<?php
$id = (int)$_GET['id'];

$rs = mysql_query("SELECT orcamentos.*, clientes.Nome nomeCliente FROM orcamentos, clientes WHERE orcamentos.CodCliente = clientes.CodCliente AND CodOrcamento = '$id'");
$r = mysql_fetch_assoc($rs);
?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/maskpreco.js"></script>
<script type="text/javascript">

function atualizaOrcamento(id){
	var conf = confirm("Atenção: você irá atualizar todos os valores deste orçamento com os preços mais atuais. Deseja continuar?");
	if (conf){
		window.location.href= "action/orcamentos.php?do=refresh&id=" + id + "&do=refresh&obra=" + $('#obra').val() + "&job=" + $('#job').val() + "&lucro=" + $('#LucroGE').val();
	}
} 

function editaOrcamento(id){
	var conf = confirm("Confirma a alteração dos dados do orçamento?");
	if (conf){
		window.location.href= "action/orcamentos.php?do=edita_infos&id=" + id + "&obra=" + $('#obra').val() + "&job=" + $('#job').val() + "&lucro=" + $('#LucroGE').val();
	}
} 
		
$(function(){
	$('#produto_vegetais').click(function(){
        if($('#produto_busca').is(':checked')) {
            $('#produto_vegetais').combogrid({
                url: 'ajax-produtos.php',
				sidx: 'DataCadastra',
				sord: 'desc',
                debug:false,
                colModel: [
                    {'columnName':'DataCadastra','width':'7','label':'Data'},
					{'columnName':'Codigo','width':'5','label':'Codigo'},
                    {'columnName':'NomeCient','width':'15','label':'Nome Cient.'},
					{'columnName':'Produto','width':'15','label':'Nome Popular'},
					{'columnName':'NFornecedor','width':'10','label':'Fornecedor'},
                    //{'columnName':'Poda','width':'10','label':'Poda'},
                    {'columnName':'Sigla','width':'5','label':'Un'},
                    {'columnName':'Porte','width':'5','label':'Porte'},
                    {'columnName':'Diametro','width':'10','label':'Diam. Tr'},
                    {'columnName':'Altura','width':'5','label':'Alt. Tr'},
                    {'columnName':'Valor','width':'5','label':'R$'},
                    {'columnName':'Unidades','width':'5','label':'Un. Cx'},
                    {'columnName':'Cor','width':'5','label':'Cor'},
                    ],
                select: function( event, ui ) {
                    $('#produto_vegetais').val( ui.item.Produto );
                    $('#produtoVegetais #valor').val( ui.item.Valor );
                    $('#id_produto_vegetais').val( ui.item.CodProduto );
                    $('#id_preco_vegetais').val( ui.item.CodPreco );
                    return false;
                }

            });
        } else {
            $('#produto_vegetais').combogrid({
                url: 'ajax-produtos-fornecedores.php',
                sidx: 'DataCadastra',
				sord: 'desc',
				debug:false,
                colModel: [
                    {'columnName':'DataCadastra','width':'7','label':'Data'},
                    {'columnName':'Codigo','width':'5','label':'Codigo'},
					{'columnName':'NomeCient','width':'15','label':'Nome Cient.'},
					{'columnName':'Produto','width':'15','label':'Nome Popular'},
					{'columnName':'NFornecedor','width':'10','label':'Fornecedor'},
                    //{'columnName':'Poda','width':'10','label':'Poda'},
                    {'columnName':'Sigla','width':'5','label':'Un'},
                    {'columnName':'Porte','width':'5','label':'Porte'},
                    {'columnName':'Diametro','width':'5','label':'Diam. Tr'},
                    {'columnName':'Altura','width':'5','label':'Alt. Tr'},
                    {'columnName':'Valor','width':'5','label':'R$'},
                    {'columnName':'Unidades','width':'5','label':'Un. Cx'},
                    {'columnName':'Cor','width':'5','label':'Cor'},
                    ],
                select: function( event, ui ) {
                    $('#produto_vegetais').val( ui.item.Produto );
                    $('#produtoVegetais #valor').val( ui.item.Valor );
                    $('#id_produto_vegetais').val( ui.item.CodProduto );
                    $('#id_preco_vegetais').val( ui.item.CodPreco );
                    return false;
                }
            });
        }
    });
	
	$(".itemorcbusca").click(function(){
		//alert($(this).attr('id'));
		var arraysplit = $(this).attr('id').split("_");
		var itemid = arraysplit[1];
		var tipo = arraysplit[2]
		//alert(itemid);	
		//alert($(this).attr('id'));
		$('#'+$(this).attr('id')).combogrid({
			url: 'ajax-produtos.php',
			sidx: 'DataCadastra',
			sord: 'desc',
			debug:false,
			colModel: [
				{'columnName':'DataCadastra','width':'7','label':'Data'},
				{'columnName':'Codigo','width':'5','label':'Codigo'},
				{'columnName':'NomeCient','width':'15','label':'Nome Cient.'},
				{'columnName':'Produto','width':'15','label':'Nome Popular'},
				{'columnName':'NFornecedor','width':'10','label':'Fornecedor'},
				//{'columnName':'Poda','width':'10','label':'Poda'},
				{'columnName':'Sigla','width':'5','label':'Un'},
				{'columnName':'Porte','width':'5','label':'Porte'},
				{'columnName':'Diametro','width':'10','label':'Diam. Tr'},
				{'columnName':'Altura','width':'5','label':'Alt. Tr'},
				{'columnName':'Valor','width':'5','label':'R$'},
				{'columnName':'Unidades','width':'5','label':'Un. Cx'},
				{'columnName':'Cor','width':'5','label':'Cor'},
				],
				select: function( event, ui ) {
					$.post('action/orcamentos.php',
					{
						'do': 'AlteraItemOrcamento',
						'tipo': tipo,
						'CodOrcamento': <?=$_GET['id']?>,
						'quantidade':$('#quantidade_'+itemid).val(),
						'id': itemid,
						'novocodpreco':ui.item.CodPreco,
						'novovalor': ui.item.Valor
					},
					function(retorno){
						//$('#valor_'+itemid).html(ui.item.Valor);
						$('#valortotal_'+itemid).html(retorno);
						//alert("Produto alterado com sucesso, a página será atualizada");
						window.location.hash = "#"+tipo;
						location.reload();
					});
				//return false;
			}
		});
	});
	
	

    $('#produto_forracoes').click(function(){
        if($('#produto_busca').is(':checked')) {
            $('#produto_forracoes').combogrid({
                url: 'ajax-produtos.php',
				sidx: 'DataCadastra',
				sord: 'desc',
                debug:false,
                colModel: [
                    {'columnName':'DataCadastra','width':'7','label':'Data'},
                    {'columnName':'Codigo','width':'5','label':'Codigo'},
					{'columnName':'NomeCient','width':'15','label':'Nome Cient.'},
					{'columnName':'Produto','width':'15','label':'Nome Popular'},
                    {'columnName':'NFornecedor','width':'10','label':'Fornecedor'},
                    //{'columnName':'Poda','width':'10','label':'Poda'},
                    {'columnName':'Sigla','width':'5','label':'Un'},
                    {'columnName':'Porte','width':'5','label':'Porte'},
                    //{'columnName':'Diametro','width':'10','label':'Diam. Tr'},
                    {'columnName':'Altura','width':'5','label':'Alt. Tr'},
                    {'columnName':'Valor','width':'5','label':'R$'},
                    {'columnName':'Unidades','width':'5','label':'Un. Cx'},
                    {'columnName':'Cor','width':'5','label':'Cor'}
                    ],
                select: function( event, ui ) {
                    $('#produto_forracoes').val( ui.item.Produto );
                    $('#produtoForracoes #valor').val( ui.item.Valor );
                    $('#produtoForracoes #unidade').val( ui.item.Sigla );
                    $('#produtoForracoes #UnidadesPorCaixa').val( ui.item.Unidades );
                    $('#id_produto_forracoes').val( ui.item.CodProduto );
                    $('#id_preco_forracoes').val( ui.item.CodPreco );
                    return false;
                }
            });
        } else {
            $('#produto_forracoes').combogrid({
                url: 'ajax-produtos-fornecedores.php',
				sidx: 'DataCadastra',
				sord: 'desc',
                debug:false,
                colModel: [
                    {'columnName':'DataCadastra','width':'7','label':'Data'},
                    {'columnName':'Codigo','width':'5','label':'Codigo'},
					{'columnName':'NomeCient','width':'15','label':'Nome Cient.'},
					{'columnName':'Produto','width':'15','label':'Nome Popular'},
                    {'columnName':'NFornecedor','width':'10','label':'Fornecedor'},
                    //{'columnName':'Poda','width':'10','label':'Poda'},
                    {'columnName':'Sigla','width':'5','label':'Un'},
                    {'columnName':'Porte','width':'5','label':'Porte'},
                    {'columnName':'Diametro','width':'10','label':'Diam. Tr'},
                    {'columnName':'Altura','width':'5','label':'Alt. Tr'},
                    {'columnName':'Valor','width':'5','label':'R$'},
                    {'columnName':'Unidades','width':'5','label':'Un. Cx'},
                    {'columnName':'Cor','width':'5','label':'Cor'},
                    ],
                select: function( event, ui ) {
                    $('#produto_forracoes').val( ui.item.Produto );
                    $('#produtoForracoes #valor').val( ui.item.Valor );
                    $('#produtoForracoes #unidade').val( ui.item.Sigla );
                    $('#produtoForracoes #UnidadesPorCaixa').val( ui.item.Unidades );
                    $('#id_produto_forracoes').val( ui.item.CodProduto );
                    $('#id_preco_forracoes').val( ui.item.CodPreco );
                    return false;
                }
            });
        }
    });

    $('#produto_diversos').click(function(){
        if($('#produto_busca_diversos').is(':checked')) {
            $('#produto_diversos').combogrid({
                url: 'ajax-produtos.php',
				sidx: 'DataCadastra',
				sord: 'desc',
                debug:false,
                colModel: [
                    {'columnName':'DataCadastra','width':'7','label':'Data'},
                    {'columnName':'Codigo','width':'5','label':'Codigo'},
					{'columnName':'NomeCient','width':'15','label':'Nome Cient.'},
					{'columnName':'Produto','width':'15','label':'Nome Popular'},
					{'columnName':'NFornecedor','width':'10','label':'Fornecedor'},
                    //{'columnName':'Poda','width':'10','label':'Poda'},
                    {'columnName':'Sigla','width':'5','label':'Un'},
                    {'columnName':'Porte','width':'5','label':'Porte'},
                    {'columnName':'Diametro','width':'5','label':'Diam. Tr'},
                    {'columnName':'Altura','width':'5','label':'Alt. Tr'},
                    {'columnName':'Valor','width':'5','label':'R$'},
                    {'columnName':'Unidades','width':'5','label':'Un. Cx'},
                    {'columnName':'Cor','width':'5','label':'Cor'},
                    ],
                select: function( event, ui ) {
                    $('#produto_diversos').val( ui.item.Produto );
                    $('#produtoDiversos #valor').val( ui.item.Valor );
                    $('#id_produto_diversos').val( ui.item.CodProduto );
                    $('#id_preco_diversos').val( ui.item.CodPreco );
                    return false;
                }

            });
        } else {
            $('#produto_diversos').combogrid({
                url: 'ajax-produtos-fornecedores.php',
				sidx: 'DataCadastra',
				sord: 'desc',
                debug:false,
                colModel: [
                    {'columnName':'DataCadastra','width':'7','label':'Data'},
                    {'columnName':'Codigo','width':'5','label':'Codigo'},
					{'columnName':'NomeCient','width':'15','label':'Nome Cient.'},
					{'columnName':'Produto','width':'15','label':'Nome Popular'},
                    {'columnName':'NFornecedor','width':'10','label':'Fornecedor'},
                    //{'columnName':'Poda','width':'10','label':'Poda'},
                    {'columnName':'Sigla','width':'5','label':'Un'},
                    {'columnName':'Porte','width':'5','label':'Porte'},
                    {'columnName':'Diametro','width':'10','label':'Diam. Tr'},
                    {'columnName':'Altura','width':'5','label':'Alt. Tr'},
                    {'columnName':'Valor','width':'5','label':'R$'},
                    {'columnName':'Unidades','width':'5','label':'Un. Cx'},
                    {'columnName':'Cor','width':'5','label':'Cor'},
                    ],
                select: function( event, ui ) {
                    $('#produto_diversos').val( ui.item.Produto );
                    $('#produtoDiversos #valor').val( ui.item.Valor );
                    $('#id_produto_diversos').val( ui.item.CodProduto );
                    $('#id_preco_diversos').val( ui.item.CodPreco );
                    return false;
                }
            });
        }
    });

    $('#produto_vasos').click(function(){
    
        $('#produto_vasos').combogrid({
            url: 'ajax-vasos.php',
			sidx: 'DataCadastra',
			sord: 'desc',
            debug:false,
            colModel: [
                {'columnName':'DataCadastra','width':'15','label':'Data'},
                {'columnName':'Codigo','width':'15','label':'Codigo'},
				{'columnName':'Modelo','width':'15','label':'Produto'},
                {'columnName':'Descricao','width':'15','label':'Revestimento'},
                {'columnName':'Dimensoes','width':'15','label':'Dimensoes'},
                {'columnName':'Valor','width':'10','label':'Valor'},
                {'columnName':'Fornecedor','width':'15','label':'Fornecedor'},
                ],
            select: function( event, ui ) {
                $('#produto_vasos').val( ui.item.Modelo );
                $('#produtoVasos #valor').val( ui.item.Valor );
                $('#id_produto_vasos').val( ui.item.CodVaso );
                //$('#id_preco_vasos').val( ui.item.CodPreco );
                return false;
            }
        });
    });

    if(window.location.hash.substr(1)=='vegetais') {
        $('#tabs li:eq(0)').addClass('active');
        $('#vegetais').addClass('active');
    } else if(window.location.hash.substr(1) == 'forracoes') {
        $('#tabs li:eq(1)').addClass('active');
        $('#forracoes').addClass('active');
    } else if(window.location.hash.substr(1) == 'diversos') {
        $('#tabs li:eq(2)').addClass('active');
        $('#diversos').addClass('active');
    } else if(window.location.hash.substr(1) == 'vasos') {
        $('#tabs li:eq(3)').addClass('active');
        $('#vasos').addClass('active');
    } else if(window.location.hash.substr(1) == 'totalizacoes') {
        $('#tabs li:eq(4)').addClass('active');
        $('#totalizacoes').addClass('active');
    } else {
        $('#tabs li:eq(0)').addClass('active');
        $('#vegetais').addClass('active');
    }

    $('#tabs li:eq(4)').click(function(){

        $.post('action/orcamentos.php',{ 'do': 'totalizaCusto', 'CodOrcamento': <?=$_GET['id']?> },
		function(retorno){
            $('#CustoMA').val(retorno).priceFormat({ prefix: '', centsSeparator: ',', thousandsSeparator: '.' });
			
			$.post('action/orcamentos.php',
		{
			'do': 'calculaCusto',
			'CodOrcamento': <?php echo $id;?>,
			'CustoMA': $('#CustoMA').val(),
			'CustoMO': $('#CustoMO').val()
		},
		function(retorno){
			$('#CustoGE').val(retorno).priceFormat({ prefix: '', centsSeparator: ',', thousandsSeparator: '.' });;
			
			$.post('action/orcamentos.php',
			{
				'do': 'calculaPrecoMO',
				'CodOrcamento': <?php echo $id;?>,
				'CustoMO': $('#CustoMO').val(),
				'LucroMO': $('#LucroMO').val()
			},
			function(retorno){
				$('#PrecoMO').val(retorno).priceFormat({ prefix: '', centsSeparator: ',', thousandsSeparator: '.' });;
				//$('#CustoMO').val().ToFixed(2);
				
				$.post('action/orcamentos.php',
				{ 
					'do': 'totalizaPreco', 
					'CodOrcamento': <?php echo $id;?>,
					'LucroGE': $('#LucroGE').val()
				},
				function(retorno){
					$('#PrecoMA').val(retorno).priceFormat({ prefix: '', centsSeparator: ',', thousandsSeparator: '.' });;
					
					$.post('action/orcamentos.php',
					{
						'do': 'calculaPreco',
						'CodOrcamento': <?php echo $id;?>,
						'PrecoMA': $('#PrecoMA').val(),
						'PrecoMO': $('#PrecoMO').val(),
						'LucroMO': $('#LucroMO').val(),
						'LucroGE': $('#LucroGE').val()
					},
					function(retorno){
						$('#PrecoGE').val(retorno).priceFormat({ prefix: '', centsSeparator: ',', thousandsSeparator: '.' });;
					});
				});	
			});
		});
        });
		
		//$('#PrecoMA').val("calcular");
		
		/*
        $.post('action/orcamentos.php',{ 'do': 'totalizaPreco', 'CodOrcamento': <?=$_GET['id']?>, 'LucroGE': $('#LucroGE').val() },function(retorno){
            $('#PrecoMA').val(retorno);
        });
		*/
        //$('.moeda').priceFormat({ prefix: '', centsSeparator: ',', thousandsSeparator: '' });
    });

    // $('#tabs li:eq(4)').click(function(){
    //     $.post('action/orcamentos.php',{ 'do': 'totalizaCusto', 'CodOrcamento': <?=$_GET['id']?> },function(retorno){
    //         $('#custo_materiais').val(retorno);
    //     });
    // });
    // 

});
</script>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                    <span>Adicionar Produtos</span>
					<a href="action/orcamentos.php?do=copy&id=<?=$id?>" role="buttton" class="btn btn-info right" title="Duplicar orçamento"> <i class="icon-plus-sign"></i> Duplicar este orçamento</a>
			<a href="#" role="buttton" class="btn btn-danger right" title="Atualizar orçamento" onclick="atualizaOrcamento(<?=$id?>);"> <i class="icon-refresh"></i> Atualizar todos os Preços</a>			
                </h4>
			
            </div>
			
			
            <div class="content">
                <div class="form-row row-fluid">
                    <div class="span2">
                        <div class="row-fluid">
                            <label class="form-label span4" for="job">JOB:</label>
                            <input class="span6" id="job" type="text" name="job" value="<?=$r['JOB']?>" />
                        </div>
                    </div>

                    <div class="span2">
                        <div class="row-fluid">
                            <label class="form-label span4" for="cliente">Cliente:</label>
                            <input class="span8" id="cliente" type="text" name="cliente" readonly value="<?=$r['nomeCliente']?>" />
                            <!-- <input id="id_cliente" type="hidden" name="id_cliente" value="<?=$_SESSION['orcamentos']['id_cliente']?>" /> -->
                        </div>
                    </div>

                    <div class="span3">
                        <div class="row-fluid">
                            <label class="form-label span6" for="obra">Obra/Serviço:</label>
                            <input class="span6" id="obra" type="text" name="obra" value="<?=$r['Obra']?>" />
                        </div>
                    </div>

                    <div class="span2">
                        <div class="row-fluid input-append">
                            <label class="form-label span8" for="LucroGE">Lucro:</label>
                            <input class="span4" id="LucroGE" type="text" name="LucroGE" value="<?=$r['LucroGE']?>" />
							<span class="add-on">%</span>
                        </div>
                    </div>
					<div class="span2">
					<div class="row-fluid">
						<a href="#" role="buttton" class="btn btn-info" title="Salvar" onclick="editaOrcamento(<?=$id?>);"> <i class="icon-ok"></i> Salvar</a>
					</div>
					</div>
				</div>
				
                <div class="form-row row-fluid">
                    <div class="span12">
                        <div class="page-header">
                            <h4>Dados gerais</h4>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <ul id="tabs" class="nav nav-tabs pattern">
                                <li class=""><a href="#vegetais" data-toggle="tab">Espécies Vegetais</a></li>
                                <li class=""><a href="#forracoes" data-toggle="tab">Forrações</a></li>
                                <li class=""><a href="#diversos" data-toggle="tab">Diversos</a></li>
                                <li class=""><a href="#vasos" data-toggle="tab">Vasos</a></li>
                                <li class=""><a href="#totalizacoes" data-toggle="tab">Totalizações</a></li>
                            </ul>
                            <div class="tab-content">
                                <?php include('orcamento-vegetais.php'); ?>
                                <?php include('orcamento-forracoes.php'); ?>
                                <?php include('orcamento-diversos.php'); ?>
                                <?php include('orcamento-vasos.php'); ?>
                                <?php include('orcamento-totalizacoes.php'); ?>
                            </div>
                        </div>
                    </div>

                </div><!-- End .row-fluid -->

            </div>
        </div><!-- End .box -->
    </div><!-- End .span12 -->
</div><!-- End .row-fluid -->
