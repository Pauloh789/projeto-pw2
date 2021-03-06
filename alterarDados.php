<?php
    session_start();

    $verificaUsuarioLogado = $_SESSION['verificaUsuarioLogado'];

    if(!$verificaUsuarioLogado){
        header("Location: index.php?codMsg=003");
    } else {
        $nomeUsuarioLogado = $_SESSION['nomeUsuarioLogado'];
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Cadastro de Usuarios </title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script src="js/messages_pt_PT.js"></script>
    <script src="js/pwstrength-bootstrap.js"></script>
    <style>
        html {
            height: 100%;
        }

        body {
            background: url('img/dark-blue-background.jpg') no-repeat center fixed;
            background-size: cover;
            height: 100%;
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a href="main.html" class="navbar-brand">
                <img src="img/icone.svg" widht="30" height="30" alt="Agenda de contatos" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="menuCadastros"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi-card-list"></i> Cadastros</a>
                        <div class="dropdown-menu" aria-labelledby="menuCadastros">
                            <a class="dropdown-item" href="cadastroContato.html">
                                <i class="bi-person-fill"></i> Novo contato</a>
                            <a class="dropdown-item" href="listaContatos.html">
                                <i class="bi-list-ul"></i> Lista de contatos</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="menuConta" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bi-gear-fill"></i> Minha conta</a>
                        <div class="dropdown-menu" aria-labelledby="menuConta">
                            <a class="dropdown-item" href="alterarDados.html">
                                <i class="bi-pencil-square"></i> Alterar dados</a>
                            <a class="dropdown-item" href="logout.php">
                                <i class="bi-door-open-fill"></i> Sair</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="modal" data-target="#modalSobreAplicacao">
                            <i class="bi-info-circle"></i> Sobre</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0" method="get" action="listaContatos.html">
                    <input class="form-control mr-sm-2" type="search" name="busca" placeholder="Pesquisar">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Pesquisar</button>
                </form>
                <span class="navbar-text ml-4">
                        Ol?? <b><?= $nomeUsuarioLogado ?><b>, seja bem-vindo(a)!
                </span>
            </div>
        </div>
    </nav>
    <div class="row h-100 align-items-center pt-5">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <div class="card border-primary my-5">
                        <div class="card-header bg-primary text-white">
                            <h5> Alterar dados</h5>
                        </div>
                        <div class="card-body">
                            <form id="novoUsuario" method="post" action="main.html">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="nomeUsuario">Nome</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-people-fill"></i></div>
                                                </div>
                                                <input id="nomeUsuario" type="text" size="60" class="form-control"
                                                    name="nomeUsuario" placeholder="Digite o seu nome" value=""
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="mailUsuario">E-mail</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-at"></i></div>
                                                </div>
                                                <input id="mailUsuario" type="email" size="60" class="form-control"
                                                    name="mailUsuario" placeholder="Digite o seu e-mail" value=""
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="mail2Usuario">Repita seu e-mail</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-at"></i></div>
                                                </div>
                                                <input id="mail2Usuario" type="email" class="form-control"
                                                    name="mail2Usuario" placeholder="Repita o seu e-mail" value=""
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="senhaAtualUsuario">Senha atual</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-key-fill"></i></div>
                                                </div>
                                                <input id="senhaAtualUsuario" type="password" class="form-control"
                                                    name="senhaAtualUsuario" placeholder="Digite sua senha atual" value=""
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="senhaUsuario">Nova senha</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-key-fill"></i></div>
                                                </div>
                                                <input id="senhaUsuario" type="password" class="form-control"
                                                    name="senhaUsuario" placeholder="Digite sua nova senha" value=""
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="senha2Usuario">Repita sua nova senha</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-key-fill"></i></div>
                                                </div>
                                                <input id="senha2Usuario" type="password" class="form-control"
                                                    name="senha2Usuario" placeholder="Repita a sua nova senha" value=""
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="campo_senha">
                                    <div class="col-sm barra-senha"></div>
                                    <div class="col-sm"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm text-right">
                                        <button class="btn btn-primary" type="submit">Salvar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalSobreAplicacao" tabindex="-1" role="dialog" aria-labelledby="sobreAplicacao"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sobreAplicacao">Sobre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="img/logo.jpg">
                    <hr>
                    <p>Agenda de contatos</p>
                    <p>Vers??o 1.0</p>
                    <p>Todos os direitos reservados &copy; 2022</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    jQuery.validator.setDefaults({
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    $(document).ready(() => {
        $("#novoUsuario").validate({
            rules: {
                //defini????o de regras utilizando ids
                mailUsuario: {
                    minlength: 5
                },
                mail2Usuario: {
                    equalTo: "#mailUsuario"
                },
                senha2Usuario: {
                    equalTo: "#senhaUsuario"
                },
                senhaUsuario: {
                    minlength: 10
                }
            }
        });
    });

    $(document).ready(() => {
        var options = {};
        options.ui = {
            container: "#campo_senha",
            viewports: {
                progress: ".barra-senha"
            },
            showVerdictsInsideProgressBar: true
        };

        $('#senhaUsuario').pwstrength(options);
    });
</script>

</html>