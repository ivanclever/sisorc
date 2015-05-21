<?php
    $id = (int)$_GET['id'];

    $rs = mysql_query("SELECT * FROM cores WHERE CodCor = '$id'");
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
                    <span>Editar Cor</span>
                </h4>
                
            </div>
            <div class="content">
               
                <form class="form-horizontal" action="action/cores.php" method="post">
                    <input type="hidden" name="do" value="altera" />
                    <input type="hidden" name="id" value="<?=$id?>" />
                    
                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="normal">Nome</label>
                                <input class="span4" id="normalInput" type="text" name="nome" value="<?=$r['Nome']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                       <button type="submit" class="btn btn-info">Salvar</button>
                       <button type="button" class="btn" onclick="location.href='?s=cores'">Cancelar</button>
                    </div>

                </form>
             
            </div>

        </div><!-- End .box -->
    </div><!-- End .span12 -->

</div><!-- End .row-fluid -->