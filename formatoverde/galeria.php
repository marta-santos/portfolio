<?php require_once('formatoverde.php'); ?>



<style>

.input{
	width:300px;
	height:30px;
	border: 0px;
	background-color: #ccc;
	margin:5px;
	font-size: 12px;
	}

.body{
	margin:0px;
	padding:0px;
	}

upload{
     -moz-border-radius:6px;
     -webkit-border-radius:3px;
     border-radius:6px;
     border:1px solid #eee;
     display:inline-block;
     color:#666;
     font-family:arial;
     font-size:14px;
     font-weight:100;
     padding:20px 14px;
     text-decoration:none;
     width:100%;
    cursor:pointer;
	}

.text-input{
    padding: 6px;
    font-size: 13px;
    border: 1px solid #d5d5d5;
    color: #333;
    border-radius: 4px 4px 4px 4px !important;
	}

.avisosim{
	background-color: #d3e3cf;
	color:#ffffff;
	padding:20px;
	font-weight: 100;
	font-size: 18px;
	text-align: center;
	font-family: Arial;
	}

.avisoerro{
	background-color: #fb6840;
	color:#ffffff;
	padding:20px;
	font-weight: 100;
	font-size: 18px;
	text-align: center;
	font-family: Arial;
	}

.editor{
	display:block;
	padding:10px;
	width:auto;
	height:auto;
	background-color:#fff;
	background-color: #eee;
	padding:30px;
	border-radius: 5px;
	margin-top:100px;
	border:1px solid #ccc;	
	font-size:12px;	
	position:fixed;
	}
	
.botaogravar{
	font-size:13px;
	padding:10px;
	width:120px;
	background-color:#fff;
	margin-top:20px;		
	border:1px solid #ccc;
	border-radius: 5px;
	color:#666;
	}

.caixatexto{
	font-size:13px;
	width:400px;
	height:200px;		
	border:1px solid #ccc;
	border-radius: 5px;
	padding:5px;
	background-color: #ffffff;
	font-family: Arial;
	}

.format{
	background-size:100% 100%;
	width:12px; 
	height:12px;
	float:right;
	margin-right:10px;
	cursor:pointer;
	}

.caixaformat{
	width:410px;
	height:20px;
	padding:5px;
	}
			
.caixatexto{
		font-size:13px;
		width:400px;
		height:200px;
		border:1px solid #ccc;
		border-radius: 5px;
		padding:5px;
		background-color: #ffffff;
		font-family: Arial;
		}


.fechar{
	width:30px;
	height:30px;
	background-color: #ffffff;
	position:absolute;
	
}
</style>




<script>
	
function iniciar(){
	document.getElementById('textoeditor').contentWindow.addEventListener('keyup',restrictEnterKey, true);
	document.getElementById("textoeditor").contentWindow.addEventListener('paste', onFocussed, true);
	document.Editor1 = document.getElementById('textoeditor').contentWindow.document;
	document.Editor1.designMode = "on";
	document.getElementById("textotratado").value=document.Editor1.body.innerHTML;
	}

function restrictEnterKey(event) {
	document.getElementById("textotratado").value = document.Editor1.body.innerHTML;
	}
	
function FormatarEditor1(action){
	document.Editor1.execCommand(action, false, null);
	document.getElementById("textotratado").value = document.Editor1.body.innerHTML;
	}

