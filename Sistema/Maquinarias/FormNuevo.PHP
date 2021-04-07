<!doctype html>
<?php 
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	
	

	
	session_start();	
	
	$SiglasSistema=$_SESSION['SiglasSistema'];

     $RIF=$_SESSION[$SiglasSistema."RIF"];
	 $ID_LOCALIDAD=$_SESSION[$SiglasSistema."ID_LOCALIDAD"];
     $ID_SOL_SM=$_GET['ID_SOL_SM']; 
	
	 
	
	
?>
<html>
<head>
<meta charset="utf-8">
<title>Registro de Maquinaria</title>

<link rel="stylesheet" href="Includes/Plugins/bootstrap-admin-templetes/AdminLTE-2.3.7/plugins/daterangepicker/daterangepicker.css">
       
</head>

<body>

<div class="row">
<form role="form" id="form_mq" >
	<div class="col-md-10 col-md-offset-1" style="margin-top:15px;">
    	<div class="box box-primary">

            
            	<div class="box-body">
               	
               	<div class="form-group col-md-6">
                    	
                        <input type="hidden" id="id_solic_muelle" value="<?php echo $ID_SOL_SM;?>">
                        <input type="hidden" id="id_localidad" value="<?php echo $ID_LOCALIDAD;?>">
                        	
                    </div>
                    
                	
                    <div class="form-group col-md-12" >
                    	<label> Seleccione Empresa:</label>
                        <select class="form-control" id="RIF_CED" name="OPERADOR" required>
                        	<option value="" readonly>Seleccione...</option>
                        	<?php 
							$Conector=Conectar2();
							$vSQL="exec  [web].[SP_BENEF_SERV_CONSULTA] 11 ";
				
	
	                          $ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	                          $CONEXION=$ResultadoEjecutar["CONEXION"];

	                          $ERROR=$ResultadoEjecutar["ERROR"];
                              $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
                              $result=$ResultadoEjecutar["RESULTADO"];
	                          //$Arreglo["CONSULTA"] = $vSQL;


	                          if($CONEXION=="SI" and $ERROR=="NO")
	                          {		
		                      while (odbc_fetch_array($result))
                                      {		

		                       $RIF_CED=odbc_result($result,'RIF_CED');
							   $NB_PROVEED_BENEF=utf8_encode(odbc_result($result,'NB_PROVEED_BENEF'));
							   echo "<option value=".$RIF_CED.">$NB_PROVEED_BENEF</option>";
										  
			
	                             	}
	                              }
                        else
                        {	
                            echo '<script>alert("'.$MSJ_ERROR.'");</script>';
                            exit;
                        }
                        
                        $Conector->Cerrar();
							?>   
                        </select>
                    </div>
                    
                    
                    <div class="form-group col-md-12" >
                    	<label> Seleccione Tipo de Servicio de Maquinaria:</label>
                        <select class="form-control" id="ID_EVENTO" name="EVENTO" required>
                        	<option value="" readonly>Seleccione...</option>
                        	<?php 
							$Conector=Conectar3();
							$vSQL="exec  SP_TIPO_EVENTO_SASPWEB ";
				
	
	                          $ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	                          $CONEXION=$ResultadoEjecutar["CONEXION"];

	                          $ERROR=$ResultadoEjecutar["ERROR"];
                              $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
                              $result=$ResultadoEjecutar["RESULTADO"];
	                          //$Arreglo["CONSULTA"] = $vSQL;


	                          if($CONEXION=="SI" and $ERROR=="NO")
	                          {		
		                      while (odbc_fetch_array($result))
                                      {		

		                       $ID_EVENTO=odbc_result($result,'ID_EVENTO');
							   $DS_EVENTO=utf8_encode(odbc_result($result,'DS_EVENTO'));
							   echo "<option value=".$ID_EVENTO.">$DS_EVENTO</option>";
										  
			
	                             	}
	                              }
                        else
                        {	
                            echo $MSJ_ERROR;
                            exit;
                        }
                        
                       $Conector->Cerrar();
							?>   
                        </select>
                    </div>
                    
                    
                  
                       
                   
                    
        
                </div>
            
        </div>
        
         <div class="form-group col-md-12" >
        <div class="box-footer" id="div_guardar"><button type="submit" class="btn btn-primary" id="guardar_sm">Guardar</button> </div>
         </div>
       
        
    </div>
