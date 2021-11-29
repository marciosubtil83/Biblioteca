<?php
    include('fswdd.php'); //fswdu - Funções Sistema Web Definidas pelo Desenvolvedor

    //Se não estiver na sessão "login_alun" retorna para a página inicial
    session_start();
    if(!isset($_SESSION['login_alun'])){
        header("Location: index.php");
        exit();
    }

    //Nome do Aluno
    echo "<h1>" . $_SESSION['usuario'] . "</h1>";

    $conn = servidor();

    $sql = "SELECT d.id, d.nome, CASE WHEN m.aluno is null THEN 0 ELSE 1 END AS matriculado FROM disciplina d LEFT OUTER JOIN (SELECT aluno, disciplina from matricula WHERE aluno = ? ) m ON m.disciplina = d.id ORDER BY d.nome;";
    $ps = $conn->prepare($sql);
    $ps->bind_param("i", $_SESSION['id_alun'] );
    $ps->execute();
    $result = $ps->get_result();

    echo "<table>";
    echo "    <tr>";
    echo "        <th id='tblTextCenter'>Id</th>";
    echo "        <th id='tblTextCenter'>Disciplina</th>";
    echo "        <th id='tblTextCenter'>Matriculado</th>";
    echo "        <th id='tblTextCenter'>Notas</th>";
    echo "    </tr>";
    if( $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<tr>";
            echo "    <td>" . $row["id"] . "</td>";
            echo "    <td>" . $row["nome"] . "</td>";
            if($row["matriculado"] == 0)
                echo "    <td id='tblTextCenter'> <a href='index.php?requisicao=fazMatDisc&id_disc=" . $row["id"] . "&id_alun=" . $_SESSION['id_alun'] . "' title='Matricular em " . $row["nome"] . "'>Não</a> </td>";
            else
                echo "    <td id='tblTextCenter'>Sim</td>";
            echo "    </td>";
            if($row["matriculado"] == 0)
                echo "    <td id='tblTextCenter'></td>";
            else
                echo "    <td id='tblTextCenter'> <a href='index.php?requisicao=notaAlun&id_disc=" . $row["id"] . "&id_alun=" . $_SESSION['id_alun'] . "' title='Ver nota de " . $row["nome"] . "'>Ver nota</a> </td>";
            echo "    </td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    echo "<br>";
    echo "<br>";
    echo "<a href='index.php?requisicao=aluno'>Voltar</a> ";

    //    var_dump($_SERVER)
    if($_SERVER['REQUEST_METHOD']=="POST"){
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="estilo.css" />
        <meta charset="UTF-8" />
    </head>
    <body>

    </body>
</html>