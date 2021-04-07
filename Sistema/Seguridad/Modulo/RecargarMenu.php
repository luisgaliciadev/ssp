<?php
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");	
	
	$Nivel="Sistema/Seguridad/Modulo/";
	
	$Conector=Conectar();
	
	$CadMenusActivados=$_GET["CadMenusActivados"];
	$ID_MODULO_PM=$_GET["ID_MODULO_PM"];	
	
	$ArregloMenusActivados = explode(";", $CadMenusActivados);
	
	$vSQL="EXEC SP_CONSTRUIR_MENU_CONFIG";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];
	
	if($CONEXION=="SI")
	{
		$Arreglo["CONEXION"]="SI";
		
		$ERROR=$ResultadoEjecutar["ERROR"];
		
		if($ERROR=="NO")
		{	
			$Arreglo["ERROR"]=$ERROR;
			
			$Ite=1;
			
			$resultPrin=$ResultadoEjecutar["RESULTADO"];
		
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
						
					$CantidadHijos=CantidadHijos($registros, $ID_MODULO1);
					$CantidadHermanos=CantidadHijos($registros, -1);
					
					if (in_array($ID_MODULO1, $ArregloMenusActivados)) 
					{
						$Cheked=' checked="" ';
					}
					else
					{
						$Cheked='';
					}
					
					if($Cont1==1)
					{
						$Arriba="<img src='".$Nivel."Imagenes/arribaa.png' width='13' height='13'  alt=''/>";
					}
					else
					{
						$Arriba="<a href='javascript: ' onClick='ReordenarMenu($ID_MODULO1, -1, $ORDEN, 1)'><img src='".$Nivel."Imagenes/arriba.png' width='13' height='13'  alt=''/></a>";
					}
					
					if($CantidadHermanos==$Cont1)
					{
						$Abajo="<img src='".$Nivel."Imagenes/abajoa.png' width='13' height='13'  alt=''/>";
					}
					else
					{
						$Abajo="<a href='javascript: ' onClick='ReordenarMenu($ID_MODULO1, -1, $ORDEN, 0)'><img src='".$Nivel."Imagenes/abajo.png' width='13' height='13'  alt=''/></a>";
					}
					
					if($CantidadHijos>0)
					{
						$CadMenu1=$NB_MODULO;
						
						$CadEliminar1='';
					}
					else
					{
						$CadMenu1="
								<a href='javascript: ' onClick='vModal(\"Sistema/Seguridad/Modulo/FromModificarMenu.php?ID_MODULO_H=".$ID_MODULO1."&ID_MODULO_PM=".$ID_MODULO_PM."&FG_SUB_MODULO=".$FG_SUB_MODULO."\", \"Modificar Menu: <strong>".$NB_MODULO."</strong>\");'>
									".$NB_MODULO."
								</a>";
								
						$CadEliminar1='<a href="javascript: " onClick="EliminarMenu('.$ID_MODULO1.');"><img src="'.$Nivel.'Imagenes/eliminar.png" width="13" height="13"  alt=""/></a>';
					}
					
					if($TIPO_MENU==2)
					{
						$Menu.='<li>
								<label for="'.$ID_MODULO1.'" id="M'.$ID_MODULO1.'">
									'.$Arriba.' 
									'.$Abajo.' 
									'.$CadMenu1.'
									'.$CadEliminar1.' 
								</label> 
								<input type="checkbox" id="'.$ID_MODULO1.'" onClick="CKNivel(\''.$ID_MODULO1.'\')" '.$Cheked.'/>';
					}
					else
					{
						if($TIPO_MENU==1)
						{									
							$Menu.='<li>
									<label for="'.$ID_MODULO1.'" id="M'.$ID_MODULO1.'">
										'.$Arriba.' 
										'.$Abajo.' 
										'.$CadMenu1.' 
										'.$CadEliminar1.' 
										<a href="javascript: " onClick="vModal(\'Sistema/Seguridad/Modulo/FormAgregarMenu.php?ID_MODULO_P='.$ID_MODULO1.'&ID_MODULO_PM='.$ID_MODULO_PM.'&FG_SUB_MODULO=1\', \'Agregar SubMenu al Menu: <strong>'.$NB_MODULO.'</strong>\');">
											<img src=\''.$Nivel.'Imagenes/agregar.png\' width=\'13\' height=\'13\'  alt=\'\'/>
										</a>
									</label> 
									<input type="checkbox" id="'.$ID_MODULO1.'" onClick="CKNivel(\''.$ID_MODULO1.'\')" '.$Cheked.'/>';
						}
						else
						{															
							$Menu.='<li>
									<label for="'.$ID_MODULO1.'" id="M'.$ID_MODULO1.'">
										'.$Arriba.' 
										'.$Abajo.' 
										'.$CadMenu1.'
										'.$CadEliminar1.' 
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
										
									$CantidadHijos=CantidadHijos($registros, $ID_MODULO2);
									$CantidadHermanos=CantidadHijos($registros, $ID_MODULO1);
									
									if (in_array($ID_MODULO2, $ArregloMenusActivados)) 
									{
										$Cheked=' checked="" ';
									}
									else
									{
										$Cheked='';
									}
									
									if($Cont2==1)
									{
										$Arriba="<img src='".$Nivel."Imagenes/arribaa.png' width='13' height='13'  alt=''/>";
									}
									else
									{
										$Arriba="<a href='javascript: ' onClick='ReordenarMenu($ID_MODULO2, $ID_MODULO1, $ORDEN, 1)'><img src='".$Nivel."Imagenes/arriba.png' width='13' height='13'  alt=''/></a>";
									}
									
									if($CantidadHermanos==$Cont2)
									{
										$Abajo="<img src='".$Nivel."Imagenes/abajoa.png' width='13' height='13'  alt=''/>";
									}
									else
									{
										$Abajo="<a href='javascript: ' onClick='ReordenarMenu($ID_MODULO2, $ID_MODULO1, $ORDEN, 0)'><img src='".$Nivel."Imagenes/abajo.png' width='13' height='13'  alt=''/></a>";
									}
									
									$CadMenu1="";
									$CadEliminar1='';
									
									if($CantidadHijos>0)
									{
										$CadMenu1=$NB_MODULO;
										$CadEliminar1='<img src="'.$Nivel.'Imagenes/eliminara.png" width="13" height="13"  alt=""/>';
									}
									else
									{
										$CadMenu1="<a href='javascript: ' onClick='vModal(\"Sistema/Seguridad/Modulo/FromModificarMenu.php?ID_MODULO_P=".$ID_MODULO1."&ID_MODULO_H=".$ID_MODULO2."&ID_MODULO_PM=".$ID_MODULO_PM."&FG_SUB_MODULO=".$FG_SUB_MODULO."\", \"Modificar Menu: <strong>".$NB_MODULO."</strong>\");'>".$NB_MODULO."</a>";
										
										$CadEliminar1='<a href="javascript: " onClick="EliminarMenu('.$ID_MODULO2.');"><img src="'.$Nivel.'Imagenes/eliminar.png" width="13" height="13"  alt=""/></a>';
									}
									
									if($TIPO_MENU==2)
									{
										$Menu.='
												<li>
													<label for="'.$ID_MODULO2.'" id="M'.$ID_MODULO2.'">
														'.$Arriba.' 
														'.$Abajo.' 
														'.$CadMenu1.' 
														'.$CadEliminar1.'
													</label> 
													<input type="checkbox" id="'.$ID_MODULO2.'" onClick="CKNivel(\''.$ID_MODULO1.'\')" '.$Cheked.'/>
												</li>';
									}
									else
									{
										if($TIPO_MENU==1)
										{
											$Menu.='<li>
														<label for="'.$ID_MODULO2.'" id="M'.$ID_MODULO2.'">
															'.$Arriba.' 
															'.$Abajo.' 
															'.$CadMenu1.' 
															<a href="javascript: " onClick="
															vModal(\'Sistema/Seguridad/Modulo/FormAgregarMenu.php?ID_MODULO_P='.$ID_MODULO2.'&FG_SUB_MODULO=2\', \'Agregar SubMenu al Menu: <strong>'.$NB_MODULO.'</strong>\');"><img src=\''.$Nivel.'Imagenes/agregar.png\' width=\'13\' height=\'13\'  alt=\'\'/></a> 
															'.$CadEliminar1.'
														</label> 
														<input type="checkbox" id="'.$ID_MODULO2.'" onClick="CKNivel(\''.$ID_MODULO1.'\')" '.$Cheked.'/>';
										}
										else
										{
											$Menu.='
													<li>
														<label for="'.$ID_MODULO2.'" id="M'.$ID_MODULO2.'">
															'.$Arriba.' 
															'.$Abajo.' 
															'.$CadMenu1.' 
															'.$CadEliminar1.'
														</label> 
														<input type="checkbox" id="'.$ID_MODULO2.'" onClick="CKNivel(\''.$ID_MODULO1.'\')" '.$Cheked.'/>';
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
													
													$CantidadHijos=CantidadHijos($registros, $ID_MODULO3);
													$CantidadHermanos=CantidadHijos($registros, $ID_MODULO2);
													
													if($Cont3==1)
													{
														$Arriba="<img src='".$Nivel."Imagenes/arribaa.png' width='13' height='13'  alt=''/>";
													}
													else
													{
														$Arriba="<a href='javascript: ' onClick='ReordenarMenu($ID_MODULO2, $ID_MODULO3, $ORDEN, 1)'><img src='".$Nivel."Imagenes/arriba.png' width='13' height='13'  alt=''/></a>";
													}
													
													if($CantidadHermanos==$Cont3)
													{
														$Abajo="<img src='".$Nivel."Imagenes/abajoa.png' width='13' height='13'  alt=''/>";
													}
													else
													{
														$Abajo="<a href='javascript: ' onClick='ReordenarMenu($ID_MODULO2, $ID_MODULO1, $ORDEN, 0)'><img src='".$Nivel."Imagenes/abajo.png' width='13' height='13'  alt=''/></a>";
													}
													
													if($CantidadHijos>0)
													{
														$CadMenu1=$NB_MODULO;
														$CadEliminar1='<img src="'.$Nivel.'Imagenes/eliminara.png" width="13" height="13"  alt=""/>';
													}
													else
													{
														$CadMenu1="<a href='javascript: ' onClick='vModal(\"Sistema/Seguridad/Modulo/FromModificarMenu.php?ID_MODULO_P=".$ID_MODULO2."&ID_MODULO_H=".$ID_MODULO3."&ID_MODULO_PM=".$ID_MODULO_PM."&FG_SUB_MODULO=".$FG_SUB_MODULO_H."\", \"Modificar Menu: <strong>".$NB_MODULO."</strong>\");'>".$NB_MODULO."</a>";
														
														$CadEliminar1='<a href="javascript: " onClick="EliminarMenu('.$ID_MODULO3.');"><img src="'.$Nivel.'Imagenes/eliminar.png" width="13" height="13"  alt=""/></a>';
													}
													
													if($TIPO_MENU==2)
													{
														$Menu.='<li style="padding-left:38px;">
																		'.$Arriba.'
																		'.$Abajo.'
																		'.$CadMenu1.'
																		'.$CadEliminar1.'
																	</li>';
													}
													else
													{
														if($TIPO_MENU==1)
														{
															$Menu.='<li style="padding-left:38px;">
																		'.$Arriba.'
																		'.$Abajo.'
																		'.$CadMenu1.'
																		'.$CadEliminar1.'
																	</li>';
														}
														else
														{
															$Menu.='
																	<li style="padding-left:38px;">
																		'.$Arriba.'
																		'.$Abajo.'
																		'.$CadMenu1.'
																		'.$CadEliminar1.'
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
			
			$Arreglo["Error"]=0;
			$Arreglo["Menu"]=$Menu;
		
			$Arreglo["Menu"]=$Menu;
		}
		else
		{		
			$Arreglo["ERROR"]=$ERROR;
			$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];
		}
	}
	else
	{		
		$Arreglo["CONEXION"]="NO";
		$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];
	}
	
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();
	
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