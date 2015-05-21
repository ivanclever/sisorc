<?php
$rs = mysql_query("SELECT produtos.*, categoriasprodutos.Nome nomeCategoria FROM produtos, categoriasprodutos
    WHERE produtos.CodCategoriaProduto = categoriasprodutos.CodCategoriaProduto 
    AND produtos.status = '0'
    ORDER BY produtos.CodProduto DESC");
?>
<div class="row-fluid">

    <div class="span12">
        <div class="box gradient">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span>Produtos</span>
                </h4>
            </div>
            <div class="content noPad clearfix">
                <div class="clearfix">
                    <div class="btn-group" style="margin:10px;">
                        <a class="btn blue" href="?s=produtos" title="Voltar para Ativos"><i class="entypo-icon-back"></i> Voltar</a>
                    </div>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome científico</th>
                            <th>Nome popular</th>
                            <th>Categoria</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($r = mysql_fetch_assoc($rs)): ?>
                        <tr class="odd gradeX">
                            <td width="200"><?=$r['Codigo']?></td>
                            <td width="200"><?=$r['NomeCientifico']?></td>
                            <td width="200"><?=$r['NomePopular']?></td>
                            <td width="200"><?=$r['nomeCategoria']?></td>
                            <td align="center">
                                <!-- <a class="btn mini blue" href="?s=precos-custo&id=<?=$r['CodProduto']?>"><i class="icomoon-icon-coins "></i> Preços de custo</a> -->
                                <a class="btn mini blue" href="?s=produtos-edit&id=<?=$r['CodProduto']?>"><i class="icon-pencil"></i> Editar</a>
                                <a href="action/produtos.php?do=ativa&id=<?=$r['CodProduto']?>" id="<?=$r['CodProduto']?>" class="btn btn-info"> <i class="icon-ok"></i> Ativar</a>
							</td>
                        </tr>
                        <?php endwhile; ?>                       
                    </tbody>
                </table>
            </div>

        </div><!-- End .box -->

    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->