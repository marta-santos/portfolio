<?php require_once('Connections/formatoverde.php'); ?>
<?php

if (!isset($_SESSION)) {
  session_start();
}

$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){

  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  
  $isValid = False; 

  if (!empty($UserName)) { 

    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
  
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$_POST['numimagens'] = count($_FILES['file']['name']);
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "adprojeto")) {
  $insertSQL = sprintf("INSERT INTO portfolio (titulo, area, cliente, texto, titulopt, areapt, clientept, textopt, titulofr, areafr, clientefr, textofr, tituloes, areaes, clientees, textoes, numimagens, linkvimeo, linkvimeo2, linkyoutube, data) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['area'], "text"),
					   GetSQLValueString($_POST['cliente'], "text"),
                       GetSQLValueString($_POST['texto'], "text"),
					   GetSQLValueString($_POST['titulopt'], "text"),
                       GetSQLValueString($_POST['areapt'], "text"),
					   GetSQLValueString($_POST['clientept'], "text"),
                       GetSQLValueString($_POST['textopt'], "text"),
					   GetSQLValueString($_POST['titulofr'], "text"),
                       GetSQLValueString($_POST['areafr'], "text"),
					   GetSQLValueString($_POST['clientefr'], "text"),
                       GetSQLValueString($_POST['textofr'], "text"),
					   GetSQLValueString($_POST['tituloes'], "text"),
                       GetSQLValueString($_POST['areaes'], "text"),
					   GetSQLValueString($_POST['clientees'], "text"),
                       GetSQLValueString($_POST['textoes'], "text"),
					   GetSQLValueString($_POST['numimagens'], "text"),
					   GetSQLValueString($_POST['linkvimeo'], "text"),
					   GetSQLValueString($_POST['linkvimeo2'], "text"),
                       GetSQLValueString($_POST['linkyoutube'], "text"),
					   GetSQLValueString($_POST['ano'].$_POST['mes'].$_POST['dia'], "text"));
				

  mysql_select_db($database_formatoverde, $formatoverde);
  $Result1 = mysql_query($insertSQL, $formatoverde) or die(mysql_error());

  $insertGoTo = "portfolio.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<?php
if (isset($_POST['submit'])) {
$j = 0;     
if (!file_exists("../portfolio/".sprintf('%03d', mysql_insert_id())  )) {
    mkdir("../portfolio/".sprintf('%03d', mysql_insert_id()) , 0777, true);
}

for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
$target_path = "../portfolio/".sprintf('%03d', mysql_insert_id()) ."/";
$validextensions = array("jpeg", "jpg", "png");
$ext = explode('.', basename($_FILES['file']['name'][$i]));
$file_extension = end($ext);
$target_path = $target_path . ($i+1) . ".jpg";
$j = $j + 1;   
if (in_array($file_extension, $validextensions)) {
if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
echo $j. ').<span id="noerror">Image uploaded successfully!.</span><br/><br/>';
} else {  
echo $j. ').<span id="error">please try again!.</span><br/><br/>';
}
} else { 
echo $j. ').<span id="error">***Invalid file Size or Type***</span><br/><br/>';
}
}
}

$target_path = "../portfolio/".sprintf('%03d', mysql_insert_id()) ."/";
$target_path = $target_path.'main.jpg';
if(move_uploaded_file($_FILES['imagem']['tmp_name'], $target_path)){}
else{}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Back Office Formato Verde</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="jconfirmaction.jquery.js"></script>

<script type="text/javascript">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
	
	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<link rel="stylesheet" href="jquery-ui.css">
