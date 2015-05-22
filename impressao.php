<?php
ob_start();
require('util/conn.php');
require('util/util.php');

$id_orcamento = (int)$_GET['id_orcamento'];

$rs = mysql_query("SELECT orcamentos.*, clientes.Nome nomeCliente, clientes.CPF_CNPJ, clientes.TelefoneComercial, clientes.Email
    FROM orcamentos, clientes
    WHERE orcamentos.CodCliente = clientes.CodCliente
    AND orcamentos.CodOrcamento = '$id_orcamento'");
$r = mysql_fetch_assoc($rs);

$rs_vegetais = mysql_query("SELECT produtos.CodProduto, produtos.NomePopular,produtos.NomeCientifico, orcespeciesvegetais.Quantidade, orcespeciesvegetais.DistanciaPlantio,
     orcespeciesvegetais.Valor, orcespeciesvegetais.Lucro, orcespeciesvegetais.Observacoes, orcespeciesvegetais.CodOrcEspecieVegetal, orcespeciesvegetais.ValorTotal,  precos.Porte, DATE_FORMAT( precos.DataCadastra,'%d/%m/%Y') as dataCad 
        FROM orcamentos, orcespeciesvegetais, precos, produtos 
        WHERE orcespeciesvegetais.CodOrcamento = orcamentos.CodOrcamento 
        AND orcespeciesvegetais.CodPreco = precos.CodPreco 
        AND precos.CodProduto = produtos.CodProduto 
        AND orcamentos.CodOrcamento = '$id_orcamento' ORDER BY produtos.NomeCientifico ASC");

$rs_forracoes = mysql_query("SELECT produtos.CodProduto, produtos.NomePopular,produtos.NomeCientifico, orcforracoes.QtdeM2, orcforracoes.QtdeCaixasMudas,orcforracoes.DistanciaPlantio, orcforracoes.Valor,orcforracoes.ValorTotal, orcforracoes.Lucro, orcforracoes.Observacoes, orcforracoes.CodOrcForracao, precos.Porte, precos.DataCadastra, DATE_FORMAT( precos.DataCadastra,'%d/%m/%Y') as dataCad
    FROM orcamentos, orcforracoes, precos, produtos
    WHERE orcforracoes.CodOrcamento = orcamentos.CodOrcamento
    AND orcforracoes.CodPreco = precos.CodPreco
    AND precos.CodProduto = produtos.CodProduto
    AND orcamentos.CodOrcamento = '$id_orcamento' ORDER BY produtos.NomeCientifico ASC");

$rs_diversos = mysql_query("SELECT produtos.CodProduto, produtos.NomePopular, orcdiversos.Quantidade, orcdiversos.Valor, orcdiversos.Lucro, 
    orcdiversos.Observacoes, orcdiversos.CodOrcDiverso, unidadesmedida.Sigla, DATE_FORMAT( precos.DataCadastra,'%d/%m/%Y') as dataCad, orcdiversos.ValorTotal
    FROM orcamentos, orcdiversos, precos, produtos, unidadesmedida
    WHERE orcdiversos.CodOrcamento = orcamentos.CodOrcamento
    AND orcdiversos.CodPreco = precos.CodPreco
    AND unidadesmedida.CodUnidadeMedida = precos.CodUnidadeMedida
    AND precos.CodProduto = produtos.CodProduto
    AND orcamentos.CodOrcamento = '$id_orcamento' ORDER BY produtos.NomeCientifico ASC");

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
                html, body { border: 0; font-size:8pt; }
                .box .title { border-bottom: 1px solid #c4c4c4; border: 0; }
                .content { border: 0 !important; }    
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
                                    <div class="print">
										<a href="#" class="tip" title="Imprimir Orçamento" onClick="window.print()"><span class="icon24 icomoon-icon-printer-2"></span></a>
									</div>
									<span class="number" style="margin-left:30px;">Orçamento <strong class="red">#<?=$r['JOB']?></strong></span>
                                    <span class="data gray" style="margin-left:30px;"><?=date('d/m/Y');?></span>
                                    <div class="clearfix"></div>
									
                                </div>
								 <h4 class="right">
                                    <span><img src="images/logo-impressao.png" width="90" style="margin-right:25px;"  /></span>
                                </h4>
                            </div>
                            <div class="content">
                                <div class="you">
                                    <ul class="unstyled">
                                        <li><h3><?=$r['nomeCliente']?></h3></li>
                                        <li><span class="icon16 icomoon-icon-arrow-right-2"></span><?=$r['TelefoneComercial']?></li>
                                    </ul>
                                </div>
                                <div class="client">
                                    <ul class="unstyled">
                                        <li><h3><?=$r['Obra']?></h3></li>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                                <?php if(mysql_num_rows($rs_vegetais)>0):?>
                                    <h4>Espécies Vegetais</h4>
                                    <table class="responsive table table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Produto</th>
											<th>Nome Cient.</th>
                                            <th>QTDE</th>
                                            <th>Porte</th>
											
                                            <th>Observacoes</th>
                                            <? if($_GET['custo']!=''): ?>
                                                <th>Custo unit. </th>
												<th>Custo Total</th>
                                            <? endif; ?>
                                            <? if($_GET['preco']!=''): ?>
                                                <th>Preço unit.</th>
												<th>Preço Total</th>
                                            <? endif; ?>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($r_vegetais = mysql_fetch_assoc($rs_vegetais)): ?>
                                            <tr class="odd gradeX">
                                                <td width="100"><?=$r_vegetais['NomePopular']?></td>
												<td width="100"><?=$r_vegetais['NomeCientifico']?></td>
                                                <td width="30"><?=$r_vegetais['Quantidade']?></td>
												<td width="30"><?=$r_vegetais['Porte']?></td>
                                                
                                                <td width="100"><?=$r_vegetais['Observacoes']?></td>
                                                <? if($_GET['custo']!=''): ?>
													<td width="80">R$ <?=sprintf('%0.2f',$r_vegetais['Valor']);?></td>
                                                    <td width="80">R$ <?=sprintf('%0.2f', $r_vegetais['ValorTotal']);?></td>
                                                <? endif; ?>
                                                <? if($_GET['preco']!=''): ?>
                                                    <td width="80">
                                                        <?php
                                                            $perc    = $r_vegetais['Lucro'] / 100.0;
															$Preco   = $r_vegetais['Valor'] + ($perc * $r_vegetais['Valor']);
															
															$perc    = $r['LucroEspeciesVegetais'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															$perc    = $r['LucroGE'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															echo "R$ ".sprintf('%0.2f', $Preco);
                                                        ?>
                                                    </td>
													<td width="80">
                                                        <?php
                                                            $perc    = $r_vegetais['Lucro'] / 100.0;
                                                            $Preco   = $r_vegetais['ValorTotal'] + ($perc * $r_vegetais['ValorTotal']);
															
															$perc    = $r['LucroEspeciesVegetais'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															$perc    = $r['LucroGE'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															echo "R$ ".sprintf('%0.2f', $Preco);
                                                        ?>
                                                    </td>
                                                <? endif; ?>
                                            </tr>
                                            <?php endwhile; ?>                       
                                        </tbody>
                                    </table>
                                <? endif; ?>

                                <?php if(mysql_num_rows($rs_forracoes)>0):?>
                                    <br />
                                    <h4>Forrações</h4>
                                    <table class="responsive table table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Produto</th>
											<th>Nome Cient.</th>
                                            <th>QTDE M²</th>
                                            <th>Distancia</th>
                                            <th>Qtde itens</th>
                                            <th>Porte</th>
                                            
                                            <th>Obs</th>
                                            <? if($_GET['custo']!=''): ?>
                                                <th>Custo m2. </th>
												<th>Custo Total</th>
                                            <? endif; ?>
                                            <? if($_GET['preco']!=''): ?>
                                                <th>Preço m2.</th>
												<th>Preço Total</th>
                                            <? endif; ?>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($r_forracoes = mysql_fetch_assoc($rs_forracoes)): ?>
                                            <tr class="odd gradeX">
                                                <td width="120"><?=$r_forracoes['NomePopular']?></td>
												<td width="100"><?=$r_forracoes['NomeCientifico']?></td>
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
                                                            $perc    = $r_forracoes['Lucro'] / 100.0;
															$Preco   = $r_forracoes['ValorTotal'] + ($perc * $r_forracoes['ValorTotal']);
															
															$perc    = $r['LucroForracoes'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															$perc    = $r['LucroGE'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															
															echo "R$ ".sprintf('%0.2f',$Preco/$r_forracoes['QtdeM2']);
                                                        ?>
                                                    </td>
													<td width="80">
                                                        <?php
															echo "R$ ".sprintf('%0.2f', $Preco);
                                                        ?>
                                                    </td>
                                                <? endif; ?>
                                            </tr>
                                            <?php endwhile; ?>                       
                                        </tbody>
                                    </table>
                                <? endif; ?>

                                <?php if(mysql_num_rows($rs_diversos)>0):?>
                                    <br />
                                    <h4>Diversos</h4>
                                    <table class="responsive table table-bordered">
                                        <thead>
                                          <th>Produto</th>
										  
                                            <th>QTDE</th>
                                            <th>UNIDADE</th>
                                            <th>Obs</th>
                                           <? if($_GET['custo']!=''): ?>
                                                <th>Custo unit. </th>
												<th>Custo Total</th>
                                            <? endif; ?>
                                            <? if($_GET['preco']!=''): ?>
                                                <th>Preço unit.</th>
												<th>Preço Total</th>
                                            <? endif; ?>
                                        </thead>
                                        <tbody>
                                          <?php while ($r_diversos = mysql_fetch_assoc($rs_diversos)): ?>
                                            <tr class="odd gradeX">
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
                                                            $perc    = $r_diversos['Lucro'] / 100.0;
															$Preco   = $r_diversos['Valor'] + ($perc * $r_diversos['Valor']);
															
															$perc    = $r['LucroDiversos'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															$perc    = $r['LucroGE'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															echo "R$ ".sprintf('%0.2f', $Preco);
                                                        ?>
                                                    </td>
													<td width="70">
                                                        <?php
                                                            $perc    = $r_diversos['Lucro'] / 100.0;
                                                            $Preco   = $r_diversos['ValorTotal'] + ($perc * $r_diversos['ValorTotal']);
															
															$perc    = $r['LucroDiversos'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															$perc    = $r['LucroGE'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															echo "R$ ".sprintf('%0.2f', $Preco);
                                                        ?>
                                                    </td>
                                                <? endif; ?>
                                            </tr>
                                            <?php endwhile; ?>  
                                        </tbody>
                                    </table>
                                <? endif; ?>

                                <?php if(mysql_num_rows($rs_vasos)>0):?>
                                    <br />
                                    <h4>Vasos</h4>
                                    <table class="responsive table table-bordered">
                                        <thead>
                                          <tr>
                                            <th>Cód</th>
                                            <th>Fornecedor</th>
                                            <th>Modelo</th>
                                            <th>QTDE</th>
                                            <th>Cor</th>
                                            <th>Esp./Forração</th>
                                            <? if($_GET['custo']!=''): ?>
                                                <th>Custo unit. </th>
												<th>Custo Total</th>
                                            <? endif; ?>
                                            <? if($_GET['preco']!=''): ?>
                                                <th>Preço unit.</th>
												<th>Preço Total</th>
                                            <? endif; ?>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php while ($r_vasos = mysql_fetch_assoc($rs_vasos)): ?>
                                            <tr class="odd gradeX">
                                                <td width="50"><?=$r_vasos['Codigo']?></td>
                                                <td width="150"><?=$r_vasos['nomeFornecedor']?></td>
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
                                                            $perc    = $r_vasos['Lucro'] / 100.0;
															$Preco   = $r_vasos['Valor'] + ($perc * $r_vasos['Valor']);
															
															$perc    = $r['LucroVasos'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															$perc    = $r['LucroGE'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															echo "R$ ".sprintf('%0.2f', $Preco);
                                                        ?>
                                                    </td>
													<td width="70">
                                                        <?php
                                                            $perc    = $r_vasos['Lucro'] / 100.0;
                                                            $Preco   = $r_vasos['ValorTotal'] + ($perc * $r_vasos['ValorTotal']);
															
															$perc    = $r['LucroVasos'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															$perc    = $r['LucroGE'] / 100.0;
															$Preco   = $Preco + ($perc * $Preco);
															
															echo "R$ ".sprintf('%0.2f', $Preco);
                                                        ?>
                                                    </td>
                                                <? endif; ?>
                                            </tr>
                                            <?php endwhile; ?> 
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
