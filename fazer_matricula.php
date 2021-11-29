<?php

    include('fswdd.php'); //fswdu - Funções Sistema Web Definidas pelo Desenvolvedor

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    };


//    id_disc=" . $row["id"]
//    id_alun=" . $_SESSION['id_alun']

    if(!isset($_GET['id_disc'])){
        echo "<p class='disciplina'>Disciplina não selecionada</p>";
        header("Location: logout.php");
        exit();
    }
    
    //Nome do Aluno
    echo "<h1>" . $_SESSION['usuario'] . "</h1>";
    //Título da Disciplina
    echo "<h2>" . $_SESSION['disc'] . "</h2>";


    if(!isset($_GET['id_disc'])){
        echo "<p class='disciplina'>Atividade não selecionada</p>";
        header("Location: index.php?requisicao=matDisciplina");
        exit();
    }
    else{
        $conn = servidor();
        $sql = "REPLACE INTO matricula (aluno, disciplina) VALUES (?, ?) ;";
        $ps = $conn->prepare($sql);
        if ($ps) {
            $ps->bind_param('ii', $_SESSION['id_alun'] ,$_GET['id_disc'] );
            $ps->execute();
            
            echo "<script language='javascript' type='text/javascript'>";
            echo "        alert('Registro(s) apagado(s): '". $ps->affected_rows .")";
            echo "</script>";
            //echo "<p>Registro(s) apagado(s): ";
            //echo $ps->affected_rows;
            //echo "</p>";
            header("Location: index.php?requisicao=matDisciplina");

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