<?php
require('util/conn.php');
require('util/util.php');

	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="utf-8"', true );


	$cod_estados = mysql_real_escape_string( $_REQUEST['cod_estados'] );

	$cidades = array();

	$sql = "SELECT CodCidade, Nome
			FROM cidades
			WHERE CodEstado=$cod_estados
			ORDER BY Nome";
	$res = mysql_query( $sql );
	while ( $row = mysql_fetch_assoc( $res ) ) {
		$cidades[] = array(
			'cod_cidades'	=> $row['CodCidade'],
			'nome'			=> $row['Nome'],
		);
	}

	echo( json_encode( $cidades ) );
?>	