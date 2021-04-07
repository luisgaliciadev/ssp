<?php
	$Nivel="../../../";	
	include($Nivel."includes/funciones.php");
	
	$conector=Conectar();
	
	session_start();
	
	$ID_REP_DIN=$_GET['ID_REP_DIN'];
	$CamposColumnas=$_GET['CamposColumnas'];	
	
	$ArregloCamposColumnas=explode(",",$CamposColumnas);
	$CantidadCamposColumnas=count($ArregloCamposColumnas);
	
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
	
	$vSQL="SELECT TOP 15 ".$CamposColumnas." ".$SENTENCIA_SQL_SIN." ".$CadBus;
	
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
				//$Posi=strpos($ArregloCamposColumnas[$Ite],".");
				
				//$NombreCampo=substr($ArregloCamposColumnas[$Ite],$Posi+1,strlen($ArregloCamposColumnas[$Ite]));
?> 
				<td><?php echo odbc_result($result, $Ite);?></td>
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