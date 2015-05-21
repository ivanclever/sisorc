<?php
require('../util/conn.php');
require('../util/util.php');
require('../util/auth.php');
LimpaPost($_POST);
extract($_POST);
$do = $_REQUEST['do'];

switch ($do) {
	case 'cadastra':
		#ValidaVazio($nome,'Campo Nome inválido');
		#ValidaVazio($categoria,'Selecione uma Categoria');

		$_SESSION['precos'] = $_POST;
		// echo '<pre>';
		// print_r($_POST);
		// die;

		if (semErros()) {
			if (mysql_query("INSERT INTO precos
					(CodProduto, CodFornecedor, CodCor, CodTipoPoda, CodUnidadeMedida, Porte, DiametroCopa, DiametroTronco, AlturaTronco, Valor, UnidadesPorCaixa, Ranking, DataCadastra)
				VALUES
					('$produto', '$id_fornecedor', '$cor', '$poda', '$medida', '$porte','$copa', '$tronco', '$altura_tronco', '$valor', '$unidades', '$ranking', NOW())")) {
				Info('Preço de Custo cadastrado com sucesso');
				Go('../?s=precos-custo&id='.$produto);
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;
	case 'exclui':
		$id = (int)$_GET['id'];
		if (mysql_query("DELETE FROM precos WHERE CodProduto = '$id'")) {
			Info ("Preço de Custo removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go();
	break;
	case 'altera':
		ValidaID($id,'CodPreco','precos');
		#ValidaVazio($nome,'Campo Nome inválido');
		#ValidaVazio($categoria,'Selecione uma Categoria');

		if (semErros()) {
			if (mysql_query("UPDATE precos 
					SET
						CodFornecedor='$id_fornecedor',
						CodCor='$cor',
						CodTipoPoda='$poda',
						CodUnidadeMedida='$medida',
						Porte='$porte',
						DiametroCopa='$copa',
						DiametroTronco='$tronco',
						AlturaTronco='$altura_tronco',
						Valor='$valor',
						UnidadesPorCaixa='$unidades',
						Ranking='$ranking'
					WHERE
						CodPreco = '$id'")) {
				Info('Preço de Custo alterado com sucesso');
				Go('../?s=precos-custo&id='.$produto);
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;
}
?>