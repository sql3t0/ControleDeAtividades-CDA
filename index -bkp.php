<?php
	include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
	protegePagina(); // Chama a função que protege a página
	$nivel = $_SESSION['usuarioNivel'];
?>
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
	<div class="container-fluid ">
		<div class="row">
			<div class="container container_black_trans" id="topo">
				<div class="row">
					<div class="col-md-2">
						<img src="imagens/logo2.png" class="img-responsive imgLogo" alt="Imagem responsiva">
					</div>
					<div class="col">
						<div id="nome">
							Controle de Atividades
						</div>
					</div>
					<div class="col">
						<div id="user">
							<p><?php echo $_SESSION['usuarioNome'];?><br>
							   <?php echo geraData(); ?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="container">
				<div class="row">
					<div class="col-2">
						<div class="container_black_trans" id="menu">
							<a href="">
								<img src="imagens/home.png" class="img-responsive imgHome box3D" alt="Imagem responsiva">
							</a>
							<?php 
								if($_SESSION['usuarioNivel'] == 2){ ?>
								<a href="paginas/Usuario.php" target="frame_central"><button id="botoes" class="btn btn-default botoes box3D" type="submit" title="Gerenciar Usuarios" ><img style="float: left;" src="imagens/add_user.png"/>Usuarios</button></a><br>
								<a href="paginas/empresa.php" target="frame_central"><button id="botoes" class="btn btn-default botoes box3D" type="submit" title="Gerenciar Empresas" ><img style="float: left;" src="imagens/empire.png"/>Empresas</button></a><br>
								<a href="paginas/atividade.php" target="frame_central"><button id="botoes" class="btn btn-default botoes box3D" type="submit" title="Gerenciar Atividades" ><img style="float: left;" src="imagens/activity_arrows.png"/>Atividades</button></a><br>
								<a href="paginas/tarefa_view.php" target="frame_central"><button id="botoes" class="btn btn-default botoes box3D" type="submit" title="Tarefas em Aberto" ><img style="float: left;" src="imagens/opened_task.png"/>Tarefas</button></a>
								<a href="paginas/tarefa_finalizada.php" target="frame_central"><button id="botoes" class="btn btn-default botoes box3D" type="submit" title="Tarefas Finalizadas" ><img style="float: left;" src="imagens/closed_task.png"/>Tarefas</button></a>
								<a href="paginas/relatorio.php" target="frame_central"><button id="botoes" class="btn btn-default botoes box3D" type="submit" title="Gerenciar Relatorios" ><img style="float: left;" src="imagens/report.png"/>Relatorio</button></a>
								<?php }else{ ?>
												<a href="paginas/tarefa_view.php" target="frame_central"><button id="botoes" class="btn btn-default botoes box3D" type="submit" title="Tarefas em Aberto"><img style="float: left;" src="imagens/opened_task.png"/>Tarefas</button></a>
												<a href="paginas/tarefa_finalizada.php" target="frame_central"><button id="botoes" class="btn btn-default botoes box3D" type="submit" title="Tarefas Finalizadas" ><img style="float: left;" src="imagens/closed_task.png"/>Tarefas</button></a>
									  <?php }?>	
							<?php
							 	if($nivel == 2){ ?>
									<a href="logout.php">
										<img src="imagens/exit.png" class="img-responsive imgExitAdm box3D" alt="Imagem responsiva">
									</a>
								<?php
								}else{ ?>
									<a href="logout.php">
										<img src="imagens/exit.png" class="img-responsive imgExit box3D" alt="Imagem responsiva">
									</a>
								<?php	
								}
							?>
						</div>
					</div>
					<div class="col-10 box3D" id="campo">
						<iframe width="100%" height="100%" style="border-radius: 5px;background-color: transparent;" src="paginas/tarefa_view.php" frameborder="0" name="frame_central" ></iframe>
					</div>
				</div>
			</div>
		</div>

		<div class="container container_black_trans" id="rodape">
			<spam style="color:red">Helço Sales Contabilidade</spam>	
		</div>
	</div>
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/bibliotecaAjax.js"></script>
</body>
</html>