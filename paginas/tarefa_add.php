<?php
	#Inclui o arquivo com o sistema de segurança
	include("../seguranca.php"); 
	#chama o arquivo de configuração com o banco
	require 'conexao.php';
	$setor = $_SESSION['usuarioSetor'];
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Adicionar Tarefa</title>
	<link rel="stylesheet" type="text/css" href="../css/tarefa_add.css" />
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min_4.0.css" />

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

</head>
<body>
	<form method="GET" action="tarefa_view_2.php">
		<div class="form-group">
		    <div class="container-fluid frame">
			 	 <div class="row" id="container_fluid" style="margin-left: 5%;">
			 	 	<!--Coluna do centro-->
			    	<div class="col">
			    		<div id="box_date">
			    			<label id="lb_setor">Setor :</label><br/>
							<!--Select de Setor-->
							<select id="sel_setor" class="form-control box3D" name="setor">
							<option>Selecione...</option>
							<?php //cria as opcoes da TAG <select> com dados do DB  
								#seleciona os dados da tabela setor
								$res = mysqli_query($con,"SELECT id, nome FROM setor");
								$total = mysqli_num_rows($res);

								for($i=0; $i<$total; $i++){
									$dados = mysqli_fetch_row($res);
									$id = $dados[0];
									$nome = $dados[1]; 
									if($nome == $_SESSION['usuarioSetor']){
										echo "<option value=\"$nome\" selected>$nome</option>";	
									}else{
										echo "<option value=\"$nome\">$nome</option>";
									}
							 	} 
							 ?>
						</select><br/>
				    	    <label id="lb_data_ini">Data de Lancamento :</label><br/>
							<input type="date" name="data_ini" id="dt_ini" class="form-control" value="<?php echo date('Y-m-d'); ?>" /><br/>
							<label id="lb_data_fim">Competencia :</label><br/>
							<input type="text" name="competencia" id="competencia" class="form-control" value="" placeholder="Ex : JANEIRO 2017" required/><br/>
						</div>

						<!-- Button trigger modal -->
						<button type="button" id="bt_modal" class="btn btn-primary box3D" data-toggle="modal" data-target="#exampleModal">
						  Salvar Tarefa
						</button>
			    	</div>

					<!--Coluna da direita-->
			    	<div class="col-7">
			     	 	<label id="lb_usuario">Usuário :</label><br/>
						<!--Select de Nome-->
						<select id="sel_usuario" class="form-control box3D" name="usuario">
							<option>Selecione...</option>
							<?php 
							//cria as opcoes da TAG <select> com dados do DB  
								#seleciona os dados da tabela usuario
								$res = mysqli_query($con,"SELECT id, nome FROM usuario where setor = '$setor' order by nome");
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
						<br/>

						<label id="lb_empresa">Empresa :</label><br/>
						<!--Select de Empresa-->
						<select id="sel_empresa" class="form-control box3D" name="empresa">
							<option >Selecione...</option>
							<?php //cria as opcoes da TAG <select> com dados do DB  
								#seleciona os dados da tabela usuario
								$res = mysqli_query($con,"SELECT id, nome, cod_fortes FROM empresa order by nome");
								$total = mysqli_num_rows($res);

								for($i=0; $i<$total; $i++){
									$dados = mysqli_fetch_row($res);
									$id = $dados[0];
									$nome = $dados[1];
									$cod_fortes = $dados[2]; 
							 		echo "<option value=\"$nome\">$nome [ $cod_fortes ]</option>";
							 	} 
							 ?>
						</select>
						<br/>
						<label id="lb_atividade">Atividade :</label><br/>
						<!--Select de Atividade-->
						<select id="sel_atividade" class="form-control box3D" name="atividade" required >
						  <option value="">Selecione...</option>
							<?php //cria as opcoes da TAG <select> com dados do DB  
								#seleciona os dados da tabela usuario
								$setor = $_SESSION['usuarioSetor'];
								$res = mysqli_query($con,"SELECT id, descricao, setor FROM atividade where setor = '$setor' order by descricao");
								$total = mysqli_num_rows($res);

								for($i=0; $i<$total; $i++){
									$dados = mysqli_fetch_row($res);
									$id = $dados[0];
									$descricao = $dados[1]; 
									$setor = $dados[2]; 
							 		echo "<option value=\"$descricao\"> $descricao </option>";
							 	} 
							 ?>
						</select><br/>

						<!--Coluna do direita-->
				    	<div class="col">
				      		<textarea rows="5" cols="100" id="txt_area" class="form-control box3D" placeholder="Observacao para realizacao da tarefa." name="obs"></textarea>
				    	</div>
						
						
						<br/>
						<!-- Modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Salvar Tarefa</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						        Deseja salvar esta Tarefa ?
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary box3D" data-dismiss="modal">Cancelar</button>
						        <input type="hidden" name="tabela" value="tarefa" />
						        <input type="submit" value="cadastrar" id="bt_cadastrar" name="acao" class="btn btn-primary box3D" />
						      </div>
						    </div>
						  </div>
						</div>

			    	</div>
			    	
			  	</div>
		  	</div>
		 </div> 	
	</form>

<script src="../js/jquery-3.2.1.slim.min.js" ></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min_4.0.js"></script>

</body>
</html>