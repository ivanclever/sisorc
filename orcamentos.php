<?php $rs = mysql_query("SELECT 
    orcamentos.*, DATE_FORMAT(orcamentos.DataCadastra,'%Y/%m/%d') as dataCad, clientes.Nome nomeCliente
    FROM orcamentos, clientes
    WHERE orcamentos.CodCliente = clientes.CodCliente AND  
	orcamentos.Status='1' 
    ORDER BY orcamentos.DataCadastra DESC"); ?>
<div class="row-fluid">

    <div class="span12">

        <div class="box gradient">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span>Orçamentos</span>
                </h4>
            </div>
            <div class="content noPad clearfix">
                <div class="clearfix">
                    <div class="btn-group" style="float:left; margin:10px;">
                        <a class="btn blue" href="?s=orcamentos-add" title="Adicionar"><i class="icon-plus"></i> Adicionar orçamento</a>
                    </div>
					<div class="btn-group" style="margin:10px;">
                        <a class="btn blue" href="?s=orcamentos-inativos" title="Inativos"> Visualizar Inativos</a>
                    </div>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="responsive orcamentos display table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>JOB</th>
                            <th>Obra</th>
                            <th>Cliente</th>
                            <th>Data Cadastro</th>
							<th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($r = mysql_fetch_assoc($rs)): ?>
                        <tr class="odd gradeX">
                            <td width="150"><?=$r['JOB']?></td>
                            <td width="250"><?=$r['Obra']?></td>
                            <td width="300"><?=$r['nomeCliente']?></td>
                            <td width="100"><?=$r['dataCad']?></td>
							<td align="center" width="250">
                                <a class="btn mini blue" href="?s=orcamentos-produtos&id=<?=$r['CodOrcamento']?>"><i class="icon-pencil"></i> Editar</a>
                                <a href="action/orcamentos.php?do=exclui&id=<?=$r['CodOrcamento']?>" role="buttton" class="del btn btn-danger"> <i class="icon-trash"></i> Desativar</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>                       
                    </tbody>
                </table>
            </div>

        </div><!-- End .box -->

    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->