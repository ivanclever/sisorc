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
		
		$BuscaId = mysql_query("SELECT (CodEstado+1) AS NvID FROM estados ORDER BY CodEstado DESC LIMIT 0,1");
		$Linha = mysql_fetch_assoc($BuscaId);
		$Nv_Id = $Linha['NvID'];
		
		if (semErros()) {
			$Salvar = "INSERT INTO  estados (CodEstado, Nome, UF) VALUES ('$Nv_Id', '$nome', '$uf')";
			if (mysql_query($Salvar)) {
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