<div class="resBtn">
    <a href="#"><span class="icon16 minia-icon-list-3"></span></a>
</div>

<!--Sidebar background-->
<div id="sidebarbg"></div>
<div id="sidebar">

    <div class="shortcuts">
        <ul>
            <li><a href="support.html" title="Support section" class="tip"><span class="icon24 icomoon-icon-support"></span></a></li>
            <li><a href="#" title="Database backup" class="tip"><span class="icon24 icomoon-icon-database"></span></a></li>
            <li><a href="charts.html" title="Sales statistics" class="tip"><span class="icon24 icomoon-icon-pie-2"></span></a></li>
            <li><a href="#" title="Write post" class="tip"><span class="icon24 icomoon-icon-pencil"></span></a></li>
        </ul>
    </div><!-- End search --> 
</div>
<? /*?>
<div id="sidebar">
    <div class="sidenav">
        <div class="sidebar-widget" style="margin: -1px 0 0 0;">
            <h5 class="title" style="margin-bottom:0">Menu</h5>
        </div><!-- End .sidenav-widget -->
        <div class="mainnav">
            <ul>
                <li>
                    <a href="?s=clientes" style="padding-left:30px;">Clientes</a>
                    <!-- <ul class="sub">
                        <li><a href="?s=clientes"><span class="icon16 icomoon-icon-arrow-right-2"></span>Listagem</a></li>
                        <li><a href="?s=clientes-add"><span class="icon16 icomoon-icon-arrow-right-2"></span>Adicionar</a></li>
                    </ul> -->
                </li>
                <li>
                    <a href="?s=fornecedores" style="padding-left:30px;">Fornecedores</a>
                    <!-- <ul class="sub">
                        <li><a href="?s=fornecedores"><span class="icon16 icomoon-icon-arrow-right-2"></span>Listagem</a></li>
                        <li><a href="?s=fornecedores-add"><span class="icon16 icomoon-icon-arrow-right-2"></span>Adicionar</a></li>
                    </ul> -->
                </li>
                <li>
                    <a href="?s=produtos" style="padding-left:30px;">Produtos</a>
                    <!-- <ul class="sub">
                        <li><a href="?s=categorias"><span class="icon16 icomoon-icon-arrow-right-2"></span>Categorias</a></li>
                        <li><a href="?s=produtos"><span class="icon16 icomoon-icon-arrow-right-2"></span>Listagem</a></li>
                        <li><a href="?s=produtos-add"><span class="icon16 icomoon-icon-arrow-right-2"></span>Adicionar</a></li>
                    </ul> -->
                </li>
                <li>
                    <a href="?s=vasos" style="padding-left:30px;">Vasos</a>
                    <!-- <ul class="sub">
                        <li><a href="?s=categorias"><span class="icon16 icomoon-icon-arrow-right-2"></span>Categorias</a></li>
                        <li><a href="?s=produtos"><span class="icon16 icomoon-icon-arrow-right-2"></span>Listagem</a></li>
                        <li><a href="?s=produtos-add"><span class="icon16 icomoon-icon-arrow-right-2"></span>Adicionar</a></li>
                    </ul> -->
                </li>
                <li>
                    <a href="?s=orcamentos" style="padding-left:30px;">Orçamentos</a>
                    <ul class="sub">
                        <li><a href="?s=orcamentos"><span class="icon16 icomoon-icon-arrow-right-2"></span>Listagem</a></li>
                        <li><a href="?s=orcamentos-add"><span class="icon16 icomoon-icon-arrow-right-2"></span>Adicionar</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" style="padding-left:30px;">Configurações</a>
                    <ul class="sub">
                        <li><a href="?s=cores"><span class="icon16 icomoon-icon-arrow-right-2"></span>Cores</a></li>
                        <li><a href="?s=podas"><span class="icon16 icomoon-icon-arrow-right-2"></span>Tipos de Poda</a></li>
                        <li><a href="?s=revestimentos"><span class="icon16 icomoon-icon-arrow-right-2"></span>Revestimentos</a></li>
                        <li><a href="?s=unidades"><span class="icon16 icomoon-icon-arrow-right-2"></span>Unidades de Medida</a></li>
                        <li><a href="?s=usuarios"><span class="icon16 icomoon-icon-arrow-right-2"></span>Usuários do sistema</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="sidebar-widget">
            <h5 class="title">Estatísticas</h5>
            <div class="content">
                <div class="rightnow">
                    <ul class="unstyled">
                        <li>
                            <span class="number">
                                <?=mysql_result(mysql_query("SELECT COUNT(CodCliente) AS num FROM clientes"),0,'num')?>
                            </span>
                            <span class="icon16 icomoon-icon-arrow-right-2"></span>Clientes
                        </li>
                        <li>
                            <span class="number">
                                <?=mysql_result(mysql_query("SELECT COUNT(CodFornecedor) AS num FROM fornecedores"),0,'num')?>
                            </span>
                            <span class="icon16 icomoon-icon-arrow-right-2"></span>Fornecedores
                        </li>
                        <li>
                            <span class="number">
                                <?=mysql_result(mysql_query("SELECT COUNT(CodProduto) AS num FROM produtos"),0,'num')?>
                            </span>
                            <span class="icon16 icomoon-icon-arrow-right-2"></span>Produtos
                        </li>
                        <li>
                            <span class="number">
                                <?=mysql_result(mysql_query("SELECT COUNT(CodOrcamento) AS num FROM orcamentos"),0,'num')?>
                            </span>
                            <span class="icon16 icomoon-icon-arrow-right-2"></span>Orçamentos
                        </li>
                    </ul>
                </div>
            </div>

        </div><!-- End .sidenav-widget -->
    </div>
</div><!-- End #sidebar -->
<? */ ?>