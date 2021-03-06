<?php
    session_start();

    $verificaUsuarioLogado = $_SESSION['verificaUsuarioLogado'];

    if(!$verificaUsuarioLogado){
        header("Location: index.php?codMsg=003");
    } else {
        include "conectaBanco.php";

        $nomeUsuarioLogado = $_SESSION['nomeUsuarioLogado'];
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Agenda de contatos </title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-icons.css">
    <script src="js/jquery-3-3-1.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script src="js/messages_pt_PT.js"></script>
    <script src="js/pwstrength-bootstrap.js"></script>
    <script src="js/dateITA.js"></script>
    <script src="js/jquery.mask.js"></script>
    <style>
        html {

            height: 100%;
        }

        body {

            background: url('img/dark-blue-background.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100%;
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top">
        <div class="container">
            <a href="/main.php" class="navbar-brand"><img src="img/icone.svg" width="30" height="30"
                    alt="agenda de contatos"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar"> <span
                    class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" id="menuCadastros">
                            <i class="bi-card-list"></i> Cadastros
                        </a>
                        <div class="dropdown-menu" aria-labelledby="menuCadastros">
                            <a class="dropdown-item" href="cadastroContato.php">
                                <i class="bi-person-fill"></i> Novo Contato
                            </a>
                            <a class="dropdown-item" href="listaContatos.php">
                                <i class="bi-list-ul"></i> Lista de contatos
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" id="menuConta">
                            <i class="bi-gear-fill"></i> Minha Conta
                        </a>
                        <div class="dropdown-menu" aria-labelledby="menuConta">
                            <a class="dropdown-item" href="alterarDados.php">
                                <i class="bi-pencil-square"></i> Alterar dados
                            </a>
                            <a class="dropdown-item" href="logout.php">
                                <i class="bi-door-open-fill"></i> Sair
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="" data-toggle="modal" data-target="#modalSobreAplicacao">
                            <i class="bi-info-circle"></i> Sobre
                        </a>
                    </li>
                </ul>
                <form action="listaContatos.php" class="form-inline my-2 my-lg-0" method="get">
                    <input class="form-control mr-sm-2" type="search" name="busca" id="busca" placeholder="Pesquisar">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Buscar</button>
                </form>
                <span class="navbar-text ml-4">
                        Ol?? <b><?= $nomeUsuarioLogado ?><b>, seja bem-vindo(a)!
                </span>
            </div>
        </div>
    </nav>

    <!--
            Cadastro
        -->
    <div class="row h-100 align-items-center">
        <div class="container my-5">
            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm-10">
                    <?php
                        $flagErro = False;
                        $flagSucesso = False;
                        $mostrarMensagem = False;
                        
                        $dadosContato = array('codigoContato','nomeContato','nascimentoContato','sexoContato','mailContato','fotoContato','fotoAtualContato',
                        'telefone1Contato','telefone2Contato','telefone3Contato','telefone4Contato','logradouroContato','complementoContato','bairroContato',
                        'estadoContato','cidadeContato');

                        foreach($dadosContato as $campo){
                            $$campo = '';
                        }

                        $$campo;

                        

                        if (isset($_POST['codigoContato'])){// FORM submetido
                            $codigoContato = $_POST['codigoContato'];

                            $codigoContato = $_POST['codigoContato'];
                            $nomeContato  = addslashes($_POST['nomeContato']);
                            $nascimentoContato = $_POST['nascimentoContato'];

                            if(isset($sexoContato)){
                                $sexoContato = $_POST['sexoContato'];

                            }else{
                                $sexoContato = "";
                            }

                            $mailContato = $_POST['mailContato'];


                            $fotoContato = $_POST['fotoContato'];

                            $fotoAtualContato = $_FILES['fotoAtualContato'];
                            $telefone1Contato = $_POST['telefone1Contato'];
                            $telefone2Contato = $_POST['telefone2Contato'];
                            $telefone3Contato = $_POST['telefone3Contato'];
                            $telefone4Contato = $_POST['telefone4Contato'];
                            $logradouroContato = addslashes($_POST['logradouroContato']);
                            $complementoContato = addslashes($_POST['complementoContato']);
                            $bairroContato = addslashes($_POST['bairroContato']);
                            $estadoContato = $_POST['estadoContato'];
                            $cidadeContato = $_POST['cidadeContato'];

                            $telefonesContato = array($telefone1Contato, $telefone2Contato, $telefone3Contato, $telefone4Contato);
                            $telefonesFiltradosContato = array_filter($telefonesContato);
                            $telefonesValidadosContato =  preg_grep('/^\(\d{2}\)\s\d{4,5}\-\d{4}$/', $telefonesContato); 

                            if($telefonesFiltradosContato === $telefonesValidadosContato){
                                $erroTelefones = False;
                            }else {
                                $erroTelefones = True;
                            }


                            if(empty($nomeContato) || empty($sexoContato) || empty($mailContato) || empty($telefone1Contato) || empty($logradouroContato) || empty($complementoContato) || empty($bairroContato) || empty($cidadeContato) || empty($estadoContato) ){
                                $flagErro = True;
                                $mensagemAcao = 'Preencha todos os campos obrigat??rios (*).';
                            }else if(strlen($nomeContato )< 5){
                                $flagErro = True;
                                $mensagemAcao = 'Informe a quantidade m??nima de caracteres para cada campo: Nome(5)';
                            }else if(preg_match('/^(0?[1-9]|[1,2][0-9]|3[0,1])[\/](0?[1-9]|1[0,1,2])[\/]\d{4$}/', $nascimentoContato)){//valida????o da data de nascimento
                                $flagErro = True;
                                $mensagemAcao = 'A data de nascimento do contato deve ser no formato dia, m??s e ano.';
                            }else if($fotoContato['error'] != 4){//valida????o da foto
                                if(!in_array($fotoContato['type'] , array('image/jpg','image/jpeg','image/png' || $fotoContato['size'] > 2000000))){
                                    $flagErro = True;
                                    $mensagemAcao = 'A foto do contato deve ser nos formatos jpg, jpeg ou png e ter no m??ximo 2MB.';
                                }

                            }else if($erroTelefones){//valida????o telefone
                                $flagErro == True;
                                $mensagemAcao = 'Os campos de telefone devem ser do formato (xx) xxxxx-xxxx.';
                                //preg_match('/^\(\d{2}\)\s\d{4,5}\-\d{4}$/' ,$telefone1Contato)
                            }



                            if(!$flagErro){
                                if (empty($codigoContato)){//inclusao de contato
                                    
                                    // bloco faltando ( video dos outros meninos)

                                }else{//edi????o de contato existente
                                    $sqlContato = "UPDATE contatos SET nomeContato=:nomeContato, nascimentoContato=:nascimentoContato,
                                                   sexoContato=:sexoContato, mailContato=:mailContato, fotoContato=:fotoContato,
                                                   telefone1Contato=:telefone1Contato, telefone2Contato=:telefone2Contato,
                                                   telefone3Contato=:telefone3Contato, telefone4Contato=:telefone4Contato,
                                                   logradouroContato=:logradouroContato, complementoContato=:complementoContato,
                                                   bairroContato=:bairroContato, cidadeContato=:cidadeContato,
                                                   codigoUsuario=:codigoUsuario";

                                    $sqlContatoST = $conexao->prepare($sqlContato);

                                    $sqlContatoST->bindValue(':codigoContato', $codigoContato);
                                    $sqlContatoST->bindValue(':codigoUsuario', $codigoUsuario);
                                    $sqlContatoST->bindValue(':nomeContato', $nomeContato);

                                    $nascimentoContato = formataData($nascimentoContato);
                                    $sqlContatoST->bindValue(':nascimento', $nascimentoContato);

                                    $sqlContatoST->bindValue(':sexoContato', $sexoContato);
                                    $sqlContatoST->bindValue(':mailContato', $mailContato);
                                    $sqlContatoST->bindValue(':telefone1Contato', $telefone1Contato);
                                    $sqlContatoST->bindValue(':telefone2Contato', $telefone2Contato);
                                    $sqlContatoST->bindValue(':telefone3Contato', $telefone3Contato);
                                    $sqlContatoST->bindValue(':telefone4Contato', $telefone4Contato);
                                    $sqlContatoST->bindValue(':logradouroContato', $logradouroContato);
                                    $sqlContatoST->bindValue(':complementoContato', $complementoContato);
                                    $sqlContatoST->bindValue(':bairroContato', $bairroContato);
                                    $sqlContatoST->bindValue(':cidadeContato', $cidadeContato);
                                    $sqlContatoST->bindValue(':estadoContato', $estadoContato);

                                    if ($fotoContato['error'] == 0) {
                                        $extensaoFoto = pathinfo($fotoContato['name'], PATHINFO_EXTENSION);
                                        $nomeFoto = "fotos/" . strtotime(date("Y-m-d H:i:s")) . $codigoUsuarioLogado . '.' . $extensaoFoto;

                                        if (copy($fotoContato['tmp_name'], $nomeFoto)) {
                                            $fotoEnviada = True;
                                        } else {
                                            $fotoEnviada = False;
                                        }
                                        
                                        $sqlContatoST->bindValue(':fotoContato', $nomeFoto);
                                    } else {
                                        $sqlContatoST->bindValue(':fotoContato', $fotoAtualContato);
                                        $fotoEnviada = False;
                                    }
                                    
                                    if ($sqlContatoST->execute()) {
                                        if ($fotoEnviada && !empty($fotoAtualContato)) {
                                            unlink($fotoAtualContato);
                                        }

                                        $flagSucesso = True;
                                        $mensagemAcao = "Contato editado com sucesso.";

                                        $nascimentoContato = formataData($nascimentoContato);
                                    } else {
                                        $flagErro = True;
                                        $mensagemAcao = "Erro ao editar o cadastro do contato. C??digo do erro: $sqlContatoST->errorCode().";

                                        $nascimentoContato = formataData($nascimentoContato);

                                        if ($fotoEnviada) {
                                            unlink($nomeFoto);
                                        }
                                    }
                                }
                            }
                        }else{//carregar dados formulario em branco ou contato existente
                            if(isset($_GET['codigoContato'])){// abrir contato j?? existente
                                $codigoContato = $_GET['codigoContato'];

                                $sqlContato = "SELECT * FROM contatos WHERE codigoContato=:codigoContato AND codigoUsuario=:codigoUsuario";

                                $sqlContatoST = $conexao->prepare($sqlContato);
                                $sqlContatoST->bindValue(':codigoContato', $codigoContato);
                                $sqlContatoST->bindValue(':codigoUsuario', $codigoUsuarioLogado);

                                $sqlContatoST->execute();
                                $quantidadeContatos = $sqlContatoST->rowCount();

                                if ($quantidadeContatos == 1) {
                                    $resultadoContato = $sqlContatoST->fetchALL();
                                    
                                    list($codigoContato, $codigoUsuario, $nomeContato, $nascimentoContato, $sexoContato, $mailContato,
                                    $fotoContato, $telefone1Contato, $telefone2Contato, $telefone3Contato, $telefone4Contato,
                                    $logradouroContato, $complementoContato, $bairroContato, $estadoContato, $cidadeContato)
                                    = $resultadoContato[0];

                                    $fotAtualContato = $fotoContato;

                                    $nascimentoContato = formataData($nascimentoContato);
                                } else {
                                    $flagErro = True;
                                    $mensagemAcao = "Contato n??o cadastrado.";
                                }
                            }
                            if($flagErro){
                                //mostrar msg de erro
                                $classeMensagem = 'alert-danger';
                                $mostrarMensagem = True;


                            }else if($flagSucesso){
                                //mensagem sucesso
                                $classeMensagem = 'alert-success';
                                $mostrarMensagem = True;

                            }
                            if($mostrarMensagem){
                                echo '"<div class=\"alert $classeMensagem alert-dismissible fade show\" role=\"alert\">
                                $mensagemAcao
                                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                                <span aria-hidden=\"true\">&times;</span>
                                </button>
                            </div>";';

                            }
                        }
                    
                    ?>
                    <div class="card border-primary my-5">
                        <div class="card-header bg-primary text-white">
                            <h5> Cadastro contato</h5>
                        </div>
                        <div class="card-body">
                            <div>
                                <h4 class="mb-3"><span style="color: blue;"> Dados pessoais </span></h4>
                            </div>
                            <form id="cadastroContato" method="post" enctype="multitype/form-data" action="cadastroContato.php">
                                <input type="hidden" name="codigoContato" value="<?= $codigoContato ?>">
                                <input type="hidden" name="fotoAtualContato" value="<?= $fotoAtualContato ?>">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="nomeContato">Nome*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-people-fill"></i></div>
                                                </div>
                                                <input id="nomeContato" type="text" size="60" class="form-control"
                                                    name="nomeContato" placeholder="Digite o seu nome" value="<?= $nomeContato?>"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="fotoContato" class="form-label">Foto</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="bi-people-fill"></i></div>
                                            </div>
                                            <input class="form-control" type="file" id="fotoContato" name="fotoContato" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="nascimentoContato">Data de nascimento</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi bi-calendar"></i></div>
                                                </div>
                                                <input id="nascimentoContato" type="text" class="form-control"
                                                    name="nascimentoContato" placeholder="DD/MM/AAAA" value="<?= $nascimentoContato?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label form="sexoContato">Sexo*</label>
                                            <div class="input-group">
                                                <div class="form-check form-check-inline">
                                                    <?php 
                                                        if($sexoContato == 'M'){
                                                            $checkedMasculino = 'checked';
                                                            $checkedFeminino = '';

                                                        }else if($sexoContato == 'F'){
                                                            $checkedFeminino = 'checked';
                                                            $checkedMasculino = '';

                                                        }else{
                                                            $checkedMasculino = '';
                                                            $checkedFeminino = '';
                                                        }
                                                    ?>
                                                    <input class="form-check-input" type="radio" name="sexoContato"
                                                        id="sexoMasculino" value="M"  <?= $checkedMasculino ?>>
                                                    <label class="form-check-label" for="sexoMasculino" >
                                                        Masculino
                                                    </label>
                                                    &nbsp
                                                    <input class="form-check-input" type="radio" name="sexoContato"
                                                        id="sexoFeminino" value="F" <?= $checkedFeminino ?>>
                                                    <label class="form-check-label" for="sexoFeminino">
                                                        Feminino
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mt-3">
                                            <label for="mailContato">E-mail*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-at"></i></div>
                                                </div>
                                                <input id="mailContato" type="email" class="form-control"
                                                    name="mailContato" placeholder="Digite o seu email" value="<?= $mailContato?>"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="mb-3" style="color: blue;">
                                        Telefones
                                    </h4>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="telefone1Contato">Telefone*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-phone"></i></div>
                                                </div>
                                                <input id="telefone1Contato" type="tel"
                                                    class="form-control mascara-telefone" name="telefone1Contato"
                                                    placeholder="(xx) xxxx-xxxx"  value="<?= $telefone1Contato?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="telefone2Contato">Telefone</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-phone"></i></div>
                                                </div>
                                                <input id="telefone2Contato" type="tel"
                                                    class="form-control mascara-telefone" name="telefone2Contato"
                                                    placeholder="(xx) xxxx-xxxx"  value="<?= $telefone2Contato?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="telefone3Contato">Telefone</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-phone"></i></div>
                                                </div>
                                                <input id="telefone3Contato" type="tel"
                                                    class="form-control mascara-telefone" name="telefone3Contato"
                                                    placeholder="(xx) xxxx-xxxx"  value="<?= $telefone3Contato?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="telefone4Contato">Telefone</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-phone"></i></div>
                                                </div>
                                                <input id="telefone4Contato" type="tel"
                                                    class="form-control mascara-telefone" name="telefone4Contato"
                                                    placeholder="(xx) xxxx-xxxx"  value="<?= $telefone4Contato?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="mb-3" style="color: blue;">
                                        Endere??o
                                    </h4>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label for="logradouroContato">Logradouro*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-map"></i></div>
                                                </div>
                                                <input id="logradouroContato" type="text" class="form-control"
                                                    name="logradouroContato"
                                                    placeholder="Rua, avenida, travessa e outros"  value="<?= $logradouroContato?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="complementoContato">Complemento*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-map"></i></div>
                                                </div>
                                                <input id="complementoContato" type="text" class="form-control"
                                                    name="complementoContato"
                                                    placeholder="N??mero, quadra, lote e outros"  value="<?= $complementoContato?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="bairroContato">Bairro*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-map"></i></div>
                                                </div>
                                                <input id="bairroContato" type="text" class="form-control"
                                                    name="bairroContato" placeholder="Digite o bairro"  value="<?= $bairroContato?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="estadoContato">Estado*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-globe"></i></div>
                                                </div>
                                                <select class="form-control" aria-label="Default select example"
                                                    id="estadoContato" name="estadoContato" required>
                                                    <option selected value="">Escolha o estado</option>
                                                    <?php
                                                    /*objeto com a query que sera usada */
                                                        $sqlEstados = "select codigoEstado, nomeEstado from estados";
                                                    /*query executa a string e o fetchALL retorna todos os resultados*/
                                                        $resultadosEstados =  $conexao->query($sqlEstados)->fetchAll();
                                                    /* executa um foreach sobre a lista de map que foi retornada da query e injeta no html a option*/ 
                                                        foreach ($resultadosEstados as list($codigoEstado, $nomeEstado)){
                                                            if($estadoContato == $codigoEstado){
                                                                $selected = 'selected';
                                                            }else{
                                                                $selected = '';
                                                            }
                                                            echo "<option value=\"$codigoEstado \" $selected>$nomeEstado</option>\n";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="cidadeContato">Cidade*</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="bi-globe"></i></div>
                                                </div>
                                                <select class="form-control" name="cidadeContato" id="cidadeContato"
                                                    required>
                                                    <option value="">Escolha a cidade</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
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
    <div class="modal fade" id="modalSobreAplicacao" tabindex="-1" role="dialog" aria-labelledby="sobreAplicacao"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sobreAplicacao">Sobre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="img/logo.jpg" alt="logo">
                    <hr>
                    <p>Agenda de contatos</p>
                    <p>Vers??o 1.0</p>
                    <p>Todos os direitos reservados &copy: 2021 </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        $("#cadastroContato").validate({
            rules: {
                //defini????o de regras utilizando ids
                nomeContato: {
                    minlength: 5,
                    required: true
                },
                nascimentoContato: {
                    dateITA: true
                },
                sexoContato: {
                    required: true
                }
            }
        });
        //mask campos
        $("#nascimentoContato").mask("00/00/0000");

        var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
            spOptions = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };
        //linha que aplica mascara ao telefone
        $('.mascara-telefone').mask(SPMaskBehavior, spOptions);
        //ajax
        //quando o evento mudan??a ocorrer com o id estadoContato
        $('#estadoContato').change(()=> {
            $('#cidadeContato').html('<option>Carregando...</option>');
            $('#cidadeContato').load('listaCidades.php?codigoEstado='+ $('#estadoContato').val());
        });
        <?php 
            if(!empty($estadoContato) && !empty($cidadeContato)){
                echo "$(\'#cidadeContato\').html('<option>Carregando...</option>');
                $(\'#cidadeContato').load('listaCidades.php?codigoEstado=". $estadoContato . "&codigoCidade=". $cidadeContato . "');";
            }
        ?>
    
    });
</script>

</html>