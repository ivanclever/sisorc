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

		$_SESSION['categorias'] = $_POST;

		if (semErros()) {
			if (mysql_query("INSERT INTO categoriasprodutos (Nome) VALUES ('$nome')")) {
				Info('Categoria cadastrada com sucesso');
				Go('../?s=categorias');
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;
	case 'exclui':
		$id = (int)$_GET['id'];
		if (mysql_query("DELETE FROM categoriasprodutos WHERE CodCategoriaProduto = '$id'")) {
			Info ("Categoria removida com sucesso");
		} else Erro("Erro durante a exclusão");
		Go();
	break;
	case 'altera':
		ValidaID($id,'CodCategoriaProduto','categoriasprodutos');
		ValidaVazio($nome,'Campo nome inválido');

		if (semErros()) {
			if (mysql_query("UPDATE categoriasprodutos SET Nome='$nome' WHERE CodCategoriaProduto = '$id'")) {
				Info('Categoria alterada com sucesso');
				Go('../?s=categorias');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;
}
?>