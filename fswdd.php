<?php
    //Funções do Servidor Web Definidas pelo Desenvolvedor
    function servidor(){
        $servidor ="167.99.252.245";
        $usuario = "BES_E13";
        $senha = "ZB86hqWr73AYxba";
        $basededados = "BES_E13";
        $porta = "3306";
        $conn = new mysqli($servidor, $usuario, $senha, $basededados, $porta);
        
        if($conn->connect_error)
            die("Falha na conexão: " . $conn->connect_error);
        else
            return $conn;
    }

    function senha($senha){
        $custo = ['cost' => 8];
        $hash = password_hash($senha,  PASSWORD_DEFAULT, $custo); //a hash será diferente a cada execução
        return $hash;
    }
    
?>