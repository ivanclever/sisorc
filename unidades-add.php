<!-- Build page from here: -->
                   
<div class="row-fluid">

    <div class="span12">

        <div class="box">
            <?php showErros(); ?>

            <div class="title">

                <h4>
                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                    <span>Unidades de medida</span>
                </h4>

            </div>
            <div class="content">

                <form class="form-horizontal" action="action/unidades.php" method="post">
                    <input type="hidden" name="do" value="cadastra" />

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="sigla">Sigla</label>
                                <input class="span4" id="sigla" type="text" name="sigla" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="descricao">Descrição</label>
                                <input class="span4" id="descricao" type="text" name="descricao" />
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                       <button type="submit" class="btn btn-info">Salvar</button>
                       <button type="button" class="btn" onclick="location.href='?s=unidades'">Cancelar</button>
                    </div>
                                                            

                </form>
             
            </div>

        </div><!-- End .box -->
    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->