var myVar;

self.addEventListener
(
	"message",
    function(event)
	{
		myVar=setInterval(RefrescarConsulta, (15*60000));
    },
    false
);

function RefrescarConsulta()
{	
	xmlhttp=new XMLHttpRequest();
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			self.postMessage(
			{
				"msg": xmlhttp.responseText
			});
		}
	}
	
	xmlhttp.open("GET","VerificarTiempoSesion.php",true);
	
	xmlhttp.send();
}

function myStopFunction()
{
	clearInterval(myVar);
}