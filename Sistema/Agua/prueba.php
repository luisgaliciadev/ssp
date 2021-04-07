<?php
$Nivel = "../../";
include($Nivel."includes/funciones.php");  
session_start();

$conector=Conectar();
$DESDE = $_GET["desde"];
$HASTA = $_GET["hasta"];
$instructor = $_GET["instructor"];

$desde_aux = explode('/',$DESDE);
$hasta_aux = explode('/',$HASTA);


$f_desde = $_GET["desde"];
$f_hasta = $_GET["hasta"];



$DESDE = $desde_aux[0].'/'.$desde_aux[1].'/'.$desde_aux[2];
$HASTA = $hasta_aux[0].'/'.$hasta_aux[1].'/'.$hasta_aux[2];




 $sql = "select count(*) as cantidad,sum(sub_total)-sum(DESCUENTO)  as sub_total_desc,sum(DESCUENTO) as descuento, sum(sub_total) as sub_total,sum(total) as total,sum(iva) as iva,NOMBRE_SERVICIO 
        from view_ventas 
        where (FECHA_FACT >='".$DESDE."' and FECHA_FACT <='".$HASTA."') AND ID_CASA_ESTUDIO=".$_SESSION["id_sede"]."
        group by NOMBRE_SERVICIO";
                   


/** Se agrega la libreria PHPExcel */
	require_once 'PHPExcel/PHPExcel.php';

	// Se crea el objeto PHPExcel
	$objPHPExcel = new PHPExcel();
	
	// Se asignan las propiedades del libro
	$objPHPExcel->getProperties()->setCreator("MAFBOOKING") //Autor
						 ->setLastModifiedBy("MAFFBOOKING") //Ultimo usuario que lo modificÃ³
						 ->setTitle("Reporte Excel Ingresos")
						 ->setSubject("Reporte Excel Ingresos")
						 ->setDescription("Reporte de Ingresos")
						 ->setKeywords("Ingresos")
						 ->setCategory("Reporte excel");

	$tituloReporte = "Ingresos  ";
	
	$titulosColumnas = array('Nº','Servicios','Sub. Total','Descuento','IVA','Total');
	
	
	$objPHPExcel->setActiveSheetIndex(0)
				->mergeCells('A1:D1');
	
	// Se agregan los titulos del reporte
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1',  $tituloReporte);
	
	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A3',  $titulosColumnas[0])
				->setCellValue('B3',  $titulosColumnas[1])
				->setCellValue('C3',  $titulosColumnas[2])
				->setCellValue('D3',  $titulosColumnas[3])
				->setCellValue('E3',  $titulosColumnas[4])
				->setCellValue('F3',  $titulosColumnas[5]);
	

$Conector=Conectar();

session_start();

$estiloTitu = array(
		'font' => array(
			'name'      => 'Verdana',
			'bold'      => true,
			'italic'    => false,
			'strike'    => false,
			'size' =>13,
				'color'     => array(
					'rgb' => '000000'
				)
		),
		'fill' => array(
			'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
			'color'	=> array('argb' => 'FFFFFF')
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


date_default_timezone_set('America/Caracas');


	$resultado=$conector->Ejecutar($sql);
	$i =4; 
	$sub_total = 0;
    $descuento = 0;
    $total = 0;
    while (odbc_fetch_row($resultado)){
		$sub_total = $sub_total + odbc_result($resultado,'sub_total');
        $descuento = $descuento + odbc_result($resultado,'descuento');
		$iva =$iva + odbc_result($resultado,'iva');
		$total = $total + odbc_result($resultado,'total');
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$i,$i-3)
			->setCellValue('B'.$i,utf8_encode(odbc_result($resultado,'NOMBRE_SERVICIO')))
			->setCellValue('C'.$i,odbc_result($resultado,'sub_total'))
			->setCellValue('D'.$i,odbc_result($resultado,'descuento'))
			->setCellValue('E'.$i,odbc_result($resultado,'iva'))
			->setCellValue('F'.$i,odbc_result($resultado,'total'));
			$i++;
		
	}
		
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C'.$i,number_format($sub_total,2,',','.'))
			->setCellValue('D'.$i,number_format($descuento,2,',','.'))
			->setCellValue('E'.$i,number_format($iva,2,',','.'))
			->setCellValue('F'.$i,number_format($total,2,',','.'));
			$i++;	
		
	
	
$estiloTituloReporte = array(
		'font' => array(
			'name'      => 'Verdana',
			'bold'      => true,
			'italic'    => false,
			'strike'    => false,
			'size' =>16,
				'color'     => array(
					'rgb' => '000000'
				)
		),
		'fill' => array(
			'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
			'color'	=> array('argb' => 'FFFFFF')
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
				'rgb' => 'FFFFFF'
			)
		),
		'fill' 	=> array(
			'type'		=> PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
			'rotation'   => 90,
			'startcolor' => array(
				'rgb' => 'c47cf2'
			),
			'endcolor'   => array(
				'argb' => 'FF431a5d'
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
					'rgb' => 'ffffff'
				)
			)             
		)
	));
	 
	
		$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->applyFromArray($estiloTituloColumnas);	
	 //$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:A".($i-1));
			
	
		for($i = 'A'; $i <= 'F'; $i++)
		{
			$objPHPExcel->setActiveSheetIndex(0)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}
	
		
	
	// Se asigna el nombre a la hoja
	$objPHPExcel->getActiveSheet()->setTitle('INGRESOS');

	// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
	$objPHPExcel->setActiveSheetIndex(0);
	// Inmovilizar paneles 
	//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
	$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

	// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="REPORTE_ingresos.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;


?>

