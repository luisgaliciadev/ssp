<?php 
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	ValidarSesion($Nivel);
	
	$LOGIN=$_SESSION[$SiglasSistema.'LOGIN'];
    
    $Conector=Conectar();
    
    $vSQL='EXEC [SP_SESION_VERIFICAR_USUARIO] "'.$LOGIN.'"';

    $ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

    $CONEXION=$ResultadoEjecutar["CONEXION"];

    $ERROR=$ResultadoEjecutar["ERROR"];
    $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
    $resultPrin=$ResultadoEjecutar["RESULTADO"];

    if($CONEXION=="SI" and $ERROR=="NO"){
        while(odbc_fetch_row($resultPrin)){
            $ID_EMPRESA_USER    = odbc_result($resultPrin,"ID_EMPRESA_USER");
            $RIF	            = odbc_result($resultPrin,"RIF");
            $RAZON_SOCIAL	    = utf8_encode(strtoupper(odbc_result($resultPrin,"RAZON_SOCIAL")));
            $DIRECCION	        = utf8_encode(strtoupper(odbc_result($resultPrin,"DIRECCION")));         
            $E_MAILU	        = utf8_encode(strtoupper(odbc_result($resultPrin,"E_MAILU")));
            $TELEFU             = odbc_result($resultPrin,"TELEFU");
        }
    }else{									
        echo $MSJ_ERROR;
    }

    $Conector->Cerrar();
	
	$Nivel="";
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <form role="form" id="formRegistrarse">
        <div class="row">  
            <div class="col-lg-6">            
                <div class="form-group">
                    <label>RIF:</label>
                    <input type="text" class="form-control" placeholder="RIF - Ej.: J00000000" required name="LOGIN" id="LOGIN" value="<?php echo $LOGIN;?>" readonly>
                </div>
                <div class="form-group">
                    <label>Razon social:</label>
                    <input type="text" class="form-control" placeholder="Razon social" required name="RAZON_SOCIAL" id="RAZON_SOCIAL" value="<?php echo $RAZON_SOCIAL;?>">
                </div>
                <div class="form-group">
                    <label>Direccion:</label>
                    <textarea class="form-control" placeholder="Direccion" required name="DIRECCION" id="DIRECCION"><?php echo $DIRECCION;?></textarea>
                </div>
                <div class="form-group">
                    <label>Celular:</label>
                    <input type="text" class="form-control" placeholder="Celular - Ej.: 0412-1234567" required name="TLF" id="TLF" value="<?php echo $TELEFU;?>">
                </div> 
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Correo:</label>
                    <input type="text" class="form-control" placeholder="Correo" required name="EMAIL" id="EMAIL"  autocomplete="off" onblur="ValidarCorreoRegistro('EMAIL', 'EMAILR', 1);" onKeyUp="ValidarCorreoRegistro('EMAILR', 'EMAIL', 0);" value="<?php echo $E_MAILU;?>">
                    <input type="hidden" required name="EMAILV" id="EMAILV" value="<?php echo $E_MAILU;?>">
                </div>
                <div class="form-group">
                    <label>Repita el correo:</label>
                    <input type="text" class="form-control" placeholder="Repita el correo" required name="EMAILR" id="EMAILR" onblur="ValidarCorreoRegistro('EMAILR', 'EMAIL', 1);" onKeyUp="ValidarCorreoRegistro('EMAILR', 'EMAIL', 0);" value="<?php echo $E_MAILU;?>">
                </div>
                <div class="form-group">
                    <label>Clave:</label>
                    <input type="password" class="form-control" placeholder="Clave" name="CLAVE" id="CLAVE" value="">
                </div>
                <div class="form-group">
                    <label>Repita la clave:</label>
                    <input type="password" class="form-control" placeholder="Repita la clave" name="CLAVER" id="CLAVER" value="">
                </div> 
            </div>           
        </div>
        <div class="row">
            <div class="col-lg-12">
                <footer>     
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btbCancelar">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </footer>
            </div>           
        </div>
    </form>
    <script>
		$(document).ready(function(e) 
		{
            window.parent.Cargando(0);			
			
			$("#TLF").inputmask("9999-9999999",{"placeholder": ""});
			
			$('#formRegistrarse').on('submit', function(e) 
			{
                e.preventDefault();
                
			    guardar();
			});

			ValidarEntradaTeclado('TLF', 'TLFCelular');
		});
		
		function guardar()
		{
			if($('#LOGIN').val().length!=10)
			{
				window.parent.MostrarMensaje("Rojo", "Disculpe, Ingrese un RIF valido.");
				$("#LOGIN").focus();
				return;					
            }	
            
			if(ValidarCorreoRegistro('EMAIL', 'EMAILR', 1)==0)
			{
				return;
            }
            
			if(validarClaves(1)==0)
			{
				return;
            }	

			Parametros=$('#formRegistrarse').serialize();

			$.ajax(
			{
				type: "POST",
				dataType:"html",
				url: "Sistema/Sesion/Modificar.php",
				data: Parametros,
				beforeSend: function()
				{
					window.parent.Cargando(1);
				},												
				cache: false,			
				success: function(Resultado)
				{
					var Arreglo=jQuery.parseJSON(Resultado);
					
					var CONEXION=Arreglo['CONEXION'];

					if(CONEXION=="NO")
					{		
						window.parent.Cargando(0);
						
						window.parent.MostrarMensaje("Rojo", "Error, No se puedo conectar con el servidor, por favor notificar al correo ssp@bolipuertos.gob.ve, envie captura de pantalla.");
					}
					else
					{
						var ERROR=Arreglo['ERROR'];

						if(ERROR=="SI")
						{		
							window.parent.Cargando(0);
							
							window.parent.MostrarMensaje("Rojo", "Error de ejecución, por favor notificar al correo ssp@bolipuertos.gob.ve, envie captura de pantalla.");
						}
						else
						{
                            var RESULTADO=Arreglo['RESULTADO'];	
                            							
                            if(RESULTADO==1)
                            {
                                window.parent.Cargando(0);

                                window.parent.MostrarMensaje("Verde", "Registro realizado exitosamente!");

                                $("#CLAVE").val('');
                                $("#CLAVER").val('');

                                $("#btbCancelar").click();
                            }
						}
					}		
				}						
			});
		}
		
		function validarClaves(MSJ)
		{
            if ($("#CLAVE").val().trim().length==0 && $("#CLAVER").val().trim().length==0) {
                return 1;
            }else{
                var valorC	=	$("#CLAVE").val().trim();
                var inputC	=	$("#CLAVE");
                var iconoC	=	$("#CLAVE_ICONO");

                var valorCR	=	$("#CLAVER").val().trim();
                var inputCR	=	$("#CLAVER");
                var iconoCR	=	$("#CLAVER_ICONO");

                if(!(valorC===valorCR))
                {
                    if(MSJ)
                    {
                        window.parent.MostrarMensaje("Rojo", "Disculpe, Las claves no coinciden.");
                    }

                    inputC.css("color", "#DD4B39");
                    iconoC.css("color", "#DD4B39");

                    inputCR.css("color", "#DD4B39");
                    iconoCR.css("color", "#DD4B39");

                    return 0;
                }
                else
                {
                    if(valorC===valorCR && valorC.length>0 && valorCR.length>0)
                    {
                        inputC.css("color", "#00a65a");
                        iconoC.css("color", "#00a65a");

                        inputCR.css("color", "#00a65a");
                        iconoCR.css("color", "#00a65a");

                        return 1;
                    }
                    else
                    {
                        inputC.css("color", "#000");
                        iconoC.css("color", "#777777");

                        inputCR.css("color", "#000");
                        iconoCR.css("color", "#777777");

                        return 0;
                    }
                }    
            }
		}
		
		function ValidarCorreoRegistro(ID, ID_ENLAZADO, MSJ)
		{
			var valor	=	$("#"+ID).val().trim();
			var input	=	$("#"+ID);
			var icono	=	$("#"+ID+"_ICONO");

			var valorE	=	$("#"+ID_ENLAZADO).val().trim();
			var inputE	=	$("#"+ID_ENLAZADO);
			var iconoE	=	$("#"+ID_ENLAZADO+"_ICONO");

			if(valor.length>0)
			{
				//alert(valor.length);
				// Patron para el correo
				var patron=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;

				if(valor.search(patron)==0)
				{
					input.css("color", "#000");
					icono.css("color", "#777777");
				}
				else
				{
					input.css("color", "#DD4B39");
					icono.css("color", "#DD4B39");

					if(MSJ)
					{
						window.parent.MostrarMensaje("Rojo", "Por Favor Ingrese un Correo Valido!");
					}

					return 0;
				}

				if(valor!=valorE && valor.length>0 && valorE.length>0)
				{
					input.css("color", "#DD4B39");
					icono.css("color", "#DD4B39");

					inputE.css("color", "#DD4B39");
					iconoE.css("color", "#DD4B39");

					if(MSJ)
					{
						window.parent.MostrarMensaje("Rojo", "Disculpe, los correos no coinciden!");
					}

					return 0;
				}
				else
				{
					if(valor.length>0)
					{
						input.css("color", "#00a65a");
						icono.css("color", "#00a65a");
					}
					else
					{
						input.css("color", "#000");
						icono.css("color", "#777777");
					}

					if(valorE.length>0)
					{
						inputE.css("color", "#00a65a");
						iconoE.css("color", "#00a65a");
					}
					else
					{
						inputE.css("color", "#000");
						iconoE.css("color", "#777777");
					}
					
					return 1;
				}
			}
		}
    </script>
</body>

</html>
