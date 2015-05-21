<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
    $('#cliente').combogrid({
        url: 'ajax-clientes.php',
        debug:true,
        colModel: [{'columnName':'Nome','width':'60','label':'Nome'},{'columnName':'Contato','width':'30','label':'Contato'}],
        select: function( event, ui ) {
            $('#cliente').val( ui.item.Nome );
            $('#id_cliente').val( ui.item.CodCliente );
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
                    <span>Adicionar Orçamento</span>
                </h4>
            </div>
            <div class="content">
                <form class="form-horizontal" action="action/orcamentos.php" method="post">
                    <input type="hidden" name="do" value="cadastra" />

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="job">JOB</label>
                                <input class="span4" id="job" type="text" name="job" value="<?=$_SESSION['clientes']['job']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="obra">Obra/Serviço</label>
                                <input class="span4" id="obra" type="text" name="obra" value="<?=$_SESSION['clientes']['obra']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="cliente">Cliente</label>
                                <input class="span4" id="cliente" type="text" name="cliente" value="<?=$_SESSION['clientes']['cliente']?>" />
                                <input id="id_cliente" type="hidden" name="id_cliente" value="<?=$_SESSION['orcamentos']['id_cliente']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-info">Salvar</button>
                        <button type="button" class="btn" onclick="location.href='?s=orcamentos'">Cancelar</button>
                    </div>
                </form>
            </div>
        </div><!-- End .box -->
    </div><!-- End .span12 -->
</div><!-- End .row-fluid -->