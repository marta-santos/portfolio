<?php require_once('Connections/formatoverde.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
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

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editarfrase")) {
  $updateSQL = sprintf("UPDATE banner SET titulo=%s, subtitulo=%s, titulopt=%s, subtitulopt=%s, tituloes=%s, subtituloes=%s, titulofr=%s, subtitulofr=%s WHERE cod=%s",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['subtitulo'], "text"),
					   GetSQLValueString($_POST['titulopt'], "text"),
                       GetSQLValueString($_POST['subtitulopt'], "text"),
					   GetSQLValueString($_POST['tituloes'], "text"),
                       GetSQLValueString($_POST['subtituloes'], "text"),
					   GetSQLValueString($_POST['titulofr'], "text"),
                       GetSQLValueString($_POST['subtitulofr'], "text"),
                       GetSQLValueString($_POST['cod'], "int"));

  mysql_select_db($database_formatoverde, $formatoverde);
  $Result1 = mysql_query($updateSQL, $formatoverde) or die(mysql_error());

  $updateGoTo = "frases.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_frase = "-1";
if (isset($_GET['cod'])) {
  $colname_frase = $_GET['cod'];
}
mysql_select_db($database_formatoverde, $formatoverde);
$query_frase = sprintf("SELECT * FROM banner WHERE cod = %s", GetSQLValueString($colname_frase, "int"));
$frase = mysql_query($query_frase, $formatoverde) or die(mysql_error());
$row_frase = mysql_fetch_assoc($frase);
$totalRows_frase = mysql_num_rows($frase);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>back office formato verde</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="jconfirmaction.jquery.js"></script>
<script type="text/javascript">
	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
	
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
    
     
        <h1>Editar Frase</h1>
       
     
         <div class="form">
         <form action="<?php echo $editFormAction; ?>" method="POST" name="editarfrase" enctype="multipart/form-data">
          <h2>Inglês</h2>
         <p>Frase: </p>
         <textarea name="titulo" cols="50"><?php echo $row_frase['titulo']; ?></textarea>
         <p>Fonte:</p>
         <textarea name="subtitulo" cols="50"><?php echo $row_frase['subtitulo']; ?></textarea>
         
         <div class="sep"></div>
         
                 <h2>Português</h2>
           <p>Frase: </p>
         <textarea name="titulopt" cols="50"><?php echo $row_frase['titulopt']; ?></textarea>
         <p>Fonte:</p>
         <textarea name="subtitulopt" cols="50"><?php echo $row_frase['subtitulopt']; ?></textarea>
         
         <div class="sep"></div>
         
                 <h2>Espanhol</h2>
           <p>Frase: </p>
         <textarea name="tituloes" cols="50"><?php echo $row_frase['tituloes']; ?></textarea>
         <p>Fonte:</p>
         <textarea name="subtituloes" cols="50"><?php echo $row_frase['subtituloes']; ?></textarea>
         
         <div class="sep"></div>
         
         <h2>Francês</h2>
         <p>Frase: </p>
         <textarea name="titulofr" cols="50"><?php echo $row_frase['titulofr']; ?></textarea>
         <p>Fonte:</p>
         <textarea name="subtitulofr" cols="50"><?php echo $row_frase['subtitulofr']; ?></textarea>
         
		 <input name="cod" type="hidden" value="<?php echo $row_frase['cod']; ?>"/>

		 <div class="sep"></div>

         <input name="contatos" type="submit" value="Guardar"/>
         <input type="hidden" name="MM_insert" value="editarfrase" />
         <input type="hidden" name="MM_update" value="editarfrase" />
         </form>
         </div>       
     
     </div><!-- end of right content-->
              
  </div>   <!--end of center content -->               
                    
    <div class="clear"></div>
    </div> <!--end of main content-->
	
    


</div>
</body>
</html>
<?php
mysql_free_result($frase);
?>
