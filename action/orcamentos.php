<?php
require('../util/conn.php');
require('../util/util.php');
require('../util/auth.php');
LimpaPost($_POST);
extract($_POST);
$do = $_REQUEST['do'];

switch ($do) {
	case 'cadastra':
		ValidaVazio($job,'Campo Job Obrigatório');
		ValidaVazio($obra,'Campo Obra Obrigatório');
		ValidaVazio($id_cliente,'Campo Cliente Obrigatório');

		$_SESSION['orcamentos'] = $_POST;

		$checkJob = mysql_query("SELECT id FROM orcamentos WHERE JOB = '$job'");
		if(mysql_num_rows($checkJob)>0) {
			Erro('JOB já consta no sistema'); Go();
		}

		$checkObra = mysql_query("SELECT id FROM orcamentos WHERE Obra = '$obra'");
		if(mysql_num_rows($checkObra)>0) {
			Erro('Nome da Obra já consta no sistema'); Go();
		}

		if (semErros()) {
			if (mysql_query("INSERT INTO orcamentos
					(CodCliente, JOB, Obra, DataCadastra)
				VALUES
					('$id_cliente', '$job', '$obra', NOW())")) {
				$id = mysql_insert_id();

				Info('Orçamento cadastrado com sucesso. Agora insira os produtos.');
				Go('../?s=orcamentos-produtos&id='.$id);
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;

	#TITULO VEGETAIS
	case 'tituloVegetais':
		mysql_query("UPDATE orcamentos SET TituloEspeciesVegetais='$titulo', LucroEspeciesVegetais='$lucroVegetais' WHERE CodOrcamento = '$id_orcamento'");

		Info('Orçamento atualizado com sucesso');
		Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#vegetais');
	break;

	#VEGETAIS
	case 'CadProdutoVegetais':
		//ValidaVazio($id_produto_vegetais,'Campo Produto Obrigatório');
		ValidaVazio($quantidade,'Campo Quantidade Obrigatório');
		//echo $quantidade; die();
		$quantidade = str_replace(",", ".", $quantidade); 
		//echo $quantidade; die();
		if (semErros()) {
			if (mysql_query("INSERT INTO orcespeciesvegetais
						(CodOrcamento, CodPreco, Quantidade, DistanciaPlantio, Valor, Observacoes, Lucro) 
					VALUES
						('$id_orcamento', '$id_preco_vegetais', '$quantidade', '$distancia', '$valor', '$observacoes', '$lucro')")) {
				$CodOrcEspecieVegetal = mysql_insert_id();

				//atualiza valor total do produto
				$valorTotal = $valor*$quantidade;

				mysql_query("UPDATE orcespeciesvegetais SET ValorTotal='$valorTotal' WHERE CodOrcEspecieVegetal = '$CodOrcEspecieVegetal'");

				Info('Produto cadastrado com sucesso');
				Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#vegetais');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;

	case 'AlteraVegetais':
		//ValidaVazio($quantidade,'Campo Quantidade Obrigatório');
		$quantidade = str_replace(",", ".", $quantidade); 
		
		if (semErros()) {

			//cadastra produto
			if (mysql_query("UPDATE orcespeciesvegetais 
					SET 	Quantidade='$quantidade', DistanciaPlantio='$distancia', Observacoes='$obs', Valor='$valor', Lucro='$lucro'
					WHERE 	CodOrcEspecieVegetal = '$id'")) {

				$valorTotal = $valor*$quantidade;

				mysql_query("UPDATE orcespeciesvegetais SET ValorTotal='$valorTotal' WHERE CodOrcEspecieVegetal = '$id'");

				//Info('Produto alterado com sucesso');
				echo sprintf('%0.2f', $valorTotal);
				//Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#vegetais');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		//Go();
	break;
	
	case 'AlteraItemOrcamento':
		//ValidaVazio($quantidade,'Campo Quantidade Obrigatório');
		$quantidade = str_replace(",", ".", $quantidade); 
		$novovalortotal = $novovalor*$quantidade;
		if (semErros()) {
			if($tipo=="vegetais"){
			$query = "UPDATE orcespeciesvegetais 
					SET 	Valor='$novovalor', ValorTotal='$novovalortotal', CodPreco='$novocodpreco'  
					WHERE 	CodOrcEspecieVegetal = '$id'";
			}elseif($tipo=="forracoes"){
				$query = "UPDATE orcforracoes   
					SET 	Valor='$novovalor', ValorTotal='$novovalortotal', CodPreco='$novocodpreco' 
					WHERE 	CodOrcForracao = '$id'";
			}
			elseif($tipo=="diversos"){
				$query = "UPDATE orcdiversos   
					SET 	Valor='$novovalor', ValorTotal='$novovalortotal', CodPreco='$novocodpreco' 
					WHERE 	CodOrcDiverso = '$id'";
			}elseif($tipo=="vasos"){
				$query = "UPDATE orcvasos   
					SET 	Valor='$novovalor', ValorTotal='$novovalortotal', CodPreco='$novocodpreco' 
					WHERE 	CodOrcVaso = '$id'";
			}
			
			//cadastra produto
			if (mysql_query($query)) {

				//Info('Produto alterado com sucesso');
				echo sprintf('%0.2f', $valorTotal);
				
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		//Go('../?s=orcamentos-produtos&id='.$CodOrcamento.'#'.$tipo);
	break;

	case 'excluiVegetais':
		$id = (int)$_GET['id'];
		$id_orcamento = (int)$_GET['id_orcamento'];
		if (mysql_query("DELETE FROM orcespeciesvegetais WHERE CodOrcEspecieVegetal = '$id'")) {
			Info ("Produto removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#vegetais');
	break;

	#TITULO FORRAÇÕES
	case 'tituloForracoes':
		mysql_query("UPDATE orcamentos SET TituloForracoes='$titulo', LucroForracoes='$lucro' WHERE CodOrcamento = '$id_orcamento'");

		Info('Orçamento atualizado com sucesso');
		Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#forracoes');
	break;

	#FORRACOES
	case 'CadProdutoForracoes':
		ValidaVazio($id_produto_forracoes,'Campo Produto Obrigatório');
		ValidaVazio($quantidade,'Campo Quantidade Obrigatório');
		//ValidaVazio($distancia,'Campo Distância Obrigatório');
		
		$quantidade = str_replace(",", ".", $quantidade); 
		$valor = str_replace(",", ".", $valor); 
		$valor = sprintf('%0.2f', $valor);
		
		$_SESSION['orcamentos'] = $_POST;

		if($unidade == 'cx') {
			if($qm2 ==""){//se quantidade de mudas por metro2 nao definido
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
			}else{
				$totalMudas = $qm2 * $quantidade;
			}

			$totalCX = ($totalMudas/$UnidadesPorCaixa);
			//$totalCX = $totalCX);
			$ValorTotal = ($valor*$totalCX);
		}elseif ($unidade == 'm2') {

			$ValorTotal = ($valor*$quantidade);

		}else{
			if($qm2 ==""){
				switch ($distancia) {
					case '10':
						$totalMudas = ($quantidade*100);
					break;
					case '15':
						$totalMudas = ($quantidade*45);
					break;
					case '18':
						$totalMudas = ($quantidade*30);
					break;
					case '20':
						$totalMudas = ($quantidade*25);
					break;
					case '22':
						$totalMudas = ($quantidade*20);
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
			}else{
				$totalMudas = $qm2 * $quantidade;
			}

			//$totalCX = ($totalMudas/$UnidadesPorCaixa);
			$ValorTotal = ($valor*$totalMudas);
		}

		

		if (semErros()) {

			if (mysql_query("INSERT INTO orcforracoes
							(CodOrcamento, CodPreco, QtdeM2, QtdeCaixasMudas, DistanciaPlantio, Valor, ValorTotal, Observacoes, Lucro, quantidade_mudas_m2) 
						VALUES
							('$id_orcamento', '$id_preco_forracoes', '$quantidade', '$totalCX', '$distancia', '$valor', '$ValorTotal', '$observacoes', '$lucro', '$qm2')")) {

				mysql_query("UPDATE orcamentos SET TituloForracoes='$titulo', LucroForracoes='$lucro' WHERE	CodOrcamento = '$id_orcamento'");

				Info('Produto cadastrado com sucesso');
				Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#forracoes');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;

	case 'AlteraForracoes':
		//ValidaVazio($id_produto_forracoes,'Campo Produto Obrigatório');
		//ValidaVazio($quantidade,'Campo Quantidade Obrigatório');
		//ValidaVazio($distancia,'Campo Distância Obrigatório');
		$_SESSION['orcamentos'] = $_POST;
		
		//print_r($_POST);
		//echo $valor;
		//die();
		
		$quantidade = str_replace(",", ".", $quantidade); 
		$valor = str_replace(",", ".", $valor); 
		//$valor = sprintf('%0.2f', $valor);
		
		if($unidade == 'cx') {
			if($qm2 ==""){
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
			}else{
				$totalMudas = $qm2 * $quantidade;
			}

			$totalCX = ($totalMudas/$UnidadesPorCaixa);

			$ValorTotal = ($valor*$totalCX);
		}elseif($unidade == 'm2') {
			$ValorTotal = ($valor*$quantidade);
		}else{
			if($qm2 ==""){
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
			}else{
				$totalMudas = $qm2 * $quantidade;
			}

			$ValorTotal = ($valor*$totalMudas);
		}

		$ValorTotal = sprintf('%0.2f', $ValorTotal);
		
		//if (semErros()) {
			if (mysql_query("UPDATE orcforracoes 
					SET
						QtdeM2='$quantidade',
						QtdeCaixasMudas='$totalCX',
						DistanciaPlantio='$distancia',
						Valor='$valor',
						ValorTotal='$ValorTotal',
						Observacoes='$obs',
						Lucro='$lucro',
						quantidade_mudas_m2='$qm2'
					WHERE
						CodOrcForracao = '$id'")) {
				
				echo $ValorTotal;
				//Info('Produto alterado com sucesso');
				//Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#forracoes');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		//}
		//Go();
	break;

	case 'excluiForracoes':
		$id = (int)$_GET['id'];
		$id_orcamento = (int)$_GET['id_orcamento'];
		if (mysql_query("DELETE FROM orcforracoes WHERE CodOrcForracao = '$id'")) {
			Info ("Produto removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#forracoes');
	break;

	#TITULO DIVERSOS
	case 'tituloDiversos':
		mysql_query("UPDATE orcamentos SET TituloDiversos='$titulo', LucroDiversos='$lucro' WHERE CodOrcamento = '$id_orcamento'");

		Info('Orçamento atualizado com sucesso');
		Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#diversos');
	break;

	#DIVERSOS
	case 'CadProdutoDiversos':
		ValidaVazio($id_produto_diversos,'Campo Produto Obrigatório');
		ValidaVazio($quantidade,'Campo Quantidade Obrigatório');
		
		$quantidade = str_replace(",", ".", $quantidade); 
		
		$_SESSION['orcamentos'] = $_POST;

		if (semErros()) {
			if (mysql_query("INSERT INTO orcdiversos
							(CodOrcamento, CodPreco, Quantidade, Valor, Observacoes, Lucro) 
						VALUES
							('$id_orcamento', '$id_preco_diversos', '$quantidade', '$valor', '$observacoes', '$lucro')")) {
				$CodOrcDiverso = mysql_insert_id();

				$valorTotal = $valor*$quantidade;
				$valorTotal = sprintf('%0.2f', $valorTotal);
				mysql_query("UPDATE orcamentos SET TituloDiversos='$titulo', LucroDiversos='$lucroDiversos' WHERE CodOrcamento = '$id_orcamento'");
				mysql_query("UPDATE orcdiversos SET ValorTotal='$valorTotal' WHERE CodOrcDiverso = '$CodOrcDiverso'");

				Info('Produto cadastrado com sucesso');
				Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#diversos');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;

	case 'AlteraDiversos':
		//ValidaVazio($quantidade,'Campo Quantidade Obrigatório');
		if (semErros()) {
			
			$quantidade = str_replace(",", ".", $quantidade); 
			
			if (mysql_query("UPDATE orcdiversos 
					SET 	Quantidade='$quantidade', Valor='$valor', Lucro='$lucro', Observacoes='$obs'
					WHERE 	CodOrcDiverso = '$id'")) {

				$valorTotal = $valor*$quantidade;
				$valorTotal = sprintf('%0.2f', $valorTotal);
				
				mysql_query("UPDATE orcdiversos SET ValorTotal='$valorTotal' WHERE CodOrcDiverso = '$id'");

				//Info('Produto alterado com sucesso');
				//Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#diversos');
				echo sprintf('%0.2f', $valorTotal);
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		//Go();
	break;

	case 'excluiDiversos':
		$id = (int)$_GET['id'];
		$id_orcamento = (int)$_GET['id_orcamento'];
		if (mysql_query("DELETE FROM orcdiversos WHERE CodOrcDiverso = '$id'")) {
			Info ("Produto removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#diversos');
	break;

	#TITULO VASOS
	case 'tituloVasos':
		mysql_query("UPDATE orcamentos SET TituloVasos='$titulo', LucroVasos='$lucro' WHERE CodOrcamento = '$id_orcamento'");

		Info('Orçamento atualizado com sucesso');
		Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#vasos');
	break;

	#VASOS
	case 'CadProdutoVasos':
		ValidaVazio($id_produto_vasos,'Campo Vaso Obrigatório');
		ValidaVazio($quantidade,'Campo Quantidade Obrigatório');
		
		$quantidade = str_replace(",", ".", $quantidade); 
				
		if (semErros()) {
			if (mysql_query("INSERT INTO orcvasos
							(CodOrcamento, CodVaso, CodCor, Codigo, Quantidade, Valor, Conteudo, Lucro) 
						VALUES
							('$id_orcamento', '$id_produto_vasos', '$cor', '$codigo', '$quantidade', '$valor', '$conteudo', '$lucro')")) {
				$CodOrcVaso = mysql_insert_id();

				$valorTotal = $valor*$quantidade;
				$valorTotal = sprintf('%0.2f', $valorTotal);
				
				mysql_query("UPDATE orcvasos SET ValorTotal='$valorTotal' WHERE CodOrcVaso = '$CodOrcVaso'");

				Info('Produto cadastrado com sucesso');
				Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#vasos');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;

	case 'AlteraVasos':
		#ValidaVazio($quantidade,'Campo Quantidade Obrigatório');
		
		$quantidade = str_replace(",", ".", $quantidade); 
		
		if (semErros()) {
			if (mysql_query("UPDATE orcvasos SET Quantidade='$quantidade', Valor='$valor', Lucro='$lucro', ValorTotal='$valorTotal' WHERE CodOrcVaso = '$id'")) {

				$valorTotal = $valor*$quantidade;
				$valorTotal = sprintf('%0.2f', $valorTotal);
				
				mysql_query("UPDATE orcvasos SET ValorTotal='$valorTotal' WHERE CodOrcVaso = '$id'");

				echo sprintf('%0.2f', $valorTotal);
				#Info('Produto alterado com sucesso');
				#Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#vasos');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		#Go();
	break;

	case 'excluiVasos':
		$id = (int)$_GET['id'];
		$id_orcamento = (int)$_GET['id_orcamento'];
		if (mysql_query("DELETE FROM orcvasos WHERE CodOrcVaso = '$id'")) {
			Info ("Produto removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#vasos');
	break;

	//orcamento
	case 'exclui':
		$id = (int)$_GET['id'];
		if (mysql_query("UPDATE orcamentos SET status='0' WHERE CodOrcamento = '$id'")) {
			Info ("Orçamento desativado com sucesso");
		} else Erro("Erro durante a desativação");
		Go();
	break;
	
	case 'ativa':
		$id = (int)$_GET['id'];
		if (mysql_query("UPDATE orcamentos SET status='1' WHERE CodOrcamento = '$id'")){
			Info ("Orçamento ativado com sucesso");
		} else Erro("Erro durante a exclusão");
		Go();
	break;
	case 'calculaCusto':
		$CustoMA = LimpaPontoRetornaFloat($CustoMA);
		$CustoMO = LimpaPontoRetornaFloat($CustoMO);
		
		$somaCusto 		= $CustoMA+$CustoMO;
		$somaCusto		= sprintf('%0.2f', $somaCusto);
		
 		mysql_query("UPDATE orcamentos SET CustoMA='$CustoMA', CustoMO='$CustoMO', CustoGE='$somaCusto' WHERE CodOrcamento = '$CodOrcamento'");

 		echo $somaCusto;
	break;

	
	case 'calculaPrecoMO':
		
		$CustoMO = LimpaPontoRetornaFloat($CustoMO);
		
 		if($LucroMO != '' || $LucroMO != 0){
			$perc 			= $LucroMO / 100.0;
			$PrecoMO 		= $CustoMO + ($perc * $CustoMO);
			
		}else{
			$PrecoMO = $CustoMO;
		}
		$PrecoMO = sprintf('%0.2f', $PrecoMO);
		$CustoMO = sprintf('%0.2f', $CustoMO);
		
		mysql_query("UPDATE orcamentos SET CustoMO= '$CustoMO', PrecoMO='$PrecoMO', LucroMO='$LucroMO' WHERE CodOrcamento = '$CodOrcamento'");
		
 		echo $PrecoMO;
	break;
	
	case 'calculaPreco':
		$PrecoMA = LimpaPontoRetornaFloat($PrecoMA);
		$PrecoMO = LimpaPontoRetornaFloat($PrecoMO);
		
		$somaPreco = $PrecoMA+$PrecoMO;
		
		/* 
 		if($LucroGE != '' || $LucroGE != 0) {
 			$percGE 	= $LucroGE / 100.0;
 			$PrecoGE 	= $somaPreco + ($percGE * $somaPreco);
 		} else {
 			$PrecoGE = $somaPreco;
 		}
		*/
		$PrecoGE = sprintf('%0.2f', $somaPreco);
 		
		mysql_query("UPDATE orcamentos SET PrecoMA='$PrecoMA', PrecoMO='$PrecoMO', LucroMO='$LucroMO', LucroGE='$LucroGE', PrecoGE='$PrecoGE' WHERE CodOrcamento = '$CodOrcamento'");

 		echo $PrecoGE;
	break;

	case 'totalizaCusto':

		$rs_vegetais 	= mysql_query("SELECT SUM(ValorTotal) as ValorTotal FROM orcespeciesvegetais WHERE CodOrcamento = '$CodOrcamento'");
		$r_vegetais 	= mysql_fetch_assoc($rs_vegetais);

		$rs_forracoes 	= mysql_query("SELECT SUM(ValorTotal) as ValorTotal FROM orcforracoes WHERE CodOrcamento = '$CodOrcamento'");
		$r_forracoes 	= mysql_fetch_assoc($rs_forracoes);

		$rs_diversos 	= mysql_query("SELECT SUM(ValorTotal) as ValorTotal FROM orcdiversos WHERE CodOrcamento = '$CodOrcamento'");
		$r_diversos 	= mysql_fetch_assoc($rs_diversos);

		$rs_vasos	 	= mysql_query("SELECT SUM(ValorTotal) as ValorTotal FROM orcvasos WHERE CodOrcamento = '$CodOrcamento'");
		$r_vasos 		= mysql_fetch_assoc($rs_vasos);

		$totalMA 		= $r_vegetais['ValorTotal']+$r_forracoes['ValorTotal']+$r_diversos['ValorTotal']+$r_vasos['ValorTotal'];
		
		$totalMA = sprintf('%0.2f', $totalMA);
		
		mysql_query("UPDATE orcamentos SET CustoMA='$totalMA' WHERE CodOrcamento = '$CodOrcamento'");

		echo $totalMA;
		
	break;

	case 'totalizaPreco':

		$rs = mysql_query("SELECT LucroEspeciesVegetais, LucroForracoes, LucroDiversos, LucroVasos FROM orcamentos WHERE CodOrcamento = '$CodOrcamento'");
		$r = mysql_fetch_assoc($rs);

		//ESPECIES VEGETAIS
			$rs_vegetais 		= mysql_query("SELECT * FROM orcespeciesvegetais WHERE CodOrcamento = '$CodOrcamento'");
			
			
			
			while ($rv = mysql_fetch_assoc($rs_vegetais)){
				
				//print_r($rv);
				//soma dos custos
				//$valorVegetais += $rv[ValorTotal];
				
				//soma dos preços
				if($rv['Lucro']>0) {
					$perlucro = $rv['Lucro']/100.0;
					$espveg_preco = $rv['ValorTotal'] + ($perlucro * $rv['ValorTotal']);
					$totalVegetais += $espveg_preco;
					//echo "passou".$espveg_preço;
					continue;
					
				}elseif($r['LucroEspeciesVegetais']>0) {
					$perlucro = $r['LucroEspeciesVegetais']/100.0;
					$espveg_preco = $rv['ValorTotal'] + ($perlucro * $rv['ValorTotal']);
					$totalVegetais += $espveg_preco;
					continue;
				}elseif($LucroGE>0) {
					$perlucro = $LucroGE/100.0;
					$espveg_preco = $rv['ValorTotal'] + ($perlucro * $rv['ValorTotal']);
					$totalVegetais += $espveg_preco;
					continue;
				}else{
					$totalVegetais += $rv['ValorTotal'];
					continue;
				}
			}
			
			
			//$percVegetais 		= $r_vegetais['LucroTotal'] / 100.0;
			//$valorVegetais 		= $r_vegetais['ValorTotal'] + ($percVegetais * $r_vegetais['ValorTotal']);

			//se o campo Lucro Especies vegetais não está vazio soma
			/*
			if($r['LucroEspeciesVegetais'] != '' || $r['LucroEspeciesVegetais'] != NULL || $r['LucroEspeciesVegetais'] != 0) {
				$percLucroVegetais 	= $r['LucroEspeciesVegetais'] / 100.0;
				$totalVegetais 	= $totalVegetais + ($percLucroVegetais * $totalVegetais);
			}
			*/			
		
			$totalVegetais = sprintf('%0.2f', $totalVegetais);
		
		//FORRACOES
			$rs_forracoes 		= mysql_query("SELECT * FROM orcforracoes WHERE CodOrcamento = '$CodOrcamento'");
						
			while ($rf = mysql_fetch_assoc($rs_forracoes)){
				
				//print_r($rf);
				//soma dos custos
				//$valorForracoes += $rf[ValorTotal];
				
				//soma dos preços
				if($rf['Lucro']>0) {
					$perlucro = $rf['Lucro']/100.0;
					$forr_preco = $rf['ValorTotal'] + ($perlucro * $rf['ValorTotal']);
					$totalForracoes += $forr_preco;
					continue;
				}elseif($r['LucroForracoes']>0) {
					$perlucro = $r['LucroForracoes']/100.0;
					$forr_preco = $rf['ValorTotal'] + ($perlucro * $rf['ValorTotal']);
					$totalForracoes += $forr_preco;
					continue;
				}elseif($LucroGE>0) {
					$perlucro = $LucroGE/100.0;
					$forr_preco = $rf['ValorTotal'] + ($perlucro * $rf['ValorTotal']);
					$totalForracoes += $forr_preco;
					continue;
				}else{
					$totalForracoes += $rf['ValorTotal'];
					continue;
				}
			}
			
			//$percVegetais 		= $r_vegetais['LucroTotal'] / 100.0;
			//$valorVegetais 		= $r_vegetais['ValorTotal'] + ($percVegetais * $r_vegetais['ValorTotal']);

			//se o campo Lucro Especies vegetais não está vazio soma
			/*
			if($r['LucroForracoes'] != '' || $r['LucroForracoes'] != NULL || $r['LucroForracoes'] != 0) {
				$percLucroForr 	= $r['LucroForracoes']/100.0;
				$totalForracoes 	= $totalForracoes + ($percLucroForr * $totalForracoes);
			} 
			*/
		
		$totalForracoes = sprintf('%0.2f', $totalForracoes);
		
		//DIVERSOS
			$rs_diversos 		= mysql_query("SELECT * FROM orcdiversos WHERE CodOrcamento = '$CodOrcamento'");
						
			while ($rd = mysql_fetch_assoc($rs_diversos)){
				
				//print_r($rv);
				//soma dos custos
				//$valorDiversos += $rd[ValorTotal];
				
				//soma dos preços
				if($rd['Lucro']>0) {
					$perlucro = $rd['Lucro']/100.0;
					$div_preco = $rd['ValorTotal'] + ($perlucro * $rd['ValorTotal']);
					$totalDiversos += $div_preco;
					continue;
				}elseif($r['LucroDiversos']>0) {
					$perlucro = $r['LucroDiversos']/100.0;
					$div_preco = $rd['ValorTotal'] + ($perlucro * $rd['ValorTotal']);
					$totalDiversos += $div_preco;
					continue;
				}elseif($LucroGE>0) {
					$perlucro = $LucroGE/100.0;
					$div_preco = $rd['ValorTotal'] + ($perlucro * $rd['ValorTotal']);
					$totalDiversos += $div_preco;
					continue;
				}else{
					$totalDiversos += $rd['ValorTotal'];
					continue;
				}
			}
			
			
			//$percVegetais 		= $r_vegetais['LucroTotal'] / 100.0;
			//$valorVegetais 		= $r_vegetais['ValorTotal'] + ($percVegetais * $r_vegetais['ValorTotal']);

			//se o campo Lucro Especies vegetais não está vazio soma
			/*
			if($r['LucroDiversos'] != '' || $r['LucroDiversos'] != NULL || $r['LucroDiversos'] != 0) {
				$percLucroDiv 	= $r['LucroDiversos'] / 100.0;
				$totalDiversos 	= $totalDiversos + ($percLucroDiv * $totalDiversos);
			} 
			*/
		
		$totalDiversos = sprintf('%0.2f', $totalDiversos);
		
		//VASOS
			$rs_vasos 		= mysql_query("SELECT * FROM orcvasos WHERE CodOrcamento = '$CodOrcamento'");
						
			while ($rvs = mysql_fetch_assoc($rs_vasos)){
				
				//print_r($rv);
				//soma dos custos
				//$valorVasos += $rv[ValorTotal];
				
				//soma dos preços
				if($rvs['Lucro']>0) {
					$perlucro = $rvs['Lucro']/100.0;
					$vasos_preco = $rvs['ValorTotal'] + ($perlucro * $rv['ValorTotal']);
					$totalVasos += $vasos_preco;
					continue;
				}elseif($r['LucroVasos']>0) {
					$perlucro = $r['LucroVasos']/100.0;
					$vasos_preco = $rvs[ValorTotal] + ($perlucro * $rvs[ValorTotal]);
					$totalVasos += $vasos_preco;
					continue;
				}elseif($LucroGE>0) {
					$perlucro = $LucroGE/100.0;
					$vasos_preco = $rvs[ValorTotal] + ($perlucro * $rvs['ValorTotal']);
					$totalVasos += $vasos_preco;
					continue;
				}else{
					$totalVasos += $rvs['ValorTotal'];
					continue;
				}
			}
			
			
			//$percVegetais 		= $r_vegetais['LucroTotal'] / 100.0;
			//$valorVegetais 		= $r_vegetais['ValorTotal'] + ($percVegetais * $r_vegetais['ValorTotal']);

			//se o campo Lucro Especies vegetais não está vazio soma
			/*
			if($r['LucroVasos'] != '' || $r['LucroVasos'] != NULL || $r['LucroVasos'] != 0) {
				$percLucrovasos 	= $r['LucroVasos'] / 100.0;
				$totalVasos 	= $totalVasos + ($percLucrovasos * $totalVasos);
			} 
			*/

		$totalVasos = sprintf('%0.2f', $totalVasos);
		
		$PrecoMA = $totalVegetais+$totalForracoes+$totalDiversos+$totalVasos;
		
		$PrecoMA = sprintf('%0.2f', $PrecoMA);
		
		mysql_query("UPDATE orcamentos SET PrecoMA='$PrecoMA', LucroGE='$LucroGE' WHERE CodOrcamento = '$CodOrcamento'");

		echo $PrecoMA;

	break;

	case 'copy':
		$id = (int)$_GET['id'];

		$rs = mysql_query("SELECT * FROM orcamentos WHERE CodOrcamento = '$id'");
		$r = mysql_fetch_assoc($rs);

		$CodCliente 				= $r['CodCliente'];
		$JOB						= '(CÓPIA) '.$r['JOB'];
		$Obra 						= $r['Obra'];
		$LucroGE					= $r['LucroGE'];
		$TituloEspeciesVegetais		= $r['TituloEspeciesVegetais'];
		$LucroEspeciesVegetais		= $r['LucroEspeciesVegetais'];

		$TituloForracoes			= $r['TituloForracoes'];
		$LucroForracoes				= $r['LucroForracoes'];

		$TituloDiversos				= $r['TituloDiversos'];
		$LucroDiversos				= $r['LucroDiversos'];

		$TituloVasos				= $r['TituloVasos'];
		$LucroVasos					= $r['LucroVasos'];

		$CustoMO					= $r['CustoMO'];
		$PrecoMO					= $r['PrecoMO'];
		$LucroMO					= $r['LucroMO'];
		$CustoMA					= $r['CustoMA'];
		$PrecoMA					= $r['PrecoMA'];
		$CustoGE					= $r['CustoGE'];
		$PrecoGE					= $r['PrecoGE'];

		if (semErros()) {

			#duplica orcamento
			if (mysql_query("INSERT INTO orcamentos 
				(
					CodCliente,
					JOB,
					Obra,
					DataCadastra,
					LucroGE,
					TituloEspeciesVegetais,
					LucroEspeciesVegetais,
					TituloForracoes,
					LucroForracoes,
					TituloDiversos,
					LucroDiversos,
					TituloVasos,
					LucroVasos,
					CustoMO,
					PrecoMO,
					LucroMO,
					CustoMA,
					PrecoMA,
					CustoGE,
					PrecoGE
				) VALUES
				(
					'$CodCliente',
					'$JOB',
					'$Obra',
					NOW(),
					'$LucroGE',
					'$TituloEspeciesVegetais',
					'$LucroEspeciesVegetais',
					'$TituloForracoes',
					'$LucroForracoes',
					'$TituloDiversos',
					'$LucroDiversos',
					'$TituloVasos',
					'$LucroVasos',
					'$CustoMO',
					'$PrecoMO',
					'$LucroMO',
					'$CustoMA',
					'$PrecoMA',
					'$CustoGE',
					'$PrecoGE'
				)")) {
				$NovoOrcamento = mysql_insert_id();

				#duplica produtos - especies
				include('duplica-especies.php');

				#duplica produtos - forracoes
				include('duplica-forracoes.php');

				#duplica produtos - diversos
				include('duplica-diversos.php');

				#duplica produtos - vasos
				include('duplica-vasos.php');				

				Info('Orçamento duplicado com sucesso.');
				Go('../?s=orcamentos');
			} else Erro("Erro durante a duplicação, tente novamente");
		}
		Go();
	break;

	case 'refresh':
		$id = (int)$_GET['id'];
		$job = $_GET['job'];
		$obra = $_GET['obra'];
		$lucro = $_GET['lucro'];
				
		//atualiza dados do orçamento
		mysql_query("UPDATE orcamentos set JOB='$job', Obra='$obra', LucroGE='$lucro', DataCadastra=NOW() WHERE CodOrcamento = '$id'"); 				
		
		#atualiza produtos - especies
		include('atualiza-especies.php');

		#atualiza produtos - forracoes
		include('atualiza-forracoes.php');

		#atualiza produtos - diversos
		include('atualiza-diversos.php');

		#atualiza produtos - vasos
		include('atualiza-vasos.php');				

		Info('Orçamento atualizado com sucesso.');
		Go('../?s=orcamentos-produtos&id='.$id.'');
	
	break;
	
	case 'edita_infos':
	
		$id = (int)$_GET['id'];
		$job = $_GET['job'];
		$obra = $_GET['obra'];
		$lucro = $_GET['lucro'];
		
		//atualiza dados do orçamento
		mysql_query("UPDATE orcamentos set JOB='$job', Obra='$obra', LucroGE='$lucro', DataCadastra=NOW() WHERE CodOrcamento = '$id'"); 				
		
		Info('Orçamento atualizado com sucesso.');
		Go('../?s=orcamentos-produtos&id='.$id.'');
		
		break;
}
?>