<?php
	include("conexao.php");
?>
<!DOCTYPE html>
<html>
<head> 
	<title>Visualizar Atividades</title>
	<link rel="stylesheet" type="text/css" href="../css/atividade.css" />
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min_4.0.css" />

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script type="text/javascript" src="../js/bibliotecaAjax.js"></script>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<!-- Button trigger modal add atividade-->
			<button type="button" id="bt_nova_atividade" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalAddAtividade">
				<img src="..\imagens\add.png" alt="Nova Atividade" />  Nova Atividade
			</button>
			<!-- Modal add atividade -->
			<div class="modal fade" id="exampleModalAddAtividade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Adicionar Atividade</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body" id="size_body_atividade">
					<iframe  width="100%" height="100%" frameborder="0" id="frame_atividade" name="frame_atividade" src="atividade_add.php"></iframe>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location='atividade.php'">Fechar</button>
			      </div>
			    </div>
			  </div>
			</div>
		</div>
		<div class="row">
			<div class="col" id="coluna_add_user_esquerda">
				<div id="avisos">	
					<table class="table table-striped table-inverse" id="minhaTabela">
						<thead class="thead-inverse">
							<tr id="tr_filtro">
								<th style="display:none;"></th>
								<th><input type="text" class="form-control th_filtro" placeholder="Descrição" aria-label="Nome" id="txtColuna1"/></th>
								<th></th>
								<th></th>
								<th class="th_filtro"><img src="../imagens/filter.png" title="Filtros de Pesquisa"/></th>
							</tr>
							<tr>
								<th id="codigo" class="tb_cabecalho" style="display:none;" ><strong>id</strong></th>
								<th id="nome" class="tb_cabecalho"><strong>Descrição</strong></th>  
								<th id="codigo_fortes" class="tb_cabecalho"><strong>Setor</strong></th>
								<th id="editar" class="tb_cabecalho"><strong>&nbsp;</strong></th>
								<th id="excluir" class="tb_cabecalho"><strong>&nbsp;</strong></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$res = mysqli_query($con,"select * from atividade order by id");  
								$total = mysqli_num_rows($res);

								for($i=0; $i<$total; $i++){
									$dados = mysqli_fetch_row($res);
									$id = $dados[0];
									$descricao = $dados[1]; 
									$setor = $dados[2];

									$idLinha = "linha$i";


									echo '<tr scope="row" id="'.$idLinha.'" >';
									echo '<td style="display:none;">'.$id.'</td>';
									echo "<td class=\"tr_font\">$descricao</td>";
									echo "<td class=\"tr_font\">$setor</td>";

									echo "<td align=\"center\"><a href=\"atividade_edit.php?id=$id&descricao=$descricao&setor=$setor\" target=\"frame_senha\" id=\"$idLinha\"><button type=\"button\" id=\"senha_bt_modal_$idLinha\" class=\"btn btn-primary box3D \" data-toggle=\"modal\" data-target=\"#exampleModal\" title=\"Alterar Atividade\" > <img src=\"..\imagens\icon_edit.png\" alt=\"Alterar Atividade\" /> </button></a></td>";

									echo "<td align=\"center\"><button type=\"button\" id=\"bt_modal_$idLinha\" class=\"btn btn-primary box3D \" data-toggle=\"modal\" data-target=\"#exampleModal_$idLinha\" title=\"Excluir Atividade\" > <img src=\"..\imagens\delete.png\" alt=\"Excluir Atividade\" /> </button><div class=\"modal fade\" id=\"exampleModal_$idLinha\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\"> <div class=\"modal-dialog\" role=\"document\"> <div class=\"modal-content bt_excluir\"> <div class=\"modal-header\"> <h5 class=\"modal-title\" id=\"exampleModalLabel\">Excluir item</h5> <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"> <span aria-hidden=\"true\">&times;</span> </button> </div> <div class=\"modal-body\"> Deseja excluir o item ? </div> <div class=\"modal-footer\"> <button type=\"button\" class=\"btn btn-secondary box3D\" data-dismiss=\"modal\" >Cancelar</button> <button type=\"button\" id=\"bt_excluir_$idLinha\" class=\"btn btn-secondary box3D bg_bt_excluir\" data-dismiss=\"modal\" onclick=\"ExcluirLinha('$idLinha', '$id','atividade');\" >Excluir</button> </div> </div> </div> </div></td>";
								}
								echo "<div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\"> <div class=\"modal-dialog\" role=\"document\"> <div class=\"modal-content bt_excluir\"> <div class=\"modal-header\"> <h5 class=\"modal-title\" id=\"exampleModalLabel\">Altera Senha</h5> <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"> <span aria-hidden=\"true\">&times;</span> </button> </div> <div class=\"modal-body\" id=\"size_body_atividade\"> <iframe  width=\"100%\" height=\"100%\" frameborder=\"0\" id=\"frame_senha\" name=\"frame_senha\" src=\"\"></iframe> </div> <div class=\"modal-footer\"> <button type=\"button\" class=\"btn btn-secondary box3D\" data-dismiss=\"modal\" onclick=\"window.location='atividade.php'\">Fechar</button></div> </div> </div> </div>";
							?>
						</tbody>
					</table>
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
<?php
" "
?>