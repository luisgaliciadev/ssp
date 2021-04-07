<!doctype html>
<?php 
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	ValidarSesion($Nivel);
	
	$vNB_MODULO=$_POST["vNB_MODULO"];
	
	$Nivel="";	
?>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>

<link rel="stylesheet" href="Includes/Plugins/daterangepicker/daterangepicker.css">
       
</head>

<body>
        <div class="row wrapper border-bottom white-bg page-heading">
			<div class="col-lg-10">
				<h2><?php echo $vNB_MODULO;?></h2>
				<?php echo construirBreadcrumbs(substr($_POST["vID_MODULO"], 6, strlen($_POST["vID_MODULO"])));?>
			</div>
		</div>    
		
		<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Nueva Solicitud de Muelle</h5>
						</div>
						<div class="ibox-content">
                            <form role="form" id="form_sm" >
                                <div class="row">
                                    <div class="form-group col-md-12" >
                                        <label> Tipo de Solicitud</label>
                                        <select class="form-control" id="tipo_sm" name="TIPO DE SOLICITUD" required>
                                            <option value="">Seleccione...</option>
                                            <?php                     
                                                $Conector=Conectar2();
    
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
                                                $vSQL="exec web.SP_LISTADO_BUQUE";
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
												
												
                                                        
                                                echo "<option value=".$ID_BUQUE."%&".trim($IMO)."%&".trim($ESLORA)."%&".$TRB."%&".$TIPO_BUQUE.">$NB_BUQUE - $BANDERA</option>";
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
                                    
                                    
                                    <div class="form-group col-md-5">
                                        <label> IMO</label>
                                        <input type="text" class="form-control" id="imo" disabled>
                                    </div>
                                    
                                    <div class="form-group col-md-5">
                                        <label> Eslora Mts.</label>
                                        <input type="text" class="form-control" id="eslora" disabled>
                                    </div>
                                    
                                    <div class="form-group col-md-5">
                                        <label> TRB</label>
                                        <input type="text" class="form-control" id="trb" disabled>
                                    </div>
                                     <div class="form-group col-md-5">
                                        <label> Tipo Buque</label>
                                        <input type="text" class="form-control" id="tipob" disabled>
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label> Viaje</label>
                                        <input type="text" class="form-control" id="viaje" name="VIAJE" required>
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label> Capit&aacute;n</label>
                                        <input type="text" class="form-control" id="capitan" name="CAPITAN" required onkeypress="return soloLetras(event);">
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label> Calado Proa</label>
                                        <input type="text" class="form-control " id="c_proa" name="CALADO PROA" required onkeypress="return NumCheck(event, this)" maxlength="6">
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label> Calado Popa</label>
                                        <input type="text" class="form-control " id="c_popa" name="CALADO POPA" onkeypress="return NumCheck(event, this)" required  maxlength="6">
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
                                        <label> ETA - ETD</label> 
                                        <div class="input-group" >
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="RangoFecha" name="RANGO DE FECHA" required>
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
                                        <label> Puesto de Atraque</label>
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
                                            <option value="1">1 </option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div> 
                                    
                                    <div class="form-group col-md-6">
                                        <label> Tipo Pago:</label>
                                        <select class="form-control" id="tpago" name="tpago" required>
                                            <option value="">Seleccione...</option>
                                            <option value="1">DEPOSITO </option>
                                            <option value="2">TRANSFERENCIA</option>
                                            
                                        </select>
                                    </div> 
                                </div>
                                  
                                <div class="row">
                                    <div class="form-group col-md-12" >
                                        <button type="submit" class="btn btn-primary" id="guardar_sm">Guardar</button> 
                                    </div>
                                </div>
                            </form>
						</div>
					</div>
				</div>
			</div>
		</div>
</body>

<script src="Sistema/solicitud/moment.min.js"></script>
<script src="Includes/Plugins/daterangepicker/daterangepicker.js"></script>
<script>
        $( document ).ready(function() {
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
					minDate: today,	
					endDate: moment().add(2, 'hours'),			
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
				
				$( "#imprimir" ).click(function() {
					window.open("Sistema/reportes/reporte_sm.php"); 
				});
				
                $(".number").on({
                    "focus": function(event) {
                        $(event.target).select();
                    },
                    "keyup": function(event) {
                        $(event.target).val(function(index, value) {
                        return value.replace(/\D/g, "")
                            .replace(/([0-9])([0-9]{2})$/, '$1.$2');
                        });
                    }
                });
                
				$('#form_sm').on('submit', function(e) 
				{
					e.preventDefault();
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
					var tpago = $("#tpago").val()
					
					var fechas = $("#RangoFecha").val().split(" - ")
                    var horas =  fechas[0].split(" ");
                    var horas2 =  fechas[1].split(" ");

                    
                    if ((horas[1] == '00:00') || (horas2[1] == '00:00')){
                        window.parent.MostrarMensaje("Rojo", "Hora Invalida");
                        return false
                    }

					
					Parametros="tipo_solicitud="+tipo_solicitud+"&buque="+buque+"&viaje="+viaje+"&capitan="+capitan+"&c_proa="+c_proa+"&c_popa="+c_popa+"&armador="+armador+"&linea="+linea+"&pto_proc="+pto_proc+"&pto_destino="+pto_destino+"&muelle="+muelle+"&nivel="+nivel+"&fecha_d="+fechas[0]+"&fecha_h="+fechas[1]+"&tpago="+tpago;
					
					
					
					
					$.ajax(
					{
						type: "POST",
						dataType:"html",
						url: "Sistema/Solicitud/ScriptInsertar.php",			
						data: Parametros,	
						beforeSend: function() 
						{
							window.parent.parent.Cargando(1);
						},												
						cache: false,			
						success: function(Resultado)
						{
							window.parent.parent.Cargando(0);
                            var Arreglo=jQuery.parseJSON(Resultado);
							//alert(Resultado);
							
							if(window.parent.ValidarConexionError(Resultado)==1)
							{	
								window.parent.MostrarMensaje("Verde", Arreglo["MENSAJE"]);
								window.parent.parent.Cargando(0);
								setTimeout(function() {
										
									}, 1000);
                                //FiltroConsulta(1);
								
								AbrirModulo("MenDes7", "Operadores", "Sistema/Operadores/FormOperadores.php")
								
							}
						}						
					});
				});

        });

        function NumCheck(e, field) {
            key = e.keyCode ? e.keyCode : e.which
            // backspace
            if (key == 8) return true
            // 0-9
            if (key > 47 && key < 58) {
                if (field.value == "") return true
                regexp = /.[0-9]{2}$/
                return !(regexp.test(field.value))
            }
            // .
            if (key == 46) {
                if (field.value == "") return false
                regexp = /^[0-9]+$/
                return regexp.test(field.value)
            }
            // other key
            return false
        
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