</form>
</div>

</body>

<script src="Sistema/OrdenCarga/Historico/moment.min.js"></script>
        <script src="Includes/Plugins/bootstrap-admin-templetes/AdminLTE-2.3.7/plugins/daterangepicker/daterangepicker.js"></script>
<script>

$( document ).ready(function() {
			window.parent.parent.Cargando(0);
	        $('#div_solic_muelle').hide();
	        $('#div_solicitud_muelle').hide();
			$('#div_cedula').hide();
			$('#btne_Cedula').hide();
			$('#div_nombre').hide();
			$('#div_cargo').hide();	
           
				
			$( "#operador" ).change(function() {
				
				if ($("#operador").val() == '')
					return false
				
				$('#div_cedula').show();
				var operador = $("#operador").val();
				var id_solic_muelle1 = $("#id_solic_muelle").val() 
				Parametros="operador="+operador+"&id_solic_muelle="+id_solic_muelle1+"&consulta=3";
				$.ajax(
					{
						type: "POST",
						dataType:"html",
						url: "Sistema/Provisionales/ScriptConsultar.php",			
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
							
							var EXISTE=Arreglo['EXISTE'];
							
				
							if(CONEXION=="NO")
							{		
								window.parent.Cargando(0);
										
								var MSJ_ERROR=Arreglo['MSJ_ERROR'];	
					<?php
								if(IpServidor()=="10.10.30.54")
								{
					?>	
									//alert(MSJ_ERROR);
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
				
									MostrarMensaje("Rojo", "ErrorJ de sentencia SQL, contacte al personal del departamento de sistemas.");
									
								}
								else if (EXISTE=="SI")
								{   MostrarMensaje("Verde", "Datos consultado con exito");
									//$('#cedula').val(Arreglo['CI_EMPLEADO']);
									$('#categoria').html(Arreglo['RESULTADOS']);
									$('#div_nombre').show();
									$('#div_cargo').show();
									$('#div_guardar').show();
									//$('#categoria').html(Arreglo['COMBO']);
									
								} 
								else 
								   {  
							
							
								
									//VerificarEmpleadoRop();
								   // MostrarMensaje("Rojo", "El empleado no esta inscrito en el SROP para este Operador Portuario, debe primero hacer la inscripcion para continuar con el proceso");
									//$('#div_nombre').hide();
									//$('#div_cargo').hide();	
				
									//$('#categoria').html(Arreglo['COMBO']);
									
								}
							}
								
							
						}						
					});	

			});
					
			
			

 		$('#form_mq').on('submit', function(e) 
		{	
			e.preventDefault();
			var ID_SOLIC_MUELLE = $("#id_solic_muelle").val();
			var ID_EVENTO = $("#ID_EVENTO").val();
			var RIF_OPERADOR = $("#RIF_CED").val();    		
			
			Parametros="ID_SOLIC_MUELLE="+ID_SOLIC_MUELLE+"&ID_EVENTO="+ID_EVENTO+"&RIF_OPERADOR="+RIF_OPERADOR;
			
			$.ajax(
					{
						type: "POST",
						dataType:"html",
						url: "Sistema/Maquinarias/ScriptInsertar.php",			
						data: Parametros,	
						beforeSend: function() 
						{
							window.parent.parent.Cargando(1);
						},												
						cache: false,			
						success: function(Resultado)
						{
							window.parent.parent.Cargando(0);
						
							//alert(Resultado);
							
							if(window.parent.ValidarConexionError(Resultado)==1)
							{	
								window.parent.MostrarMensaje("Verde", "Registro Guardado.");
								window.parent.parent.Cargando(1);
								$("#ID_EVENTO").val('');
								$("#RIF_CED").val('');
								
								//AbrirModulo("MenDes7", "Operadores", "Sistema/Operadores/FormOperadores.php")
								FiltroConsulta(1);
							}
						}						
					});
			
			
			
		});
		
 });
	
	
    </script>

 <script>
 
