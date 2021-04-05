<!doctype html>
<html lang="pt-br">
<?php
require_once __DIR__ . '/classe/Usuario.php';
$usuario = new Usuario();
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>

    <title>Teste Ponteon</title>
</head>

<body>
    <div class="container">
        <h1>Cadastro de Empresários</h1>
        <?php
        session_start();
        if (isset($_SESSION['errorCelular'])) {
            echo $_SESSION['errorCelular'];
            unset($_SESSION['errorCelular']);
        } else if (isset($_SESSION['sucesso'])) {
            echo $_SESSION['sucesso'];
            unset($_SESSION['sucesso']);
        } else if (isset($_SESSION['ErrorCadastroEmpresario'])) {
            echo $_SESSION['ErrorCadastroEmpresario'];
            unset($_SESSION['ErrorCadastroEmpresario']);
        }
        ?>
        <form action="controlador/salvar.php" method="POST">
            <div class="row">
                <div class="col-md-3">
                    <label for="Nome Completo">Nome Completo</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label for="Celular">Celular</label>
                    <input type="text" id="celular" name="celular" class="form-control" required>
                </div>
                <?php
                $estados = $usuario->buscarEstados();
                ?>
                <div class="col-md-2">
                    <label for="inputState">Estado</label>
                    <select id="estados" name="estados" class="form-control" required>
                        <option>Escolha...</option>
                        <?php for ($i = 0; $i < count($estados); $i++) { ?>
                            <option value='<?= $estados[$i]["id"] ?>'> <?= $estados[$i]["nome"] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="cidades">Cidade</label>
                    <select id="cidades" name="cidade" class="form-control" required>

                    </select>
                </div>
                <?php
                $dados = $usuario->buscarEmpresarios();
                ?>
                <div class="col-md-3">
                    <label for="inputBussiness">Pai Empresarial</label>
                    <select id="pai_empresarial" name="pai_empresarial" class="form-control">
                        <option value="-">Nenhum</option>
                        <?php for ($i = 0; $i < count($dados); $i++) { ?>
                            <option value='<?= $dados[$i]["nome"] ?>'><?= $dados[$i]["nome"] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-success mt-3">Salvar</button>
        </form>
    </div>
    <?php
    $listar = $usuario->listar();
    ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th scope="col">Nome Completo</th>
                            <th scope="col">Celular</th>
                            <th scope="col">Cidade/UF</th>
                            <th scope="col">Cadastrado Em</th>
                            <th scope="col">Pai Empresarial</th>
                            <th scope="col">Rede</th>
                            <th scope="col">-</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($listar); $i++) { ?>
                            <tr>
                                <?php $cidadeEstado = $usuario->dadosTabela($listar["$i"]["id"]) ?>
                                <?php $data = new DateTime($listar["$i"]["criado_em"]); ?>
                                <td><?= $listar["$i"]["nome"] ?></td>
                                <td><?= $listar["$i"]["celular"] ?></td>
                                <td><?= $cidadeEstado["nome_cidade"] . '/' . $cidadeEstado["uf"] ?></td>
                                <td><?= $data->format("d/m/Y H:i") ?></td>
                                <td><?= $listar["$i"]["pai_empresarial"] ?></td>
                                <td><a href="">[VER REDE]</a></td>
                                <td><a href='controlador/excluir.php?id=<?= $listar["$i"]["id"] ?>' onclick="return confirm('Tem certeza que deseja remover o registro?')">[EXCLUIR]</a></td>
                            </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $("#estados").on("change", function() {
            var idEstado = $("#estados").val();
            $.ajax({
                url: 'http://localhost/ponteonteste/buscar_cidade.php',
                type: 'POST',
                data: {
                    id: idEstado
                },
                beforeSend: function() {
                    $("#cidades").html("Aguarde...");
                },
                success: function(data) {
                    $("#cidades").html(data);
                },
                error: function(data) {
                    $("#cidades").html("Ocorreu um erro ao carregar");
                },
            });
        });

        $(document).ready(function() {
            $('#celular').mask('(00)00000-0000');
        });
    </script>
</body>

</html>