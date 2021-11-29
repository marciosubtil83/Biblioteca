<?php
    include('fswdd.php'); //fswdu - Funções Sistema Web Definidas pelo Desenvolvedor

    if (session_status() == PHP_SESSION_NONE)
        session_start();

    //Se não estiver na sessão "login" executa logout
    if(!isset($_SESSION['login']) ){
        header("Location: index.php?requisicao=logout");
        exit();
    }

    //filtro da consulta
    if(isset($_POST['consulta']))
        $_SESSION['consulta'] = $_POST['consulta'];
    else
        $_SESSION['consulta'] = "";

    if($_SESSION['consulta'] == "todos")
        $_POST['termo'] = "todos";

    //termo da consulta
    if(isset($_POST['termo']))
        $_SESSION['termo'] = $_POST['termo'];
    else
        $_SESSION['termo'] = "";

    //Se não estiver na sessão "id_disc" retorna para a página de disciplina
    if( !isset($_SESSION['consulta']) || !isset($_SESSION['termo']) ){
        header("Location: index.php?requisicao=livroConsulta");
        exit();
    }
    $conn = servidor();

    //Query de pesquisa de Nota com filtro de aluno e disciplina
    $sql = "SELECT
                autor_sobrenome,
                autor_nome,
                titulo,
                subtitulo,
                genero,
                ISBN,
                corredor,
                estante
            FROM bib_livro ";
    if($_SESSION['consulta'] == "autor_sobrenome"){
        $_SESSION['termo'] = "%".$_SESSION['termo']."%";
        $sql = $sql . "WHERE autor_sobrenome like ? ORDER BY ISBN";
    }
    elseif($_SESSION['consulta'] == "autor_nome"){
        $_SESSION['termo'] = "%".$_SESSION['termo']."%";
        $sql = $sql . "WHERE autor_nome like ? ORDER BY ISBN";
    }
    elseif($_SESSION['consulta'] == "titulo"){
        $_SESSION['termo'] = "%".$_SESSION['termo']."%";
        $sql = $sql . "WHERE titulo like ? ORDER BY ISBN";
    }
    elseif($_SESSION['consulta'] == "subtitulo"){
        $_SESSION['termo'] = "%".$_SESSION['termo']."%";
        $sql = $sql . "WHERE subtitulo like ? ORDER BY ISBN";
    }
    elseif($_SESSION['consulta'] == "genero"){
        $_SESSION['termo'] = "%".$_SESSION['termo']."%";
        $sql = $sql . "WHERE genero like ? ORDER BY ISBN";
    }
    elseif($_SESSION['consulta'] == "ISBN"){
        $_SESSION['termo'] = "%".$_SESSION['termo']."%";
        $sql = $sql . "WHERE ISBN = ? ORDER BY ISBN";
    }
    elseif($_SESSION['consulta'] == "corredor")
        $sql = $sql . "WHERE corredor = ? ORDER BY ISBN";
    elseif($_SESSION['consulta'] == "estante")
        $sql = $sql . "WHERE estante = ? ORDER BY ISBN";
    else
        $sql = $sql . "ORDER BY ISBN";

    $ps = $conn->prepare($sql);
    if($_SESSION['consulta'] != "todos")
        $ps->bind_param("s", $_SESSION['termo'] );
    $ps->execute();
    $result = $ps->get_result();

    echo "<br>";
    echo "<table>";
    echo "    <tr>";
    echo "        <th id='tblTextCenter'>Sobrenome</th>";
    echo "        <th id='tblTextCenter'>Nome</th>";
    echo "        <th id='tblTextCenter'>Titulo</th>";
    echo "        <th id='tblTextCenter'>Subtitulo</th>";
    echo "        <th id='tblTextCenter'>Gênero</th>";
    echo "        <th id='tblTextCenter'>ISBN</th>";
    echo "        <th id='tblTextCenter'>Corredor</th>";
    echo "        <th id='tblTextCenter'>Estante</th>";
    echo "    </tr>";
    if( $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<tr>";
            echo "    <td>" . $row["autor_sobrenome"] . "</td>";
            echo "    <td>" . $row["autor_nome"] . "</td>";
            echo "    <td>" . $row["titulo"] . "</td>";
            echo "    <td>" . $row["subtitulo"] . "</td>";
            echo "    <td>" . $row["genero"] . "</td>";
            echo "    <td>" . $row["ISBN"] . "</td>";
            echo "    <td id='tblTextCenter'>" . $row["corredor"] . "</td>";
            echo "    <td id='tblTextCenter'>" . $row["estante"] . "</td>";
            echo "    </td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    echo "<br>";
    echo "<br>";

    //Voltar para uma página especificada pelo desenvolvedor
    echo "<p>Voltar para a consulta <a href='index.php?requisicao=livroConsulta'>voltar</a> </p>";
?>

<!DOCTYPE HTML>
<html>
    <body>

    </body>
</html>