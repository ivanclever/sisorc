<?php
$rs_vasos = mysql_query("SELECT * FROM orcvasos WHERE CodOrcamento = '$id'");
while($r_vasos = mysql_fetch_assoc($rs_vasos)):

	$CodOrcVas		 			=	$r_vasos['CodOrcVaso'];
	$CodVaso			 		=	$r_vasos['CodVaso'];
	$CodCor						=	$r_vasos['CodCor'];
	$Codigo 				 	=	$r_vasos['Codigo'];
	$Conteudo					=	$r_vasos['Conteudo'];
	$QuantidadeVas				=	$r_vasos['Quantidade'];
	#$ValorVas 					=	$r_vasos['Valor'];
	$LucroVas 					=	$r_vasos['Lucro'];
	#$ValorTotalVas 			=	$r_vasos['ValorTotal'];

	$rs_preco_vas = mysql_query("SELECT Valor FROM vasos WHERE CodVaso = '$CodVaso'");
	$r_preco_vas = mysql_fetch_assoc($rs_preco_vas);
	$ValorVas =	$r_preco_vas['Valor'];

	//atualiza valor total do produto
	$ValorTotalVas = $r_preco_vas['Valor']*$QuantidadeVas;

	mysql_query("INSERT INTO orcvasos
					(CodOrcamento, CodVaso, CodCor, Codigo, Quantidade, Valor, Conteudo, Lucro, ValorTotal) 
				VALUES
					('$NovoOrcamento', '$CodVaso', '$CodCor', '$Codigo', '$QuantidadeVas', '$ValorVas', '$Conteudo', '$LucroVas', '$ValorTotalVas')");
endwhile;
?>