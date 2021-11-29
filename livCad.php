<?php

    include_once('fswdd.php'); //fswdd - Funções do Sistema Web Definidas pelo Desenvolvedor

    //inicia session em php, se já não estiver iniciada
    if (session_status() == PHP_SESSION_NONE)
        session_start();

    //se sessão 'login' não estiver iniciada, não permite entrar na tela de cadastro de fornecedor
#    if(!isset($_SESSION['login']))
#        header("Location: index.php");

        //não permite usuário com permissao inferior à nivel 5 realizar cadastro de fornecedor
#    if($_SESSION['permissao'] < 5){
#        header("Location: index.php?requisicao=logout");
#    }

    //se servidor receber uma requisição do método 'POST'
    if($_SERVER['REQUEST_METHOD']=="POST"){

        //inicia conexão com o servidor do BD
        $conn = servidor();
    
        //se houver erro na conexão com o BD informa o erro e encerra conexão
        if($conn->connect_error)
            die("Falha na conexão: " . $conn->connect_error);

        //Livro
        $autorSobrenome = $_POST['autorSobrenome'];
        $autorNome = $_POST['autorNome'];
        $titulo = $_POST['titulo'];
        $subtitulo = $_POST['subtitulo'];
        $isbn = $_POST['isbn'];
        $genero = $_POST['genero'];
        $corredor = $_POST['corredor'];
        $estante = $_POST['estante'];

        if($corredor == "")
            $corredor = 0;
        else{
            $corredor = intval($corredor);
        }

        if($estante == "")
            $estante = 0;
        else{
            $estante = intval($estante);
        }
        

        //Valida se todos os campos estão preenchidos na tela
        if($autorSobrenome === "" || $autorNome === "" || $titulo === ""  || $subtitulo === ""  || $isbn === "" || $genero === "" || $corredor === 0 || $estante === 0){
            echo "<p>Antes de salvar, preencha todos os dados do cadastro de usuário.</p>";
            exit();
        }
        //Cadastro do usuário
        else{
            //Consulta isbn
            $sql = "SELECT ISBN FROM bib_livro WHERE ISBN = ? ";
            $ps = $conn->prepare($sql);
            $ps->bind_param("s", $isbn );
            $ps->execute();
            $result = $ps->get_result();
            if( $result->num_rows > 0){
                header("Location: index.php?requisicao=livCadastrado&res=N");
            }
            else{
                //Cadastrar usuário
                $sql = "INSERT INTO bib_livro (autor_sobrenome, autor_nome, titulo, subtitulo, ISBN, genero, corredor, estante)
                VALUES ('". $autorSobrenome ."', '". $autorNome ."', '". $titulo ."', '". $subtitulo ."', '". $isbn ."', '". $genero ."', ". $corredor .", ". $estante .")";
                #$sql = "INSERT INTO bib_livro (autor_sobrenome, autor_nome, titulo, subtitulo, ISBN, genero, corredor, estante)
                #        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                
                //Executa a query SQL dentro da conexão com o BD configurada em $conn
                $ps = $conn->prepare($sql);
                #$ps->bind_param("ssssssii", $autorSobrenome, $autorNome, $titulo, $subtitulo, $isbn, $genero, $corredor, $estante );
                $ps->execute();
                $result = $ps->get_result();
                #$result = $conn->query($sql);
                //Se query foi executada
                $id_livro = $ps->insert_id;
                if( $id_livro > 0){
                    $_SESSION['id_livro'] = $id_livro;
                    header("Location: index.php?requisicao=livCadastrado&res=S");
                }
                //Se query não foi executada
                else
                    echo "Erro ao incluir cadastro do livro: ". $sql . "<br>" . $conn->error;
            }        
        }
    }
?>


<!DOCTYPE HTML>

<html>
    <head>
        <title>Biblioteca - Cadastro de Livro</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class='col-6'>
                    <table class="table">
                        <form class="form-control" id="cadastro" name="Cadastro" method="post" action="index.php?requisicao=livroCadastro">
                            <label class="form-control" for="Cad_user">Cadastrar Livro</label><br>

                            <input class="form-control"type="text" id="autorSobrenome" required="required" name="autorSobrenome" maxlength=20 placeholder="Sobrenome do Autor"/>
                            </br>
                            <input class="form-control"type="text" id="autorNome" required="required" name="autorNome" maxlength=50 placeholder="Nome do Autor"/>
                            </br>
                            <input class="form-control"type="text" id="titulo" required="required" name="titulo" maxlength=50 placeholder="Título do livro"/>
                            </br>
                            <input class="form-control"type="text" id="subtitulo" required="required" name="subtitulo" maxlength=100 placeholder="Subtítulo do livro"/>
                            </br>
                            <input class="form-control"type="text" id="isbn" required="required" name="isbn" maxlength=13 placeholder="ISBN"/>
                            </br>
                            <input class="form-control"type="text" id="genero" required="required" name="genero" maxlength=20 placeholder="Gênero"/>
                            </br>
                            <input class="form-control"type="number" id="corredor" required="required" name="corredor" placeholder="Nº do Corredor"/>
                            </br>
                            <input class="form-control"type="number" id="estante" required="required" name="estante" placeholder="Nº da Estante"/>
                            </br>
                            <input  type="submit"  class="btn btn-info" onclick="Enviar();" value="Salvar"/>
                        </form>
                    </table>
                </div> 
            </div>
        </div>
    </body>
</html>
