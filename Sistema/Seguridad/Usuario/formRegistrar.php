<?php 
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	ValidarSesion($Nivel);
	
	$Nivel="";
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <form role="form" id="formRegistrarUsuario">
		<input type="hidden" name="ID_EMPRESA_USER" id="ID_EMPRESA_USER" value="<?php echo $ID_EMPRESA_USER;?>">
        <div class="row">  
            <div class="col-lg-6">            
                <div class="form-group">
                    <label>Rol:</label>
                    <select class="form-control" required name="ID_ROL" id="ID_ROL" onChange="localidad()">
                    	<option value="" disabled selected>Seleccione...</option>
<?php 
						$Conector=Conectar();	

                        $vSQL="SELECT * FROM TB_ADMIN_USU_ROL WHERE ID_ROL!=5 AND FG_ACTIVO=1 ORDER BY NB_ROL ASC";
						$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
                        
                        $CONEXION=$ResultadoEjecutar["CONEXION"];						
                        $ERROR=$ResultadoEjecutar["ERROR"];
                        $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
                        $result=$ResultadoEjecutar["RESULTADO"];
                        
                        if($CONEXION=="SI" and $ERROR=="NO")
                        {		
                            while ($registro=odbc_fetch_array($result))
                            {			
                                $ID_ROL=odbc_result($result,'ID_ROL');
                                $NB_ROL=utf8_encode(odbc_result($result,'NB_ROL'));								
                                        
                                echo "<option value='$ID_ROL'>$NB_ROL</option>";
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
                <div class="form-group">
                    <label>Localidad:</label>
                    <select name="ID_LOCALIDAD" id="ID_LOCALIDAD" class="form-control" placeholder="Seleccione el puerto" required >
                        <option value="" disabled selected>SELECCIONE EL PUERTO...</option>
                    </select>
                </div> 
                <div class="form-group">
                    <label>Login:</label>
                    <input type="text" class="form-control" placeholder="RIF - Ej.: J00000000" required name="LOGIN" id="LOGIN" style="text-transform:uppercase;">
                </div>
                <div class="form-group">
                    <label>Razon social:</label>
                    <input type="text" class="form-control" placeholder="Razon social" required name="RAZON_SOCIAL" id="RAZON_SOCIAL">
                </div>
                <div class="form-group">
                    <label>Direccion:</label>
                    <textarea class="form-control" placeholder="Direccion" required name="DIRECCION" id="DIRECCION"></textarea>
                </div>
                <div class="form-group">
                    <label>Celular:</label>
                    <input type="text" class="form-control" placeholder="Celular - Ej.: 0412-1234567" required name="TLF" id="TLF">
                </div> 
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Correo:</label>
                    <input type="text" class="form-control" placeholder="Correo" required name="EMAIL" id="EMAIL"  autocomplete="off" onblur="ValidarCorreoRegistro('EMAIL', 'EMAILR', 1);" onKeyUp="ValidarCorreoRegistro('EMAILR', 'EMAIL', 0);">
                    <input type="hidden" required name="EMAILV" id="EMAILV" value="<?php echo $E_MAILU;?>">
                </div>
                <div class="form-group">
                    <label>Repita el correo:</label>
                    <input type="text" class="form-control" placeholder="Repita el correo" required name="EMAILR" id="EMAILR" onblur="ValidarCorreoRegistro('EMAILR', 'EMAIL', 1);" onKeyUp="ValidarCorreoRegistro('EMAILR', 'EMAIL', 0);">
                </div>
                <div class="form-group">
                    <label>Clave:</label>
                    <input type="password" class="form-control" placeholder="Clave" name="CLAVE" id="CLAVE" onBlur="validarClaves(1);" onKeyUp="validarClaves(0);" value="" required>
                </div>
                <div class="form-group">
                    <label>Repita la clave:</label>
                    <input type="password" class="form-control" placeholder="Repita la clave" name="CLAVER" id="CLAVER" onBlur="validarClaves(1);" onKeyUp="validarClaves(0);" value="" required>
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
			
			$('#LOGIN').keyup(function(event) 
			{
				var keycode = (event.keyCode ? event.keyCode : event.which);

				if(keycode == '13') 
				{
					$('#btnIngresar').click();
				}
			});

			$('#LOGIN').blur(function(event) 
			{
				if($(this).val().length!=10 && $(this).val().length>0)
				{
					window.parent.MostrarMensaje("Rojo", "Disculpe, Ingrese un RIF valido.");
					$("#LOGIN").focus();
					return;					
				}
			});

			$('#LOGIN').keydown(function (e)
			{
				if (e.shiftKey == 1) 
				{
					return false
				}

				var code = e.which;
				var key;

				//alert(code);

				key = String.fromCharCode(code);

				switch(true)
				{
					//Tipo de personas
					case code == 86 || code == 69 || code == 71 || code == 74 || code == 80:
					//Keyboard numbers
					case code >= 48 && code <= 57:
					//Keypad numbers
					case code >= 96 && code <= 105:
					//Negative sign
					case code == 189 || code == 109:
					// 37 (Left Arrow), 39 (Right Arrow), 8 (Backspace) , 46 (Delete), 36 (Home), 35 (End), 
					case code == 37 || code == 39 || code == 8 || code == 46 || code == 35 || code == 36 || code == 9:
						return;
					break;
				}

				e.preventDefault();
			});

			$("#LOGIN").inputmask("a9{1,9}",{"placeholder": ""});
			
			$("#TLF").inputmask("9999-9999999",{"placeholder": ""});
			
			$('#formRegistrarUsuario').on('submit', function(e) 
			{
                e.preventDefault();
                
			    guardar();
			});
			
			ValidarEntradaTeclado('TLF', 'TLFCelular');
		});
		
		function localidad()
		{
			Parametros="&ID_ROL="+$('#ID_ROL').val();

			$.ajax(
			{
				type: "POST",
				dataType:"html",
				url: "Sistema/Seguridad/Usuario/scriptLocalidad.php",
                data: Parametros,
                async: false,
				beforeSend: function()
				{
					window.parent.Cargando(1);
				},												
				cache: false,			
				success: function(Resultado)
				{
					if(window.parent.ValidarConexionError(Resultado)==1){
                        
                        Arreglo=jQuery.parseJSON(Resultado);

                        var OPTION=Arreglo['OPTION'];

                        $('#ID_LOCALIDAD').html(OPTION);

					    window.parent.Cargando(0);
                    }		
				}						
			});
		}
		
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

			Parametros=$('#formRegistrarUsuario').serialize();

			$.ajax(
			{
				type: "POST",
				dataType:"html",
				url: "Sistema/Seguridad/Usuario/scriptRegistrar.php",
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
								
								window.parent.FiltroConsulta(1);

                                $("#btbCancelar").click();
                            }else{
								if(RESULTADO==2)
								{									
									window.parent.Cargando(0);

									window.parent.MostrarMensaje("Rojo", "Disculpe, el usuario se encuentra registrado!");
								}
							}
						}
					}		
				}						
			});
		}
		
		function validarClaves(MSJ)
		{
			var valorC	=	$("#CLAVE").val().trim();
			var inputC	=	$("#CLAVE");
			var iconoC	=	$("#CLAVE_ICONO");

			var valorCR	=	$("#CLAVER").val().trim();
			var inputCR	=	$("#CLAVER");
			var iconoCR	=	$("#CLAVER_ICONO");

			if(!(valorC===valorCR) && valorC.length>0 && valorCR.length>0)
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
