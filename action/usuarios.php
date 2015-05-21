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
		ValidaSenha($senha,$conf);
		ValidaVazio($login,'Campo login inválido');
		if (semErros()) {
			$senha = md5($senha.'System');
			if (mysql_query("INSERT INTO usuarios (login, senha, nome) VALUES ('$login', '$senha', '$nome')")) {
				Info('Usuário cadastrado com sucesso');
				Go('../?s=usuarios');
			} else Erro("Erro durante cadastro do usuário");
		}
		Go();
	break;
	case 'exclui':
		$id = (int)$_GET['id'];
		if (mysql_query("DELETE FROM usuarios WHERE id = '$id'")) {
			Info ("Usuário removido com sucesso");
		} else Erro("Erro durante a consulta");
		Go();
	break;
	case 'altera':

		ValidaID($id,'id','usuarios');
		if (!empty($senha)) {
			ValidaSenha($senha,$conf);
			$senha = md5($senha.'System');
		} else {
			$rs = mysql_query("SELECT senha FROM usuarios WHERE id = '$id'");
			$r = mysql_fetch_assoc($rs);
			$senha = $r['senha'];
		}
		ValidaVazio($nome,'Campo nome inválido');

		if (semErros()) {
			if (mysql_query("UPDATE usuarios SET nome='$nome', senha='$senha' WHERE id = '$id'")) {
				Info('Usuário alterado com sucesso');
				Go('../?s=usuarios');
			} else {
				Erro('Erro durante a consulta');
			}
		}
		Go();
	break;
}
?>