<?php 
    
    if (!isset($_GET['requisicao'])){
        header("Location: index.php?requisicao=home");
        //header("Location: login.php");
        }

    //inicia session em php
    if (session_status() == PHP_SESSION_NONE)
        session_start();

?> 

<!DOCTYPE html>
<html>
    <head>
        <title>Biblioteca</title>
    </head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!--<link rel="shortcut icon" type="image/x-icon" href="imagens/favicon.ico">-->
    <link rel="stylesheet" type="text/css" href="estilos/estilo.css">
    
    <body>
        <header>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-3">
                        <img src="imagens/logo.png">
                    </div>
                </div>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">                    
                <!--<h4><ul class='nav-item'><a href="index.php?requisicao=home"class='badge badge-light'>Home</a></ul></h4>-->
                <h4><ul class='nav-item'><a href="index.php?requisicao=login"class='badge badge-light'>Login</a></ul></h4>
                    <?php
                        if( isset($_SESSION['login']) ){
                            if($_SESSION['permissao'] == 9){ #administrador
                                echo "<h4><ul class='nav-item'><a href='index.php?requisicao=userCad'class='badge badge-light'>Cadastrar Usuário</a></ul></h4>";
                                echo "<h4><ul class='nav-item'><a href='index.php?requisicao=livroCadastro'class='badge badge-light'>Cadastrar Livro</a></ul></h4>";
                            }
                            echo "<h4><ul class='nav-item'><a href='index.php?requisicao=livroConsulta'class='badge badge-light'>Consultar Livro</a></ul></h4>";
                            echo "<h4><ul class='nav-item'><a href='index.php?requisicao=logout'class='badge badge-light'>Sair</ul></h4></a>";
                        }
                    ?>
                             
                    
                </nav>
            </div>
        </header>

        <div class="container-fluid">
            <?php
                if( isset($_SESSION['login']) ){
                    if($_SESSION['permissao'] == 8) #Professor
                        echo '<p>Bem vindo, Prof. '. $_SESSION['usuario'] .'.</p>';
                    else
                        echo '<p>Bem vindo, '. $_SESSION['usuario'] .'.</p>';
                }
            ?>
            <br>
        </div>
        <div class="container-fluid">
                <?php
                    switch($_GET['requisicao']){
                        case "consulta":
                            include(__DIR__."/livro_consultado.php");
                            break;                
                        case "livCadastrado":
                            include(__DIR__."/livro_cadastrado.php");
                            break;
                        case "livroCadastro":
                            include(__DIR__."/livCad.php");
                            break;                
                        case "livroConsulta":
                            include(__DIR__."/livCon.php");
                            break;                
                        case "login":
                            include(__DIR__."/login.php");
                            break;                
                        case "logout":
                            include(__DIR__."/logout.php");
                            break;                
                        case "userCad":
                            include(__DIR__."/usuarios.php");
                            break;
                        case "usuario_cadastrado":
                            include(__DIR__."/usuario_cadastrado.php");
                            break;
                        case "home":
                            include(__DIR__."/home.php");
                            break;
                        default:
                            include(__DIR__."/404.php");
                    }
                ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    </body>

    <footer>
        
        <div class="row">
            <div class="col-12">
                <p class="text-center">Desenvolvido por Factory <br> 2021</p>

            </div>
        </div>
    
    </footer>

</html>