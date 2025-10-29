<?php require_once('formatoverde.php'); ?>
<?php

$ligacao =mysql_connect("localhost","personal","palavrapass");
mysql_select_db("personal_trip",($formatoverde)) ;

$trabalho=$_POST['trabalho'];

if($_POST['visivel']=="0"){
mysql_query("UPDATE porfolio SET visivel='1' WHERE cod='".$trabalho."'");
}

if($_POST['visivel']=="1"){
mysql_query("UPDATE porfolio SET visivel='0' WHERE cod='".$trabalho."'");
} 



?>