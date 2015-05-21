<?php
$id = (int)$_GET['id'];
$rs = mysql_query("SELECT fornecedores.Nome nomeFornecedor, produtos.NomePopular nomeProduto, produtos.Ambiente, produtos.Codigo
            FROM precos, produtos, fornecedores
            WHERE precos.CodFornecedor = fornecedores.CodFornecedor
            AND precos.CodProduto = produtos.CodProduto
            AND fornecedores.CodFornecedor = '$id'");

$rs_fornecedor = mysql_query("SELECT Nome FROM fornecedores WHERE CodFornecedor = '$id'");
$rs_fornecedor = mysql_fetch_assoc($rs_fornecedor);
?>
<div class="row-fluid">

    <div class="span12">

        <div class="box gradient">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span>Produtos relacionados ao fornecedor: <strong style="text-transform: uppercase;"><?=$r_fornecedor['Nome']?></strong></span>
                </h4>
            </div>
            <div class="content noPad clearfix">
                <div class="clearfix">
                    <div class="btn-group" style="float:left; margin:10px;">
                        <a class="btn blue" href="?s=precos-custo-add&id=<?=$id?>" title="Adicionar"><i class="icon-plus"></i> Adicionar</a>
                    </div>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Produto</th>
                            <th>Ambiente</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($r = mysql_fetch_assoc($rs)): ?>
                        <tr class="odd gradeX">
                            <td width="100"><?=$r['Codigo']?></td>
                            <td width="400"><?=$r['nomeProduto']?></td>
                            <td width="200"><? if($r['Ambiente'] == '0') echo 'Sombra'; else if($r['Ambiente'] == '1') echo 'Meia Sombra'; else echo 'Sol Pleno';  ?></td>
                            <td align="center">
                                <a class="btn mini blue" href="?s=precos-custo-edit&id=<?=$r['CodPreco']?>"><i class="icon-pencil"></i> Editar</a>
                                <a href="action/precos-custo.php?do=exclui&id=<?=$r['CodProduto']?>" role="buttton" class="del btn btn-danger"> <i class="icon-trash"></i> Excluir</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>                       
                    </tbody>
                </table>
            </div>

        </div><!-- End .box -->

    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->