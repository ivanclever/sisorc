<?php
require('../util/conn.php');
require('../util/util.php');
require('../util/auth.php');
LimpaPost($_POST);
extract($_POST);
$do = $_REQUEST['do'];

switch ($do) {
	case 'cadastra':

		$_SESSION['estado'] = $_POST;
		if (semErros()) {
			if (mysql_query("INSERT INTO  estados (Nome, UF) VALUES ('$nome', '$uf')")) {
				Info('Cadastrado realizado com sucesso');
				unset($_SESSION['estado']);
				Go('../?s=estado');
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;
	
	
	case 'altera':
		ValidaID($id,'CodCidade','cidade');
		
		if (semErros()) {
			if (mysql_query("UPDATE estados 
					SET
						Nome = '$nome',
						UF = '$uf'
					WHERE
						CodCidade = '$id'")) {
				Info('Cadastro alterado com sucesso');
				Go('../?s=estado');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;
}
?>