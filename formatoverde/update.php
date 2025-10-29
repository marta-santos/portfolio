<?php require_once('formatoverde.php'); ?>
<?

mysql_select_db("personal_trip",($formatoverde)) ;
if($_POST['tabela']==true){
		 $ser=$_POST['codigo'];//cod
		 $tx = $_POST['textotratado'];
		$campo=$_POST['tabela'];
		
		mysql_query("UPDATE porfolio SET $campo='$tx' WHERE cod='$ser'");
	}
?>