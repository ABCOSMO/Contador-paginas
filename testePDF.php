<?php
// extrair_folha_pagamento.php
require 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

/**
 * Extrai dados de folha de pagamento de PDF
 * @param string $pdf_file_path Caminho para o arquivo PDF
 * @return array Array com os dados extraídos ou array de erro
 */
function extrairFolhaPagamento($pdf_file_path) {
    // Validar arquivo
    if (!file_exists($pdf_file_path)) {
        return ['erro' => 'Arquivo não encontrado: ' . $pdf_file_path];
    }

    try {
        // Extrair texto do PDF
        $parser = new Parser();
        $pdf = $parser->parseFile($pdf_file_path);
        $texto_pdf = $pdf->getText();

        // Processar linhas
        $linhas = explode("\n", $texto_pdf);
        $dados_finais = [];
        $matricula_atual = $nome_atual = $categ_atual = '';
        $ultimo_funcionario_valido = ['matricula' => '', 'nome' => '', 'categoria' => ''];

        foreach ($linhas as $linha) {
            $linha = trim($linha);
            if (empty($linha)) continue;
            
            // Parar no Resumo Geral
            if (preg_match('/^(Resumo Geral|RESUMO GERAL|Resumo|RESUMO)/i', $linha)) {
                break;
            }
            
            // Linha com matrícula (novo funcionário)
            if (preg_match('/^(\d{4})\s+([A-Z][A-Z\s]{10,}?)\s+([HM])\s+(\d{2,3})\s+([A-Z].*?)\s+(\d{1,3}:\d{2})\s+([\d,]+)$/', $linha, $match)) {
                $matricula_atual = trim($match[1]);
                $nome_atual = trim($match[2]);
                $categ_atual = trim($match[3]);
                
                $ultimo_funcionario_valido = [
                    'matricula' => $matricula_atual,
                    'nome' => $nome_atual,
                    'categoria' => $categ_atual
                ];
                
                $dados_finais[] = [
                    'Matricula' => $matricula_atual,
                    'Nome' => $nome_atual,
                    'Categ_Evento' => $categ_atual,
                    'Evento_Cod' => trim($match[4]),
                    'Descricao' => trim($match[5]),
                    'Referencia' => trim($match[6]),
                    'Valor' => str_replace(',', '.', trim($match[7]))
                ];
            }
            // Linha de evento adicional
            elseif (preg_match('/^(\d{2,3})\s+([A-Z].*?)\s+(\d{1,3}:\d{2})\s+([\d,]+)$/', $linha, $match)) {
                if ($ultimo_funcionario_valido['matricula'] !== '') {
                    if (!preg_match('/[HM]\s+\d/', $linha)) {
                        $dados_finais[] = [
                            'Matricula' => $ultimo_funcionario_valido['matricula'],
                            'Nome' => $ultimo_funcionario_valido['nome'],
                            'Categ_Evento' => $ultimo_funcionario_valido['categoria'],
                            'Evento_Cod' => trim($match[1]),
                            'Descricao' => trim($match[2]),
                            'Referencia' => trim($match[3]),
                            'Valor' => str_replace(',', '.', trim($match[4]))
                        ];
                        
                        $matricula_atual = $ultimo_funcionario_valido['matricula'];
                        $nome_atual = $ultimo_funcionario_valido['nome'];
                        $categ_atual = $ultimo_funcionario_valido['categoria'];
                    }
                }
            }
            // Ignorar linhas de controle
            elseif (preg_match('/^(Página|Pagina|Page)\s*\d+/i', $linha) || 
                    preg_match('/^Transferência para Folha/i', $linha) ||
                    preg_match('/^Período:/i', $linha) ||
                    preg_match('/^Filial:/i', $linha)) {
                continue;
            }
            // Resetar em cabeçalho de tabela
            elseif (preg_match('/^(Matrícula|Nome|Categ|Evento|Referência|Valor)/i', $linha) && 
                     preg_match('/\|\s*\d/', $linha)) {
                $matricula_atual = $nome_atual = $categ_atual = '';
                $ultimo_funcionario_valido = ['matricula' => '', 'nome' => '', 'categoria' => ''];
            }
        }

        // Remover duplicatas e retornar
        $dados_finais = array_map("unserialize", array_unique(array_map("serialize", $dados_finais)));
        return $dados_finais;

    } catch (Exception $e) {
        return ['erro' => 'Erro ao processar PDF: ' . $e->getMessage()];
    }
}

/**
 * Salva dados no banco de dados
 * @param array $dados Dados extraídos
 * @param PDO $pdo Conexão PDO
 * @return bool Sucesso da operação
 */
function salvarNoBanco($dados, $pdo) {
    try {
        $pdo->beginTransaction();
        
        $sql = "INSERT INTO folha_pagamento 
                (matricula, nome, categoria, evento_cod, descricao, referencia, valor, data_processamento) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $pdo->prepare($sql);
        
        foreach ($dados as $registro) {
            // Pular registros de erro
            if (isset($registro['erro'])) continue;
            
            $stmt->execute([
                $registro['Matricula'],
                $registro['Nome'],
                $registro['Categ_Evento'],
                $registro['Evento_Cod'],
                $registro['Descricao'],
                $registro['Referencia'],
                $registro['Valor']
            ]);
        }
        
        $pdo->commit();
        return true;
        
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Erro ao salvar no banco: " . $e->getMessage());
        return false;
    }
}

/**
 * Gera relatório estatístico
 * @param array $dados Dados extraídos
 * @return array Estatísticas
 */
function gerarEstatisticas($dados) {
    if (isset($dados['erro'])) return $dados;
    
    $estatisticas = [
        'total_registros' => count($dados),
        'total_funcionarios' => count(array_unique(array_column($dados, 'Matricula'))),
        'total_eventos' => count(array_unique(array_column($dados, 'Evento_Cod'))),
        'eventos_por_tipo' => array_count_values(array_column($dados, 'Evento_Cod')),
        'categorias' => array_count_values(array_column($dados, 'Categ_Evento'))
    ];
    
    return $estatisticas;
}

// --- EXECUÇÃO PRINCIPAL ---
if (php_sapi_name() === 'cli') {
    // Modo linha de comando
    $arquivo_pdf = $argv[1] ?? 'Folha.pdf';
    $dados = extrairFolhaPagamento($arquivo_pdf);
    
    if (isset($dados['erro'])) {
        echo "ERRO: " . $dados['erro'] . "\n";
        exit(1);
    }
    
    echo json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
} else {
    // Modo web
    header('Content-Type: application/json; charset=utf-8');
    
    $arquivo_pdf = $_GET['arquivo'] ?? 'Folha.pdf';
    $acao = $_GET['acao'] ?? 'extrair';
    
    $dados = extrairFolhaPagamento($arquivo_pdf);
    
    if ($acao === 'estatisticas') {
        $resultado = gerarEstatisticas($dados);
    } else {
        $resultado = $dados;
    }
    
    echo json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>