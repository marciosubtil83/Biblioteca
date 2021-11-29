<?php
    include('fswdd.php'); //fswdu - Funções Sistema Web Definidas pelo Desenvolvedor

    if (session_status() == PHP_SESSION_NONE)
        session_start();
    if(isset($_GET['id_ativ']))
        $_SESSION['id_ativ'] = $_GET['id_ativ'];
    if(isset($_GET['atividade']))
        $_SESSION['atividade'] = $_GET['atividade'];

    //Nome do Professor
    echo "<h1>" . $_SESSION['usuario'] . "</h1>";
    //Título da Disciplina
    echo "<h2>" . $_SESSION['disc'] . "</h2>";
    //Título da Atividade
    echo "<h3>" . $_SESSION['atividade'] . "</h3>";

    //Se não estiver na sessão "login_prof" retorna para a página de cadastro de disciplina
    if(!isset($_SESSION['id_disc'])){
        header("Location: index.php?requisicao=cadDisciplina");
        exit();
    }

    $conn = servidor();

    $sql = "SELECT 
                d.nome as disciplina, 
                ativ.id as id_ativ,
                ativ.nome, 
                ativ.peso,
                a.id as id_aluno, 
                a.nome as aluno, 
                n.valor as nota, 
                cast((ativ.peso * n.valor) as decimal(5,2)) as media 
            FROM matricula m 
            INNER JOIN disciplina d ON d.id = m.disciplina 
            INNER JOIN aluno a ON a.id = m.aluno 
            INNER JOIN atividade ativ ON ativ.disciplina = m.disciplina 
            LEFT OUTER JOIN nota n ON n.aluno = a.id AND n.atividade = ativ.id 
            WHERE ativ.id = ? 
            ORDER BY a.nome;";
    $ps = $conn->prepare($sql);
    $ps->bind_param("i", $_SESSION['id_ativ'] );
    $ps->execute();
    $result = $ps->get_result();

    echo "<form action='index.php?requisicao=cadNota&id_ativ=". $_SESSION['id_ativ'] ."&atividade=". $_SESSION['atividade'] ."' method='POST'>";
    echo "    <table>";
    echo "        <tr>";
    echo "            <th id='tblTextCenter'>Peso atividade</th>";
    echo "            <th>Aluno</th>";
    echo "            <th id='tblTextCenter'>Nota lançada</th>";
    echo "            <th id='tblTextCenter'>Nova Nota</th>";
    echo "            <th id='tblTextCenter'>Média alcançada</th>";
    echo "        </tr>";
    if( $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "        <tr>";
            echo "            <td id='tblTextCenter'>" . $row["peso"] . "</td>";
            echo "            <td>" . $row["id_aluno"] . " - " . $row["aluno"] . "</td>";
            echo "            <td id='tblTextCenter'>" . $row["nota"] . "</td>";
            echo "            <td id='tblTextCenter'> <input type = 'text' id = 'nota-". $row["id_aluno"] ."' name = 'nota-". $row["id_aluno"] ."'/> </td>";
            echo "            <td id='tblTextCenter'>" . $row["media"] . "</td>";
            echo "            </td>";
            echo "        </tr>";
        }
    }
    echo "    </table>";
    echo "    <input type='submit' value='Salvar'/>";
    echo "</form>";
    echo "<br>";
    echo "<br>";
    echo "<a href='index.php?requisicao=cadAtiv&id_disc=" .$_SESSION['id_disc'] . "&disc=" . $_SESSION['disc'] . "'>Voltar</a> ";


    //    var_dump($_SERVER)
    if($_SERVER['REQUEST_METHOD']=="POST"){

        $conn = servidor();
    
        //if($conn->connect_error)
        //    die("Falha na conexão: " . $conn->connect_error);

        foreach($_POST as $key => $value){
            $id = substr($key, 5);
            //echo "<p>". $_POST[$key] ."</p>";
            if($_POST[$key] != ""){
                $sql = "REPLACE INTO nota  (aluno, atividade, valor) VALUES (" . $id . ", " .  $_SESSION['id_ativ'] . ", '" . $_POST[$key] . "');";
                //echo "<p>SQL: " . $sql . "</p>";
            }
            
            //$sql = "";

            if($sql != ""){
                $result = $conn->query($sql);  //Executa a query SQL dentro da conexão com o BD configurada em $conn
                if( $result === TRUE){
                    echo "Cadastro realizado com sucesso.";
                    header("Location: index.php?requisicao=cadNota&id_ativ=" . $_SESSION['id_ativ'] . "&atividade=" . $_SESSION['atividade'] ."");
                }
                else
                    echo "Erro: ". $sql . "<br>" . $conn->error;
            }

            //$sql = "INSERT INTO disciplina VALUES (?,?)";
            //$ps = $conn->prepare($sql);
            //$ps->bind_param("si", $_POST['disciplina'], $_SESSION['id_prof'] );
            //$ps->execute();
            //$result = $ps->get_result();
        }        
    }
?>

<!DOCTYPE HTML>
<html>
    <body>

    </body>
</html>