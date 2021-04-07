<?php
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();	
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	$Rif = $_SESSION[$SiglasSistema.'RIF'];
	
	date_default_timezone_set('America/Caracas');
	// REPARACION
	//$id_solicitud = 23551;	
?>
<table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Cant. Toque</th>
                              <th>Tiempo Permanencia</th>
                              <th>D&iacute;a</th>
                              <th>Hora</th>
                            </tr>
                            </thead>
                        
                        <tbody>
                        
                        <?php 
						
							$vSQL="SELECT * FROM VENTANA_ATRAQUE WHERE RIF_BENEF ='$Rif' AND FG_ACTIVO = 1";
							
							$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
										//echo $vSQL;		
							$CONEXION=$ResultadoEjecutar["CONEXION"];						
							$ERROR=$ResultadoEjecutar["ERROR"];
							$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
							$result=$ResultadoEjecutar["RESULTADO"];
							
							if($CONEXION=="SI" and $ERROR=="NO")
							{		
								$filas = '';
								while ($registro=odbc_fetch_array($result))
								{
								 	$CANTIDAD_TOQ	= utf8_encode(	odbc_result($result,"CANTIDAD_TOQ"));
									$TIEMPO_PERM 	=	utf8_encode(odbc_result($result,"TIEMPO_PERM"));
									$DIA	=	utf8_encode(odbc_result($result,"DIA"));
									$HORA	=	utf8_encode(odbc_result($result,"HORA"));									
									
									
									
									echo'<tr>
								  <td>'.$CANTIDAD_TOQ.'</td>
								  <td> '.$TIEMPO_PERM.'</td>
								  <td>'.$DIA.'</td>
								  <td> '. $HORA.'</td>
								</tr>';				
								}
							}
							else
							{	
								echo $MSJ_ERROR;
								exit;
							}
								
								$Conector->Cerrar();
						
						
						?>
                        
                        </tbody>
                        <tfoot>
                            <tr>
								<th>Cant. Toque</th>
								<th>Tiempo Permanencia</th>
								<th>D&iacute;a</th>
								<th>Hora</th>
                            </tr>
                         </tfoot>
                </table>
<script>
$( document ).ready(function() {
			
			$("#example2").DataTable();	
});

function eliminar_beneficiario(Id_SM,Rif_gen, Rif_oper,Ano,Id_solicitud)
{
		//alert(Id_SM)
		
	Parametros="consulta=2&Id_SM="+Id_SM+"&Rif_gen="+Rif_gen+"&Rif_oper="+Rif_oper+"&Ano="+Ano+"&Id_solicitud="+Id_solicitud;
		
	$.ajax(
	{
		type: "POST",
		dataType:"html",
		url: "Sistema/Tripulantes/ScriptGuardar.php",			
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
				MostrarMensaje("Rojo", "Error, No se puede conectar con el servidor, contacte al personal del departamento de sistemas.");
				
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
					
					if(Arreglo['CONSULTA'] == 1)
					{
						window.parent.Cargando(0);
						MostrarMensaje("Verde", Arreglo['MENSAJE']);
						actualiza_tabla(Arreglo['ID_SM']);
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
	
	
}
</script>