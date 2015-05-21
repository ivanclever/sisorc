<?php
$id = (int)$_GET['id'];

$rs = mysql_query("SELECT * FROM precos WHERE CodPreco = '$id'");
$r = mysql_fetch_assoc($rs);

$rs_produtos = mysql_query("SELECT NomePopular FROM produtos WHERE CodProduto = '$id'");
$r_produto = mysql_fetch_assoc($rs_produtos);

$rs_cores = mysql_query("SELECT * FROM cores");

$rs_podas = mysql_query("SELECT * FROM tipospodas");

$rs_medidas = mysql_query("SELECT * FROM unidadesmedida ");

$rs_fornecedores = mysql_query("SELECT Nome FROM fornecedores WHERE CodFornecedor = '$r[CodFornecedor]'");
$r_fornecedores = mysql_fetch_assoc($rs_fornecedores);

$categorias = mysql_query("SELECT * FROM categoriasprodutos");

?>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.1.custom.min.js"></script>
<script type="text/javascript">
$(function(){
    $('#fornecedor').combogrid({
        url: 'ajax-fornecedores.php',
        debug:true,
        colModel: [{'columnName':'Nome','width':'60','label':'Nome'},{'columnName':'RazaoSocial','width':'30','label':'Razão Social'},{'columnName':'Produto','width':'10','label':'Produto'}, ],
        select: function( event, ui ) {
            $('#fornecedor').val( ui.item.Nome );
            $('#id_fornecedor').val( ui.item.CodFornecedor );
            return false;
        }
    });
});
</script>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                    <span>Editar</span>
                </h4>
            </div>
            <div class="content">
                <form class="form-horizontal" action="action/precos.php" method="post">
                    <input type="hidden" name="do" value="altera" />
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="id_fornecedor" id="id_fornecedor" value="<?=$r['CodFornecedor']?>" />
                    <input type="hidden" name="produto" value="<?=$r['CodProduto']?>" />

                    <div class="form-row row-fluid">
                        <div class="span7">
                            <div class="row-fluid">
                                <label class="form-label span4" for="cor">Cores</label>
                                <div class="span4">
                                    <select name="cor" id="cor" class="span4">
                                        <option vaue="">Selecione</option>
                                        <?php while ($r_cores = mysql_fetch_assoc($rs_cores)): ?>
                                            <option <? if ($r['CodCor'] == $r_cores['CodCor']) echo 'selected="selected"'; ?> value="<?=$r_cores['CodCor']?>"><?=$r_cores['Nome']?></option>
                                        <? endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span7">
                            <div class="row-fluid">
                                <label class="form-label span4" for="poda">Tipo de Poda</label>
                                <div class="span4">
                                    <select name="poda" id="poda" class="span4">
                                        <option vaue="">Selecione</option>
                                        <?php while ($r_podas = mysql_fetch_assoc($rs_podas)): ?>
                                            <option <? if ($r['CodTipoPoda'] == $r_podas['CodTipoPoda']) echo 'selected="selected"'; ?> value="<?=$r_podas['CodTipoPoda']?>"><?=$r_podas['Descricao']?></option>
                                        <? endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span7">
                            <div class="row-fluid">
                                <label class="form-label span4" for="medida">Unidade Medida</label>
                                <div class="span4">
                                    <select name="medida" id="medida" class="span4">
                                        <option vaue="">Selecione</option>
                                        <?php while ($r_medidas = mysql_fetch_assoc($rs_medidas)): ?>
                                            <option <? if ($r['CodUnidadeMedida'] == $r_medidas['CodUnidadeMedida']) echo 'selected="selected"'; ?> value="<?=$r_medidas['CodUnidadeMedida']?>"><?=$r_medidas['Descricao']?></option>
                                        <? endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="fornecedor">Fornecedor</label>
                                <input class="span8" id="fornecedor" type="text" name="fornecedor" value="<?=$r_fornecedores['Nome']?>" />
                                <div id="switcher" style="float:right"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="porte">Porte</label>
                                <input class="span8" id="porte" type="text" name="porte" value="<?=$r['Porte']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="copa">Diametro Copa:</label>
                                <input class="span8" type="text" id="copa" name="copa" value="<?=$r['DiametroCopa']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="tronco">Diametro Tronco:</label>
                                <input class="span8" type="text" id="tronco" name="tronco" value="<?=$r['DiametroTronco']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="altura_tronco">Altura Tronco:</label>
                                <input class="span8" type="text" id="altura_tronco" name="altura_tronco" value="<?=$r['AlturaTronco']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="valor">Valor:</label>
                                <input class="span8" type="text" id="valor" name="valor" value="<?=$r['Valor']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="unidades">Unidades:</label>
                                <input class="span8" type="text" id="unidades" name="unidades" value="<?=$r['UnidadesPorCaixa']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span7">
                            <div class="row-fluid">
                                <label class="form-label span4" for="ranking">Ranking</label>
                                <div class="span4">
                                    <select name="ranking" id="ranking" class="span4">
                                        <option <? if ($r['Ranking'] == 'A') echo 'selected="selected"'; ?> value="A">A</option>
                                        <option <? if ($r['Ranking'] == 'B') echo 'selected="selected"'; ?> value="B">B</option>
                                        <option <? if ($r['Ranking'] == 'C') echo 'selected="selected"'; ?> value="C">C</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                       <button type="submit" class="btn btn-info">Salvar</button>
                       <button type="button" class="btn" onclick="location.href='?s=precos-custo&id=<?=$r['CodProduto']?>'">Cancelar</button>
                    </div>
                </form>
            </div>
        </div><!-- End .box -->
    </div><!-- End .span12 -->
</div><!-- End .row-fluid -->