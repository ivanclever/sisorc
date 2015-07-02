<?php
$estados = array (
    "Acre"=>    "AC", 
    "Alagoas"=> "AL",
    "Amapá"=>   "AP", 
    "Amazonas"=>    "AM", 
    "Bahia"=>   "BA", 
    "Ceará"=>   "CE", 
    "Distrito Federal"=>    "DF", 
    "Espírito Santo"=>  "ES", 
    "Maranhão"=>    "MA", 
    "Mato Grosso"=> "MT", 
    "Mato Grosso do Sul"=>  "MS", 
    "Minas Gerais"=>    "MG", 
    "Pará"=>    "PA", 
    "Paraíba"=> "PB", 
    "Paraná"=>  "PR", 
    "Pernambuco"=>  "PE", 
    "Piauí"=>   "PI", 
    "Rio de Janeiro"=>  "RJ", 
    "Rio Grande do Norte"=> "RN", 
    "Rio Grande do Sul"=>   "RS", 
    "Rondônia"=>    "RO", 
    "Rorâima"=> "RR", 
    "São Paulo"=>   "SP", 
    "Santa Catarina"=>  "SC", 
    "Sergipe"=> "SE", 
    "Tocantins"=>   "TO");
?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
    $('div.cnpj').hide();
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
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                    <span>Adicionar Cliente</span>
                </h4>
            </div>
            <div class="content">
                <form class="form-horizontal" action="action/clientes.php" method="post">
                    <input type="hidden" name="do" value="cadastra" />

                    <div class="form-row row-fluid">
                        <div class="span7">
                            <div class="row-fluid">
                                <label class="form-label span4" for="status">Ativo ?</label>
                                <div class="span4">
                                    <select name="status" id="status" class="span4">
                                        <option <? if ($_SESSION['clientes']['status'] == '1') echo 'selected="selected"'; ?> value="1">Sim</option>
                                        <option <? if ($_SESSION['clientes']['status'] == '0') echo 'selected="selected"'; ?> value="0">Não</option>
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
                                        <option <? if ($_SESSION['clientes']['tipo'] == '0') echo 'selected="selected"'; ?> value="0">Física</option>
                                        <option <? if ($_SESSION['clientes']['tipo'] == '1') echo 'selected="selected"'; ?> value="1">Jurídica</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="nome">Nome</label>
                                <input class="span8" id="nome" type="text" name="nome" value="<?=$_SESSION['clientes']['nome']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid cpf">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="cpf">CPF:</label>
                                <input class="span8 cpf" type="text" id="cpf" name="cpf" value="<?=$_SESSION['clientes']['cpf']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid cnpj">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="documento">CNPJ:</label>
                                <input class="span8 cnpj" type="text" id="cnpj" name="cnpj" value="<?=$_SESSION['clientes']['cnpj']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="data">Dada Nasc:</label>
                                <input class="span8 data" id="data" type="text" name="data" value="<?=$_SESSION['clientes']['data']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="data">E-mail:</label>
                                <input class="span8" id="email" type="text" name="email" value="<?=$_SESSION['clientes']['email']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="contatos">Contatos:</label>
                                <input class="span8" id="contatos" type="text" name="contatos" value="<?=$_SESSION['clientes']['contatos']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="fax">FAX:</label>
                                <input class="span8" id="fax" type="text" name="fax" value="<?=$_SESSION['clientes']['fax']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="residencial">Residencial:</label>
                                <input class="span8" id="residencial" type="text" name="residencial" value="<?=$_SESSION['clientes']['residencial']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="comercial">Comercial:</label>
                                <input class="span8" id="comercial" type="text" name="comercial" value="<?=$_SESSION['clientes']['comercial']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="celular">Celular:</label>
                                <input class="span8" id="celular" type="text" name="celular" value="<?=$_SESSION['clientes']['celular']?>" />
                            </div>
                        </div>
                    </div>                    

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <h3 class="span4" style="margin:15px 0 0 50px;">Endereço</h3>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="cep">CEP:</label>
                                <input class="span2 cep" id="cep" type="text" name="cep" value="<?=$_SESSION['clientes']['cep']?>" />
                                <a href="#" class="btn" onclick="return getEndereco()">Consultar</a>
                            </div>

                        </div>
                    </div>
                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="logradouro">Logradouro:</label>
                                <input class="span8" id="logradouro" type="text" name="logradouro" value="<?=$_SESSION['clientes']['logradouro']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span2">
                            <label class="form-label span6" for="numero">Número:</label>
                            <input class="span4" id="numero" type="text" name="numero" value="<?=$_SESSION['clientes']['numero']?>" />
                        </div>
                        <div class="span6">
                            <label class="form-label span4" for="complemento">Complemento:</label>
                            <input class="span6" id="complemento" type="text" name="complemento" value="<?=$_SESSION['clientes']['complemento']?>" />
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span4" for="bairro">Bairro:</label>
                                <input class="span8" id="bairro" type="text" name="bairro" value="<?=$_SESSION['clientes']['bairro']?>" />
                                
                            </div>
                        </div>
                    </div>
                    
                   <div class="form-row row-fluid">
						<div class="span3">
							<div class="row-fluid">
								<label class="form-label span4" for="cidade">Cidade:</label>
                                <input class="span8" id="cidade" type="text" name="cidade" />
                                <?php
								 	//$cq = mysql_query("SELECT CodCidade, CidUf FROM viCidades WHERE  order by Nome asc");
								?>
                                
								<!--<select name="cidade" id="cidade" class="span4">
                                  <option value="">Selecione</option>
                                 
									<?php while ($rc = mysql_fetch_assoc($cq)): ?>
											<option value="<?php echo $rc['CodCidade'];?>"><?php echo $rc['Nome'];?></option>
                                        <?php endwhile ?>
                                    </select> -->
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
                                                            <textarea name="observacoes" style="width:90%; height:100px;"><?=$_SESSION['clientes']['observacoes']?></textarea>
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
            </div>
        </div><!-- End .box -->
    </div><!-- End .span12 -->
</div><!-- End .row-fluid -->