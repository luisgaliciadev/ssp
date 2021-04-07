<?php
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();

	$ID_MODULO=$_POST["ID_MODULO"];
	$ID_ROL=$_POST["ID_ROL"];
	$FG_SUB_MODULO=$_POST["FG_SUB_MODULO"];
	$CHECK=$_POST["CHECK"];
	
	if($FG_SUB_MODULO==1)
	{
		AsigDesaModulo($ID_MODULO, $ID_ROL, $CHECK, $Conector);
		
		$vSQL="SELECT * FROM TB_ADMIN_USU_MODULO WHERE ID_MODULO_P=$ID_MODULO";
			
		$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

		$CONEXION=$ResultadoEjecutar["CONEXION"];						
		$ERROR=$ResultadoEjecutar["ERROR"];					
		$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];		
		$rs=$ResultadoEjecutar["RESULTADO"];
		
		if($CONEXION=="SI" and $ERROR=="NO")
		{		
			$CantidadModulos=odbc_num_rows($rs);
			
			if($CantidadModulos)
			{
				while($row = odbc_fetch_array($rs))
				{
					$ID_MODULO_AUX=$row['ID_MODULO'];	
					
					AsigDesaModulo($ID_MODULO_AUX, $ID_ROL, $CHECK, $Conector);
				}
			}		
		}
		else
		{	
			$Arreglo["CONEXION"]=$CONEXION;
			$Arreglo["ERROR"]=$ERROR;
			$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
			
			echo json_encode($Arreglo);
			
			$Conector->Cerrar();
			
			exit;
		}
		
		$vSQL="SELECT * FROM TB_ADMIN_USU_MODULO WHERE ID_MODULO=$ID_MODULO";
		
		$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

		$CONEXION=$ResultadoEjecutar["CONEXION"];						
		$ERROR=$ResultadoEjecutar["ERROR"];					
		$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];		
		$rs=$ResultadoEjecutar["RESULTADO"];
		
		if($CONEXION=="SI" and $ERROR=="NO")
		{		
			$row = odbc_fetch_array($rs);
			
			$ID_MODULO_P=$row['ID_MODULO_P'];	
			
			$vSQL="SELECT * FROM TB_ADMIN_USU_MODULO WHERE ID_MODULO_P=$ID_MODULO_P AND TB_ADMIN_USU_MODULO.FG_ACTIVO=1";
		
			$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

			$CONEXION=$ResultadoEjecutar["CONEXION"];						
			$ERROR=$ResultadoEjecutar["ERROR"];					
			$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];		
			$rs=$ResultadoEjecutar["RESULTADO"];
			
			if($CONEXION=="SI" and $ERROR=="NO")
			{		
				$CantidadModulos=odbc_num_rows($rs);
				
				$vSQL="
						SELECT        
							COUNT(dbo.TB_ADMIN_USU_ROL_MODULO.ID_MODULO) AS CANTIDAD, dbo.TB_ADMIN_USU_MODULO.ID_MODULO_P, dbo.TB_ADMIN_USU_ROL.ID_ROL
						FROM            
							dbo.TB_ADMIN_USU_ROL_MODULO INNER JOIN
                         	dbo.TB_ADMIN_USU_MODULO AS MODULO_1 ON dbo.TB_ADMIN_USU_ROL_MODULO.ID_MODULO = MODULO_1.ID_MODULO INNER JOIN
                         	dbo.TB_ADMIN_USU_MODULO ON MODULO_1.ID_MODULO = dbo.TB_ADMIN_USU_MODULO.ID_MODULO INNER JOIN
                         	dbo.TB_ADMIN_USU_ROL ON dbo.TB_ADMIN_USU_ROL_MODULO.ID_ROL = dbo.TB_ADMIN_USU_ROL.ID_ROL
						WHERE        
							dbo.TB_ADMIN_USU_MODULO.FG_ACTIVO = 1 AND 
							dbo.TB_ADMIN_USU_MODULO.ID_MODULO_P = $ID_MODULO_P AND 
							dbo.TB_ADMIN_USU_ROL_MODULO.ID_ROL = $ID_ROL
						GROUP BY dbo.TB_ADMIN_USU_MODULO.ID_MODULO_P, dbo.TB_ADMIN_USU_ROL.ID_ROL";

				$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

				$CONEXION=$ResultadoEjecutar["CONEXION"];						
				$ERROR=$ResultadoEjecutar["ERROR"];					
				$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];		
				$rs=$ResultadoEjecutar["RESULTADO"];
				
				if($CONEXION=="SI" and $ERROR=="NO")
				{		
					$CantidadModulosAsigDesa=odbc_result($rs,"CANTIDAD");		
					
					if($CantidadModulosAsigDesa==0)
					{
						AsigDesaModulo($ID_MODULO_P, $ID_ROL, "checked", $Conector);
					}
					else
					{
						AsigDesaModulo($ID_MODULO_P, $ID_ROL, "", $Conector);
					}	
				}
				else
				{	
					$Arreglo["CONEXION"]=$CONEXION;
					$Arreglo["ERROR"]=$ERROR;
					$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
					
					echo json_encode($Arreglo);
					
					$Conector->Cerrar();
					
					exit;
				}	
			}
			else
			{	
				$Arreglo["CONEXION"]=$CONEXION;
				$Arreglo["ERROR"]=$ERROR;
				$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
				
				echo json_encode($Arreglo);
				
				$Conector->Cerrar();
				
				exit;
			}	
		}
		else
		{	
			$Arreglo["CONEXION"]=$CONEXION;
			$Arreglo["ERROR"]=$ERROR;
			$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
			
			echo json_encode($Arreglo);
			
			$Conector->Cerrar();
			
			exit;
		}
		
		
		$Arreglo["Error"]=0;
		echo json_encode($Arreglo);
		$Conector->Cerrar();
		exit;
	}
	else
	{
		if($FG_SUB_MODULO==2)
		{
			AsigDesaModulo($ID_MODULO, $ID_ROL, $CHECK, $Conector);
			
			$vSQL="SELECT * FROM TB_ADMIN_USU_MODULO WHERE ID_MODULO=$ID_MODULO";
			
			$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

			$CONEXION=$ResultadoEjecutar["CONEXION"];						
			$ERROR=$ResultadoEjecutar["ERROR"];					
			$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];		
			$rs=$ResultadoEjecutar["RESULTADO"];
			
			if($CONEXION=="SI" and $ERROR=="NO")
			{		
				$row = odbc_fetch_array($rs);
				
				$ID_MODULO_P=$row['ID_MODULO_P'];	
				
				$vSQL="SELECT * FROM TB_ADMIN_USU_MODULO WHERE ID_MODULO_P=$ID_MODULO_P AND FG_ACTIVO=1";
			
				$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

				$CONEXION=$ResultadoEjecutar["CONEXION"];						
				$ERROR=$ResultadoEjecutar["ERROR"];					
				$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];		
				$rs2=$ResultadoEjecutar["RESULTADO"];
				
				if($CONEXION=="SI" and $ERROR=="NO")
				{		
					$CantidadModulos=odbc_num_rows($rs2);
					
					$vSQL="SELECT * FROM TB_ADMIN_USU_MODULO WHERE ID_MODULO=$ID_MODULO_P";
			
					$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

					$CONEXION=$ResultadoEjecutar["CONEXION"];						
					$ERROR=$ResultadoEjecutar["ERROR"];					
					$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];		
					$rs2=$ResultadoEjecutar["RESULTADO"];
					
					if($CONEXION=="SI" and $ERROR=="NO")
					{		
						$row = odbc_fetch_array($rs2);
						
						$ID_MODULO_P2=$row['ID_MODULO_P'];
									
						$vSQL="SELECT        COUNT(dbo.TB_ADMIN_USU_ROL_MODULO.ID_MODULO) AS CANTIDAD, dbo.TB_ADMIN_USU_MODULO.ID_MODULO_P, dbo.TB_ADMIN_USU_ROL.ID_ROL
FROM            dbo.TB_ADMIN_USU_ROL_MODULO INNER JOIN
                         dbo.TB_ADMIN_USU_MODULO AS MODULO_1 ON dbo.TB_ADMIN_USU_ROL_MODULO.ID_MODULO = MODULO_1.ID_MODULO INNER JOIN
                         dbo.TB_ADMIN_USU_MODULO ON MODULO_1.ID_MODULO = dbo.TB_ADMIN_USU_MODULO.ID_MODULO INNER JOIN
                         dbo.TB_ADMIN_USU_ROL ON dbo.TB_ADMIN_USU_ROL_MODULO.ID_ROL = dbo.TB_ADMIN_USU_ROL.ID_ROL
WHERE        (dbo.TB_ADMIN_USU_MODULO.FG_ACTIVO = 1) AND ID_MODULO_P = $ID_MODULO_P AND 
									ID_ROL = $ID_ROL
GROUP BY dbo.TB_ADMIN_USU_MODULO.ID_MODULO_P, dbo.TB_ADMIN_USU_ROL.ID_ROL
";
				
						$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

						$CONEXION=$ResultadoEjecutar["CONEXION"];						
						$ERROR=$ResultadoEjecutar["ERROR"];					
						$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];		
						$rs=$ResultadoEjecutar["RESULTADO"];
						
						if($CONEXION=="SI" and $ERROR=="NO")
						{		
							$CantidadModulosAsigDesa=odbc_result($rs,"CANTIDAD");
							
							if($CantidadModulosAsigDesa==0)
							{
								AsigDesaModulo($ID_MODULO_P, $ID_ROL, "checked", $Conector);
								AsigDesaModulo($ID_MODULO_P2, $ID_ROL, "checked", $Conector);
							}
							else
							{
								if(!VerificarExiste($ID_MODULO_P, $ID_ROL, $Conector))
								{
									AsigDesaModulo($ID_MODULO_P, $ID_ROL, "", $Conector);
								}
								
								if(!VerificarExiste($ID_MODULO_P2, $ID_ROL, $Conector))
								{
									AsigDesaModulo($ID_MODULO_P2, $ID_ROL, "", $Conector);
								}
							}		
						}
						else
						{	
							$Arreglo["CONEXION"]=$CONEXION;
							$Arreglo["ERROR"]=$ERROR;
							$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
							
							echo json_encode($Arreglo);
							
							$Conector->Cerrar();
							
							exit;
						}	
					}
					else
					{	
						$Arreglo["CONEXION"]=$CONEXION;
						$Arreglo["ERROR"]=$ERROR;
						$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
						
						echo json_encode($Arreglo);
						
						$Conector->Cerrar();
						
						exit;
					}	
				}
				else
				{	
					$Arreglo["CONEXION"]=$CONEXION;
					$Arreglo["ERROR"]=$ERROR;
					$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
					
					echo json_encode($Arreglo);
					
					$Conector->Cerrar();
					
					exit;
				}	
			}
			else
			{	
				$Arreglo["CONEXION"]=$CONEXION;
				$Arreglo["ERROR"]=$ERROR;
				$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
				
				echo json_encode($Arreglo);
				
				$Conector->Cerrar();
				
				exit;
			}
			
			$Arreglo["CONEXION"]=$CONEXION;
			$Arreglo["ERROR"]=$ERROR;
			
			echo json_encode($Arreglo);
			
			$Conector->Cerrar();
			
			exit;
		}
		else
		{
			AsigDesaModulo($ID_MODULO, $ID_ROL, $CHECK, $Conector);
			
			$vSQL="SELECT * FROM TB_ADMIN_USU_MODULO WHERE ID_MODULO_P=$ID_MODULO";
			
			$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

			$CONEXION=$ResultadoEjecutar["CONEXION"];						
			$ERROR=$ResultadoEjecutar["ERROR"];					
			$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];		
			$rs=$ResultadoEjecutar["RESULTADO"];
			
			if($CONEXION=="SI" and $ERROR=="NO")
			{		
				$CantidadModulos=odbc_num_rows($rs);
				
				if($CantidadModulos)
				{
					while($row = odbc_fetch_array($rs))
					{
						$ID_MODULO_AUX=$row['ID_MODULO'];
						
						if(VerificarExiste($ID_MODULO_AUX, $ID_ROL, $Conector)==0 and $CHECK=="")
						{
							AsigDesaModulo($ID_MODULO_AUX, $ID_ROL, $CHECK, $Conector);
						}
						
						$vSQL="SELECT * FROM TB_ADMIN_USU_MODULO WHERE ID_MODULO_P=$ID_MODULO_AUX";
			
						$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

						$CONEXION=$ResultadoEjecutar["CONEXION"];						
						$ERROR=$ResultadoEjecutar["ERROR"];					
						$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];		
						$rs2=$ResultadoEjecutar["RESULTADO"];
						
						if($CONEXION=="SI" and $ERROR=="NO")
						{		
							$CantidadModulos=odbc_num_rows($rs2);
							
							if($CantidadModulos)
							{
								while($row2 = odbc_fetch_array($rs2))
								{
									$ID_MODULO_AUX2=$row2['ID_MODULO'];	
									
									if(VerificarExiste($ID_MODULO_AUX2, $ID_ROL, $Conector)==0 and $CHECK=="")
									{
										AsigDesaModulo($ID_MODULO_AUX2, $ID_ROL, $CHECK, $Conector);
									}
								}
							}	
						}
						else
						{	
							$Arreglo["CONEXION"]=$CONEXION;
							$Arreglo["ERROR"]=$ERROR;
							$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
							
							echo json_encode($Arreglo);
							
							$Conector->Cerrar();
							
							exit;
						}
					}
				}
				
				$Arreglo["CONEXION"]=$CONEXION;
				$Arreglo["ERROR"]=$ERROR;
				
				echo json_encode($Arreglo);
				
				$Conector->Cerrar();
				
				exit;		
			}
			else
			{	
				$Arreglo["CONEXION"]=$CONEXION;
				$Arreglo["ERROR"]=$ERROR;
				$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
				
				echo json_encode($Arreglo);
				
				$Conector->Cerrar();
				
				exit;
			}
		}
	}
	
	function AsigDesaModulo($ID_MODULO, $ID_ROL, $CHECK, $Conector)
	{
		if($CHECK=="checked")
		{
			$vSQL="DELETE FROM TB_ADMIN_USU_ROL_MODULO WHERE ID_MODULO=$ID_MODULO AND ID_ROL=$ID_ROL";
		}
		else
		{
			$vSQL="INSERT INTO TB_ADMIN_USU_ROL_MODULO (ID_MODULO, ID_ROL) VALUES($ID_MODULO, $ID_ROL)";
		}
		
		$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

		$CONEXION=$ResultadoEjecutar["CONEXION"];						
		$ERROR=$ResultadoEjecutar["ERROR"];					
		$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];		
		$rs=$ResultadoEjecutar["RESULTADO"];
		
		if($CONEXION=="SI" and $ERROR=="SI")
		{			
			$Arreglo["CONEXION"]=$CONEXION;
			$Arreglo["ERROR"]=$ERROR;
			$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
			
			echo json_encode($Arreglo);
			
			$Conector->Cerrar();
			
			exit;
		}
	}
	
	function VerificarExiste($ID_MODULO, $ID_ROL, $Conector)
	{
		$vSQL="SELECT 
					COUNT(dbo.TB_ADMIN_USU_MODULO.ID_MODULO) as CantidadModulosAsigDesa
				FROM            
					dbo.TB_ADMIN_USU_ROL_MODULO INNER JOIN
					dbo.TB_ADMIN_USU_MODULO AS MODULO_1 ON dbo.TB_ADMIN_USU_ROL_MODULO.ID_MODULO = MODULO_1.ID_MODULO INNER JOIN
					dbo.TB_ADMIN_USU_MODULO ON MODULO_1.ID_MODULO = dbo.TB_ADMIN_USU_MODULO.ID_MODULO INNER JOIN
					dbo.TB_ADMIN_USU_ROL ON dbo.TB_ADMIN_USU_ROL_MODULO.ID_ROL = dbo.TB_ADMIN_USU_ROL.ID_ROL
				WHERE        
					(dbo.TB_ADMIN_USU_MODULO.ID_MODULO = $ID_MODULO) AND 
					(dbo.TB_ADMIN_USU_ROL.ID_ROL = $ID_ROL) AND TB_ADMIN_USU_MODULO.FG_ACTIVO=1";
		
		$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

		$CONEXION=$ResultadoEjecutar["CONEXION"];						
		$ERROR=$ResultadoEjecutar["ERROR"];					
		$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];		
		$rs=$ResultadoEjecutar["RESULTADO"];
		
		if($CONEXION=="SI" and $ERROR=="NO")
		{
			$CantidadModulosAsigDesa=odbc_result($rs,"CantidadModulosAsigDesa");
			
			return $CantidadModulosAsigDesa;				
		}
		else
		{	
			$Arreglo["CONEXION"]=$CONEXION;
			$Arreglo["ERROR"]=$ERROR;
			$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
			
			echo json_encode($Arreglo);
			
			$Conector->Cerrar();
			
			exit;
		}
	}
?>