<?php

require_once __DIR__ . '/../classe/Usuario.php';

$id = $_GET['id'];

$usuario =  new Usuario();


if($usuario->excluir($id)){
    header("location: ../");
}else{
    header("location: ../");
}