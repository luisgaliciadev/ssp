<?php	
	$Nivel="../../";
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	$ReporteOrdenCarga=$_SESSION[$SiglasSistema."ReporteOrdenCarga"];
	
	$ID_ORDEN_PESAJE=$_GET["ID_ORDEN_PESAJE"];
	
	$ReporteOrdenCarga = iconv ("ISO-8859-1", "UTF-8", ($ReporteOrdenCarga));
	
	include($Nivel."Includes/Plugins/MPDF57/mpdf.php");
	
	$mpdf=new mPDF('c','Letter');
	
	$mpdf->SetTitle('Orden de Carga Nro: '.$ID_ORDEN_PESAJE);
	
 	$mpdf->watermarkTextAlpha = 0.6;
	
	$mpdf->showWatermarkImage = true;  
	
	$mpdf->WriteHTML($ReporteOrdenCarga);
	
	$mpdf->Output();
?>	