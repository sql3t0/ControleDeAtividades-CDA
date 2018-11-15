<?php
	//VARIAVEIS STATICAS
	$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cda";
	//CONEXAO - MODELO 1
	$con = mysqli_connect($servername, $username, $password) or die ("Erro de conexão");
    $res1 = mysqli_select_db($con,$dbname) or die ("Banco de dados inexistente");

    //CONEXAO - MODELO 2 (*usada em timer.php)
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>