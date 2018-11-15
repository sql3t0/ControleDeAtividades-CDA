<?php
	include("../seguranca.php"); // Inclui o arquivo com o sistema de segurança
	protegePagina(); // Chama a função que protege a página
	include("conexao.php");
	include("timer.php");
	$username = $_SESSION['usuarioNome'];
	$nivel 	  = $_SESSION['usuarioNivel'];
	$setor    = $_SESSION['usuarioSetor'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Visualizar Tarefas</title>
	<link rel="stylesheet" type="text/css" href="../css/tarefa_view.css" />
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min_4.0.css" />

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script type="text/javascript" src="../js/bibliotecaAjax.js"></script>
</head>
<body>
	<div id="avisos">
		<div class="form-group" id="form_id">
			<div class="container-fluid"  >
					<?php if($_SESSION['usuarioNivel'] == 2){?>
						<div class="row" id="container_fluid">
							<div class="col-12">
								<!-- Button trigger modal -->
								<button type="button" id="bt_criar_tarefa" class="btn btn-primary bt_criar_tarefa box3D" data-toggle="modal" data-target="#exampleModal">
									<img src="..\imagens\add.png" alt="Nova Tarefa" />   Nova Tarefa
								</button>

								<!-- Modal -->
								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header ">
												<h5 class="modal-title" id="exampleModalLabel">Criar Nova Tarefa</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												Deseja criar uma nova Tarefa ? 
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancela</button>
												<a href="tarefa_add.php"><button type="button" class="btn btn-primary">Criar Nova</button></a>
											</div>
										</div>
									</div>
								</div>
							</div>
					</div>
				<?php } ?>

				<div class="row">
					<!--box geral-->
					<div class="col-12" style="margin-top:-10px">
						<form name="formulario" class="form-group">
							<table class="table table-striped table-inverse" id="minhaTabela">
								<thead class="thead-inverse">   
									<tr id="tr_filtro">
										<th><img src="../imagens/filter.png" title="Filtros de Pesquisa" /></th>
										<th><input type="text" class="form-control th_filtro" placeholder="Nome" aria-label="Nome" id="txtColuna1"/></th>
										<th class="th_filtro" style="display:none;"></th>
										<th><input type="text" class="form-control th_filtro" placeholder="Empresa" aria-label="Empresa" id="txtColuna3"/></th>
										<th><input type="text" class="form-control th_filtro" placeholder="Atividade" aria-label="Atividade" id="txtColuna4"/></th>
										<th><input type="text" class="form-control th_filtro" placeholder="Data Ini" aria-label="Data inicio" id="txtColuna5"/></th>
										<th><input type="text" class="form-control th_filtro" placeholder="Data Fim" aria-label="Data fim" id="txtColuna6"/></th>
										<th><input type="text" class="form-control th_filtro" placeholder="Obs" aria-label="Observacao" id="txtColuna7"/></th>
										<th><img src="../imagens/filter.png" title="Filtros de Pesquisa" /></th>
									</tr>
									<tr>
										<th id="codigo" class="tb_cabecalho" style="display:none;" ><strong>Codigo</strong></th>
										<th id="usuario" class="tb_cabecalho"><strong>Nome</strong></th>  
										<th id="setor" class="tb_cabecalho"><strong>Setor</strong></th>
										<th id="empresa" class="tb_cabecalho"><strong>Empresa</strong></th>
										<th id="atividade" class="tb_cabecalho"><strong>Atividade</strong></th>
										<th id="data_ini" class="tb_cabecalho"><strong>Data de inicio</strong></th>
										<th id="data_fim" class="tb_cabecalho"><strong>Data de Finalizacao</strong></th>
										<th id="obs" class="tb_cabecalho"><strong>Observacao</strong></th>
										<th id="iniciar" class="tb_cabecalho"></th>
										<th id="excluir" class="tb_cabecalho"></th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($nivel == 2){//eh admin
										$res = mysqli_query($con,"select * from tarefa where setor = '$setor' AND status = '0' order by id desc LIMIT 300");
									}else{//comun user
										$res = mysqli_query($con,"select * from tarefa where setor = '$setor' and usuario = '$username' AND status = '0' order by id desc LIMIT 300");
									}
									  
									$total = mysqli_num_rows($res);
									$data = geraDataInv();

									$init_time_task = 0; //controla a incialização automatica da cronometragem de tempo da tarefa em linha de sucessao
									if ($total > 0){
										for($i=0; $i<$total; $i++){
											$dados = mysqli_fetch_row($res);
											$codigo = $dados[0];
											$usuario = $dados[1]; 
											$setor = $dados[2];
											$empresa = $dados[3];
											$atividade = $dados[4];
											$data_ini = date('d/m/Y', strtotime($dados[5]));
											$data_fim = $dados[6];
											$obs = $dados[7];
											$status = $dados[8];
											$status_time = $dados[9];

											$idLinha = "linha$i";

											echo '<tr scope="row" id="'.$idLinha.'" class="box3D_tr" >';
											echo '<td style="display:none;">'.$codigo.'</td>';
											echo "<td class=\"tr_font\">$usuario</td>";
											echo "<td class=\"tr_font\">$setor</td>";
											echo "<td class=\"tr_font\">$empresa</td>";
											echo "<td class=\"tr_font\">$atividade</td>";
											echo "<td class=\"tr_font\">$data_ini</td>";
											echo "<td class=\"tr_font\">$data_fim</td>";
											echo "<td class=\"tr_font\">$obs</td>";

											if($_SESSION['usuarioNivel'] == 2){
												if($status_time == 0){
													echo "<td ><button type=\"button\" id=\"bt_modal_$idLinha\" class=\"btn btn-primary box3D \" data-toggle=\"modal\" data-target=\"#exampleModal_$idLinha\" title=\"Excluir Tarefa\" ><img src=\"..\imagens\delete.png\" alt=\" Excluir Tarefa\" /></button><div class=\"modal fade\" id=\"exampleModal_$idLinha\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\"> <div class=\"modal-dialog\" role=\"document\"> <div class=\"modal-content bt_excluir\"> <div class=\"modal-header\"> <h5 class=\"modal-title\" id=\"exampleModalLabel\">Excluir item</h5> <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"> <span aria-hidden=\"true\">&times;</span> </button> </div> <div class=\"modal-body\"> Deseja excluir o item ? </div> <div class=\"modal-footer\"> <button type=\"button\" class=\"btn btn-secondary box3D\" data-dismiss=\"modal\" >Cancelar</button> <button type=\"button\" id=\"bt_excluir_$idLinha\" class=\"btn btn-secondary box3D bg_bt_excluir\" data-dismiss=\"modal\" onclick=\"ExcluirLinha('$idLinha', '$codigo','tarefa');\" >Excluir</button> </div> </div> </div> </div></td>";
												}else{
													if($status == 0 ){
														echo "<td ><button type=\"button\" id=\"bt_modal_$idLinha\" class=\"btn btn-primary box3D \" data-toggle=\"modal\" data-target=\"#exampleModal_$idLinha\" title=\" Tarefa em Andamento\" disabled> <img src=\"..\imagens\started.png\" alt=\"Tarefa em Andamento\" />  </button>";
													}else{
														echo "<td ><button type=\"button\" id=\"bt_modal_$idLinha\" class=\"btn btn-primary box3D \" data-toggle=\"modal\" data-target=\"#exampleModal_$idLinha\" title=\" Tarefa Finalizada\" disabled> <img src=\"..\imagens\check.png\" alt=\" Tarefa Finalizada\" />  </button>";
													}
												}
													
											}else{
												if($status == 0 ){
													if($status_time == 0){
														echo "<td ><button type=\"button\" id=\"bt_modal_$idLinha\" class=\"btn btn-primary box3D \" data-toggle=\"modal\" data-target=\"#modal_start_time_$idLinha\" title=\" Iniciar Tarefa\" > <img src=\"..\imagens\play.png\" alt=\" Iniciar Tarefa\" /> </button><div class=\"modal fade\" id=\"modal_start_time_$idLinha\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\"> <div class=\"modal-dialog\" role=\"document\"> <div class=\"modal-content bt_excluir\"> <div class=\"modal-header\"> <h5 class=\"modal-title\" id=\"exampleModalLabel\">Iniciar Tarefa</h5> <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"> <span aria-hidden=\"true\">&times;</span> </button> </div> <div class=\"modal-body\"> Deseja Iniciar essa Tarefa ? </div> <div class=\"modal-footer\"> <button type=\"button\" class=\"btn btn-secondary box3D\" data-dismiss=\"modal\" >Cancelar</button> <button type=\"button\" id=\"bt_start_time_$idLinha\" class=\"btn btn-secondary box3D bg_bt_excluir\" data-dismiss=\"modal\" onclick=\"ControlTimer('start_timer',$codigo,'$usuario');\">Iniciar</button> </div> </div> </div> </div></td>";
													}else{
														//desativa o botao de IniciarTarefa
														echo "<td ><button type=\"button\" id=\"bt_modal_$idLinha\" class=\"btn btn-primary box3D \" data-toggle=\"modal\" data-target=\"#modal_start_time_$idLinha\" title=\" Tarefa Iniciada...\" disabled> <img src=\"..\imagens\started.png\" alt=\"Tarefa em Andamento\" /> </button>";

														echo "<td ><button type=\"button\" id=\"bt_modal_$idLinha\" class=\"btn btn-primary box3D \" data-toggle=\"modal\" data-target=\"#exampleModal_$idLinha\" title=\" Finalizar Tarefa\" > <img src=\"..\imagens\stop.png\" alt=\"Finalizar Tarefa\" /> </button><div class=\"modal fade\" id=\"exampleModal_$idLinha\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\"> <div class=\"modal-dialog\" role=\"document\"> <div class=\"modal-content bt_excluir\"> <div class=\"modal-header\"> <h5 class=\"modal-title\" id=\"exampleModalLabel\">Finalizar Tarefa</h5> <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"> <span aria-hidden=\"true\">&times;</span> </button> </div> <div class=\"modal-body\"> Deseja Finalizar essa Tarefa ? </div> <div class=\"modal-footer\"> <button type=\"button\" class=\"btn btn-secondary box3D\" data-dismiss=\"modal\" >Cancelar</button> <button type=\"button\" id=\"bt_excluir_$idLinha\" class=\"btn btn-secondary box3D bg_bt_excluir\" data-dismiss=\"modal\" onclick=\"FinalizarTarefa('$idLinha', '$codigo','tarefa','$data');ControlTimer('save_time',$codigo,'$usuario');\" >Finalizar</button> </div> </div> </div> </div></td>";
													}
													

												}else{
													echo "<td ><button type=\"button\" id=\"bt_modal_$idLinha\" class=\"btn btn-primary box3D \" data-toggle=\"modal\" data-target=\"#exampleModal_$idLinha\" title=\" Tarefa Finalizada\" disabled> <img src=\"..\imagens\check.png\" alt=\" Tarefa Finalizada\" />  </button>";
												}
											}

										}
									}else{
										//caso nao haja nenhum registro de tarefa cadastrada no banco 
										echo "<tr><td></td><td></td><td></td><td align=\"center\" >Nenhum registro de Tarefa Encontrado</td><td align=\"center\"> <img src=\"..\imagens\_empty.png\" alt=\"Nenhum registro de Tarefa\" /> </td><td></td><td></td><td></td><td></td></tr>";
									}
									echo "</tr>";
									?>
								</tbody>
							</table>
						</form>
					</div>
				</div>

			</div>
		</div> 	
	</div>
	<script src="../js/jquery-3.2.1.slim.min.js" ></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min_4.0.js"></script>
	<script src="../js/filtro.js"></script>
</body>
</html>