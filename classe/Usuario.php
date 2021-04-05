<?php

require_once __DIR__ . '/../conexao/Conexao.php';

class Usuario extends Conexao
{
    private $nome;
    private $celular;
    private $pai_empresarial;
    private $id_cidade;

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function cadastrar()
    {
        $sql = "SELECT nome from usuario WHERE celular = :celular";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":celular", $this->celular);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            session_start();
            $_SESSION['errorCelular'] = '<div class="alert alert-danger" role="alert">
           O Número de celular digitado já foi cadastrado
         </div>';
            return false;
        } else {
            $sql = "INSERT INTO usuario(nome, celular, pai_empresarial,id_cidade) VALUES(:nome, :celular, :pai_empresarial, :id_cidade)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":nome", $this->nome);
            $stmt->bindValue(":celular", $this->celular);
            $stmt->bindValue(":pai_empresarial", $this->pai_empresarial);
            $stmt->bindValue(":id_cidade", $this->id_cidade);
            $stmt->execute();
            return true;
        }
    }

    public function buscarEmpresarios()
    {
        $sql =  "SELECT nome from usuario";
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array();
        }
    }

    public function buscarEstados()
    {
        $sql = "SELECT * FROM estado ORDER BY nome ASC";
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array();
        }
    }

    public function buscarCidadePorId($id)
    {
        $sql = "SELECT * FROM cidade where id_estado = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array();
        }
    }

    public function dadosTabela($id)
    {
        /*$sql = "SELECT usuario.id,usuario.nome,usuario.celular,usuario.pai_empresarial, usuario.criado_em, cidade.nome AS nome_cidade, estado.uf FROM usuario 
        INNER JOIN cidade ON usuario.id_cidade = cidade.id 
        INNER JOIN estado ON estado.id = cidade.id_estado 
        WHERE usuario.id = :id";*/

        $sql = "SELECT cidade.nome AS nome_cidade, estado.uf FROM usuario 
                INNER JOIN cidade ON usuario.id_cidade = cidade.id 
                INNER JOIN estado ON estado.id = cidade.id_estado 
                WHERE usuario.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return array();
        }
    }

    public function listar()
    {
        $sql = "SELECT id, nome, celular, pai_empresarial, criado_em FROM usuario ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array();
        }
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM usuario WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
