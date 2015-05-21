<?php
$rs = mysql_query("SELECT * FROM cores ORDER BY CodCor DESC");
?>
<div class="row-fluid">

    <div class="span12">

        <div class="box gradient">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span>Cores</span>
                </h4>
            </div>
            <div class="content noPad clearfix">
                <div class="clearfix">
                    <div class="btn-group" style="margin:20px;">
                        <a class="btn blue" href="?s=cores-add" title="Adicionar"><i class="icon-plus"></i> Adicionar</a>
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
                            <td width="500"><?=$r['Nome']?></td>
                            <td align="center">
                                <a class="btn mini blue" href="?s=cores-edit&id=<?=$r['CodCor']?>"><i class="icon-pencil"></i> Editar</a>
                                
                                <a href="action/cores.php?do=exclui&id=<?=$r['CodCor']?>" role="buttton" class="del btn btn-danger"> <i class="icon-trash"></i> Excluir</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>                       
                    </tbody>
                </table>
            </div>

        </div><!-- End .box -->

    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->