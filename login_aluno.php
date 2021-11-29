<?php
    include('fswdd.php'); //fswdd - Funções do Sistema Web Definidas pelo Desenvolvedor

    session_start();
    if(isset($_SESSION["login_alun"]))
        header("Location: index.php?requisicao=aluno");


    if($_SERVER['REQUEST_METHOD']=="POST"){

        $conn = servidor();
    
        if($conn->connect_error)
            die("Falha na conexão: " . $conn->connect_error);
            
        $sql = "SELECT a.id, a.nome, a.login, a.senha FROM  aluno a
                WHERE a.login = ?;";
        $ps = $conn->prepare($sql);
        $ps->bind_param("s", $_POST['user'] );
        $ps->execute();
        $result = $ps->get_result();

        if( $result->num_rows > 0)
            $row = $result->fetch_assoc();
        else
            die("<p>Login de Aluno não cadastrado.</p>");

        if($_POST["user"] == $row["login"] && $_POST["pass"] == $row["senha"] ){
            session_start();
            $_SESSION["login_alun"] =true;
            $_SESSION['usuario'] = $row["nome"];
            $_SESSION['id_alun'] = $row["id"];
            header("Location: index.php?requisicao=aluno");
            exit();
        }else{
            //informação incorreta
            echo "Dados incorretos, tente novamente";
       }
    }
?>


<!DOCTYPE HTML>
<HTML>
    <head>Acesso Aluno</head>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <meta charset="utf-8">

    <body>
        <form action="login_aluno.php" method="POST">
            <label for="user">Usuário</label>
            <input type="text" id="user" name="user"/><br><br>
            <label for="pass">Senha</label>
            <input type="password" id="pass" name="pass"/><br><br>
            <input type="submit" value="Entrar"/>
        </form>
    </body>
</HTML>
