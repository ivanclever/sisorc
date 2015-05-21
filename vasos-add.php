<?php
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
                    <span>Adicionar Vaso</span>
                </h4>
            </div>
            <div class="content">
                <form class="form-horizontal" action="action/vasos.php" method="post">
                    <input type="hidden" name="do" value="cadastra" />

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="revestimento">Revestimento</label>
                                <div class="span2">
                                    <select name="revestimento" id="revestimento" class="span4">
                                        <?php while ($r_revestimentos = mysql_fetch_assoc($revestimentos)): ?>
                                            <option <? if ($_SESSION['vasos']['revestimento'] == $r_revestimentos['CodRevestimento']) echo 'selected="selected"'; ?> value="<?=$r_revestimentos['CodRevestimento']?>"><?=$r_revestimentos['Descricao']?></option>
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
                                        <option <? if ($_SESSION['vasos']['bandeja'] == '0') echo 'selected="selected"'; ?> value="0">Não</option>
                                        <option <? if ($_SESSION['vasos']['bandeja'] == '1') echo 'selected="selected"'; ?> value="1">Sim</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="fornecedor">Fornecedor</label>
                                <input class="span8" id="fornecedor" type="text" name="fornecedor" value="<?=$_SESSION['vasos']['fornecedor']?>" />
                                <input id="id_fornecedor" type="hidden" name="id_fornecedor" value="<?=$_SESSION['vasos']['id_fornecedor']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="cod_fornecedor">Cód. Fornecedor</label>
                                <input class="span8" id="cod_fornecedor" type="text" name="cod_fornecedor" value="<?=$_SESSION['vasos']['cod_fornecedor']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="modelo">Modelo</label>
                                <input class="span8" id="modelo" type="text" name="modelo" value="<?=$_SESSION['vasos']['modelo']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="dimensoes">Dimensões:</label>
                                <input class="span8" type="text" id="dimensoes" name="dimensoes" value="<?=$_SESSION['vasos']['dimensoes']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="valor">Valor:</label>
                                <input class="span8" type="text" id="valor" name="valor" value="<?=$_SESSION['vasos']['valor']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="status">Ativo ?</label>
                                <div class="span2">
                                    <select name="status" id="status" class="span4">
                                        <option <? if ($_SESSION['vasos']['status'] == '0') echo 'selected="selected"'; ?> value="0">Não</option>
                                        <option <? if ($_SESSION['vasos']['status'] == '1') echo 'selected="selected"'; ?> value="1">Sim</option>
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