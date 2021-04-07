<?php
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");	
	
	$Conector=Conectar();
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	if(isset($_SESSION[$SiglasSistema."LOGIN"])) 
	{
		$LOGIN=$_SESSION[$SiglasSistema."LOGIN"];
		$RAZON_SOCIAL=$_SESSION[$SiglasSistema."RAZON_SOCIAL"];
		$NB_LOCALIDAD=$_SESSION[$SiglasSistema."NB_LOCALIDAD"];
		
		$vSQL="EXEC SP_CONSTRUIR_MENU '$LOGIN'";
						
		$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

		$CONEXION=$ResultadoEjecutar["CONEXION"];						
		$ERROR=$ResultadoEjecutar["ERROR"];					
		$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];		
		$resultPrin=$ResultadoEjecutar["RESULTADO"];
		
		if($CONEXION=="SI" and $ERROR=="NO")
		{		
			$Menu='
					<li class="nav-header">
						<div class="dropdown profile-element"> 
							<span>
								<img alt="image" class="img-circle" src="Includes/Plugins/inspinia/img/profile_small.jpg" />
							</span>
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<span class="clear block m-t-xs text-white"><strong class="font-bold">'.strtoupper(substr($RAZON_SOCIAL, 0, 1)).strtolower(substr($RAZON_SOCIAL, 1, strlen($RAZON_SOCIAL))).'</strong></span>
								<span class="clear block m-t-xs text-white">'.strtoupper(substr($NB_LOCALIDAD, 0, 1)).strtolower(substr($NB_LOCALIDAD, 1, strlen($NB_LOCALIDAD))).'</span>
								<span class="clear"> 
									<span class="text-muted text-xs block">Mi cuenta <b class="caret"></b></span> 
								</span> 
							</a>
							<ul class="dropdown-menu animated fadeInRight m-t-xs">
								<li><a href="javascript:" onClick="vModal3(\'Sistema/sesion/formModificar.php\', \'Modificar mis datos\');">Modificar mis datos</a></li>
								<li><a href="javascript:" onClick="Bloqueo();">Bloquear pantalla</a></li>
							
								<li class="divider"></li>
								<li><a href="javascript:" onClick="CerrarSesion();">Salir</a></li>
							</ul>
						</div>
						<div class="logo-element">
							SSP
						</div>
					</li>';
				
			$Ite=1;
			
			while($registros[$Ite]=odbc_fetch_array($resultPrin))
			{				
				$Ite++;
			}
			
			foreach ($registros as &$registro1) 
			{
				if($registro1["NIVEL"]==1)
				{
					$NIVEL=$registro1["NIVEL"];
					$ID_MODULO1=$registro1["ID_MODULO"];
					$NB_MODULO=utf8_encode($registro1["NB_MODULO"]);
					$RUTA=utf8_encode($registro1["RUTA"]);
					$TIPO_MENU=$registro1["TIPO_MENU"];
					$ENLACEP=$registro1["ENLACE"];
					$ICONO=$registro1["ICONO"];
					
					$Menu.="<li  class='MenuNivel0'>";		
					
					if($TIPO_MENU==2)
					{
						$Menu.="			
								<a href='".$ENLACEP."' target='_blank'>
									<i class='fa fa-".$ICONO."'></i> 
									<span class='tituloMenu'>".$NB_MODULO."</span>
									<span class='fa fa-external-link'></span>
								</a>";
					}
					else
					{
						if($TIPO_MENU==1)
						{
							$Menu.="				
									<a href='javascript:'>
										<i class='fa fa-".$ICONO."'></i> 
										<span class='tituloMenu'>".$NB_MODULO."</span>
										<span class='fa arrow'></span>
									</a>";
						}
						else
						{
							$Menu.="													
									<a id='MenDes".$ID_MODULO1."' href='javascript:' onClick='AbrirModulo(\"MenDes".$ID_MODULO1."\", \"".$NB_MODULO."\", \"".$RUTA."\")'>
										<i class='fa fa-".$ICONO."'></i> 
										<span class='tituloMenu'>".$NB_MODULO."</span>
									</a>";
						}
						
						$CantidadHijos=CantidadHijos($registros, $ID_MODULO1);
					
						if($CantidadHijos)
						{
							$Menu.="<ul class='nav nav-second-level'>";						
							
							foreach ($registros as &$registro2) 
							{
								if($registro2["NIVEL"]==2 and $registro2["ID_MODULO_P"]==$ID_MODULO1)
								{
									$NIVEL=$registro2["NIVEL"];
									$ID_MODULO2=$registro2["ID_MODULO"];
									$NB_MODULO=utf8_encode($registro2["NB_MODULO"]);
									$RUTA=utf8_encode($registro2["RUTA"]);
									$TIPO_MENU=$registro2["TIPO_MENU"];
									$ENLACEP=$registro2["ENLACE"];
									$ICONO=$registro2["ICONO"];

									$Menu.="<li  class='MenuNivel1'>";
									
									if($TIPO_MENU==2)
									{													
										$Menu.="			
												<a href='".$ENLACEP."' target='_blank'>
													<i class='fa fa-".$ICONO."'></i> 
													<span class='tituloMenu'>".$NB_MODULO."</span>
													<span class='fa fa-external-link pull-right'></span>
												</a>";
									}
									else
									{
										if($TIPO_MENU==1)
										{
											$Menu.="			
													<a href='javascript:'>
														<i class='fa fa-".$ICONO."'></i> 
														<span class='tituloMenu'>".$NB_MODULO."</span>
														<span class='fa arrow'></span>
													</a>";
										}
										else
										{														
											$Menu.="			
													<a id='MenDes".$ID_MODULO2."' href='javascript:' onClick='AbrirModulo(\"MenDes".$ID_MODULO2."\", \"".$NB_MODULO."\", \"".$RUTA."\")'>
														<i class='fa fa-".$ICONO."'></i> 
														<span class='tituloMenu'>".$NB_MODULO."</span>
													</a>";
										}
										
										$CantidadHijos=CantidadHijos($registros, $ID_MODULO2);
									
										if($CantidadHijos)
										{							
											$Menu.="<ul class='nav nav-third-level'>";						
							
											foreach ($registros as &$registro3) 
											{
												if($registro3["NIVEL"]==3 and $registro3["ID_MODULO_P"]==$ID_MODULO2)
												{
													$NIVEL=$registro3["NIVEL"];
													$ID_MODULO3=$registro3["ID_MODULO"];
													$NB_MODULO=utf8_encode($registro3["NB_MODULO"]);
													$RUTA=utf8_encode($registro3["RUTA"]);
													$TIPO_MENU=$registro3["TIPO_MENU"];
													$ENLACEP=$registro3["ENLACE"];
													$ICONO=$registro3["ICONO"];

													$Menu.="<li  class='MenuNivel2'>";
													
													if($TIPO_MENU==2)
													{
														$Menu.="			
																<a href='".$ENLACEP."' target='_blank'>
																	<i class='fa fa-".$ICONO."'></i> 
																	<span class='tituloMenu'>".$NB_MODULO."</span>
																</a>";
													}
													else
													{
														if($TIPO_MENU==1)
														{
															$Menu.="			
																	<a href='javascript:'>
																		<i class='fa fa-".$ICONO."'></i> 
																		<span class='tituloMenu'>".$NB_MODULO."</span>
																		<span class='fa arrow'></span>
																	</a>";
														}
														else
														{																		
															$Menu.="												
																	<a id='MenDes".$ID_MODULO3."' href='javascript:' onClick='AbrirModulo(\"MenDes".$ID_MODULO3."\", \"".$NB_MODULO."\", \"".$RUTA."\")'>
																		<i class='fa fa-".$ICONO."'></i> 
																		<span class='tituloMenu'>".$NB_MODULO."</span>
																	</a>";
														}
														
														$CantidadHijos=CantidadHijos($registros, $ID_MODULO);
													
														if($CantidadHijos)
														{							
															
														}
														
														$Menu.="</li>";
													}
												}
											}
											
											$Menu.="</ul>";
										}
										
										$Menu.="</li>";
									}
								}
							}
											
							$Menu.="</ul>";
						}
					}
						
					$Menu.="</li>";
				}
			}
						
			$Menu.='					
					<li>													
						<a id="MenDes200102" href="javascript:" onclick="Bloqueo();">
							<i class="fa fa-lock"></i> 
							<span>Bloquear pantalla</span>
						</a>
					</li>
					
					<li class="MenuNivel0">										
						<a id="MenDes200103" href="javascript:" onclick="CerrarSesion();">
							<i class="fa fa-sign-out"></i> 
							<span>Salir</span>
						</a>
					</li>';
			
			$Arreglo["CONEXION"]=$CONEXION;
			$Arreglo["ERROR"]=$ERROR;			
			$Arreglo["Menu"]=$Menu;
			
			echo json_encode($Arreglo);		
		}
		else
		{	
			$Arreglo["CONEXION"]=$CONEXION;
			$Arreglo["ERROR"]=$ERROR;
			$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
			
			echo json_encode($Arreglo);
		}
		
		$Conector->Cerrar();
		$Conector=Conectar();
	}
	
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