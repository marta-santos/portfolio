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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editarprojeto")) {
  $updateSQL = sprintf("UPDATE portfolio SET titulo=%s, area=%s, cliente=%s, texto=%s, titulopt=%s, areapt=%s, clientept=%s, textopt=%s, titulofr=%s, areafr=%s, clientefr=%s, textofr=%s, tituloes=%s, areaes=%s, clientees=%s, textoes=%s, numimagens=%s, linkvimeo=%s, linkvimeo2=%s, linkyoutube=%s, data=%s WHERE cod=%s",
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
					   GetSQLValueString($_POST['valorcoisa'], "text"),
                       GetSQLValueString($_POST['linkvimeo'], "text"),
					   GetSQLValueString($_POST['linkvimeo2'], "text"),
					   GetSQLValueString($_POST['linkyoutube'], "text"),
					   GetSQLValueString($_POST['ano'].$_POST['mes'].$_POST['dia'], "text"),
                       GetSQLValueString($_POST['cod'], "int"));

  mysql_select_db($database_formatoverde, $formatoverde);
  $Result1 = mysql_query($updateSQL, $formatoverde) or die(mysql_error());

  $updateGoTo = "portfolio.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_projeto = "-1";
if (isset($_GET['cod'])) {
  $colname_projeto = $_GET['cod'];
}
mysql_select_db($database_formatoverde, $formatoverde);
$query_projeto = sprintf("SELECT * FROM portfolio WHERE cod = %s", GetSQLValueString($colname_projeto, "int"));
$projeto = mysql_query($query_projeto, $formatoverde) or die(mysql_error());
$row_projeto = mysql_fetch_assoc($projeto);
$totalRows_projeto = mysql_num_rows($projeto);

if (isset($_POST['submit'])) {
	
$j = 0;

for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
$target_path = "../portfolio/".sprintf('%03d', $row_projeto['cod']) ."/";   
$validextensions = array("jpeg", "jpg", "png");    
$ext = explode('.', basename($_FILES['file']['name'][$i]));  
$file_extension = end($ext); 
$target_path = $target_path . uniqid('MyApp', true) . "." . $ext[count($ext) - 1];  
$j = $j + 1;      
if (($_FILES["file"]["size"][$i] < 100000) 
&& in_array($file_extension, $validextensions)) {
if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
echo $j. ').<span id="noerror">Image uploaded successfully!.</span><br/><br/>';
sequentialImages("../portfolio/".sprintf('%03d', $row_projeto['cod']) ."/");
} else {   
echo $j. ').<span id="error">please try again!.</span><br/><br/>';
}
} else {   
echo $j. ').<span id="error">***Invalid file Size or Type***</span><br/><br/>';
}
}

$target_path = "../portfolio/".sprintf('%03d', $row_projeto['cod']) ."/";
$target_path = $target_path.'main.jpg';
if(move_uploaded_file($_FILES['imagem']['tmp_name'], $target_path)){}
else{}

$i=0;
$array = array_filter(glob("../portfolio/".sprintf('%03d', $row_projeto['cod']) ."/*.jpg") ,"is_file");
foreach ($array as $f){
    ++$i;
}
$testesol =  $i;

$i=0;
$array = array_filter(glob("../portfolio/".sprintf('%03d', $row_projeto['cod']) ."/*.jpg") ,"is_file");
foreach ($array as $f){
	if($f=="../portfolio/".sprintf('%03d', $row_projeto['cod']) ."/main.jpg"){
		}
	else{
    rename($f, "../portfolio/".sprintf('%03d', $row_projeto['cod']) ."/". ++$i .".jpg");
		}
}

}

