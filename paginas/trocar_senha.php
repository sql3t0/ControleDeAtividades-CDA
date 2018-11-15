<!DOCTYPE html>
<html>
<head>
	<title>Trocar Senha</title>
	<link rel="stylesheet" type="text/css" href="../css/usuario.css" />
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min_4.0.css" />

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
	<form method="GET" action="tarefa_view_2.php" >
		<div class="form-group">
			<div class="container-fluid">
				<div class="row">
					<div class="col" id="inp_senha">
						<label >Nova Senha</label>
						<input type="password" class="form-control" id="inp_senha_" name="senha" placeholder="Senha do Usuario" required="true" />
					</div>
					<div class="col" id="inp_confirm_senha">
						<label >Confimar</label>
						<input type="password" class="form-control" id="inp_confirm_senha_" placeholder="Confimar Senha" required="true" />
					</div>
				</div>
				<div class="row">
					<?php
						include("conexao.php");
						if(!empty($_GET['id'])){
							$id = $_GET['id'];
							echo '<input  type="hidden" name="id" value="'.$id.'" />';
						}else{
							echo '<div class="row"><div class="col"><h3 style="color:red">Parametro ID necassario !</h3></div></div>';
						}
					?>
					<input  type="hidden" name="tabela" value="usuario" />
					<button type="submit" value="atualizar" id="bt_atulizar_senha" name="acao" class="btn btn-primary box3D">Alterar</button>
				</div>
			</div>
		</div>
	</form>

	<script type="text/javascript">
		var password = document.getElementById("inp_senha_") , confirm_password = document.getElementById("inp_confirm_senha_");

		function validatePassword(){
			if(password.value != confirm_password.value) {
				confirm_password.setCustomValidity("Senhas diferentes!");
			} else {
				confirm_password.setCustomValidity('');
			}
		}

		inp_senha.onchange = validatePassword;
		inp_confirm_senha.onkeyup = validatePassword;
	</script>
</body>
</html>