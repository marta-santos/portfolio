<?php require_once('formatoverde.php'); ?>
<?php
	
	if($_POST['novotrabalho']==true){
		
		$result=mysql_query('SELECT cod FROM porfolio WHERE cod= (SELECT MAX(cod) FROM porfolio)');
		
		while($linha=mysql_fetch_array($result)){$resultado=$linha['cod']+1;}
		
		$resultado = sprintf('%03d', $resultado);
		
		if($resultado=="000"){$resultado="001";}
		
		mkdir("../portfolio/".$resultado, 0777);
		chmod("../portfolio/".$resultado, 0777);

		mysql_query("INSERT INTO porfolio (cod) VALUES ('$resultado')");
		
		}


	
	
?>