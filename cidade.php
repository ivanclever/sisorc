<?php
$rs = mysql_query("SELECT c.CodCidade, c.Nome, e.Nome as Estado FROM cidades c
INNER JOIN estados e ON c.CodEstado = e.CodEstado
ORDER BY c.Nome");
?>
<div class="row-fluid">

    <div class="span12">

        <div class="box gradient">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span>Cidades</span>
                </h4>
            </div>
            <div class="content noPad clearfix">
                <div class="clearfix">
                    <div class="btn-group" style="margin:10px;">
                        <a class="btn blue" href="?s=cidade-add" title="Adicionar"><i class="icon-plus"></i> Adicionar</a>
                    </div>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>Cidade</th>
                            <th>UF</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($r = mysql_fetch_assoc($rs)): ?>
                        <tr class="odd gradeX">
                            <td width="250"><?=$r['Nome']?></td>
                            <td width="250"><?=$r['Estado']?></td>
                            <td align="center">
                                <a class="btn mini blue" href="?s=cidade-edit&id=<?=$r['CodCidade']?>"><i class="icon-pencil"></i> Editar</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>                       
                    </tbody>
                </table>
            </div>

        </div><!-- End .box -->

    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->