<?php
require('../util/conn.php');
require('../util/util.php');
require('../util/auth.php');
LimpaPost($_POST);
extract($_POST);
$do = $_REQUEST['do'];

switch ($do) {
	case 'cadastra':
		ValidaVazio($modelo,'Campo Modelo obrigatório');
		ValidaVazio($id_fornecedor,'Selecione um Fornecedor');

		$_SESSION['vasos'] = $_POST;

		if (semErros()) {
			if (mysql_query("INSERT INTO vasos
					(CodFornecedor, CodigoFornecedor, CodRevestimento, Modelo, Dimensoes, Bandeja, Valor, status, DataCadastra)
				VALUES
					('$id_fornecedor', '$cod_fornecedor', '$revestimento', '$modelo', '$dimensoes', '$bandeja', '$valor', '1', NOW())")) {
				unset($_SESSION['vasos']);
				Info('Vaso cadastrado com sucesso');
				Go('../?s=vasos');
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;
	case 'exclui':
		$id = $_REQUEST['id'];
		if (mysql_query("UPDATE vasos SET status='0' WHERE CodVaso = '$id'")) {
			unset($_SESSION['vasos']);
			//Info ("Vaso removido com sucesso");
		} else Erro("Erro durante a exclusão");
		//Go();
	break;
	case 'ativa':
		$id = (int)$_GET['id'];
		if (mysql_query("UPDATE vasos SET status='1' WHERE CodVaso = '$id'")) {
			Info ("Vaso ativado com sucesso");
		} else Erro("Erro durante a atualização");
		Go();
	break;
	case 'altera':
		ValidaID($id,'CodVaso','vasos');
		ValidaVazio($modelo,'Campo Modelo obrigatório');
		ValidaVazio($id_fornecedor,'Selecione um Fornecedor');
		//$data = DateToUs($data);
		//
		// echo '<pre>';
		// print_r($_POST);
		// die;

		if (semErros()) {
			if (mysql_query("UPDATE vasos 
					SET
						CodFornecedor='$id_fornecedor',
						CodigoFornecedor='$cod_fornecedor',
						CodRevestimento='$revestimento',
						Modelo='$modelo',
						Dimensoes='$dimensoes',
						Bandeja='$bandeja',
						Valor='$valor',
						DataCadastra=NOW()
					WHERE
						CodVaso = '$id'")) {
				Info('Vaso alterado com sucesso');
				//Go('../?s=vasos');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;
	
	case 'alteravalor':
		ValidaID($id,'CodVaso','vasos');
		ValidaVazio($valor,'Campo Valor obrigatório');

		if (semErros()) {
			if (mysql_query("UPDATE vasos 
					SET
						Valor='$valor',
						DataCadastra=NOW()
					WHERE
						CodVaso = '$id'")) {
				Info('Vaso alterado com sucesso');
				//Go('../?s=vasos');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;
	
	
	case 'copy':
		$id = (int)$_GET['id'];
		//ValidaID($id,'CodPreco','precos');
		#ValidaVazio($nome,'Campo Nome inválido');

		$rs = mysql_query("SELECT * FROM vasos WHERE CodVaso = '$id'");
		$r = mysql_fetch_assoc($rs);
		
		$CodFornecedor 				= $r['CodFornecedor'];
		$CodigoFornecedor 				= $r['CodigoFornecedor'];
		$CodRevestimento 					= $r['CodRevestimento'];
		$Modelo				= $r['Modelo'];
		$Dimensoes			= $r['Dimensoes'];
		$Bandeja						= $r['Bandeja'];
		$Valor						= $r['Valor'];
		
		if (semErros()) {

			if (mysql_query("INSERT INTO vasos
					(CodFornecedor,
					CodigoFornecedor,
					CodRevestimento,
					Modelo,
					Dimensoes,
					Bandeja,
					Valor,
					DataCadastra,
					status)
				VALUES
					('$CodFornecedor',
					'$CodigoFornecedor',
					'$CodRevestimento',
					'$Modelo',
					'$Dimensoes',
					'$Bandeja',
					'$Valor',
					NOW(),
					1
				)")) {
				$ls = mysql_query("SELECT LAST_INSERT_ID() as lastid");
				$l = mysql_fetch_assoc($ls);
				Info('Preço duplicado com sucesso');
				Go('../?s=vasos&id='.$l["lastid"]);
			} else {
				Erro('Erro durante a duplicação, tente novamente');
			}
		}
	break;
}
?>