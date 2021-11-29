<?php
    include('fswdd.php'); //fswdu - Funções Sistema Web Definidas pelo Desenvolvedor

    session_start();
    if(isset($_SESSION["login_prof"]))
        header("Location: index.php?requisicao=professor");


    if($_SERVER['REQUEST_METHOD']=="POST"){

        $conn = servidor();
    
        if($conn->connect_error)
            die("Falha na conexão: " . $conn->connect_error);
    
        //$sql = "SELECT p.id, p.nome, p.login, p.senha FROM  professor p
        //        WHERE p.login = '" . $_POST['user'] . "';";

        //$result = $conn->query($sql);
        
        $sql = "SELECT p.id, p.nome, p.login, p.senha FROM  professor p
                WHERE p.login = ?;";
        $ps = $conn->prepare($sql);
        $ps->bind_param("s", $_POST['user'] );
        $ps->execute();
        $result = $ps->get_result();

        if( $result->num_rows > 0)
            $row = $result->fetch_assoc();
        else
            die("<p>Login de Professor não cadastrado.</p>");

        //if($_POST["user"]=="professor" && $_POST["pass"] =="1234"){
        if($_POST["user"] == $row["login"] && $_POST["pass"] == $row["senha"] ){
            session_start();
            $_SESSION["login_prof"] =true;
            $_SESSION['usuario'] = $row["nome"];
            $_SESSION['id_prof'] = $row["id"];            
            header("Location: index.php?requisicao=professor");
            exit();
        }else{
            //informação incorreta
            echo "Dados incorretos, tente novamente";
       }
    }
?>


<!DOCTYPE HTML>
<HTML>
    <head>Acesso Professor</head>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <meta charset="utf-8">

    <body>
        <form action="login_docente.php" method="POST">
            <label for="user">Usuário</label>
            <input type="text" id="user" name="user"/><br><br>
            <label for="pass">Senha</label>
            <input type="password" id="pass" name="pass"/><br><br>
            <input type="submit" value="Entrar"/>
        </form>
    </body>
</HTML>