/*------------------*/
function sequentialImages($target_path) {
 $i = 1;
 $files = glob($target_path."{*.gif,*.jpg,*.jpeg,*.png}",GLOB_BRACE|GLOB_NOSORT);
 $count = count($files);
 foreach ( $files as $file ) {
  $newname = str_pad($i, strlen($count)+1, '0', STR_PAD_LEFT);
  $ext = substr(strrchr($file, '.'), 1);
  $newname = $path.'/'.$newname.'.'.$ext;
  if ( $file != $newname ) {
   rename($file, $newname);  
  }
  $i++;
 }
}
/*------------------*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Back Office Formato Verde</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
var coisa = <?php echo $row_projeto['numimagens'];?>;
var abc = 0;     
$(document).ready(function() {
$('#valorcoisa').attr('value', coisa)
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
	coisa = coisa - 1;
	$('#valorcoisa').attr('value', coisa)
$(this).parent().parent().remove();
}));
}
});

function imageIsLoaded(e) {
	coisa = coisa + 1;
	$('#valorcoisa').attr('value', coisa)
$('#previewimg' + abc).attr('src', e.target.result);
};
$('#upload').click(function(e) {
var name = $(":file").val();

});

$(".testeimg").append($("<img/>", {
id: 'img',
src: 'images/trash.png',
alt: 'delete'
}).click(function() {
$(this).parent().remove();
deleteImage($(this).parent().attr('id'));
}));
});

function deleteImage($file)
{
    var r = confirm("Are you sure you want to delete this Image?")
    if(r == true)
    {
		coisa = coisa - 1;
		$('#valorcoisa').attr('value', coisa)
        $.ajax({
          url: 'deleteimage.php',
          data: {'file' : $file},
          success: function (response) {
          },
          error: function () {
          }
        });
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
     
        <h1>Editar Projeto</h1>
        
                <div id="maindiv">
<div id="formdiv">
       
         <div class="form">
         <form action="<?php echo $editFormAction; ?>" method="POST" name="editarprojeto" enctype="multipart/form-data">
         
         <p>Data:</p>
         <input type="text" class="datepicker" name="data" id="data" value="<?php echo substr($row_projeto['data'], 4, 2) ?>/<?php echo substr($row_projeto['data'], 6, 2) ?>/<?php echo substr($row_projeto['data'], 0, 4) ?>">
         
           <input name="dia" id="dia" class="dia" type="hidden" value="<?php echo substr($row_projeto['data'], 6, 2) ?>" />
           <input name="mes" id="mes" class="mes" type="hidden" value="<?php echo substr($row_projeto['data'], 4, 2) ?>" />
           <input name="ano" id="ano" class="ano" type="hidden" value="<?php echo substr($row_projeto['data'], 0, 4) ?>" />
         
         
         <input  id="valorcoisa" name="valorcoisa" type="hidden"/>
         <input name="numimagens" type="hidden" id="numimages" value="<?php echo $row_projeto['numimagens']; ?>" size="50" />
         
         <h2>Imagem de Capa do Projeto</h2>
         </br>
         <img id="blah" src="../portfolio/<?php echo sprintf('%03d', $row_projeto['cod']); ?>/main.jpg" width="200"/>
         <p>Selecionar nova imagem de capa:</p>
         <input name="imagem" type="file" class="file" onchange="readURL(this);"/>
         
         <h2>Imagens do Projeto</h2>
         <?php 
         $directory = "../portfolio/".sprintf('%03d', $row_projeto['cod'])."/";
		 $images = glob($directory . "*");

		 for($i=0; $i<$row_projeto['numimagens']; $i++)
			{?>
            <div class="testeimg" id="<?php	echo $directory;?><?php echo ($i+1) ?>.jpg">
                <img src="<?php	echo $directory;?><?php echo ($i+1) ?>.jpg" width="190" id="imagem"/>
            </div> 
	<?php   } ?>
    
		 <div id="filediv"><input name="file[]" type="file" id="file"/></div>
		 <input type="button" id="add_more" class="upload" value="Add More Files"/>  
        
        <div class="sep"></div>    
    
          <h2>Inglês</h2>
         <p>titulo: </p>
         <textarea name="titulo" cols="50"><?php echo $row_projeto['titulo']; ?></textarea>
         <p>area:</p>
         <textarea name="area" cols="50"><?php echo $row_projeto['area']; ?></textarea>
         <p>cliente: </p>
         <textarea name="cliente" cols="50"><?php echo $row_projeto['cliente']; ?></textarea>
         <p>texto:</p>
         <textarea name="texto" cols="50"><?php echo $row_projeto['texto']; ?></textarea>
         
         <div class="sep"></div>
         
                 <h2>Português</h2>
         <p>titulo: </p>
         <textarea name="titulopt" cols="50"><?php echo $row_projeto['titulopt']; ?></textarea>
         <p>area:</p>
         <textarea name="areapt" cols="50"><?php echo $row_projeto['areapt']; ?></textarea>
         <p>cliente: </p>
         <textarea name="clientept" cols="50"><?php echo $row_projeto['clientept']; ?></textarea>
         <p>texto:</p>
         <textarea name="textopt" cols="50"><?php echo $row_projeto['textopt']; ?></textarea>
         
         <div class="sep"></div>
         
                 <h2>Espanhol</h2>
         <p>titulo: </p>
         <textarea name="tituloes" cols="50"><?php echo $row_projeto['tituloes']; ?></textarea>
         <p>area:</p>
         <textarea name="areaes" cols="50"><?php echo $row_projeto['areaes']; ?></textarea>
         <p>cliente: </p>
         <textarea name="clientees" cols="50"><?php echo $row_projeto['clientees']; ?></textarea>
         <p>texto:</p>
         <textarea name="textoes" cols="50"><?php echo $row_projeto['textoes']; ?></textarea>
         
         <div class="sep"></div>
         
                 <h2>Francês</h2>
         <p>titulo: </p>
         <textarea name="titulofr" cols="50"><?php echo $row_projeto['titulofr']; ?></textarea>
         <p>area:</p>
         <textarea name="areafr" cols="50"><?php echo $row_projeto['areafr']; ?></textarea>
         <p>cliente: </p>
         <textarea name="clientefr" cols="50"><?php echo $row_projeto['clientefr']; ?></textarea>
         <p>texto:</p>
         <textarea name="textofr" cols="50"><?php echo $row_projeto['textofr']; ?></textarea>
         
     <div class="sep"></div>
         
         <h2>Vídeos</h2>
         <p>Link 1:</p>
         <textarea name="linkvimeo" cols="50"><?php echo $row_projeto['linkvimeo']; ?></textarea>
         <p>Link 2:</p>
         <textarea name="linkvimeo2" cols="50"><?php echo $row_projeto['linkvimeo2']; ?></textarea>
         <p>Link 3:</p>
         <textarea name="linkyoutube" cols="50"><?php echo $row_projeto['linkyoutube']; ?></textarea>
<input name="cod" type="hidden" value="<?php echo $row_projeto['cod']; ?>"/>


<div class="sep"></div>
  <input type="submit" value="Guardar" name="submit" id="upload" class="upload"/>
         <input type="hidden" name="MM_insert" value="editarprojeto" />
         <input type="hidden" name="MM_update" value="editarprojeto" />
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
<?php
mysql_free_result($projeto);
?>
