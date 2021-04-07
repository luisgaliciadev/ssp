<!doctype html>
<?php 
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	

	
	session_start();	
	
	$SiglasSistema=$_SESSION['SiglasSistema'];

     $RIF=$_SESSION[$SiglasSistema."RIF"];
	 $ID_LOCALIDAD=$_SESSION[$SiglasSistema."ID_LOCALIDAD"];


     $ID_SOL_SM=$_GET['ID_SOL_SM']; 
	
	 
	
	
?>
<html>
<head>
<meta charset="utf-8">
<title>Nuevo empleado</title>

<link rel="stylesheet" href="Includes/Plugins/bootstrap-admin-templetes/AdminLTE-2.3.7/plugins/daterangepicker/daterangepicker.css">
       
</head>

<body>

<div class="row">
<form role="form" id="form_sm" >
	<div class="col-md-10 col-md-offset-1" style="margin-top:15px;">
    	<div class="box box-primary">

            
            	<div class="box-body">
               	
               	<div class="form-group col-md-6">
                    	
                        <input type="hidden" id="id_solic_muelle" value="<?php echo $ID_SOL_SM;?>">
                        <input type="hidden" id="id_localidad" value="<?php echo $ID_LOCALIDAD;?>">
                        	
                    </div>
                    
                	<div class="form-group col-md-12" >
                    	<label> Seleccione operador</label>
                        <select class="form-control" id="pais" name="OPERADOR" required>
                        	<option value="" readonly>Seleccione...</option>
                        	<?php 

							$vSQL="exec  [web].[SP_LISTADO_PAIS] ";
				
	
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

		                       $ID_PAIS=odbc_result($result,'ID_PAIS');
							   $NB_PAIS=utf8_encode(odbc_result($result,'NB_PAIS'));
							   echo "<option value=".$ID_PAISBEN_RIF_CED.">$NB_PAIS</option>";
										  
			
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
                    
                    
                    <div class="form-group col-md-12" id="div_solicitud_muelle">
                     <input type="text" class="form-control" id="solicitud_muelle" value="<?php echo $SOLIC_MUELLE;?>" hidden>
                     
                      </div>
                    
                <div class="form-group col-md-12">
                    <label>Pasaporte:</label>
                    <p></p>
                    <input type="text" id="pasaporte" style="text-transform:none; width:25%; float:left; margin-right:5px;margin-bottom:5px;" class="form-control"/>
                    
                </div>
           
               
                    <div class="form-group col-md-4" >
                    	<label> Nombre</label>
                        <input type="text" class="form-control" id="nombre" >
                    </div>
                    
                    <div class="form-group col-md-4" >
                    	<label> Cargo</label>
                        <input type="text" class="form-control" id="cargo" >
                    </div>
                    
        
                </div>
            
        </div>
        
        <div class="box-footer" id="div_guardar"><button type="submit" class="btn btn-primary" id="guardar_sm">Guardar</button> </div>
        
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
					
			
			$( "#btnb_Cedula" ).click(function() {
				
					
					var cedula1 = $("#cedula").val();
					var operador = $("#operador").val();
					var categoria = $("#categoria").val();
    				var id_solic_muelle1 = $("#id_solic_muelle").val() 
					Parametros="operador="+operador+"&id_solic_muelle="+id_solic_muelle1+"&cedula="+cedula1+"&categoria="+categoria+"&consulta=1";
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
								{   MostrarMensaje("Rojo", "Error, ya el empleado existe en la solicitud actual");	
									
									//$('#categoria').html(Arreglo['COMBO']);
									
								} 
								else 
								   {  
							
									MostrarMensaje("Verde", "Datos consultado con exito");
									console.log(1)
									//$('#cedula').val(Arreglo['CI_EMPLEADO']);
									$('#nombre').val(Arreglo['NB_EMPLEADO']);
									$('#cargo').val(Arreglo['CARGO']);
									$('#div_nombre').show();
									$('#div_cargo').show();
									$('#div_guardar').show();								
								}
							}
								
							
						}						
					});	
									
					
			});
	

 		$('#form_sm').on('submit', function(e) 
		{	
			e.preventDefault();
			var cedula1 = $("#cedula").val();
			var operador = $("#operador").val();
			var categoria = $("#categoria").val();
    		var id_solic_muelle1 = $("#id_solic_muelle").val() ;
			var nombre = $("#nombre").val();
    		var cargo = $("#cargo").val(); 
			var tipo_op =$("#ID_SOL_SM").val().split("&");
			Parametros="operador="+operador+"&id_solic_muelle="+id_solic_muelle1+"&cedula="+cedula1+"&categoria="+categoria+"&nombre="+nombre+"&cargo="+cargo+"&tipo_op="+tipo_op[1];
			
			$.ajax(
					{
						type: "POST",
						dataType:"html",
						url: "Sistema/Provisionales/ScriptInsertar.php",			
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
								window.parent.MostrarMensaje("Verde", "Orden de Carga Anulada Exitosamente.");
								window.parent.parent.Cargando(1);
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

			        MostrarMensaje("Rojo", "ErrorH de sentencia SQL, contacte al personal del departamento de sistemas.");
					
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