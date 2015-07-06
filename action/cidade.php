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
		
		$BuscaId = mysql_query("SELECT (CodCidade+1) AS NvID FROM cidades ORDER BY CodCidade DESC LIMIT 0,1");
		$Linha = mysql_fetch_assoc($BuscaId);
		$Nv_Id = $Linha['NvID'];
		
		$Salvar="INSERT INTO  cidades (CodCidade, Nome, CodEstado) VALUES ('$Nv_Id', '$nome', '$uf')";
		
		if (semErros()) {
			if (mysql_query($Salvar)) {
				Info('Cadastrado realizado com sucesso');
				unset($_SESSION['cidade']);
				Go('../?s=cidade');
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;
	
	
	case 'altera':
//		ValidaID($id,'CodCidade','cidade');
		$id = (int)$_GET['id'];
		
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