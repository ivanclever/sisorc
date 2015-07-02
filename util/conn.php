<?php
@session_start();
//error_reporting(0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

#local
$_link = mysql_connect("localhost","root","");
//$_link = mysql_connect("localhost:8080","sisorcuser","OM2N,0NPs4!X");
$db = mysql_select_db("sisorc",$_link);

@mysql_query("SET NAMES utf8");
@mysql_query("SET CHARACTER_SET utf8");
?>