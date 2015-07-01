<?php
ob_start();
require('util/conn.php');
require('util/util.php');
require('util/auth.php');

if ($_GET['s'] == 'sair') {
    unset($_SESSION['Auth']);
    Go('login.php');
}
$id_usuario = $_SESSION['Auth']['ID'];
$nivel_usuario = mysql_query("SELECT * FROM usuarios WHERE id = '$id_usuario'");
$usuario = mysql_fetch_assoc($nivel_usuario);

$secoes = array(
    ''=>'dashboard.php',

    //usuarios
    'usuarios'=>'usuarios.php',
    'usuarios-add'=>'usuarios-add.php',
    'usuarios-edit'=>'usuarios-edit.php',

    //produtos
    'produtos'=>'produtos.php',
    'produtos-add'=>'produtos-add.php',
    'produtos-edit'=>'produtos-edit.php',
	'produtos-inativos'=> 'produtos-inativos.php',

    //precos
    'precos-custo'=>'precos-custo.php',
    'precos-custo-add'=>'precos-custo-add.php',
    'precos-custo-edit'=>'precos-custo-edit.php',
    'precos-custo-inativos'=>'precos-custo-inativos.php',

    'categorias'=>'categorias.php',
    'categorias-add'=>'categorias-add.php',
    'categorias-edit'=>'categorias-edit.php',

    'ambientes'=>'ambientes.php',
    'ambientes-add'=>'ambientes-add.php',
    'ambientes-edit'=>'ambientes-edit.php',

    //fornecedores
    'fornecedores'=>'fornecedores.php',
    'fornecedores-add'=>'fornecedores-add.php',
    'fornecedores-edit'=>'fornecedores-edit.php',
        'fornecedores-inativos'=>'fornecedores-inativos.php',

        'produtos-fornecedores'=>'produtos-fornecedores.php',
        'produtos-fornecedores-add'=>'produtos-fornecedores-add.php',
        'produtos-fornecedores-edit'=>'produtos-fornecedores-edit.php',

    //clientes
    'clientes'=>'clientes.php',
    'clientes-add'=>'clientes-add.php',
    'clientes-edit'=>'clientes-edit.php',
        'clientes-inativos'=>'clientes-inativos.php',

    //orcamentos
    'orcamentos'=>'orcamentos.php',
    'orcamentos-add'=>'orcamentos-add.php',
    'orcamentos-produtos'=>'orcamentos-produtos.php',
    'orcamentos-edit'=>'orcamentos-edit.php',
	'orcamentos-inativos'=>'orcamentos-inativos.php',

        'orcamentos-vegetais-edit'=>'orcamentos-vegetais-edit.php',
        'orcamentos-forracoes-edit'=>'orcamentos-forracoes-edit.php',
        'orcamentos-diversos-edit'=>'orcamentos-diversos-edit.php',
        'orcamentos-vasos-edit'=>'orcamentos-vasos-edit.php',

    //cores
    'cores'=>'cores.php',
    'cores-add'=>'cores-add.php',
    'cores-edit'=>'cores-edit.php',

    //podas
    'podas'=>'podas.php',
    'podas-add'=>'podas-add.php',
    'podas-edit'=>'podas-edit.php',

    //unidades
    'unidades'=>'unidades.php',
    'unidades-add'=>'unidades-add.php',
    'unidades-edit'=>'unidades-edit.php',

    //revestimentos
    'revestimentos'=>'revestimentos.php',
    'revestimentos-add'=>'revestimentos-add.php',
    'revestimentos-edit'=>'revestimentos-edit.php',

    //vasos
    'vasos'=>'vasos.php',
    'vasos-add'=>'vasos-add.php',
    'vasos-edit'=>'vasos-edit.php',
	'vasos-inativos'=>'vasos-inativos.php',
);
$title = array(
    ''=>'Home',

    //usuarios
    'usuarios'=>'Usuários',
    'usuarios-add'=>'Adicionar Usuário',
    'usuarios-edit'=>'Editar Usuário',

    //produtos
    'produtos'=>'Produtos',
    'produtos-add'=>'Adicionar Produtos',
    'produtos-edit'=>'Editar Produtos',
	'produtos-inativos'=>'Produtos Inativos',

    //Precos de custo
    'precos-custo'=>'Preços',
    'precos-custo-add'=>'Adicionar Preços',
    'precos-custo-edit'=>'Editar Preços',

    'precos-custo-inativos'=>'Preços de custo - Inativos',

    'categorias'=>'Categorias',
    'categorias-add'=>'Adicionar Categorias',
    'categorias-edit'=>'Editar Categorias',

    'ambientes'=>'Ambientes',
    'ambientes-add'=>'Adicionar Ambientes',
    'ambientes-edit'=>'Editar Ambientes',

    //fornecedores
    'fornecedores'=>'Fornecedores',
    'fornecedores-add'=>'Adicionar Fornecedores',
    'fornecedores-edit'=>'Editar Fornecedores',

        'produtos-fornecedores'=>'Produtos -Fornecedores',
        'produtos-fornecedores-add'=>'Relacionar Produto ao Fornecedor',

        'fornecedores-inativos'=>'Fornecedores Inativos',

    //clientes
    'clientes'=>'Clientes',
    'clientes-add'=>'Adicionar Clientes',
    'clientes-edit'=>'Editar Clientes',

    'clientes-inativos'=>'Clientes Inativos',

    //orcamentos
    'orcamentos'=>'Orçamentos',
    'orcamentos-add'=>'Adicionar Orçamentos',
    'orcamentos-produtos'=>'Adicionar Produtos',
    'orcamentos-edit'=>'Editar Orçamentos',
	'orcamentos-inativos'=>'Orçamentos Inativos',

        'orcamentos-vegetais-edit'=>'Orçamentos - Vegetais',
        'orcamentos-forracoes-edit'=>'Orçamentos - Forrações',
        'orcamentos-diversos-edit'=>'Orçamentos - Diversos',
        'orcamentos-vasos-edit'=>'Orçamentos - Vasos',

    //cores
    'cores'=>'Cores',
    'cores-add'=>'Adicionar Cor',
    'cores-edit'=>'Editar Cor',

    //podas
    'podas'=>'Tipos de Podas',
    'podas-add'=>'Adicionar Tipo de Poda',
    'podas-edit'=>'Editar Tipo de Poda',

    //unidades
    'unidades'=>'Unidades de Medida',
    'unidades-add'=>'Adicionar Unidades de Medida',
    'unidades-edit'=>'Editar Unidades de Medida',

    //revestimentos
    'revestimentos'=>'Revestimentos',
    'revestimentos-add'=>'Adicionar Revestimentos',
    'revestimentos-edit'=>'Editar Revestimentos',

    //vasos
    'vasos'=>'Vasos',
    'vasos-add'=>'Adicionar Vasos',
    'vasos-edit'=>'Editar Vasos',
	'vasos-inativos'=>'Vasos Inativos',

);

