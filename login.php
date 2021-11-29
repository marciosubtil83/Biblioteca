<?php
    include_once('fswdd.php'); //fswdd - Funções do Sistema Web Definidas pelo Desenvolvedor

    //inicia session em php
    if (session_status() == PHP_SESSION_NONE)
        session_start();

    if(isset($_SESSION['login']))
        header("Location: index.php?requisicao=home");


    if($_SERVER['REQUEST_METHOD']=="POST"){

        $login = $_POST['user'];

        $conn = servidor();
    
        if($conn->connect_error)
            die("Falha na conexão: " . $conn->connect_error);
            
        $sql = "SELECT u.id as u_id, u.nome, u.login, u.senha, u.acesso as permissao
                FROM  bib_usuario u
                WHERE u.login = ?;";
        $ps = $conn->prepare($sql);
        $ps->bind_param("s", $login );
        $ps->execute();
        $result = $ps->get_result();

        if( $result->num_rows > 0)
            $row = $result->fetch_assoc();
        else
            die("<p>Login não cadastrado.</p>");

        $u_id = $row["u_id"];
        $login = $row["login"];

        //Valida usuario
        if($_POST["user"] == $login){

            //valida senha criptografada
            if( password_verify($_POST["pass"], $row["senha"]) ){
                $_SESSION['login'] = true;
                $_SESSION['usuario_login'] = $row["login"];
                $_SESSION['usuario'] = $row["nome"];
                $_SESSION['permissao'] = $row["permissao"];
                $_SESSION['id'] = $row["c_id"];

                //admin
                if($_SESSION['permissao'] === 9)
                    header("Location: index.php?requisicao=livroCadastro");
                //Professor
                elseif($_SESSION['permissao'] === 8)
                    header("Location: index.php?requisicao=livroConsulta");
                //Aluno
                elseif($_SESSION['permissao'] === 1)
                    header("Location: index.php?requisicao=livroConsulta");
                else
                    header("Location: index.php?requisicao=erro");
                
                    exit();
            }
            else
                die("<p>Senha inválida.</p><br><p>Voltar para o sistema <a href='javascript:history.back()'>voltar</a> </p>");
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Biblioteca</title>
        <link rel="stylesheet" type="text/css" href="estilo.css">
    </head>
    <meta charset="utf-8">
    <body>
        <form action="login.php" method="POST" id="formu">
            <span><i class="fas fa-user"></i> <input type="text" name="user" placeholder="Usuario" required/></span><br>
            <input type="password" name="pass" placeholder="Senha" required/>
            <button type="submit">ACESSAR</button>
        </form>
    </body>
</html>
