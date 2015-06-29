<?php
$rs_diversos = mysql_query("SELECT * FROM orcdiversos WHERE CodOrcamento = '$id'");
while($r_diversos = mysql_fetch_assoc($rs_diversos)):

	$CodOrcDiv		 			=	$r_diversos['CodOrcDiverso'];
	$CodPrecoDiv			 	=	$r_diversos['CodPreco'];
	$QuantidadeDiv		 		=	$r_diversos['Quantidade'];
	$ObservacoesDiv				=	$r_diversos['Observacoes'];
	$ValorDiv 					=	$r_diversos['Valor'];
	$LucroDiv 					=	$r_diversos['Lucro'];
	$ValorTotalDiv 				=	$r_diversos['ValorTotal'];
/*
	$rs_preco_div = mysql_query("SELECT Valor FROM precos WHERE CodPreco = '$CodPrecoDiv'");
	$r_preco_div = mysql_fetch_assoc($rs_preco_div);
	$ValorDiv =	$r_preco_div['Valor'];

	//atualiza valor total do produto
	$ValorTotalDiv = $r_preco_div['Valor']*$QuantidadeDiv;
*/
	mysql_query("INSERT INTO orcdiversos
						(CodOrcamento, CodPreco, Quantidade, Valor, Observacoes, Lucro, ValorTotal) 
					VALUES
						('$NovoOrcamento', '$CodPrecoDiv', '$QuantidadeDiv', '$ValorDiv', '$ObservacoesDiv', '$LucroDiv', '$ValorTotalDiv')");

endwhile;
?>