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

		$checkJob = mysql_query("SELECT JOB FROM orcamentos WHERE JOB = '$job'");
		if(mysql_num_rows($checkJob)>0) {
			Erro('JOB já consta no sistema'); Go();
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

	#VEGETAIS
	case 'CadProdutoVegetais':
		ValidaVazio($id_produto_vegetais,'Campo Produto Obrigatório');

		if (semErros()) {
			if (mysql_query("INSERT INTO orcespeciesvegetais
						(CodOrcamento, CodPreco, Quantidade, DistanciaPlantio, Valor, Observacoes, Lucro) 
					VALUES
						('$id_orcamento', '$id_preco_vegetais', '$quantidade', '$distancia', '$valor', '$observacoes', '$lucro')")) {
				$CodOrcEspecieVegetal = mysql_insert_id();

				$rs_vegetais = mysql_query("SELECT orcespeciesvegetais.Valor, orcespeciesvegetais.Quantidade, orcespeciesvegetais.Lucro, orcespeciesvegetais.ValorTotal
				    FROM orcamentos, orcespeciesvegetais, precos, produtos
			        WHERE orcespeciesvegetais.CodOrcamento = orcamentos.CodOrcamento
			        AND orcespeciesvegetais.CodPreco = precos.CodPreco
			        AND precos.CodProduto = produtos.CodProduto
			        AND orcamentos.CodOrcamento = '$id_orcamento'");

				$rs_soma = mysql_query("SELECT CustoMA, PrecoMA FROM orcamentos WHERE CodOrcamento = '$id_orcamento'");
				$r_soma = mysql_fetch_assoc($rs_soma);

			 	while($r_vegetais = mysql_fetch_array($rs_vegetais)):

			 		//preco
			 		$total 		= $r_vegetais['Valor']*$r_vegetais['Quantidade'];
			 		//$perc 		= $r_vegetais['Lucro'] / 100.0;
			 		//$preco 		= $total + ($perc * $total);

			 		//custo
			 		$custo 	= $total;

			 		if($r_soma['CustoMA'] == '' || $r_soma['CustoMA'] == NULL || $r_soma['CustoMA'] == 0) { 
						$custoMA = $custo;
					} else {
						$custoMA = $custo+$r_soma['CustoMA'];
					}

					mysql_query("UPDATE orcamentos SET TituloEspeciesVegetais='$titulo', LucroEspeciesVegetais='$lucroVegetais', CustoMA='$custoMA', PrecoMA='$precoMA' WHERE CodOrcamento = '$id_orcamento'");

			 	endwhile;

				//atualiza valor total do produto
				$valorTotal = $valor*$quantidade;

				// if($r_soma['PrecoMA'] == '' || $r_soma['PrecoMA'] == NULL || $r_soma['PrecoMA'] == 0) {
				// 	$precoMA = $preco;
				// } else {
				// 	$precoMA = ($preco+$r_soma['PrecoMA']);
				// }

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

		if (semErros()) {

			//cadastra produto
			if (mysql_query("UPDATE orcespeciesvegetais 
					SET 	Quantidade='$quantidade', DistanciaPlantio='$distancia', Valor='$valor', Observacoes='$observacoes', Lucro='$lucro'
					WHERE 	CodOrcEspecieVegetal = '$id'")) {

				//query para calcular todos os produtos e somar na tabela orcamentos
				//soma custoMA precoMA toda vez q tiver produto
				$rs_vegetais = mysql_query("SELECT orcespeciesvegetais.Valor, orcespeciesvegetais.Quantidade, orcespeciesvegetais.Lucro, orcespeciesvegetais.ValorTotal 
				    FROM orcamentos, orcespeciesvegetais, precos, produtos
			        WHERE orcespeciesvegetais.CodOrcamento = orcamentos.CodOrcamento
			        AND orcespeciesvegetais.CodPreco = precos.CodPreco
			        AND precos.CodProduto = produtos.CodProduto
			        AND orcamentos.CodOrcamento = '$id_orcamento'");

				$rs_soma = mysql_query("SELECT CustoMA, PrecoMA FROM orcamentos WHERE CodOrcamento = '$id_orcamento'");
				$r_soma = mysql_fetch_assoc($rs_soma);

			 	while($r_vegetais = mysql_fetch_array($rs_vegetais)):

			 		//preco com %
			 		$total 	= ($r_vegetais['Valor']*$r_vegetais['Quantidade']);
			 		//$perc 	= $r_vegetais['Lucro'] / 100.0;
			 		//$preco 	= $total + ($perc * $total);

			 		//custo sem %
			 		$custo 	= ($quantidade * $total);

			 		if($r_soma['CustoMA'] == '' || $r_soma['CustoMA'] == NULL || $r_soma['CustoMA'] == 0) { 
						$custoMA = $custo;
					} else {
						$custoMA = $custo+$r_soma['CustoMA'];
					}

			 		mysql_query("UPDATE orcamentos SET CustoMA='$custoMA', PrecoMA='$precoMA' WHERE CodOrcamento = '$id_orcamento'");

			 	endwhile;			

				$valorTotal = $valor*$quantidade;
				$precoMA 	= ($preco+$r_soma['PrecoMA']);

				// if($r_soma['PrecoMA'] == '' || $r_soma['PrecoMA'] == NULL || $r_soma['PrecoMA'] == 0) {
				// 	$precoMA = $preco;
				// } else {
				// 	$precoMA = ($preco+$r_soma['PrecoMA']);
				// }

				
				mysql_query("UPDATE orcespeciesvegetais SET ValorTotal='$valorTotal' WHERE CodOrcEspecieVegetal = '$id'");

				Info('Produto cadastrado com sucesso');
				Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#vegetais');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;

	case 'excluiVegetais':
		$id = (int)$_GET['id'];
		$id_orcamento = (int)$_GET['id_orcamento'];
		if (mysql_query("DELETE FROM orcespeciesvegetais WHERE CodOrcEspecieVegetal = '$id'")) {
			Info ("Produto removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#vegetais');
	break;

	#FORRACOES
	case 'CadProdutoForracoes':
		ValidaVazio($id_produto_forracoes,'Campo Produto Obrigatório');
		$_SESSION['orcamentos'] = $_POST;

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

			//$totalCX = ($totalMudas/$UnidadesPorCaixa);

			$ValorTotal = ($valor*$totalMudas);
		}

		if($unidade == 'm2') {

			$ValorTotal = ($valor*$quantidade);

		}

		if (semErros()) {

			if (mysql_query("INSERT INTO orcforracoes
							(CodOrcamento, CodPreco, QtdeM2, QtdeCaixasMudas, DistanciaPlantio, Valor, ValorTotal, Observacoes, Lucro) 
						VALUES
							('$id_orcamento', '$id_preco_forracoes', '$quantidade', '$totalCX', '$distancia', '$valor', '$ValorTotal', '$observacoes', '$lucro')")) {

			// $rs_vegetais = mysql_query("SELECT orcespeciesvegetais.Valor, orcespeciesvegetais.Quantidade, orcespeciesvegetais.Lucro, orcespeciesvegetais.ValorTotal
			//     FROM orcamentos, orcespeciesvegetais, precos, produtos
			//     WHERE orcespeciesvegetais.CodOrcamento = orcamentos.CodOrcamento
			//     AND orcespeciesvegetais.CodPreco = precos.CodPreco
			//     AND precos.CodProduto = produtos.CodProduto
			//     AND orcamentos.CodOrcamento = '$id_orcamento'");

			// $r_forracoes = mysql_query("SELECT
			// 	produtos.CodProduto, produtos.NomePopular, orcforracoes.QtdeM2, orcforracoes.QtdeCaixasMudas,orcforracoes.DistanciaPlantio, orcforracoes.Valor, orcforracoes.ValorTotal
		 //        FROM orcamentos, orcforracoes, precos, produtos
		 //        WHERE orcforracoes.CodOrcamento = orcamentos.CodOrcamento
		 //        AND orcforracoes.CodPreco = precos.CodPreco
		 //        AND precos.CodProduto = produtos.CodProduto
		 //        AND orcamentos.CodOrcamento = '$id'");

				mysql_query("UPDATE orcamentos 
					SET
						TituloForracoes='$titulo',
						LucroForracoes='$lucro'
					WHERE
						CodOrcamento = '$id_orcamento'");

				Info('Produto cadastrado com sucesso');
				Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#forracoes');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;

	case 'AlteraForracoes':
		ValidaVazio($id_produto_forracoes,'Campo Produto Obrigatório');
		$_SESSION['orcamentos'] = $_POST;

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

		if (semErros()) {
			if (mysql_query("UPDATE orcforracoes 
					SET
						QtdeM2='$quantidade',
						QtdeCaixasMudas='$totalCX',
						DistanciaPlantio='$distancia',
						Valor='$valor',
						ValorTotal='$lucro',
						Observacoes='$observacoes',
						Lucro='$lucro'
					WHERE
						CodOrcamento = '$id_orcamento'")) {

				mysql_query("UPDATE orcamentos 
					SET
						TituloForracoes='$titulo',
						LucroForracoes='$lucro'
					WHERE
						CodOrcamento = '$id_orcamento'");

				Info('Produto cadastrado com sucesso');
				Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#forracoes');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;

	case 'excluiForracoes':
		$id = (int)$_GET['id'];
		if (mysql_query("DELETE FROM orcforracoes WHERE CodOrcForracao = '$id'")) {
			Info ("Produto removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#forracoes');
	break;

	#DIVERSOS
	case 'CadProdutoDiversos':
		ValidaVazio($id_produto_diversos,'Campo Produto Obrigatório');

		$_SESSION['orcamentos'] = $_POST;

		if (semErros()) {
			if (mysql_query("INSERT INTO orcdiversos
							(CodOrcamento, CodPreco, Quantidade, Valor, Observacoes, Lucro) 
						VALUES
							('$id_orcamento', '$id_preco_diversos', '$quantidade', '$valor', '$observacoes', '$lucro')")) {
				$CodOrcDiverso = mysql_insert_id();

				$rs_diversos = mysql_query("SELECT produtos.CodProduto, produtos.NomePopular, orcdiversos.Quantidade, orcdiversos.Valor, orcdiversos.Lucro, 
			        orcdiversos.Observacoes, orcdiversos.CodOrcDiverso, unidadesmedida.Sigla, DATE_FORMAT( precos.DataCadastra,'%d/%m/%Y') as dataCad 
			        FROM orcamentos, orcdiversos, precos, produtos, unidadesmedida
			        WHERE orcdiversos.CodOrcamento = orcamentos.CodOrcamento
			        AND orcdiversos.CodPreco = precos.CodPreco
			        AND unidadesmedida.CodUnidadeMedida = precos.CodUnidadeMedida
			        AND precos.CodProduto = produtos.CodProduto
			        AND orcamentos.CodOrcamento = '$id_orcamento'");

				while($r_diversos = mysql_fetch_array($rs_diversos)):

			 		//preco
			 		$total 	= ($r_diversos['Valor']*$r_diversos['Quantidade']);
			 		$perc 	= $r_diversos['Lucro'] / 100.0;
			 		$preco 	= $total + ($perc * $total);

			 		//custo
			 		$custo 	= $total;

			 	endwhile;

			 	$rs_soma = mysql_query("SELECT CustoMA, PrecoMA FROM orcamentos WHERE CodOrcamento = '$id_orcamento'");
				$r_soma = mysql_fetch_assoc($rs_soma);

				$valorTotal = $valor*$quantidade;

				if($r_soma['PrecoMA'] == '' || $r_soma['PrecoMA'] == NULL || $r_soma['PrecoMA'] == 0) {
					$precoMA = $preco;
				} else {
					$precoMA = ($preco+$r_soma['PrecoMA']);
				}
				if($r_soma['CustoMA'] == '' || $r_soma['CustoMA'] == NULL || $r_soma['CustoMA'] == 0) { 
					$custoMA = $custo;
				} else {
					$custoMA = ($custo+$r_soma['CustoMA']);
				}

				mysql_query("UPDATE orcamentos SET TituloDiversos='$titulo', LucroDiversos='$lucroDiversos', CustoMA='$custoMA', PrecoMA='$precoMA' WHERE CodOrcamento = '$id_orcamento'");
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
		if (semErros()) {
			
			if (mysql_query("UPDATE orcdiversos 
					SET 	Quantidade='$quantidade', Valor='$valor', Observacoes='$observacoes', Lucro='$lucro'
					WHERE 	CodOrcDiverso = '$id'")) {

				$rs_diversos = mysql_query("SELECT produtos.CodProduto, produtos.NomePopular, orcdiversos.Quantidade, orcdiversos.Valor, orcdiversos.Lucro, 
			        orcdiversos.Observacoes, orcdiversos.CodOrcDiverso, unidadesmedida.Sigla, DATE_FORMAT( precos.DataCadastra,'%d/%m/%Y') as dataCad 
			        FROM orcamentos, orcdiversos, precos, produtos, unidadesmedida
			        WHERE orcdiversos.CodOrcamento = orcamentos.CodOrcamento
			        AND orcdiversos.CodPreco = precos.CodPreco
			        AND unidadesmedida.CodUnidadeMedida = precos.CodUnidadeMedida
			        AND precos.CodProduto = produtos.CodProduto
			        AND orcamentos.CodOrcamento = '$id_orcamento'");

				while($r_diversos = mysql_fetch_array($rs_diversos)):

			 		//preco
			 		$total 	= ($r_diversos['Valor']*$r_diversos['Quantidade']);
			 		$perc 	= $r_diversos['Lucro'] / 100.0;
			 		$preco 	= $total + ($perc * $total);

			 		//custo
			 		$custo 	= $total;

			 	endwhile;

			 	$rs_soma = mysql_query("SELECT CustoMA, PrecoMA FROM orcamentos WHERE CodOrcamento = '$id_orcamento'");
				$r_soma = mysql_fetch_assoc($rs_soma);

				$valorTotal = $valor*$quantidade;

				if($r_soma['PrecoMA'] == '' || $r_soma['PrecoMA'] == NULL || $r_soma['PrecoMA'] == 0) {
					$precoMA = $preco;
				} else {
					$precoMA = ($preco+$r_soma['PrecoMA']);
				}
				if($r_soma['CustoMA'] == '' || $r_soma['CustoMA'] == NULL || $r_soma['CustoMA'] == 0) { 
					$custoMA = $custo;
				} else {
					$custoMA = ($custo+$r_soma['CustoMA']);
				}

				mysql_query("UPDATE orcamentos SET TituloDiversos='$titulo', LucroDiverDiversos='$lucroDiversos', CustoMA='$custoMA', PrecoMA='$precoMA' WHERE CodOrcamento = '$id_orcamento'");
				mysql_query("UPDATE orcdiversos SET ValorTotal='$valorTotal' WHERE CodOrcDiverso = '$id'");

				Info('Produto cadastrado com sucesso');
				Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#diversos');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;

	case 'excluiDiversos':
		$id = (int)$_GET['id'];
		if (mysql_query("DELETE FROM orcdiversos WHERE CodOrcDiverso = '$id'")) {
			Info ("Produto removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#diversos');
	break;

	#VASOS
	case 'CadProdutoVasos':
		ValidaVazio($id_produto_vasos,'Campo Vaso Obrigatório');

		if (semErros()) {
			if (mysql_query("INSERT INTO orcvasos
							(CodOrcamento, CodVaso, CodCor, Codigo, Quantidade, Valor, Conteudo, Lucro) 
						VALUES
							('$id_orcamento', '$id_produto_vasos', '$cor', '$codigo', '$quantidade', '$valor', '$conteudo', '$lucro')")) {
				$CodOrcVaso = mysql_insert_id();

				$rs_vasos = mysql_query("SELECT orcvasos.Valor, orcvasos.Quantidade, orcvasos.Lucro, orcvasos.ValorTotal
			        FROM orcamentos, orcvasos, vasos, cores
			        WHERE orcvasos.CodOrcamento = orcamentos.CodOrcamento
			        AND vasos.CodVaso = orcvasos.CodVaso
			        AND orcvasos.CodCor = cores.CodCor
			        AND orcamentos.CodOrcamento = '$id'");

				while($r_vasos = mysql_fetch_array($rs_vasos)):

			 		//preco
			 		$total 	= ($r_vasos['Valor']*$r_vasos['Quantidade']);
			 		$perc 	= $r_vasos['Lucro'] / 100.0;
			 		$preco 	= $total + ($perc * $total);

			 		//custo
			 		$custo 	= $total;

			 	endwhile;

				echo $custo.' - '.$preco;
				die;

				$rs_soma = mysql_query("SELECT CustoMA, PrecoMA FROM orcamentos WHERE CodOrcamento = '$id_orcamento'");
				$r_soma = mysql_fetch_assoc($rs_soma);

				$valorTotal = $valor*$quantidade;

				if($r_soma['PrecoMA'] == '' || $r_soma['PrecoMA'] == NULL || $r_soma['PrecoMA'] == 0) {
					$precoMA = $preco;
				} else {
					$precoMA = ($preco+$r_soma['PrecoMA']);
				}
				if($r_soma['CustoMA'] == '' || $r_soma['CustoMA'] == NULL || $r_soma['CustoMA'] == 0) { 
					$custoMA = $custo;
				} else {
					$custoMA = ($custo+$r_soma['CustoMA']);
				}
				echo $custoMA;
				echo $precoMA;
				die;
				mysql_query("UPDATE orcamentos SET TituloVasos='$titulo', LucroVasos='$lucroVasos', CustoMA='$custoMA', PrecoMA='$precoMA' WHERE CodOrcamento = '$id_orcamento'");
				mysql_query("UPDATE orcvasos SET ValorTotal='$valorTotal' WHERE CodOrcVaso = '$CodOrcVaso'");

				Info('Produto cadastrado com sucesso');
				Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#vasos');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;

	case 'excluiVasos':
		$id = (int)$_GET['id'];
		if (mysql_query("DELETE FROM orcvasos WHERE CodOrcVaso = '$id'")) {
			Info ("Produto removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go('../?s=orcamentos-produtos&id='.$id_orcamento.'#vasos');
	break;

	case 'finaliza':
		//ValidaVazio($nome,'Campo Nome inválido');

		if (semErros()) {
			if (mysql_query("UPDATE orcamentos 
					SET
						custo='$nome',
						lucro='$nome_popular',
						Codigo='$codigo',
						Observacoes='$observacoes'
					WHERE
						CodProduto = '$id'")) {
				Info('Produto alterado com sucesso');
				Go('../?s=orcamentos');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;

	//orcamento
	case 'exclui':
		$id = (int)$_GET['id'];
		if (mysql_query("DELETE FROM orcamentos WHERE CodOrcamento = '$id'")) {
			Info ("Orçamento removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go();
	break;
	case 'altera':
		ValidaID($id,'CodProduto','orcamentos');
		ValidaVazio($nome,'Campo Nome inválido');
		ValidaVazio($categoria,'Selecione uma Categoria');

		if (semErros()) {
			if (mysql_query("UPDATE orcamentos 
					SET
						CodCategoriaProduto='$categoria',
						Ambiente='$ambiente',
						NomeCientifico='$nome',
						NomePopular='$nome_popular',
						Codigo='$codigo',
						Observacoes='$observacoes'
					WHERE
						CodProduto = '$id'")) {
				Info('Produto alterado com sucesso');
				Go('../?s=orcamentos');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;
}
?>