<?php	
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();

	$ID_MODULO=$_POST["ID_MODULO"];
	$ID_MODULO_P=$_POST["ID_MODULO_P"];
	$ORDEN=$_POST["ORDEN"];
	$ID_ROL=$_POST["ID_ROL"];
	$Direccion=$_POST["Direccion"];
	
	if($Direccion==1)
	{
		$ORDE_AUX=$ORDEN-1;
		
		$vSQL="UPDATE TB_ADMIN_USU_MODULO SET ORDEN=$ORDE_AUX WHERE ID_MODULO=$ID_MODULO";
		
		$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
		$CONEXION=$ResultadoEjecutar["CONEXION"];
		
		if($CONEXION=="SI")
		{
			$Arreglo["CONEXION"]=$CONEXION;
			
			$ERROR=$ResultadoEjecutar["ERROR"];
		
			if($ERROR=="NO")
			{
				$Arreglo["ERROR"]=$ERROR;
			
				$vSQL="SELECT        
							ID_MODULO
						FROM            
							dbo.TB_ADMIN_USU_MODULO
						WHERE        
							(FG_ACTIVO = 1) AND (ID_MODULO_P = $ID_MODULO_P) AND (ID_MODULO <> $ID_MODULO) AND (ORDEN >= $ORDE_AUX)
						ORDER BY ORDEN ASC";
	
				$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
				$CONEXION=$ResultadoEjecutar["CONEXION"];
				
				if($CONEXION=="SI")
				{
					$Arreglo["CONEXION"]=$CONEXION;
					
					$ERROR=$ResultadoEjecutar["ERROR"];
				
					if($ERROR=="NO")
					{
						$Arreglo["ERROR"]=$ERROR;
						
						$rs=$ResultadoEjecutar["RESULTADO"];						
											
						while(odbc_fetch_array($rs))
						{
							$ID_MODULO_H=odbc_result($rs,"ID_MODULO");
							
							$ORDE_AUX++;
							
							$vSQL="UPDATE TB_ADMIN_USU_MODULO SET ORDEN=$ORDE_AUX WHERE ID_MODULO=$ID_MODULO_H";
					
							$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
							$CONEXION=$ResultadoEjecutar["CONEXION"];
							
							if($CONEXION=="SI")
							{
								$Arreglo["CONEXION"]=$CONEXION;
								
								$ERROR=$ResultadoEjecutar["ERROR"];
							
								if($ERROR=="NO")
								{
									$Arreglo["ERROR"]=$ERROR;
									
									echo json_encode($Arreglo);
									
									$Conector->Cerrar();
									
									exit;
								}
								else
								{
									$Arreglo["ERROR"]=$ERROR;
									$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];
									
									echo json_encode($Arreglo);
									
									$Conector->Cerrar();
									
									exit;
								}
							}
							else
							{
								$Arreglo["CONEXION"]="NO";
								$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];	
									
								echo json_encode($Arreglo);
								
								$Conector->Cerrar();
								
								exit;	
							}
						}
					}
					else
					{
						$Arreglo["ERROR"]=$ERROR;
						$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];
			
						echo json_encode($Arreglo);
						
						$Conector->Cerrar();
						
						exit;
					}
				}
				else
				{
					$Arreglo["CONEXION"]="NO";
					$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];		
			
					echo json_encode($Arreglo);
					
					$Conector->Cerrar();
					
					exit;
				}
			}
			else
			{
				$Arreglo["ERROR"]=$ERROR;
				$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];
				
				echo json_encode($Arreglo);
				
				$Conector->Cerrar();
				
				exit;
			}
		}
		else
		{
			$Arreglo["CONEXION"]="NO";
			$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];		
			
			echo json_encode($Arreglo);
			
			$Conector->Cerrar();
			
			exit;
		}
	}
	else
	{
		$ORDE_AUX=$ORDEN+1;
		
		$vSQL="UPDATE TB_ADMIN_USU_MODULO SET ORDEN=$ORDE_AUX WHERE ID_MODULO=$ID_MODULO";
		
		$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
		$CONEXION=$ResultadoEjecutar["CONEXION"];
		
		if($CONEXION=="SI")
		{
			$Arreglo["CONEXION"]=$CONEXION;
			
			$ERROR=$ResultadoEjecutar["ERROR"];
		
			if($ERROR=="NO")
			{
				$Arreglo["ERROR"]=$ERROR;
				
				$vSQL="SELECT        
							ID_MODULO
						FROM            
							dbo.TB_ADMIN_USU_MODULO
						WHERE        
							(FG_ACTIVO = 1) AND (ID_MODULO_P = $ID_MODULO_P) AND (ID_MODULO <> $ID_MODULO) AND (ORDEN = $ORDE_AUX)
						ORDER BY ORDEN ASC";
		
				$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
				$CONEXION=$ResultadoEjecutar["CONEXION"];
				
				if($CONEXION=="SI")
				{					
					$ERROR=$ResultadoEjecutar["ERROR"];
				
					if($ERROR=="NO")
					{						
						$rs=$ResultadoEjecutar["RESULTADO"];	
						
						$ID_MODULO_H=odbc_result($rs,"ID_MODULO");
						
						$ORDE_AUX--;
						
						$vSQL="UPDATE TB_ADMIN_USU_MODULO SET ORDEN=$ORDE_AUX WHERE ID_MODULO=$ID_MODULO_H";
				
						$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
						$CONEXION=$ResultadoEjecutar["CONEXION"];
						
						if($CONEXION=="SI")
						{
							$Arreglo["CONEXION"]=$CONEXION;
							
							$ERROR=$ResultadoEjecutar["ERROR"];
						
							if($ERROR=="NO")
							{
								$Arreglo["ERROR"]=$ERROR;
									
								echo json_encode($Arreglo);
								
								$Conector->Cerrar();
								
								exit;								
							}
							else
							{
								$Arreglo["ERROR"]=$ERROR;
								$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];
								
								echo json_encode($Arreglo);
								
								$Conector->Cerrar();
								
								exit;
							}
						}
						else
						{
							$Arreglo["CONEXION"]="NO";
							$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];	
							
							echo json_encode($Arreglo);
							
							$Conector->Cerrar();
							
							exit;	
						}
					}
					else
					{
						$Arreglo["ERROR"]=$ERROR;
						$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];
			
						echo json_encode($Arreglo);
						
						$Conector->Cerrar();
						
						exit;
					}
				}
				else
				{
					$Arreglo["CONEXION"]="NO";
					$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];		
			
					echo json_encode($Arreglo);
					
					$Conector->Cerrar();
					
					exit;
				}
			}
			else
			{
				$Arreglo["ERROR"]=$ERROR;
				$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];
				
				echo json_encode($Arreglo);
				
				$Conector->Cerrar();
				
				exit;
			}
		}
		else
		{
			$Arreglo["CONEXION"]="NO";
			$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];		
			
			echo json_encode($Arreglo);
			
			$Conector->Cerrar();
			
			exit;
		}
	}
?>