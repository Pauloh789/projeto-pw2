<?php
    include "conectaBanco.php"
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
    <script src="js/jquery-3-3-1.js"></script>
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
    <div class="row h-100 align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm-10">
                    <?php
                        $flagErro = False;
                        if (isset($_POST['acao'])){
                            $acao = $_POST['acao'];

                            if ($acao == "salvar"){
                                $nomeUsuario = $_POST['nomeUsuario'];
                                $mailUsuario = $_POST['mailUsuario'];
                                $mail2Usuario = $_POST['mail2Usuario'];
                                $senhaUsuario = $_POST['senhaUsuario'];
                                $senha2Usuario = $_POST['senha2Usuario'];

                                if(!empty($nomeUsuario) && !empty($mailUsuario) && !empty($mail2Usuario) && !empty($senhaUsuario) && !empty($senha2Usuario) && !empty($nomeUsuario)){
                                    if ($mailUsuario == $mail2Usuario && $senhaUsuario == $senha2Usuario) {
                                        
                                        if (strlen($nomeUsuario) >= 5 && strlen(strlen($senhaUsuario) >= 8)) {
                                            $sqlUsuarios = "SELECT codigoUsuario from usuarios where mailUsuario = :mailUsuario";
                                            $sqlUsuariosST = $conexao->prepare($sqlUsuarios);
                                            $sqlUsuariosST->bindValue(":mailUsuario", $mailUsuario);
                                            $sqlUsuariosST->execute();
                                            $quantidadeUsuarios = $sqlUsuariosST->rowcount();
                                            //row count retorna a quantidade de usuarios na row    

                                            if ($quantidadeUsuarios == 0 ){

                                                $senhaUsuarioMD5 = md5($senhaUsuario);
        
                                                $sqlNovoUsuario = "INSERT INTO usuarios (nomeUsuario, mailUsuario, senhaUsuario) Values 
                                                (:nomeUsuario, :mailUsuario, :senhaUsuario)";/*o : marca os valores para serem substituidos pela prep string*/
                                                
                                                $sqlNovoUsuarioST =  $conexao->prepare($sqlNovoUsuario);/*prepara para não haver ataques de sql injection*/
                                                $sqlNovoUsuarioST->bindValue(':nomeUsuario',$nomeUsuario);
                                                $sqlNovoUsuarioST->bindValue(':mailUsuario',$mailUsuario);
                                                $sqlNovoUsuarioST->bindValue(':senhaUsuario',$senhaUsuarioMD5);
        
                                                if ($sqlNovoUsuarioST->execute()){
                                                    $mensagemAcao = "Novo usuario cadastrado com sucesso!";
                                                }else{
                                                    $flagErro = True;
                                                    $mensagemAcao = "Código erro: " . $sqlNovoUsuarioST->errorCode();
                                                }
                                            }else{  
                                                $flagErro = True;
                                                $mensagemAcao = "Este Email já foi utilizado por outro usuário.";
                                            }
                                        }
                                        else {
                                            $flagErro = True;
                                            $mensagemAcao = "Informe a quantidade mínima de caracteres para cada campo: nome(5), senha(8).";
                                        }
                                    }
                                    else {
                                        $flagErro = True;
                                        $mensagemAcao = "Os campos de confirmação de email e senha devem ser preenchidos 
                                                        com os seus respectivos valores.";
                                    }
                                    
                                }else{
                                    $flagErro = True;
                                    $classeMensagem = "Preencha todos os campos obrigatórios (*)";

                                }

                                if (!$flagErro){
                                    $classeMensagem = "alert-success";
                                }else{
                                    $classeMensagem = "alert-danger";
                                }

                                echo "<div class=\"alert $classeMensagem alert-dismissible fade show\" role=\"alert\">
                                        $mensagemAcao
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                        <span aria-hidden=\"true\">&times;</span>
                                        </button>
                                    </div>";
                            }
                        }
                    ?>
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5> Cadastro de novo usuario</h5>
                        </div>
                        <div class="card-body">
                            <form id="novoUsuario" method="post" action="novoUsuario.php">
                                <input type="hidden" name="acao" value="salvar">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="nomeUsuario">Nome*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-people-fill"></i></div>
                                                </div>
                                                <input id="nomeUsuario" type="text" size="60" class="form-control"
                                                    name="nomeUsuario" placeholder="Digite o seu nome" value="<?= ($flagErro) ? $nomeUsuario : '' ?>"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="mailUsuario">E-mail*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-at"></i></div>
                                                </div>
                                                <input id="mailUsuario" type="email" size="60" class="form-control"
                                                    name="mailUsuario" placeholder="Digite o seu e-mail" value="<?= ($flagErro) ? $mailUsuario : '' ?>"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="mail2Usuario">Repita seu e-mail*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-at"></i></div>
                                                </div>
                                                <input id="mail2Usuario" type="email" class="form-control"
                                                    name="mail2Usuario" placeholder="Repita o seu e-mail" value="<?= ($flagErro) ? $mail2Usuario : '' ?>"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="senhaUsuario">Senha*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-key-fill"></i></div>
                                                </div>
                                                <input id="senhaUsuario" type="password" class="form-control"
                                                    name="senhaUsuario" placeholder="Digite sua senha" value="<?= ($flagErro) ? $senhaUsuario : '' ?>"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="senha2Usuario">Repita sua senha*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-key-fill"></i></div>
                                                </div>
                                                <input id="senha2Usuario" type="password" class="form-control"
                                                    name="senha2Usuario" placeholder="Repita a sua senha" value="<?= ($flagErro) ? $senha2Usuario : '' ?>"
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
                                        <button class="btn btn-primary" type="submit">Cadastrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm"></div>
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
                //definição de regras utilizando ids
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