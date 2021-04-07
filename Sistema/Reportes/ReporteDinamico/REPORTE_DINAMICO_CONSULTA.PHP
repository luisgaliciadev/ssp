<?php
	$Nivel="../../../";	
	include($Nivel."includes/funciones.php");
	
	$conector=Conectar();
	
	session_start();
	
	$ID_REP_DIN=$_GET['ID_REP_DIN'];
	
	$CamposColumnas=$_GET['CamposColumnas'];	
	$TIPO_CAMPO_HTML=$_GET['TIPO_CAMPO_HTML'];	
	$SELECT_FLAG=$_GET['SELECT_FLAG'];		
	
	$ArregloCamposColumnas=explode(",",$CamposColumnas);
	$CantidadCamposColumnas=count($ArregloCamposColumnas);
	
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
	
	$POSI=strpos($SENTENCIA_SQL, "FROM");
	$SENTENCIA_SQL=substr($SENTENCIA_SQL, $POSI, strlen($SENTENCIA_SQL));
	
	$vSQL="SELECT TOP 15 ".$CamposColumnas." ".$SENTENCIA_SQL." ".$CadBus;
	
	//echo $vSQL;
	//exit;
	
	if($result=$conector->Ejecutar($vSQL))
	{
		$pintar=0;
		
		while(odbc_fetch_row($result))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
?> 
		<tr <?php echo $clase?>>
<?php 
			for($Ite=1; $Ite<=$CantidadCamposColumnas; $Ite++)
			{
				switch($ArregloTIPO_CAMPO_HTML[$Ite-1])
				{
					case "DATEPICKER":
						$Campo=fecha_normal(odbc_result($result, $Ite));
					break;
					
					case "SELECT":
						if($ArregloSELECT_FLAG[$Ite-1])
						{
							$Campo=odbc_result($result, $Ite);
							
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
							$Campo=odbc_result($result, $Ite);
						}
					break;
					
					default:
						$Campo=odbc_result($result, $Ite);
					break;
				}
?> 
				<td><?php echo $Campo;?></td>
<?php 
			}
?> 
		</tr>
<?php 
		}
	}
	else
	{
		echo $vSQL;
	}
?>