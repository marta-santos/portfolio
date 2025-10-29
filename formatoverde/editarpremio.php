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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editarpremio")) {
  $updateSQL = sprintf("UPDATE premios SET titulo=%s, titulopt=%s, tituloes=%s, titulofr=%s, data=%s WHERE cod=%s",
                       GetSQLValueString($_POST['titulo'], "text"),
					   GetSQLValueString($_POST['titulopt'], "text"),
					   GetSQLValueString($_POST['tituloes'], "text"),
					   GetSQLValueString($_POST['titulofr'], "text"),
					   GetSQLValueString($_POST['ano'].$_POST['mes'].$_POST['dia'], "text"),
                       GetSQLValueString($_POST['cod'], "int"));

  mysql_select_db($database_formatoverde, $formatoverde);
  $Result1 = mysql_query($updateSQL, $formatoverde) or die(mysql_error());

  $updateGoTo = "premios.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_premio = "-1";
if (isset($_GET['cod'])) {
  $colname_premio = $_GET['cod'];
}
mysql_select_db($database_formatoverde, $formatoverde);
$query_premio = sprintf("SELECT * FROM premios WHERE cod = %s", GetSQLValueString($colname_premio, "int"));
$premio = mysql_query($query_premio, $formatoverde) or die(mysql_error());
$row_premio = mysql_fetch_assoc($premio);
$totalRows_premio = mysql_num_rows($premio);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Back Office Formato Verde</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="jconfirmaction.jquery.js"></script>
<script type="text/javascript">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
	
</script>
<link rel="stylesheet" href="jquery-ui.css">
<script src="jquery-1.10.2.js"></script>
<script src="jquery-ui.js"></script>
<script>
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
    
        <h1>Editar Prémio</h1>
       
         <div class="form">
         <form action="<?php echo $editFormAction; ?>" method="POST" name="editarpremio" enctype="multipart/form-data" onsubmit="return validar();">
         
                  <p>Data:</p>
         <input type="text" class="datepicker" name="data" id="data" value="<?php echo substr($row_premio['data'], 4, 2) ?>/<?php echo substr($row_premio['data'], 6, 2) ?>/<?php echo substr($row_premio['data'], 0, 4) ?>">
         
           <input name="dia" id="dia" class="dia" type="hidden" value="<?php echo substr($row_premio['data'], 6, 2) ?>" />
           <input name="mes" id="mes" class="mes" type="hidden" value="<?php echo substr($row_premio['data'], 4, 2) ?>" />
           <input name="ano" id="ano" class="ano" type="hidden" value="<?php echo substr($row_premio['data'], 0, 4) ?>" />
         
          <h2>Inglês</h2>
         <p>Frase: </p>
         <textarea name="titulo" cols="50"><?php echo $row_premio['titulo']; ?></textarea>
         
         <h2>Português</h2>
         <p>Frase: </p>
         <textarea name="titulopt" cols="50"><?php echo $row_premio['titulopt']; ?></textarea>
         
                 <h2>Espanhol</h2>
           <p>Frase: </p>
         <textarea name="tituloes" cols="50"><?php echo $row_premio['tituloes']; ?></textarea>
       
                 <h2>Francês</h2>
           <p>Frase: </p>
         <textarea name="titulofr" cols="50"><?php echo $row_premio['titulofr']; ?></textarea>
     
         
<input name="cod" type="hidden" value="<?php echo $row_premio['cod']; ?>"/>

<input name="contatos" type="submit" value="Guardar"/>
         <input type="hidden" name="MM_insert" value="editarpremio" />
         <input type="hidden" name="MM_update" value="editarpremio" />
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
mysql_free_result($premio);
?>
