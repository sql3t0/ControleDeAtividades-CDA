<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Controle de Atividades</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="shortcut icon" href="imagens/icon.png">
</head>
<body>
	
	<div class="container">
		<div class="login-container">
            <div id="output"></div>
            <div id="avatar">
            	<img src="imagens/logo2.png" style="vertical-align: 35px;">
            </div>
            <div id="login" class="form-box">
                <form method="post" action="valida.php">
                    <input name="usuario" type="text" placeholder="Usuário" required="true" class="box3D" />
                    <input name="senha" type="password" placeholder="Senha" required="true" class="box3D" />
                    <button id="login" class="btn btn-info btn-block login box3D" type="submit" value="Entrar">Logar</button>
                </form>
            </div>
        </div>
	</div>

	<script src="js/jquery.js"/>
	<script src="js/bootstrap.js"/>
</body>
</html>