/*function adicionarlinkEditor1(){
	a=prompt("Insira o hiperlink ex: www.");
	texto = prompt('Insira o texto descritivo', '');
	var link = "<a style='text-decoration:none' href='http://"+a+"'>"+texto+"</a>";
	document.Editor1.execCommand('inserthtml', false, link); 
	document.getElementById("textotratado").value=document.Editor1.body.innerHTML;
	} 
*/
function editarcampo(valor,valor2){


document.Editor1.body.style.fontFamily="Arial";
	document.Editor1.body.style.fontSize="13px";
	document.Editor1.body.style.lineHeight="18px";
	document.Editor1.body.style.color="#404040";

		
	exp=valor.substr(3,20);
	d="edi"+exp;	
			
	for(var i = 0; i < document.getElementsByName("trabalhos").length; i++){
		var objminiaturas = document.getElementsByName("trabalhos").item(i);
		if(objminiaturas.id==d){			
			exp2=objminiaturas.id.substr(3,20);
			n=objminiaturas.id.substr(3,20);
			//campos
			tx=valor2+n;
			document.getElementById('campo').value=valor2;
						
			////////campos onde vai buscar informacao					
			text=document.getElementById(tx).innerHTML;
						
			if(text=="adicionar"){text="";}
			//campos do input
			document.Editor1.body.innerHTML=text;
				
			document.getElementById("textotratado").value=document.Editor1.body.innerHTML;
			document.getElementById("codigo").value=n;
			}
		}
	}


function onFocussed(e){
     e.preventDefault();
     alert("Não pode copiar diretamente para o editor sem remover a formatação");
     document.getElementById("cleaner").style.display="block";
     document.getElementById("botaogravar").style.display="none";
     document.getElementById("textoclean").focus();
}

function copiar(e){
	document.getElementById("cleaner").style.display="none";
	document.getElementById("botaogravar").style.display="block";
    t=document.getElementById("textoclean").value;
    dd=document.getElementById("textotratado").value;
	document.Editor1.execCommand('inserthtml', false, t); 
	app=document.getElementById("textotratado").value+t;
	document.getElementById("textotratado").value=app;
	}
	

		
		
function fazerupload(valor){
	exp=valor.substr(2,20);
	d="formulario"+exp;	
	document.forms[d].submit();
}

function criarnovo(){
		document.formularionovo.submit();
}
	
function upzip(){
		document.medidas.submit();
}
	
	function gravarnoticia(){
	document.getElementById("editor").style.display="none";
	document.formularioeditar.submit();
	}

</script>

<html>
<body onLoad="iniciar()">

<!---editor-->
<div id="cortina" class="cortina" style="margin-top:0px;display:block">
<table width="500"  cellpadding="0" cellspacing="0" border="0" height="auto" align="center">
<tr>
<td>
<div id="editor" class="editor" style="position:fixed">

<form method="post" action="<?php ?>login.php" id="formularioeditar" name="formularioeditar" >
<div class="caixaformat">
<div class="format"  onclick="FormatarEditor1('bold')" >B</div>
</div>
<!--texto e texto tratado-->
<iframe id="textoeditor" name="textoeditor" onkeyUp="actualizar()"  class="caixatexto" onbeforepaste="teste()"></iframe>
<textarea id="textotratado"  name="textotratado" style="display:none;"/></textarea>
<!--texto e texto tratado-->
<!--inserir mais campos-->
<div id="cleaner" style="display:none;">
Copie novamente o texto;<br>
<textarea  style="width:400px;height:100px;background-color:#f9f3ae" name="textoclean" id="textoclean"  type="hidden"/></textarea>
<div onClick="copiar()" class="botaogravar" >COPIAR SEM FORMATAÇÃO</div>
</div>
<!--inserir mais campos-->
<!--codigo para alterar-->
<input id="codigo" name="codigo"  type="hidden" style=""  value=""/>
<input id="campo" name="campo"  type="hidden" style=""  value=""/>
<!--codigo para alterar-->

<div class="botaogravar" id="botaogravar" onClick="gravarnoticia()"> GRAVAR</div>

</form>
</div>
</td>
</tr>
</table>
</div>



<!---editor-->






 
<form id="formularioapagar" name="formularioapagar" method="POST" action="login.php">
<input type="hidden" id="apagar" name="apagar">
</form>



<form id="formulariovisivel" name="formulariovisivel" method="POST" action="login.php">
<input type="hidden" id="trabalho" name="trabalho">
<input type="hidden" id="visivel" name="visivel">
</form>



<form id="formularionovo" name="formularionovo" method="POST" action="login.php">
<input type="hidden" id="novtrabalho" name="novtrabalho" value="1">
</form>


</body></html>

    
