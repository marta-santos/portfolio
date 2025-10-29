<?php require_once('Connections/formatoverde.php'); 
clearstatcache();?>
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

$maxRows_banners = 5;
$pageNum_banners = 0;
if (isset($_GET['pageNum_banners'])) {
  $pageNum_banners = $_GET['pageNum_banners'];
}
$startRow_banners = $pageNum_banners * $maxRows_banners;



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editarvisibilidade")) {
  $updateSQL = sprintf("UPDATE etiqueta SET visivel=%s WHERE cod=%s",
                       GetSQLValueString($_POST['visibilidade'], "text"),
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




mysql_select_db($database_formatoverde, $formatoverde);
$query_banners = "SELECT * FROM etiqueta ORDER BY datatxt DESC";
$query_limit_banners = sprintf("%s LIMIT %d, %d", $query_banners, $startRow_banners, $maxRows_banners);
$banners = mysql_query($query_limit_banners, $formatoverde) or die(mysql_error());
$row_banners = mysql_fetch_assoc($banners);

if (isset($_GET['totalRows_banners'])) {
  $totalRows_banners = $_GET['totalRows_banners'];
} else {
  $all_banners = mysql_query($query_banners);
  $totalRows_banners = mysql_num_rows($all_banners);
}
$totalPages_banners = ceil($totalRows_banners/$maxRows_banners)-1;
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

       <h1>Banners</h1>
       
         <table width="625" border="0">
  							<tr>
    							<td width="400">
                                <div class="pagination">
      <?php if ($pageNum_banners > 0) { // Show if not first page ?>
  <a href="<?php printf("%s?pageNum_banners=%d%s", $currentPage, max(0, $pageNum_banners - 1), $queryString_banners); ?>"><< prev</a>
  <?php } // Show if not first page ?>
  <?php if ($pageNum_banners == 0) { // Show if first page ?>
    <span class="disabled"><< prev</span>
    <?php } // Show if first page ?>
    
    <?php 
	     for($i = 0; $i < $totalPages_banners + 1; $i++) {
			 if($pageNum_banners==($i)){?>
				 <span class="current"><?php echo $i+1; ?> </span>
				 <?php
				 }
			 else{
             echo "<a href='banners.php?pageNum_banners=$i'>".($i+1)."</a>";
			 }
        }
	?>  
    
<?php if ($pageNum_banners < $totalPages_banners) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_banners=%d%s", $currentPage, min($totalPages_banners, $pageNum_banners + 1), $queryString_banners); ?>">next >></a>
        <?php } // Show if not last page ?>
        <?php if ($pageNum_banners >= $totalPages_banners) { // Show if last page ?>
  <span class="disabled">next >></span>
  <?php } // Show if last page ?>
           </div>
       </td>
       <td width="150"><a href="adbanner.php" class="menuitem">Adicionar Banner</a></td>
					   </tr>
					</table>
       
      <table id="rounded-corner" width="550">
    <thead>
    	<tr>
        	<th width="20" class="rounded" scope="col"></th>
            <th width="450" class="rounded" scope="col">Título</th>
          <th width="450" class="rounded" scope="col">Data Início</th>
          <th width="450" class="rounded" scope="col">Data Fim</th>
        </tr>
    </thead>
        <tfoot>
    	<tr>
        	<td colspan="7" class="rounded-foot-left"></td>
        	</tr>
    </tfoot>
  
    <tbody>
          <?php do { ?>
    <tr>
    <td>
    
        <form action="<?php echo $editFormAction; ?>" method="POST" name="editarvisibilidade" enctype="multipart/form-data" >
     <input  id="visibilidade" name="visibilidade" type="hidden" value="<?php if($row_banners['visivel']==1){echo 0;} else{echo 1;}?>"/>
    <input type="image" src="images/<?php if($row_banners['visivel']==1){echo visivel;} else{echo invisivel;}?>.png" alt="Submit Form" class="visibilidade"/>
    <input name="cod" type="hidden" value="<?php echo $row_banners['cod']; ?>"/>
         <input type="hidden" name="MM_insert" value="editarvisibilidade" />
         <input type="hidden" name="MM_update" value="editarvisibilidade" />
    </form>
    
    
    <a href="editarbanner.php?cod=<?php echo $row_banners['cod']; ?>"><img src="images/user_edit.png" alt="" title="" border="0"/></a>
    <a  href="eliminarbanner.php?cod=<?php echo $row_banners['cod']; ?>"class="ask"><img src="images/trash.png" alt="" title="" border="0"/></a>
    </td>
 
    <td>
    <?php
    if($row_banners['imagem']==1){ ?>
        <img src="../etiqueta/<?php echo sprintf('%03d', $row_banners['cod'])?>.jpg" width="200"/>
		<?php
		}
	else{
		echo $row_banners['titulo'];		
		}
	?>

    </td>
    <td><?php echo $row_banners['diainicio'].'/'.$row_banners['mesinicio'].'/'.$row_banners['anoinicio']; ?></td>
    <td><?php echo $row_banners['diafim'].'/'.$row_banners['mesfim'].'/'.$row_banners['anofim']; ?></td>
    </tr>

          <?php } while ($row_banners = mysql_fetch_assoc($banners)); ?>
        
    </tbody>
</table>
     
     </div>
              
  </div>         
                    
    <div class="clear"></div>
    </div>
	
</div>
</body>
</html>
<?php
mysql_free_result($banners);
?>
