<?php

namespace Correios\ContadorDePaginas\Conectar;
use PDO;
use PDOException;

	//class conecta extends PDO{
        class ConectarBD
        {
           private static $conexao = null;
           protected $host = '127.0.0.1';
           protected $senha = '';
           protected $usuario = 'root';
           protected $bancoDados = 'fap';
    
            //CONSTRUTOR
            private function __construct()
            {

            }//CONSTRUTOR
    
            //CONEXÃO
            public static function getConexao()
            {
                
                if (self::$conexao === null) {
                    try {
                        $instance = new static();
                        $dsn = "mysql:dbname=" . $instance->bancoDados . "; host=" . $instance->host . ";charset=utf8";
                        $user = $instance->usuario;
                        $password = $instance->senha;

                        self::$conexao = new PDO($dsn, $user, $password);
                        self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch (PDOException $e) {
                        erro_log('Erro de Conexão PDO: ' . $e->getMessage(), 0);
                        die('Não foi possível conectar ao banco de dados. Por favor, tente novamente mais tarde.');
                    }
                }
                return self::$conexao;
            }
    
            
            protected function executarSQL($sql, array $array = [])
            {                
                try {
                    $pdo = $this->conexaoDB->prepare($sql);
    
                    $pdo->execute($array);
                   
                    return $pdo;
    
                } catch (PDOException  $e) {
                erro_log('Erro ao executar SQL: ' . $e->getMessage(), 0);
                return false;
                }
            }

            //executa instruções sql pelo PDO
            protected function beginTransaction()
            {
                return self::getConexao()->beginTransaction();
            }
    
            protected function commitSQL()
            {
                return self::getConexao()->commit();
            }
    
            protected function rollbackSQL()
            {
                return self::getConexao()->rollBack();
            }
    
            protected function lastidSQL()
            {
                return (int) self::getConexao()->lastInsertId();
            }
    
    
    
        }//ABSTRACT CLASS CONECTA - PDO
    
    ?>