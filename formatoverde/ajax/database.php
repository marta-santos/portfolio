<?php header('Content-Type: text/html; charset=ISO-8859-15'); ?>

<?php
 $valor=$_GET['id'];
 $tabela=$_GET['tabela'];
 $campo=$_GET['campo'];

$ligacao =mysql_connect("localhost","personal","palavrapass");
if ($ligacao){
mysql_select_db("personal_trip",($ligacao)) ;

$result = mysql_query("SELECT * FROM ".$tabela." WHERE cod='".$valor."' ");
	while($row = mysql_fetch_array($result))
			{
			echo $row[$campo];
			}	
	
} 
	

	
?>