<?php
$id = (int)$_GET['id'];
$rs_totalizacoes = mysql_query("SELECT CustoMA, PrecoMA, CustoMO, PrecoMO, LucroMO, CustoGE, PrecoGE  FROM orcamentos WHERE CodOrcamento = '$id'");
$r_totalizacoes = mysql_fetch_assoc($rs_totalizacoes);
?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
    $('#calcular').click(function(){


        
		//alert("click");
		
		$.post('action/orcamentos.php',
        {
            'do': 'calculaCusto',
            'CodOrcamento': <?=$_GET['id']?>,
            'CustoMA': $('#CustoMA').val(),
            'CustoMO': $('#CustoMO').val()
        },
        function(retorno){
            $('#CustoGE').val(retorno);
			
			$.post('action/orcamentos.php',
			{
				'do': 'calculaPrecoMO',
				'CodOrcamento': <?=$_GET['id']?>,
				'CustoMO': $('#CustoMO').val(),
				'LucroMO': $('#LucroMO').val()
			},
			function(retorno){
				$('#PrecoMO').val(retorno);
				
				$.post('action/orcamentos.php',
				{
					'do': 'calculaPreco',
					'CodOrcamento': <?=$_GET['id']?>,
					'PrecoMA': $('#PrecoMA').val(),
					'PrecoMO': $('#PrecoMO').val(),
					'LucroGE': $('#LucroGE').val()
				},
				function(retorno){
					$('#PrecoGE').val(retorno);
				});
				
			});
			
			});
			
        });
		//$('.moeda').priceFormat({ prefix: '', centsSeparator: ',', thousandsSeparator: '' });
		
        //return false;
		
		
		
		
		
        
		
		
		
        //return false;
    
	/*
    $('#LucroMO').blur(function(){
        $.post('action/orcamentos.php',
        {
            'do': 'calculaPrecoMO',
            'CodOrcamento': <?=$_GET['id']?>,
            'CustoMO': $('#CustoMO').val(),
            'LucroMO': $('#LucroMO').val()
        },
        function(retorno){
            $('#PrecoMO').val(retorno);
        });
        //return false;
    });
	*/
    //$('.moeda').priceFormat({ prefix: '', centsSeparator: ',', thousandsSeparator: '' });
});
</script>
<div class="tab-pane" id="totalizacoes">

    <div class="span4">
        <h3>Materiais</h3>
        <div class="form-row row-fluid">
            <div class="span12">
                <div class="row-fluid">
                    <label class="form-label span6" for="CustoMA">Custo</label>
                    <input class="span6 moeda" id="CustoMA" type="text" name="CustoMA" value="<?=$r_totalizacoes['CustoMA']?>" />
                </div>
            </div>
        </div>
        <div class="form-row row-fluid" style="background-color:#679000;padding:5px;">
            <div class="span12">
                <div class="row-fluid input-append">
                    <label class="form-label span6" for="PrecoMA"><strong>Preço:</strong></label>
                    <input class="span6 moeda" type="text" id="PrecoMA" name="PrecoMA" value="<?=$r_totalizacoes['PrecoMA']?>" />
                </div>
            </div>
        </div>
    </div>

    <div class="span4">
        <h3>Mão de obra</h3>
        <div class="form-row row-fluid">
            <div class="span12">
                <div class="row-fluid">
                    <label class="form-label span6" for="CustoMO">Custo</label>
                    <input class="span6 moeda" id="CustoMO" type="text" name="CustoMO" value="<?=$r_totalizacoes['CustoMO']?>" />
                </div>
            </div>
        </div>
        <div class="form-row row-fluid" style="background-color:#679000;padding:5px;">
            <div class="span12">
                <div class="row-fluid">
                    <label class="form-label span6" for="PrecoMO"><strong>Preço:</strong></label>
                    <input class="span6 moeda" type="text" id="PrecoMO" name="PrecoMO" value="<?=$r_totalizacoes['PrecoMO']?>" />
                </div>
            </div>
        </div>
        <div class="form-row row-fluid">
            <div class="span12">
                <div class="row-fluid input-append">
                    <label class="form-label span6" for="LucroMO">Lucro:</label>
                    <input class="span6" type="text" id="LucroMO" name="LucroMO" value="<?=$r_totalizacoes['LucroMO']?>" />
                    <span class="add-on">%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="span3">
        <h3>Geral</h3>
        <div class="form-row row-fluid">
            <div class="span12">
                <div class="row-fluid">
                    <label class="form-label span6" for="CustoGE">Custo</label>
                    <input class="span6 moeda" id="CustoGE" type="text" name="CustoGE" value="<?=$r_totalizacoes['CustoGE']?>" />
                </div>
            </div>
        </div>
        <div class="form-row row-fluid" style="background-color:#679000;padding:5px;">
            <div class="span12">
                <div class="row-fluid input-append">
                    <label class="form-label span6" for="PrecoGE"><strong>Preço:</strong></label>
                    <input class="span6 moeda" type="text" id="PrecoGE" name="PrecoGE" value="<?=$r_totalizacoes['PrecoGE']?>" />
                </div>
            </div>
        </div>

        <!-- <div class="form-row row-fluid">
            <div class="span8">
                <div class="row-fluid input-append">
                    <label class="form-label span4" for="lucro_total">Lucro:</label>
                    <input class="span6" type="text" id="lucro_total" name="lucro_total" value="<?=$_SESSION['orcamentos']['preco_total']?>" />
                    <span class="add-on">%</span>
                </div>
            </div>
        </div> -->
    </div>

    <div style="clear:both;"></div>

    <br /><br />

    <div class="form-actions" style="clear:both; text-align:center;">
        <button type="submit" class="btn btn-info" id="calcular"><i class="icomoon-icon-calculate"></i> Calcular</button>
        <button type="button" class="btn" onclick="action/orcamentos.php?do=exclui&id=<?=$r['CodOrcamento']?>"><i class="icon-trash"></i> Excluir</button>
        <button type="button" class="btn" id="openChamada"><i class="icon-print"></i> Imprimir</button>

        <!-- ui dialog -->
        <div id="dialogChamada" title="Opções de impressão" class="dialog">
            <form target="_blank" action="impressao.php">
                <input type="hidden" name="id_orcamento" value="<?=$id?>" />
                <br style="clear:both;" />
                <div class="span6">
                    <div class="row-fluid">
                        <label class="form-label span4" for="checkboxes">Selecione:</label><br /><br />
                        
                        <div class="left marginT5 marginR10">
                            <label>
                                <input type="checkbox" name="preco" id="check" value="1" checked="checked" class="styled" /> Visualizar Preço
                            </label>
                        </div>
                        <div class="left marginT5 marginR10">
                            <label>
                                <input type="checkbox" name="custo" id="check" value="2" class="styled" /> Visualizar Custo
                            </label>
                        </div>
                    </div>

                     <br style="clear:both;" /><br />
                    <button type="submit" class="btn btn-info"> Visualizar</button>
                </div>
               
    
            </form>
        </div>
    </div>


</div>