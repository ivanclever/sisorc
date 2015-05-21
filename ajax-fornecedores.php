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
$result = mysql_query("SELECT COUNT(*) AS count FROM fornecedores WHERE Nome like '$searchTerm'");
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];

if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit; // do not put $limit*($page - 1)
if($total_pages!=0) $SQL = "SELECT * FROM fornecedores WHERE Nome like '$searchTerm'  ORDER BY $sidx $sord LIMIT $start , $limit";
else $SQL = "SELECT * FROM fornecedores WHERE Nome like '$searchTerm'  ORDER BY $sidx $sord";
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());

$response->page = $page;
$response->total = $total_pages;
$response->records = $count;
$i=0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {

    if($row['RazaoSocial'] !='') {
        $razao = $row['RazaoSocial'];
    } else {
        $razao = '-';
    }

    $response->rows[$i]['CodFornecedor']    = $row['CodFornecedor'];
    $response->rows[$i]['Nome']             = $row['Nome'];
    $response->rows[$i]['RazaoSocial']      = $razao;
    $response->rows[$i]['Produto']    = $row['Produto'];

    $i++;
}

echo json_encode($response);
?>
