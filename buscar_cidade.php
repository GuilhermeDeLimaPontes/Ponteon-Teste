<?php
    require_once __DIR__ . '/classe/Usuario.php';

    $usuario = new Usuario();
    $dados1 = $usuario->buscarCidadePorId($_POST["id"]);

    foreach ($dados1 as $cidades) {
        echo '<option value="'.$cidades['id'].'">'.$cidades['nome'].'</option>';
    }
?>