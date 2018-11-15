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
						<input type="text" class="form-control" id="inp_nome_edit_" name="nome" placeholder="Nome da Empresa" required="true" />
					</div>
				</div>
				<div class="row">
					<div class="col" id="inp_codigoFortes_edit">
						<label >Código Fortes</label>
						<input type="text" class="form-control" id="inp_codigoFortes_edit_" name="cod_fortes" placeholder="Codigo da Empresa na Fortes" maxlength="4" required="true" />
					</div>
				</div>
				<div class="row">
					<input  type="hidden" name="tabela" value="empresa" />
					<button type="submit" value="cadastrar" id="bt_cadastrar_empresa" name="acao" class="btn btn-primary box3D" >Salvar</button>
				</div>
			</div>
		</div>
	</form>
</body>
</html>