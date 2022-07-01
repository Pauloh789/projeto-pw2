<?php
    session_start();

    $verificaUsuarioLogado = $_SESSION['verificaUsuarioLogado'];

    if(!$verificaUsuarioLogado){
        header("Location: index.php?codMsg=003");
    } else {
        include 'conectaBanco.php';
        include 'common/formataData.php';
        $codigoUsuarioLogado = $_SESSION['codigoUsuarioLogado'];

        if (isset($_GET['codigoContato'])) {
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

                $nascimentoContato = formataData($nascimentoContato);

                if ($sexoContato == 'M'){
                    $sexoContato = 'Masculino';
                } else {
                    $sexoContato = 'Feminino';
                }

                $sqlEndereco = "SELECT c.nomeCidade, e.nomeEstado FROM cidades as c, estados as e WHERE
                                c.codigoCidade=:cidadeContato AND e.codigoEstado=:estadoContato";
                
                $sqlEnderecoST = $conexao->prepare($sqlEndereco);
                $sqlEnderecoST->bindValue(':cidadeContato', $cidadeContato);
                $sqlEnderecoST->bindValue(':estadoContato', $estadoContato);

                $sqlEnderecoST->execute();
                $resultadoEndereco = $sqlEnderecoST->fetchALL();

                list($cidadeContato, $estadoContato) = $resultadoEndereco[0];

                echo "<h5 class=\"text-primary\">Dados pessoais</h5>
                      <hr>
                    <div class=\"row\"> 
                        <div class=\"col-sm-6\">
                            <p>$nomeContato</p> 
                        </div>

                        <img src=\"$fotoContato\" alt=\"$nomeContato\">
                    </div>
                    <div class=\"row\">
                        <div class=\"col-sm-6\">
                            <p>$nascimentoContato</p>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-sm-6\">
                            <p>$sexoContato</p>
                        </div>
                    </div>

                    <div class=\"row\">
                        <div class=\"col-sm-6\">
                            <p>$mailContato</p>
                        </div>
                    </div>

                    <div>
                        <h4 class=\"mb-3\" style=\"color: blue;\">
                            Telefones
                        </h4>
                    </div>

                    <div class=\"row\">
                        <div class=\"col-sm-6\">
                            <p>$telefone1Contato</p>
                        </div>
                        <div class=\"col-sm-6\">
                            $telefone2Contato</p>
                        </div>
                    </div>

                    <div class=\"row\">
                        <div class=\"col-sm-6\">
                            <p>$telefone3Contato</p>
                        </div>
                        <div class=\"col-sm-6\">
                            <p>$telefone4Contato</p>
                        </div>
                    </div>

                    <div>
                        <h4 class=\"mb-3\" style=\"color: blue;\">
                            Endereço
                        </h4>
                    </div>

                    <div class=\"row\">
                        <div class=\"col-sm\">
                            <p>$logradouroContato</p>
                        </div>
                    </div>

                    <div class=\"row\">
                        <div class=\"col-sm-6\">
                            <p>$complementoContato</p>
                        </div>
                        <div class=\"col-sm-6\">
                            <p>$bairroContato</p>
                        </div>
                    </div>

                    <div class=\"row\">
                        <div class=\"col-sm-6\">
                            <p>$estadoContato</p>
                        </div>
                        <div class=\"col-sm-6\">
                            <p>$cidadeContato</p>
                        </div>
                    </div>";
            }
        }
    }
?>