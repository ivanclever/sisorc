<?php
$rs = mysql_query("SELECT F.*, c.CidUf FROM clientes f
LEFT OUTER JOIN viCidades c ON f.CodCidade = c.CodCidade
WHERE status = '1' ORDER BY f.DataCadastra DESC");
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
                        <a class="btn blue" href="?s=clientes-add" title="Adicionar"><i class="icon-plus"></i> Adicionar</a>
                    </div>
                    <div class="btn-group" style="margin:10px;">
                        <a class="btn blue" href="?s=clientes-inativos" title="Inativos"> Visualizar Inativos</a>
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
                            <th>Contato</th>
                            <th>Cidade</th>
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
                            <td width="250"><?=$r['Contato']?></td>
                            <td width="250"><?=$r['CidUf']?></td>
                            <td align="center">
                                <a class="btn mini blue" href="?s=clientes-edit&id=<?=$r['CodCliente']?>"><i class="icon-pencil"></i> Editar</a>
                                <a href="action/clientes.php?do=exclui&id=<?=$r['CodCliente']?>" role="buttton" class="del btn btn-danger"> <i class="icon-trash"></i> Desativar</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>                       
                    </tbody>
                </table>
            </div>

        </div><!-- End .box -->

    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->