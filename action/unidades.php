<?php
require('../util/conn.php');
require('../util/util.php');
require('../util/auth.php');
LimpaPost($_POST);
extract($_POST);
$do = $_REQUEST['do'];

switch ($do) {
	case 'cadastra':
		ValidaVazio($sigla,'Campo Sigla obrigatório');
		ValidaVazio($descricao,'Campo Descrição obrigatório');

		$_SESSION['categorias'] = $_POST;

		if (semErros()) {
			if (mysql_query("INSERT INTO unidadesmedida (sigla, descricao) VALUES ('$sigla', '$descricao')")) {
				Info('Unidade cadastrada com sucesso');
				Go('../?s=unidades');
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;
	case 'exclui':
		$id = (int)$_GET['id'];
		if (mysql_query("DELETE FROM unidadesmedida WHERE CodUnidadeMedida = '$id'")) {
			Info ("Unidade removida com sucesso");
		} else Erro("Erro durante a exclusão");
		Go();
	break;
	case 'altera':
		ValidaID($id,'CodUnidadeMedida','unidadesmedida');
		ValidaVazio($sigla,'Campo Sigla obrigatório');
		ValidaVazio($descricao,'Campo Descrição obrigatório');

		if (semErros()) {
			if (mysql_query("UPDATE unidadesmedida SET Sigla='$sigla', Descricao='$descricao' WHERE CodUnidadeMedida = '$id'")) {
				Info('Unidade alterada com sucesso');
				Go('../?s=unidades');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;
}
?>