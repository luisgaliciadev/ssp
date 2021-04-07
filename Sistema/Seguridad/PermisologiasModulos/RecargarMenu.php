<?php	
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Nivel="Sistema/Seguridad/PermisologiasModulos/";
	
	$Conector=Conectar();

	$ID_ROL=$_GET["ID_ROL"];
	$CadMenusActivados=$_GET["CadMenusActivados"];
	
	$ArregloMenusActivados = explode(";", $CadMenusActivados);
	
	$vSQL="EXEC SP_CONSTRUIR_MENU_ROL $ID_ROL";
						
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];						
	$ERROR=$ResultadoEjecutar["ERROR"];					
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];		
	$resultPrin=$ResultadoEjecutar["RESULTADO"];
	
	if($CONEXION=="SI" and $ERROR=="NO")
	{						
		$Ite=1;
		
		while($registros[$Ite]=odbc_fetch_array($resultPrin))
		{				
			$Ite++;
		}
		
		$Cont1=0;
		
		foreach ($registros as &$registro1) 
		{
			if($registro1["NIVEL"]==1)
			{
				$Cont1++;
				
				$NIVEL=$registro1["NIVEL"];
				$ORDEN=$registro1["ORDEN"];
				$ID_MODULO1=$registro1["ID_MODULO"];
				$NB_MODULO=utf8_encode($registro1["NB_MODULO"]);
				$TIPO_MENU=$registro1["TIPO_MENU"];
				$FG_SUB_MODULO=$registro1["FG_SUB_MODULO"];
				$TIENE=$registro1["TIENE"];
					
				$CantidadHijos=CantidadHijos($registros, $ID_MODULO1);
				$CantidadHermanos=CantidadHijos($registros, -1);
				
				if($TIENE)
				{
					$CheckM='<a href="javascript: " onClick="AsigDesaModulo('.$ID_MODULO1.', '.$ID_ROL.', '.$FG_SUB_MODULO.', \'checked\');" alt="Desasignar Modulo"><img src="'.$Nivel.'Imagenes/check1.png" width="13" height="13"  alt="Desasignar Modulo"/></a>';
				}
				else
				{
					$CheckM='<a href="javascript: " onClick="AsigDesaModulo('.$ID_MODULO1.', '.$ID_ROL.', '.$FG_SUB_MODULO.', \'\');"  alt="Asignar Modulo"><img src="'.$Nivel.'Imagenes/check0.png" width="13" height="13"  alt="Asignar Modulo"/></a>';
				}
				
				if (in_array($ID_MODULO1, $ArregloMenusActivados)) 
				{
					$Cheked=' checked= ';
				}
				else
				{
					$Cheked='';
				}
				
				if($TIPO_MENU==2)
				{
					$Menu.='<li>
									<label for="'.$ID_MODULO1.'" id="M'.$ID_MODULO1.'">
										'.$NB_MODULO.' 
										'.$CheckM.'
									</label> 
									<input type="checkbox" id="'.$ID_MODULO1.'" onClick="CKNivel(\''.$ID_MODULO1.'\')" '.$Cheked.'/>';
				}
				else
				{
					if($TIPO_MENU==1)
					{
						$Menu.='<li>
									<label for="'.$ID_MODULO1.'" id="M'.$ID_MODULO1.'">
										'.$NB_MODULO.' 
										'.$CheckM.'
									</label> 
									<input type="checkbox" id="'.$ID_MODULO1.'" onClick="CKNivel(\''.$ID_MODULO1.'\')" '.$Cheked.'/>';
					}
					else
					{						
						$Menu.='<li>
									<label for="'.$ID_MODULO1.'" id="M'.$ID_MODULO1.'">
										'.$NB_MODULO.' 
										'.$CheckM.'
									</label> 
									<input type="checkbox" id="'.$ID_MODULO1.'" onClick="CKNivel(\''.$ID_MODULO1.'\')" '.$Cheked.'/>';
					}
				
					if($CantidadHijos)
					{
						$Menu.="<ol>";						
						
						$Cont2=0;
						
						foreach ($registros as &$registro2) 
						{
							if($registro2["NIVEL"]==2 and $registro2["ID_MODULO_P"]==$ID_MODULO1)
							{
								$Cont2++;
								
								$NIVEL=$registro2["NIVEL"];
								$ORDEN=$registro2["ORDEN"];
								$ID_MODULO2=$registro2["ID_MODULO"];
								$NB_MODULO=utf8_encode($registro2["NB_MODULO"]);
								$TIPO_MENU=$registro2["TIPO_MENU"];
								$FG_SUB_MODULO=$registro2["FG_SUB_MODULO"];
								$TIENE=$registro2["TIENE"];
									
								$CantidadHijos=CantidadHijos($registros, $ID_MODULO2);
								$CantidadHermanos=CantidadHijos($registros, $ID_MODULO1);
								
								if($TIENE)
								{
									$CheckM='<a href="javascript: " onClick="AsigDesaModulo('.$ID_MODULO2.', '.$ID_ROL.', '.$FG_SUB_MODULO.', \'checked\');"><img src="'.$Nivel.'Imagenes/check1.png" width="13" height="13"  alt="Desasignar Modulo"/></a>';
								}
								else
								{
									$CheckM='<a href="javascript: " onClick="AsigDesaModulo('.$ID_MODULO2.', '.$ID_ROL.', '.$FG_SUB_MODULO.', \'\');"><img src="'.$Nivel.'Imagenes/check0.png" width="13" height="13"  alt="Asignar Modulo"/></a>';
								}
								
								if (in_array($ID_MODULO2, $ArregloMenusActivados)) 
								{
									$Cheked=' checked= ';
								}
								else
								{
									$Cheked='';
								}
								
								if($TIPO_MENU==2)
								{
									$Menu.='';
								}
								else
								{
									if($TIPO_MENU==1)
									{
										$Menu.='<li>
													<label for="'.$ID_MODULO2.'" id="M'.$ID_MODULO2.'">  
														'.$NB_MODULO.' 
														'.$CheckM.'
													</label> 
													<input type="checkbox" id="'.$ID_MODULO2.'" onClick="CKNivel(\''.$ID_MODULO2.'\')" '.$Cheked.'/>';
									}
									else
									{
										$Menu.='
												<li>
													<label for="'.$ID_MODULO2.'" id="M'.$ID_MODULO2.'">
														'.$NB_MODULO.' 
														'.$CheckM.'
													</label> 
													<input type="checkbox" id="'.$ID_MODULO2.'" onClick="CKNivel(\''.$ID_MODULO2.'\')" '.$Cheked.'/>';
									}
								
									if($CantidadHijos)
									{							
										$Menu.="<ol>";						
										
										$Cont3=0;
		
										foreach ($registros as &$registro3) 
										{
											if($registro3["NIVEL"]==3 and $registro3["ID_MODULO_P"]==$ID_MODULO2)
											{
												$Cont3++;
												
												$NIVEL=$registro3["NIVEL"];
												$ORDEN=$registro3["ORDEN"];
												$ID_MODULO3=$registro3["ID_MODULO"];
												$NB_MODULO=utf8_encode($registro3["NB_MODULO"]);
												$TIPO_MENU=$registro3["TIPO_MENU"];
												$FG_SUB_MODULO=$registro3["FG_SUB_MODULO"];
												$TIENE=$registro3["TIENE"];
												
												$CantidadHijos=CantidadHijos($registros, $ID_MODULO3);
												$CantidadHermanos=CantidadHijos($registros, $ID_MODULO2);
								
												if($TIENE)
												{
													$CheckM='<a href="javascript: " onClick="AsigDesaModulo('.$ID_MODULO3.', '.$ID_ROL.', '.$FG_SUB_MODULO.', \'checked\');"><img src="'.$Nivel.'Imagenes/check1.png" width="13" height="13"  alt="Desasignar Modulo"/></a>';
												}
												else
												{
													$CheckM='<a href="javascript: " onClick="AsigDesaModulo('.$ID_MODULO3.', '.$ID_ROL.', '.$FG_SUB_MODULO.', \'\');"><img src="'.$Nivel.'Imagenes/check0.png" width="13" height="13"  alt="Asignar Modulo"/></a>';
												}
												
												if($TIPO_MENU==2)
												{
													$Menu.='';
												}
												else
												{
													if($TIPO_MENU==1)
													{
														$Menu.='';
													}
													else
													{
														$Menu.='
																<li style="padding-left:38px;">
																	'.$NB_MODULO.'
																	'.$CheckM.'
																</li>';
													}
												}
											}
										}
										
										$Menu.="</ol>";
									}
									
									$Menu.="</li>";
								}
							}
						}
						
						$Menu.="</ol>
							</li>";
					}
					
					$Menu.="</li>";
				}
			}
		}
		
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["Menu"]=$Menu;
	}
	else
	{	
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
	}
		
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();
	$Conector=Conectar();
	
	function CantidadHijos($registros, $ID_MODULO)
	{
		$CantidadHijos=0;
		
		foreach ($registros as &$registro) 
		{
			if($registro["ID_MODULO_P"]==$ID_MODULO)
			{
				$CantidadHijos++;
			}
		}
		
		return $CantidadHijos;
	}
?>