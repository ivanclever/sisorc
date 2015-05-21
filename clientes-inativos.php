<?php
$rs = mysql_query("SELECT * FROM clientes WHERE status = '0' ORDER BY DataCadastra ASC");
?>
<div class="row-fluid">

    <div class="span12">

        <div class="box gradient">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span>Clientes</span>
                </h4>
            </div>
            <div class="content noPad clearfix">
                <div class="clearfix">
                    <div class="btn-group" style="margin:10px;">
                        <a class="btn blue" href="?s=clientes" title="Voltar para Ativos"><i class="entypo-icon-back"></i> Voltar</a>
                    </div>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Residencial</th>
                            <th>Comercial</th>
                            <th>Celular</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($r = mysql_fetch_assoc($rs)): ?>
                        <tr class="odd gradeX">
                            <td width="250"><?=$r['Nome']?></td>
                            <td width="250"><?=$r['Email']?></td>
                            <td width="100"><? if($r['TelefoneResidencial'] != '') echo $r['TelefoneResidencial']; else echo '-'; ?></td>
                            <td width="100"><? if($r['TelefoneComercial'] != '') echo $r['TelefoneComercial']; else echo '-'; ?></td>
                            <td width="100"><? if($r['TelefoneCelular'] != '') echo $r['TelefoneCelular']; else echo '-'; ?></td>
                            <td align="center">
                                <a href="action/clientes.php?do=ativa&id=<?=$r['CodCliente']?>" id="<?=$r['CodCliente']?>" class="btn btn-info"> <i class="icon-ok"></i> Ativar</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>                       
                    </tbody>
                </table>
            </div>

        </div><!-- End .box -->

    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->