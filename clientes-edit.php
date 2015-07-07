<?php
$id = (int)$_GET['id'];

$rs = mysql_query("SELECT f.*, e.CodEstado, c.Nome as Cidade
FROM clientes f
LEFT OUTER JOIN cidades c ON c.CodCidade = f.CodCidade
LEFT OUTER JOIN estados e ON c.CodEstado = e.CodEstado
WHERE CodCliente = '$id'");
$r = mysql_fetch_assoc($rs);

echo soNum($r['FAX']);
?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
    

    <? if ($r['Pessoa'] == 0) { ?>
        $('div.cnpj').hide();
        $('div.cpf').show();
    <? } else { ?>
        $('div.cpf').hide();
        $('div.cnpj').show();
    <? } ?>

    $('#tipoPessoa').change(function(){
        var vl = $(this).val();
        if(vl==0) {
            $('div.cnpj').hide();
            $('div.cpf').show();
        } else {
            $('div.cpf').hide();
            $('div.cnpj').show();
        }
    });

});
</script>

<script type="text/javascript">
		$(function(){
			$('#cod_estados').change(function(){
				if( $(this).val() ) {
					$('#cod_cidades').hide();
					$('.carregando').show();
					$.getJSON('cidades.ajax.php?search=',{cod_estados: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cod_cidades + '">' + j[i].nome + '</option>';
						}	
						$('#cod_cidades').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#cod_cidades').html('<option value="">– Escolha um estado –</option>');
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
                    <span>Editar</span>
                </h4>
            </div>
            <div class="content">
                <form class="form-horizontal" action="action/clientes.php" method="post">
                    <input type="hidden" name="do" value="altera" />
                    <input type="hidden" name="id" value="<?=$id?>" />

                    <div class="form-row row-fluid">
                        <div class="span7">
                            <div class="row-fluid">
                                <label class="form-label span4" for="status">Ativo ?</label>
                                <div class="span4">
                                    <select name="status" id="status" class="span4">
                                        <option <? if ($r['status'] == '1') echo 'selected="selected"'; ?> value="1">Sim</option>
                                        <option <? if ($r['status'] == '0') echo 'selected="selected"'; ?> value="0">Não</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span7">
                            <div class="row-fluid">
                                <label class="form-label span4" for="tipo">Tipo Pessoa</label>
                                <div class="span4">
                                    <select name="tipo" id="tipoPessoa" class="span4">
                                        <option <? if ($r['Pessoa'] == '0') echo 'selected="selected"'; ?> value="0">Física</option>
                                        <option <? if ($r['Pessoa'] == '1') echo 'selected="selected"'; ?> value="1">Jurídica</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="nome">Nome</label>
                                <input class="span8" id="nome" type="text" name="nome" value="<?=stripslashes($r['Nome'])?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid cpf">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="cpf">CPF:</label>
                                <input class="span8 cpf" type="text" id="cpf" name="cpf" value="<?=soNum($r['CPF_CNPJ'])?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid cnpj">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="documento">CNPJ:</label>
                                <input class="span8 cnpj" type="text" id="cnpj" name="cnpj" value="<?=soNum($r['CPF_CNPJ'])?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="data">Dada Nasc:</label>
                                <input class="span8 data" id="data" type="text" name="data" value="<?=dateTimeToBr($r['DataNascimento'])?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="data">E-mail:</label>
                                <input class="span8" id="email" type="text" name="email" value="<?=$r['Email']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="contatos">Contatos:</label>
                                <input class="span8" id="contatos" type="text" name="contatos" value="<?=$r['Contato']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="fax">FAX:</label>
                                <input class="span8" id="fax" type="text" name="fax" value="<?=soNum($r['FAX'])?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="residencial">Residencial:</label>
                                <input class="span8" id="residencial" type="text" name="residencial" value="<?=soNum($r['TelefoneResidencial'])?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="comercial">Comercial:</label>
                                <input class="span8" id="comercial" type="text" name="comercial" value="<?=soNum($r['TelefoneComercial'])?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="celular">Celular:</label>
                                <input class="span8" id="celular" type="text" name="celular" value="<?=soNum($r['TelefoneCelular'])?>" />
                            </div>
                        </div>
                    </div>                    

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                            <h3 class="span4" style="margin:15px 0 0 50px;">Endereço</h3>
                        </div>
                    </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="cep">CEP:</label>
                                <input class="span2 cep" id="cep" type="text" name="cep" value="<?=$r['CEP']?>" />
                                <!--<a href="#" class="btn" onclick="return getEndereco()">Consultar</a>-->
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="logradouro">Logradouro:</label>
                                <input class="span8" id="logradouro" type="text" name="logradouro" value="<?=$r['Endereco']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span3">
                            <label class="form-label span6" for="numero">Número:</label>
                            <input class="span4" id="numero" type="text" name="numero" value="<?=$r['Numero']?>" />
                        </div>
                        <div class="span6">
                            <label class="form-label span4" for="complemento">Complemento:</label>
                            <input class="span6" id="complemento" type="text" name="complemento" value="<?=$r['Complemento']?>" />
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span4" for="bairro">Bairro:</label>
                                <input class="span8" id="bairro" type="text" name="bairro" value="<?=$r['Bairro']?>" />
                            </div>
                        </div>
                    </div>
                    
                  <div class="form-row row-fluid">
						<div class="span3">
							<div class="row-fluid">
                            <?php $cq = mysql_query("SELECT NULL CodEstado, ' -Selecione-' UF UNION SELECT CodEstado, UF FROM estados ORDER BY UF"); ?>
                               <label class="form-label span4" for="nmestado">Estado:</label>
                                <select name="cod_estados" id="cod_estados" class="span4">
                                 <?php while ($rc = mysql_fetch_assoc($cq)): ?>
                                	<option <?php if ($r['CodEstado'] == $rc['CodEstado']) {echo 'selected="selected"';} ?> value="<?php echo $rc['CodEstado'];?>"><?php echo $rc['UF'];?></option>
                           	    <?php endwhile ?>
                                </select>
                              </div>
                              </div>
                              </div>
                      
                      <div class="form-row row-fluid">
						<div class="span3">
							<div class="row-fluid">
								<label class="form-label span4" for="cidade">Cidade:</label>
                                <select class="span6" name="cod_cidades" id="cod_cidades">
                                	<option value="NULL">-- Escolha uma cidade --</option>
                                	<option value="<?php echo $r['CodCidade'];?>"><?php echo $r['Cidade'];?></option>
                                </select>
                           
							</div>
						</div>
					</div>
                    

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="page-header">
                                <h4>Observações</h4>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <div class="tabbable tabs-left">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#texto" data-toggle="tab">Observações</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="texto">
                                            <div class="form-row row-fluid">
                                                <div class="span12">
                                                    <div class="row-fluid">
                                                       <div class="form-row">
                                                            <textarea name="observacoes" style="width:90%; height:100px;"><?=$r['Observacoes']?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End .span6 -->
                    </div><!-- End .row-fluid -->

                    <div class="form-actions">
                       <button type="submit" class="btn btn-info">Salvar</button>
                       <button type="button" class="btn" onclick="location.href='?s=clientes'">Cancelar</button>
                    </div>
                </form>
        </div><!-- End .box -->
    </div><!-- End .span12 -->
</div><!-- End .row-fluid -->