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
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <meta charset="utf-8">
    
    <body>
        <header>
            <div class="container">
                <div id="logo">
                    <img src="imagens/logo.png">
                </div>
                <div id="menu">                    
                    <a href="index.php?requisicao=home">Home</a>
                    <?php
                        if( isset($_SESSION['login']) ){
                            if($_SESSION['permissao'] == 9){ #administrador
                                echo '<a href="index.php?requisicao=userCad">Cadastrar Usuário</a>';
                                echo '<a href="index.php?requisicao=livroCadastro">Cadastrar Livro</a>';
                            }
                            echo '<a href="index.php?requisicao=livroConsulta">Consultar Livro</a>';
                            echo '<a href="index.php?requisicao=logout">Logout</a>';
                        }
                        else
                            echo '<a href="index.php?requisicao=login">Login</a>';
                    ?>
                </div>
            </div>
        </header>

        <div>
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
    </body>

    <footer>Desenvolvido por Factory<br>2021</footer>

</html>