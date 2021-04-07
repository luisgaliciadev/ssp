<!doctype html>
<?php 
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();	
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	$num_sol = $_GET["id"];
	
	$vSQL="select *, cast(datepart(hour,FECHA_ETA) as char(2))+':'+cast(datepart(minute,FECHA_ETA) as char(2)) as HORA_ETA,casT(FECHA_ETA AS DATE) AS ETA, cast(datepart(hour,FECHA_ETZ) as char(2))+':'+cast(datepart(minute,FECHA_ETZ) as char(2)) as HORA_ETZ,casT(FECHA_ETZ AS DATE) AS ETZ from SOLICITUD_DE_MUELLE where ID= $num_sol";
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	$CONEXION=$ResultadoEjecutar["CONEXION"];						
    $ERROR=$ResultadoEjecutar["ERROR"];
    $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
    $result=$ResultadoEjecutar["RESULTADO"];
                        
    if($CONEXION=="SI" and $ERROR=="NO")
    {		
    	while ($registro=odbc_fetch_array($result))
        {			
          $CTIPO_SOLICITUD=odbc_result($result,'TIPO_SOLICITUD');
          $CID_BUQUE=utf8_encode(odbc_result($result,'ID_BUQUE'));
		  $CVIAJE=odbc_result($result,'NRO_VIAJE');
          $CCAPITAN=utf8_encode(odbc_result($result,'CAPITAN'));
		  $CC_POPA=odbc_result($result,'CALADO_POPA');
          $CC_PROA=utf8_encode(odbc_result($result,'CALADO_PROA'));
		  $CARMADOR=odbc_result($result,'ID_EMPRESA_BL');
          $CLINEA=utf8_encode(odbc_result($result,'ID_EMPRESA_BL_LINEA'));
		  $CPROCEDENCIA=odbc_result($result,'ID_PUERTO_PROCEDENCIA');
          $CDESTINO=utf8_encode(odbc_result($result,'ID_PUERTO_DESTINO'));
		  $CMUELLE=utf8_encode(odbc_result($result,'ID_BIEN'));
		  $CNIVEL=utf8_encode(odbc_result($result,'NIVEL_PROTECCION_BUQUE'));
		  $CFECHA_ETA=FechaNormal(odbc_result($result,'ETA')).' '.odbc_result($result,'HORA_ETA');
		  $CFECHA_ETZ=FechaNormal(odbc_result($result,'ETZ')).' '.odbc_result($result,'HORA_ETZ');
		  $CESTATUS_SOLIC_MUELLE =utf8_encode(odbc_result($result,'ESTATUS_SOLIC_MUELLE'));
		  
		  
         }
    }else
     {	
        echo $MSJ_ERROR;
        exit;
     }
                        
     $Conector->Cerrar();
	
	
?>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>

<link rel="stylesheet" href="Includes/Plugins/daterangepicker/daterangepicker.css">       
</head>

<body>

