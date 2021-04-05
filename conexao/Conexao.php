<?php

class Conexao
{

    protected $db;

    private const OPTIONS = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    public function __construct()
    {
        try {
            $this->db = new PDO("mysql:dbname=ponteon;host=localhost;charset=utf8", "root", "", self::OPTIONS);
    
        } catch (PDOException $e) {
            echo "Erro ao se conectar ao banco".$e->getMessage();
        }
    }
}
