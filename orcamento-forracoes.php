<script type="text/javascript">
$(function(){
    $('.editFor').click(function(){
        var id = $(this).attr('id');
        var quantidade = $('#quantidade_'+id).val();
		quantidade = quantidade.replace(/,/g, '.');
		var qm2 = $('#qm2_'+id).val();
        var distancia = $('#distancia_'+id).val();
        var valor = $('#valor_'+id).val();
        var lucro = $('#lucro_'+id).val();
        var obs = $('#obs_'+id).val();
        var unidade = $('span#unidade_'+id).attr('value');
        var unidadesPorCaixa = $('span#cx_'+id).attr('value');

        $.post('action/orcamentos.php',
        {
            'do': 'AlteraForracoes',
            'CodOrcamento': <?=$_GET['id']?>,
            'id': id,
            'quantidade': quantidade,
			'qm2': qm2,
            'distancia': distancia,
            'lucro': lucro,
            'valor': valor,
            'obs': obs,
            'unidade': unidade,
            'UnidadesPorCaixa': unidadesPorCaixa
        },
        function(retorno){
			$('td#valortotal_'+id).html("R$ " + retorno);
			alert("Produto alterado com sucesso");
        });
    });
	
});
</script>
<div class="tab-pane" id="forracoes">
    <form class="form-horizontal" action="action/orcamentos.php" method="post">
        <input type="hidden" name="do" value="tituloForracoes" />
        <input type="hidden" name="id_orcamento" value="<?=$_GET['id']?>" />

        <div class="form-row row-fluid">
            <div class="span4" style="margin-left:40px;">
                <div class="row-fluid">
                    <label class="form-label span4" for="titulo">Título</label>
                    <input class="span8" id="titulo" type="text" name="titulo" value="<?php if (!isset($r['TituloForracoes']) || $r['TituloForracoes']==""){echo "Forrações";}else{echo $r['TituloForracoes'];} ?>" />
                </div>
            </div>
            <div class="span3">
                <div class="row-fluid input-append">
                    <label class="form-label span4" for="lucro">Lucro:</label>
                    <input class="span6" type="text" id="lucro" name="lucro" value="<?=$r['LucroForracoes']?>" />
                    <span class="add-on">%</span>
                </div>
            </div>
            <div class="span2">
                <button type="submit" class="btn btn-info">Atualizar</button>
            </div>
        </div>
    </form>

    <form class="form-horizontal" action="action/orcamentos.php" method="post" id="produtoForracoes">
        <input type="hidden" name="do" value="CadProdutoForracoes" />
        <input type="hidden" name="id_orcamento" value="<?=$_GET['id']?>" />

        <div class="form-row row-fluid">
            <div class="span12"><br />
                <h3 style="margin-left:50px;">Produtos:</h3>
                <div class="row-fluid">
                    <label class="form-label span2" for="busca_vegetais">Buscar por:</label>
                    <label style="float:left;">
					<input type="radio" name="buca_forracoes" checked id="produto_busca" /> Produto/Código</label>
                    <label style="float:left; margin-left:10px;">
					<input type="radio" name="buca_forracoes" id='fornecedor_busca' /> Fornecedor</label>
                </div>
            </div>
            <div class="span3">
                <div class="row-fluid">
                    <label class="form-label span4" for="produto_forracoes">Nome</label>
                    <input class="span8" id="produto_forracoes" type="text" name="produto_forracoes" />
                    <input id="id_produto_forracoes" type="hidden" name="id_produto_forracoes" />
                    <input id="id_preco_forracoes" type="hidden" name="id_preco_forracoes" />
                    <input id="unidade" type="hidden" name="unidade" />
                    <input id="UnidadesPorCaixa" type="hidden" name="UnidadesPorCaixa" />
                </div>
            </div>

            <div class="span3">
                <div class="row-fluid">
                    <label class="form-label span6" for="quantidade">Qtde M²</label>
                    <input class="span6" id="quantidade" type="text" name="quantidade" />
                </div>
            </div>

            <div class="span3">
                <div class="row-fluid">
                    <label class="span4" for="distancia">Distancia</label>
                    <div class="span4">
                        <select name="distancia" id="distancia">
    						<option value=""></option>
    						<option value="10">10</option>
    						<option value="15">15</option>
    						<option value="20">20</option>
    						<option value="25">25</option>
    						<option value="30">30</option>
    						<option value="35">35</option>
    						<option value="40">40</option>
    						<option value="45">45</option>
    						<option value="50">50</option>
    					</select>
                    </div>
                </div>
            </div>
			<div class="span3">
                <div class="row-fluid">
                    <label class="form-label span6" for="distancia">Qtde Mudas/m2</label>
                    <input class="span6" id="qm2" type="text" name="qm2" />
                </div>
            </div>
            <div class="span4">
                <div class="row-fluid">
                    <label class="form-label span6" for="valor">Valor</label>
                    <input class="span6" id="valor" type="text" name="valor" />
                </div>
            </div>
            <div class="span4">
                <div class="row-fluid">
                    <label class="form-label span6" for="observacoes">Observações</label>
                    <input class="span6" id="observacoes" type="text" name="observacoes" />
                </div>
            </div>
            
            <div class="span4">
                <div class="row-fluid">
                    <label class="form-label span6" for="lucro">Lucro</label>
                    <input class="span6" id="lucro" type="text" name="lucro" />
                </div>
            </div>
            <div style="clear:both;"></div><br />
            <div class="span12">
                <div class="row-fluid">
                    <button type="submit" class="btn btn-info" style="margin-left:50px;">Inserir</button>
                </div>
            </div>
        </div>
    </form>
    <br />
    <strong>Produtos:</strong>
    <?php
    $rs_forracoes = mysql_query("SELECT produtos.CodProduto,produtos.Codigo, produtos.NomePopular,produtos.NomeCientifico, orcforracoes.CodOrcForracao, orcforracoes.QtdeM2, orcforracoes.QtdeCaixasMudas,orcforracoes.DistanciaPlantio, orcforracoes.quantidade_mudas_m2,
        orcforracoes.Valor,orcforracoes.ValorTotal, orcforracoes.Lucro, orcforracoes.Observacoes, orcforracoes.CodOrcForracao, precos.Porte, precos.DataCadastra,
        DATE_FORMAT( precos.DataCadastra,'%d/%m/%Y') as dataCad, fornecedores.Nome nomeFornecedor, fornecedores.CodFornecedor, unidadesmedida.Sigla, precos.UnidadesPorCaixa, precos.CodPreco
        FROM orcamentos, orcforracoes, precos, unidadesmedida, produtos, fornecedores
        WHERE orcforracoes.CodOrcamento = orcamentos.CodOrcamento
        AND orcforracoes.CodPreco = precos.CodPreco
        AND precos.CodProduto = produtos.CodProduto
        AND precos.CodFornecedor = fornecedores.CodFornecedor
        AND precos.CodUnidadeMedida = unidadesmedida.CodUnidadeMedida
        AND orcamentos.CodOrcamento = '$id' ORDER BY produtos.NomeCientifico ASC");
    ?>
    <table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
        <thead>
            <tr>
                <th>Nº</th>
				<th>Codigo</th>
				<th>Nome Cient.</th>
				<th>Nome Pop.</th>
                <th>Fornecedor</th>
                <th>QTDE M²</th>
                <th>Dist.</th>
                <th>Qtde cx/md</th>
				<th>Unid.</th>
                <th>Porte(cm)</th>
                <th>Valor</th>
                <th>Mudas/m2</th>
				<th>Data</th>
                <th>Obs</th>
                <th>Total</th>
                <th>Lucro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($r_forracoes = mysql_fetch_assoc($rs_forracoes)): ?>
            <span id="unidade_<?=$r_forracoes['CodOrcForracao']?>" value="<?=$r_forracoes['Sigla']?>" /></span>
            <span id="cx_<?=$r_forracoes['CodOrcForracao']?>" value="<?=$r_forracoes['UnidadesPorCaixa']?>" /></span>
            <form id="forracoes_<?=$r_forracoes['CodOrcForracao']?>">
                <tr class="odd gradeX">
                    <td width="20"><?=$r_forracoes['CodOrcForracao']?></td>
					<td width="20"><?=$r_forracoes['Codigo']?></td>
					<td width="100"><input type="text" name="forrnomecient" class="itemorcbusca"  id="itemorcbusca_<?=$r_forracoes['CodOrcForracao'].'_forracoes'?>" value="<?=$r_forracoes['NomeCientifico']?>"></td>
					<td width="100"><a href="?s=precos-custo&id=<?=$r_forracoes['CodProduto']?>&preco=<?=$r_forracoes['CodPreco']?>"><?=$r_forracoes['NomePopular']?></a></td>
					<td width="100"><a href="?s=fornecedores-edit&id=<?=$r_forracoes['CodFornecedor']?>"><strong><?=$r_forracoes['nomeFornecedor']?></strong></a></td>
                    <td width="30"><input type="text" name="quantidade" id="quantidade_<?=$r_forracoes['CodOrcForracao']?>" required value="<?=$r_forracoes['QtdeM2']?>" /></td>
                    <td width="30"><input type="text" name="distancia" id="distancia_<?=$r_forracoes['CodOrcForracao']?>" required value="<?=$r_forracoes['DistanciaPlantio']?>" /></td>
                    <td width="30"><?=$r_forracoes['QtdeCaixasMudas']?></td>
                    <td width="20" id="unidade_<?=$r_forracoes['CodOrcForracao']?>"><?=$r_forracoes['Sigla']?></td>
					<td width="30"><?=$r_forracoes['Porte']?></td>
                    <td width="40"><input type="text" name="valor" id="valor_<?=$r_forracoes['CodOrcForracao']?>" required value="<?=sprintf('%0.2f', $r_forracoes['Valor']);?>" /></td>
					<td width="30"><input type="text" name="qm2" id="qm2_<?=$r_forracoes['CodOrcForracao']?>" required value="<?=$r_forracoes['quantidade_mudas_m2']?>" /></td>
                    <td width="70"><?=$r_forracoes['dataCad']?></td>
                    <td width="80"><input type="text" name="obs" id="obs_<?=$r_forracoes['CodOrcForracao']?>" value="<?=$r_forracoes['Observacoes']?>" /></td>
                    <td width="70" id="valortotal_<?=$r_forracoes['CodOrcForracao']?>"><strong>R$ <?=sprintf('%0.2f', $r_forracoes['ValorTotal']);?></strong></td>
                    <td width="30"><input type="text" name="lucro" id="lucro_<?=$r_forracoes['CodOrcForracao']?>" value="<?=$r_forracoes['Lucro']?>" /></td>
                    <td align="center">
                        <a href="javascript:;" role="buttton" id="<?=$r_forracoes['CodOrcForracao']?>" CodOrcamento="<?=$id?>" class="btn btn-success editFor"> <i class="icon-ok"></i> </a>
                        <a href="action/orcamentos.php?do=excluiForracoes&id=<?=$r_forracoes['CodOrcForracao']?>&id_orcamento=<?=$id?>" role="buttton" class="del btn btn-danger"> <i class="icon-trash"></i> </a>
                    </td>
                </tr>
            </form>
            <?php endwhile; ?>                       
        </tbody>
    </table>
</div>