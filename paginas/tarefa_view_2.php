<?php
$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT");
header("Last-Modified: {$gmtDate} GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-Type: text/html; charset=ISO-8859-1");

include("conexao.php");
include("timer.php");

extract($_GET, EXTR_PREFIX_ALL, 'g');
extract($_POST, EXTR_PREFIX_ALL, 'g');

/* 
 * FUNCAO PARA EVITAR A CRICAO DE DADOS DUPLICADOS 
 */

function evitaDuplicidade($tabela,$campoComparativo,$valorComparativo){
	include("conexao.php");
	$res = mysqli_query($con,"select $campoComparativo from $tabela where $campoComparativo = '$valorComparativo'");  
	if(mysqli_num_rows($res) > 0){
		return "exist";
	}else{
		return "cadastrar";
	}
}

 //-----------------------------------------------

// Atualização do produto
if($_GET['acao'] == 'atualizar'){
	if(!empty($_GET['tabela'])){
		$tabela = $_GET['tabela'];

		if($_GET['tabela'] == 'usuario'){
			if(!empty($_GET['id']) && !empty($_GET['senha'])){
				if(is_numeric($_GET['id'])){
					$sql = "update $tabela set senha = '".$_GET['senha']."' where id = '".$_GET['id']."'";
					$res2 = mysqli_query($con,$sql);
					echo '<div class="container-fluid"><div class="row"><div class="col"><h2 style="color:red" align="center">Alteracao realizada com Sucesso !</h2></div></div></div>';

				}else{
					echo "Parametro ID invalido !";
				}
			}else{
				echo "Faltam Parametros para concluir a Atualizacao !";
			}
		}

		if($_GET['tabela'] == 'empresa'){
			if(!empty($_GET['id']) && !empty($_GET['nome']) && !empty($_GET['cod_fortes'])){
				if(is_numeric($_GET['id'])){
					$sql = "update $tabela set nome = '".$_GET['nome']."', cod_fortes = '".$_GET['cod_fortes']."' where id = '".$_GET['id']."'";
					$res2 = mysqli_query($con,$sql);
					echo '<div class="container-fluid"><div class="row"><div class="col"><h2 style="color:red" align="center">Alteracao realizada com Sucesso !</h2></div></div></div>';

				}else{
					echo "Parametro ID invalido !";
				}
			}else{
				echo "Faltam Parametros para concluir a Atualizacao !";
			}
		}

		if($_GET['tabela'] == 'atividade'){
			if(!empty($_GET['id']) && !empty($_GET['descricao']) && !empty($_GET['setor'])){
				if(is_numeric($_GET['id'])){
					$sql = "update $tabela set descricao = '".$_GET['descricao']."', setor = '".$_GET['setor']."' where id = '".$_GET['id']."'";
					$res2 = mysqli_query($con,$sql);
					echo '<div class="container-fluid"><div class="row"><div class="col"><h2 style="color:red" align="center">Alteracao realizada com Sucesso !</h2></div></div></div>';

				}else{
					echo "Parametro ID invalido !";
				}
			}else{
				echo "Faltam Parametros para concluir a Atualizacao !";
			}
		}
		if($_GET['tabela'] == 'tarefa'){
			if(!empty($_GET['id']) && !empty($_GET['data_fim'])){
				if(is_numeric($_GET['id'])){
					$sql = "update $tabela set status = '1',data_fim = '".$_GET['data_fim']."' where id = '".$_GET['id']."'";
					$res2 = mysqli_query($con,$sql);
					echo '4';
				}else{
					echo "Parametro ID invalido !";
				}
			}else{
				echo "Faltam Parâmetros para concluir a Atualização !";
			}
		}

	}else{
		echo "Parâmetro [TABELA] Necessário !";
	}
	
}
// exclusão de dados
elseif($_GET['acao'] == 'excluir'){
	if(!empty($_GET['tabela']) ){
		$tabela = $_GET['tabela'];		
		$sql = "delete from $tabela where id = '".$_GET['cod']."' ";
		$res = mysqli_query($con,$sql);
		echo '2';
		//retorna a mensagem de confirmação de Exclusao
	}
}
// reabrir tarefa
elseif($_GET['acao'] == 'reabrirTarefa'){
	if(!empty($_GET['tabela']) && !empty($_GET['id']) ){
		$tabela = $_GET['tabela'];		
		$sql = "update $tabela set status = '0' where id = '".$_GET['id']."'";
		$res = mysqli_query($con,$sql);

		// Pega a data/hora atual
        $date = new DateTime("now", new DateTimeZone('America/Fortaleza') ); //SET YOUR DATETIMEZONE
        $time_stamp =  $date->format('Y/m/d H:i:s');
		//sql p/ recriar nova linha na tabela de time_stamps
        $time_stamp = strtotime($time_stamp);
        $sql = "INSERT INTO time_stamps VALUES ('".$_GET['id']."', '{$time_stamp}')";
        $result = $conn->query($sql);
		echo '1';
		//retorna a mensagem de confirmação de reabertura
	}
}
// controle do timer
elseif($_GET['acao'] == 'timer'){
	if(!empty($_GET['opt']) && !empty($_GET['id']) && !empty($_GET['nome']) ){
		$opt = $_GET['opt'];
		$id = $_GET['id'];
		$nome = $_GET['nome'];

		$status = ControlTimer($opt,$id,$nome);

		if ($status == "iniciado"){
			echo "5";
		 	date_default_timezone_set('America/Fortaleza');
	 		$data_play = date('Y-m-d');
			$hora_play = date('h:i:sa');
			$sql = "update tarefa set data_play = '".$data_play."',hora_play = '".$hora_play."' where id = $id";
			$res = mysqli_query($con,$sql);
		}elseif($status == "encerrado"){
			echo "4";
			date_default_timezone_set('America/Fortaleza');
			$hora_stop = date('h:i:sa');
			$sql = "update tarefa set hora_stop = '".$hora_stop."' where id = '".$_GET['id']."'";
			$res = mysqli_query($con,$sql);
		}elseif($status == "reiniciado"){
			echo "7";
		}elseif($status == "pausado"){
			echo "8";
		}else{
			echo "6";
		}
	}
}
// Cadastro de produtos
elseif($_GET['acao'] == 'cadastrar'){
	if(!empty($_GET['tabela'])){
		if($_GET['tabela'] == 'tarefa'){
			if(!empty($_GET['usuario']) && !empty($_GET['setor']) && !empty($_GET['empresa']) && !empty($_GET['atividade']) && !empty($_GET['data_ini'])){
				if($_GET['atividade'] == "Arquivo Recebido"){
					$subTarefas = array("Organizar Z","DCTF","SPED Contribuicao","SPED Fiscal","Impostos","Edicao","Importacao");
					for($i=0;$i < count($subTarefas);$i++){
						$sql = "insert into tarefa (usuario, setor, empresa, atividade, data_ini,obs,status,competencia) values ('".$_GET['usuario']."','".$_GET['setor']."','".$_GET['empresa']."','".$subTarefas[$i]."','".$_GET['data_ini']."','".$_GET['obs']."','0','".$_GET['competencia']."')";
						$res2 = mysqli_query($con,$sql);
						$novo_codigo = mysqli_insert_id($con);
					}
					//retorna a mensagem de confirmação de cadasro da tarefa
					echo "<script>alert(\"Cadastro Realizado Com Sucesso !\");window.history.back();</script>";	
				}else{
					$sql = "insert into tarefa (usuario, setor, empresa, atividade, data_ini,obs,status,competencia) values ('".$_GET['usuario']."','".$_GET['setor']."','".$_GET['empresa']."','".$_GET['atividade']."','".$_GET['data_ini']."','".$_GET['obs']."','0','".$_GET['competencia']."')";
					$res2 = mysqli_query($con,$sql);
					$novo_codigo = mysqli_insert_id($con);

					//retorna a mensagem de confirmação de cadasro da tarefa
					echo "<script>alert(\"Cadastro Realizado Com Sucesso !\");window.history.back();</script>";
				}
			}else{
				echo "<script>alert(\"Você deve preencher todos os campos !\");window.history.back();</script>";
			}
		}elseif($_GET['tabela'] == 'usuario'){
			if(!empty($_GET['nome']) && !empty($_GET['senha']) && !empty($_GET['setor']) && !empty($_GET['nivel'])){
				$ok = evitaDuplicidade($_GET['tabela'],'nome',$_GET['nome']);
				if($ok == "exist"){
					echo "<script>alert(\"Nome de Usuario já cadastrado no banco !\");window.location=\"usuario.php\";</script>";
				}else{
					$sql = "insert into usuario (nome, senha, setor, nivel) values ('".$_GET['nome']."','".$_GET['senha']."','".$_GET['setor']."','".$_GET['nivel']."')";
					$res2 = mysqli_query($con,$sql);
					$novo_codigo = mysqli_insert_id($con);

					//retorna a mensagem de confirmação de cadasro usuario
					echo "<script>alert(\"Cadastro Realizado Com Sucesso !\");window.location=\"usuario.php\";</script>";
				}
				
			}else{
				echo "<script>alert(\"Você deve preencher todos os campos !\");window.history.back();</script>";
			}
		}elseif($_GET['tabela'] == 'empresa'){
			if(!empty($_GET['nome']) && !empty($_GET['cod_fortes'])){
				$ok = evitaDuplicidade($_GET['tabela'],'cod_fortes',$_GET['cod_fortes']);
				if($ok == "exist"){
					echo "<script>alert(\"Codigo de Empresa já cadastrado no banco !\");window.history.back();</script>";
				}else{
					$sql = "insert into empresa (nome, cod_fortes) values ('".$_GET['nome']."','".$_GET['cod_fortes']."')";
					$res2 = mysqli_query($con,$sql);
					$novo_codigo = mysqli_insert_id($con);
					
					//retorna a mensagem de confirmação de cadasro de empresa
					echo '<div class="container-fluid"><div class="row"><div class="col"><h2 style="color:red" align="center">Cadastro realizado com Sucesso !</h2></div></div></div>';
				}
			}else{
				echo "<script>alert(\"Você deve preencher todos os campos !\");window.history.back();</script>";
			}
		}elseif($_GET['tabela'] == 'atividade'){
			if(!empty($_GET['descricao']) && !empty($_GET['setor'])){
				$sql = "insert into atividade (descricao, setor) values ('".$_GET['descricao']."','".$_GET['setor']."')";
				$res2 = mysqli_query($con,$sql);
				$novo_codigo = mysqli_insert_id($con);
				
				//retorna a mensagem de confirmação de cadasro de atividade
				echo '<div class="container-fluid"><div class="row"><div class="col"><h2 style="color:red" align="center">Cadastro realizado com Sucesso !</h2></div></div></div>';
			}else{
				echo "<script>alert(\"Você deve preencher todos os campos !\");window.history.back();</script>";
			}
		}

	}
	
}
?>