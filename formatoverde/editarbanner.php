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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editarbanner")) {
  $updateSQL = sprintf("UPDATE etiqueta SET titulo=%s, data=%s, texto=%s, titulofr=%s, datafr=%s, textofr=%s, tituloes=%s, dataes=%s, textoes=%s, titulopt=%s, datapt=%s, textopt=%s, diainicio=%s, mesinicio=%s, anoinicio=%s, diafim=%s, mesfim=%s, anofim=%s, datatxt=%s, imagem=%s, link=%s WHERE cod=%s",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['data'], "text"),
					   GetSQLValueString($_POST['texto'], "text"),
                       GetSQLValueString($_POST['titulofr'], "text"),
					   GetSQLValueString($_POST['datafr'], "text"),
                       GetSQLValueString($_POST['textofr'], "text"),
					   GetSQLValueString($_POST['tituloes'], "text"),
					   GetSQLValueString($_POST['dataes'], "text"),
					   GetSQLValueString($_POST['textoes'], "text"),
					   GetSQLValueString($_POST['titulopt'], "text"),
					   GetSQLValueString($_POST['datapt'], "text"),
					   GetSQLValueString($_POST['textopt'], "text"),
					   GetSQLValueString($_POST['diainicio'], "text"),
					   GetSQLValueString($_POST['mesinicio'], "text"),
					   GetSQLValueString($_POST['anoinicio'], "text"),
					   GetSQLValueString($_POST['diafim'], "text"),
					   GetSQLValueString($_POST['mesfim'], "text"),
					   GetSQLValueString($_POST['anofim'], "text"),
					   GetSQLValueString($_POST['anoinicio'].$_POST['mesinicio'].$_POST['diainicio'], "text"),
					   GetSQLValueString($_POST['imagem2'], "text"),
                       GetSQLValueString($_POST['link'], "text"),
                       GetSQLValueString($_POST['cod'], "int"));

  mysql_select_db($database_formatoverde, $formatoverde);
  $Result1 = mysql_query($updateSQL, $formatoverde) or die(mysql_error());

  $updateGoTo = "banners.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_banner = "-1";
if (isset($_GET['cod'])) {
  $colname_banner = $_GET['cod'];
}
mysql_select_db($database_formatoverde, $formatoverde);
$query_banner = sprintf("SELECT * FROM etiqueta WHERE cod = %s", GetSQLValueString($colname_banner, "int"));
$banner = mysql_query($query_banner, $formatoverde) or die(mysql_error());
$row_banner = mysql_fetch_assoc($banner);
$totalRows_banner = mysql_num_rows($banner);

$target_path = "../etiqueta/";
	$target_path = $target_path.sprintf('%03d', $_POST['cod']).'.jpg';
	if(move_uploaded_file($_FILES['imagem']['tmp_name'], $target_path)){}
	else{}

