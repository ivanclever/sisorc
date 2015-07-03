<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                    <span>Adicionar Fornecedor</span>
                </h4>
            </div>
            <div class="content">
                <form class="form-horizontal" action="action/fornecedores.php" method="post">
                    <input type="hidden" name="do" value="cadastra" />

                    <div class="form-row row-fluid">
                        <div class="span7">
                            <div class="row-fluid">
                                <label class="form-label span4" for="status">Ativo ?</label>
                                <div class="span4">
                                    <select name="status" id="status" class="span4">
                                        <option <? if ($_SESSION['fornecedores']['status'] == '1') echo 'selected="selected"'; ?> value="1">Sim</option>
                                        <option <? if ($_SESSION['fornecedores']['status'] == '0') echo 'selected="selected"'; ?> value="0">Não</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span7">
                            <div class="row-fluid">
                                <label class="form-label span4" for="ranking">Ranking</label>
                                <div class="span4">
                                    <select name="ranking" id="ranking" class="span4">
                                        <option <? if ($_SESSION['fornecedores']['ranking'] == 'A') echo 'selected="selected"'; ?> value="A">A</option>
                                        <option <? if ($_SESSION['fornecedores']['ranking'] == 'B') echo 'selected="selected"'; ?> value="B">B</option>
                                        <option <? if ($_SESSION['fornecedores']['ranking'] == 'C') echo 'selected="selected"'; ?> value="C">C</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="nome">Nome</label>
                                <input class="span8" id="nome" type="text" name="nome" value="<?=$_SESSION['fornecedores']['nome']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid cnpj">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="documento">CNPJ:</label>
                                <input class="span8 cnpj" type="text" id="cnpj" name="cnpj" value="<?=$_SESSION['fornecedores']['cnpj']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="razao_social">Razão Social:</label>
                                <input class="span8" id="razao_social" type="text" name="razao_social" value="<?=$_SESSION['fornecedores']['razao_social']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="insc">Inscrição Estadual:</label>
                                <input class="span8" id="insc" type="text" name="insc" value="<?=$_SESSION['fornecedores']['insc']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="data">E-mail:</label>
                                <input class="span8" id="email" type="text" name="email" value="<?=$_SESSION['fornecedores']['email']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="site">Site</label>
                                <input class="span8" id="site" type="text" name="site" value="<?=$_SESSION['fornecedores']['site']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="contatos">Contatos:</label>
                                <input class="span8" id="contatos" type="text" name="contatos" value="<?=$_SESSION['fornecedores']['contatos']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="telefone">Telefone:</label>
                                <input class="span8 telefone" id="telefone" type="text" name="telefone" value="<?=$_SESSION['fornecedores']['telefone']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="fax">FAX:</label>
                                <input class="span8 fax" id="fax" type="text" name="fax" value="<?=$_SESSION['fornecedores']['fax']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="celular">Celular:</label>
                                <input class="span8 telefone" id="celular" type="text" name="celular" value="<?=$_SESSION['fornecedores']['celular']?>" />
                            </div>
                        </div>
                    </div>
					
					 <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="produtos">Produtos:</label>
                                <input class="span8 produtos" id="produtos" type="text" name="produtos" value="<?=$_SESSION['fornecedores']['produtos']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="ceasa">Ceasa:</label>
                                <input class="span8" id="ceasa" type="text" name="ceasa" value="<?=$_SESSION['fornecedores']['ceasa']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="ceasa_batata">Ceasa Batata:</label>
                                <input class="span8" id="ceasa_batata" type="text" name="ceasa_batata" value="<?=$_SESSION['fornecedores']['ceasa_batata']?>" />
                            </div>
                        </div>
                    </div>           

                    <div class="form-row row-fluid">
                        <div class="span2">
                            <h3 class="span4" style="margin:15px 0 0 50px;">Endereço</h3>
                        </div>
                    </div>

                     <div class="form-row row-fluid">
						<div class="span3">
							<div class="row-fluid">
                                <label class="form-label span4" for="cep">CEP:</label>
                                <input class="span8 cep" id="cep" type="text" name="cep" value="<?=$r['CEP']?>" />
                                <a href="#" class="btn" onclick="return getEndereco()">Consultar</a>
                            </div>

                        </div>
                    </div>
                    <div class="form-row row-fluid">
                     	<div class="span3">
                            <div class="row-fluid">
                                <label class="form-label span4" for="logradouro">Logradouro:</label>
                                <input class="span6" id="logradouro" type="text" name="logradouro" value="<?=$r['Endereco']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span2">
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
								<label class="form-label span4" for="cidade">Cidade:</label>
                                <input class="span8" id="cidade" type="text" name="cidade" value="<?=$r['CidUf']?>" />
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
                       <button type="button" class="btn" onclick="location.href='?s=fornecedores'">Cancelar</button>
                    </div>
                </form>
            </div>
        </div><!-- End .box -->
    </div><!-- End .span12 -->
</div><!-- End .row-fluid -->