<?php
	$Nivel="../../../../";
	include($Nivel."includes/PHP/funciones.php");
		
	$consulta = $_POST["consulta"];
	$solicitud = $_POST["solicitud"];
	$nb_procedure = $_POST["nb_procedure"];
	$conector = $_POST["conector"];
	$formato = $_POST["formato"];
	$stipo = $_POST["stipo"];
	$agente = $_POST["agente"];
	$rif = $_POST["rif"];


	session_start();	

	$RIF=$_SESSION[$_SESSION['SiglasSistema'].'RIF'];
	$USUARIO_CRE_WEB=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];	
	$LOCALIDAD=$_SESSION[$_SESSION['SiglasSistema'].'ID_LOCALIDAD'];	

	if($conector=="Conectar2()")
	{
		$Conector=Conectar2();
		$vSQL="EXEC $nb_procedure $solicitud,$LOCALIDAD, '$USUARIO_CRE_WEB',0,0";
	}
	else
		if($conector=="Conectar3()")
		{
			$Conector=Conectar3();
			
			//buscar quien genero la solicitud de muelle 
			
			
			if($stipo==10)// estiba carga y descarga 
			{
				//$vSQL="EXEC SP_INSERT_PRE_CARGA_DESCARGA_SASPWEB $solicitud,'$agente','$USUARIO_CRE_WEB'";
				
				 $vSQL="EXEC [dbo].[SP_INSERT_DATA_SASPWEB] 'J305767696',23852";
				
				$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
							
				echo $CONEXION=$ResultadoEjecutar["CONEXION"];						
				echo $ERROR=$ResultadoEjecutar["ERROR"];
				 $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
				$result=$ResultadoEjecutar["RESULTADO"];
				if($CONEXION=="SI" and $ERROR=="NO")
				{		
					$RESULTADO=odbc_result($resultPrin,"RESULTADO");
					if($RESULTADO==1)//TRANSFERENCIA DE DATA EXITOSA DE SASP A SOE 
					{
						$vSQL="EXEC $nb_procedure $solicitud,'$agente', '$USUARIO_CRE_WEB'";
					}
				}
				else
				{	
						echo $MSJ_ERROR;
						exit;
				}
				//$Conector->Cerrar();
						
				
			}
			else
			{
				$vSQL="EXEC $nb_procedure $solicitud,'$agente', '$USUARIO_CRE_WEB'";
			}
			
			
		}

	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{				
		$MENSAJE=odbc_result($resultPrin,"MENSAJE");
		$ID_PRELIQ=odbc_result($resultPrin,"ID");

		$Arreglo["MENSAJE"]=$MENSAJE;
		$Arreglo["ID_SM"]=$ID_PRELIQ;
		$Arreglo["ERROR"]=$ERROR;
		
		
		if(($stipo==10)  &&($RESULTADO==1) )
		{
			$Conector=Conectar2();
			$vSQL="exec [web].[SP_ACTUALIZAR_PLANILLA_PRELIQ_CARGA_DESCARGA] $ID_PRELIQ,$solicitud,'$rif'";
			//echo $vSQL;
			$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
							
			$CONEXION=$ResultadoEjecutar["CONEXION"];						
			$ERROR=$ResultadoEjecutar["ERROR"];
			$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
			$result=$ResultadoEjecutar["RESULTADO"];
			if($CONEXION=="SI" and $ERROR=="NO")
			{		
				
			}
			else
			{	
					echo $MSJ_ERROR;
					exit;
			}
			$Conector->Cerrar();
		}
		
		
		if(($stipo==11))
		{
			
			$Conector=Conectar2();
			$vSQL="exec [web].[SP_ACTUALIZAR_PLANILLA_PRELIQ] $ID_PRELIQ,$solicitud,'$rif'";
			//echo $vSQL;
			$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
							
			$CONEXION=$ResultadoEjecutar["CONEXION"];						
			$ERROR=$ResultadoEjecutar["ERROR"];
			$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
			$result=$ResultadoEjecutar["RESULTADO"];
			if($CONEXION=="SI" and $ERROR=="NO")
			{		
				
			}
			else
			{	
					echo $MSJ_ERROR;
					exit;
			}
			$Conector->Cerrar();
			
			
		}
		
	}
	else
	{
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
	}
		
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();

?>