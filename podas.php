<?php
$rs = mysql_query("SELECT * FROM tipospodas ORDER BY CodTipoPoda DESC");
?>
<div class="row-fluid">

    <div class="span12">

        <div class="box gradient">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span>Tipos de podas</span>
                </h4>
            </div>
            <div class="content noPad clearfix">
                <div class="clearfix">
                    <div class="btn-group" style="margin:20px;">
                        <a class="btn blue" href="?s=podas-add" title="Adicionar"><i class="icon-plus"></i> Adicionar</a>
                    </div>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($r = mysql_fetch_assoc($rs)): ?>
                        <tr class="odd gradeX">
                            <td width="500"><?=$r['Descricao']?></td>
                            <td align="center">
                                <a class="btn mini blue" href="?s=podas-edit&id=<?=$r['CodTipoPoda']?>"><i class="icon-pencil"></i> Editar</a>
                                
                                <a href="action/podas.php?do=exclui&id=<?=$r['CodTipoPoda']?>" role="buttton" class="del btn btn-danger"> <i class="icon-trash"></i> Excluir</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>                       
                    </tbody>
                </table>
            </div>

        </div><!-- End .box -->

    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->