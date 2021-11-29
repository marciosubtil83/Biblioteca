<?php
    if(!isset($_GET['res']))
        exit();

    //Cadastro de usuário realizado
    if($_GET['res'] === "S"){
        echo "<br>";
        echo "<p>Cadastro de livro realizado com sucesso.</p>";
        echo "<br>";
        //Voltar para uma página especificada pelo desenvolvedor
        echo "<p>Voltar para o sistema <a href='index.php?requisicao=livroCadastro'>voltar</a> </p>";
    }
    //Cadastro já existe
    else if($_GET['res'] === "N"){
        echo "<br>";
        echo "<p>Cadastro de livro com o ISBN informado já existe.</p>";
        echo "<p>Utilize outro ISBN para o cadastro do livro.</p>";
        echo "<br>";
        //Voltar para a página anterior do navegador
        echo "<p>Voltar para o sistema <a href='javascript:history.back()'>voltar</a> </p>";
    }
    else{
        header("Location: index.php?requisicao=erro");
    }
?>