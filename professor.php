<?php
    //Se não estiver na sessão "login_prof" retorna para a página inicial
    session_start();
    if(!isset($_SESSION["login_prof"])){
        header("Location: index.php");
        exit();
    }
?>


<!DOCTYPE HTML>
<html>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <meta charset="utf-8">
    <body>
        <h1>Área do Professor</h1>
        <p>Bem vindo(a), <?php echo $_SESSION['usuario'];?> [<a href="logout.php">sair</a>]</p>
        <br>
        <p> <a href="index.php?requisicao=cadDisciplina">Disciplina</a> </p>
    </body>
</html>

