<?php
$id = (int)$_GET['id'];

$rs = mysql_query("SELECT vasos.*, fornecedores.Nome nomeFornecedor FROM vasos, fornecedores WHERE vasos.CodFornecedor = fornecedores.CodFornecedor AND CodVaso = '$id'");
$r = mysql_fetch_assoc($rs);

$revestimentos = mysql_query("SELECT * FROM revestimentos");

?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
    $('#fornecedor').combogrid({
        url: 'ajax-fornecedores.php',
        debug:true,
        colModel: [{'columnName':'Nome','width':'60','label':'Nome'},{'columnName':'RazaoSocial','width':'30','label':'Razão Social'},{'columnName':'Produto','width':'10','label':'Produto'},],
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
                <form class="form-horizontal" action="action/vasos.php" method="post">
                    <input type="hidden" name="do" value="altera" />
                    <input type="hidden" name="id" value="<?=$id?>" />

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="revestimento">Revestimento</label>
                                <div class="span2">
                                    <select name="revestimento" id="revestimento" class="span4">
                                        <?php while ($r_revestimentos = mysql_fetch_assoc($revestimentos)): ?>
                                            <option <? if ($r['CodRevestimento'] == $r_revestimentos['CodRevestimento']) echo 'selected="selected"'; ?> value="<?=$r_revestimentos['CodRevestimento']?>"><?=$r_revestimentos['Descricao']?></option>
                                        <? endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="bandeja">Bandeja</label>
                                <div class="span2">
                                    <select name="bandeja" id="bandeja" class="span4">
                                        <option <? if ($r['Bandeja'] == '0') echo 'selected="selected"'; ?> value="0">Não</option>
                                        <option <? if ($r['Bandeja'] == '1') echo 'selected="selected"'; ?> value="1">Sim</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="fornecedor">Fornecedor</label>
                                <input class="span8" id="fornecedor" type="text" name="fornecedor" value="<?=$r['nomeFornecedor']?>" />
                                <input id="id_fornecedor" type="hidden" name="id_fornecedor" value="<?=$r['CodFornecedor']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="cod_fornecedor">Cod. Fornecedor</label>
                                <input class="span8" id="cod_fornecedor" type="text" name="cod_fornecedor" value="<?=$r['CodigoFornecedor']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="modelo">Modelo</label>
                                <input class="span8" id="modelo" type="text" name="modelo" value="<?=$r['Modelo']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="dimensoes">Dimensões:</label>
                                <input class="span8" type="text" id="dimensoes" name="dimensoes" value="<?=$r['Dimensoes']?>" />
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
                                <label class="form-label span2" for="data">Data Cadastro:</label>
                                <input class="span8 data" type="text" id="data" name="data" value="<?=DateToBr($r['DataCadastra'])?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="status">Ativo ?</label>
                                <div class="span2">
                                    <select name="status" id="status" class="span4">
                                        <option <? if ($r['status'] == '0') echo 'selected="selected"'; ?> value="0">Não</option>
                                        <option <? if ($r['status'] == '1') echo 'selected="selected"'; ?> value="1">Sim</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                       <button type="submit" class="btn btn-info">Salvar</button>
                       <button type="button" class="btn" onclick="location.href='?s=vasos'">Cancelar</button>
                    </div>
                </form>
            </div>
        </div><!-- End .box -->
    </div><!-- End .span12 -->
</div><!-- End .row-fluid -->