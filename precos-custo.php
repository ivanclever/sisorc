<?php
$id = (int)$_GET['id'];
$preco = (int)$_GET['preco'];

$rs = mysql_query("SELECT precos.*, f.Nome AS nomeFornecedor, f.CodFornecedor, t.Descricao, c.nome, u.Sigla, DATE_FORMAT(precos.DataCadastra,'%Y/%m/%d') as dataCad
    FROM precos
    LEFT JOIN produtos AS p ON p.CodProduto = precos.CodProduto
    LEFT JOIN fornecedores AS f ON f.Codfornecedor = precos.Codfornecedor
    LEFT JOIN tipospodas AS t ON t.CodTipoPoda = precos.CodTipoPoda
    LEFT JOIN cores AS c ON c.CodCor = precos.CodCor
    LEFT JOIN unidadesmedida AS u ON u.CodUnidadeMedida = precos.CodUnidadeMedida
    WHERE precos.CodProduto = p.CodProduto
    AND precos.status = '1'
    AND p.CodProduto = '$id'
    $cond
    GROUP BY precos.CodPreco
    ORDER BY precos.DataCadastra DESC
");

if($preco !='') $cond = "AND precos.CodPreco <> '$preco'";

if($preco != '') {
    $rs_preco = mysql_query("SELECT precos.*, f.Nome AS nomeFornecedor, f.CodFornecedor, DATE_FORMAT(precos.DataCadastra,'%Y/%m/%d') as dataCad
        FROM precos
        LEFT JOIN produtos AS p ON p.CodProduto = precos.CodProduto
        LEFT JOIN fornecedores AS f ON f.Codfornecedor = precos.Codfornecedor
        LEFT JOIN tipospodas AS t ON t.CodTipoPoda = precos.CodTipoPoda
        LEFT JOIN cores AS c ON c.CodCor = precos.CodCor
        LEFT JOIN unidadesmedida AS u ON u.CodUnidadeMedida = precos.CodUnidadeMedida
        WHERE precos.CodProduto = p.CodProduto
        AND precos.status = '1'
        AND p.CodProduto = '$id'
        AND precos.CodPreco = '$preco'
        ");
    $r_preco_current = mysql_fetch_assoc($rs_preco);

	

	
	}
	$rs_cores = mysql_query("SELECT * FROM cores");
	$rs_current_cores = mysql_query("SELECT * FROM cores");

	$rs_podas = mysql_query("SELECT * FROM tipospodas");
	$rs_current_podas = mysql_query("SELECT * FROM tipospodas");

	$rs_medidas = mysql_query("SELECT * FROM unidadesmedida ");
	$rs_current_medidas = mysql_query("SELECT * FROM unidadesmedida ");

	$rs_fornecedores = mysql_query("SELECT * FROM fornecedores ORDER BY Nome DESC");

$rs_produtos = mysql_query("SELECT NomePopular,NomeCientifico FROM produtos WHERE CodProduto = '$id'");
	$r_produto = mysql_fetch_assoc($rs_produtos);
?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
    $('#fornecedor').combogrid({
        url: 'ajax-fornecedores.php',
        debug:true,
        colModel: [{'columnName':'Nome','width':'50','label':'Nome'},{'columnName':'RazaoSocial','width':'30','label':'Razão Social'},{'columnName':'Produto','width':'10','label':'Produto'},],
        select: function( event, ui ) {
            $('#fornecedor').val( ui.item.Nome );
            $('#id_fornecedor').val( ui.item.CodFornecedor );
            return false;
        }
    });

    $('.editFornecedor').combogrid({
        url: 'ajax-fornecedores.php',
        debug:true,
        colModel: [{'columnName':'Nome','width':'50','label':'Nome'},{'columnName':'RazaoSocial','width':'30','label':'Razão Social'},{'columnName':'Produto','width':'10','label':'Produto'},],
        select: function( event, ui ) {
            var id = $(this).attr('forn');
            $(this).val(ui.item.Nome);
            $('.editPreco#'+id).attr('CodFornecedor',ui.item.CodFornecedor);
            $('span#CodFornecedor_'+id).attr('value', ui.item.CodFornecedor );
            return false;
        }
    });

    $('.interactionClassNow').remove();
	
    $('.editPrecoValor').click(function(){
        var id          = $(this).attr('id');
        var valor       = $('#valor_'+id).val();
       
        $.post('action/precos.php',
        {
            'do': 'alteravalor',
            'id': id,
            'valor': valor
        },
        function(retorno){
            alert("Valor do produto salvo com sucesso !");
            alert(id);
			$('td#valor_'+id).html(retorno);
			
			var d1 = new Date();
			var curr_day = ("0" + d1.getDate()).slice(-2);
			var curr_month = ("0" + (d1.getMonth() + 1)).slice(-2); //Months are zero based
			var curr_year = d1.getFullYear(); 
			var data_atualizada = curr_year + "-" + curr_month + "-" + curr_day;
			
			$('td#data_'+id).html(data_atualizada);		
			
        });
    });
	
	$('.editPreco').click(function(){
        var id          = $(this).attr('id');
		var idfornantigo = $(this).attr('CodFornecedor');
        var CodForn     = $('span#CodFornecedor_'+idfornantigo).attr('value');
		var poda        = $('#poda_'+id).val();
        var cor         = $('#cor_'+id).val();
        var un          = $('#un_'+id).val();
        var porte       = $('#porte_'+id).val();
        var diamCopa    = $('#diamCopa_'+id).val();
        var diamTronco  = $('#diamTronco_'+id).val();
        var altTronco   = $('#altTronco_'+id).val();
        var valor       = $('#valor_'+id).val();
        var quantidades = $('#quantidades_'+id).val();
        var fornecedor  = CodForn;

        $.post('action/precos.php',
        {
            'do': 'altera',
            'id': id,
            'poda': poda,
            'cor': cor,
            'medida': un,
            'porte': porte,
            'copa': diamCopa,
            'tronco': diamTronco,
            'altura_tronco': altTronco,
            'unidades': quantidades,
            'valor': valor,
            'id_fornecedor': fornecedor
        },
        function(retorno){
            alert("Produto salvo com sucesso !");
            $('td#valor_'+id).html(retorno);
			
			var d1 = new Date();
			var curr_day = ("0" + d1.getDate()).slice(-2);
			var curr_month = ("0" + (d1.getMonth() + 1)).slice(-2); //Months are zero based
			var curr_year = d1.getFullYear(); 
			var data_atualizada = curr_year + "-" + curr_month + "-" + curr_day;
			
			$('td#dataA_'+id).html(data_atualizada);
			
			
			
        });
    });
	
	
	$('.excluiProduto').click(function(){
        var id          = $(this).attr('id');
        //alert(id);
        $.post('action/precos.php',
        {
            'do': 'exclui',
            'id': id
        },
        function(retorno){
            alert("Produto desativado com sucesso");
            $('td#data_'+id).html("produto desativado");
			$('tr#trprod_'+id).hide();
        });
    });
	
	
    $('select.noUniform').addClass('nostyle');

});
</script>
<div class="row-fluid">

    <div class="span12">

        <div class="box gradient">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span class="left">Preços de Custo - Produto: <strong style="text-transform: uppercase;"><?=$r_produto['NomeCientifico']?> - <?=$r_produto['NomePopular']?></strong></span>
                    <a class="btn blue right" href="?s=precos-custo-inativos&id=<?=$id?>" title="Inativos" style="margin:0 5px 5px 0;"> Visualizar Inativos</a>
					<a class="btn warning right" href="?s=produtos-edit&id=<?=$id?>" title="Observações" style="margin:0 5px 5px 0;"> Ver Observações</a>
                </h4>
                <div style="clear:both"></div>
            </div>
			
			<form class="form-horizontal" action="action/precos.php" method="post">
                <input type="hidden" name="do" value="cadastra" />
                <input type="hidden" name="id_fornecedor" id="id_fornecedor" value="<?=$_SESSION['precos']['id_fornecedor']?>" />
                <input type="hidden" name="produto" value="<?=$id?>" />

                <div class="content">
                    <div class="form-row row-fluid">
                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span6" for="cor">Cor</label>
                                <div class="span6">
                                    <select name="cor" id="cor" class="span4">
                                        <option value="">Selecione</option>
                                        <?php while ($r_cores = mysql_fetch_assoc($rs_cores)): ?>
                                            <option <? if ($_SESSION['precos']['cor'] == $r_cores['CodCor']) echo 'selected="selected"'; ?> value="<?=$r_cores['CodCor']?>"><?=$r_cores['Nome']?></option>
                                        <? endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span6" for="poda">Poda</label>
                                <div class="span6">
                                    <select name="poda" id="poda" class="span4">
                                        <option value="">Selecione</option>
                                        <?php while ($r_podas = mysql_fetch_assoc($rs_podas)): ?>
                                            <option <? if ($_SESSION['precos']['poda'] == $r_podas['CodTipoPoda']) echo 'selected="selected"'; ?> value="<?=$r_podas['CodTipoPoda']?>"><?=$r_podas['Descricao']?></option>
                                        <? endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span6" for="medida">Medida</label>
                                <div class="span6">
                                    <select name="medida" id="medida" class="span4">
                                        <option value="">Selecione</option>
                                        <?php while ($r_medidas = mysql_fetch_assoc($rs_medidas)): ?>
                                            <option <? if ($_SESSION['precos']['medida'] == $r_medidas['CodUnidadeMedida']) echo 'selected="selected"'; ?> value="<?=$r_medidas['CodUnidadeMedida']?>"><?=$r_medidas['Descricao']?></option>
                                        <? endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span6" for="porte">Porte</label>
                                <input class="span6" id="porte" type="text" name="porte" value="<?=$_SESSION['precos']['porte']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-row row-fluid">
                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span6" for="fornecedor">Fornecedor</label>
                                <input class="span6" id="fornecedor" type="text" name="fornecedor" value="<?=$_SESSION['precos']['fornecedor']?>" />
                                <div id="switcher" style="float:right"></div>
                            </div>
                        </div>
                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span6" for="copa">Diam. Copa:</label>
                                <input class="span6" type="text" id="copa" name="copa" value="<?=$_SESSION['precos']['copa']?>" />
                            </div>
                        </div>
                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span6" for="tronco">Diam. Tronco:</label>
                                <input class="span6" type="text" id="tronco" name="tronco" value="<?=$_SESSION['precos']['tronco']?>" />
                            </div>
                        </div>
                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span6" for="altura_tronco">Alt. Tronco:</label>
                                <input class="span6" type="text" id="altura_tronco" name="altura_tronco" value="<?=$_SESSION['precos']['altura_tronco']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-row row-fluid">
                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span6" for="valor">Valor:</label>
                                <input class="span6" type="text" id="valor" name="valor" value="<?=$_SESSION['precos']['valor']?>" />
                            </div>
                        </div>
                    
                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span6" for="unidades">Unid. Caixa:</label>
                                <input class="span6" type="text" id="unidades" name="unidades" value="<?=$_SESSION['precos']['unidades']?>" />
                            </div>
                        </div>

                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span6" for="ranking">Ranking</label>
                                <div class="span6">
                                    <select name="ranking" id="ranking" class="span4">
                                        <option <? if ($_SESSION['precos']['ranking'] == 'A') echo 'selected="selected"'; ?> value="A">A</option>
                                        <option <? if ($_SESSION['precos']['ranking'] == 'B') echo 'selected="selected"'; ?> value="B">B</option>
                                        <option <? if ($_SESSION['precos']['ranking'] == 'C') echo 'selected="selected"'; ?> value="C">C</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-actions">
                       <button type="submit" class="btn btn-info">Adicionar Preço de custo</button>
                       <button type="button" class="btn" onclick="location.href='?s=produtos'">Cancelar</button>
					   
                    </div>
				</div>
           </form>
            
            <br />
			
            <br /> 

            <div class="content noPad" style="border-top:1px solid #C4C4C4; overflow-x:auto !important;">
                <? if($preco!=''): ?>
                <br />
                <strong style="margin:10px;">Produto selecionado:</strong>
                <table cellpadding="0" cellspacing="0" border="0" class="responsive display table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>Fornecedor</th>
                            <th>Poda</th>
                            <th>Cor</th>
                            <th>Un.</th>
                            <th>Porte(cm)</th>
                            <th>Diam. Copa</th>
                            <th>Diam. Tronco</th>
                            <th>Alt. Tronco</th>
                            <th>Un. p/caixa</th>
                            <th>Data</th>
                            <th>Valor</th>
							<th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd gradeX">
                            <td width="100">
                                <input type="text" class="editFornecedor" forn="<?=$r_preco_current['CodFornecedor']?>" id="fornecedor_<?=$r_preco_current['CodFornecedor']?>" value="<?=$r_preco_current['nomeFornecedor']?>" />
                                <span id="CodFornecedor_<?=$r_preco_current['CodFornecedor']?>" CodFornecedor="<?=$r['CodPreco']?>" value="<?=$r_preco_current['CodFornecedor']?>"></span>
                            </td>
                            <td width="50">
                                <select name="poda" id="poda_<?=$r_preco_current['CodPreco']?>" class="noUniform" style="width:100px;">
                                    <option value="">Selecione</option>
                                    <?php while ($r_current_podas = mysql_fetch_assoc($rs_current_podas)): ?>
                                        <option <? if ($r_preco_current['CodTipoPoda'] == $r_current_podas['CodTipoPoda']) echo 'selected="selected"'; ?> value="<?=$r_current_podas['CodTipoPoda']?>"><?=$r_current_podas['Descricao']?></option>
                                    <? endwhile; mysql_data_seek($rs_current_podas,0); ?>
                                </select>
                            </td>
                            <td width="50">
                                <select name="cor" id="cor_<?=$r_preco_current['CodPreco']?>" class="noUniform" style="width:100px;">
                                    <option value="">Selecione</option>
                                    <?php while ($r_current_cores = mysql_fetch_assoc($rs_current_cores)): ?>
                                        <option <? if ($r_preco_current['CodCor'] == $r_current_cores['CodCor']) echo 'selected="selected"'; ?> value="<?=$r_current_cores['CodCor']?>"><?=$r_current_cores['Nome']?></option>
                                    <? endwhile; mysql_data_seek($rs_current_cores,0); ?>
                                </select>
                            </td>
                            <td width="50">
                                <select name="medida" id="un_<?=$r_preco_current['CodPreco']?>" class="noUniform" style="width:60px;">
                                    <option value="">Selecione</option>
                                    <?php while ($r_current_medidas = mysql_fetch_assoc($rs_current_medidas)): ?>
                                        <option <? if ($r_preco_current['CodUnidadeMedida'] == $r_current_medidas['CodUnidadeMedida']) echo 'selected="selected"'; ?> value="<?=$r_current_medidas['CodUnidadeMedida']?>"><?=$r_current_medidas['Sigla']?></option>
                                    <? endwhile; mysql_data_seek($rs_current_medidas,0); ?>
                                </select>
                            </td>
                            <td width="50"><input type="text" name="porte" id="porte_<?=$r_preco_current['CodPreco']?>" value="<?=$r_preco_current['Porte']?>" style="width:50px;" /></td>
                            <td width="100"><input type="text" name="diametroCopa" id="diamCopa_<?=$r_preco_current['CodPreco']?>" value="<?=$r_preco_current['DiametroCopa']?>" style="width:50px;" /></td>
                            <td width="100"><input type="text" name="diametroTronco" id="diamTronco_<?=$r_preco_current['CodPreco']?>" value="<?=$r_preco_current['DiametroTronco']?>" style="width:50px;" /></td>
                            <td width="50"><input type="text" name="alturaTronco" id="altTronco_<?=$r_preco_current['CodPreco']?>" value="<?=$r_preco_current['AlturaTronco']?>" style="width:50px;" /></td>
                            <td width="100"><input type="text" name="UnidadesPorCaixa" id="quantidades_<?=$r_preco_current['CodPreco']?>" value="<?=$r_preco_current['UnidadesPorCaixa']?>" style="width:40px;" /></td>
                            <td width="100" id="dataA_<?=$r_preco_current['CodPreco']?>"><?=$r_preco_current['dataCad']?></td>
                            <td width="50"><input type="text" class="moeda" name="valor" id="valor_<?=$r_preco_current['CodPreco']?>" value="<?=sprintf('%0.2f', $r_preco_current['Valor']);?>" style="width:50px;" /></td>
							<td align="center">
                                <a href="javascript:;" role="buttton" CodFornecedor="<?=$r_preco_current['CodFornecedor']?>" id="<?=$r_preco_current['CodPreco']?>"  title="Salvar produto" class="btn btn-success editPreco"> <i class="icon-ok"></i> </a>
                                <a href="action/precos.php?do=copy&id=<?=$r_preco_current['CodPreco']?>" role="buttton" class="btn btn-success" title="Duplicar produto" onclick="return confirm('Deseja realmente duplicar preço?');"> <i class="icon-plus-sign"></i> </a>
								
								<!-- <a href="javascript:;" role="buttton" id="<?=$r_preco_current['CodPreco']?>" class="btn btn-danger excluiProduto"> <i class="icon-trash"></i> </a>-->
								
								<!-- <a href="action/precos-custo.php?do=exclui&id=<?=$r_preco_current['CodProduto']?>" role="buttton" class="del btn btn-danger"> <i class="icon-trash"></i></a> -->
                            </td>
                        </tr>
                    </tbody>  
                </table>
                <br />
                <? endif; ?>
                <!-- <div class="clearfix">
                    <div class="btn-group" style="float:left; margin:10px;">
                        <a class="btn blue" href="?s=precos-custo-add&id=<?=$id?>" title="Adicionar"><i class="icon-plus"></i> Adicionar</a>
                    </div>
                </div> -->
                <table cellpadding="0" cellspacing="0" border="0" class="responsive dateCad display table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>Fornecedor</th>
                            <th>Poda</th>
                            <th>Cor</th>
                            <th>Un.</th>
                            <th>Porte(cm)</th>
                            <th>Diam. Copa</th>
                            <th>Diam. Tronco</th>
                            <th>Alt. Tronco</th>
                            <th>Un. p/caixa</th>
                            <th>Data</th>
							<th>Valor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($r = mysql_fetch_assoc($rs)):
                        //print_r($r);
						if($preco != $r['CodPreco']):
						?>
                        <form id="preco_<?=$r['CodPreco']?>">
                            <tr class="odd gradeX" id="trprod_<?=$r['CodPreco']?>">
                                <td width="100">
                                    <a target="_blank" href="?s=fornecedores-edit&id=<?=$r['CodFornecedor']?>"><?=$r['nomeFornecedor']?></a>
                                </td>
                                <td width="50">
                                    
                                    <?=$r['Descricao']?>

                                </td>
                                <td width="50">
                                      <?=$r['Nome']?>
                                </td>
                                <td width="50">
                                    <?=$r['Sigla']?>
                                </td>
                                <td width="50"><?=$r['Porte']?></td>
                                <td width="100"><?=$r['DiametroCopa']?></td>
                                <td width="100"><?=$r['DiametroTronco']?></td>
                                <td width="50"><?=$r['AlturaTronco']?></td>
                                
                                <td width="100"><?=$r['UnidadesPorCaixa']?></td>
                                <td width="100" id="data_<?=$r['CodPreco']?>"><?=$r['dataCad']?></td>
								<td width="50"><div style="display:none"><?=$r['Valor']?></div><input type="text" class="moeda" name="valor" id="valor_<?=$r['CodPreco']?>" value="<?=sprintf('%0.2f', $r['Valor'])?>" style="width:50px;" /></td>
                                <td align="center">
                                    <a href="javascript:;" role="buttton" CodFornecedor="<?=$r['CodFornecedor']?>" id="<?=$r['CodPreco']?>"  title="Salvar produto" class="btn btn-success editPrecoValor"> <i class="icon-ok"></i> </a>
                                    <a href="action/precos.php?do=copy&id=<?=$r['CodPreco']?>" role="buttton" class="btn btn-success" title="Duplicar produto"  onclick="return confirm('Deseja realmente duplicar preço?');"> <i class="icon-plus-sign"></i> </a>
									
									<a href="javascript:;" role="buttton" id="<?=$r['CodPreco']?>" class="btn btn-danger excluiProduto"  title="Desativar produto"> <i class="icon-trash"></i> </a>
                                    <!-- <a href="action/precos.php?do=exclui&id=<?=$r['CodProduto']?>" role="buttton" class="del btn btn-danger"> <i class="icon-trash"></i></a> -->
                                </td>
                            </tr>
                        </form>
                        <?php 
						endif;
						endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div><!-- End .box -->

    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->