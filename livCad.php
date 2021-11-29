<?php
    include('fswdd.php'); //fswdu - Funções Sistema Web Definidas pelo Desenvolvedor

    //Se não estiver na sessão "login_prof" retorna para a página inicial
    session_start();
    if(!isset($_SESSION['login_prof'])){
        header("Location: index.php");
        exit();
    }

    //Nome do Professor
    echo "<h1>" . $_SESSION['usuario'] . "</h1>";

    $conn = servidor();

    $sql = "SELECT id, nome FROM disciplina WHERE professor = ? ORDER BY nome;";
    $ps = $conn->prepare($sql);
    $ps->bind_param("i", $_SESSION['id_prof'] );
    $ps->execute();
    $result = $ps->get_result();

    echo "<table>";
    echo "    <tr>";
    echo "        <th>Id</th>";
    echo "        <th>Disciplina</th>";
    echo "        <th id='tblTextCenter'>Atividade</th>";
    echo "    </tr>";
    if( $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<tr>";
            echo "    <td>" . $row["id"] . "</td>";
            echo "    <td>" . $row["nome"] . "</td>";
            echo "    <td id='tblTextCenter'> <a href='index.php?requisicao=cadAtiv&id_disc=" . $row["id"] . "&disc=" . $row["nome"] . "'>Ver</a> </td>";
            echo "    </td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    echo "<h3>Cadastro de nova disciplina</h3>";
    echo "<form action='index.php?requisicao=cadDisciplina' method='POST'> ";
    echo "<label for='disciplina'>Nome da Disciplina</label> ";
    echo "<input type='text' id='disciplina' name='disciplina'/><br><br> ";
    echo "<input type='submit' value='Cadastrar'/> ";
    echo "</form> ";
    echo "<br> ";
    echo "<br> ";
    echo "<a href='index.php?requisicao=professor'>Voltar</a> ";


    //    var_dump($_SERVER)
    if($_SERVER['REQUEST_METHOD']=="POST"){

        $conn = servidor();
    
        If($_POST['disciplina'] != "")
            $sql = "INSERT INTO disciplina (nome, professor) VALUES ('" . $_POST['disciplina'] . "', " . $_SESSION['id_prof'] . ");";
        else{
            echo "<b>Informe o nome da disciplina.</b>";
            $sql = "";
        }

        if($sql != ""){
            $result = $conn->query($sql);  //Executa a query SQL dentro da conexão com o BD configurada em $conn
            if( $result === TRUE)
                echo "Cadastro realizado com sucesso.";
            else
                echo "Erro: ". $sql . "<br>" . $conn->error;
        }
        
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