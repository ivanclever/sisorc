<?php
$rs = mysql_query("SELECT * FROM fornecedores WHERE status = '1' ORDER BY DataCadastra DESC");
?>
<div class="row-fluid">

    <div class="span12">

        <div class="box gradient">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span>Fornecedores</span>
                </h4>
            </div>
            <div class="content noPad clearfix">
                <div class="clearfix">
                    <div class="btn-group" style="margin:10px;">
                        <a class="btn blue" href="?s=fornecedores-add" title="Adicionar"><i class="icon-plus"></i> Adicionar</a>
                    </div>
                    <div class="btn-group" style="margin:10px;">
                        <a class="btn blue" href="?s=fornecedores-inativos" title="Inativos"> Visualizar Inativos</a>
                    </div>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Produtos</th>
                            <th>Telefone</th>
                            <th>Celular</th>
                            <th>E-mail</th>
                            <th>Ranking</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($r = mysql_fetch_assoc($rs)): ?>
                        <tr class="odd gradeX">
                            <td width="200"><?=$r['Nome']?></td>
                            <td width="200"><?=$r['Produto']?></td>
                            <td width="100"><?=$r['Telefone']?></td>
                            <td width="100"><?=$r['Celular']?></td>
                            <td width="200"><?=$r['Email']?></td>
                            <td width="100"><?=$r['Ranking']?></td>
                            <td align="center">
                                <? /*?><a class="btn mini blue" href="?s=produtos-fornecedores&id=<?=$r['CodFornecedor']?>"><i class="icon-pencil"></i> Produtos</a><? */?>
                                <a class="btn mini blue" href="?s=fornecedores-edit&id=<?=$r['CodFornecedor']?>"><i class="icon-pencil"></i> Editar</a>
                                <a href="action/fornecedores.php?do=exclui&id=<?=$r['CodFornecedor']?>" role="buttton" class="del btn btn-danger"> <i class="icon-trash"></i> Desativar</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>                       
                    </tbody>
                </table>
            </div>

        </div><!-- End .box -->

    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->