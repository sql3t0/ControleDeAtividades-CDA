<?php
	#Inclui o arquivo com o sistema de segurança
	include("../seguranca.php"); 
	#chama o arquivo de configuração com o banco
	require 'conexao.php';
	if($_SESSION){
		if($_SESSION['usuarioNivel'] == 2){
			$setor = $_SESSION['usuarioSetor'];
		}else{
			echo "<meta http-equiv=\"refresh\" content=\"0; url=../login.php\" />";
		}
	}else{
		echo "<meta http-equiv=\"refresh\" content=\"0; url=../login.php\" />";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Adicionar Tarefa</title>
	<link rel="stylesheet" type="text/css" href="../css/relatorio.css" />
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min_4.0.css" />

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

</head>
<body>
	<div class="container-fluid">
		<form method="GET" action="gera_relatorio.php">
			<div class="row" id="row1">
				<div class="col-3">
					<div id="nome_usuario">
						<label id="lb_usuario">Usuário :</label>
						<!--Select de Nome-->
						<select id="sel_usuario" class="form-control box3D" name="usr_nome">
							<option value="Nenhum usuario selecionado !" style="color:red">Selecione...</option>
							<option value="Todos" style="color:#0069d9">Todos</option>
							<?php 
							//cria as opcoes da TAG <select> com dados do DB  
							 #seleciona os dados da tabela usuario
							$res = mysqli_query($con,"SELECT id, nome FROM usuario where setor = '$setor'");
							$total = mysqli_num_rows($res);

							for($i=0; $i<$total; $i++){
								$dados = mysqli_fetch_row($res);
								$id = $dados[0];
								$nome = $dados[1];
								$setor = $dados[2]; 
								echo "<option value=\"$nome\">$nome</option>";
							} 
							?>
						</select>
					</div>
					<div id="nome_empresa">
						<label id="lb_empresa">Empresa :</label><br/>
						<!--Select de Empresa-->
						<select id="sel_empresa" class="form-control box3D" name="cod_fortes">
							<option value="Nenhuma Empresa selecionada !" style="color:red">Selecione...</option>
							<option value="Todas" style="color:#0069d9">Todas</option>
							<?php 
							//cria as opcoes da TAG <select> com dados do DB  
							 #seleciona os dados da tabela empresa
							$res = mysqli_query($con,"SELECT id, nome, cod_fortes FROM empresa");
							$total = mysqli_num_rows($res);

							for($i=0; $i<$total; $i++){
								$dados = mysqli_fetch_row($res);
								$id = $dados[0];
								$nome = $dados[1];
								$cod_fortes = $dados[2]; 
								echo "<option value=\"$cod_fortes\">$nome [$cod_fortes]</option>";
							} 
							?>
						</select>
					</div>
					<div id="data_inicial">
						<label id="lb_data_ini">Data de Início :</label><br/>
						<input type="date" name="dt_ini" id="dt_ini" class="form-control box3D" value="<?php echo date('Y-m-d'); ?>" />
					</div>
					<div class="data_termino">
						<label id="lb_data_fim">Data de Término :</label><br/>
						<input type="date" name="dt_fim" id="dt_fim" class="form-control box3D" value="<?php echo date('Y-m-d'); ?>" /><br/>
					</div>
					<div id="bt_select">
						<button type="submit" value="relatorio" id="bt_relatorio" name="acao" class="btn btn-primary box3D" formtarget="frame_relatorio">
							Gerar
						</button>
					</div><br/>
					<div id="bt_imprimir">
						<button type="button" id="bt_imprimir" class="btn btn-primary box3D" style="float: right;" title="Imprimir" onclick="window.parent.frame_central.frame_relatorio.print();">
							<img src="..\imagens\printer.png" alt="Imprimir" />
						</button>
					</div>
				</div>
				<div class="col-9" id="frame_principal">
					<iframe src="gera_relatorio.php" id="frame_relatorio" name="frame_relatorio"></iframe>
				</div>
			</div>
		</form>
	</div>

	<script src="../js/jquery-3.2.1.slim.min.js" ></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min_4.0.js"></script>
</body>
</html>