<?php
$rs = mysql_query("SELECT vasos.*, fornecedores.Nome nomeFornecedor FROM vasos, fornecedores 
        WHERE vasos.CodFornecedor = fornecedores.CodFornecedor
        AND vasos.status = '0'
        ORDER BY CodVaso DESC");
?>
<div class="row-fluid">

    <div class="span12">

        <div class="box gradient">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span>Vasos</span>
                </h4>
            </div>
            <div class="content noPad clearfix">
                <div class="clearfix">
                    <div class="btn-group" style="margin:10px;">
                        <a class="btn blue" href="?s=vasos" title="Voltar para Ativos"><i class="entypo-icon-back"></i> Voltar</a>
                    </div>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="responsive dynamicTable display table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>Fornecedor</th>
                            <th>Modelo</th>
                            <th>Dimensoes</th>
                            <th>Valor</th>
                            <th>Data Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($r = mysql_fetch_assoc($rs)): ?>
                        <tr class="odd gradeX">
                            <td width="200"><?=$r['nomeFornecedor']?></td>
                            <td width="200"><?=$r['Modelo']?></td>
                            <td width="200"><?=$r['Dimensoes']?></td>
                            <td width="200"><?=$r['Valor']?></td>
                            <td width="150"><?=DateToBr($r['DataCadastra'])?></td>
                            <td align="center">
                                <!--<a class="btn mini blue" href="?s=vasos-edit&id=<?=$r['CodVaso']?>"><i class="icon-pencil"></i> Editar</a>-->
                                <a href="action/vasos.php?do=ativa&id=<?=$r['CodVaso']?>" id="<?=$r['CodVaso']?>" class="btn btn-info"> <i class="icon-ok"></i> Ativar</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>                       
                    </tbody>
                </table>
            </div>

        </div><!-- End .box -->

    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->