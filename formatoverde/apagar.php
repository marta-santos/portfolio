<?php require_once('formatoverde.php'); ?>
<?php
$tra=$_POST['trabalho'];

mysql_select_db("personal_trip",($formatoverde)) ;

if($_POST['apagar']==true){

$dir='../portfolio/'.$tra.'/';

mysql_query("DELETE FROM porfolio WHERE cod='".$tra."'");


if($dir==true){

$mydir = opendir($dir);
while(false !== ($file = readdir($mydir))) 
{if($file != "." && $file != ".."){ unlink($dir.$file);}}
rmdir($dir) ;
}

}


?>