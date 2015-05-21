<?php
require('../util/conn.php');
require('../util/util.php');
require('../util/auth.php');
LimpaPost($_POST);
extract($_POST);
$do = $_REQUEST['do'];

switch ($do) {
	case 'cadastra':
		ValidaVazio($nome,'Campo Nome obrigatório');

		$_SESSION['categorias'] = $_POST;

		if (semErros()) {
			if (mysql_query("INSERT INTO cores (Nome) VALUES ('$nome')")) {
				Info('Cor cadastrada com sucesso');
				Go('../?s=cores');
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;
	case 'exclui':
		$id = (int)$_GET['id'];
		if (mysql_query("DELETE FROM cores WHERE CodCor = '$id'")) {
			Info ("Cor removida com sucesso");
		} else Erro("Erro durante a exclusão");
		Go();
	break;
	case 'altera':
		ValidaID($id,'CodCor','cores');
		ValidaVazio($nome,'Campo Nome obrigatório');

		if (semErros()) {
			if (mysql_query("UPDATE cores SET Nome='$nome' WHERE CodCor = '$id'")) {
				Info('Cor alterada com sucesso');
				Go('../?s=cores');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;
}
?>