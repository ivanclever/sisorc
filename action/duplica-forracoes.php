<?php
$rs_forracoes = mysql_query("SELECT * FROM orcforracoes WHERE CodOrcamento = '$id'");
while($r_forracoes = mysql_fetch_assoc($rs_forracoes)):
	$CodPrecoFor			 	=	$r_forracoes['CodPreco'];
/*
	$rs_preco_for = mysql_query("SELECT precos.Valor, precos.UnidadesPorCaixa, unidadesmedida.Sigla FROM precos, unidadesmedida WHERE precos.CodUnidadeMedida = unidadesmedida.CodUnidadeMedida AND precos.CodPreco = '$CodPrecoFor'");
	$r_preco_for = mysql_fetch_assoc($rs_preco_for);
	$valorFor = $r_preco_for['Valor'];
*/
	$CodOrcForracao		 		=	$r_forracoes['CodOrcForracao'];
	$QtdeM2		 				=	$r_forracoes['QtdeM2'];
	$DistanciaPlantioFor 		=	$r_forracoes['DistanciaPlantio'];
	$QtdeCX 					=	$r_forracoes['QtdeCaixasMudas'];
	$ValorFor 					=	$r_forracoes['Valor'];
	$ObservacoesFor				=	$r_forracoes['Observacoes'];
	$LucroFor 					=	$r_forracoes['Lucro'];
	$ValorTotalFor 				=	$r_forracoes['ValorTotal'];
	$quantidade_mudas_m2		=	$r_forracoes['quantidade_mudas_m2'];
	$ValorFor					= 	$r_forracoes['Valor'];
/*
	if($r_preco_for['Sigla'] == 'cx') {
		switch ($DistanciaPlantioFor) {
			case '10':
				$totalMudas = ($QtdeM2*100);
			break;
			case '15':
				$totalMudas = ($QtdeM2*45);
			break;
			case '20':
				$totalMudas = ($QtdeM2*25);
			break;
			case '25':
				$totalMudas = ($QtdeM2*16);
			break;
			case '30':
				$totalMudas = ($QtdeM2*12);
			break;
			case '35':
				$totalMudas = ($QtdeM2*9);
			break;
			case '40':
				$totalMudas = ($QtdeM2*7);
			break;
			case '45':
				$totalMudas = ($QtdeM2*5);
			break;
			case '50':
				$totalMudas = ($QtdeM2*4);
			break;
		}

		$totalCX = ($totalMudas/$r_preco_for['UnidadesPorCaixa']);

		$ValorTotalFor = ($valorFor*$totalCX);
	}

	if($r_preco_for['Sigla'] == 'md') {

		switch ($distancia) {
			case '10':
				$totalMudas = ($QtdeM2*100);
			break;
			case '15':
				$totalMudas = ($QtdeM2*45);
			break;
			case '20':
				$totalMudas = ($QtdeM2*25);
			break;
			case '25':
				$totalMudas = ($QtdeM2*16);
			break;
			case '30':
				$totalMudas = ($QtdeM2*12);
			break;
			case '35':
				$totalMudas = ($QtdeM2*9);
			break;
			case '40':
				$totalMudas = ($QtdeM2*7);
			break;
			case '45':
				$totalMudas = ($QtdeM2*5);
			break;
			case '50':
				$totalMudas = ($QtdeM2*4);
			break;
		}

		//$totalCX = ($totalMudas/$UnidadesPorCaixa);

		$ValorTotalFor = ($valorFor*$totalMudas);
	}

	if($r_preco_for['Sigla'] == 'm2') {

		$ValorTotalFor = ($valorFor*$QtdeM2);

	}
*/
	mysql_query("INSERT INTO orcforracoes
						(CodOrcamento, CodPreco, QtdeM2, QtdeCaixasMudas, DistanciaPlantio, quantidade_mudas_m2, Valor, ValorTotal, Observacoes, Lucro) 
					VALUES
						('$NovoOrcamento', '$CodPrecoFor', '$QtdeM2', '$QtdeCX', '$DistanciaPlantioFor', '$quantidade_mudas_m2', '$ValorFor', '$ValorTotalFor', '$ObservacoesFor', '$LucroFor')");
endwhile;

?>