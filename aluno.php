<?php
    //Se não estiver na sessão "login_alun" retorna para a página inicial
    session_start();
    if(!isset($_SESSION["login_alun"])){
        header("Location: index.php");
        exit();
    }
?>


<!DOCTYPE HTML>
<html>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <meta charset="utf-8">
    <body>
        <h1>Área do Aluno</h1>
        <p>Bem vindo(a), <?php echo $_SESSION['usuario'];?> [<a href="logout.php">sair</a>]</p>
        <br>
        <p> <a href="index.php?requisicao=matDisciplina">Disciplinas</a> </p>
        <?php
            echo "<p> <a href='index.php?requisicao=notaAlun&id_alun=" . $_SESSION['id_alun'] . "'>Notas</a> </p>";
        ?>
    </body>
</html>

