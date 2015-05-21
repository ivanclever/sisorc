<?php
require('../util/conn.php');
require('../util/util.php');
require('../util/auth.php');
LimpaPost($_POST);
extract($_POST);
$do = $_REQUEST['do'];

switch ($do) {
	case 'cadastra':
		ValidaVazio($medida,'Campo Medida inválido');

		$_SESSION['precos'] = $_POST;
		// echo '<pre>';
		// print_r($_POST);
		// die;

		if (semErros()) {
			if (mysql_query("INSERT INTO precos
					(CodProduto, CodFornecedor, CodCor, CodTipoPoda, CodUnidadeMedida, Porte, DiametroCopa, DiametroTronco, AlturaTronco, Valor, UnidadesPorCaixa, Ranking, DataCadastra)
				VALUES
					('$produto', '$id_fornecedor', '$cor', '$poda', '$medida', '$porte','$copa', '$tronco', '$altura_tronco', '$valor', '$unidades', '$ranking', NOW())")) {
				unset($_SESSION['precos']);
				Info('Preço de Custo cadastrado com sucesso');
				Go('../?s=precos-custo&id='.$produto);
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;
	case 'exclui':
		$id = $_REQUEST['id'];
		if (mysql_query("UPDATE precos 
					SET
						status='0'
					WHERE
						CodPreco = '$id'")) {
			//Info ("Preço de Custo removido com sucesso");
		} else Erro("Erro durante a exclusão");
		#Go();
	break;
	case 'ativa':
		$id = $_REQUEST['id'];
		if (mysql_query("UPDATE precos 
					SET
						status='1'
					WHERE
						CodPreco = '$id'")) {
			Info ("Preço de Custo ativado com sucesso");
		} else Erro("Erro durante a exclusão");
		Go();
	break;
	case 'altera':

		//ValidaID($id,'CodPreco','precos');
		#ValidaVazio($nome,'Campo Nome inválido');
		$valor = str_replace(",", ".", $valor);
		$valor = sprintf('%0.2f', $valor);
		//if (semErros()) {
		
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
						DataCadastra=NOW()
					WHERE
						CodPreco = '$id'")) {
				echo "Produto alterado com sucesso";
				#Go('../?s=precos-custo&id='.$produto);
			} 
			else {
				echo "Erro durante a alteração, tente novamente";
			}
		//}
		#Go();
	break;
	case 'alteravalor':

		//ValidaID($id,'CodPreco','precos');
		ValidaVazio($valor,'Campo Valor inválido');
		$valor = str_replace(",", ".", $valor);
		$valor = sprintf('%0.2f', $valor);
		//if (semErros()) {
		
			if (mysql_query("UPDATE precos 
					SET
						Valor='$valor',
						DataCadastra=NOW()
					WHERE
						CodPreco = '$id'")) {
				//echo "Preço do produto alterado com sucesso";
				#Go('../?s=precos-custo&id='.$produto);
			} 
			else {
				echo "Erro durante a alteração, tente novamente";
			}
		//}
		#Go();
	break;

	case 'copy':
		$id = (int)$_GET['id'];
		//ValidaID($id,'CodPreco','precos');
		#ValidaVazio($nome,'Campo Nome inválido');

		$rs = mysql_query("SELECT * FROM precos WHERE CodPreco = '$id'");
		$r = mysql_fetch_assoc($rs);

		$CodProduto 				= $r['CodProduto'];
		$CodFornecedor 				= $r['CodFornecedor'];
		$CodCor 					= $r['CodCor'];
		$CodTipoPoda				= $r['CodTipoPoda'];
		$CodUnidadeMedida			= $r['CodUnidadeMedida'];
		$Porte						= $r['Porte'];
		$DiametroCopa				= $r['DiametroCopa'];
		$DiametroTronco				= $r['DiametroTronco'];
		$AlturaTronco				= $r['AlturaTronco'];
		$Valor						= $r['Valor'];
		$UnidadesPorCaixa			= $r['UnidadesPorCaixa'];
		$Ranking					= $r['Ranking'];

		if (semErros()) {

			if (mysql_query("INSERT INTO precos
					(CodProduto,
					CodFornecedor,
					CodCor,
					CodTipoPoda,
					CodUnidadeMedida,
					Porte,
					DiametroCopa,
					DiametroTronco,
					AlturaTronco,
					Valor,
					UnidadesPorCaixa,
					Ranking,
					DataCadastra)
				VALUES
					('$CodProduto',
					'$CodFornecedor',
					'$CodCor',
					'$CodTipoPoda',
					'$CodUnidadeMedida',
					'$Porte',
					'$DiametroCopa',
					'$DiametroTronco',
					'$AlturaTronco',
					'$Valor',
					'$UnidadesPorCaixa',
					'$Ranking',
					NOW()
				)")) {
				$ls = mysql_query("SELECT LAST_INSERT_ID() as lastid");
				$l = mysql_fetch_assoc($ls);
				Info('Preço de custo duplicado com sucesso');
				Go('../?s=precos-custo&id='.$CodProduto.'&preco='.$l["lastid"]);
			} else {
				Erro('Erro durante a duplicação, tente novamente');
			}
		}
		Go();
	break;
}
?>