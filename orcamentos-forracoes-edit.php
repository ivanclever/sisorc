<?php
$id = (int)$_GET['id'];
$id_orcamento = (int)$_GET['id_orcamento'];

$rs = mysql_query("SELECT * FROM orcforracoes WHERE CodOrcForracao = '$id'");
$r = mysql_fetch_assoc($rs);

?>

<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                    <span>Editar Forrações</span>
                </h4>
            </div>
            <div class="content">
                <form class="form-horizontal" action="action/orcamentos.php" method="post">
                    <input type="hidden" name="do" value="AlteraForracoes" />
                    <input type="hidden" name="id_orcamento" id="id_orcamento" value="<?=$id_orcamento?>" />
                    <input type="hidden" name="id" value="<?=$id?>" />

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="quantidade">QTDE m²</label>
                                <input class="span8" id="quantidade" type="text" name="quantidade" value="<?=$r['Quantidade']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="distancia">Dist. plantio</label>
                                <input class="span8" id="distancia" type="text" name="distancia" value="<?=$r['DistanciaPlantio']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="valor">Valor</label>
                                <input class="span8" type="text" id="valor" name="valor" value="<?=$r['Valor']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="observacoes">Observações</label>
                                <input class="span8" type="text" id="observacoes" name="observacoes" value="<?=$r['Observacoes']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="lucro">Lucro</label>
                                <input class="span8" type="text" id="lucro" name="lucro" value="<?=$r['Lucro']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                       <button type="submit" class="btn btn-info">Salvar</button>
                       <button type="button" class="btn" onclick="location.href='?s=orcamentos-produtos&id=<?=$id_orcamento?>#forracoes'">Cancelar</button>
                    </div>
                </form>
            </div>
        </div><!-- End .box -->
    </div><!-- End .span12 -->
</div><!-- End .row-fluid -->