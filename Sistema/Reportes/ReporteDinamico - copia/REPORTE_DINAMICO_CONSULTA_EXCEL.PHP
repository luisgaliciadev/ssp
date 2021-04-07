<?php
	$Nivel="../../../";	
	
	include($Nivel."includes/funciones.php");
	
	require_once $Nivel.'plugins/PHPExcel/PHPExcel.php';
	
	$conector=Conectar();
	
	session_start();
	
	$ID_REP_DIN=$_GET['ID_REP_DIN'];
	$CamposColumnas=$_GET['CamposColumnas'];	
	$Columnas=$_GET['Columnas'];
	$TituloReporte=$_GET['TituloReporte'];
	
	$ArregloCamposColumnas=explode(",",$CamposColumnas);
	$CantidadCamposColumnas=count($ArregloCamposColumnas);
	
	$ArregloColumnas=explode(",",$Columnas);
	$CantidadColumnas=count($ArregloColumnas);
	
	$CadBus="";
	
	while(true)
	{
		$Ite++;
		
		if(!isset($_GET['CamBus'.$Ite]))
		{
			break;
		}
		else
		{
			$posi=strpos($_GET['CamBus'.$Ite], '*');
			
			$NB_CAMPO_SQL=substr($_GET['CamBus'.$Ite], 0, $posi);
			
			$TIPO_CAMPO_HTML_AUX=substr($_GET['CamBus'.$Ite], ($posi+1), strlen($_GET['CamBus'.$Ite]));
			$posi_AUX=strpos($TIPO_CAMPO_HTML_AUX, '*');
			
			$TIPO_CAMPO_HTML=substr($TIPO_CAMPO_HTML_AUX, 0, ($posi_AUX));
			
			$VALOR=$_GET['ValBus'.$Ite];
			
			if($VALOR)
			{
				switch($TIPO_CAMPO_HTML)
				{
					case 'TEXT':
						$CadBus.=" AND ".$NB_CAMPO_SQL." LIKE '%".$VALOR."%' ";
					break;
					
					case 'SELECT':
						$CadBus.=" AND ".$NB_CAMPO_SQL." = ".$VALOR." ";
					break;
				}
			}
		}
	}
	
	$vSQL="SELECT        
				*
			FROM            
				TB_REP_DIN 
			WHERE 
				FG_ACTIVO=1 AND (ID_REP_DIN = $ID_REP_DIN)";
	
	if($result=$conector->Ejecutar($vSQL))
	{
		$SENTENCIA_SQL_SIN=odbc_result($result,'SENTENCIA_SQL_SIN');
	}
	else
	{
		echo $vSQL;
	}	
	
	$objPHPExcel = new PHPExcel();
	
	$objPHPExcel->getProperties()->setCreator("BP") //Autor
						 ->setLastModifiedBy("BP") //Ultimo usuario que lo modificó
						 ->setTitle("Reporte Excel con PHP y MySQL")
						 ->setSubject("Reporte Excel con PHP y MySQL")
						 ->setDescription("Reporte de alumnos")
						 ->setKeywords("reporte alumnos carreras")
						 ->setCategory("Reporte excel");
	
	$ABC = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	
	$objPHPExcel->setActiveSheetIndex(0)
				->mergeCells('A1:K1');
					
	// Se agregan los titulos del reporte
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1',  $TituloReporte);
				
	for($Ite=0; $Ite<$CantidadColumnas; $Ite++)
	{
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue($ABC[$Ite].'3',  $ArregloColumnas[$Ite]);
	}
	
	$vSQL="SELECT top 20 ".$CamposColumnas." ".$SENTENCIA_SQL_SIN." ".$CadBus;
	
	if($result=$conector->Ejecutar($vSQL))
	{
		$pintar=0;
		
		$Fil=4;
		
		while(odbc_fetch_row($result))
		{
			for($Col=1; $Col<=$CantidadCamposColumnas; $Col++)
			{
				/*$Posi=strpos($ArregloCamposColumnas[$Col],".");
				
				$NombreCampo=substr($ArregloCamposColumnas[$Col],$Posi+1,strlen($ArregloCamposColumnas[$Col]));*/
				
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue($ABC[$Col-1].$Fil, odbc_result($result, $Col));

			}
			
			$Fil++;
		}
			
		$Col--;
	}
	else
	{
		echo $vSQL;
	}
	
	$estiloTituloReporte = array(
		'font' => array(
			'name'      => 'Verdana',
			'bold'      => true,
			'italic'    => false,
			'strike'    => false,
			'size' =>18,
				'color'     => array(
					'rgb' => '000000'
				)
		),
		'fill' => array(
			'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
			'color'	=> array('argb' => 'ffffff')
		),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_NONE                    
			)
		), 
		'alignment' =>  array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'rotation'   => 0,
				'wrap'          => TRUE
		)
	);

	$estiloTituloColumnas = array(
		'font' => array(
			'name'      => 'Arial',
			'bold'      => true,                          
			'color'     => array(
				'rgb' => '000000'
			)
		),
		'fill' 	=> array(
			'type'		=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
			'rotation'   => 90,
			'endcolor'   => array(
				'argb' => 'C9C9C9'
			)
		),
		'borders' => array(
			'top'     => array(
				'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
				'color' => array(
					'rgb' => '143860'
				)
			),
			'bottom'     => array(
				'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
				'color' => array(
					'rgb' => '143860'
				)
			)
		),
		'alignment' =>  array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap'          => TRUE
		));
		
	$estiloInformacion = new PHPExcel_Style();
	
	$estiloInformacion->applyFromArray(
		array(
			'font' => array(
			'name'      => 'Arial',               
			'color'     => array(
				'rgb' => '000000'
			)
		),
		'fill' 	=> array(
			'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
			'color'		=> array('argb' => 'FFd9b7f4')
		),
		'borders' => array(
			'left'     => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN ,
				'color' => array(
					'rgb' => '3a2a47'
				)
			)             
		)
	));
	 
	$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A3:'.$ABC[$Col-1].'3')->applyFromArray($estiloTituloColumnas);		
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:D".($Col-1));
			
	for($i = 'A'; $i <= $ABC[$Col]; $i++)
	{
		$objPHPExcel->setActiveSheetIndex(0)			
			->getColumnDimension($i)->setAutoSize(TRUE);
	}
	
	// Se asigna el nombre a la hoja
	$objPHPExcel->getActiveSheet()->setTitle('Resultados');

	// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
	$objPHPExcel->setActiveSheetIndex(0);
	// Inmovilizar paneles 
	//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
	$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

	// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Reporte.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	//exit;
?>
<script>
	window.close();
</script>