﻿<script type="text/javascript" src="js/jquery.min.js"></script>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                    <span>Adicionar Estado</span>
                </h4>
            </div>
            <div class="content">
                <form class="form-horizontal" action="action/estado.php" method="post">
                    <input type="hidden" name="do" value="cadastra" />
					<div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="nome">Nome</label>
                                <input class="span8" id="nome" type="text" name="nome" value="<?=$_SESSION['estado']['nome']?>" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row row-fluid">
                        <div class="span7">
                            <div class="row-fluid">
                                <label class="form-label span4">UF</label>
                                <div class="span4">
                                 <input class="span8" id="uf" type="text" name="uf" value="<?=$_SESSION['estado']['uf']?>" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                       <button type="submit" class="btn btn-info">Salvar</button>
                       <button type="button" class="btn" onclick="location.href='?s=estado'">Cancelar</button>
                    </div>
                </form>
            </div>
        </div><!-- End .box -->
    </div><!-- End .span12 -->
</div><!-- End .row-fluid -->