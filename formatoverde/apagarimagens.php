<?php require_once('formatoverde.php'); ?>
<?php
	
	if($_POST['apagarimagens']==true){
		///////////////////////CRIAR IMAGENS ZIP
	$trabalho= $_POST['trabalho'];
	$pasta='../portfolio/'.$trabalho."/";
	
foreach(glob($pasta.'*.*') as $v){
    unlink($v);
}		
	}
?>

