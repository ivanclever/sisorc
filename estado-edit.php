<script type="text/javascript" src="js/jquery.min.js"></script>
<?php 
	$Cons_Cid = mysql_query("SELECT Nome, UF FROM estados WHERE CodEstado = '$id'");
	$Exe_Cid = mysql_fetch_assoc($Cons_Cid);
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                    <span>Alterar Estado</span>
                </h4>
            </div>
            <div class="content">
                <form class="form-horizontal" action="action/estado.php" method="post">
                    <input type="hidden" name="do" value="altera" />
					<div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="nome">Nome</label>
                                <input class="span8" id="nome" type="text" name="nome" value="<?=$Exe_Cid['Nome']?>" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row row-fluid">
                        <div class="span7">
                            <div class="row-fluid">
                                <label class="form-label span4">UF</label>
                                <div class="span4">
                                 <input class="span8" id="uf" type="text" name="uf" value="<?=$Exe_Cid['UF']?>" />
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