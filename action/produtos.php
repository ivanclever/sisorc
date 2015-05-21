<?php
require('../util/conn.php');
require('../util/util.php');
require('../util/auth.php');
LimpaPost($_POST);
extract($_POST);
$do = $_REQUEST['do'];

switch ($do) {
	case 'cadastra':
		ValidaVazio($nome,'Campo Nome inválido');
		ValidaVazio($categoria,'Selecione uma Categoria');

		$_SESSION['produtos'] = $_POST;

		if (semErros()) {
			if (mysql_query("INSERT INTO produtos
					(CodCategoriaProduto, Codigo, NomePopular, NomeCientifico, Ambiente, Observacoes, status)
				VALUES
					('$categoria', '$codigo', '$nome_popular', '$nome', '$ambiente', '$observacoes', '$status')")) {
				Info('Produto cadastrado com sucesso');
				Go('../?s=produtos');
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;
	case 'exclui':
		$id = (int)$_GET['id'];
		if (mysql_query("UPDATE produtos SET status='0' WHERE CodProduto = '$id'")) {
			Info ("Produto removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go();
	break;
	case 'ativa':
		$id = (int)$_GET['id'];
		if (mysql_query("UPDATE produtos SET status='1' WHERE CodProduto = '$id'")) {
			Info ("Produto ativado com sucesso");
		} else Erro("Erro durante a atualização");
		Go();
	break;
	case 'altera':
		ValidaID($id,'CodProduto','produtos');
		ValidaVazio($nome,'Campo Nome inválido');
		ValidaVazio($categoria,'Selecione uma Categoria');

		if (semErros()) {
			if (mysql_query("UPDATE produtos 
					SET
						CodCategoriaProduto='$categoria',
						Ambiente='$ambiente',
						NomeCientifico='$nome',
						NomePopular='$nome_popular',
						Codigo='$codigo',
						Observacoes='$observacoes',
						status='$status'
					WHERE
						CodProduto = '$id'")) {
				Info('Produto alterado com sucesso');
				Go('../?s=produtos');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;
}
?>