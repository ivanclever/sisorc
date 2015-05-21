<script type="text/javascript">
$(function(){
    $('.editDiv').click(function(){
        var id = $(this).attr('id');
        var quantidade = $('#quantidade_'+id).val();
        var valor = $('#valor_'+id).val();
        var lucro = $('#lucro_'+id).val();
        var obs = $('#obs_'+id).val();

        $.post('action/orcamentos.php',
        {
            'do': 'AlteraDiversos',
            'CodOrcamento': <?=$_GET['id']?>,
            'id': id,
            'quantidade': quantidade,
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
<div class="tab-pane" id="diversos">
    <form class="form-horizontal" action="action/orcamentos.php" method="post">
        <input type="hidden" name="do" value="tituloDiversos" />
        <input type="hidden" name="id_orcamento" value="<?=$_GET['id']?>" />

        <div class="form-row row-fluid">
            <div class="span4" style="margin-left:40px;">
                <div class="row-fluid">
                    <label class="form-label span4" for="titulo">Título</label>
                    <input class="span8" id="titulo" type="text" name="titulo" value="<?=$r['TituloDiversos']?>" />
                </div>
            </div>
            <div class="span3">
                <div class="row-fluid input-append">
                    <label class="form-label span4" for="lucro">Lucro:</label>
                    <input class="span6" type="text" id="lucro" name="lucro" value="<?=$r['LucroDiversos']?>" />
                    <span class="add-on">%</span>
                </div>
            </div>
            <div class="span2">
                <button type="submit" class="btn btn-info">Atualizar</button>
            </div>
        </div>
    </form>

    <form class="form-horizontal" action="action/orcamentos.php" method="post" id="produtoDiversos">
        <input type="hidden" name="do" value="CadProdutoDiversos" />
        <input type="hidden" name="id_orcamento" value="<?=$_GET['id']?>" />

        <div class="form-row row-fluid">
            <div class="span12"><br />
                <h3 style="margin-left:50px;">Produtos:</h3>
                <div class="row-fluid">
                    <label class="form-label span2" for="produto_busca_diversos">Buscar por:</label>
                    <label style="float:left;"><input type="radio" name="produto_busca_diversos" checked id="produto_busca_diversos" /> Produto/Código</label>
                    <label style="float:left; margin-left:10px;"><input type="radio" name="produto_busca_diversos" id='fornecedor_busca' /> Fornecedor</label>
                </div>
            </div>
            <div class="span4">
                <div class="row-fluid">
                    <label class="form-label span4" for="produto_diversos">Nome</label>
                    <input class="span8" id="produto_diversos" type="text" name="produto_diversos" />
                    <input id="id_produto_diversos" type="hidden" name="id_produto_diversos" />
                    <input id="id_preco_diversos" type="hidden" name="id_preco_diversos" />
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
                    <label class="form-label span4" for="lucro">Lucro</label>
                    <input class="span8" id="lucro" type="text" name="lucro" />
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

            <div style="clear:both;"></div><br />
            <div class="span12">
                <div class="row-fluid">
                    <button type="submit" class="btn btn-info" style="margin-left:50px;">Inserir</button>
                </div>
            </div>
        </div>
    </form>
    <?php
    $rs_diversos = mysql_query("SELECT produtos.CodProduto, produtos.NomePopular, orcdiversos.CodOrcDiverso, orcdiversos.Quantidade, orcdiversos.Valor, orcdiversos.Lucro, 
        orcdiversos.Observacoes, orcdiversos.CodOrcDiverso, unidadesmedida.Sigla, DATE_FORMAT( precos.DataCadastra,'%d/%m/%Y') as dataCad, orcdiversos.ValorTotal,
        fornecedores.Nome nomeFornecedor, precos.CodPreco
        FROM orcamentos, orcdiversos, precos, produtos, unidadesmedida, fornecedores
        WHERE orcdiversos.CodOrcamento = orcamentos.CodOrcamento
        AND orcdiversos.CodPreco = precos.CodPreco
        AND unidadesmedida.CodUnidadeMedida = precos.CodUnidadeMedida
        AND precos.CodProduto = produtos.CodProduto
        AND precos.CodPreco = orcdiversos.CodPreco
        AND precos.CodFornecedor = fornecedores.CodFornecedor
        AND orcamentos.CodOrcamento = '$id' ORDER BY CodOrcDiverso DESC");

    if(mysql_num_rows($rs_diversos)>0):
    ?>
        <br />
        <strong>Produtos:</strong>
        
        <table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
            <thead>
                <tr>
					<th>No</th>
                    <th>Produto</th>
                    <th>Fornecedor</th>
                    <th>QTDE</th>
                    <th>UN</th>
                    <th>Valor</th>
                    <th>Data</th>
                    <th>Obs</th>
                    <th>Total</th>
                    <th>Lucro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($r_diversos = mysql_fetch_assoc($rs_diversos)): ?>
                <form id="diversos_<?=$r_diversos['CodOrcDiverso']?>">
                <tr class="odd gradeX">
                    <td width="20"><?=$r_diversos['CodOrcDiverso']?></td>
					<td width="150"><a target="_blank" href="?s=precos-custo&id=<?=$r_diversos['CodProduto']?>&preco=<?=$r_diversos['CodPreco']?>"><?=$r_diversos['NomePopular']?></a></td>
                    <td width="150"><a target="_blank" href="?s=fornecedores-edit&id=<?=$r_diversos['CodFornecedor']?>"><strong><?=$r_diversos['nomeFornecedor']?></strong></a></td>
                    <td width="100"><input type="text" name="quantidade" id="quantidade_<?=$r_diversos['CodOrcDiverso']?>" required value="<?=$r_diversos['Quantidade']?>" /></td>
                    <td width="50"><?=$r_diversos['Sigla']?></td>
                    <td width="100"><input type="text" name="valor" id="valor_<?=$r_diversos['CodOrcDiverso']?>" value="<?=sprintf('%0.2f', $r_diversos['Valor']);?>" /></td>
                    <td width="150"><?=$r_diversos['dataCad']?></td>
                    <td width="100"><input type="text" name="obs" id="obs_<?=$r_diversos['CodOrcDiverso']?>" value="<?=$r_diversos['Observacoes']?>" /></td>
                    <td width="100" id="valor_<?=$r_diversos['CodOrcDiverso']?>">R$ <?=sprintf('%0.2f', $r_diversos['ValorTotal']);?></td>
                    <td width="50"><input type="text" name="lucro" id="lucro_<?=$r_diversos['CodOrcDiverso']?>" value="<?=$r_diversos['Lucro']?>" /></td>
                    <td align="center">
                        <a href="javascript:;" role="buttton" id="<?=$r_diversos['CodOrcDiverso']?>" CodOrcamento="<?=$id?>" class="btn btn-success editDiv"> <i class="icon-ok"></i> </a> 
                        <a href="action/orcamentos.php?do=excluiDiversos&id=<?=$r_diversos['CodOrcDiverso']?>&id_orcamento=<?=$id?>" role="buttton" class="del btn btn-danger"> <i class="icon-trash"></i> </a>
                    </td>
                </tr>
                </form>
                <?php endwhile; ?>
            </tbody>
        </table>
    <? endif ;?>
</div>