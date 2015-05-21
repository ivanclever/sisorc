<?php
require('../util/conn.php');
require('../util/util.php');
require('../util/auth.php');
LimpaPost($_POST);
extract($_POST);
$do = $_REQUEST['do'];

switch ($do) {
	case 'cadastra':
		ValidaVazio($nome,'Campo nome inválido');

		$_SESSION['ambientes'] = $_POST;

		if (semErros()) {
			if (mysql_query("INSERT INTO ambientes (nome) VALUES ('$nome')")) {
				Info('Ambiente cadastrado com sucesso');
				Go('../?s=ambientes');
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;
	case 'exclui':
		$id = (int)$_GET['id'];
		if (mysql_query("DELETE FROM ambientes WHERE id = '$id'")) {
			Info ("Ambiente removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go();
	break;
	case 'altera':
		ValidaID($id,'id','ambientes');
		ValidaVazio($nome,'Campo nome inválido');

		if (semErros()) {
			if (mysql_query("UPDATE ambientes SET nome='$nome' WHERE id = '$id'")) {
				Info('Ambiente alterado com sucesso');
				Go('../?s=ambientes');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;
}
?>