# FAP - Contador de Páginas

Projeto PHP para contagem automática de páginas em arquivos ZIP contendo documentos de clientes. Idealizado para uso com os serviços dos Correios (Multiplex e Inserção), o sistema lê arquivos ZIP, valida matrizes em banco, conta objetos e páginas de PDF e gera relatórios de saída.

## 🔍 Principais funcionalidades

- Extração de arquivos ZIP e processamento de conteúdo
- Contagem de objetos em arquivos TXT e XML
- Leitura de páginas de PDF usando `smalot/pdfparser`
- Validação de matrizes (inserção/multiplex) contra um banco de dados MySQL
- Geração de arquivos de saída (TXT/Excel) com totais
- Interface web leve para acionamento dos processamentos
- API RESTful básica usando PSR-7/PSR-15 com Nyholm PSR-7
- Autoload baseado em PSR-4 e gerenciamento de dependências via Composer

## 🏗 Arquitetura e boas práticas

- **Namespaces e autoload PSR-4** (arquivo customizado `autoload.php` adaptado)
- **PSR-7/PSR-15** para controllers e manipulação de requisições/respostas
- **Injeção de dependência** com [PHP-DI](http://php-di.org) configurada em `config/dependencies.php`
- **Separação de responsabilidades** em camadas (`Controller`, `Contador`, `Cadastrar`, `Helper`, `Conectar`)
- Uso de **interfaces** e **traits** para facilitar extensão e teste
- **Tratamento básico de exceções** em pontos críticos (PDO, leitura de arquivos)
- Estrutura organizada (`public/`, `src/`, `views/`, `config/`, `test/`, `vendor/`)
- `composer.json` para dependências e autoload

## 🛠️ Requisitos

- PHP 8.0+ com PDO e extensões Zip e XML
- MySQL (ou outro banco com PDO compatível)
- Composer para instalação de dependências

## 🚀 Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/<seu-usuario>/FAP.git
   cd FAP
   ```
2. Instale dependências:
   ```bash
   composer install
   ```
3. Ajuste credenciais do banco em `src/Conectar/ConectarBD.php`
4. Publique os arquivos ou execute via PHP built-in server:
   ```bash
   php -S localhost:8000 -t public
   ```
5. Acesse `http://localhost:8000` no navegador.

## 🧪 Testes

Scripts de teste simples estão na pasta `test/`. Para um ambiente mais robusto, recomenda-se adicionar PHPUnit e escrever testes automatizados.

## 📁 Estrutura de pastas

```
public/            # Front controller e assets
src/               # Código fonte (controllers, serviços, etc.)
config/            # Rotas e definições de DI
views/             # Templates HTML
test/              # Scripts de teste
vendor/            # Dependências Composer
```

## 📦 Dependências principais

- php-di/php-di
- nyholm/psr7
- smalot/pdfparser
- league/plates (template engine)

## 💡 Observações

O projeto foi desenvolvido seguindo padrões de organização e modularidade, facilitando manutenção e evolução. Apesar de ainda contar com folgas e melhorias possíveis (testes automatizados, logging, padronização PSR-12), já oferece uma base sólida para um ambiente de trabalho corporativo.

Contribuições são bem-vindas! Sinta-se à vontade para abrir pull requests ou issues no GitHub.

---

*Desenvolvido por equipe FAP*
