<?php require_once('formatoverde.php'); ?>
<?php header('Content-Type: text/html; charset=ISO-8859-15');
clearstatcache(); ?>


<?php

	include("apagar.php");
	include("visivel.php");
	include("inserirnovo.php");
	include("zip.php");
	include("apagarimagens.php");
	include("update.php");

	
	

mysql_select_db("personal_trip",($formatoverde)) ;
$result = mysql_query("SELECT * FROM porfolio ");
$nu=mysql_num_rows($result)
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	
	<!-/////////////JQUERY//////////////////-!>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
	<!-/////////////JQUERY//////////////////-!>
	
	<link rel="stylesheet" href="flama/stylesheet.css" type="text/css" charset="utf-8" />
	<link href='http://fonts.googleapis.com/css?family=Roboto:200,300,400,500,600,700,800' rel='stylesheet' type='text/css'>

<head>

<style>
		
body{
	font-family: 'Dosis', sans-serif;		
	font-size: 13px;
	margin: 0px;
	padding: 0px;
	line-height: 17px;
	font-weight: 300;
	}
		

.inserirnovo{
	background-color: #7ec64a;
	width: 150px;
	padding:10px;
	height:20px;
	float: right;
	color: #ffffff;
	border-radius: 2px;
	margin: 10px;
	letter-spacing: 0px;
	font-size: 14px;
	text-align: center;
	font-weight: 400;
	margin: 20px;
	margin-top: 0px;
	margin-right: 30px;
	cursor:pointer;
	}
	
.inserirnovo2{
	background-color: #7ec64a;
	width: 150px;
	padding:10px;
	height:20px;
	float: right;
	color: #ffffff;
	border-radius: 2px;
	margin: 10px;
	letter-spacing: 0px;
	font-size: 14px;
	text-align: center;
	font-weight: 400;
	margin: 20px;
	margin-top: 0px;
	margin-right: 0px;
	cursor:pointer;
	}
		
		
.inserirnovo3{
	width: auto;
	padding:10px;
	height:20px;
	float: left;
	color: #ffffff;
	letter-spacing: 0px;
	font-size: 18px;
	text-align: center;
	font-weight: 300;
	margin: 20px;
	margin-top: 0px;
	cursor:pointer;
	}	
			

.inserirnovo3a{
	width: 15px;
	padding:3px;
	height:15px;
	float: right;
	color: #cccccc;
	margin: 10px;
	letter-spacing: 0px;
	font-size: 12px;
	line-height: 14px;
	text-align: center;
	font-weight: 300;
	margin: 6px;
	margin-left:0px;
	margin-top:0px;

	cursor:pointer;
	border-radius: 20px; 
	}	
		
		
