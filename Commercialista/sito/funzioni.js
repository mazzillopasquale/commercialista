var xmlHttp;
var email;
function getXMLHttp()
{
  var xmlHttp=null;
	try{
		// IE7+, Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}catch (e){
		// Internet Explorer
	try{
		xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }catch (e){
		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
	return xmlHttp;
}

function createTableRis(tipo,mod)
{
   xmlHttp = getXMLHttp();
	if (xmlHttp==null){
		alert ("Your browser does not support AJAX!");
		return;
	} 
	if(mod==2)
    {
       xmlHttp.open("GET","utenteRisposte.php?tipo="+tipo,true);
	   xmlHttp.onreadystatechange=ricezioneRis;
	   xmlHttp.send(null);    
    }
    if(mod==1)
    {
       xmlHttp.open("GET","commercialistaRisposte.php?tipo="+tipo,true);
	   xmlHttp.onreadystatechange=ricezioneRis;
	   xmlHttp.send(null);    
    }
}

function ricezioneRis()
{ 
		if((xmlHttp.readyState==4) && (xmlHttp.status==200))
		{
				var t=document.getElementById('risposte');
				t.innerHTML=xmlHttp.responseText;
		}
	
}



