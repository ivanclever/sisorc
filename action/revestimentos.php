<?php
require('../util/conn.php');
require('../util/util.php');
require('../util/auth.php');
LimpaPost($_POST);
extract($_POST);
$do = $_REQUEST['do'];

switch ($do) {
	case 'cadastra':
		ValidaVazio($nome,'Campo Descrição obrigatório');

		$_SESSION['categorias'] = $_POST;

		if (semErros()) {
			if (mysql_query("INSERT INTO revestimentos (Descricao) VALUES ('$nome')")) {
				Info('Revestimento cadastrado com sucesso');
				Go('../?s=revestimentos');
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;
	case 'exclui':
		$id = (int)$_GET['id'];
		if (mysql_query("DELETE FROM revestimentos WHERE CodRevestimento = '$id'")) {
			Info ("Revestimento removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go();
	break;
	case 'altera':
		ValidaID($id,'CodRevestimento','revestimentos');
		ValidaVazio($nome,'Campo Descrição obrigatório');

		if (semErros()) {
			if (mysql_query("UPDATE revestimentos SET Descricao='$nome' WHERE CodRevestimento = '$id'")) {
				Info('Revestimento alterado com sucesso');
				Go('../?s=revestimentos');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;
}
?>