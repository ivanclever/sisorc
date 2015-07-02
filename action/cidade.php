<?php
require('../util/conn.php');
require('../util/util.php');
require('../util/auth.php');
LimpaPost($_POST);
extract($_POST);
$do = $_REQUEST['do'];

switch ($do) {
	case 'cadastra':

		$_SESSION['cidade'] = $_POST;
		
		if (semErros()) {
			if (mysql_query("INSERT INTO  cidades (Nome, CodEstado) VALUES ('$nome', '$uf')")) {
				Info('Cadastrado realizado com sucesso');
				unset($_SESSION['cidade']);
				Go('../?s=cidade');
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;
	
	
	case 'altera':
		ValidaID($id,'CodCidade','cidade');
		
		if (semErros()) {
			if (mysql_query("UPDATE cidades 
					SET
						Nome = '$nome',
						CodEstado = '$uf'
					WHERE
						CodCidade = '$id'")) {
				Info('Cadastro alterado com sucesso');
				Go('../?s=cidade');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;
}
?>