$datainicio = $row_banner['diainicio'].'/'.$row_banner['mesinicio'].'/'.$row_banner['anoinicio'];
$datafim = $row_banner['diafim'].'/'.$row_banner['mesfim'].'/'.$row_banner['anofim'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Back Office Formato Verde</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="jconfirmaction.jquery.js"></script>
<link rel="stylesheet" href="jquery-ui.css">
<script src="jquery-1.10.2.js"></script>
<script src="jquery-ui.js"></script>
<script type="text/javascript">
$(function() {

    $( "#inicio" ).datepicker(
	{
		 onClose: function( selectedDate ) {

        $('#diainicio').val( selectedDate.split(/\//)[1] ); // day
        $('#mesinicio').val( selectedDate.split(/\//)[0] ); // month
        $('#anoinicio').val( selectedDate.split(/\//)[2] ); // year
    }
		
		});
	$( "#fim" ).datepicker({
		 onClose: function( selectedDate ) {

        $('#diafim').val( selectedDate.split(/\//)[1] ); // day
        $('#mesfim').val( selectedDate.split(/\//)[0] ); // month
        $('#anofim').val( selectedDate.split(/\//)[2] ); // year
    }
		
		});
  });
  
function validar() {
  
    if ($("#inicio").val() =="") { 
			 alert("Por favor, insira uma data de ínicio.");
			 return false;
	}
	if ($("#fim").val() =="") { 
			 alert("Por favor, insira uma data de fim.");
			 return false;
	}
  return true;
}

	
	$(document).ready(function() {
		$('.ask').jConfirmAction();	
	
	});
	
	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
				$('#imagem2')
					.attr('value', 1)
                $('#blah')
                    .attr('src', e.target.result)
					.attr('style', 'visibility: visible')
                    .width(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
	
	function eliminarimagem(){
		$teste = 0;
		$('#imagem2')
			.attr('value', 0);
		$('#blah')
             .attr('src', '')
			 .attr('style', 'visibility: hidden');
		$('.file')
			.attr('value', '');
		}
	
</script>

</head>
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
    
        <h1>Editar Banner</h1>
         
         <div class="form">
         <form action="<?php echo $editFormAction; ?>" method="POST" name="editarbanner" enctype="multipart/form-data">
                  
<table width="625" border="0">
  <tr>
    <td> 
    <h2>Data início:</h2>
            <input type="text" class="datepicker" name="datainicio" id="inicio" value="<?php echo $datainicio ?>">
            <input name="diainicio" id="diainicio" class="dia" type="hidden" value="<?php echo $row_banner['diainicio']; ?>" />
            <input name="mesinicio" id="mesinicio" class="mes" type="hidden" value="<?php echo $row_banner['mesinicio']; ?>" />
            <input name="anoinicio" id="anoinicio" class="ano" type="hidden" value="<?php echo $row_banner['anoinicio']; ?>" />
    </td>
    <td>       
    <h2>Data fim:</h2>
            <input type="text" class="datepicker" name="datafim" id="fim"  value="<?php echo $datafim ?>">
            <input name="diafim" id="diafim" class="dia" type="hidden" value="<?php echo $row_banner['diafim']; ?>" />
            <input name="mesfim" id="mesfim" class="mes" type="hidden" value="<?php echo $row_banner['mesfim']; ?>" />
            <input name="anofim" id="anofim" class="ano" type="hidden" value="<?php echo $row_banner['anofim']; ?>" /></td>
  </tr>
</table>
  			<h2>Imagem:</h2>
            <input name="imagem2" cols="80" id="imagem2" value="<?php echo $row_banner['imagem']; ?>" type="hidden">
            <input name="imagem" type="file" class="file" onchange="readURL(this);" value=""/>
                		
<img id="blah" src="<?php  if($row_banner['imagem']==1){?>../etiqueta/<?php echo $row_banner['cod']; ?>.jpg   <?php } else{?> <?php }?>" width="200"/>
      
                <p>Eliminar Imagem:</p>
    			<img src="images/trash.png" alt="" title="" border="0" onclick="eliminarimagem()"/>
               
            	<p>Link:</p>
         		<textarea name="link" cols="80"><?php echo $row_banner['link']; ?></textarea>
                
            <div class="sep"></div>
                
			<h2>Inglês</h2>
         		<p>Título:</p>
         		<textarea name="titulo" cols="80"><?php echo $row_banner['titulo']; ?></textarea>    
		 		<p>Data:</p>
		 		<textarea name="data" cols="80"><?php echo $row_banner['data']; ?></textarea>
   				<p>Texto:</p>
         		<textarea name="texto" cols="80"><?php echo $row_banner['texto']; ?></textarea> 
                
                            <div class="sep"></div>
                
			<h2>Português</h2>
		 		<p>Título:</p>
		 		<textarea name="titulopt" cols="80"><?php echo $row_banner['titulopt']; ?></textarea>
        		<p>Data:</p>
		 		<textarea name="datapt" cols="80"><?php echo $row_banner['datapt']; ?></textarea>
   				<p>Texto:</p>
         		<textarea name="textopt" cols="80"><?php echo $row_banner['textopt']; ?></textarea> 
                
                            <div class="sep"></div>
                
            <h2>Espanhol</h2>
		 		<p>Título:</p>
		 		<textarea name="tituloes" cols="80"><?php echo $row_banner['tituloes']; ?></textarea>
        		<p>Data:</p>
		 		<textarea name="dataes" cols="80"><?php echo $row_banner['dataes']; ?></textarea>
   				<p>Texto:</p>
         		<textarea name="textoes" cols="80"><?php echo $row_banner['textoes']; ?></textarea>
                
                            <div class="sep"></div>
                 
            <h2>Francês</h2>
		 		<p>Título:</p>
		 		<textarea name="titulofr" cols="80"><?php echo $row_banner['titulofr']; ?></textarea>
        		<p>Data:</p>
		 		<textarea name="datafr" cols="80"><?php echo $row_banner['datafr']; ?></textarea>
   				<p>Texto:</p>
         		<textarea name="textofr" cols="80"><?php echo $row_banner['textofr']; ?></textarea>  
                
                            <div class="sep"></div>
         
		 <input name="cod" type="hidden" value="<?php echo $row_banner['cod']; ?>"/>
		 <input name="contatos" type="submit" value="Guardar"/>
         <input type="hidden" name="MM_insert" value="editarbanner" />
         <input type="hidden" name="MM_update" value="editarbanner" />
         </form>
         </div>       
     
     </div>
              
  </div>               
                    
    <div class="clear"></div>
    </div> 
	
</div>
</body>
</html>
<?php
mysql_free_result($banner);
?>
