/////////////Mudar a raiz sempre que esta mudar

function verutilizador2(valor)
		{
		mudarutilizador2=GetXmlHttpObjectutilizador2();
		urlutilizador2="gestao/up2.php?id="+valor;
		mudarutilizador2.open("GET",urlutilizador2,true);
		mudarutilizador2.onreadystatechange=stateChangedutilizador2;
		mudarutilizador2.send(null);
		}

function stateChangedutilizador2(){
if (mudarutilizador2.readyState==4){document.getElementById("utilizadorbox2").innerHTML=mudarutilizador2.responseText;}}

function GetXmlHttpObjectutilizador2()
{if (window.XMLHttpRequest){ return new XMLHttpRequest();}
if (window.ActiveXObject){return new ActiveXObject("Microsoft.XMLHTTP");}
return null;}