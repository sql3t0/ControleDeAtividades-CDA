<?php
	#Inclui o arquivo com o sistema de segurança
	include("../seguranca.php"); 
	#chama o arquivo de configuração com o banco
	require 'conexao.php';
	if($_SESSION){
		$setor = $_SESSION['usuarioSetor'];
	}else{
		echo "<meta http-equiv=\"refresh\" content=\"0; url=../login.php\" />";
	}
	if($_GET){
		$nome      = $_GET['usr_nome'];//nome do usuario a ser gerado o relatorio
		$empresa   = $_GET['cod_fortes'];//codigo_de_empresa_especifica ou all 
		$dt_ini    = $_GET['dt_ini'];
		$dt_fim    = $_GET['dt_fim'];
	}else{
		$nome      = "Nome do Usuario...";//nome do usuario a ser gerado o relatorio
		$empresa   = "Nome da Empresa...";//codigo_de_empresa_especifica ou all 
		$dt_ini    = date('Y-m-d');
		$dt_fim    = date('Y-m-d');
	}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Relatorio de Atividades</title>
	<link rel="stylesheet" type="text/css" href="../css/relatorio.css" />
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min_4.0.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body style="background-color: #32383e;">
	<div id="area_impressao">
	<table class="table table-striped table-inverse" id="minhaTabela" >
		<thead class="thead-inverse">
			<tr >
				<th>Gerado:</th>
				<th><?php echo date('d/m/Y');?></th>
				<th></th>
				<th></th>
				<th>Periodo:</th>
				<th><?php echo date('d/m/Y', strtotime($dt_ini)) ; ?></th>
				<th> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a </th>
				<th><?php echo date('d/m/Y', strtotime($dt_fim)) ;?></th>  
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th class="tb_cabecalho">Usuario</th>
				<th class="tb_cabecalho">Empresa</th>
				<th class="tb_cabecalho">Competencia</th>
				<th class="tb_cabecalho">Tarefa</th>
				<th class="tb_cabecalho">Data Ini.</th>
				<th class="tb_cabecalho">Data Play</th>
				<th class="tb_cabecalho">Hora Play</th>
				<th class="tb_cabecalho">Data fin.</th>
				<th class="tb_cabecalho">Hora Stop</th>
				<th class="tb_cabecalho border_columns" id="th_borderRight">Duração</th>
				<?php
				if($nome != "Nome do Usuario..."){
					if($empresa == "Todas"){//select c/ todas as empresas
						if($nome == "Todos"){
							$resTarefa = mysqli_query($con,"select id,atividade,data_ini,data_fim,empresa,usuario,data_play,hora_play,hora_stop,competencia from tarefa where status = '1' AND data_fim BETWEEN ('$dt_ini') AND ('$dt_fim') order by usuario");
						}else{
							$resTarefa = mysqli_query($con,"select id,atividade,data_ini,data_fim,empresa,usuario,data_play,hora_play,hora_stop,competencia from tarefa where usuario = '$nome' AND status = '1' AND data_fim BETWEEN ('$dt_ini') AND ('$dt_fim') order by empresa");
						}
					}else{//select c/ empresa especifica
						if($nome == "Todos"){
							$resTarefa = mysqli_query($con,"select id,atividade,data_ini,data_fim,empresa,usuario,data_play,hora_play,hora_stop,competencia from tarefa where empresa = (select nome from empresa where cod_fortes = '$empresa') AND status = '1' AND data_fim BETWEEN ('$dt_ini') AND ('$dt_fim') order by usuario");
						}else{
							$resTarefa = mysqli_query($con,"select id,atividade,data_ini,data_fim,empresa,usuario,data_play,hora_play,hora_stop,competencia from tarefa where usuario = '$nome' and empresa = (select nome from empresa where cod_fortes = '$empresa') AND status = '1' AND data_fim BETWEEN ('$dt_ini') AND ('$dt_fim') order by id");
						}
					}
					  
					$total = mysqli_num_rows($resTarefa);
					$empresaanterior="";
					$usuarioanterior="";
					if ($total > 0){
						for($i=0; $i<$total; $i++){
							$dados = mysqli_fetch_row($resTarefa);
							$id 	     = $dados[0];
							$atividade   = $dados[1];
							$dtIni       = date('d/m/Y', strtotime($dados[2]));
							$dtFim       = date('d/m/Y', strtotime($dados[3]));
							$empresa     = $dados[4];
							$usuario     = strtoupper($dados[5]);
							$data_play   = date('d/m/Y', strtotime($dados[6]));
							$hora_play   = $dados[7];
							$hora_stop   = $dados[8];
							$competencia = $dados[9];

							$resTimer   = mysqli_query($con,"select time from timer where id = '$id'");
							$dadosTimer = mysqli_fetch_row($resTimer);
							$time	    = $dadosTimer[0];
							$horas = sprintf( '%d', $time/3600 );
					        $minutos = sprintf( '%d', $time/60%60 );
					        if($horas < 10){
					            $horas = "0".$horas;
					        }
					        if($minutos < 10){
					            $minutos = "0".$minutos;
					        }

					        $new_time = $horas.":".$minutos;
        

							echo "<tr>";
							if($usuario != $usuarioanterior){
								echo "<td><strong><b>$usuario</b></strong></td>";
								echo "<td><strong><b>$empresa</b></strong></td>";
							}else{
								echo "<td style=\"border:solid 0px transparent;\"></td>";
								if($empresa != $empresaanterior){
									echo "<td><strong><b>$empresa</b></strong></td>";
								}else{
									echo "<td style=\"border:solid 0px transparent;\"></td>";
								}
							} 
							$usuarioanterior = $usuario;
							$empresaanterior = $empresa;

							echo "<td>$competencia</td>";
							echo "<td>$atividade</td>";
							echo "<td>$dtIni</td>";
							echo "<td>$data_play</td>";
							echo "<td>$hora_play</td>";
							echo "<td>$dtFim</td>";
							echo "<td>$hora_stop</td>";
							echo "<td>$new_time</td>";
							echo "</tr>";
						}
					}else{
						//caso nao haja nenhum registro de tarefa cadastrada no banco 
						echo "<tr><td></td><td></td><td align=\"center\" >Nenhum registro Encontrado para o periodo !</td><td align=\"center\"></td> <td><img src=\"..\imagens\_empty.png\" alt=\"Nenhum registro de Tarefa\" /> </td></tr>";
					}
				}
				?>
			</tr>
		</tbody>
	</table>
</div>

	<script src="../js/jquery-3.2.1.slim.min.js" ></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min_4.0.js"></script>
</body>
</html>