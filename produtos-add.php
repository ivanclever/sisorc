<?php
$categorias = mysql_query("SELECT * FROM categoriasprodutos");
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <?php showErros(); ?>
            <div class="title">
                <h4>
                    <span class="icon16 icomoon-icon-equalizer-2"></span>
                    <span>Adicionar Produto</span>
                </h4>
            </div>
            <div class="content">
                <form class="form-horizontal" action="action/produtos.php" method="post">
                    <input type="hidden" name="do" value="cadastra" />

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="categoria">Categoria</label>
                                <div class="span2">
                                    <select name="categoria" id="categoria" class="span4">
                                        <?php while ($r_categorias = mysql_fetch_assoc($categorias)): ?>
                                            <option <? if ($_SESSION['produtos']['categoria'] == $r_categorias['CodCategoriaProduto']) echo 'selected="selected"'; ?> value="<?=$r_categorias['CodCategoriaProduto']?>"><?=$r_categorias['Nome']?></option>
                                        <? endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="ambiente">Ambiente</label>
                                <div class="span2">
                                    <select name="ambiente" id="ambiente" class="span4">
                                        <option value="">-Selecione-</option>
                                        <option <? if ($_SESSION['produtos']['ambiente'] == '0') echo 'selected="selected"'; ?> value="0">Sombra</option>
                                        <option <? if ($_SESSION['produtos']['ambiente'] == '1') echo 'selected="selected"'; ?> value="1">Meia Sombra</option>
                                        <option <? if ($_SESSION['produtos']['ambiente'] == '2') echo 'selected="selected"'; ?> value="2">Sol Pleno</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="codigo">Código</label>
                                <input class="span8" id="codigo" type="text" name="codigo" value="<?=$_SESSION['produtos']['codigo']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="nome">Nome Cientifico</label>
                                <input class="span8" id="nome" type="text" name="nome" value="<?=$_SESSION['produtos']['nome']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="nome_popular">Nome Popular:</label>
                                <input class="span8" type="text" id="nome_popular" name="nome_popular" value="<?=$_SESSION['produtos']['nome_popular']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="status">Ativo ?</label>
                                <div class="span2">
                                    <select name="status" id="status" class="span4">
                                        <option <? if ($_SESSION['produtos']['status'] == '0') echo 'selected="selected"'; ?> value="0">Não</option>
                                        <option <? if ($_SESSION['produtos']['status'] == '1') echo 'selected="selected"'; ?> value="1">Sim</option>
                                    </select>
                                </div>
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
                                                            <textarea name="observacoes" style="width:90%; height:100px;"><?=$_SESSION['produtos']['observacoes']?></textarea>
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
                       <button type="button" class="btn" onclick="location.href='?s=produtos'">Cancelar</button>
                    </div>
                </form>
            </div>
        </div><!-- End .box -->
    </div><!-- End .span12 -->
</div><!-- End .row-fluid -->