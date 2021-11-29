<?php

    include('fswdd.php'); //fswdu - Funções Sistema Web Definidas pelo Desenvolvedor

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    };

    if(!isset($_SESSION['id_disc'])){
        echo "<p class='disciplina'>Disciplina não selecionada</p>";
        header("Location: logout.php");
        exit();
    }
    
    //Nome do Professor
    echo "<h1>" . $_SESSION['usuario'] . "</h1>";
    //Título da Disciplina
    echo "<h2>" . $_SESSION['disc'] . "</h2>";


    if(!isset($_GET['id_ativ'])){
        echo "<p class='disciplina'>Atividade não selecionada</p>";
        header("Location: index.php?requisicao=cadAtiv&id_disc=". $_SESSION['id_disc'] ."&disc=". $_SESSION['disc'] ."");
        exit();
    }
    else{
        $conn = servidor();
        $sql = "DELETE FROM atividade WHERE id = ? ;";
        $ps = $conn->prepare($sql);
        if ($ps) {
            $ps->bind_param('i', $_GET['id_ativ'] );
            $ps->execute();
            
            echo "<script language='javascript' type='text/javascript'>";
            echo "        alert('Registro(s) apagado(s): '". $ps->affected_rows .")";
            echo "</script>";
            //echo "<p>Registro(s) apagado(s): ";
            //echo $ps->affected_rows;
            //echo "</p>";
            header("Location: index.php?requisicao=cadAtiv&id_disc=" . $_SESSION['id_disc'] . "&disc=" .  $_SESSION['disc'] ."");

        }
        else{
            echo "<p>Erro de conexão: ";
            echo conn->error;
            echo "</p>";
        }
    }


?>

<!DOCTYPE HTML>
<html>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <script type="text/javascript" src="validacao.js"></script>
    <meta charset="utf-8">
    
    <body>

    </body>
</html>