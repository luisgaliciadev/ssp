<?php
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();	
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	$Rif = $_SESSION[$SiglasSistema.'RIF'];
	
	date_default_timezone_set('America/Caracas');
	$id_solicitud = $_GET['id_sm'];
	//$id_solicitud = 23551;	
?>
<table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th>Rif</th>
                              <th>Raz&oacute;n Social</th>
                              <th>Categor&iacute;a</th>
                              <th>Tipo de Servicio</th>
                              <th>-</th>
                            </tr>
                            </thead>
                        
                        <tbody>
                        
                        <?php 
						
							$vSQL="EXEC web.[SP_LISTADO_OPERADORES_SM] $Rif, $id_solicitud";
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
								 	$DS_TIPO_BENEFICIARIO	=utf8_encode(	odbc_result($result,"DS_TIPO_BENEFICIARIO"));
									$BEN_RIF_CED	=	utf8_encode(odbc_result($result,"BEN_RIF_CED"));
									$NB_PROVEED_BENEF	=	utf8_encode(odbc_result($result,"NB_PROVEED_BENEF"));
									$NB_CATEGORIA	=	utf8_encode(odbc_result($result,"NB_CATEGORIA"));
									$RIF_CED_GENERA	=	utf8_encode(odbc_result($result,"RIF_CED_GENERA"));
									
									$ID_SOLIC_MUELLE	=	odbc_result($result,"ID_SOLIC_MUELLE");
									$ANO_EJERCICIO	=	odbc_result($result,"ANO_EJERCICIO");
									
									if($BEN_RIF_CED == $Rif)
									{
										$boton = '<button type="button" class="btn btn-block btn-danger btn-sm"  disabled>Eliminar</button>';
									}
									else
									{
										$boton = '<button type="button" class="btn btn-block btn-danger btn-sm" onClick="eliminar_beneficiario('.$id_solicitud.',\''.$RIF_CED_GENERA.'\',\''.$BEN_RIF_CED.'\','.$ANO_EJERCICIO.','.$ID_SOLIC_MUELLE.')">Eliminar</button>';
									}
									
									
									echo'<tr>
								  <td>'.$BEN_RIF_CED.'</td>
								  <td> '.$NB_PROVEED_BENEF.'</td>
								  <td>'.$NB_CATEGORIA.'</td>
								  <td> '. $DS_TIPO_BENEFICIARIO.'</td>
								  <td>'.
									$boton.'
								  </td>
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
                              <th>Rif</th>
                              <th>Raz&oacute;n Social </th>
                              <th>Categor&iacute;a</th>
                              <th>Tipo de Servicio</th>
                              <th>-</th>
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
		url: "Sistema/Operadores/ScriptGuardar.php",			
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