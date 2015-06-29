<?php
$id = (int)$_GET['id'];

$rs = mysql_query("SELECT * FROM produtos WHERE CodProduto = '$id'");
$r = mysql_fetch_assoc($rs);

$categorias = mysql_query("SELECT * FROM categoriasprodutos");

?>
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
                <form class="form-horizontal" action="action/produtos.php" method="post">
                    <input type="hidden" name="do" value="altera" />
                    <input type="hidden" name="id" value="<?=$id?>" />

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span4" for="categoria">Categoria</label>
                                <div class="span2">
                                    <select name="categoria" id="categoria" class="span4">
                                        <option value="">Selecione</option>
                                        <?php while ($r_categorias = mysql_fetch_assoc($categorias)): ?>
                                            <option <? if ($r['CodCategoriaProduto'] == $r_categorias['CodCategoriaProduto']) echo 'selected="selected"'; ?> value="<?=$r_categorias['CodCategoriaProduto']?>"><?=$r_categorias['Nome']?></option>
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
                                        <option value="">Selecione</option>
                                        <option <? if ($r['Ambiente'] == '0') echo 'selected="selected"'; ?> value="0">Sombra</option>
                                        <option <? if ($r['Ambiente'] == '1') echo 'selected="selected"'; ?> value="1">Meia Sombra</option>
                                        <option <? if ($r['Ambiente'] == '2') echo 'selected="selected"'; ?> value="2">Sol Pleno</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="codigo">Código</label>
                                <input class="span8" id="codigo" type="text" name="codigo" value="<?=$r['Codigo']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="nome">Nome Cientifico</label>
                                <input class="span8" id="nome" type="text" name="nome" value="<?=$r['NomeCientifico']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="nome_popular">Nome Popular:</label>
                                <input class="span8" type="text" id="nome_popular" name="nome_popular" value="<?=$r['NomePopular']?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-row row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <label class="form-label span2" for="status">Ativo ?</label>
                                <div class="span2">
                                    <select name="status" id="status" class="span4">
                                        <option <? if ($r['status'] == '0') echo 'selected="selected"'; ?> value="0">Não</option>
                                        <option <? if ($r['status'] == '1') echo 'selected="selected"'; ?> value="1">Sim</option>
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
                       <button type="button" class="btn" onclick="location.href='?s=produtos'">Cancelar</button>
                    </div>
                </form>
            </div>
        </div><!-- End .box -->
    </div><!-- End .span12 -->
</div><!-- End .row-fluid -->