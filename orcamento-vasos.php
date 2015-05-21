<?php
$cores = mysql_query("SELECT * FROM cores");
?>
<script type="text/javascript">
$(function(){
    $('.editVas').click(function(){
        var id = $(this).attr('id');
        var quantidade = $('#quantidade_'+id).val();
        var valor = $('#valor_'+id).val();
        var lucro = $('#lucro_'+id).val();
        var obs = $('#obs_'+id).val();

        $.post('action/orcamentos.php',
        {
            'do': 'AlteraVasos',
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
<div class="tab-pane" id="vasos">
    <form class="form-horizontal" action="action/orcamentos.php" method="post">
        <input type="hidden" name="do" value="tituloVasos" />
        <input type="hidden" name="id_orcamento" value="<?=$_GET['id']?>" />

        <div class="form-row row-fluid">
            <div class="span4" style="margin-left:40px;">
                <div class="row-fluid">
                    <label class="form-label span4" for="titulo">Título</label>
                    <input class="span8" id="titulo" type="text" name="titulo" value="<?=$r['TituloVasos']?>" />
                </div>
            </div>
            <div class="span3">
                <div class="row-fluid input-append">
                    <label class="form-label span4" for="lucro">Lucro:</label>
                    <input class="span6" type="text" id="lucro" name="lucro" value="<?=$r['LucroVasos']?>" />
                    <span class="add-on">%</span>
                </div>
            </div>
            <div class="span2">
                <button type="submit" class="btn btn-info">Atualizar</button>
            </div>
        </div>
    </form>

    <br />

    <form class="form-horizontal" action="action/orcamentos.php" method="post" id="produtoVasos">
        <input type="hidden" name="do" value="CadProdutoVasos" />
        <input type="hidden" name="id_orcamento" value="<?=$_GET['id']?>" />

        <div class="form-row row-fluid">
            <!-- <div class="span12"><br />
                <h3 style="margin-left:50px;">Produtos:</h3>
                <div class="row-fluid">
                    <label class="form-label span2" for="busca_vasos">Buscar por:</label>
                    <label style="float:left;"><input type="radio" name="busca_vasos" checked id="produto_busca_vasos" /> Produto/Código</label>
                    <label style="float:left; margin-left:10px;"><input type="radio" name="busca_vasos" id='fornecedor_busca' /> Fornecedor</label>
                </div>
            </div> -->

            <div class="span4">
                <div class="row-fluid">
                    <label class="form-label span4" for="produto_vasos">Nome</label>
                    <input class="span8" id="produto_vasos" type="text" name="produto_vasos" />
                    <input id="id_produto_vasos" type="hidden" name="id_produto_vasos" />
                    <input id="id_preco_vasos" type="hidden" name="id_preco_vasos" />
                </div>
            </div>

            <div class="span4">
                <div class="row-fluid">
                    <label class="form-label span4" for="cor">Cor</label>
                    <div class="span8">
                        <select name="cor" id="cor" class="span4">
                            <?php while ($r_cores = mysql_fetch_assoc($cores)): ?>
                                <option value="<?=$r_cores['CodCor']?>"><?=$r_cores['Nome']?></option>
                            <? endwhile; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="span4">
                <div class="row-fluid">
                    <label class="form-label span4" for="codigo">Código</label>
                    <input class="span8" id="codigo" type="text" name="codigo" />
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
                    <label class="form-label span4" for="conteudo">Conteúdo</label>
                    <input class="span8" id="conteudo" type="text" name="conteudo" />
                </div>
            </div>
            <div class="span4">
                <div class="row-fluid">
                    <label class="form-label span4" for="quantidade">Quantidade</label>
                    <input class="span8" id="quantidade" type="text" name="quantidade" />
                </div>
            </div>
            <div style="clear:both;"></div><br />
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
    $rs_vasos = mysql_query("SELECT orcvasos.Codigo, vasos.CodVaso, vasos.Modelo, orcvasos.CodOrcVaso , orcvasos.Quantidade, orcvasos.Conteudo, orcvasos.Valor, orcvasos.ValorTotal, orcvasos.Lucro, orcvasos.CodOrcVaso, cores.Nome nomeCor, fornecedores.Nome nomeFornecedor,fornecedores.CodFornecedor
        FROM orcamentos, orcvasos, vasos, cores, fornecedores
        WHERE orcvasos.CodOrcamento = orcamentos.CodOrcamento
        AND vasos.CodVaso = orcvasos.CodVaso
        AND orcvasos.CodCor = cores.CodCor
        AND vasos.CodFornecedor = fornecedores.CodFornecedor
        AND orcamentos.CodOrcamento = '$id' ORDER BY CodOrcVaso DESC");

    if(mysql_num_rows($rs_vasos)>0):
    ?>
        <br />
        <strong>Produtos:</strong>

        <table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
            <thead>
                <tr>
                    <th>No</th>
					<th>Cód</th>
                    <th>Fornecedor</th>
                    <th>Modelo</th>
                    <th>QTDE</th>
                    <th>Cor</th>
                    <th>Esp./Forração</th>
                    <th>Valor</th>
                    <th>Total</th>
                    <th>Lucro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($r_vasos = mysql_fetch_assoc($rs_vasos)): ?>
                <form id="vasos_<?=$r_vasos['CodOrcVaso']?>">
                    <tr class="odd gradeX">
						<td width="20"><?=$r_vasos['CodOrcVaso']?></td>
                        <td width="50"><?=$r_vasos['Codigo']?></td>
                        <td width="150"><a target="_blank" href="?s=fornecedores-edit&id=<?=$r_vasos['CodFornecedor']?>"><?=$r_vasos['nomeFornecedor']?></a></td>
                        <td width="150"><a target="_blank" href="?s=vasos&id=<?=$r_vasos['CodVaso']?>"><?=$r_vasos['Modelo']?></a></td>
                        <td width="50"><input type="text" name="quantidade" id="quantidade_<?=$r_vasos['CodOrcVaso']?>" value="<?=$r_vasos['Quantidade']?>" /></td>
                        <td width="100"><?=$r_vasos['nomeCor']?></td>
                        <td width="100"><?=$r_vasos['Conteudo']?></td>
                        <td width="50"><input type="text" name="valor" id="valor_<?=$r_vasos['CodOrcVaso']?>" value="<?=sprintf('%0.2f',$r_vasos['Valor']);?>" /></td>
                        <td width="100" id="valor_<?=$r_vasos['CodOrcVaso']?>">R$ <?=sprintf('%0.2f',$r_vasos['ValorTotal']);?></td>
                        <td width="50"><input type="text" name="lucro" id="lucro_<?=$r_vasos['CodOrcVaso']?>" value="<?=$r_vasos['Lucro']?>" /></td>
                        <td align="center">
                            <a href="javascript:;" role="buttton" id="<?=$r_vasos['CodOrcVaso']?>" CodOrcamento="<?=$id?>" class="btn btn-success editVas"> <i class="icon-ok"></i></a>
                            <a href="action/orcamentos.php?do=excluiVasos&id=<?=$r_vasos['CodOrcVaso']?>&id_orcamento=<?=$id?>" role="buttton" class="del btn btn-danger"> <i class="icon-trash"></i></a>
                        </td>
                    </tr>
                </form>
                <?php endwhile; ?>                       
            </tbody>
        </table>
    <? endif ;?>
</div>