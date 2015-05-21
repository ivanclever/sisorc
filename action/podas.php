<?php
require('../util/conn.php');
require('../util/util.php');
require('../util/auth.php');
LimpaPost($_POST);
extract($_POST);
$do = $_REQUEST['do'];

switch ($do) {
	case 'cadastra':
		ValidaVazio($descricao,'Campo Descrição obrigatório');

		$_SESSION['categorias'] = $_POST;

		if (semErros()) {
			if (mysql_query("INSERT INTO tipospodas (Descricao) VALUES ('$descricao')")) {
				Info('Tipo de poda cadastrado com sucesso');
				Go('../?s=podas');
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;
	case 'exclui':
		$id = (int)$_GET['id'];
		if (mysql_query("DELETE FROM tipospodas WHERE CodTipoPoda = '$id'")) {
			Info ("Tipo de poda removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go();
	break;
	case 'altera':
		ValidaID($id,'CodTipoPoda','tipospodas');
		ValidaVazio($descricao,'Campo Descrição obrigatório');

		if (semErros()) {
			if (mysql_query("UPDATE tipospodas SET Descricao='$descricao' WHERE CodTipoPoda = '$id'")) {
				Info('Tipo de poda alterado com sucesso');
				Go('../?s=podas');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;
}
?>