var ajax;
var dadosUsuario;

// ----- Cria o objeto e faz a requisição -----
function requisicaoHTTP(tipo,url,assinc){
	if(window.XMLHttpRequest){// Objeto usado no Mozila, Safari...
		ajax = new XMLHttpRequest;
	}
	else if(window.ActiveXObject){// Objeto usado pelo Internet Explorer
		ajax = new ActiveXObject("Msxml2.XMLHTTP");
		if(!ajax){
			ajax = new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	//ajax é a variável que vai armanezar o objeto que será utilizado baseado no navegador usado pelo usuário
	if (ajax){
		iniciaRequisicao(tipo,url,assinc); // Iniciou com sucesso
	}else{
		alert("Seu navegador não possui suporte a essa aplicação"); // Mensagem que será exibida caso não seja possível iniciar a requisição
	}
}
// ----- Inicia o objeto criado e envia os dados (se existirem) -----
function iniciaRequisicao(tipo, url, bool){
	ajax.onreadystatechange = trataResposta; //Atribui ao objeto a resposta da função trataResposta
	ajax.open(tipo, url, bool); //Informa os parâmetros do objeto: tipo de envio, url e se a comunicação será assíncrona ou não
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");//Recupera as informações do cabeçalho
	ajax.send(dadosUsuario);// Envia os dados processados para o navegador
}
// ----- Inicia requisição com envio de dados -----
function enviaDados(url){
	criaQueryString(); //Chama a função que transformará os dados enviados em ua string
	requisicaoHTTP("POST", url, true); //Chama a função que fará a requisição de dados ao servidor
}
// ----- Cria a string a ser enviada, formato campo1=valor&campo2=valor2... -----
function criaQueryString(){
	dadosUsuario = "";
	var frm = document.forms[0]; //Identifica o formulário
	var numElementos = frm.elements.length;// Informa o número de elementos
	for(var i = 0; i < numElementos; i++){//Monta a querystring
		if(i < numElementos-1){ //Se i for menor que o número de elementos (menos 1)
			dadosUsuario += frm.elements[i].name+"="+encodeURIComponent(frm.elements[i].value)+"&"; //recupera os valores que comporão a url se houver mais elementos a serem incluídos;
		}
		else{
			dadosUsuario += frm.elements[i].name+"="+encodeURIComponent(frm.elements[i].value); //recupera os valores que comporão a url se houver mais elementos a serem incluídos;
		}
	}
}
// ----- Trata a resposta do servidor -----
function trataResposta(){
	if(ajax.readyState == 4){// Se todas as informações e a conexão foi fechada...
		if(ajax.status == 200){// Se o status da conexão for 200
			trataDados(); // Chama a função trataDAdos
		}
		else{
			alert("Problema na comunicação com o objeto XMLHttpRequest.");
		}
	}
}


var dadosAtuais; //Array que guarda os dados atuais da linha antes de editá-la
var linhaEmEdicao = null; //Guarda o ID da linha a ser editada, incluída ou excluída
var linhasNovas = 0; //Variável auxiliar


//Exclui uma linha da tabela
function ExcluirLinha(idLinha, cod,tabela){
	if(!linhaEmEdicao){
		var linha = document.getElementById(idLinha);//Armazena o id da linha que será excluída
		linha.className = 'linhaSelecionada';// define a classe de estilos que será usada na linha
		Aviso(1); // Exibe o aviso: Aguarde...
		var url = "tarefa_view_2.php?acao=excluir&tabela="+tabela+"&cod="+cod;//Url que será enviada
		requisicaoHTTP("GET", url, true);//Função que fará a requisição
	}else{
		alert("Voce esta com um registro aberto. Feche-o antes de prosseguir.");
	}
}

//Finalizar uma linha da tabela
function FinalizarTarefa(idLinha, cod,tabela,data_fim){
	if(!linhaEmEdicao){
		Aviso(1); // Exibe o aviso: Aguarde...
		var url = "tarefa_view_2.php?acao=atualizar&tabela="+tabela+"&id="+cod+"&data_fim="+data_fim;//Url que será enviada
		requisicaoHTTP("GET", url, true);//Função que fará a requisição
	}else{
		alert("Faltam parametros necessarios para Finalizar a Tarefa !");
	}
}

//Reabre uma tarefa jah finalizada
function reabrirTarefa(cod,tabela){
	if(!linhaEmEdicao){
		Aviso(1); // Exibe o aviso: Aguarde...
		var url = "tarefa_view_2.php?acao=reabrirTarefa&tabela="+tabela+"&id="+cod;//Url que será enviada
		requisicaoHTTP("GET", url, true);//Função que fará a requisição
	}else{
		alert("Faltam parametros necessarios para Finalizar a Tarefa !");
	}
}


//iniciar/finaliza tempo de duração da atividade
function ControlTimer(opt, id,nome){
	if(!linhaEmEdicao){
		Aviso(1); // Exibe o aviso: Aguarde...
		var url = "tarefa_view_2.php?acao=timer&opt="+opt+"&id="+id+"&nome="+nome;//Url que será enviada
		requisicaoHTTP("GET", url, true);//Função que fará a requisição
	}else{
		alert("Faltam parametros necessarios para Finalizar a Tarefa !");
	}
}

//Atualiza o conteúdo da linha
function Atualizar(c,u,s,e,a,di,df,o){
	Aviso(1); //Exibe o aviso aguarde...
	var dados = ObtemDadosForm(c,u,s,e,a,di,df,o);//Chama a função que montará a string com os dados que estarão na url
	var cod = c;//Armazena o código do produto que será atualizado
	var url = "tarefa_view_2.php?acao=atualizar"; //Monta a url
	url += "&cod="+cod+"&"+dados;//Monta a url
	requisicaoHTTP("GET", url, true);//Inicia a requisição
}

//Chamada do programa em PHP que cadastra no banco de dados
function Cadastrar(c,u,s,e,a,di,df,o){
	Aviso(1);//Chama a função aviso
	var dados = ObtemDadosForm(c,u,s,e,a,di,df,o, 0); //Armazena a string com dados que comporão a url
	var url = "tarefa_view_2.php?acao=cadastrar&"+dados;//Url que será enviada
	requisicaoHTTP("GET", url, true);//Inicia a requisição
}

//Coloca os dados do formulário em formato de query string
function ObtemDadosForm(c,u,s,e,a,di,df,o){
	parametros = "usuario="+u+"&setor="+s+"&empresa="+e+"&atividade="+a+"&data_ini="+di+"&data_fim="+df+"&obs="+o;//Define os parâmetros da url que será enviada
	return parametros;//Retorna o valor da variável como resposta da função
}

//Exibe ou oculta a mensagem de espera
function Aviso(exibir){
	var saida = document.getElementById("avisos");//Armazena a chamada da div avisos
	if(exibir){// Se exibir for verdadeio...
		saida.className = "aviso";//Define que a classe a ser usada será avisos
		saida.innerHTML = "Aguarde... Processando!";// Exibe o aviso: Aguarde... Processando!
	}else{
		saida.className = "";//Elimina a classe se exibir for falso
		saida.innerHTML = "";//Não exibe nenhum aviso
	}
}

//Trata a  resposta do servidor, de acordo com a operação realizada
function trataDados(){
	var resposta = ajax.responseText; //armazena a resposta do servidor

	if(resposta == 1){
		alert('Tarefa atualizada com Sucesso.');
		window.location.reload();
	}
	if(resposta == 2){
		alert('Linha excluida com Sucesso.');
		window.location.reload();
	}
	if(resposta == 3){
		alert('Tarefa cadastrada com Sucesso.');
		window.location.href="tarefa_view.php";
	}
	if(resposta == 4){
		alert('Tarefa Finalizada com Sucesso.');
		window.location.reload();
	}
	if(resposta == 5){
		alert('Tarefa Iniciada com Sucesso.');
		window.location.reload();
	}
	if(resposta == 6){
		alert('Falha na Inicializacao da Tarefa !');
		window.location.reload();
	}
	if(resposta == 7){
		alert('Tarefa Reinicada com Sucesso !');
		window.location.reload();
	}
	if(resposta == 8){
		alert('Tarefa Pausada com Sucesso !');
		window.location.reload();
	}
	Aviso(0);
}


/*
requisicaoHTTP = tenta  instanciar o objeto XMLHttpRequest e, se conseguir, chama a função que fará a requisição, passando a ela os dados fornecidos pelo usuário.

iniciaRequisição = recebe os dados da função requisiçãoHTTP e processa a requisição, além de definir a função que irá tratar a resposta do servidor.

enviaDados = faz uma requisição definindo antes os dados a serem enviados, que, no caso, são obtidos de um formulário HTML. Caso não haja dados a seresm enviados, podemos chamar diretamente a função requisicaoHTTP.

criaQueryString = coloca os dados do firmulário no formato de uma QueryString, para que o servidor possa identificar os pares nome/valor.

trataResposta = verifica se a requisição foi conluída e inicia o tratamento dos dados. Há diferença desta função para a função trataDados(), que você deverá criar em seu programa para realizar o tratamento desejado sobre os dados retornados pelo servidor.

Possíveis valores do readyState
0(Não Iniciado): O Objeto foi criado mas o método open() não foi chamado ainda. 
1(Carregando): O método open() foi chamado mas a requisição não foi enviada ainda. 
2(Carregado): A requisição foi enviada. 
3(Incompleto): Uma parte da resposta do servidor foi recebida. 
4(Completo): Todos as informações foram recebidas e a conexão foi fechada com sucesso. 
*/