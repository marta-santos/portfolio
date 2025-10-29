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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editaretiqueta")) {
  $updateSQL = sprintf("UPDATE etiquetasmapa SET posX=%s, posY=%s, tipo=%s, titulo=%s, entidade=%s, texto=%s, extra=%s, entidade2=%s, texto2=%s, entidade3=%s, texto3=%s, titulopt=%s, entidadept=%s, textopt=%s, extrapt=%s, entidade2pt=%s, texto2pt=%s, entidade3pt=%s, texto3pt=%s, tituloes=%s, entidadees=%s, textoes=%s, extraes=%s, entidade2es=%s, texto2es=%s, entidade3es=%s, texto3es=%s, titulofr=%s, entidadefr=%s, textofr=%s, extrafr=%s, entidade2fr=%s, texto2fr=%s, entidade3fr=%s, texto3fr=%s WHERE cod=%s",
                       GetSQLValueString($_POST['form_x'], "text"),
                       GetSQLValueString($_POST['form_y'], "text"),
					   GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['titulo'], "text"),
					   GetSQLValueString($_POST['entidade'], "text"),
                       GetSQLValueString($_POST['texto'], "text"),
					   GetSQLValueString($_POST['extra'], "text"),
					   GetSQLValueString($_POST['entidade2'], "text"),
                       GetSQLValueString($_POST['texto2'], "text"),
					   GetSQLValueString($_POST['entidade3'], "text"),
                       GetSQLValueString($_POST['texto3'], "text"),
                       GetSQLValueString($_POST['titulopt'], "text"),
					   GetSQLValueString($_POST['entidadept'], "text"),
					   GetSQLValueString($_POST['textopt'], "text"),
					   GetSQLValueString($_POST['extrapt'], "text"),
					   GetSQLValueString($_POST['entidade2pt'], "text"),
                       GetSQLValueString($_POST['texto2pt'], "text"),
					   GetSQLValueString($_POST['entidade3pt'], "text"),
                       GetSQLValueString($_POST['texto3pt'], "text"),
					   GetSQLValueString($_POST['tituloes'], "text"),
					   GetSQLValueString($_POST['entidadees'], "text"),
					   GetSQLValueString($_POST['textoes'], "text"),
					   GetSQLValueString($_POST['extraes'], "text"),
					   GetSQLValueString($_POST['entidade2es'], "text"),
                       GetSQLValueString($_POST['texto2es'], "text"),
					   GetSQLValueString($_POST['entidade3es'], "text"),
                       GetSQLValueString($_POST['texto3es'], "text"),
					   GetSQLValueString($_POST['titulofr'], "text"),
					   GetSQLValueString($_POST['entidadefr'], "text"),
					   GetSQLValueString($_POST['textofr'], "text"),
					   GetSQLValueString($_POST['extrafr'], "text"),
					   GetSQLValueString($_POST['entidade2fr'], "text"),
                       GetSQLValueString($_POST['texto2fr'], "text"),
					   GetSQLValueString($_POST['entidade3fr'], "text"),
                       GetSQLValueString($_POST['texto3fr'], "text"),
                       GetSQLValueString($_POST['cod'], "int"));

  mysql_select_db($database_formatoverde, $formatoverde);
  $Result1 = mysql_query($updateSQL, $formatoverde) or die(mysql_error());

  $updateGoTo = "mapa.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_etiqueta = "-1";
if (isset($_GET['cod'])) {
  $colname_etiqueta = $_GET['cod'];
}
mysql_select_db($database_formatoverde, $formatoverde);
$query_etiqueta = sprintf("SELECT * FROM etiquetasmapa WHERE cod = %s", GetSQLValueString($colname_etiqueta, "int"));
$etiqueta = mysql_query($query_etiqueta, $formatoverde) or die(mysql_error());
$row_etiqueta = mysql_fetch_assoc($etiqueta);
$totalRows_etiqueta = mysql_num_rows($etiqueta);
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
		
		pos_x = <?php echo $row_etiqueta['posX']; ?>;
		pos_y = <?php echo $row_etiqueta['posY']; ?>;
		$("#cross").css( {position:"absolute", top:(pos_y-5), left: (pos_x-3)});
		document.getElementById("cross").style.visibility = "visible" ;
	});
	
</script>

