<?php
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
$searchTerm = $_GET['searchTerm'];
if(!$sidx) $sidx =1;
if ($searchTerm=="") {
	$searchTerm="%";
} else {
	$searchTerm = "%" . $searchTerm . "%";
}

require('util/conn.php');
require('util/util.php');
error_reporting(0);

$result = mysql_query("SELECT COUNT(*) AS count
    FROM vasos, fornecedores, revestimentos
    WHERE vasos.CodFornecedor = fornecedores.CodFornecedor
    AND vasos.CodRevestimento = revestimentos.CodRevestimento
    AND fornecedores.Nome LIKE '%$searchTerm%'
    ORDER BY vasos.DataCadastra DESC");

$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];

if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit; // do not put $limit*($page - 1)
if($total_pages!=0)
    // $SQL = "SELECT precos.*, produtos.NomePopular, fornecedores.Nome nomeFornecedor
    //     FROM precos, produtos, tipospodas, fornecedores, cores, unidadesmedida
    //     WHERE precos.CodProduto = produtos. CodProduto 
    //     AND precos.CodTipoPoda = tipospodas.CodTipoPoda 
    //     AND precos.CodFornecedor = fornecedores.CodFornecedor
    //     AND precos.CodCor = cores.CodCor
    //     AND precos.CodUnidadeMedida = unidadesmedida.CodUnidadeMedida
    //     AND produtos.NomePopular LIKE '%$searchTerm%'
    //     GROUP BY precos.CodPreco
    //     ORDER BY $sidx $sord LIMIT $start , $limit";

    $SQL = "SELECT vasos.*, fornecedores.Nome, DATE_FORMAT( vasos.DataCadastra,'%d/%m/%Y') as dataCad, revestimentos.Descricao
            FROM vasos, fornecedores, revestimentos
            WHERE vasos.CodFornecedor = fornecedores.CodFornecedor
            AND vasos.CodRevestimento = revestimentos.CodRevestimento
            AND fornecedores.Nome LIKE '%$searchTerm%'
            ORDER BY $sidx $sord LIMIT $start , $limit";
else

    $SQL = "SELECT vasos.*, fornecedores.Nome, DATE_FORMAT( vasos.DataCadastra,'%d/%m/%Y') as dataCad, revestimentos.Descricao
        FROM vasos, fornecedores, revestimentos
        WHERE vasos.CodFornecedor = fornecedores.CodFornecedor
        AND vasos.CodRevestimento = revestimentos.CodRevestimento
        AND fornecedores.Nome LIKE '%$searchTerm%'
        ORDER BY $sidx $sord";

//else $SQL = "SELECT * FROM clientes WHERE Nome like '$searchTerm'  ORDER BY $sidx $sord";
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());

$response->page = $page;
$response->total = $total_pages;
$response->records = $count;
$i=0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {

    $response->rows[$i]['CodVaso']         = $row['CodVaso'];
    $response->rows[$i]['DataCadastra']         = $row['dataCad'];
    $response->rows[$i]['Modelo']               = $row['Modelo'];
    $response->rows[$i]['Descricao']            = $row['Descricao'];
    $response->rows[$i]['Dimensoes']            = $row['Dimensoes'];
    $response->rows[$i]['Valor']                = $row['Valor'];
    $response->rows[$i]['Fornecedor']           = $row['Nome'];

    $i++;
}

echo json_encode($response);
?>
