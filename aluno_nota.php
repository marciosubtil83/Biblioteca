<?php
    include('fswdd.php'); //fswdu - Funções Sistema Web Definidas pelo Desenvolvedor

    if (session_status() == PHP_SESSION_NONE)
        session_start();
    if(isset($_GET['id_disc']))
        $_SESSION['id_disc'] = $_GET['id_disc'];
    else
        $_SESSION['id_disc'] = "";

    //Nome do Aluno
    echo "<h1>" . $_SESSION['usuario'] . "</h1>";
    //Título da Disciplina
    //echo "<h2>" . $_SESSION['disc'] . "</h2>";
    //Título da Atividade
    //echo "<h3>" . $_SESSION['atividade'] . "</h3>";

    //Se não estiver na sessão "id_disc" retorna para a página de disciplina
    if(!isset($_SESSION['id_disc'])){
        header("Location: index.php?requisicao=matDisciplina");
        exit();
    }

    $conn = servidor();

    //Query de pesquisa de Nota com filtro de aluno e disciplina
    if($_SESSION['id_disc'] != ""){
        $sql = "SELECT 
                    d.nome,
                    cast(ifnull(sum(n.valor * ativ.peso),0) as decimal(4,2)) as media 
                FROM matricula m
                JOIN disciplina d on d.id = m.disciplina
                LEFT OUTER JOIN atividade ativ ON ativ.disciplina = d.id
                LEFT OUTER JOIN (SELECT * FROM nota WHERE aluno = ?) n ON n.atividade = ativ.id AND n.aluno = m.aluno
                WHERE m.disciplina = ?
                GROUP BY d.nome;";
        $ps = $conn->prepare($sql);
        $ps->bind_param("ii", $_SESSION['id_alun'], $_SESSION['id_disc'] );
    }
    //Query de pesquisa de Nota com filtro apenas de aluno
    else{
        $sql = "SELECT 
                    d.nome,
                    cast(ifnull(sum(n.valor * ativ.peso),0) as decimal(4,2)) as media 
                FROM matricula m
                JOIN disciplina d on d.id = m.disciplina
                LEFT OUTER JOIN atividade ativ ON ativ.disciplina = d.id
                LEFT OUTER JOIN nota n on n.atividade = ativ.id AND n.aluno = m.aluno
                WHERE m.aluno = ?
                GROUP BY d.nome;";
        $ps = $conn->prepare($sql);
        $ps->bind_param("i", $_SESSION['id_alun']);
    }
    $ps->execute();
    $result = $ps->get_result();

    echo "<table>";
    echo "    <tr>";
    echo "        <th id='tblTextCenter'>Disciplina</th>";
    echo "        <th id='tblTextCenter'>Média alcançada</th>";
    echo "    </tr>";
    if( $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<tr>";
            echo "    <td>" . $row["nome"] . "</td>";
            echo "    <td id='tblTextCenter'>" . $row["media"] . "</td>";
            echo "    </td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    echo "<br>";
    echo "<br>";
    if($_SESSION['id_disc'] != ""){
        echo "<a href='index.php?requisicao=matDisciplina'>Voltar</a> ";
    }
    else{
        echo "<a href='index.php?requisicao=aluno'>Voltar</a> ";
    }
?>

<!DOCTYPE HTML>
<html>
    <body>

    </body>
</html>