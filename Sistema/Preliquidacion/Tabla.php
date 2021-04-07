<!doctype html>
<?php 
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();	
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	$num_sol = $_GET["id"];
	
	
	
?>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>

       
</head>

<body>

<div class="row">
<form role="form" id="form_mod" >
<input type="hidden" class="form-control" id="num_sol" name="VIAJE" required value="<?php echo $num_sol; ?>">
	<div class="col-md-10 col-md-offset-1" style="margin-top:15px;">
    	<div class="box box-primary">  	
            
			<div class="box-body">
				<div class="form-group col-md-12" >
	 				
					<table class="table table-bordered">
	 					<thead>
	 						<th>Tipo Servicio</th>
							<th>Cliente</th>
							<th>Tipo Cliente</th>
							<th>Preliquidaci&oacute;n</th>
							<th>Fecha Reg</th>
						</thead>
						<tbody>
					
							<?php
								$vSQL="exec web.SP_LISTADO_SERVICIOS_PRELIQ $num_sol";
								$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
						
								$CONEXION=$ResultadoEjecutar["CONEXION"];						
								$ERROR=$ResultadoEjecutar["ERROR"];
								$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
								$result=$ResultadoEjecutar["RESULTADO"];
								
								if($CONEXION=="SI" and $ERROR=="NO")
								{		
									while ($registro=odbc_fetch_array($result))
									{			
										$NB_SERVICIO =odbc_result($result,'NB_STIPO_SERVICIO');
										$NB_PROVEED_BENEF=utf8_encode(odbc_result($result,'NB_PROVEED_BENEF'));
										$DS_TIPO_BENEFICIARIO =odbc_result($result,'DS_TIPO_BENEFICIARIO');
										
										$FG_PRELIQUIDA =odbc_result($result,'FG_PRELIQUIDA');
										
										$NB_PROCEDURE =odbc_result($result,'NB_PROCEDURE');
										
										$CONECTOR =odbc_result($result,'CONECTOR');
										$FORMATO_PRELIQ =odbc_result($result,'FORMATO_PRELIQ');
										
										$ID_PRELIQ =odbc_result($result,'ID_PRELIQ');
																
										
										
										$FECHA_REG=utf8_encode(odbc_result($result,'FECHA_REG'));
										$BOTONES = '';
										
										if($FG_PRELIQUIDA=0)
										{
											$BOTONES =$BOTONES.'<div class="btn-toolbar" role="toolbar">
														<div class="btn-group">
														
														<button type="button" disabled class="btn btn-info">
															<span class="glyphicon glyphicon-search"></span>
														</button>

														
																				
														
														</div>
													</div>';
										}
										else
										{
											
											$BOTONES =$BOTONES.'<div class="btn-toolbar" role="toolbar">
														<div class="btn-group">
																												
															<button type="button" data-toggle="tooltip" title="Ver Preliquidación" class="btn btn-info"
															onClick="ver_preliq('.$ID_PRELIQ.',\''.$FORMATO_PRELIQ.'\');">
																<span class="glyphicon glyphicon-search"></span>
															</button>

															<button type="button" data-toggle="tooltip" title="Agregar detalle de Preliquidacion"  class="btn btn-danger"
															onClick="detalle_pre('.$ID_PRELIQ.',\''.$NB_SERVICIO.'\');">
															<span class="fa  fa-pencil-square-o"></span>
															</button>
													
														</div>
													</div>';
											
										}
														
										$BOTONES =$BOTONES.'';
										
										echo "<tr>
												<td>".$NB_SERVICIO."</td>
												<td>".$NB_PROVEED_BENEF."</td>
												<td>".$DS_TIPO_BENEFICIARIO."</td>
												<td>".$BOTONES."</td>
												<td>".$FECHA_REG."</td>
											 </tr>";
										
									}
								}
								else
								{	
									echo $MSJ_ERROR;
									exit;
								}
							?>
						</tbody>
					  </table>
				</div>
			</div>
            
        </div>
       
        
    </div>
</form>
</div>

</body>


<script>
        $( document ).ready(function() {
			
			
			
			window.parent.parent.parent.parent.Cargando(0);
           
		
		});
	
function ver_preliq(Id_preliq,Formato)
{
	
	window.open("Sistema/Formatos/"+Formato+"?id_preliq="+Id_preliq);
	
}
	

	
		function generar_preliq(id_solic, nb_procedure, conector, formato)
		{
				
			Parametros="consulta=1&solicitud="+id_solic+"&nb_procedure="+nb_procedure+"&conector="+conector+"&formato="+formato;
			
			
			$.ajax(
			{
				type: "POST",
				dataType:"html",
				url: "Sistema/Preliquidacion/ScriptGenPre.php",			
				data: Parametros,	
				beforeSend: function() 
				{
					window.parent.parent.Cargando(1);
				},												
				cache: false,			
				success: function(result)
				{
					window.parent.parent.Cargando(0);

					var Arreglo=jQuery.parseJSON(result);

					var CONEXION=Arreglo['CONEXION'];

					if(CONEXION=="NO")
					{		
						window.parent.Cargando(0);

						var MSJ_ERROR=Arreglo['MSJ_ERROR'];	
	<?php
						if(IpServidor()=="10.10.30.54")
						{
	?>	
							alert(MSJ_ERROR);
	<?php
						}
	?>							
						window.parent.Cargando(0);
						MostrarMensaje("Rojo", "Error, No se puedo conectar con el servidor, contacte al personal del departamento de sistemas.");
					}
					else
					{
						var ERROR=Arreglo['ERROR'];

						if(ERROR=="SI")
						{		
							window.parent.Cargando(0);			
							var MSJ_ERROR=Arreglo['MSJ_ERROR'];	
	<?php
							if(IpServidor()=="10.10.30.54")
							{
	?>	
								alert(MSJ_ERROR);
	<?php
							}
	?>
							window.parent.Cargando(0);
							MostrarMensaje("Rojo", "Error de sentencia SQL, contacte al personal del departamento de sistemas.");	
						}
						else
						{						
							
							$id=Arreglo['ID_SM'];
							$mensaje=Arreglo['MENSAJE'];
							
							if($id>0)
							{
								window.parent.Cargando(0);
								MostrarMensaje("Verde", Arreglo['MENSAJE']);
								$("#consulta").load('Sistema/Ventas/Pendientes/Generales/Tabla.php?id='+id_solic);
							}
							else
							{
								window.parent.Cargando(0);
								MostrarMensaje("Rojo", Arreglo['MENSAJE']);
							}
							
						
						}
					}
				}						
			});

			;
		}
	
    </script>
</html>