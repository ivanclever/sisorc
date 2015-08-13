
<?php
ob_start();
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$dataimpressao = strftime('%d de %B de %Y', strtotime('today'));

require('util/conn.php');
require('util/util.php');

$id_orcamento = (int)$_GET['id_orcamento'];

$rs = mysql_query("SELECT orcamentos.*, clientes.Nome nomeCliente, clientes.CPF_CNPJ, clientes.TelefoneComercial, clientes.Email
    FROM orcamentos, clientes
    WHERE orcamentos.CodCliente = clientes.CodCliente
    AND orcamentos.CodOrcamento = '$id_orcamento'");
$r = mysql_fetch_assoc($rs);

/*$rs_vegetais = mysql_query("SELECT produtos.CodProduto, produtos.NomePopular,produtos.NomeCientifico, orcespeciesvegetais.Quantidade, orcespeciesvegetais.DistanciaPlantio,
     orcespeciesvegetais.Valor, orcespeciesvegetais.Lucro, orcespeciesvegetais.Observacoes, orcespeciesvegetais.CodOrcEspecieVegetal, orcespeciesvegetais.ValorTotal,  precos.Porte, DATE_FORMAT( precos.DataCadastra,'%d/%m/%Y') as dataCad 
        FROM orcamentos, orcespeciesvegetais, precos, produtos 
        WHERE orcespeciesvegetais.CodOrcamento = orcamentos.CodOrcamento 
        AND orcespeciesvegetais.CodPreco = precos.CodPreco 
        AND precos.CodProduto = produtos.CodProduto 
        AND orcamentos.CodOrcamento = '$id_orcamento' ORDER BY produtos.NomeCientifico ASC");
*/
$rs_vegetais = mysql_query("SELECT O.CodOrcamento, 
OV.Quantidade,  OV.DistanciaPlantio, OV.Valor,  OV.Lucro,  OV.Observacoes, 
OV.CodOrcEspecieVegetal,  OV.ValorTotal, P.CodCor,  P.Porte, 
C.nome,  DATE_FORMAT(P.DataCadastra,'%d/%m/%Y') as dataCad, PRD.CodProduto,PRD.Codigo, PRD.NomePopular, PRD.NomeCientifico 
FROM orcamentos as O 
LEFT JOIN orcespeciesvegetais as OV ON OV.CodOrcamento = O.CodOrcamento 
LEFT JOIN precos as P ON OV.CodPreco = P.CodPreco 
LEFT JOIN cores as C ON P.CodCor = C.CodCor 
LEFT JOIN produtos as PRD ON P.CodProduto = PRD.CodProduto 
WHERE OV.CodOrcamento = O.CodOrcamento 
AND OV.CodPreco = P.CodPreco 
AND P.CodProduto = PRD.CodProduto 
AND O.CodOrcamento = '$id_orcamento' ORDER BY PRD.NomeCientifico ASC");

$rs_forracoes = mysql_query("SELECT produtos.CodProduto,produtos.Codigo, produtos.NomePopular,produtos.NomeCientifico, orcforracoes.QtdeM2, orcforracoes.QtdeCaixasMudas,orcforracoes.DistanciaPlantio, orcforracoes.Valor,orcforracoes.ValorTotal, orcforracoes.Lucro, orcforracoes.Observacoes, orcforracoes.CodOrcForracao, precos.Porte, precos.DataCadastra, DATE_FORMAT( precos.DataCadastra,'%d/%m/%Y') as dataCad
    FROM orcamentos, orcforracoes, precos, produtos
    WHERE orcforracoes.CodOrcamento = orcamentos.CodOrcamento
    AND orcforracoes.CodPreco = precos.CodPreco
    AND precos.CodProduto = produtos.CodProduto
    AND orcamentos.CodOrcamento = '$id_orcamento' ORDER BY produtos.NomeCientifico ASC");

$rs_diversos = mysql_query("SELECT produtos.CodProduto,produtos.Codigo, produtos.NomePopular, orcdiversos.Quantidade, orcdiversos.Valor, orcdiversos.Lucro, 
    orcdiversos.Observacoes, orcdiversos.CodOrcDiverso, unidadesmedida.Sigla, DATE_FORMAT( precos.DataCadastra,'%d/%m/%Y') as dataCad, orcdiversos.ValorTotal
    FROM orcamentos, orcdiversos, precos, produtos, unidadesmedida
    WHERE orcdiversos.CodOrcamento = orcamentos.CodOrcamento
    AND orcdiversos.CodPreco = precos.CodPreco
    AND unidadesmedida.CodUnidadeMedida = precos.CodUnidadeMedida
    AND precos.CodProduto = produtos.CodProduto
    AND orcamentos.CodOrcamento = '$id_orcamento' ORDER BY produtos.NomePopular ASC");

$rs_vasos = mysql_query("SELECT orcvasos.Codigo, vasos.CodVaso, vasos.Modelo, orcvasos.Quantidade, orcvasos.Conteudo, orcvasos.Valor, orcvasos.ValorTotal, orcvasos.Lucro, orcvasos.CodOrcVaso, cores.Nome nomeCor, fornecedores.Nome nomeFornecedor
    FROM orcamentos, orcvasos, vasos, cores, fornecedores
    WHERE orcvasos.CodOrcamento = orcamentos.CodOrcamento
    AND vasos.CodVaso = orcvasos.CodVaso
    AND orcvasos.CodCor = cores.CodCor
    AND vasos.CodFornecedor = fornecedores.CodFornecedor
    AND orcamentos.CodOrcamento = '$id_orcamento' ORDER BY vasos.Modelo ASC");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Visualizar Impressão | Orçamento #<?=$r['JOB']?></title>

        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- Core stylesheets do not remove -->
        <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <link href="css/icons.css" rel="stylesheet" type="text/css" />

        <!-- Main stylesheets -->
        <link href="css/main.css" rel="stylesheet" type="text/css" />

        <style type="text/css">
            @media print {
                .tip { display: none; }
                html, body,table { border: 0; font-size:9pt; }
                .box .title { border-bottom: 1px solid #c4c4c4; border: 0; }
                .content { border: 0 !important; } 
				/*.odd.gradeX {border-bottom:1px dashed #CCCCCC;}
				.linetitle {border-bottom:1px solid;}
				.responsive.table.table-bordered {padding:2px;margin:0px;border:0}*/
							
            }
			@page
			{
				size: A4;margin:0.5cm;}
			}
        </style>
    </head>

    <body>

        <div id="wrapper" class="container">
            <div class="row">
               <!-- Build page from here: -->
               <div class="row-fluid">
                    <div class="span12">
                        <div class="box invoice">
                            <div class="title clearfix">
                                <div class="invoice-info">
                                    <div class="you">
										<span>São Paulo, <?=$dataimpressao?></span><br /><br />
										<ul class="unstyled">
											<li><h3><?=$r['nomeCliente']?></h3></li>
											<li><span class="icon16 icomoon-icon-arrow-right-2"></span><?=$r['TelefoneComercial']?></li>
										</ul>
										
									</div>
									<div class="clearfix"></div>
                                </div>
								 <h4 class="right">
                                    <span><img src="images/logo-impressao.png" width="90" style="margin-right:25px;"  /></span>
                                </h4>
                            </div>
                            <div class="content">
                                <div class="you">
										<span class="number" style="margin-left:30px;"><h4>Orçamento Nº<strong><?=$r['JOB']?></strong></h4></span>
									</div>
                                <div class="client">
                                    <ul class="unstyled">
                                        <li><h3><?=$r['Obra']?></h3></li>
                                    </ul>
									<div class="print">
										<a href="#" class="tip" title="Imprimir Orçamento" onClick="window.print()"><span class="icon24 icomoon-icon-printer-2"></span></a>
									</div>
                                </div>
								<div class="clearfix"></div>
                                
								<?php if(mysql_num_rows($rs_vegetais)>0 && $_GET['printespveg']!=''): ?>
                                    <h4>Espécies Vegetais</h4>
                                    <table cellpadding="3" cellspacing="3" width="100%">
                                        <thead>
                                          <tr style="border-bottom:1px #666666 solid;">
                                            <th align="left">Cód.</th>
											<th align="left">Nome Cient.</th>
											<th align="left">Nome Popular</th>
											<th align="left">QTDE</th>
                                            <th align="left">Porte (cm)</th>
											<th align="left">Cor</th>
                                            <th align="left">Observacoes</th>
                                            <? if($_GET['custo']!=''): ?>
                                                <th align="left">Custo unit. </th>
												<th align="left">Custo Total</th>
                                            <? endif; ?>
                                            <? if($_GET['preco']!=''): ?>
                                                <th align="left">Preço unit.</th>
												<th align="left">Preço Total</th>
                                            <? endif; ?>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($r_vegetais = mysql_fetch_assoc($rs_vegetais)): ?>
                                            <tr style="border-bottom:1px dashed #666666;">
												<td width="30"><?=$r_vegetais['Codigo']?></td>
                                                <td width="100"><?=$r_vegetais['NomeCientifico']?></td>
												<td width="100"><?=$r_vegetais['NomePopular']?></td>
                                                <td width="30"><?=$r_vegetais['Quantidade']?></td>
												<td width="30"><?=$r_vegetais['Porte']?></td>
                                                <td width="30"><?=$r_vegetais['nome']?></td>
                                                <td width="100"><?=$r_vegetais['Observacoes']?></td>
                                                <? if($_GET['custo']!=''): ?>
													<td width="80"><?=sprintf('%0.2f',$r_vegetais['Valor']);?></td>
                                                    <td width="80"><?=sprintf('%0.2f', $r_vegetais['ValorTotal']);?></td>
                                                <? endif; ?>
                                                <? if($_GET['preco']!=''): ?>
                                                    <td width="80">
                                                        <?php
                                                            if($r_vegetais['Lucro']>0){
																$perc    = $r_vegetais['Lucro'] / 100.0;
																$Preco   = $r_vegetais['Valor'] + ($perc * $r_vegetais['Valor']);
															}elseif($r['LucroEspeciesVegetais']>0){
																$perc    = $r['LucroEspeciesVegetais'] / 100.0;
																$Preco   = $r_vegetais['Valor'] + ($perc * $r_vegetais['Valor']);
															}elseif($r['LucroGE']>0){
																$perc    = $r['LucroGE'] / 100.0;
																$Preco   = $r_vegetais['Valor'] + ($perc * $r_vegetais['Valor']);
															}else{
																$Preco = $r_vegetais['Valor'];
															}
															echo sprintf('%0.2f', $Preco);
                                                        ?>
                                                    </td>
													<td width="80">
                                                        <?php
                                                            $Preco = $Preco*$r_vegetais['Quantidade'];
															echo sprintf('%0.2f', $Preco);
                                                        ?>
                                                    </td>
                                                <? endif; ?>
                                            </tr>
											
											<?php 
											$totalcusto_veg+= $r_vegetais['ValorTotal'];
											$totalpreco_veg+= $Preco;
											?>
											
											<?php endwhile; ?>                       
											<tr style="border-bottom:1px #666666; solid;">
											<td><strong>Total</strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<? if($_GET['custo']!=''): ?>
												<td></td>
												<td><strong><? echo sprintf('%0.2f', $totalcusto_veg);?></strong></td>
											<? endif; ?>
                                            <? if($_GET['preco']!=''): ?>
												<td></td>
												<td><strong><? echo sprintf('%0.2f', $totalpreco_veg);?></strong></td>
											<? endif; ?>
											</tr>
                                        </tbody>
                                    </table>
                                <? endif; ?>

                                <?php if(mysql_num_rows($rs_forracoes)>0  && $_GET['printforrac']!=''):?>
                                    <br />
                                    <h4>Forrações</h4>
                                    <table cellpadding="3" cellspacing="3"  width="100%">
                                        <thead>
                                          <tr style="border-bottom:1px solid;">
                                            <th align="left">Cód.</th>
											<th align="left">Nome Cient.</th>
											<th align="left">Nome Popular</th>
											<th align="left">QTDE M²</th>
                                            <th align="left">Distancia</th>
                                            <th align="left">Qtde itens</th>
                                            <th align="left">Porte (cm)</th>
                                            <th align="left">Obs</th>
                                            <? if($_GET['custo']!=''): ?>
                                                <th align="left">Custo m2. </th>
												<th align="left">Custo Total</th>
                                            <? endif; ?>
                                            <? if($_GET['preco']!=''): ?>
                                                <th align="left">Preço m2.</th>
												<th align="left">Preço Total</th>
                                            <? endif; ?>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($r_forracoes = mysql_fetch_assoc($rs_forracoes)): ?>
                                            <tr style="border-bottom:1px dashed #666666;">
                                                <td width="30"><?=$r_forracoes['Codigo']?></td>
												<td width="100"><?=$r_forracoes['NomeCientifico']?></td>
												<td width="120"><?=$r_forracoes['NomePopular']?></td>
												<td width="50"><?=$r_forracoes['QtdeM2']?></td>
                                                <td width="50"><?=$r_forracoes['DistanciaPlantio']?></td>
                                                <td width="100"><?=$r_forracoes['QtdeCaixasMudas']?></td>
                                                <td width="70"><?=$r_forracoes['Porte']?></td>
                                                <td width="100"><?=$r_forracoes['Observacoes']?></td>
                                                <? if($_GET['custo']!=''): ?>
                                                    <td width="80">R$ <?=sprintf('%0.2f',$r_forracoes['ValorTotal']/$r_forracoes['QtdeM2'])?></td>
                                                    <td width="80">R$ <?=sprintf('%0.2f', $r_forracoes['ValorTotal']);?></td>
                                                <? endif; ?>
                                                <? if($_GET['preco']!=''): ?>
                                                    <td width="80">
                                                        <?php
                                                            if($r_forracoes['Lucro']>0){
																$perc    = $r_forracoes['Lucro'] / 100.0;
																$Preco   = $r_forracoes['ValorTotal'] + ($perc * $r_forracoes['ValorTotal']);
															}elseif($r['LucroForracoes']>0){
																$perc    = $r['LucroForracoes'] / 100.0;
																$Preco   = $r_forracoes['ValorTotal'] + ($perc * $r_forracoes['ValorTotal']);
															}elseif($r['LucroGE']>0){
																$perc    = $r['LucroGE'] / 100.0;
																$Preco   = $r_forracoes['ValorTotal'] + ($perc * $r_forracoes['ValorTotal']);
															}else{
																$Preco = $r_forracoes['ValorTotal'];
															}
															
															
															/*
															$perc    = $r_forracoes['Lucro'] / 100.0;
															$Preco   = $r_forracoes['ValorTotal'] + ($perc * $r_forracoes['ValorTotal']);
															
															$perc    = $r['LucroForracoes'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															$perc    = $r['LucroGE'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															*/
															
															echo sprintf('%0.2f',$Preco/$r_forracoes['QtdeM2']);
                                                        ?>
                                                    </td>
													<td width="80">
                                                        <?php
															echo sprintf('%0.2f', $Preco);
                                                        ?>
                                                    </td>
                                                <? endif; ?>
                                            </tr>
											<?php 
											$totalcusto_forr+= $r_forracoes['ValorTotal'];
											$totalpreco_forr+= $Preco;
											?>
                                            <?php endwhile; ?> 
											<tr style="border-bottom:1px #666666; solid;">
											<td><strong>Total</strong></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<? if($_GET['custo']!=''): ?>
												<td></td>
												<td><strong><? echo "R$ ".sprintf('%0.2f', $totalcusto_forr);?></strong></td>
											<? endif; ?>
                                            <? if($_GET['preco']!=''): ?>
												<td></td>
												<td><strong><? echo "R$ ".sprintf('%0.2f', $totalpreco_forr);?></strong></td>
											<? endif; ?>
											</tr>											
                                        </tbody>
                                    </table>
                                <? endif; ?>

                                <?php if(mysql_num_rows($rs_diversos)>0  && $_GET['printdiv']!=''):?>
                                    <br />
                                    <h4>Diversos</h4>
                                    <table cellpadding="3" cellspacing="3"  width="100%">
                                        <thead >
                                         <tr style="border-bottom:1px solid;align:left;">
											<th align="left">Produto</th>
										    <th align="left">QTDE</th>
                                            <th align="left">UNIDADE</th>
                                            <th align="left">Obs</th>
                                           <? if($_GET['custo']!=''): ?>
                                                <th align="left">Custo unit. </th>
												<th align="left">Custo Total</th>
                                            <? endif; ?>
                                            <? if($_GET['preco']!=''): ?>
                                                <th align="left">Preço unit.</th>
												<th align="left">Preço Total</th>
                                            <? endif; ?>
										</tr>
                                        </thead>
                                        <tbody>
                                          <?php while ($r_diversos = mysql_fetch_assoc($rs_diversos)): ?>
                                            <tr style="border-bottom:1px dashed #666666;">
                                                <td width="100"><?=$r_diversos['NomePopular']?></td>
												<td width="100"><?=$r_diversos['Quantidade']?></td>
                                                <td width="50"><?=$r_diversos['Sigla']?></td>
                                                <td width="150"><?=$r_diversos['Observacoes']?></td>
                                                <? if($_GET['custo']!=''): ?>
                                                    <td width="70"><?=sprintf('%0.2f',$r_diversos['Valor']);?></td>
													<td width="70"><?=sprintf('%0.2f',$r_diversos['ValorTotal']);?></td>
                                                <? endif; ?>
                                                <? if($_GET['preco']!=''): ?>
                                                    <td width="70">
                                                        <?php
                                                            
															if($r_diversos['Lucro']>0){
																$perc    = $r_diversos['Lucro'] / 100.0;
																$Preco   = $r_diversos['Valor'] + ($perc * $r_diversos['Valor']);
															}elseif($r['LucroDiversos']>0){
																$perc    = $r['LucroDiversos'] / 100.0;
																$Preco   = $r_diversos['Valor'] + ($perc * $r_diversos['Valor']);
															}elseif($r['LucroGE']>0){
																$perc    = $r['LucroGE'] / 100.0;
																$Preco   = $r_diversos['Valor'] + ($perc * $r_diversos['Valor']);
															}else{
																$Preco = $r_diversos['Valor'];
															}
															echo sprintf('%0.2f', $Preco);
															
															/*
															$perc    = $r_diversos['Lucro'] / 100.0;
															$Preco   = $r_diversos['Valor'] + ($perc * $r_diversos['Valor']);
															
															$perc    = $r['LucroDiversos'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															$perc    = $r['LucroGE'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															echo "R$ ".sprintf('%0.2f', $Preco);
															*/
                                                        ?>
                                                    </td>
													<td width="70">
                                                        <?php
                                                            /*
															$perc    = $r_diversos['Lucro'] / 100.0;
                                                            $Preco   = $r_diversos['ValorTotal'] + ($perc * $r_diversos['ValorTotal']);
															
															$perc    = $r['LucroDiversos'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															$perc    = $r['LucroGE'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															*/
															$Preco = $Preco*$r_diversos['Quantidade'];
															echo sprintf('%0.2f', $Preco);
                                                        ?>
                                                    </td>
                                                <? endif; ?>
                                            </tr>
											<?php
											$totalcusto_div+= $r_diversos['ValorTotal'];
											$totalpreco_div+= $Preco;
											?>
                                            <?php endwhile; ?>
											<tr style="border-bottom:1px #666666; solid;">
												<td><strong>Total</strong></td>
												<td></td>
												<td></td>
												<td></td>
												<? if($_GET['custo']!=''): ?>
													<td></td>
													<td><strong><? echo "R$ ".sprintf('%0.2f', $totalcusto_div);?></strong></td>
												<? endif; ?>
												<? if($_GET['preco']!=''): ?>
													<td></td>
													<td><strong><? echo "R$ ".sprintf('%0.2f', $totalpreco_div);?></strong></td>
												<? endif; ?>
											</tr>												
                                        </tbody>
                                    </table>
                                <? endif; ?>

                                <?php if(mysql_num_rows($rs_vasos)>0 && $_GET['printvasos']!=''):?>
                                    <br />
                                    <h4>Vasos</h4> 
                                    <table cellpadding="3" cellspacing="5"  width="100%">
                                        <thead>
                                          <tr style="border-bottom:1px solid;">
                                            <th align="left">Cód</th>
                                            
                                            <th align="left">Modelo</th>
                                            <th align="left">QTDE</th>
                                            <th align="left">Cor</th>
                                            <th align="left">Esp./Forração</th>
                                            <? if($_GET['custo']!=''): ?>
                                                <th align="left">Custo unit. </th>
												<th align="left">Custo Total</th>
                                            <? endif; ?>
                                            <? if($_GET['preco']!=''): ?>
                                                <th align="left">Preço unit.</th>
												<th align="left">Preço Total</th>
                                            <? endif; ?>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php while ($r_vasos = mysql_fetch_assoc($rs_vasos)): ?>
                                            <tr style="border-bottom:1px dashed #666666;">
                                                <td width="50"><?=$r_vasos['Codigo']?></td>
                                                <td width="150"><?=$r_vasos['Modelo']?></td>
                                                <td width="40"><?=$r_vasos['Quantidade']?></td>
                                                <td width="80"><?=$r_vasos['nomeCor']?></td>
                                                <td width="80"><?=$r_vasos['Conteudo']?></td>
                                                <? if($_GET['custo']!=''): ?>
													<td width="70"><?=sprintf('%0.2f',$r_vasos['Valor'])?></td>
                                                    <td width="70"><?=sprintf('%0.2f',$r_vasos['ValorTotal'])?></td>
                                                <? endif; ?>
                                                <? if($_GET['preco']!=''): ?>
                                                    <td width="70">
                                                        <?php
                                                            /*$perc    = $r_vasos['Lucro'] / 100.0;
															$Preco   = $r_vasos['Valor'] + ($perc * $r_vasos['Valor']);
															
															$perc    = $r['LucroVasos'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															$perc    = $r['LucroGE'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															*/
															
															if($r_vasos['Lucro']>0){
																$perc    = $r_vasos['Lucro'] / 100.0;
																$Preco   = $r_vasos['Valor'] + ($perc * $r_vasos['Valor']);
															}elseif($r['LucroVasos']>0){
																$perc    = $r['LucroVasos'] / 100.0;
																$Preco   = $r_vasos['Valor'] + ($perc * $r_vasos['Valor']);
															}elseif($r['LucroGE']>0){
																$perc    = $r['LucroGE'] / 100.0;
																$Preco   = $r_vasos['Valor'] + ($perc * $r_vasos['Valor']);
															}else{
																$Preco = $r_vasos['Valor'];
															}
															echo sprintf('%0.2f', $Preco);
                                                        ?>
                                                    </td>
													<td width="70">
                                                        <?php
                                                            /*
															$perc    = $r_vasos['Lucro'] / 100.0;
                                                            $Preco   = $r_vasos['ValorTotal'] + ($perc * $r_vasos['ValorTotal']);
															
															$perc    = $r['LucroVasos'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															$perc    = $r['LucroGE'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															*/
															
															$Preco = $Preco*$r_vasos['Quantidade'];
															echo sprintf('%0.2f', $Preco);
                                                        ?>
                                                    </td>
                                                <? endif; ?>
                                            </tr>
											<?php
											$totalcusto_vaso+= $r_vasos['ValorTotal'];
											$totalpreco_vaso+= $Preco;
											?>
                                            <?php endwhile; ?>
											<tr style="border-bottom:1px #666666; solid;">
												<td><strong>Total</strong></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<? if($_GET['custo']!=''): ?>
													<td></td>
													<td><strong><? echo "R$ ".sprintf('%0.2f', $totalcusto_vaso);?></strong></td>
												<? endif; ?>
												<? if($_GET['preco']!=''): ?>
													<td></td>
													<td><strong><? echo "R$ ".sprintf('%0.2f', $totalpreco_vaso);?></strong></td>
												<? endif; ?>
											</tr>
                                        </tbody>
                                    </table>
                                    <br />
                                <? endif; ?>

                                <div class="clearfix"></div>
                               
                            </div>

                        </div><!-- End .box -->

                    </div>

                </div><!-- End .row-fluid -->
                    
            </div><!-- End #wrapper .row -->

        </div><!-- End .container -->

        <!-- Le javascript
        ================================================== -->
        <!-- Important plugins put in all pages -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap/bootstrap.js"></script>  

        <!-- Charts plugins -->    
        <script type="text/javascript" src="plugins/charts/sparkline/jquery.sparkline.min.js"></script><!-- Sparkline plugin -->
       
        <!-- Misc plugins -->    
        <script type="text/javascript" src="plugins/misc/qtip/jquery.qtip.min.js"></script><!-- Custom tooltip plugin -->   
        <script type="text/javascript" src="plugins/misc/totop/jquery.ui.totop.min.js"></script> 

        <!-- Form plugins -->
        <script type="text/javascript" src="plugins/forms/watermark/jquery.watermark.min.js"></script>    
        <script type="text/javascript" src="plugins/forms/uniform/jquery.uniform.min.js"></script>    

    </body>
</html>
