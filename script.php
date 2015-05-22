<?php
require('util/conn.php');
require('util/util.php');
ob_implicit_flush(true);
//orcamentos
$rs = mysql_query("SELECT * FROM orcamentos");

while($r = mysql_fetch_assoc($rs)):
	mysql_query("update sisorc.orcamentos set LucroGE=Lucro where (LucroGe is null or LucroGE=0) and CodOrcamento='$r[CodOrcamento]'");
	/*
	$rs_vegetais = mysql_query("SELECT CodOrcEspecieVegetal, Valor, Quantidade FROM orcespeciesvegetais WHERE CodOrcamento = '$r[CodOrcamento]'");

	while($r_vegetais = mysql_fetch_assoc($rs_vegetais)):
		$r_vegetais['Quantidade'] = str_replace(",", ".", $r_vegetais['Quantidade']);
		//atualiza valor total do produto
		$valorTotal = $r_vegetais['Valor']*$r_vegetais['Quantidade'];
		$valorTotal = sprintf('%0.2f', $valorTotal);
		mysql_query("UPDATE orcespeciesvegetais SET ValorTotal='$valorTotal' WHERE CodOrcEspecieVegetal = '$r_vegetais[CodOrcEspecieVegetal]'");
	echo "id: ". $r_vegetais[CodOrcEspecieVegetal]. " Valor: ". $valor . " - Quantidade: ". $r_vasos['Quantidade'].  " - ValorTotal: ". $valortotal. "<br/>";
	endwhile;
	*/
	/*
	$rs_diversos = mysql_query("SELECT CodOrcDiverso, Valor, Quantidade FROM orcdiversos WHERE CodOrcamento = '$r[CodOrcamento]'");

	while($r_diversos = mysql_fetch_assoc($rs_diversos)):
		$r_diversos['Quantidade'] = str_replace(",", ".", $r_diversos['Quantidade']);
		//atualiza valor total do produto
		$valorTotal = $r_diversos['Valor']*$r_diversos['Quantidade'];
		$valorTotal = sprintf('%0.2f', $valorTotal);
		mysql_query("UPDATE orcdiversos SET ValorTotal='$valorTotal' WHERE CodOrcDiverso = '$r_diversos[CodOrcDiverso]'");
echo "id: ". $r_diversos[CodOrcDiverso]. " Valor: ". $valor . " - Quantidade: ". $r_vasos['Quantidade'].  " - ValorTotal: ". $valortotal. "<br/>";
	endwhile;
	
	
*/
/*
	$rs_vasos = mysql_query("SELECT CodOrcVaso, Valor, Quantidade FROM orcvasos WHERE CodOrcamento = '$r[CodOrcamento]'");

	while($r_vasos = mysql_fetch_assoc($rs_vasos)):
		$r_vasos['Quantidade'] = str_replace(",", ".", $r_vasos['Quantidade']);
		//atualiza valor total do produto
		$valorTotal = $r_vasos['Valor']*$r_vasos['Quantidade'];
		$valorTotal = sprintf('%0.2f', $valorTotal);
		mysql_query("UPDATE orcvasos SET ValorTotal='$valorTotal' WHERE CodOrcVaso = '$r_vasos[CodOrcVaso]'");
	
	echo "id: ". $r_vasos[CodOrcVaso]. " Valor: ". $valor . " - Quantidade: ". $r_vasos['Quantidade'].  " - ValorTotal: ". $valortotal. "<br/>";
	
	endwhile;
	*/

	//forracoes
	/*
	$rs_forracoes = mysql_query("SELECT orcforracoes.CodOrcForracao, orcforracoes.Valor, orcforracoes.DistanciaPlantio, orcforracoes.QtdeM2, unidadesmedida.Sigla, precos.UnidadesPorCaixa
		FROM orcforracoes, precos, unidadesmedida 
		WHERE precos.CodUnidadeMedida = unidadesmedida.CodUnidadeMedida
		AND precos.CodPreco = orcforracoes.CodPreco
		AND orcforracoes.CodOrcamento = '$r[CodOrcamento]'
	");

	while($r_forracoes = mysql_fetch_assoc($rs_forracoes)):
		$unidade 			= $r_forracoes['Sigla'];
		$quantidade 		= $r_forracoes['QtdeM2'];
		$distancia 			= $r_forracoes['DistanciaPlantio'];
		$valor 				= $r_forracoes['Valor'];
		$UnidadesPorCaixa	= $r_forracoes['UnidadesPorCaixa'];

		if($unidade == 'cx') {
			switch ($distancia) {
				case '10':
					$totalMudas = ($quantidade*100);
				break;
				case '15':
					$totalMudas = ($quantidade*45);
				break;
				case '20':
					$totalMudas = ($quantidade*25);
				break;
				case '25':
					$totalMudas = ($quantidade*16);
				break;
				case '30':
					$totalMudas = ($quantidade*12);
				break;
				case '35':
					$totalMudas = ($quantidade*9);
				break;
				case '40':
					$totalMudas = ($quantidade*7);
				break;
				case '45':
					$totalMudas = ($quantidade*5);
				break;
				case '50':
					$totalMudas = ($quantidade*4);
				break;
			}

			$totalCX = ($totalMudas/$UnidadesPorCaixa);
			$totalCX = ceil($totalCX);
			$ValorTotal = ($valor*$totalCX);
		}

		if($unidade == 'md') {

			switch ($distancia) {
				case '10':
					$totalMudas = ($quantidade*100);
				break;
				case '15':
					$totalMudas = ($quantidade*45);
				break;
				case '20':
					$totalMudas = ($quantidade*25);
				break;
				case '25':
					$totalMudas = ($quantidade*16);
				break;
				case '30':
					$totalMudas = ($quantidade*12);
				break;
				case '35':
					$totalMudas = ($quantidade*9);
				break;
				case '40':
					$totalMudas = ($quantidade*7);
				break;
				case '45':
					$totalMudas = ($quantidade*5);
				break;
				case '50':
					$totalMudas = ($quantidade*4);
				break;
			}

			$ValorTotal = ($valor*$totalMudas);
			
		}

		if($unidade == 'm2') {

			$ValorTotal = ($valor*$quantidade);

		}
		
		if($unidade != 'm2' && $unidade != 'cx' && $unidade !='md') {
			$ValorTotal = ($valor*$quantidade);
		}
		
		$ValorTotal = sprintf('%0.2f', $ValorTotal);
		
		
		echo "ID orc forracao: " .$r_forracoes[CodOrcForracao]. " - total caixas: " .$totalCX. " - unidade: " .$unidade. " - Qtde M2: ". $quantidade . " - distancia: ". $distancia . " - UnidadesPorCaixa: ". $UnidadesPorCaixa . " - Valor: ". $valor .  " - ValorTotal: ". $ValorTotal. "<br/>";
		
		
		
		mysql_query("UPDATE orcforracoes SET ValorTotal='$ValorTotal' WHERE CodOrcForracao = '$r_forracoes[CodOrcForracao]'");

	endwhile;
	*/
	echo $r[CodOrcamento];
flush();
endwhile;

echo "script ok";

?>