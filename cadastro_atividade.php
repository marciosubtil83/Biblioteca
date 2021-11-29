<?php
    include('fswdd.php'); //fswdu - Funções Sistema Web Definidas pelo Desenvolvedor

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    };
    if(isset($_GET['id_disc'])){
        $_SESSION['id_disc'] = $_GET['id_disc'];
        if(isset($_GET['disc']))
            $_SESSION['disc'] = $_GET['disc'];
        else{
            $_SESSION['disc'] = "";
            echo "<p class='disciplina'>Disciplina não selecionada</p>";
        }
    }


    //Nome do Professor
    echo "<h1>" . $_SESSION['usuario'] . "</h1>";
    //Título da Disciplina
    echo "<h2>" . $_SESSION['disc'] . "</h2>";

    //Se não estiver na sessão "login_prof" retorna para a página de cadastro de disciplina
    if(!isset($_SESSION['id_disc'])){
        header("Location: index.php?requisicao=cadDisciplina");
        exit();
    }

    $conn = servidor();

    $sql = "SELECT id, nome, peso FROM atividade WHERE disciplina = ? ORDER BY nome;";
    $ps = $conn->prepare($sql);
    $ps->bind_param("i", $_SESSION['id_disc'] );
    $ps->execute();
    $result = $ps->get_result();



    echo "<table>";
    echo "    <tr>";
    echo "        <th>Id</th>";
    echo "        <th>Atividade</th>";
    echo "        <th id='tblTextCenter'>Peso</th>";
    echo "        <th id='tblTextCenter'>Lançar nota</th>";
    //echo "        <th id='tblTextCenter'>Editar atividade</th>";      //precisa verificar quais comandos aplicar
    echo "        <th id='tblTextCenter'>Excluir atividade</th>";
    echo "    </tr>";
    if( $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<tr>";
            echo "    <td>" . $row["id"] . "</td>";
            echo "    <td>" . $row["nome"] . "</td>";
            echo "    <td id='tblTextCenter'>" . $row["peso"] . "</td>";
            echo "    <td id='tblTextCenter'> <a href='index.php?requisicao=cadNota&id_ativ=" . $row["id"] . "&atividade=" . $row["nome"] . "'>Lançar</a> </td>";
            //echo "    <td id='tblTextCenter'> <a href='index.php?requisicao=cadAtiv&id_disc=" . $_SESSION['id_disc'] . "&id_ativ=". $row["id"] . "&x=true" . "'>Editar</a> </td>";

            $sql = "SELECT count(*) as cont FROM nota n WHERE n.atividade = ?;";
            $ps = $conn->prepare($sql);
            $ps->bind_param("i", $row["id"] );
            $ps->execute();
            $notas = $ps->get_result();
            $notas = $notas->fetch_assoc();
            if( $notas["cont"]> 0){
                echo "    <td id='tblTextCenter'>--</td>";
            }
            else{
                echo "    <td id='tblTextCenter'> <a href='index.php?requisicao=eclAtiv&id_ativ=". $row["id"] . "'>Excluir</a> </td>";
            }
            echo "    </td>";
            echo "</tr>";
        }
    }
    echo "</table>";


    echo "<form action='index.php?requisicao=cadAtiv'  method='POST'> ";
    echo "    <label for='atividade'>Nome da atividade</label> ";
    echo "    <input type='text' id='atividade' name='atividade'/><br><br> ";
    echo "    <label for='peso'>Peso</label> ";
    echo "    <input type='text' id='peso' name='peso'/><br><br> ";
    echo "    <input type='submit' value='Cadastrar'/> ";
    echo "</form> ";
    echo "<br>";
    echo "<br>";
    echo "<a href='index.php?requisicao=cadDisciplina'>Voltar</a> ";

    //    var_dump($_SERVER)
    if($_SERVER['REQUEST_METHOD']=="POST"){        

        $conn = servidor();
    
        If($_POST['atividade'] != "")
            $sql = "INSERT INTO atividade (nome, peso, disciplina) VALUES ('" . $_POST['atividade'] . "', '" . $_POST['peso'] . "', " . $_SESSION['id_disc'] . ");";
        else{
            echo "<b>Informe o nome da atividade.</b>";
            $sql = "";
        }

        if($sql != ""){
            $result = $conn->query($sql);  //Executa a query SQL dentro da conexão com o BD configurada em $conn
            if( $result === TRUE){
                echo "<p>Cadastro realizado com sucesso.</p>";
                header("Location: index.php?requisicao=cadAtiv&id_disc=" . $_SESSION['id_disc'] . "&disc=" .  $_SESSION['disc'] ."");
            }
            else
                echo "<p>Erro: ". $sql . "<br>" . $conn->error . "</p>";
        }
    
    }
?>

<!DOCTYPE HTML>
<html>
    <body>

    </body>
</html>