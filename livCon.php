<?php
    include('fswdd.php'); //fswdu - Funções Sistema Web Definidas pelo Desenvolvedor

    if (session_status() == PHP_SESSION_NONE)
        session_start();

    //Se não estiver na sessão "login" executa logout
    if(!isset($_SESSION['login']) ){
        header("Location: index.php?requisicao=logout");
        exit();
    }    
?>

<!DOCTYPE HTML>
<html>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class='col-6'>
                    <table class="table">
                        <form class="consulta" id="consulta" name="consulta" method="post" action="index.php?requisicao=consulta">
                            <label for="Cad_user">Consulta de Livro</label>

                            <select class="form-control form-select-lg mb-3" aria-label=".form-select-lg example" name="consulta">
                                <option selected>Selecione o termo</option>
                                <option value="autor_sobrenome">Sobrenome do Autor</option>
                                <option value="autor_nome">Nome do Autor</option>
                                <option value="titulo">Título</option>
                                <option value="subtitulo">Subtítulo</option>
                                <option value="genero">Gênero</option>
                                <option value="ISBN">ISBN</option>
                                <option value="corredor">Corredor</option>
                                <option value="estante">Estante</option>
                                <option value="todos">Todos</option>
                            </select>

                            <input class="form-control"type="text" id="termo" name="termo" maxlength=20 placeholder="Termo da pesquisa"/></br>

                            <input  type="submit"  class="btn btn-info" onclick="Enviar();" value="Consultar"/>
                        </form>
                    </table>
                </div> 
            </div>
        </div>
    </body>
</html>