<script src="jquery-1.10.2.js"></script>
<script src="jquery-ui.js"></script>
<script>
var abc = 0;   
$(document).ready(function() {
$('#numimagens').attr('value', 0)
$('#add_more').click(function() {
$(this).before($("<div/>", {
id: 'filediv'
}).fadeIn('slow').append($("<input/>", {
name: 'file[]',
type: 'file',
id: 'file'
}), $("<br/><br/>")));
});

$('body').on('change', '#file', function() {
if (this.files && this.files[0]) {
abc += 1; 
var z = abc - 1;
var x = $(this).parent().find('#previewimg' + z).remove();
$(this).before("<div id='abcd" + abc + "' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");
var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);
$(this).hide();
$("#abcd" + abc).append($("<img/>", {
id: 'img',
src: 'images/trash.png',
alt: 'delete'
}).click(function() {
$(this).parent().parent().remove();
}));
}
});

function imageIsLoaded(e) {
$('#previewimg' + abc).attr('src', e.target.result);
};
$('#upload').click(function(e) {
var name = $(":file").val();
if (!name) {
alert("First Image Must Be Selected");
e.preventDefault();
}
});
});

  $(function() {
	   
    $( "#data" ).datepicker({
		onClose: function( selectedDate ) {

        	$('#dia').val( selectedDate.split(/\//)[1] ); // day
        	$('#mes').val( selectedDate.split(/\//)[0] ); // month
        	$('#ano').val( selectedDate.split(/\//)[2] ); // year
    }
		
		});
  });
  
function validar() {
  
    if ($("#data").val() =="") { 
			 alert("Por favor, insira uma data.");
			 return false;
	}
  return true;
}
</script>

<body>
<div class="header">
	<div class="header_login">
    	<div class="logo">
        	<a href="#"><img src="images/logofv.png" alt="" title="" border="0" /></a>
		</div>
    
    	<div class="right_header">
        	Bem-vindo! <a href="http://www.formatoverde.pt" target="_blank">Visita o site</a> | <a href="<?php echo $logoutAction ?>" class="logout">Logout</a>
		</div>
	</div>
</div>

<div id="main_container">
    
    <div class="main_content">
                    
    <div class="center_content">  
    
    <div class="left_content">
    		  		
            <div class="sidebarmenu">
            	<a class="menuitem" href="index.php">Home</a>
                <a class="menuitem" href="banners.php">Banners</a>
                <a class="menuitem" href="premios.php">Prémios</a>
                <a class="menuitem" href="portfolio.php">Portfólio</a>
                <a class="menuitem" href="frases.php">Frases Sensibilização</a>
                <a class="menuitem" href="areas.php">Áreas Temáticas</a>
                <a class="menuitem" href="mapa.php">Mapa</a>
                <a class="menuitem" href="redessociais.php">Redes Sociais</a>
                <a class="menuitem" href="contatos.php">Contactos</a>
      
            </div>
                    
    </div>   
          
         <div class="right_content">               
     
        <h1>Adicionar Projeto</h1>
        
        <div id="maindiv">
<div id="formdiv">
     
         <div class="form">
         <form action="<?php echo $editFormAction; ?>" method="POST" name="adprojeto" enctype="multipart/form-data" >
         
		 <h2>Data:</h2>
         <input type="text" class="datepicker" name="data" id="data">
         
         <input name="dia" id="dia" class="dia" type="hidden" value="" />
         <input name="mes" id="mes" class="mes" type="hidden" value="" />
         <input name="ano" id="ano" class="ano" type="hidden" value="" />
         
         <h2>Imagem de Capa do Projeto</h2>
         <input name="imagem" type="file" class="file" onchange="readURL(this);"/>
         <img id="blah" src=" " />
         <p>imagem .jpg</p>
         <h2>Imagens do Projeto</h2>
		 <div id="filediv"><input name="file[]" type="file" id="file"/></div>
		 <input type="button" id="add_more" class="upload" value="Adicionar Mais Imagens"/>
        
         <input name="numimagens" cols="50" id="numimagens" type="hidden">
         
         <div class="sep"></div>
         
         <h2>Inglês</h2>
         <p>titulo: </p>
         <textarea name="titulo" cols="50"> </textarea>
         <p>area:</p>
         <textarea name="area" cols="50"> </textarea>
         <p>cliente: </p>
         <textarea name="cliente" cols="50"> </textarea>
         <p>texto:</p>
         <textarea name="texto" cols="50"> </textarea>
         
         <div class="sep"></div>
         
         <h2>Português</h2>
         <p>titulo: </p>
         <textarea name="titulopt" cols="50"> </textarea>
         <p>area:</p>
         <textarea name="areapt" cols="50"> </textarea>
         <p>cliente: </p>
         <textarea name="clientept" cols="50"> </textarea>
         <p>texto:</p>
         <textarea name="textopt" cols="50"> </textarea>
         
         <div class="sep"></div>
         
         <h2>Espanhol</h2>
         <p>titulo: </p>
         <textarea name="tituloes" cols="50"> </textarea>
         <p>area:</p>
         <textarea name="areaes" cols="50"> </textarea>
         <p>cliente: </p>
         <textarea name="clientees" cols="50"> </textarea>
         <p>texto:</p>
         <textarea name="textoes" cols="50"> </textarea>
         
         <div class="sep"></div>
         
         <h2>Francês</h2>
         <p>titulo: </p>
         <textarea name="titulofr" cols="50"> </textarea>
         <p>area:</p>
         <textarea name="areafr" cols="50"> </textarea>
         <p>cliente: </p>
         <textarea name="clientefr" cols="50"> </textarea>
         <p>texto:</p>
         <textarea name="textofr" cols="50"> </textarea>
         
         <div class="sep"></div>
         
         <h2>Vídeos</h2>
         <p>Link 1:</p>
         <textarea name="linkvimeo" cols="50"> </textarea>
         <p>Link 2:</p>
         <textarea name="linkvimeo2" cols="50"> </textarea>
         <p>Link 3:</p>
         <textarea name="linkyoutube" cols="50"> </textarea>
         <input name="cod" type="hidden" value="" />
     
         <div class="sep"></div>
     
         <input type="submit" value="Adicionar" name="submit" id="upload" class="upload"/>
         <input type="hidden" name="MM_insert" value="adprojeto" />
         </form>
         </div>       
     
     </div>
</div>
     
     </div>
              
  </div>             
                    
    <div class="clear"></div>
    </div>

</div>

</body>
</html>