<div class="row">
<form role="form" id="form_mod" >
<input type="hidden" class="form-control" id="num_sol" name="VIAJE" required value="<?php echo $num_sol; ?>">
<input type="hidden" class="form-control" id="estatus" name="VIAJE" required value="<?php echo $CESTATUS_SOLIC_MUELLE; ?>">
	<div class="col-md-10 col-md-offset-1" style="margin-top:15px;">
    	<div class="box box-primary">
        	
            
            	<div class="box-body">
                	<div class="form-group col-md-12" >
                    	<label> Tipo de Solicitud</label>
                        <select class="form-control" id="tipo_sm" name="TIPO DE SOLICITUD" required>
                        	<option value="">Seleccione...</option>
                        	<?php 
								$vSQL="exec web.SP_TP_SOLICITUD";
								$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
                        
								$CONEXION=$ResultadoEjecutar["CONEXION"];						
								$ERROR=$ResultadoEjecutar["ERROR"];
								$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
								$result=$ResultadoEjecutar["RESULTADO"];
								
								if($CONEXION=="SI" and $ERROR=="NO")
								{		
									while ($registro=odbc_fetch_array($result))
									{			
										$TIPO_SOLICITUD=odbc_result($result,'TIPO_SOLICITUD');
										$DS_TIPO_SOLICITUD=utf8_encode(odbc_result($result,'DS_TIPO_SOLICITUD'));
										if ($CTIPO_SOLICITUD == $TIPO_SOLICITUD)
											echo "<option value=".$TIPO_SOLICITUD." selected>$DS_TIPO_SOLICITUD</option>";
										else
											echo "<option value=".$TIPO_SOLICITUD.">$DS_TIPO_SOLICITUD</option>";
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
                    
                    <div class="form-group col-md-6">
                    	<label> Buque</label>
                        <select class="form-control" id="buque" name="BUQUE" required>
                        	<option value="">Seleccione...</option>
                        	<?php 
								$vSQL="exec web.SP_LISTADO_BUQUE_MOD $num_sol";
								echo $CID_BUQUE;
								$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
                        
								$CONEXION=$ResultadoEjecutar["CONEXION"];						
								$ERROR=$ResultadoEjecutar["ERROR"];
								$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
								$result=$ResultadoEjecutar["RESULTADO"];
								
								if($CONEXION=="SI" and $ERROR=="NO")
								{		
									while ($registro=odbc_fetch_array($result))
									{			
										$ID_BUQUE=odbc_result($result,'ID_BUQUE');
										$NB_BUQUE=utf8_encode(odbc_result($result,'NB_BUQUE'));
										$BANDERA=utf8_encode(odbc_result($result,'BANDERA'));
										$ESLORA=utf8_encode(odbc_result($result,'ESLORA'));
										$TRB=utf8_encode(odbc_result($result,'TRB'));
										$IMO=utf8_encode(odbc_result($result,'IMO'));
										$TIPO_BUQUE=utf8_encode(odbc_result($result,'TIPO_BUQUE'));
										
										if ($CID_BUQUE == $ID_BUQUE){	
											echo "<option value=".$ID_BUQUE."%&".trim($IMO)."%&".trim($ESLORA)."%&".$TRB."%&".$TIPO_BUQUE." selected>$NB_BUQUE - $BANDERA</option>";						
										}else
											echo "<option value=".$ID_BUQUE."%&".trim($IMO)."%&".trim($ESLORA)."%&".$TRB."%&".$TIPO_BUQUE." >$NB_BUQUE - $BANDERA </option>";
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
                    
                    <div class="form-group col-md-6">
                    	<label> Bandera</label>
                        <input type="text" class="form-control" id="bandera" disabled>
                        	
                    </div>
                    
                    
                    <div class="form-group col-md-6">
                    	<label> IMO</label>
                        <input type="text" class="form-control" id="imo" disabled>
                    </div>
                    
                    <div class="form-group col-md-6">
                    	<label> Eslora Mts.</label>
                        <input type="text" class="form-control" id="eslora" disabled>
                    </div>
                    
                    <div class="form-group col-md-6">
                    	<label> TRB</label>
                        <input type="text" class="form-control" id="trb" disabled>
                    </div>
                    <div class="form-group col-md-6">
                                        <label> Tipo Buque</label>
                                        <input type="text" class="form-control" id="tipob" disabled>
                                    </div>
                     <div class="form-group col-md-6">
                    	<label> Viaje</label>
                        <input type="text" class="form-control" id="viaje" name="VIAJE" required value="<?php echo $CVIAJE; ?>">
                    </div>
                    
                    <div class="form-group col-md-6">
                    	<label> Capit&aacute;n</label>
                        <input type="text" class="form-control" id="capitan" name="CAPITAN" onkeypress="return soloLetras(event);" required value="<?php echo $CCAPITAN; ?>">
                    </div>
                    
                     <div class="form-group col-md-6">
                    	<label> Calado Proa</label>
                        <input type="text" class="form-control" id="c_proa" name="CALADO PROA" onkeypress="return NumCheck(event, this)" required value="<?php echo $CC_PROA; ?>">
                    </div>
                    
                    <div class="form-group col-md-6">
                    	<label> Calado Popa</label>
                        <input type="text" class="form-control" id="c_popa" name="CALADO POPA" onkeypress="return NumCheck(event, this)" required value="<?php echo $CC_POPA; ?>">
                    </div>
                    
                    
                    <div class="form-group col-md-6">
                    	<label> Armador</label>
                        <select class="form-control" id="armador" name="ARMADOR" required>
                        	<option value="">Seleccione...</option>
                        	<?php 
								$vSQL="exec web.SP_LISTADO_ARMADOR";
								$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
                        
								$CONEXION=$ResultadoEjecutar["CONEXION"];						
								$ERROR=$ResultadoEjecutar["ERROR"];
								$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
								$result=$ResultadoEjecutar["RESULTADO"];
								
								if($CONEXION=="SI" and $ERROR=="NO")
								{		
									while ($registro=odbc_fetch_array($result))
									{			
										$ID=odbc_result($result,'ID');
										$NB_EMPRESA_BL=utf8_encode(odbc_result($result,'NB_EMPRESA_BL'));								
										if ($CARMADOR == $ID)
											echo "<option value=".$ID." selected>$NB_EMPRESA_BL</option>";
										else
											echo "<option value=".$ID.">$NB_EMPRESA_BL</option>";
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
                    
                    <div class="form-group col-md-6">
                    	<label> L&iacute;nea Naviera</label>
                        <select class="form-control" id="naviera" name="NAVIERA" required>
                        	<option value="">Seleccione...</option>
                        	<?php 
								$vSQL="exec web.SP_LISTADO_LINEA";
								$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
                        
								$CONEXION=$ResultadoEjecutar["CONEXION"];						
								$ERROR=$ResultadoEjecutar["ERROR"];
								$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
								$result=$ResultadoEjecutar["RESULTADO"];
								
								if($CONEXION=="SI" and $ERROR=="NO")
								{		
									while ($registro=odbc_fetch_array($result))
									{			
										$ID=odbc_result($result,'ID');
										$NB_EMPRESA_BL=utf8_encode(odbc_result($result,'NB_EMPRESA_BL'));								
										if ($CLINEA ==$ID )
											echo "<option value=".$ID.">$NB_EMPRESA_BL</option>";
										else
											echo "<option value=".$ID." selected>$NB_EMPRESA_BL</option>";
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
                                   
                    
                    
                    
                    <div class="form-group col-md-6">
                    	<label> ETA - ETD</label> 
                        <div class="input-group" >
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" id="RangoFecha" name="RANGO DE FECHA" required value="<?php echo $CFECHA_ETA.' - '.$CFECHA_ETZ; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group col-md-6">
                    	<label> Pto. Procedencia</label>
                        <select class="form-control" id="procedencia" name="PROCEDENCIA" required>
                        	<option value="">Seleccione...</option>
                        	<?php 
								$vSQL="exec web.SP_LISTADO_PUERTO";
								$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
                        
								$CONEXION=$ResultadoEjecutar["CONEXION"];						
								$ERROR=$ResultadoEjecutar["ERROR"];
								$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
								$result=$ResultadoEjecutar["RESULTADO"];
								
								if($CONEXION=="SI" and $ERROR=="NO")
								{		
									while ($registro=odbc_fetch_array($result))
									{			
										$ID_PUERTO=odbc_result($result,'ID_PUERTO');
										$NB_PUERTO=utf8_encode(odbc_result($result,'NB_PUERTO'));								
										if($CPROCEDENCIA == $ID_PUERTO)
											echo "<option value=".$ID_PUERTO." selected>$NB_PUERTO</option>";
										else
											echo "<option value=".$ID_PUERTO.">$NB_PUERTO</option>";
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
                    
                    <div class="form-group col-md-6">
                    	<label> Pto. Destino</label>
                        <select class="form-control" id="destino" name="DESTINO" required>
                        	<option value="">Seleccione...</option>
                        	<?php 
								$vSQL="exec web.SP_LISTADO_PUERTO";
								$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
                        
								$CONEXION=$ResultadoEjecutar["CONEXION"];						
								$ERROR=$ResultadoEjecutar["ERROR"];
								$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
								$result=$ResultadoEjecutar["RESULTADO"];
								
								if($CONEXION=="SI" and $ERROR=="NO")
								{		
									while ($registro=odbc_fetch_array($result))
									{			
										$ID_PUERTO=odbc_result($result,'ID_PUERTO');
										$NB_PUERTO=utf8_encode(odbc_result($result,'NB_PUERTO'));								
										if($CDESTINO == $ID_PUERTO)
											echo "<option value=".$ID_PUERTO." selected>$NB_PUERTO</option>";
										else
											echo "<option value=".$ID_PUERTO.">$NB_PUERTO</option>";
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
                    	
                    <div class="form-group col-md-6">
                    	<label> Pref. Muelle</label>
                        <select class="form-control" id="muelle" name="PREFERENCIA DE MUELLE" required>
                        	<option value="">Seleccione...</option>
                        	<?php 
								$vSQL="exec web.SP_LISTADO_MUELLE";
								$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
                        
								$CONEXION=$ResultadoEjecutar["CONEXION"];						
								$ERROR=$ResultadoEjecutar["ERROR"];
								$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
								$result=$ResultadoEjecutar["RESULTADO"];
								
								if($CONEXION=="SI" and $ERROR=="NO")
								{		
									while ($registro=odbc_fetch_array($result))
									{			
										$ID_BIEN=odbc_result($result,'ID_BIEN');
										$NB_BIEN=utf8_encode(odbc_result($result,'NB_BIEN'));								
										if($CMUELLE == $ID_BIEN)
											echo "<option value=".$ID_BIEN." selected>$NB_BIEN</option>";
										else
											echo "<option value=".$ID_BIEN.">$NB_BIEN</option>";
										
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
                    
                     <div class="form-group col-md-6">
                    	<label> Nivel Protecci&oacute;n</label>
                        <select class="form-control" id="nivel" name="NIVEL" required>
                        	<option value="">Seleccione...</option>
                        	<option value="1" <?PHP if ($CNIVEL == 1 ) echo "selected"; ?>>1 </option>
                            <option value="2" <?PHP if ($CNIVEL == 2 ) echo "selected"; ?>>2</option>
                            <option value="3" <?PHP if ($CNIVEL == 3 ) echo "selected"; ?>>3</option>
                        </select>
                    </div>
                
                
                
                </div>
            
        </div>
        <div class="box-footer">
		<button type="summit" class="btn btn-primary" id="guardar_sm">Modificar</button>
		<button type="button" class="btn btn-danger" id="cancelar">Cancelar</button>
		</div>
        
    </div>
</form>
</div>

</body>

<script src="Sistema/OrdenCarga/Historico/moment.min.js"></script>
<script src="Includes/Plugins/daterangepicker/daterangepicker.js"></script>
<script>
        $( document ).ready(function() {
			bandera_buque()
			bloquear()
			
			
			window.parent.parent.Cargando(0);
            var today = new Date(); 
			var dd = today.getDate(); 
			var mm = today.getMonth()+1; //January is 0! 
			var yyyy = today.getFullYear(); 
			var HH = today.getHours(); 
			var MM = today.getSeconds(); 
			var HHEND =  today.getHours() + 2 ; 
			if(dd<10){ dd='0'+dd } 
			if(mm<10){ mm='0'+mm } 
			var today = dd+'/'+mm+'/'+yyyy+' '+HH+':'+01; 
				
				$('#RangoFecha').daterangepicker(
				{
					timePicker : true,
					timePicker24Hour: true,
					timePickerIncrement: 10,			
					"locale": 
					{
						"format": "DD/MM/YYYY HH:mm ",
						"separator": " - ",
						"applyLabel": "Aplicar",
						"cancelLabel": "Cancelar",
						"fromLabel": "Desde",
						"toLabel": "Hasta",
						"customRangeLabel": "Custom",
						"daysOfWeek": [
							"Do",
							"Lu",
							"Ma",
							"Mi",
							"Ju",
							"Vi",
							"Sa"
						],
						"monthNames": [
							"Enero",
							"Febrero",
							"Marzo",
							"Abril",
							"Mayo",
							"Junio",
							"julio",
							"Agosto",
							"Septiembre",
							"Octubre",
							"Noviembre",
							"Diciembre"
						],
						"firstDay": 1
					}				
            	});
				
				
				
				$( "#buque" ).change(function() {
					var bandera = $("#buque option:selected").text().split(" - ");
				  	var valores = $(this).val().split("%&")
				  	$("#imo").val(valores[1])
					$("#eslora").val(valores[2])
					$("#trb").val(valores[3])
					$("#bandera").val(bandera[1])
					$("#tipob").val(valores[4])
				});
				
				$('#form_mod').on('submit', function(e) 
				{
					e.preventDefault();
					modificar_sm()
					
				});
				
				$( "#cancelar" ).click(function() {
					$("#info").html('');
					$("#consulta").html('');	
					$("#num_sm").val('');			
				});

        });
		
		function bandera_buque(){
		
			var bandera = $("#buque option:selected").text().split(" - ");
			var valores = $("#buque").val().split("%&")
			$("#imo").val(valores[1])
			$("#eslora").val(valores[2])
			$("#trb").val(valores[3])
			$("#bandera").val(bandera[1])
		}
		
		function bloquear(){
			
			if ($( "#estatus" ).val() > 0) {
				$( ".form-control" ).prop( "disabled", true )
				$( "#guardar_sm" ).hide();
				$( "#num_sm" ).prop( "disabled", false )
			}
		}
		function modificar_sm(){
		
			
					var bandera = $("#buque option:selected").text().split(" - ");
				  	var valores = $("#buque").val().split("%&")
					var tipo_solicitud = $("#tipo_sm").val()
					var buque = valores[0]
					var bandera = bandera[1]
					var imo = valores[1]
					var eslora = valores[2]
					var trb = valores[3]
					var viaje = $("#viaje").val()
					var capitan = $("#capitan").val()
					var c_proa =$("#c_proa").val()
					var c_popa = $("#c_popa").val()
					var armador = $("#armador").val()
					var linea = $("#naviera").val()
					var pto_proc = $("#procedencia").val()
					var pto_destino = $("#destino").val()
					var muelle = $("#muelle").val()
					var nivel = $("#nivel").val()
					var num_sol = $("#num_sol").val()
					
					var fechas = $("#RangoFecha").val().split(" - ")
					
					Parametros="tipo_solicitud="+tipo_solicitud+"&buque="+buque+"&viaje="+viaje+"&capitan="+capitan+"&c_proa="+c_proa+"&c_popa="+c_popa+"&armador="+armador+"&linea="+linea+"&pto_proc="+pto_proc+"&pto_destino="+pto_destino+"&muelle="+muelle+"&nivel="+nivel+"&fecha_d="+fechas[0]+"&fecha_h="+fechas[1]+"&num_sol="+num_sol;
					
					console.log(Parametros)
					
					
					$.ajax(
					{
						type: "POST",
						dataType:"html",
						url: "Sistema/ModificarSolicitud/ScriptModificar.php",			
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
								window.parent.MostrarMensaje("Verde", "Solicitud Modificada con Exitosamente.");
								AbrirModulo("MenDes1002", "Modificar Solicitud", "Sistema/ModificarSolicitud/filtro.php")
							}
						}						
					});
		
		}

		function soloLetras(e) {
            key = e.keyCode || e.which;
            tecla = String.fromCharCode(key).toString();
            letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";//Se define todo el abecedario que se quiere que se muestre.
            especiales = [8, 37, 39, 46, 6]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.

            tecla_especial = false
            for(var i in especiales) {
                if(key == especiales[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if(letras.indexOf(tecla) == -1 && !tecla_especial){
                return false;
            }
        }
    </script>
</html>