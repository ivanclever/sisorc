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
    AND precos.status = '0'
    AND p.CodProduto = '$id'
    $cond
    GROUP BY precos.CodPreco
    ORDER BY precos.DataCadastra DESC
");

?>
<script type="text/javascript" src="js/jquery.min.js"></script>

<div class="row-fluid">

    <div class="span12">

        <div class="box gradient">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span class="left">Preços de Custo - Produto: <strong style="text-transform: uppercase;"><?=$r_produto['NomePopular']?></strong></span>
                    <a class="btn blue right" href="?s=precos-custo&id=<?=$id?>" title="Inativos" style="margin:0 5px 5px 0;"> Voltar</a>
                </h4>
                <div style="clear:both"></div>
            </div>
            <div class="content">
                <div class="clearfix">
                    <div class="btn-group" style="float:left; margin:10px;">
                        <a class="btn blue" href="?s=precos-custo&id=<?=$id?>" title="Adicionar"><i class="entypo-icon-back"></i> Voltar para ativos</a>
                    </div>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="responsive dateCad display table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>Fornecedor</th>
                            <th>Poda</th>
                            <th>Cor</th>
                            <th>Un.</th>
                            <th>Porte</th>
                            <th>Diam. Copa</th>
                            <th>Diam. Tronco</th>
                            <th>Alt. Tronco</th>
                            <th>Valor</th>
                            <th>UNDES</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($r = mysql_fetch_assoc($rs)):
                        ?>
                        <form id="preco_<?=$r['CodPreco']?>">
                            <tr class="odd gradeX">
                                <td width="100">
                                    <?=$r['nomeFornecedor']?>
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
                                <td width="100"><?=$r['dataCad']?></td>
								<td width="50"><?=$r['Valor']?></td>
                                <td align="center">
                                    <a href="action/precos.php?do=ativa&id=<?=$r['CodPreco']?>" id="<?=$r['CodPreco']?>" class="btn btn-info editPreco"> <i class="icon-ok"></i> Ativar</a>
                                </td>
                            </tr>
                        </form>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div><!-- End .box -->

    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->