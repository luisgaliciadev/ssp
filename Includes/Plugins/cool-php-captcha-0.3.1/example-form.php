<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="Author" content="Jose Rodriguez" />
		<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
        <script>
			function VerificarCaptcha()
			{
				var TxtCaptcha = $('#TxtCaptcha').val();
				
				parametros='TxtCaptcha='+TxtCaptcha;
				alert(parametros);
				
				$.ajax(
				{
					type: "POST",
					dataType:"html",
					url: "verificar.php",			
					data: parametros,	
					beforeSend: function() 
					{	
					},			
					success: function(result)
					{
						if(result==0)
						{
							 RecargarCaptcha();
						}
					}	
				});
			}
			
			function RecargarCaptcha()
			{
				document.getElementById('captcha').src='captcha.php?'+Math.random();
				$('#TxtCaptcha').val('');
				$('#TxtCaptcha').focus();
			}
		</script>
        <style type="text/css">
			body { font-family: sans-serif; font-size: 0.8em; padding: 20px; }
			#result { border: 1px solid green; width: 300px; margin: 0 0 35px 0; padding: 10px 20px; font-weight: bold; }
			#change-image { font-size: 0.8em; }
        </style>
	</head>
    <body onload="document.getElementById('TxtCaptcha').focus()">  
    	<div style="float:left; border:#000 solid 0px; width:202px; height:105px;">
            <div style="padding-bottom:5px;">
                <img src="captcha.php" id="captcha" style="border:#DFDFDF solid 1px;"/>
            </div>
            <div style="width:196px;">
                <input type="text" name="TxtCaptcha" id="TxtCaptcha" autocomplete="off" style="width:100%"/>
            </div>
        </div>
        <div style="float:left; height:50px; margin-top:10px;">
            <a href="javascript:RecargarCaptcha()" value="Nuevo"><img src="recargar.jpg" style="border:#DFDFDF solid 1px; width:50px; margin-left:5px;" title="Nuevo Captcha"/></a>
        </div>
        <input type="button" onclick="VerificarCaptcha()" value="enviar"/>
</body>
</html>
