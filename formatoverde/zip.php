<?php require_once('formatoverde.php'); ?>
<?php
		///////////////////////CRIAR IMAGENS ZIP
	$trabalho= $_POST['trabalho'];
	$pasta='../portfolio/'.$trabalho;
	
	$tnmain=$_FILES['uploadfilemain']['tmp_name']; 
	$tn1=$_FILES['uploadfile1']['tmp_name']; 
	$tn2=$_FILES['uploadfile2']['tmp_name']; 
	$tn3=$_FILES['uploadfile3']['tmp_name']; 
	$tn4=$_FILES['uploadfile4']['tmp_name']; 
	$tn5=$_FILES['uploadfile5']['tmp_name']; 
	$tn6=$_FILES['uploadfile6']['tmp_name']; 
	
	$filemain = $pasta.'/main.jpg';
	$file1 = $pasta.'/1.jpg';
	$file2 = $pasta.'/2.jpg';
	$file3 = $pasta.'/3.jpg';
	$file4 = $pasta.'/4.jpg';
	$file5 = $pasta.'/5.jpg';
	$file6 = $pasta.'/6.jpg';

	if($tnmain==true){move_uploaded_file($tnmain, $filemain);}
	if($tn1==true){move_uploaded_file($tn1, $file1);}
	if($tn2==true){move_uploaded_file($tn2, $file2);}
	if($tn3==true){move_uploaded_file($tn3, $file3);}
	if($tn4==true){move_uploaded_file($tn4, $file4);}
	if($tn5==true){move_uploaded_file($tn5, $file5);}
	if($tn6==true){move_uploaded_file($tn6, $file6);}
			
	
?>

