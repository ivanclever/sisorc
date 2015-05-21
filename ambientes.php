<?php
$rs = mysql_query("SELECT * FROM ambientes ORDER BY id DESC");
?>
<div class="row-fluid">

    <div class="span12">

        <div class="box gradient">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span>Ambientes</span>
                </h4>
            </div>
            <div class="content noPad clearfix">
                <div class="clearfix">
                    <div class="btn-group" style="float:left; margin:10px;">
                        <a class="btn blue" href="?s=ambientes-add" title="Adicionar"><i class="icon-plus"></i> Adicionar ambiente</a>
                    </div>
                    <div class="btn-group" style="float:left; margin:10px;">
                        <a class="btn btn-info" href="?s=produtos" title="Voltar"><i class="entypo-icon-back"></i> Votar para Produtos</a>
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
                            <td width="700"><?=$r['nome']?></td>
                            <td align="center">
                                <a class="btn mini blue" href="?s=ambientes-edit&id=<?=$r['id']?>"><i class="icon-pencil"></i> Editar</a>
                                <a href="action/ambientes.php?do=exclui&id=<?=$r['id']?>" role="buttton" class="del btn btn-danger"> <i class="icon-trash"></i> Excluir</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>                       
                    </tbody>
                </table>
            </div>

        </div><!-- End .box -->

    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->