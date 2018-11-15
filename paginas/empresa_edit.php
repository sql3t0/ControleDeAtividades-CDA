<!DOCTYPE html>
<html>
<head>
	<title>Editar Empresa</title>
	<link rel="stylesheet" type="text/css" href="../css/empresa.css" />
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min_4.0.css" />

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
	<form method="GET" action="tarefa_view_2.php" >
		<div class="form-group">
			<div class="container-fluid">
				<div class="row">
					<div class="col" id="inp_nome_edit">
						<label >Nome</label>
						<input type="text" class="form-control" id="inp_nome_edit_" name="nome" placeholder="Nome da Empresa" value="<?php echo $_GET['nome']; ?>" required="true" />
					</div>
					<div class="col" id="inp_codigoFortes_edit">
						<label >Código Fortes</label>
						<input type="text" class="form-control" id="inp_codigoFortes_edit_" name="cod_fortes" placeholder="Codigo da Empresa na Fortes" value="<?php echo $_GET['cod_fortes']; ?>" required="true" />
					</div>
				</div>
				<div class="row">
					<?php
						include("conexao.php");
						if(!empty($_GET['id']) && !empty($_GET['nome']) && !empty($_GET['cod_fortes'])){
							$id = $_GET['id'];
							$nome = $_GET['nome'];
							$cod_fortes = $_GET['cod_fortes'];
							echo '<input  type="hidden" name="id" value="'.$id.'" />';
						}else{
							echo '<div class="row"><div class="col"><h3 style="color:red">Faltam Parametros necassarios !</h3></div></div>';
						}
					?>
					<input  type="hidden" name="tabela" value="empresa" />
					<button type="submit" value="atualizar" id="bt_atulizar_empresa" name="acao" class="btn btn-primary box3D">Alterar</button>
				</div>
			</div>
		</div>
	</form>
</body>
</html>