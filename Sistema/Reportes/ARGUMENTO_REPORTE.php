<?php 
	$Nivel="../../";	
	include($Nivel."includes/funciones.php");
	
	$conector=Conectar();
	
	session_start();

	$id_localidad = $_SESSION[$SiglasSistema."id_localidad"];

	$resp ="";
	$url = "";
	$condicion = "";

	$id_reporte=$_POST['id_reporte'];
	
	$vSQL="select * from view_rp_argumento_reporte where id_reporte = $id_reporte ";
	
	if($result=$conector->Ejecutar($vSQL))
	{
		$aux = 1;
		while(odbc_fetch_row($result))
		{
			$url = odbc_result($result,'nb_hoja');
			$condicion = odbc_result($result,'condicion');
			if($aux == 1)
			{
				$resp .= odbc_result($result,'ID_ARGUMREP_GRAL');
				$aux = $aux +1 ;
			}
			else
			{
				$resp .="%%";
				$resp .= odbc_result($result,'ID_ARGUMREP_GRAL');
			}
		}
		 
		echo $url."%%".$condicion."%%".$resp;
	}
	else
	{
		echo $vSQL;
		exit;
	}
	
	$conector->Cerrar();
?>