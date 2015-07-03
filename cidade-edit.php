<?php
$id = (int)$_GET['id'];
?>

<script type="text/javascript" src="js/jquery.min.js"></script>
<?php 
	$Cons_Cid = mysql_query("SELECT CodEstado, Nome FROM cidades WHERE CodCidade = '$id'");
	$Exe_Cid = mysql_fetch_assoc($Cons_Cid);
	
	//print_r($Exe_Cid);
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                    <span>Editar Cidade - <?php echo $Exe_Cid['Nome'];?></span>
                </h4>
            </div>
            <div class="content">
                <form class="form-horizontal" action="action/cidade.php" method="post">
                    <input type="hidden" name="do" value="altera" />
					<input type="hidden" name="id" value="<?php echo $id;?>" />
					<div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="nome">Nome</label>
                                <input class="span8" id="nome" type="text" name="nome" value="<?= $Exe_Cid["Nome"] ?>" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row row-fluid">
                        <div class="span7">
                            <div class="row-fluid">
                                <label class="form-label span4">UF</label>
                                <div class="span4">
                                    <select name="uf" id="uf" class="span4">
                                    <?php $Cons_Est = mysql_query("SELECT CodEstado, UF FROM estados");
										  
										  while($Exe_Cons = mysql_fetch_assoc($Cons_Est))
										  {
									 ?>
                                        <option <? if ($Exe_Cons['CodEstado'] == $Exe_Cid["CodEstado"]) echo 'selected="selected"'; ?> value="<?php echo $Exe_Cons["CodEstado"];?>"><?php echo $Exe_Cons["UF"];?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                       <button type="submit" class="btn btn-info">Salvar</button>
                       <button type="button" class="btn" onclick="location.href='?s=clientes'">Cancelar</button>
                    </div>
                </form>
            </div>
        </div><!-- End .box -->
    </div><!-- End .span12 -->
</div><!-- End .row-fluid -->