<?php

$id = (int)$_GET['id'];

$rs = mysql_query("SELECT vasos.*, fornecedores.Nome nomeFornecedor FROM vasos, fornecedores 
        WHERE vasos.CodFornecedor = fornecedores.CodFornecedor
        AND vasos.status = '1'
        ORDER BY CodVaso DESC");

if($id != ''){
$rs_preco = mysql_query("SELECT vasos.*, fornecedores.Nome nomeFornecedor FROM vasos, fornecedores 
        WHERE vasos.CodFornecedor = fornecedores.CodFornecedor
        AND vasos.status = '1' 
		AND  vasos.CodVaso = '$id'");
		
		$r_preco_current = mysql_fetch_assoc($rs_preco);
}
		
$revestimentos = mysql_query("SELECT * FROM revestimentos");

$rs_current_revestimentos = mysql_query("SELECT * FROM revestimentos");

?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
    $('#fornecedor').combogrid({
        url: 'ajax-fornecedores.php',
        debug:true,
        colModel: [{'columnName':'Nome','width':'60','label':'Nome'},{'columnName':'RazaoSocial','width':'30','label':'Razão Social'},{'columnName':'Produto','width':'10','label':'Produto'},],
        select: function( event, ui ) {
            $('#fornecedor').val( ui.item.Nome );
            $('#id_fornecedor').val( ui.item.CodFornecedor );
            return false;
        }
    });

    $('.editFornecedor').combogrid({
        url: 'ajax-fornecedores.php',
        debug:true,
        colModel: [{'columnName':'Nome','width':'60','label':'Nome'},{'columnName':'RazaoSocial','width':'30','label':'Razão Social'},{'columnName':'Produto','width':'10','label':'Produto'},],
        select: function( event, ui ) {
            var id = $(this).attr('forn');
            $(this).val(ui.item.Nome);
            $('.editVaso#'+id).attr('CodFornecedor',ui.item.CodFornecedor);
            $('span#CodFornecedor_'+id).attr('value', ui.item.CodFornecedor );
            return false;
        }
    });

    $('.interactionClassNow').remove();

    $('.editVaso').click(function(){
        var id                  = $(this).attr('id');
        var CodForn             = $(this).attr('CodFornecedor');
        var bandeja             = $('#bandeja_'+id).val();
        var revestimento        = $('#revestimento_'+id).val();
        var cod_fornecedor      = $('#CodigoFornecedor_'+id).val();
        var modelo              = $('#modelo_'+id).val();
        var dimensoes           = $('#dimensoes_'+id).val();
        var valor               = $('#valor_'+id).val();
        var fornecedor          = CodForn;

        $.post('action/vasos.php',
        {
            'do': 'altera',
            'id': id,
            'bandeja': bandeja,
            'revestimento': revestimento,
            'cod_fornecedor': cod_fornecedor,
            'modelo': modelo,
            'dimensoes': dimensoes,
            'valor': valor,
            'id_fornecedor': fornecedor
        },
			function(retorno){
				//window.location.reload();
				alert("Produto salvo com sucesso !");
				$('td#valor_'+id).html(retorno);
				
				var d1 = new Date();
				var curr_day = ("0" + d1.getDate()).slice(-2);
				var curr_month = ("0" + (d1.getMonth() + 1)).slice(-2); //Months are zero based
				var curr_year = d1.getFullYear(); 
				var data_atualizada = curr_year + "-" + curr_month + "-" + curr_day;
				
				$('td#data_'+id).html(data_atualizada);
			});
		});
		
		$('.excluiVaso').click(function(){
			var id          = $(this).attr('id');
			//alert(id);
			$.post('action/vasos.php',
			{
				'do': 'exclui',
				'id': id
			},
			function(retorno){
				alert("Vaso desativado com sucesso");
				//$('td#data_'+id).html("produto desativado");
				$('tr#trprod_'+id).hide();
			});
		});
		
		$('.excluiVaso2').click(function(){
			var id          = $(this).attr('id');
			//alert(id);
			$.post('action/vasos.php',
			{
				'do': 'exclui',
				'id': id
			},
			function(retorno){
				alert("Vaso desativado com sucesso");
				//$('td#data_'+id).html("produto desativado");
				//$('tr#trprod_'+id).hide();
				window.location.href="?s=vasos";
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
                    <span class="left">Vasos</span>
                    <a class="btn blue right" href="?s=vasos-inativos" title="Inativos" style="margin:0 5px 5px 0;"> Visualizar Inativos</a>
                </h4>
                <div style="clear:both"></div>
            </div>

            <form class="form-horizontal" action="action/vasos.php" method="post">
                <input type="hidden" name="do" value="cadastra" />

                <div class="content">
                    <div class="form-row row-fluid">
                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span4" for="fornecedor">Fornecedor</label>
                                <input class="span6" id="fornecedor" type="text" name="fornecedor" value="<?=$_SESSION['vasos']['fornecedor']?>" />
                                <input id="id_fornecedor" type="hidden" name="id_fornecedor" value="<?=$_SESSION['vasos']['id_fornecedor']?>" />
                            </div>
                        </div>

                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span4" for="bandeja">Bandeja</label>
                                <div class="span6">
                                    <select name="bandeja" id="bandeja" class="span4">
                                        <option <? if ($_SESSION['vasos']['bandeja'] == '0') echo 'selected="selected"'; ?> value="0">Não</option>
                                        <option <? if ($_SESSION['vasos']['bandeja'] == '1') echo 'selected="selected"'; ?> value="1">Sim</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span4" for="revestimento">Revestimento</label>
                                <div class="span6">
                                    <select name="revestimento" id="revestimento" class="span4">
                                        <?php while ($r_revestimentos = mysql_fetch_assoc($revestimentos)): ?>
                                            <option <? if ($_SESSION['vasos']['revestimento'] == $r_revestimentos['CodRevestimento']) echo 'selected="selected"'; ?> value="<?=$r_revestimentos['CodRevestimento']?>"><?=$r_revestimentos['Descricao']?></option>
                                        <? endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span6" for="cod_fornecedor">Cód. Fornecedor</label>
                                <input class="span6" id="cod_fornecedor" type="text" name="cod_fornecedor" value="<?=$_SESSION['vasos']['cod_fornecedor']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span4" for="modelo">Modelo</label>
                                <input class="span6" id="modelo" type="text" name="modelo" value="<?=$_SESSION['vasos']['modelo']?>" />
                            </div>
                        </div>

                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span4" for="dimensoes">Dimensões:</label>
                                <input class="span6" type="text" id="dimensoes" name="dimensoes" value="<?=$_SESSION['vasos']['dimensoes']?>" />
                            </div>
                        </div>

                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span4" for="valor">Valor:</label>
                                <input class="span6" type="text" id="valor" name="valor" value="<?=$_SESSION['vasos']['valor']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-actions">
                       <button type="submit" class="btn btn-info">Adicionar Vaso</button>
                       <button type="button" class="btn" onclick="location.href='./'">Cancelar</button>
                    </div>
                </form>
            </div>

            <br />

            <div class="content noPad" style="border-top:1px solid #C4C4C4;">
                <? if($id!=''): ?>
                <br />
                <strong style="margin:10px;">Produto selecionado:</strong>
                <table cellpadding="0" cellspacing="0" border="0" class="responsive display table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>Fornecedor</th>
                            <th>Cod. Fornecedor</th>
                            <th>Bandeja</th>
                            <th>Revestimento</th>
                            <th>Dimensões</th>
                            <th>Modelo</th>
                            <th>Valor</th>
                            <th>Data Cad.</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr class="odd gradeX" id="trprod_<?=$r_preco_current['CodVaso']?>">
                            <td width="150">
                                <div style="display:none"><?=$r_preco_current['nomeFornecedor']?></div>
                                <input type="text" class="editFornecedor" forn="<?=$r_preco_current['CodVaso']?>" id="fornecedor_<?=$r_preco_current['CodFornecedor']?>" value="<?=$r_preco_current['nomeFornecedor']?>" style="width:150px;" />
                                <span id="CodFornecedor_<?=$r_preco_current['CodVaso']?>" CodFornecedor="<?=$r_preco_current['CodVaso']?>" value="<?=$r_preco_current['CodFornecedor']?>"></span>
                            </td>
                            <td width="100">
                                <input type="text" id="CodigoFornecedor_<?=$r_preco_current['CodVaso']?>" value="<?=$r_preco_current['CodigoFornecedor']?>" style="width:100px;" />
                            </td>
                            <td width="100">
                                <select name="bandeja" id="bandeja_<?=$r['CodVaso']?>" class="noUniform" style="width:100px;">
                                    <option <? if ($r_preco_current['Bandeja'] == '0') echo 'selected="selected"'; ?> value="0">Não</option>
                                    <option <? if ($r_preco_current['Bandeja'] == '1') echo 'selected="selected"'; ?> value="1">Sim</option>
                                </select>
                            </td>
                            <td width="150">
                                <select name="revestimento" id="revestimento_<?=$r_preco_current['CodVaso']?>" class="noUniform" style="width:150px;">
                                    <?php while ($r_current_revestimentos = mysql_fetch_assoc($rs_current_revestimentos)): ?>
                                        <option <? if ($r_preco_current['CodRevestimento'] == $r_current_revestimentos['CodRevestimento']) echo 'selected="selected"'; ?> value="<?=$r_current_revestimentos['CodRevestimento']?>"><?=$r_current_revestimentos['Descricao']?></option>
                                    <? endwhile; mysql_data_seek($rs_current_revestimentos,0); ?>
                                </select>
                            </td>
                            <td width="150"><input type="text" name="dimensoes" id="dimensoes_<?=$r_preco_current['CodVaso']?>" value="<?=$r_preco_current['Dimensoes']?>" style="width:150px;" /></td>
                            <td width="100"><div style="display:none"><?=$r_preco_current['Modelo']?></div><input type="text" name="modelo" id="modelo_<?=$r_preco_current['CodVaso']?>" value="<?=$r_preco_current['Modelo']?>" style="width:100px;" /></td>
                            <td width="50"><div style="display:none"><?=$r_preco_current['Valor']?></div><input type="text" class="moeda" name="valor" id="valor_<?=$r_preco_current['CodVaso']?>" value="<?=$r_preco_current['Valor']?>" style="width:50px;" /></td>
                            <td width="100" id="data_<?=$r_preco_current['CodVaso']?>"><?=$r_preco_current['DataCadastra']?></td>
                            <td align="center">
                                <a href="javascript:;" role="buttton" CodFornecedor="<?=$r_preco_current['CodFornecedor']?>" id="<?=$r_preco_current['CodVaso']?>" class="btn btn-info editVaso"> <i class="icon-ok"></i> </a>
                                <a href="javascript:;" role="buttton" id="<?=$r_preco_current['CodVaso']?>" class="btn btn-danger excluiVaso2"> <i class="icon-trash"></i> </a>
								
								<!-- <a href="action/vasos.php?do=exclui&id=<?=$r['CodVaso']?>" role="buttton" class="del btn btn-danger"> <i class="icon-trash"></i> </a>-->
                            </td>
                        </tr>
                    </tbody>  
                </table>
                <br />
                <? endif; ?>
				
				
				<table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>Fornecedor</th>
                            <th>Cod. Fornecedor</th>
                            <th>Bandeja</th>
                            <th>Revestimento</th>
                            <th>Dimensões</th>
                            <th>Modelo</th>
                            <th>Valor</th>
                            <th>Data Cad.</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($r = mysql_fetch_assoc($rs)): ?>
                        <tr class="odd gradeX" id="trprod_<?=$r['CodVaso']?>">
                            <td width="150">
                                <div style="display:none"><?=$r['nomeFornecedor']?></div>
                                <input type="text" class="editFornecedor" forn="<?=$r['CodVaso']?>" id="fornecedor_<?=$r['CodFornecedor']?>" value="<?=$r['nomeFornecedor']?>" style="width:150px;" />
                                <span id="CodFornecedor_<?=$r['CodVaso']?>" CodFornecedor="<?=$r['CodVaso']?>" value="<?=$r['CodFornecedor']?>"></span>
                            </td>
                            <td width="100">
                                <input type="text" id="CodigoFornecedor_<?=$r['CodVaso']?>" value="<?=$r['CodigoFornecedor']?>" style="width:100px;" />
                            </td>
                            <td width="100">
                                <select name="bandeja" id="bandeja_<?=$r['CodVaso']?>" class="noUniform" style="width:100px;">
                                    <option <? if ($r['Bandeja'] == '0') echo 'selected="selected"'; ?> value="0">Não</option>
                                    <option <? if ($r['Bandeja'] == '1') echo 'selected="selected"'; ?> value="1">Sim</option>
                                </select>
                            </td>
                            <td width="150">
                                <select name="revestimento" id="revestimento_<?=$r['CodVaso']?>" class="noUniform" style="width:150px;">
                                    <?php while ($r_current_revestimentos = mysql_fetch_assoc($rs_current_revestimentos)): ?>
                                        <option <? if ($r['CodRevestimento'] == $r_current_revestimentos['CodRevestimento']) echo 'selected="selected"'; ?> value="<?=$r_current_revestimentos['CodRevestimento']?>"><?=$r_current_revestimentos['Descricao']?></option>
                                    <? endwhile; mysql_data_seek($rs_current_revestimentos,0); ?>
                                </select>
                            </td>
                            <td width="150"><input type="text" name="dimensoes" id="dimensoes_<?=$r['CodVaso']?>" value="<?=$r['Dimensoes']?>" style="width:150px;" /></td>
                            <td width="100"><div style="display:none"><?=$r['Modelo']?></div><input type="text" name="modelo" id="modelo_<?=$r['CodVaso']?>" value="<?=$r['Modelo']?>" style="width:100px;" /></td>
                            <td width="50"><div style="display:none"><?=$r['Valor']?></div><input type="text" class="moeda" name="valor" id="valor_<?=$r['CodVaso']?>" value="<?=$r['Valor']?>" style="width:50px;" /></td>
                            <td width="100" id="data_<?=$r['CodVaso']?>"><?=$r['DataCadastra']?></td>
                            <td align="center">
                                <a href="javascript:;" role="buttton" CodFornecedor="<?=$r['CodFornecedor']?>" id="<?=$r['CodVaso']?>" class="btn btn-info editVaso"> <i class="icon-ok"></i> </a>
                                <a href="javascript:;" role="buttton" id="<?=$r['CodVaso']?>" class="btn btn-danger excluiVaso"> <i class="icon-trash"></i> </a>
								
								<!-- <a href="action/vasos.php?do=exclui&id=<?=$r['CodVaso']?>" role="buttton" class="del btn btn-danger"> <i class="icon-trash"></i> </a>-->
                            </td>
                        </tr>
                        <?php endwhile; ?>                       
                    </tbody>
                </table>
            </div>

        </div><!-- End .box -->

    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->