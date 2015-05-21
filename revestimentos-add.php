<!-- Build page from here: -->
                   
<div class="row-fluid">

    <div class="span12">

        <div class="box">
            <?php showErros(); ?>

            <div class="title">

                <h4>
                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                    <span>Revestimentos</span>
                </h4>

            </div>
            <div class="content">

                <form class="form-horizontal" action="action/revestimentos.php" method="post">
                    <input type="hidden" name="do" value="cadastra" />

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="normal">Descrição</label>
                                <input class="span4" id="normalInput" type="text" name="nome" />
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                       <button type="submit" class="btn btn-info">Salvar</button>
                       <button type="button" class="btn" onclick="location.href='?s=revestimentos'">Cancelar</button>
                    </div>
                                                            

                </form>
             
            </div>

        </div><!-- End .box -->
    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->