$breadcrumb = array(
    ''=>'Home',

    //usuarios
    'usuarios'=>'Configurações > Usuários',
    'usuarios-add'=>'Configurações > Adicionar Usuário',
    'usuarios-edit'=>'Configurações > Editar Usuário',

    //produtos
    'produtos'=>' Produtos',
    'produtos-add'=>' Produtos > Adicionar Produto',
    'produtos-edit'=>' Produtos > Editar Produto',
	'produtos-inativos'=> 'Produtos > Produtos Inativos',

    //precos
    'precos-custo'=>' Preços de Custo',
    'precos-custo-add'=>' Preços de Custo > Adicionar Preço',
    'precos-custo-edit'=>' Preços de Custo > Editar Preço',

    'precos-custo-inativos'=>'Preços de custo - Inativos',

    'categorias'=>'Produtos > Categorias',
    'categorias-add'=>' Produtos > Categorias > Adicionar Categoria',
    'categorias-edit'=>' Produtos > Categorias > Editar Categoria',

    'ambientes'=>' Produtos > Ambientes',
    'ambientes-add'=>' Produtos > Ambientes > Adicionar Ambientes',
    'ambientes-edit'=>' Produtos > Ambientes > Editar Ambientes',

    //fornecedores
    'fornecedores'=>' Fornecedores',
    'fornecedores-add'=>' Fornecedores > Adicionar Fornecedor',
    'fornecedores-edit'=>' Fornecedores > Editar Fornecedor',

        'produtos-fornecedores'=>' Fornecedores > Produtos',
        'produtos-fornecedores-add'=>' Fornecedores > Relacionar Produto ao Fornecedor',

        'fornecedores-inativos'=>'Fornecedores Inativos',

    //clientes
    'clientes'=>' Clientes',
    'clientes-add'=>' Clientes > Adicionar Cliente',
    'clientes-edit'=>' Clientes > Editar Cliente',

    'clientes-inativos'=>'Clientes Inativos',

    //orcamentos
    'orcamentos'=>' Orçamentos',
    'orcamentos-add'=>' Orçamentos > Adicionar Orçamento',
    'orcamentos-produtos'=>' Orçamentos > Adicionar Produtos',
    'orcamentos-edit'=>' Orçamentos > Editar Orçamento',
	'orcamentos-inativos'=>' Orçamentos > Inativos',

        'orcamentos-vegetais-edit'=>' Orçamentos >  Editar Espécies vegetais',
        'orcamentos-forracoes-edit'=>' Orçamentos > Editar Forrações',
        'orcamentos-diversos-edit'=>' Orçamentos > Editar Diversos',
        'orcamentos-vasos-edit'=>' Orçamentos > Editar Vasos',

    //cores
    'cores'=>' Cores',
    'cores-add'=>' Adicionar Cor',
    'cores-edit'=>' Editar Cor',

    //podas
    'podas'=>' Cores',
    'podas-add'=>' Adicionar Cor',
    'podas-edit'=>' Editar Cor',

    //unidades
    'unidades'=>' Unidades de Medida',
    'unidades-add'=>' Adicionar Unidade de Medida',
    'unidades-edit'=>' Editar Unidade de Medida',

    //revestimentos
    'revestimentos'=>' Revestimentos',
    'revestimentos-add'=>' Adicionar Revestimentos',
    'revestimentos-edit'=>' Editar Revestimentos',

    //vasos
    'vasos'=>' Vasos',
    'vasos-add'=>' Adicionar Vasos',
    'vasos-edit'=>' Editar Vasos',
	'vasos-inativos'=>'Vasos Inativos',

);
if (!array_key_exists($_GET['a'],$secoes)) $_GET['s'] = '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Terra Verde | <?=$title[$_GET['s']]?></title>

        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <?php include('css.php'); ?>