function VerificarEmpleado()
{
    var cedula1 = $("#cedula").val();
    var id_solic_muelle1 = $("#id_solic_muelle").val() 
	 
	
	Parametros="id_solic_muelle="+id_solic_muelle1+"&cedula="+cedula1+"&consulta=1";
		
	$.ajax(
	{
		type: "POST",
		dataType:"html",
		url: "Sistema/Provisionales/ScriptConsultar.php",			
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
			
			var EXISTE=Arreglo['EXISTE'];
			

			

			
			
			
			if(CONEXION=="NO")
			{		
				window.parent.Cargando(0);
						
				var MSJ_ERROR=Arreglo['MSJ_ERROR'];	
	<?php
				if(IpServidor()=="10.10.30.54")
				{
	?>	
					//alert(MSJ_ERROR);
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
				else if (EXISTE=="SI")
				{   MostrarMensaje("Rojo", "Error, ya el empleado existe en la solicitud actual");
					$('#cedula').val(Arreglo['CI_EMPLEADO']);
					$('#nombre').val(Arreglo['NB_EMPLEADO']);
					$('#cargo').val(Arreglo['CARGO']);
					$('#div_nombre').show();
				    $('#div_cargo').show();
					$('#div_guardar').hide();
					//$('#categoria').html(Arreglo['COMBO']);
					
				} 
				else 
				   {  
			
			
			    
				    //VerificarEmpleadoRop();
				   // MostrarMensaje("Rojo", "El empleado no esta inscrito en el SROP para este Operador Portuario, debe primero hacer la inscripcion para continuar con el proceso");
					//$('#div_nombre').hide();
			        //$('#div_cargo').hide();	

					//$('#categoria').html(Arreglo['COMBO']);
					
				}
			}
				
			
		}						
	});	
	
}	




function VerificarEmpleadoRop()
{
    var id_localidad1 = $("#id_localidad").val();
	var operador1 = $("#operador").val()
	var cedula1 = $("#cedula").val()
	 
	
	Parametros="id_localidad="+id_localidad1+"&cedula="+cedula1+"&operador="+operador1+"&consulta="2;
		
	$.ajax(
	{
		type: "POST",
		dataType:"html",
		url: "Sistema/Provisionales/ScriptConsultar.php",			
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
			
			var EXISTE=Arreglo['EXISTE'];
			
			var NPEXISTE=Arreglo['NPEXISTE'];
			
			alert(NPXISTE);
			
			
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
				else if (EXISTE=="SI")
				{   MostrarMensaje("Verde", "El usuario se encuenta inscrito en el SROP");
					//$('#cedula').val(Arreglo['CI_EMPLEADO']);
					$('#nombre').val(Arreglo['NOMBRE']);
					$('#cargo').val(Arreglo['CARGO']);
					$('#div_nombre').show();
				    $('#div_cargo').show();
					$('#div_guardar').show();
					//$('#categoria').html(Arreglo['COMBO']);
					
				} 
				else 
				   {  
				    MostrarMensaje("Rojo", "El empleado no esta inscrito en el SROP para este Operador Portuario, debe primero hacer la inscripcion para continuar con el proceso");
					$('#div_nombre').hide();
			        $('#div_cargo').hide();	

					//$('#categoria').html(Arreglo['COMBO']);
					
				}
			}
				
			
		}						
	});	
	
}	

 </script>

</html>