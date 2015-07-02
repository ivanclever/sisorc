<?php
$Cons_Est = "SELECT CodEstado, UF FROM estados";
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                    <span>Adicionar Cidade</span>
                </h4>
            </div>
            <div class="content">
                <form class="form-horizontal" action="action/cidade.php" method="post">
                    <input type="hidden" name="do" value="cadastra" />
					<div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="nome">Nome</label>
                                <input class="span8" id="nome" type="text" name="nome" value="<?= $_SESSION['cidade']['nome']?>" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row row-fluid">
                        <div class="span7">
                            <div class="row-fluid">
                                <label class="form-label span4">UF</label>
                                <div class="span4">
                                    <select name="uf" id="uf" class="span4">
                                    <?php  $exe= mysql_query($Cons_Est);
									while($Exe_Cons = mysql_fetch_assoc($exe)): ?>
                                        <option value="<?= $Exe_Cons['CodEstado'] ?>"><?= $Exe_Cons['UF'] ?></option>
                                      <?php endwhile ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        </div>

                    <div class="form-actions">
                       <button type="submit" class="btn btn-info">Salvar</button>
                       <button type="button" class="btn" onclick="location.href='?s=cidade'">Cancelar</button>
                    </div>
                </form>
            </div>
        </div><!-- End .box -->
    </div><!-- End .span12 -->
</div><!-- End .row-fluid -->