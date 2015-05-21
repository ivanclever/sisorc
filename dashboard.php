<!-- Build page from here: -->
<div class="row-fluid">
    <div class="span12">
        <div class="centerContent">
            <ul class="bigBtnIcon">
                <li>
                    <a href="?s=clientes" title="Clientes" class="tipB">
                        <span class="icon icomoon-icon-user"></span>
                        <span class="txt">Clientes</span>
                        <span class="notification blue"><?=mysql_result(mysql_query("SELECT COUNT(CodCliente) AS num FROM clientes"),0,'num')?></span>
                    </a>
                </li>
                <li>
                    <a href="?s=fornecedores" title="Fornecedores" class="tipB">
                        <span class="icon icomoon-icon-truck"></span>
                        <span class="txt">Fornecedores</span>
                        <span class="notification blue"><?=mysql_result(mysql_query("SELECT COUNT(CodFornecedor) AS num FROM fornecedores"),0,'num')?></span>
                    </a>
                </li>
                <li>
                    <a href="?s=produtos" title="Produtos" class="tipB">
                        <span class="icon icomoon-icon-leaf"></span>
                        <span class="txt">Produtos</span>
                        <span class="notification blue"><?=mysql_result(mysql_query("SELECT COUNT(CodProduto) AS num FROM produtos"),0,'num')?></span>
                    </a>
                </li>
                <li>
                    <a href="?s=orcamentos" title="Orçamentos" class="tipB">
                        <span class="icon icomoon-icon-pencil"></span>
                        <span class="txt">Orçamentos</span>
                        <span class="notification blue"><?=mysql_result(mysql_query("SELECT COUNT(CodOrcamento) AS num FROM orcamentos"),0,'num')?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div><!-- End .span8 -->
</div><!-- End .row-fluid -->