<?php

    include_once('fswdd.php'); //fswdd - Funções do Sistema Web Definidas pelo Desenvolvedor

    //inicia session em php, se já não estiver iniciada
    if (session_status() == PHP_SESSION_NONE)
        session_start();

    //se sessão 'login' não estiver iniciada, não permite entrar na tela de cadastro de fornecedor
#    if(!isset($_SESSION['login']))
#        header("Location: index.php");

        //não permite usuário com permissao inferior à nivel 5 realizar cadastro de fornecedor
#    if($_SESSION['permissao'] < 5){
#        header("Location: index.php?requisicao=logout");
#    }

    //se servidor receber uma requisição do método 'POST'
    if($_SERVER['REQUEST_METHOD']=="POST"){

        //inicia conexão com o servidor do BD
        $conn = servidor();
    
        //se houver erro na conexão com o BD informa o erro e encerra conexão
        if($conn->connect_error)
            die("Falha na conexão: " . $conn->connect_error);

        //Usuário
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $login = $_POST['user'];
        $senha = $_POST['senha'];
        $tipo = $_POST['tipo_user'];
        
        //Define código da permissão
        if($tipo === "Administrador")
            $permissao = 9;
        else if($tipo === "Professor")
            $permissao = 8;
        else if($tipo === "Aluno")
            $permissao = 1;
        else
            $permissao = 0;

        //Valida se todos os campos estão preenchidos na tela
        if($nome === "" || $telefone === "" || $email === "" || $login === "" || $senha === "" || $permissao === 0){
            echo "<p>Antes de salvar, preencha todos os dados do cadastro de usuário.</p>";
            exit();
        }
        //Cadastro do usuário
        else{
            //Consulta login
            $sql = "SELECT id FROM bib_usuario WHERE login = ? ";
            $ps = $conn->prepare($sql);
            $ps->bind_param("s", $login );
            $ps->execute();
            $result = $ps->get_result();
            if( $result->num_rows > 0){
                $row = $result->fetch_assoc();
                $id_usuario = $row['id'];
                header("Location: index.php?requisicao=usuario_cadastrado&res=N");
            }
            else{
                //Codifica senha do usuário
                $senha = senha($senha);

                //Cadastrar usuário
                $sql = "INSERT INTO bib_usuario (login, senha, nome, email, telefone, acesso)
                        VALUES ('". $login ."', '". $senha ."', '". $nome ."', '". $email ."', '". $telefone ."', ". $permissao .")";
                //Executa a query SQL dentro da conexão com o BD configurada em $conn
                $result = $conn->query($sql);
                //Se query foi executada
                if( $result === TRUE){
                    $id_usuario = $conn->insert_id;
                    if($id_usuario > 0){
                        $_SESSION['id_usuario'] = $id_usuario;
                        header("Location: index.php?requisicao=usuario_cadastrado&res=S");
                    }
                    else
                        echo "Erro ao recuperar id do usuario cadastrado: ". $sql . "<br>" . $conn->error;
                }
                //Se query não foi executada
                else
                    echo "Erro ao incluir cadastro de usuario: ". $sql . "<br>" . $conn->error;
            }        
        }
    }
?>


<!DOCTYPE HTML>

<html>
    <head>
        <title>Biblioteca</title>
        <meta charset="utf-8">
    </head>
    <body>
        <form class="cadastro" id="cadastro" name="Cadastro" method="post" action="index.php?requisicao=usuario">
            <label for="Cad_user">Cadastro Usuário</label>
            <input class="form-control"type="text" id="nome" required="required" name="nome" maxlength=50 placeholder="Nome"/></br>
            <input class="form-control"type="tel" id="telefone" required="required" name="telefone" maxlength=11 placeholder="Telefone"/> </br>
            <input class="form-control"type="email" id="email" required="required" name="email" maxlength=100 placeholder="E-mail"/> </br>
            <input class="form-control"type="text" id="user" required="required" name="user" maxlength=20 placeholder="Usuário"/></br>
            <input class="form-control"type="password" id="senha" required="required" name="senha"placeholder="Senha"/></br>
            <label for="Cad_user">Cadastro de acessos</label>
            <select class="form-control form-select-lg mb-3" aria-label=".form-select-lg example" name="tipo_user">
                <option selected>Selecione a Permissão</option>
                <!-- <option value="Administrador">Administrador</option> -->
                <option value="Aluno">Aluno</option>
                <option value="Professor">Professor</option>
            </select>
            <input  type="submit"  class="btn btn-info" onclick="Enviar();" value="Salvar"/>
        </form>
    </body>
</html>
