<?php
$rs = mysql_query("SELECT * FROM configuracoes");
$r = mysql_fetch_assoc($rs);
?>
<!-- Build page from here: -->                   
<div class="row-fluid">

    <div class="span12">

        <div class="box">
            <?php showErros(); ?>

            <div class="title">
                <h4>
                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                    <span>Formulário de contato, redes sociais</span>
                </h4>
            </div>

            <div class="content">

                <form class="form-horizontal" action="action/configuracoes.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="do" value="altera" />
                    <input type="hidden" name="id" value="1" />

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span4" for="email">E-mail</label>
                                <input class="span8" id="email" type="text" name="email" value="<?=$r['email']?>" />
                                <span class="help-block blue span8">Para adicionar mais de e-mail, acrescente a virgula após o email. Ex: contato@anchietasenador.com.br,atendimento@anchietasenador.com.br</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span4" for="facebook">Facebook</label>
                                <input class="span8" id="facebook" type="text" name="facebook" value="<?=$r['facebook']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span4" for="twitter">Twitter</label>
                                <input class="span8" id="twitter" type="text" name="twitter" value="<?=$r['twitter']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span4" for="flickr">Flickr</label>
                                <input class="span8" id="flickr" type="text" name="flickr" value="<?=$r['flickr']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span4" for="youtube">Youtube</label>
                                <input class="span8" id="youtube" type="text" name="youtube" value="<?=$r['youtube']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                       <button type="submit" class="btn btn-info">Salvar</button>
                       <button type="button" class="btn" onclick="location.href='./'">Cancelar</button>
                    </div>

                </form>

            </div>

        </div><!-- End .box -->
    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->