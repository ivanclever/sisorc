<?php
$id = (int)$_GET['id'];
$id_orcamento = (int)$_GET['id_orcamento'];

$rs = mysql_query("SELECT * FROM orcvasos WHERE CodOrcVaso = '$id'");
$r = mysql_fetch_assoc($rs);

$cores = mysql_query("SELECT * FROM cores");
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                    <span>Editar Vasos</span>
                </h4>
            </div>
            <div class="content">
                <form class="form-horizontal" action="action/orcamentos.php" method="post">
                    <input type="hidden" name="do" value="AlteraVasos" />
                    <input type="hidden" name="id_orcamento" id="id_orcamento" value="<?=$id_orcamento?>" />
                    <input type="hidden" name="id" value="<?=$id?>" />

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="cor">Cor</label>
                                <div class="span2">
                                    <select name="cor" id="cor" class="span4">
                                        <?php while ($r_cores = mysql_fetch_assoc($cores)): ?>
                                            <option <? if ($r['CodCor'] == $r_cores['CodCor']) echo 'selected="selected"'; ?> value="<?=$r_cores['CodCor']?>"><?=$r_cores['Nome']?></option>
                                        <? endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="codigo">Código</label>
                                <input class="span8" id="codigo" type="text" name="codigo" value="<?=$r['Codigo']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="quantidade">QTDE</label>
                                <input class="span8" id="quantidade" type="text" name="quantidade" value="<?=$r['Quantidade']?>" />
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
                                <label class="form-label span2" for="conteudo">Conteúdo</label>
                                <input class="span8" type="text" id="conteudo" name="conteudo" value="<?=$r['Conteudo']?>" />
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
                       <button type="button" class="btn" onclick="location.href='?s=orcamentos-produtos&id=<?=$id_orcamento?>#vasos'">Cancelar</button>
                    </div>
                </form>
            </div>
        </div><!-- End .box -->
    </div><!-- End .span12 -->
</div><!-- End .row-fluid -->