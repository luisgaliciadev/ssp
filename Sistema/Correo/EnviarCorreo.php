<?php
	$Nivel="../../";
	include($Nivel."Includes/PHP/funciones.php");
	
	session_start();
	
	$Arreglo	=	EnviarCorreo
	(
		$EmisorCorreo			=	'contacto@zonalotto.com', 
		$EmisorNombre			=	'ZonaLot', 
		$EmisorCorreoResponder	=	'contacto@zonalotto.com', 
		$EmisorNombreResponder	=	'Zonalot', 
		$DestinatarioCorreo		=	'freiteseliesser@hotmail.com', 
		$DestinatarioNombre		=	'Eliesser Freites', 
		$Asunto					=	'Prueba', 
		$Plantilla				=	'http://localhost/zonalot/Sistema/Correo/ValidarRegistroUsuario.php?Kye=123456789',
		$Nivel					=	$Nivel
	);
	
	if($Arreglo["RESULTADO"])
	{
		echo "Correo enviado";
	}
	else
	{
		echo $Arreglo["MSJ_ERROR"];
	}
?>