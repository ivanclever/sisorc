<?php
$rs_vegetais = mysql_query("SELECT * FROM orcespeciesvegetais WHERE CodOrcamento = '$id'");
while($r_vegetais = mysql_fetch_assoc($rs_vegetais)):

	$CodOrcEspecieVegetal 		=	$r_vegetais['CodOrcEspecieVegetal'];
	$CodPrecoVeg			 	=	$r_vegetais['CodPreco'];
	$QuantidadeVeg 				=	$r_vegetais['Quantidade'];
	$DistanciaPlantioVeg 		=	$r_vegetais['DistanciaPlantio'];
	$ObservacoesVeg 			=	$r_vegetais['Observacoes'];
	$LucroVeg					=	$r_vegetais['Lucro'];
	#$ValorTotalVeg 				=	$r_vegetais['ValorTotal'];

	$rs_preco_veg = mysql_query("SELECT Valor FROM precos WHERE CodPreco = '$CodPrecoVeg'");
	$r_preco_veg = mysql_fetch_assoc($rs_preco_veg);
	$ValorVeg =	$r_preco_veg['Valor'];

	//atualiza valor total do produto
	//$ValorTotalVeg = $r_preco_veg['Valor']*$QuantidadeVeg;
	
	$ValorTotalVeg = $ValorVeg*$QuantidadeVeg;
	
	
	mysql_query("UPDATE orcespeciesvegetais 
					SET 	Valor='$ValorVeg', ValorTotal='$ValorTotalVeg'
					WHERE 	CodOrcEspecieVegetal = '$CodOrcEspecieVegetal'");

endwhile;
?>