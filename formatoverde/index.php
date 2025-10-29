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
    
    <div class="menuindex">
    		<a href="banners.php"><h1>Banners</h1></a>
            <div class="submenuindex">
      		<a href="adbanner.php"><h2>+ Adicionar Banner</h2></a>
            </div>
    </div>  
    <div class="menuindex">
    		<a href="premios.php"><h1>Prémios</h1></a>
            <div class="submenuindex">
      		<a href="adpremio.php"><h2>+ Adicionar Prémio</h2></a>
            </div>
    </div>      
    <div class="menuindex">
    		<a href="portfolio.php"><h1>Portfólio</h1></a>
            <div class="submenuindex">
      		<a href="adprojeto.php"><h2>+ Adicionar Projeto</h2></a>
            </div>
    </div>   
    <div class="menuindex">
    		<a href="frases.php"><h1>Frases Sensibilização</h1></a>
            <div class="submenuindex">
      		<a href="adfrase.php"><h2>+ Adicionar Frase</h2></a>
            </div>
    </div>
    <div class="menuindex">
    		<a href="areas.php"><h1>Áreas Temáticas</h1></a>
            <div class="submenuindex">
      		<a href="adarea.php"><h2>+ Adicionar Área</h2></a>
            </div>
    </div>
    <div class="menuindex">
    		<a href="mapa.php"><h1>Mapa</h1></a>
            <div class="submenuindex">
      		<a href="adetiqueta.php"><h2>+ Adicionar Etiqueta</h2></a>
            </div>
    </div>
    <div class="menuindex">
    		<a href="redessociais.php"><h1>Redes Sociais</h1></a>
            <div class="submenuindex">
      		<a href="adrede.php"><h2>+ Adicionar Rede</h2></a>
            </div>
    </div>
    <div class="menuindex">
    		<a href="contatos.php"><h1>Contactos</h1></a>
            <div class="submenuindex">
      		<a href="adcontato.php"><h2>+ Adicionar Contato</h2></a>
            </div>
    </div>     
              
  </div>             
                    
    <div class="clear"></div>
</div>
	
</div>
</body>
</html>
