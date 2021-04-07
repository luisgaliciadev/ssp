<?php
	$Nivel="../../../";	
	
	include($Nivel."includes/funciones.php");
	
	require_once $Nivel.'plugins/PHPExcel/PHPExcel.php';
	
	$conector=Conectar();
	
	session_start();
	
	$ID_REP_DIN=$_GET['ID_REP_DIN'];
	
	$CamposColumnas=$_GET['CamposColumnas'];	
	$Columnas=$_GET['Columnas'];
	$TIPO_CAMPO_HTML=$_GET['TIPO_CAMPO_HTML'];	
	$SELECT_FLAG=$_GET['SELECT_FLAG'];		
	
	$TituloReporte=$_GET['TituloReporte'];
	
	$ArregloCamposColumnas=explode(",",$CamposColumnas);
	$CantidadCamposColumnas=count($ArregloCamposColumnas);
	
	$ArregloColumnas=explode(",",$Columnas);
	$CantidadColumnas=count($ArregloColumnas);
	
	$ArregloTIPO_CAMPO_HTML=explode(",",$TIPO_CAMPO_HTML);
	$CantidadTIPO_CAMPO_HTML=count($ArregloTIPO_CAMPO_HTML);
	
	$ArregloSELECT_FLAG=explode(",",$SELECT_FLAG);
	$CantidadSELECT_FLAG=count($ArregloSELECT_FLAG);
	
	$CadBus="";
	
	$Ite=0;
	
	while(true)
	{		
		if(!isset($_GET['NB_CAMPO'.$Ite]))
		{
			break;
		}
		else
		{			
			$NB_CAMPO_SQL=$_GET['NB_CAMPO_SQL'.$Ite];			
			$TIPO_CAMPO_HTML=$_GET['TIPO_CAMPO_HTML'.$Ite];			
			$VALOR=$_GET['VALOR'.$Ite];
			$ID_CAMPO_SELECT=$_GET['ID_CAMPO_SELECT'.$Ite];	
			
			if(trim(strval($VALOR))!="")
			{
				switch($TIPO_CAMPO_HTML)
				{
					case 'TEXT':
						$CadBus.=" AND ".$NB_CAMPO_SQL." LIKE '%".$VALOR."%' ";
					break;
					
					case 'SELECT':
						$CadBus.=" AND ".$ID_CAMPO_SELECT." = ".$VALOR." ";
					break;
				}
			}
		}
		
		$Ite++;
	}
	
	$vSQL="SELECT        
				*
			FROM            
				TB_REP_DIN 
			WHERE 
				FG_ACTIVO=1 AND (ID_REP_DIN = $ID_REP_DIN)";
	
	if($result=$conector->Ejecutar($vSQL))
	{
		$SENTENCIA_SQL=odbc_result($result,'SENTENCIA_SQL');
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
	
	$POSI=strpos($SENTENCIA_SQL, "FROM");
	$SENTENCIA_SQL=substr($SENTENCIA_SQL, $POSI, strlen($SENTENCIA_SQL));
	
	$vSQL="SELECT ".$CamposColumnas." ".$SENTENCIA_SQL." ".$CadBus;
	
	if($result=$conector->Ejecutar($vSQL))
	{
		$pintar=0;
		
		$Fil=4;
		
		while(odbc_fetch_row($result))
		{
			for($Col=1; $Col<=$CantidadCamposColumnas; $Col++)
			{
				switch($ArregloTIPO_CAMPO_HTML[$Col-1])
				{
					case "DATEPICKER":
						$Campo=fecha_normal(odbc_result($result, $Col));
					break;
					
					case "SELECT":
						if($ArregloSELECT_FLAG[$Col-1])
						{
							$Campo=odbc_result($result, $Col);
							
							if($Campo)
							{
								$Campo="SI";
							}
							else
							{
								$Campo="NO";
							}
						}
						else
						{
							$Campo=odbc_result($result, $Col);
						}
					break;
					
					default:
						$Campo=odbc_result($result, $Col);
					break;
				}
				
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue($ABC[$Col-1].$Fil, $Campo);

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