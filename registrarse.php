<?php 
	$Nivel="";
	include($Nivel."includes/PHP/funciones.php");
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	if(isset($_SESSION[$SiglasSistema.'LOGIN']))
	{
		echo'
			<script language="javascript">
				self.location= "Principal.php" 
			</script>';
		
		exit;
	}
?>
<!DOCTYPE html>
<html>

<head>
	<title>SSP</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
			
	<link href="Includes/Imagenes/LogoSistema.ico" type="image/x-icon" rel="icon">

    <link href="Includes/Plugins/inspinia/css/bootstrap.min.css" rel="stylesheet">
    <link href="Includes/Plugins/inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="Includes/Plugins/inspinia/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    
    <link href="Includes/Plugins/inspinia/css/animate.css" rel="stylesheet">
    <link href="Includes/Plugins/inspinia/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">
	<div id="FondoInicioSesion"></div>
	<div id="LoadingGB" class="LoadingGB" style="display:none;">            
		<div class="spinner">
		  <div class="rect1"></div>
		  <div class="rect2"></div>
		  <div class="rect3"></div>
		  <div class="rect4"></div>
		  <div class="rect5"></div>
		</div>
		 <div id="Cargando">Cargando...</div>
	</div>

    <div class="text-center loginscreen  animated fadeInDown col-lg-6 col-lg-offset-3">
        <div>
            <div>
                <h1 class="logo-name">SSP</h1>
            </div>
            <h3>SSP</h3>
            <p>Crea tu cuenta en el Sistema de Servicios Portuarios</p>
            <form class="m-t" role="form" id="formRegistrarse">
               <div class="col-lg-6">  
					<div class="form-group">
						<input type="text" class="form-control" placeholder="RIF - Ej.: J00000000" required name="LOGIN" id="LOGIN" style="text-transform:uppercase;">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Razon social" required name="RAZON_SOCIAL" id="RAZON_SOCIAL">
					</div>
					<div class="form-group">
						<textarea class="form-control" placeholder="Direccion" required name="DIRECCION" id="DIRECCION"></textarea>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Celular - Ej.: 0412-1234567" required name="TLF" id="TLF">
					</div> 
               </div>
               <div class="col-lg-6">  
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Correo" required name="EMAIL" id="EMAIL"  autocomplete="off" onblur="ValidarCorreoRegistro('EMAIL', 'EMAILR', 1);" onKeyUp="ValidarCorreoRegistro('EMAILR', 'EMAIL', 0);">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Repita el correo" required name="EMAILR" id="EMAILR" onblur="ValidarCorreoRegistro('EMAILR', 'EMAIL', 1);" onKeyUp="ValidarCorreoRegistro('EMAILR', 'EMAIL', 0);">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Clave" required name="CLAVE" id="CLAVE" onBlur="validarClaves(1);" onKeyUp="validarClaves(0);">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Repita la clave" required name="CLAVER" id="CLAVER" onBlur="validarClaves(1);" onKeyUp="validarClaves(0);">
					</div>            	
               	</div>
                
                <button type="submit" class="btn btn-primary block full-width m-b" id="btnIngresar">Registrar</button>

                <p class="text-muted text-center"><small>¿Ya tienes una cuenta?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="./">Ingresar</a>
            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo $Nivel;?>Includes/Plugins/inspinia/js/jquery-2.1.1.js"></script>
    <script src="<?php echo $Nivel;?>Includes/Plugins/inspinia/js/bootstrap.min.js"></script>

    <!-- Toastr -->
    <script src="Includes/Plugins/inspinia/js/plugins/toastr/toastr.min.js"></script>

	<script src="Includes/Plugins/jquery.inputmask-3.x/js/inputmask.js" type="text/javascript"></script>
	<script src="Includes/Plugins/jquery.inputmask-3.x/js/jquery.inputmask.js" type="text/javascript"></script>
   
    <script>
		$(document).ready(function(e) 
		{			
			$('#LOGIN').focus();			

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

			$('#CLAVE').keyup(function(event) 
			{
				var keycode = (event.keyCode ? event.keyCode : event.which);

				if(keycode == '13') 
				{
					$('#btnIngresar').click();
				}
			});
			
			$("#TLF").inputmask("9999-9999999",{"placeholder": ""});
			
			$('#formRegistrarse').on('submit', function(e) 
			{
				e.preventDefault();

				registrarse();
			});

			ValidarEntradaTeclado('TLF', 'TLFCelular');
		});
		
		function registrarse()
		{
			if(validarClaves(1)==0)
			{
				return;
			}

			if($('#LOGIN').val().length!=10)
			{
				window.parent.MostrarMensaje("Rojo", "Disculpe, Ingrese un RIF valido.");
				$("#LOGIN").focus();
				return;					
			}
			
			VarCaptcha=VerificarCaptcha();

			if(VarCaptcha==0)
			{
				window.parent.MostrarMensaje("Rojo", "Disculpe, el Captcha ingresado no es correcto.");
				$("#TxtCaptcha").focus();
				return;					
			}		

			Parametros=$('#formRegistrarse').serialize();

			$.ajax(
			{
				type: "POST",
				dataType:"html",
				url: "Sistema/Sesion/Registrarse.php",
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

							if(RESULTADO==2)
							{
								window.parent.Cargando(0);

								window.parent.MostrarMensaje("Rojo", "Disculpe, El usuario se encuentra registrado!");
							}
							else
							{									
								if(RESULTADO==1)
								{
									window.parent.Cargando(0);

									window.parent.MostrarMensaje("Verde", "Registro realizado exitosamente!");

									setTimeout(function() {
										window.location.href="./";
									}, 3000);
								}
								else
								{									

								}
							}
						}
					}		
				}						
			});
		}
		
		function VerificarCaptcha()
		{
			return 1;
			var VarCaptcha=0;
			var TxtCaptcha = $('#TxtCaptcha').val();

			parametros='TxtCaptcha='+TxtCaptcha;

			$.ajax(
			{
				type: "POST",
				dataType:"html",
				url: "Includes/Plugins/cool-php-captcha-0.3.1/verificar.php",			
				data: parametros, 
				async: false,	
				beforeSend: function() 
				{
					window.parent.Cargando(1);
				},			
				success: function(result)
				{						
					if(result==0)
					{
						 VarCaptcha=result;

						 window.parent.Cargando(0);
					}
					else
					{
						 VarCaptcha=result;
					}
				}	
			});

			return VarCaptcha;
		}

		function MostrarMensaje(Tipo, Mensaje)
		{
			window.parent.toastr.options = {
				closeButton: true,
				progressBar: true,
				showMethod: 'slideDown',
				timeOut: 4000,
				positionClass: "toast-bottom-center",
			};
			
			switch(Tipo)
			{					
				case "Verde":
					window.parent.toastr.success(Mensaje, "Procesado");	
				break;

				case "Amarillo":
					window.parent.toastr.warning(Mensaje, "Alerta");	
				break;

				case "Rojo":
					window.parent.toastr.error(Mensaje, "Error");	
				break;

				case "Azul":
					window.parent.toastr.info(Mensaje, "Informacion");	
				break;
			}
		}

		function Cargando(Op)
		{
			if(Op)
			{
				if(!$("#LoadingGB").is(':visible'))
				{
					window.parent.$("#LoadingGB").css("display","");
				}
			}
			else
			{
				if($("#LoadingGB").is(':visible'))
				{
					window.parent.$("#LoadingGB").css("display","none");
				}
			}
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

		function ValidarEntradaTeclado(ID, Tipo)
		{
			switch(true)
			{
				case Tipo == 'SoloLetras':	
					$('#'+ID).keydown(function (e)
					{
						if (e.shiftKey == 1) 
						{
							return true;
						}

						var code = e.which;
						var key;

						//alert(tlf.length+" "+code);

						key = String.fromCharCode(code);

						switch(true)
						{
							///Letas del teclado
							case code >= 65 && code <= 90:
							// 37 (Flecha izquierda), 39 (Flecha derecha), 8 (Borrar) , 46 (Suprimir), 36 (Inicio), 35 (Fin), 32 (Espacio), 
							case code == 37 || code == 39 || code == 8 || code == 46 || code == 35 || code == 36 || code == 9 || code == 32:
								return true;
							break;
						}

						e.preventDefault();
					});
				break;

				case Tipo == 'SoloNumeros':	
					$('#'+ID).keydown(function (e)
					{
						if (e.shiftKey == 1) 
						{
							return true;
						}

						var code = e.which;
						var key;

						//alert(tlf.length+" "+code);

						key = String.fromCharCode(code);

						switch(true)
						{
							//Numeros del teclado
							case code >= 48 && code <= 57:
							//Numpad
							case code >= 96 && code <= 105:
							// 37 (Flecha izquierda), 39 (Flecha derecha), 8 (Borrar) , 46 (Suprimir), 36 (Inicio), 35 (Fin), 32 (Espacio), 
							case code == 37 || code == 39 || code == 8 || code == 46 || code == 35 || code == 36 || code == 9 || code == 32:
								return true;
							break;
						}

						e.preventDefault();
					});
				break;

				case Tipo == 'SoloLetrasNumeros':	
					$('#'+ID).keydown(function (e)
					{
						if (e.shiftKey == 1) 
						{
							return true;
						}

						var code = e.which;
						var key;

						//alert(tlf.length+" "+code);

						key = String.fromCharCode(code);

						switch(true)
						{
							///Letas del teclado
							case code >= 65 && code <= 90:
							//Numeros del teclado
							case code >= 48 && code <= 57:
							//Numpad
							case code >= 96 && code <= 105:
							// 37 (Flecha izquierda), 39 (Flecha derecha), 8 (Borrar) , 46 (Suprimir), 36 (Inicio), 35 (Fin), 32 (Espacio), 
							case code == 37 || code == 39 || code == 8 || code == 46 || code == 35 || code == 36 || code == 9 || code == 32:
								return true;
							break;
						}

						e.preventDefault();
					});
				break;

				case Tipo == 'RIF':					
					$('#'+ID).inputmask("a99999999-9",{"placeholder": "V########-#"});

					$('#'+ID).keydown(function (e)
					{
						if (e.shiftKey == 1) 
						{
							return true;
						}

						var code = e.which;
						var key;

						key = String.fromCharCode(code);

						var tlf	=	$(this).val();

						//alert(tlf);							

						switch(true)
						{
							//Tipo de personas 86 (V), 69 (E), 71 (G), 74 (J), 80 (P) 
							case code == 86 || code == 69 || code == 71 || code == 74 || code == 80:
							//Numeros del teclado
							case code >= 48 && code <= 57:
							//Numpad
							case code >= 96 && code <= 105:
							// 37 (Flecha izquierda), 39 (Flecha derecha), 8 (Borrar) , 46 (Suprimir), 36 (Inicio), 35 (Fin)
							case code == 37 || code == 39 || code == 8 || code == 46 || code == 35 || code == 36 || code == 9:
								return true;
							break;
						}

						e.preventDefault();
					});
				break;

				case Tipo == 'CI':				
					$('#'+ID).inputmask("a99999999",{"placeholder": "V########"});

					$('#'+ID).keydown(function (e)
					{
						if (e.shiftKey == 1) 
						{
							return true;
						}

						var code = e.which;
						var key;

						var tlf	=	$(this).val();

						//alert(tlf.length+" "+code);

						switch(true)
						{
							//Tipo de personas 86 (V), 69 (E)
							case code == 86 || code == 69:
							//Numeros del teclado
							case code >= 48 && code <= 57:
							//Numpad
							case code >= 96 && code <= 105:
							// 37 (Flecha izquierda), 39 (Flecha derecha), 8 (Borrar) , 46 (Suprimir), 36 (Inicio), 35 (Fin)
							case code == 37 || code == 39 || code == 8 || code == 46 || code == 35 || code == 36 || code == 9:
								return true;
							break;
						}

						e.preventDefault();
					});
				break;

				case Tipo == 'TLFCelular':	
					$('#'+ID).inputmask("9999-9999999",{"placeholder": "####-#######"});

					$('#'+ID).keydown(function (e)
					{
						if (e.shiftKey == 1) 
						{
							return false
						}

						var code 		=	e.which;
						var key	 		=	String.fromCharCode(code);

						var tlf			=	$(this).val().split("#").join("");
						var Longitud 	= 	tlf.length;

						//alert(Longitud+" "+code);	

						switch(true)
						{
							case Longitud == 0 || Longitud == 1:
								switch(true)
								{
									//Numeros del teclado
									case code == 48:
									//Numpad
									case code == 96:
									// 37 (Flecha izquierda), 39 (Flecha derecha), 8 (Borrar) , 46 (Suprimir), 36 (Inicio), 35 (Fin), 
									case code == 37 || code == 39 || code == 8 || code == 46 || code == 35 || code == 36 || code == 9:						
										return true;
									break;
								}
							break;

							case Longitud == 2:
								switch(true)
								{
									//Numeros del teclado
									case code == 52:
									//Numpad
									case code == 100:
									// 37 (Flecha izquierda), 39 (Flecha derecha), 8 (Borrar) , 46 (Suprimir), 36 (Inicio), 35 (Fin), 
									case code == 37 || code == 39 || code == 8 || code == 46 || code == 35 || code == 36 || code == 9:						
										return true;
									break;
								}
							break;

							case Longitud == 3:
								switch(true)
								{
									//Numeros del teclado
									case code == 49 || code == 50:
									//Numpad
									case code == 97 || code == 98:
									// 37 (Flecha izquierda), 39 (Flecha derecha), 8 (Borrar) , 46 (Suprimir), 36 (Inicio), 35 (Fin), 
									case code == 37 || code == 39 || code == 8 || code == 46 || code == 35 || code == 36 || code == 9:						
										return true;
									break;
								}
							break;

							case Longitud == 4:
								switch(true)
								{
									//Numeros del teclado
									case code == 50 || code == 52 || code == 54:
									//Numpad
									case code == 98 || code == 100 || code == 102:
									// 37 (Flecha izquierda), 39 (Flecha derecha), 8 (Borrar) , 46 (Suprimir), 36 (Inicio), 35 (Fin), 
									case code == 37 || code == 39 || code == 8 || code == 46 || code == 35 || code == 36 || code == 9:						
										return true;
									break;
								}
							break;

							case Longitud > 4:
								switch(true)
								{
									//Numeros del teclado
									case code >= 48 && code <= 57:
									//Numpad
									case code >= 96 && code <= 105:
									// 37 (Flecha izquierda), 39 (Flecha derecha), 8 (Borrar) , 46 (Suprimir), 36 (Inicio), 35 (Fin), 
									case code == 37 || code == 39 || code == 8 || code == 46 || code == 35 || code == 36 || code == 9:						
										return true;
									break;
								}
							break;
						}

						e.preventDefault();
					});
				break;

				case Tipo == 'TLFFijo':
				break;
			}
		}
    </script>
</body>

</html>
