<script type="text/javascript">
$(function(){
    $('.editVeg').click(function(){
        var id = $(this).attr('id');
        var quantidade = $('#quantidade_'+id).val();
		quantidade = quantidade.replace(/,/g, '.');
        var distancia = $('#distancia_'+id).val();
        var valor = $('#valor_'+id).val();
        var lucro = $('#lucro_'+id).val();
        var obs = $('#obs_'+id).val();

        $.post('action/orcamentos.php',
        {
            'do': 'AlteraVegetais',
            'CodOrcamento': <?=$_GET['id']?>,
            'id': id,
            'quantidade': quantidade,
            'distancia': distancia,
            'lucro': lucro,
            'valor': valor,
            'obs': obs
        },
        function(retorno){
		
		$('td#valor_'+id).html("R$ " + retorno);
			alert("Produto alterado com sucesso");
        });
    });
});
</script>
<div class="tab-pane" id="vegetais">

    <form class="form-horizontal" action="action/orcamentos.php" method="post">
        <input type="hidden" name="do" value="tituloVegetais" />
        <input type="hidden" name="id_orcamento" value="<?=$_GET['id']?>" />

        <div class="form-row row-fluid">
            <div class="span4" style="margin-left:40px;">
                <div class="row-fluid">
                    <label class="form-label span4" for="titulo">Título</label>
                    <input class="span8" id="titulo" type="text" name="titulo" value="<?=$r['TituloEspeciesVegetais']?>" />
                </div>
            </div>
            <div class="span3">
                <div class="row-fluid input-append">
                    <label class="form-label span4" for="lucroVegetais">Lucro:</label>
                    <input class="span6" type="text" id="lucroVegetais" name="lucroVegetais" value="<?=$r['LucroEspeciesVegetais']?>" />
                    <span class="add-on">%</span>
                </div>
            </div>
            <div class="span2">
                <button type="submit" class="btn btn-info">Atualizar</button>
            </div>
        </div>
    </form>

    <hr />

    <form class="form-horizontal" action="action/orcamentos.php" method="post" id="produtoVegetais">
        <input type="hidden" name="do" value="CadProdutoVegetais" />
        <input type="hidden" name="id_orcamento" value="<?=$_GET['id']?>" />

        <div class="form-row row-fluid">
            <div class="span12"><br />
                <h3 style="margin-left:50px;">Produtos:</h3>
                <div class="row-fluid">
                    <label class="form-label span2" for="busca_vegetais">Buscar por:</label>
                    <label style="float:left;"><input type="radio" name="buca_vegetais" checked id="produto_busca" /> Produto/Código</label>
                    <label style="float:left; margin-left:10px;"><input type="radio" name="buca_vegetais" id='fornecedor_busca' /> Fornecedor</label>
                </div>
            </div>
            <div class="span4">
                <div class="row-fluid">
                    <label class="form-label span4" for="produto_vegetais">Nome</label>
                    <input class="span8" id="produto_vegetais" type="text" name="produto_vegetais" />
                    <input id="id_produto_vegetais" type="hidden" name="id_produto_vegetais" />
                    <input id="id_preco_vegetais" type="hidden" name="id_preco_vegetais" />
                </div>
            </div>

            <div class="span4">
                <div class="row-fluid">
                    <label class="form-label span4" for="quantidade">Qtde</label>
                    <input class="span8" id="quantidade" type="text" name="quantidade" />
                </div>
            </div>

            <div class="span4">
                <div class="row-fluid">
                    <label class="form-label span4" for="distancia">Distância</label>
                    <input class="span8" id="distancia" type="text" name="distancia" />
                </div>
            </div>
            <div style="clear:both;"></div><br />
            <div class="span4">
                <div class="row-fluid">
                    <label class="form-label span4" for="valor">Valor</label>
                    <input class="span8" id="valor" type="text" name="valor" />
                </div>
            </div>
            <div class="span4">
                <div class="row-fluid">
                    <label class="form-label span4" for="observacoes">Observações</label>
                    <input class="span8" id="observacoes" type="text" name="observacoes" />
                </div>
            </div>
            <div class="span4">
                <div class="row-fluid">
                    <label class="form-label span4" for="lucro">Lucro</label>
                    <input class="span8" id="lucro" type="text" name="lucro" />
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
    <?php
    $rs_vegetais = mysql_query("SELECT produtos.CodProduto, produtos.NomePopular,orcespeciesvegetais.CodOrcEspecieVegetal ,orcespeciesvegetais.Quantidade, orcespeciesvegetais.DistanciaPlantio, orcespeciesvegetais.Observacoes,
             orcespeciesvegetais.Valor, orcespeciesvegetais.Lucro, orcespeciesvegetais.Observacoes, orcespeciesvegetais.CodOrcEspecieVegetal, orcespeciesvegetais.ValorTotal, precos.Porte, 
             DATE_FORMAT( precos.DataCadastra,'%d/%m/%Y') as dataCad, fornecedores.Nome nomeFornecedor, precos.CodPreco, precos.Status, fornecedores.CodFornecedor
        FROM orcamentos, orcespeciesvegetais, precos, produtos, fornecedores
        WHERE orcespeciesvegetais.CodOrcamento = orcamentos.CodOrcamento
        AND orcespeciesvegetais.CodPreco = precos.CodPreco
        AND precos.CodProduto = produtos.CodProduto
        AND precos.CodPreco = orcespeciesvegetais.CodPreco
        AND precos.CodFornecedor = fornecedores.CodFornecedor
        AND orcamentos.CodOrcamento = '$id' ORDER BY CodOrcEspecieVegetal DESC");

    if(mysql_num_rows($rs_vegetais)>0):
    ?>
        <br />
        <strong>Produtos:</strong>
        <table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
            <thead>
                <tr>
                    <th>Nº</th>
					<th>Produto</th>
					<th>Fornecedor</th>
                    <th>QTDE</th>
                    <th>Dist.</th>
                    <th>Porte</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th>Observacoes</th>
                    <th>Total</th>
                    <th>Lucro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($r_vegetais = mysql_fetch_assoc($rs_vegetais)): ?>
                  <form id="vegetais_<?=$r_vegetais['CodOrcEspecieVegetal']?>">
					<tr class="odd gradeX">                    
						<td width="20"><?=$r_vegetais['CodOrcEspecieVegetal']?></td>
						<td width="150"><a target="_blank" href="?s=precos-custo&id=<?=$r_vegetais['CodProduto']?>&preco=<?=$r_vegetais['CodPreco']?>"><?=$r_vegetais['NomePopular']?></a><? if ($r_vegetais["Status"]==0){echo "<br><pre>*Desativado*</pre>";}?></td>
						<td width="150"><a target="_blank" href="?s=fornecedores-edit&id=<?=$r_vegetais['CodFornecedor']?>"><strong><?=$r_vegetais['nomeFornecedor']?></strong></a></td>
						<td width="50"><input type="text" name="quantidade" id="quantidade_<?=$r_vegetais['CodOrcEspecieVegetal']?>" required value="<?=$r_vegetais['Quantidade']?>" /></td>
						<td width="50"><input type="text" name="distancia" id="distancia_<?=$r_vegetais['CodOrcEspecieVegetal']?>" required value="<?=$r_vegetais['DistanciaPlantio']?>" /></td>
						<td width="50"><?=$r_vegetais['Porte']?></td>
						<td width="50"><input type="text" name="valor" id="valor_<?=$r_vegetais['CodOrcEspecieVegetal']?>" value="<?=sprintf('%0.2f', $r_vegetais['Valor']);?>" /></td>
						<td width="100"><?=$r_vegetais['dataCad']?></td>
						<td width="100"><input type="text" name="obs" id="obs_<?=$r_vegetais['CodOrcEspecieVegetal']?>" value="<?=$r_vegetais['Observacoes']?>" /></td>
						<td width="100" id="valor_<?=$r_vegetais['CodOrcEspecieVegetal']?>">R$ <?=sprintf('%0.2f', $r_vegetais['ValorTotal']);?></td>
						<td width="50"><input type="text" name="lucro" id="lucro_<?=$r_vegetais['CodOrcEspecieVegetal']?>" value="<?=$r_vegetais['Lucro']?>" /></td>
						<td align="center">
							<a href="javascript:;" role="buttton" id="<?=$r_vegetais['CodOrcEspecieVegetal']?>" CodOrcamento="<?=$id?>" class="btn btn-success editVeg"> <i class="icon-ok"></i> </a>
							<a href="action/orcamentos.php?do=excluiVegetais&id=<?=$r_vegetais['CodOrcEspecieVegetal']?>&id_orcamento=<?=$id?>" role="buttton" class="del btn btn-danger"> <i class="icon-trash"></i> </a>
						</td>
					</tr>
				</form>
                
                <?php endwhile; ?>                       
            </tbody>

        </table>
    <? endif ;?>
</div>