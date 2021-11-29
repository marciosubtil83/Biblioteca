<?php
    session_start();
    session_unset();    //usado para limpar as variáveis da sessão. Usado quando há mais de uma variável.
    session_destroy();
    header("Location: index.php?requisicao=home");
?>