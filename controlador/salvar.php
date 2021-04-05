<?php

require_once __DIR__ . '/../classe/Usuario.php';

if ($_POST['nome'] != '' &&  $_POST['celular'] != '' && $_POST['cidade'] != '') {
    $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
    $celular = filter_input(INPUT_POST, "celular", FILTER_SANITIZE_SPECIAL_CHARS);
    $cidade = filter_input(INPUT_POST, "cidade", FILTER_SANITIZE_SPECIAL_CHARS);
    $pai_empresarial = filter_input(INPUT_POST, "pai_empresarial", FILTER_SANITIZE_SPECIAL_CHARS);

    $usuario = new Usuario();

    $usuario->__set('nome', $nome);
    $usuario->__set('celular', $celular);
    $usuario->__set('pai_empresarial', $pai_empresarial);
    $usuario->__set('id_cidade', $cidade);


    if ($usuario->cadastrar()) {
        session_start();
        $_SESSION['sucesso'] = '<div class="alert alert-success" role="alert">Cadastro realizado com sucesso </div>';
        header("location: ../");
    } else {
        header("location: ../");
    }
} else {
    session_start();

    $_SESSION['ErrorCadastroEmpresario'] = '<div class="alert alert-danger" role="alert">Campos Obrigatórios Não Foram Preenchidos(Nome Completo, Celular ou Estado/Cidade) </div>';
    header("location: ../");
}
