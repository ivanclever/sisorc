<?php
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort


$sord = $_GET['sord']; // get the direction
$searchTerm = $_GET['searchTerm'];

if ( $searchTerm == "") { $searchTerm="%"; } 
else { $searchTerm = "%" . $searchTerm . "%"; }


require('util/conn.php');
require('util/util.php');
//error_reporting(0);

$result = mysql_query("SELECT COUNT(*) AS count
    FROM precos
    LEFT JOIN produtos AS p ON p.CodProduto = precos.CodProduto
    LEFT JOIN fornecedores AS f ON f.Codfornecedor = precos.Codfornecedor
    LEFT JOIN tipospodas AS t ON t.CodTipoPoda = precos.CodTipoPoda
    LEFT JOIN unidadesmedida AS u ON u.CodUnidadeMedida = precos.CodUnidadeMedida
    LEFT JOIN cores AS c ON c.CodCor = precos.CodCor
    WHERE precos.CodProduto = p.CodProduto
    AND (p.NomePopular LIKE '%$searchTerm%' OR p.NomeCientifico LIKE '%$searchTerm%' OR p.Codigo LIKE '%$searchTerm%')
    GROUP BY precos.CodPreco
    ORDER BY precos.DataCadastra DESC");

// $result = mysql_query("SELECT COUNT(*) AS count
//             FROM precos, produtos, tipospodas, fornecedores, cores, unidadesmedida
//             WHERE precos.CodProduto = produtos. CodProduto 
//             AND precos.CodTipoPoda = tipospodas.CodTipoPoda 
//             AND precos.CodFornecedor = fornecedores.CodFornecedor
//             AND precos.CodCor = cores.CodCor
//             AND precos.CodUnidadeMedida = unidadesmedida.CodUnidadeMedida
//             AND produtos.NomePopular LIKE '%$searchTerm%'
//             GROUP BY precos.CodPreco
//             ORDER BY precos.CodPreco DESC");

#$result = mysql_query("SELECT COUNT(*) AS count FROM clientes WHERE Nome like '$searchTerm'");
//$row = mysql_fetch_array($result, MYSQL_ASSOC);
$count = $row['count'] == null? 1:$row['count'];
$count = mysql_num_rows($result);

if( $count > 0 ) {
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

    $SQL = "SELECT precos.*, p.NomePopular,p.Codigo, p.NomeCientifico, f.Nome as NFornecedor, DATE_FORMAT( precos.DataCadastra,'%d/%m/%Y') as dataCad, u.Sigla, c.Nome Cor
            FROM precos
            LEFT JOIN produtos AS p ON p.CodProduto = precos.CodProduto
            LEFT JOIN fornecedores AS f ON f.Codfornecedor = precos.Codfornecedor
            LEFT JOIN tipospodas AS t ON t.CodTipoPoda = precos.CodTipoPoda
            LEFT JOIN unidadesmedida AS u ON u.CodUnidadeMedida = precos.CodUnidadeMedida
            LEFT JOIN cores AS c ON c.CodCor = precos.CodCor
            WHERE precos.CodProduto = p.CodProduto
            AND (p.NomePopular LIKE '%$searchTerm%' OR p.NomeCientifico LIKE '%$searchTerm%' OR p.Codigo LIKE '%$searchTerm%')
            GROUP BY precos.CodPreco
            ORDER BY $sidx $sord LIMIT $start , $limit";
else

    $SQL = "SELECT precos.*,p.Codigo, p.NomePopular, p.NomeCientifico, f.Nome as NFornecedor, DATE_FORMAT( precos.DataCadastra,'%d/%m/%Y') as dataCad, u.Sigla, c.Nome Cor
        FROM precos
        LEFT JOIN produtos AS p ON p.CodProduto = precos.CodProduto
        LEFT JOIN fornecedores AS f ON f.Codfornecedor = precos.Codfornecedor
        LEFT JOIN tipospodas AS t ON t.CodTipoPoda = precos.CodTipoPoda
        LEFT JOIN unidadesmedida AS u ON u.CodUnidadeMedida = precos.CodUnidadeMedida
        LEFT JOIN cores AS c ON c.CodCor = precos.CodCor
        WHERE precos.CodProduto = p.CodProduto
        AND (p.NomePopular LIKE '%$searchTerm%' OR p.NomeCientifico LIKE '%$searchTerm%' OR p.Codigo LIKE '%$searchTerm%')
        GROUP BY precos.CodPreco
        ORDER BY $sidx $sord";

//else $SQL = "SELECT * FROM clientes WHERE Nome like '$searchTerm'  ORDER BY $sidx $sord";
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());

$response->page = $page;
$response->total = $total_pages;
$response->records = $count;
$i=0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {

    if($row['Poda'] !='') $poda = $row['Poda']; else $poda = '-';
    if($row['Sigla'] !='') $sigla = $row['Sigla']; else $sigla = '-';
    if($row['Porte'] !='') $porte = $row['Porte']; else $porte = '-';
    if($row['Diametro'] !='') $diametro = $row['DiametroTronco']; else $diametro = '-';
    if($row['AlturaTronco'] !='') $altura = $row['AlturaTronco']; else $altura = '-';
    if($row['Valor'] !='') $valor = $row['Valor']; else $valor = '-';
    if($row['UnidadesPorCaixa'] !='') $unidades = $row['UnidadesPorCaixa']; else $unidades = '-';
    if($row['Cor'] !='') $cor = $row['Cor']; else $cor = '-';

    $response->rows[$i]['DataCadastra']         = $row['dataCad'];
    $response->rows[$i]['CodPreco']             = $row['CodPreco'];
	$response->rows[$i]['Codigo']            	= $row['Codigo'];
    $response->rows[$i]['CodProduto']           = $row['CodProduto'];
    $response->rows[$i]['Produto']              = $row['NomePopular'];
	$response->rows[$i]['NomeCient']             = $row['NomeCientifico'];
    $response->rows[$i]['NFornecedor']           = $row['NFornecedor'];
    $response->rows[$i]['Poda']                 = $poda;
    $response->rows[$i]['Sigla']                = $sigla;
    $response->rows[$i]['Porte']                = $porte;
    $response->rows[$i]['Diametro']             = $diametro;
    $response->rows[$i]['Altura']               = $altura;
    $response->rows[$i]['Valor']                = $valor;
    $response->rows[$i]['Unidades']             = $unidades;
    $response->rows[$i]['Cor']             		= $cor;

    $i++;
}

echo json_encode($response);
?>