.inselected{background-color: #ffffff;}
.innormal{background-color: #666666;}	
.innormal:hover{background-color: #7ec64a;}	

		
.editar{
	background-color: #7ec64a;
	width: 20px;
	height: 20px;
	padding:0px;
	color:#ffffff;
	text-align: center;
	font-size: 12px;
	line-height: 13px;
	border-radius: 2px;
	font-weight: 200;
	margin: 5px;
	letter-spacing: 0px;
	margin-top: -25px;
	background-image: url(edit.png);
	background-size: 100% 100%;
	cursor:pointer;
	float:right;			
	}
		

.editar:hover{
	background-color: #6ead40;
	}
			
			
		
.upload{
	background-color: #7ec64a;
	width: 30px;
	height: 30px;
	padding:0px;
	color:#ffffff;
	text-align: center;
	font-size: 12px;
	line-height: 13px;
	border-radius: 2px;
	font-weight: 200;
	margin: 20px;
	letter-spacing: 0px;
	margin-top: 0px;
	background-image: url(upload.png);
	background-size: 100% 100%;
	cursor:pointer;
	}
		
.upload:hover{
	background-color: #6ead40;
	}
			
			
.textopt{
	color: #505050;
	padding:10px;
	margin-bottom:10px;
	max-width:700px;
	}
		
		
.lingua{
	padding:0px;
	background-color: #d6d6cb;
	color:#909090;
	font-size: 10px;
	font-weight: 400;
	padding-left: 20px;
	}
		
.titulo{
	padding:10px;
	color:#e3e5e2;
	font-size: 11px;
	font-weight: 400;
	padding-left: 20px;
	height:20px;
	text-transform: uppercase;
	background-color: #909090;
	}
			
.numero{
	padding:10px;
	background-color: #666666;
	color:#ffffff;
	font-size: 13px;
	text-transform: uppercase;
	}
			
.checkbox{
	padding:20px;
	color:#ffffff;
	font-size: 10px;
	}
		
		
.botaoapagar{
	background-color: #f25524;
	width: 20px;
	height:20px;
	float: right;
	color:#ffffff;
	border-radius: 2px;
	text-align: center;
	margin-left:0px;
	margin-right:30px;
	cursor:pointer;
	background-image: url(apagar.png);
	background-size: 100% 100%;
	}
	
.botao{
	width: 20px;
	height:20px;
	float: right;
	color:#ffffff;
	border-radius: 2px;
	text-align: center;
	margin-right:10px;
	cursor:pointer;
	background-size: 100% 100%;
	
	}	
		
.visivel{
	background-image: url(visivel.png);
	background-color: #6ead40;
	}	
	
.invisivel{
	background-image: url(invisivel.png);
	background-color: #f25524;
	}
		
.caixainput{
	background-color:#edede5;
	border-radius: 10px;
	width: 100%;
	height: 350px;
	padding:20px;
	}
		
.caixainputfile{
	background-color:#edede5;
	border-radius: 10px;
	width: 250px;
	height: auto;
	padding:20px;
	}
		
		
.botaofechar{
	padding:0px;
	float: right;
	font-size: 25px;
	text-align: center;
	width:30px;
	font-weight: 100;
	color:#666666;
	cursor:pointer;
	margin-top: 10px;
	margin-right:-30px;
	}
		
		
		
.barracinza{
	background-color:#ffffff;
	}
		
.barrabranca{
	background-color:#fafbe3;
	}
	
		
.bold{
	font-size:20px;
	cursor:pointer;
	margin-bottom:5px;
	padding:5px;
	width:18px;
	text-align:center;
	border-radius: 2px;


}

.link{
	font-size:16px;
	cursor:pointer;
	margin-top:-30px;
	padding:5px;
	width:120px;
	text-align:center;
	border-radius: 2px;
	border: 1px solid "#666666";
	float: right;

}


.boldselected{
	font-size:20px;
	cursor:pointer;
	margin-bottom:5px;
	padding:5px;
	width:18px;
	text-align:center;
	border-radius: 2px;
		font-weight: 800;

}


.inserirnovoinput{
	background-color: #7ec64a;
	width: 150px;
	padding:10px;
	height:20px;
	float: right;
	color: #ffffff;
	border-radius: 2px;
	margin: 10px;
	letter-spacing: 0px;
	font-size: 14px;
	text-align: center;
	font-weight: 400;
	margin: 20px;
	margin-top: 260px;
	margin-right: 0px;
	cursor:pointer;
	}
	
.inserirnovoinputfile{
	background-color: #7ec64a;
	width: 150px;
	padding:10px;
	height:20px;
	float: right;
	color: #ffffff;
	border-radius: 2px;
	margin: 10px;
	letter-spacing: 0px;
	font-size: 14px;
	text-align: center;
	font-weight: 400;
	margin: 20px;
	margin-top: -40px;
	cursor:pointer;
	}
</style>
	
	
	
	
<script>

function fecharinputbox(){
		$("#cortina").fadeOut(500);
		$("#cortina2").fadeOut(500);
		}
		
function fecharinputbox2(){
		$("#cortina").fadeOut(500);
		$("#cortina3").fadeOut(500);
		$('#uploadfilemain').val('');
		$('#uploadfilemain').fadeIn();
		$('#uploadfilemainmin').fadeOut();
		$('#uploadfile1').fadeOut();
		$('#uploadfile2').fadeOut();
		$('#uploadfile3').fadeOut();
		$('#uploadfile4').fadeOut();
		$('#uploadfile5').fadeOut();
		$('#uploadfile6').fadeOut();

		}
		
	
function abririnputbox(valor1, valor2, valor3, valor4){

		document.formularioeditar.posicao.value=valor4;
		$("#cortina").fadeIn(500);
		$("#cortina2").fadeIn(500);
		iniciar();
		receberdados(valor1, valor2, valor3);
		$("#codigo").val(valor1);
		$("#campo").val(valor2);
		$("#tabela").val(valor3);

		}
			
			
function receberdados(valor1, valor2, valor3){
		$.get( "ajax/database.php?id="+valor1+"&tabela="+valor2+"&campo="+valor3+"", function( data ) {
		$("#textoeditor").contents().find("body").html(data);
		$("#textotratado").val(data);
		});
		}
			
			
			
///////////////////////EDITOR TEXTO
function iniciar(){
	document.getElementById('textoeditor').contentWindow.addEventListener('keyup',restrictEnterKey, true);
	document.getElementById("textoeditor").contentWindow.addEventListener('paste', onFocussed, true);
	document.Editor1 = document.getElementById('textoeditor').contentWindow.document;
	document.Editor1.designMode = "on";
	document.getElementById("textotratado").value=document.Editor1.body.innerHTML;
	document.Editor1.body.style.fontFamily="Arial";
	document.Editor1.body.style.fontSize="14px";
	document.Editor1.body.style.lineHeight="18px";
	document.Editor1.body.style.color="#404040";
	document.Editor1.body.style.backgroundColor="#ffffff";
	}

function restrictEnterKey(event) {
	document.getElementById("textotratado").value = document.Editor1.body.innerHTML;
	}
	
cnn=0;


function FormatarEditor1(action){

	if(cnn==1){$("#bold").removeClass("boldselected");$("#bold").addClass("bold");cnn=0; 
	}else{cnn++;$("#bold").toggleClass("boldselected");
		
	}
	

	
	

	document.Editor1.execCommand(action, false, null);
	document.getElementById("textotratado").value = document.Editor1.body.innerHTML;
	}

	function adicionarlinkEditor1(){
	a=prompt("Insira o hiperlink ex: www.");
	texto = prompt('Insira o texto descritivo', '');
	var link = "<a style='text-decoration:none' href='http://"+a+"'>"+texto+"</a>";
	document.Editor1.execCommand('inserthtml', false, link); 
	document.getElementById("textotratado").value=document.Editor1.body.innerHTML;
	} 


function onFocussed(e){

    e.preventDefault();
    alert("Não pode copiar diretamente para o editor sem remover a formatação.Copie novamente para a caixa amarela");
    document.getElementById("botaogravaralt").style.display="none";
    document.getElementById("cleaner").style.display="block";
    document.getElementById("botaogravar").style.display="none";


	}

function copiar(e){
    document.getElementById("botaogravaralt").style.display="block";
	document.getElementById("cleaner").style.display="none";	
    t=document.getElementById("textoclean").value;
    dd=document.getElementById("textotratado").value;
	document.Editor1.execCommand('inserthtml', false, t); 
	app=document.getElementById("textotratado").value+t;
	document.getElementById("textotratado").value=app;
	document.getElementById("textoclean").value="";

	}
	
/////////////
			
		
function descerate(valor){
	ad=valor.substr(3, 3);
 	jj="#bol"+ad;

    $('#inserirnovo3a .inserirnovo3a').removeClass('inselected');
    $('#inserirnovo3a .inserirnovo3a').addClass('innormal');
       
    $(jj).removeClass('innormal');        
    $(jj).addClass('inselected');
        
 	jjj="#bar"+ad;
    $('.barras').addClass('barracinza');
    $('.barras').removeClass('barrabranca');

    $(jjj).addClass('barrabranca');

	ee="#"+valor;
	$('html, body').animate({scrollTop: $(ee).offset().top-80 }, 300);
	}		


////////////////////////////////////////////////
//////////////////////////////////////////////// SCROLL SELECIONAR O TRABALHO
////////////////////////////////////////////////

$(function () {

<?php 
if($_POST['codigo']){echo "$('html, body').animate({scrollTop: $('#bar".$_POST['codigo']."').offset().top-80 }, 300);";}
if($_POST['posicao']){echo "$('html, body').animate({scrollTop: $('#bar".$_POST['posicao']."').offset().top-80 }, 300);";}

?>
	
	
		$(window).scroll(function () {
		
				var scroll = $(window).scrollTop();
			
				<?php  
					for($rr=$nu;$rr>=1;$rr--){
						$rrr=sprintf('%03d', $rr);
						echo "
						ba".$rrr."='#bar".$rrr."';bo".$rrr."='#bol".$rrr."';
						var position".$rrr." = $( ba".$rrr.").position().top-200;	
						
						if(scroll >= position".$rrr."){
							$('.barras').removeClass('barrabranca');
							$('.barras').addClass('barracinza');
							$('#inserirnovo3a .inserirnovo3a').removeClass('inselected');
							$('#inserirnovo3a .inserirnovo3a').addClass('innormal');
							$(ba".$rrr.").addClass('barrabranca');
							$(bo".$rrr.").removeClass('innormal');
							$(bo".$rrr.").addClass('inselected');
							}

						";

					}
					
				?>
											
				});		
		
			});


////////////////////////////////////////////////
//////////////////////////////////////////////// SCROLL SELECIONAR O TRABALHO
////////////////////////////////////////////////
	
	
function uploaddados(){
	document.formularioupload.submit();	
		
	}
	
function uploaddadosedit(){
	document.formularioeditar.submit();		
	}
	
	

//////////////////////
function inserirnovo(){
	document.formularionovo.submit();		

}

//////////////////////
function apagartrabalho(valor){
	aa=confirm("Quer mesmo apagar?");
	document.formularioapagar.trabalho.value=valor;
	if(aa){document.formularioapagar.submit();}		

}

//////////////////////
function visiveltrabalho(valor, valor2, valor3){
	document.formulariovisivel.trabalho.value=valor;
	document.formulariovisivel.posicao.value=valor3;
	document.formulariovisivel.visivel.value=valor2;
	document.formulariovisivel.submit();		

}



function uploadimagens(valor1, valor2){
		document.formularioupload.trabalho.value=valor1;
		document.formularioupload.posicao.value=valor2;
		$("#cortina").fadeIn(500);
		$("#cortina3").fadeIn(500);
	
}


function apagarimagens(valor1, valor2){
 cn=confirm("tem a certeza que deseja apagar?");
 if(cn==true){
		document.formularioapagarimagens.trabalho.value=valor1;
		document.formularioapagarimagens.posicao.value=valor2;
		document.formularioapagarimagens.submit();		}

}



function mostrar(valor){
if(valor=="uploadfilemain"){ $("#uploadfile1").fadeIn(600);$("#uploadfilemain").fadeOut(600);$("#uploadfilemainmin").fadeIn(600);}
if(valor=="uploadfile1"){ $("#uploadfile2").fadeIn(600);$("#uploadfile1").fadeOut(600);;$("#uploadfile1min").fadeIn(600);}
if(valor=="uploadfile2"){ $("#uploadfile3").fadeIn(600);$("#uploadfile2").fadeOut(600);;$("#uploadfile2min").fadeIn(600);}
if(valor=="uploadfile3"){ $("#uploadfile4").fadeIn(600);$("#uploadfile3").fadeOut(600);;$("#uploadfile3min").fadeIn(600);}
if(valor=="uploadfile4"){ $("#uploadfile5").fadeIn(600);$("#uploadfile4").fadeOut(600);;$("#uploadfile4min").fadeIn(600);}
if(valor=="uploadfile5"){ $("#uploadfile6").fadeIn(600);$("#uploadfile5").fadeOut(600);;$("#uploadfile5min").fadeIn(600);}
if(valor=="uploadfile6"){ $("#uploadfile6").fadeOut(600);$("#uploadfile6min").fadeIn(600);}


}




 function showMyImage(fileInput, valor) {
 		fin=valor+"min";
        var files = fileInput.files;
        for (var i = 0; i < files.length; i++) {           
            var file = files[i];
            var imageType = /image.*/;     
            if (!file.type.match(imageType)) {
                continue;
            }           
            var img=document.getElementById(fin);            
            img.file = file;    
            var reader = new FileReader();
            reader.onload = (function(aImg) { 
                return function(e) { 
                    aImg.src = e.target.result; 
                }; 
            })(img);
            reader.readAsDataURL(file);
        }    
    }
</script>
	
	
</head>



<body>
<?php


if ($formatoverde){
mysql_select_db("formatoverde",($formatoverde)) ;
$result2 = mysql_query("SELECT * FROM porfolio ORDER BY cod DESC");


$num=mysql_num_rows($result2);







echo "<div id='cortina' style='width:100%;height:100%;position:fixed;background-color:#101010;padding:10px;opacity:0.8;z-index:10;display:none'></div>";


echo "<div id='cortina3' style='width:100%;height:100%;position:fixed;padding:10px;z-index:11;display:none'>
<table border='0' cellpadding='0' cellspacing='0' align='center' width='400' height='100%'><tr><td>
<div class='botaofechar' onclick='fecharinputbox2()'>x</div>
<div class='caixainputfile'>";

echo "<form name='formularioupload' id='formularioupload' action='index.php' method='POST' enctype='multipart/form-data'>";

echo '<img id="uploadfilemainmin" style="width:202px;display:none"  src="" alt="image"/></br>';
echo "<input class='uploadfile' type='file' name='uploadfilemain' id='uploadfilemain' onchange='mostrar(this.id), showMyImage(this, this.id)'>";
echo '<img id="uploadfile1min" style="width:100px;display:none"  src="" alt="image"/></br>';
echo "<input class='uploadfile' type='file' name='uploadfile1' id='uploadfile1' onchange='mostrar(this.id), showMyImage(this, this.id)' style='display:none' >";
echo '<img id="uploadfile2min" style="width:100px;display:none"  src="" alt="image"/></br>';

echo "<input class='uploadfile' type='file' name='uploadfile2' id='uploadfile2' onchange='mostrar(this.id), showMyImage(this, this.id)' style='display:none'>";
echo '<img id="uploadfile3min" style="width:100px;display:none"  src="" alt="image"/></br>';

echo "<input class='uploadfile' type='file' name='uploadfile3' id='uploadfile3' onchange='mostrar(this.id), showMyImage(this, this.id)' style='display:none'>";
echo '<img id="uploadfile4min" style="width:100px;display:none;"  src="" alt="image"/></br>';

echo "<input class='uploadfile' type='file' name='uploadfile4' id='uploadfile4' onchange='mostrar(this.id), showMyImage(this, this.id)' style='display:none'>";
echo '<img id="uploadfile5min" style="width:100px;display:none;"  src="" alt="image"/></br>';

echo "<input type='file' name='uploadfile5' id='uploadfile5' onchange='mostrar(this.id), showMyImage(this, this.id)' style='display:none'>";
echo '<img id="uploadfile6min" style="width:100px;display:none"  src="" alt="image"/></br>';

echo "<input type='file' name='uploadfile6' id='uploadfile6' onchange='showMyImage(this, this.id)'style='display:none'>";

echo '<input type="hidden" id="trabalho" name="trabalho" value="">
<input type="hidden" id="posicao" name="posicao" value="">';
echo"</form>";

echo "
<div id='botaogravaralt' class='inserirnovoinputfile'  onclick='uploaddados()'>Upload</div>

</div></div>

</td></tr></table>
</div>";



echo "<div id='cortina2' style='width:100%;height:100%;position:fixed;padding:10px;z-index:11;display:none'>
<table border='0' cellpadding='0' cellspacing='0' align='center' width='500' height='100%'><tr><td>
<div class='botaofechar' onclick='fecharinputbox()'>x</div>

<div class='caixainput'>
<div>
<br>";
?>

<!---editor-->


<form method="POST" action="index.php" id="formularioeditar" name="formularioeditar" >
	<div class="caixaformat">
		<div id='bold' class='bold'   onclick="FormatarEditor1('bold')" >Bold</div>
		<div id='link' class='link'   onclick="adicionarlinkEditor1()" >adicionar link</div>

		
	</div>
	<!--texto e texto tratado-->
	<iframe id="textoeditor" name="textoeditor" onkeyUp="actualizar()"  style='border:0px;margin-top:0px;border-radius:2px;width:500px;height:250px;position:absolute' onbeforepaste="teste()"></iframe>
	<textarea id="textotratado"  name="textotratado" style="display:none;"/></textarea>
	<!--texto e texto tratado-->
	<!--inserir mais campos-->
	<div id="cleaner" style="display:none;">
	Copie novamente o texto para a caixa em baixo;<br>
	<textarea  style="width:500px;height:250px;background-color:#f9f3ae;position:absolute;margin-top:-15px" name="textoclean" id="textoclean"  type="hidden" autofocus=""/></textarea>
	<div onclick="copiar()" class="inserirnovoinput" >Copiar</div>
	</div>
	<!--inserir mais campos-->
	<!--codigo para alterar-->
	<input id="codigo" name="codigo"  type="hidden" style="margin-top:400px"  value=""/>
	<input id="campo" name="campo"  type="hidden" style=""  value=""/>
	<input id="posicao" name="posicao"  type="hidden" style=""  value=""/>
	<input id="tabela" name="tabela"  type="hidden" style=""  value=""/>

	<!--codigo para alterar-->
</form>





<!---editor-->


<?php
echo"


</div>
</br></br>
<div id='botaogravaralt' class='inserirnovoinput'  onclick='uploaddadosedit()'>Gravar</div>

</div>

</td></tr></table>
</div>";



echo "<div style='width:100%;position:fixed;height:60px;background-color:#101010;padding:10px;opacity:0.8;'></div>";
echo "<div style='width:100%;position:fixed;height:60px;padding:10px;margin-top:10px;'>
<div style='float:left;margin-left:20px;'><img width='40'src='../imagens/passaro_fv_mapa_1.svg' ></div>
<div class='inserirnovo3' >SAIR</div><div class='inserirnovo3' style='color:#8cdb46'>Gerir Portfolio</div><div class='inserirnovo3'>GerirEtiqueta</div><div class='inserirnovo3'>Upload Econews</div>";

/*botao*/
echo "<div onclick='inserirnovo()' class='inserirnovo'>Inserir Novo</div>";

echo "<div id='inserirnovo3a'>";
	
for ($iia=1;$iia<=$num;$iia++){
	
		 $aii=sprintf('%03d', $iia);


		echo "<div id='bol".$aii."' class='inserirnovo3a "; if($iia==$num){echo "inselected";} else{echo "innormal";}; echo "'";
		echo  'onclick="';
		echo "descerate('pos".$aii."')";
		echo'"';
		echo">".$iia."</div>";
}


/*botao*/
echo "</div>";


echo "</div>";




echo "<table  border='0' cellpadding='0' cellspacing='0' style='padding-top:80px;'>";


$result2 = mysql_query("SELECT * FROM porfolio ORDER BY cod DESC");
$dd=$num+1;

	while($row2 = mysql_fetch_array($result2))
			{
			$dd--;
			$ddd=sprintf('%03d', $dd);

			$cod=$row2['cod'];

			$titulo=$row2['titulo'];
			$titulopt=$row2['titulopt'];
			$titulofr=$row2['titulofr'];
			$tituloes=$row2['tituloes'];

			
			$area=$row2['area'];
			$areapt=$row2['areapt'];
			$areafr=$row2['areafr'];
			$areapes=$row2['areaes'];
			
			
			$cliente=$row2['cliente'];
			$clientept=$row2['clientept'];
			$clientefr=$row2['clientefr'];
			$clientees=$row2['clientees'];

			
			$texto=$row2['texto'];
			$textopt=$row2['textopt'];
			$textofr=$row2['textofr'];
			$textoes=$row2['textoes'];
			
			$linkvimeo=$row2['linkvimeo'];			
			$linkyoutube=$row2['linkyoutube'];	
			$visivel=$row2['visivel'];	

	/*		
			*/

			echo "<tr class='barras "; if($ddd==$num){echo "barrabranca";}else{echo "barracinza";}
			echo "' id='bar".$ddd."' >";


			echo "<td style='border-right:1px solid #cccccc' valign='top'><div id='pos".$ddd."' class='titulo'>".$cod." Imagens</div><div class='lingua'>Principal</div>";
			
			$p="../portfolio/".$cod."/";
			if ($handle = opendir($p)) {
						while (false !== ($file = readdir($handle))) {
							if ($file != "." && $file != ".."  && $file == "main.jpg") {
								echo "<img style='margin:20px;'  width='200'  style='' src='../portfolio/".$cod."/".$file."'>";

								}
						}
					}


			
			
			echo "<div class='lingua'>Outras</div>";
			echo "<div style='margin:20px;'>";
			
$cnf=0;
			if ($handle = opendir($p)) {
						while (false !== ($file = readdir($handle))) {
						
							if ($file != "." && $file != ".."  && $file != "main.jpg") {$cnf++;
								echo "<img width='100px' height='60' style='' src='../portfolio/".$cod."/".$file."'>";

								}
						}
					}
			
		
					
			echo "</div>";
			
			if($cnf>0){
					/*botao editar*/
			echo '<div class="botaoapagar"  onclick="apagarimagens('; 
			echo "'".$cod."'";
			echo ", '".$ddd."'";
			echo ')" style="margin-left:20px;"></div>';
			/*botao editar*/
				
			}else{
				/*botao editar*/
			echo '<div class="upload"  onclick="uploadimagens('; 
			echo "'".$cod."'";
			echo ", '".$ddd."'";
			echo ')" style="margin-left:20px;"></div>';
			/*botao editar*/
				
			}
			
			
			
			echo"</td>";




			echo "<td style='border-right:1px solid #cccccc' valign='top' width='200'>
			<div class='titulo'>Titulo</div>
			<div class='lingua'>EN</div><div class='textopt'>".$titulo."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'titulo'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/

			echo "<div class='lingua'>PT</div><div class='textopt'>".$titulopt."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'titulopt'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/


			echo "<div class='lingua'>FR</div><div class='textopt'>".$titulofr."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'titulofr'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/
			
			
			echo "<div class='lingua'>ES</div><div class='textopt'>".$titulopes."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'tituloes'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/
			
			echo "<div class='titulo'>LINK VIMEO</div>";
			
			echo "<div class='textopt'>".$linkvimeo."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'linkvimeo'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/



			echo "<div class='titulo'>LINK YOUTUBE</div>";
			
			echo "<div class='textopt'>".$linkyoutube."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'linkyoutube'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/

			
			echo "</td>";
			
			
			echo "<td valign='top' style='border-right:1px solid #cccccc' width='200'><div class='titulo'>Area</div><div class='lingua'>EN</div><div class='textopt'>".$area."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'area'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/
			
			echo "<div class='lingua'>PT</div><div class='textopt'>".$areapt."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'areapt'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/
			
			echo "<div class='lingua'>FR</div><div class='textopt'>".$areafr."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'areafr'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/
			
			echo "<div class='lingua'>ES</div><div class='textopt'>".$areaes."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'areaes'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/
			
			
			
			
			
			
			echo "<div class='titulo'>Cliente</div><div class='lingua'>EN</div><div class='textopt'>".$cliente."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'cliente'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/
			
			echo "<div class='lingua'>PT</div><div class='textopt'>".$clientept."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'clientept'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/
			
			echo "<div class='lingua'>FR</div><div class='textopt'>".$clientefr."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'clientefr'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/
			
			
			echo "<div class='lingua'>ES</div><div class='textopt'>".$clientees."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'clientees'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/
			

			echo "</td>";
			
			
			
			

			echo "<td valign='top' width='800'><div class='titulo'>Texto";
			
			/*botao editar*/
			echo '<div class="botaoapagar"  onclick="apagartrabalho('; 
			echo "'".$cod."'";
			echo ')"></div>';
			/*botao editar*/

			/*botao editar*/
			echo '<div class="botao ';
			if($visivel>0){echo "visivel";}else{echo "invisivel";}
			echo '"  onclick="visiveltrabalho('; 
			echo "'".$cod."', '".$visivel."' ,'".$ddd."'";
			echo ')"></div>';
			/*botao editar*/
			
			
			
			
			echo"</div><div class='lingua'>EN</div><div class='textopt'>".$texto."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'texto'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/
			
			echo "<div class='lingua'>PT</div><div class='textopt'>".$textopt."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'textopt'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/
			
			echo "<div class='lingua'>FR</div><div class='textopt'>".$textofr."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'textofr'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/
			
			echo "<div class='lingua'>ES</div><div class='textopt'>".$textoes."</div>";
			
			/*botao editar*/
			echo '<div class="editar"  onclick="abririnputbox('; 
			echo "'".$cod."', 'porfolio', 'textoes'";
			echo ", '".$ddd."'";
			echo ')"></div>';
			/*botao editar*/
			
			echo"</td>";
			




			echo "</tr>";
			
			
			
	
			}	
	echo "<tr><td height='200px'></td></tr></table>";
} 




?>

<form id="formularioapagarimagens" name="formularioapagarimagens" method="POST" action="index.php">
<input type="hidden" id="trabalho" name="trabalho" value=''>
<input type="hidden" id="posicao" name="posicao" value=''>
<input type="hidden" id="apagarimagens" name="apagarimagens" value="1">


</form>

<form id="formularioapagar" name="formularioapagar" method="POST" action="index.php">
<input type="hidden" id="apagar" name="apagar" value="1">
<input type="hidden" id="trabalho" name="trabalho" value=''>
</form>

<form id="formulariovisivel" name="formulariovisivel" method="POST" action="index.php">
<input type="text" id="visivel" name="visivel" value="1">
<input type="hidden" id="trabalho" name="trabalho" value=''>
<input type="hidden" id="posicao" name="posicao" value=''>
</form>

<form id="formularionovo" name="formularionovo" method="POST" action="index.php">
<input type="hidden" id="novotrabalho" name="novotrabalho" value="1">
</form>	
		
	</body>
	
</html>