<script type="text/javascript">
            //adding load class to body and hide page
            document.documentElement.className += 'loadstate';
        </script>
    </head>

    <body>
<!-- loading animation -->
    <div id="qLoverlay"></div>
    <div id="qLbar"></div>

    <?php include('header.php'); ?>

    <div id="wrapper">

        <!--Sidebar content-->
        <?php# include('sidebar.php'); ?>

        <!--Body content-->
        <div id="content-one" class="clearfix" style="margin-right:0;">
            <div class="contentwrapper"><!--Content wrapper-->
                <div class="heading">

                    <h3>SISTV - Sistema de Orçamentos Terra Verde</h3>                    

                    <div class="resBtnSearch">
                        <a href="#"><span class="icon16 icomoon-icon-search-3"></span></a>
                    </div>

                    <ul class="breadcrumb">
                        <li>Você está em:</li>
                        <li>
                            <a href="#" class="tip" title="voltar para Home">
                                <span class="icon16 icomoon-icon-screen-2"></span>
                            </a> 
                            <span class="divider">
                                <span class="icon16 icomoon-icon-arrow-right-2"></span>
                            </span>
                        </li>
                        <li class="active"><?=$breadcrumb[$_GET['s']]?></li>
                    </ul>

                </div><!-- End .heading-->

                <?php include($secoes[$_GET['s']]) ?>

            </div><!-- End contentwrapper -->

        </div><!-- End #content -->

    </div><!-- End #wrapper -->

    <?php include('js.php'); ?>

    </body>
</html>