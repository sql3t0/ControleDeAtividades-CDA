<?php
include("conexao.php");
?>
<!DOCTYPE html>
<html>
<head> 
	<title>Visualizar Usuários</title>
	<link rel="stylesheet" type="text/css" href="../css/usuario.css" />
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min_4.0.css" />

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script type="text/javascript" src="../js/bibliotecaAjax.js"></script>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col" id="coluna_add_user_esquerda">
				<div id="avisos">	
					<table class="table table-striped table-inverse" id="minhaTabela">
						<thead class="thead-inverse">
							<tr id="tr_filtro">
								<th class="th_filtro"><img src="../imagens/filter.png" title="Filtros de Pesquisa" /></th>
								<th><input type="text" class="form-control th_filtro" placeholder="Nome" aria-label="Nome" id="txtColuna1"/></th>
								<th></th>
								<th></th>
								<th></th>
								<th class="th_filtro"><img src="../imagens/filter.png" title="Filtros de Pesquisa" /></th>
							</tr>
							<tr>
								<th id="codigo" class="tb_cabecalho" style="display:none;" ><strong>id</strong></th>
								<th id="nome" class="tb_cabecalho"><strong>Nome</strong></th>  
								<th id="senha" class="tb_cabecalho"><strong>Senha</strong></th>
								<th id="setor" class="tb_cabecalho"><strong>Setor</strong></th>
								<th id="nivel" class="tb_cabecalho"><strong>Nivel</strong></th>
								<th id="alterar_senha" class="tb_cabecalho"><strong>&nbsp;</strong></th>
								<th id="excluir" class="tb_cabecalho"><strong>&nbsp;</strong></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$res = mysqli_query($con,"select * from usuario order by nome");  
							$total = mysqli_num_rows($res);

							for($i=0; $i<$total; $i++){
								$dados = mysqli_fetch_row($res);
								$id = $dados[0];
								$nome = $dados[1]; 
								$senha = $dados[2];
								$setor = $dados[3];
								$nivel = $dados[4];

								$idLinha = "linha$i";


								echo '<tr scope="row" id="'.$idLinha.'" >';
								echo '<td style="display:none;">'.$id.'</td>';
								echo "<td class=\"tr_font\">$nome</td>";
								echo "<td class=\"tr_font\"><input style=\"background-color:transparent;border-style:none;\"type=\"password\" value=\"$senha\"disabled/></td>";
								echo "<td class=\"tr_font\">$setor</td>";
								echo "<td class=\"tr_font\">$nivel</td>";

								echo "<td align=\"center\"><a href=\"trocar_senha.php?id=$id\" target=\"frame_senha\" id=\"$idLinha\"><button type=\"button\" id=\"senha_bt_modal_$idLinha\" class=\"btn btn-primary box3D \" data-toggle=\"modal\" data-target=\"#exampleModal\" title=\" Alterar Senha\" > <img src=\"..\imagens\icon_edit.png\" alt=\" Alterar Senha\" /> </button></a></td>";

								echo "<td align=\"center\"><button type=\"button\" id=\"bt_modal_$idLinha\" class=\"btn btn-primary box3D \" data-toggle=\"modal\" data-target=\"#exampleModal_$idLinha\" title=\"Excluir Usuario\" > <img src=\"..\imagens\delete.png\" alt=\"Excluir Usuario\" /> </button><div class=\"modal fade\" id=\"exampleModal_$idLinha\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\"> <div class=\"modal-dialog\" role=\"document\"> <div class=\"modal-content bt_excluir\"> <div class=\"modal-header\"> <h5 class=\"modal-title\" id=\"exampleModalLabel\">Excluir item</h5> <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"> <span aria-hidden=\"true\">&times;</span> </button> </div> <div class=\"modal-body\"> Deseja excluir o item ? </div> <div class=\"modal-footer\"> <button type=\"button\" class=\"btn btn-secondary box3D\" data-dismiss=\"modal\" >Cancelar</button> <button type=\"button\" id=\"bt_excluir_$idLinha\" class=\"btn btn-secondary box3D bg_bt_excluir\" data-dismiss=\"modal\" onclick=\"ExcluirLinha('$idLinha', '$id','usuario');\" >Excluir</button> </div> </div> </div> </div></td>";
							}
								echo "<div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\"> <div class=\"modal-dialog\" role=\"document\"> <div class=\"modal-content bt_excluir\"> <div class=\"modal-header\"> <h5 class=\"modal-title\" id=\"exampleModalLabel\">Alterar Senha</h5> <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"> <span aria-hidden=\"true\">&times;</span> </button> </div> <div class=\"modal-body\"> <iframe  width=\"100%\" height=\"100%\" frameborder=\"0\" id=\"frame_senha\" name=\"frame_senha\" src=\"\"></iframe> </div> <div class=\"modal-footer\"> <button type=\"button\" class=\"btn btn-secondary box3D\" data-dismiss=\"modal\" onclick=\"window.location='usuario.php'\">Fechar</button></div> </div> </div> </div>"
							?>
						</tbody>
					</table>
				</div>
			</div>	
			<div class="col" id="coluna_add_user_direita">
				<div>
					<form method="GET" action="tarefa_view_2.php" >
						<div class="form-group">
							<label >Nome</label>
							<input type="nome" class="form-control" id="inp_nome" name="nome" placeholder="Nome do novo usuario" required="true" />
						</div>
						<div class="form-group">
							<label >Setor</label>
							<select class="form-control" id="sel_setor" name="setor" required="true" required="true">
								<option >Selecione...</option>
								<option value="Fiscal">Fiscal</option>
								<option value="Contabil">Contábil</option>
								<option value="Pessoal">Pessoal</option>
							</select>
						</div>
						<div class="form-group">
							<label >Nível de Acesso</label>
							<select class="form-control" id="sel_nivel" name="nivel" required="true">
								<option value="1">Selecione...</option>
								<option value="1">Nível de Usuário Comum</option>
								<option value="2">Nível de Usuário Administrador</option>
							</select>
						</div>
						<div class="form-group">
							<div class="container-fluid">
								<div class="row">
									<div class="col" id="inp_senha">
										<label >Senha</label>
										<input type="password" class="form-control" id="inp_senha_" name="senha" placeholder="Senha do Usuario" required="true" />
									</div>
									<div class="col" id="inp_confirm_senha">
										<label >Confimar</label>
										<input type="password" class="form-control" id="inp_confirm_senha_" name="confirma_senha" placeholder="Confimar Senha" required="true" />
									</div>
								</div>
							</div>	
						</div>
						<br/>
						<div class="form-group">
							<br/>
							<!-- Button trigger modal -->
							<button type="button" id="bt_modal" class="btn btn-primary box3D" data-toggle="modal" data-target="#exampleModalSalvar">
								<img src="..\imagens\add.png" alt="Novo Usuario" />  Criar Usuário
							</button>
							<!-- Modal -->
							<div class="modal fade" id="exampleModalSalvar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Salvar Usuário</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											Deseja salvar este Usuário ?
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary box3D" data-dismiss="modal">Cancelar</button>
											<input  type="hidden" name="tabela" value="usuario" />
											<button type="submit" value="cadastrar" id="bt_cadastrar" name="acao" class="btn btn-primary box3D">Salvar</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>



	<script src="../js/jquery-3.2.1.slim.min.js" ></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min_4.0.js"></script>
	<script src="../js/filtro.js"></script>
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