<script language="JavaScript">
function point_it(event){
	pos_x = event.offsetX?(event.offsetX):event.pageX-document.getElementById("pointer_div").offsetLeft;
	pos_y = event.offsetY?(event.offsetY):event.pageY-document.getElementById("pointer_div").offsetTop;
	$("#cross").css( {position:"absolute", top:(pos_y-5), left: (pos_x-3)});
	document.getElementById("cross").style.visibility = "visible" ;
	document.editaretiqueta.form_x.value = pos_x;
	document.editaretiqueta.form_y.value = pos_y;
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
     
        <h1>Editar Etiqueta</h1>  
     
         <div class="form">
         <form action="<?php echo $editFormAction; ?>" method="POST" name="editaretiqueta" enctype="multipart/form-data">
         
         <p>Marque o ponto no mapa:</p>
         
         	<div id="pointer_div" onclick="point_it(event)" style="position:relative; background-image:url('images/mapa.png'); width:625px; height:321px; background-size:100%;">

<div class="map-point" id="cross" style="position:relative;visibility:hidden;z-index:2;"></div>
			</div>
		<input type="hidden" name="form_x" size="4" value="<?php echo $row_etiqueta['posX']; ?>"/>
		<input type="hidden" name="form_y" size="4" value="<?php echo $row_etiqueta['posY']; ?>"/>
 
         <p>Tipo de etiqueta:</p>
         <select name="tipo">
         	<option value="0" <?php echo ($row_etiqueta['tipo'] == 0)?"selected":""; ?>>Projetos</option>
         	<option value="1" <?php echo ($row_etiqueta['tipo'] == 1)?"selected":""; ?>>Representação</option>
         </select>
         
            <div class="sep"></div>
               
         <h2>Inglês</h2>
         
         <p>Título:</p>
         <textarea name="titulo" cols="80"><?php echo $row_etiqueta['titulo']; ?></textarea> 
		 <p>Entidade:</p>
		 <textarea name="entidade" cols="80"><?php echo $row_etiqueta['entidade']; ?></textarea>
         <p>Texto:</p>
		 <textarea name="texto" cols="80" rows="5"><?php echo $row_etiqueta['texto']; ?></textarea>
         <p>Extra:</p>
         <textarea name="extra" cols="80"><?php echo $row_etiqueta['extra']; ?></textarea>
         <p>Entidade 2:</p>
		 <textarea name="entidade2" cols="80"><?php echo $row_etiqueta['entidade2']; ?></textarea>
         <p>Texto 2:</p>
		 <textarea name="texto2" cols="80" rows="5"><?php echo $row_etiqueta['texto2']; ?></textarea>
         <p>Entidade 3:</p>
		 <textarea name="entidade3" cols="80"><?php echo $row_etiqueta['entidade3']; ?></textarea>
         <p>Texto 3:</p>
		 <textarea name="texto3" cols="80" rows="5"><?php echo $row_etiqueta['texto3']; ?></textarea>
         
            <div class="sep"></div>
  
         <h2>Português</h2>
         <p>Título:</p>
         <textarea name="titulopt" cols="80"><?php echo $row_etiqueta['titulopt']; ?></textarea> 
		 <p>Entidade:</p>
		 <textarea name="entidadept" cols="80"><?php echo $row_etiqueta['entidadept']; ?></textarea>
         <p>Texto:</p>
		 <textarea name="textopt" cols="80"><?php echo $row_etiqueta['textopt']; ?></textarea>
         <p>Extra:</p>
         <textarea name="extrapt" cols="80"><?php echo $row_etiqueta['extrapt']; ?></textarea> 
         <p>Entidade 2:</p>
		 <textarea name="entidade2pt" cols="80"><?php echo $row_etiqueta['entidade2pt']; ?></textarea>
         <p>Texto 2:</p>
		 <textarea name="texto2pt" cols="80" rows="5"><?php echo $row_etiqueta['texto2pt']; ?></textarea>
         <p>Entidade 3:</p>
		 <textarea name="entidade3pt" cols="80"><?php echo $row_etiqueta['entidade3pt']; ?></textarea>
         <p>Texto 3:</p>
		 <textarea name="texto3pt" cols="80" rows="5"><?php echo $row_etiqueta['texto3pt']; ?></textarea>
         
            <div class="sep"></div>
         
         <h2>Espanhol</h2>
         <p>Título:</p>
         <textarea name="tituloes" cols="80"><?php echo $row_etiqueta['tituloes']; ?></textarea> 
		 <p>Entidade:</p>
		 <textarea name="entidadees" cols="80"><?php echo $row_etiqueta['entidadees']; ?></textarea>
         <p>Texto:</p>
		 <textarea name="textoes" cols="80"><?php echo $row_etiqueta['textoes']; ?></textarea>
         <p>Extra:</p>
         <textarea name="extraes" cols="80"><?php echo $row_etiqueta['extraes']; ?></textarea> 
         <p>Entidade 2:</p>
		 <textarea name="entidade2es" cols="80"><?php echo $row_etiqueta['entidade2es']; ?></textarea>
         <p>Texto 2:</p>
		 <textarea name="texto2es" cols="80" rows="5"><?php echo $row_etiqueta['texto2es']; ?></textarea>
         <p>Entidade 3:</p>
		 <textarea name="entidade3es" cols="80"><?php echo $row_etiqueta['entidade3es']; ?></textarea>
         <p>Texto 3:</p>
		 <textarea name="texto3es" cols="80" rows="5"><?php echo $row_etiqueta['texto3es']; ?></textarea>
         
            <div class="sep"></div>
         
         <h2>Francês</h2>
         <p>Título:</p>
         <textarea name="titulofr" cols="80"><?php echo $row_etiqueta['titulofr']; ?></textarea> 
		 <p>Entidade:</p>
		 <textarea name="entidadefr" cols="80"><?php echo $row_etiqueta['entidadefr']; ?></textarea>
         <p>Texto:</p>
		 <textarea name="textofr" cols="80"><?php echo $row_etiqueta['textofr']; ?></textarea>
         <p>Extra:</p>
         <textarea name="extrafr" cols="80"><?php echo $row_etiqueta['extrafr']; ?></textarea> 
         <p>Entidade 2:</p>
		 <textarea name="entidade2fr" cols="80"><?php echo $row_etiqueta['entidade2fr']; ?></textarea>
         <p>Texto 2:</p>
		 <textarea name="texto2fr" cols="80" rows="5"><?php echo $row_etiqueta['texto2fr']; ?></textarea>
         <p>Entidade 3:</p>
		 <textarea name="entidade3fr" cols="80"><?php echo $row_etiqueta['entidade3fr']; ?></textarea>
         <p>Texto 3:</p>
		 <textarea name="texto3fr" cols="80" rows="5"><?php echo $row_etiqueta['texto3fr']; ?></textarea>
         
		 <input name="cod" type="hidden" value="<?php echo $row_etiqueta['cod']; ?>"/>
         
            <div class="sep"></div>

		 <input name="contatos" type="submit" value="Guardar"/>
         <input type="hidden" name="MM_insert" value="editaretiqueta" />
         <input type="hidden" name="MM_update" value="editaretiqueta" />
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
mysql_free_result($etiqueta);
?>
