<!DOCTYPE HTML>
<html>
<link rel="stylesheet" type="text/css" href="estilo.css">
    <meta charset="utf-8">
    <body>
                <header>
                    <div class="container">
                        <div id="logo">
                            <img src="imagens/logo.png">
                        </div>
                            <div id="menu">
                                
                                <a href="index.php?requisicao=home">Home</a>
                                <a href="index.php?requisicao=professor">Modulo Professor</a>
                                <a href="index.php?requisicao=aluno">Aluno</a>
                                
                            
                            </div>
                    </div>   

                </header>


        
        <div>
           <form action="aluno" method="POST">
                <table id="Cadastro">
                    <tr>
                        <th><label for="matricula">Matricula</label></th>
                        <td><input type="text" id="matricula" name="matricula"/></td>
                    
                    </tr>
                    <tr>
                        <th><label for="nome">Nome</label></th>
                        <td><input type="text" id="nome" name="nome"/></td>
                    </tr>
                    <tr>
                        <th><label for="login">usuario</label></th>
                        <td><input type="text" id="login" name="login"></td>
                    </tr>
                    <tr>
                        <th><label for="senha">Senha</label></th>
                        <td><input type="password" id="senha" name="senha"></td>
                    </tr>


                </table>
            
            </form>
        </div>
                  
                    
        
    
    </body>




</html>