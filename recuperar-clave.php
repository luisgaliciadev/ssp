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
    
    <style>
        body
        {
            margin-top:0px;
            border: 1px solid rgba(0, 0, 0, 0);
        }

        #FondoInicioSesion
        {
            background:url(Includes/Imagenes/FondoInicioSesion.jpg) no-repeat center fixed;
            background-size:cover;
            height:100%;
            width:100%;
            z-index:-1;
            position:fixed;
        }
    </style>
</head>

<body class="gray-bg">
<div id="FondoInicioSesion"></div>
    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">¿Olvido su contraseña?</h2>

                    <p>
                        Ingresa tu RIF y se enviara un correo con una nueva clave 
                    </p>

                    <div class="row">

                        <div class="col-lg-12">
                            <form class="m-t" role="form" id="formRecuperarClave">
                                <div class="form-group">
                                <input id="LOGIN" name="LOGIN" type="text" required class="form-control" placeholder="RIF - Ej.: J00000000" style="text-transform:uppercase;" autocomplete="off" value="V100000000">
                                </div>

                                <button type="submit" class="btn btn-primary block full-width m-b">Enviar clave</button>
                                <a class="btn btn-sm btn-white btn-block" href="./">Ingresar</a>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-12">
                Copyright © 2017. SOLUCIONES INTEGRALES SICA 9000 C.A.
            </div>
        </div>
    </div>
    
    <!-- Mainly scripts -->
    <script src="Includes/Plugins/inspinia/js/jquery-2.1.1.js"></script>
    <script src="Includes/Plugins/inspinia/js/bootstrap.min.js"></script>    

    <!-- Toastr -->
    <script src="Includes/Plugins/inspinia/js/plugins/toastr/toastr.min.js"></script>

    <script src="Includes/Plugins/jquery.inputmask-3.x/js/inputmask.js" type="text/javascript"></script>
    <script src="Includes/Plugins/jquery.inputmask-3.x/js/jquery.inputmask.js" type="text/javascript"></script>

    <script> 					 					
        $(document).ready(function(e) 
        {			
            $('#LOGIN').focus();

            $('#formRecuperarClave').on('submit', function(e) 
            {
                e.preventDefault();

                recuperarClave();
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

            $('#LOGIN').keyup(function(event) 
            {
                var keycode = (event.keyCode ? event.keyCode : event.which);

                if(keycode == '13') 
                {
                    $('#btnRecuperarClave').click();
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
        });

        function recuperarClave(){
            var	LOGIN	= $("#LOGIN").val().trim();

            if($('#LOGIN').val().length!=10)
            {
                window.parent.MostrarMensaje("Rojo", "Disculpe, Ingrese un RIF valido.");
                $("#LOGIN").focus();
                return;					
            }

            var  parametros = "&LOGIN="+LOGIN;
                
            $.ajax({
                type: "POST",
                dataType:"html",
                url: "Sistema/Sesion/recuperarClave.PHP",			
                data: parametros,
                beforeSend: function(){
                    window.parent.parent.Cargando(1);
                },												
                cache: false,			
                success: function(Resultado){						
                    if(window.parent.ValidarConexionError(Resultado)==1){
                        
                        Arreglo=jQuery.parseJSON(Resultado);

                        var RESULTADO=Arreglo['RESULTADO'];

                        if(RESULTADO==-3)
                        {
                            window.parent.Cargando(0);

                            window.parent.MostrarMensaje("Rojo", "Disculpe, Usuario no se encuentra registrado!");

                            $("#LOGIN").focus();
                        }
                        else
                        {
                            if(RESULTADO==-2)
                            {
                                window.parent.Cargando(0);

                                window.parent.MostrarMensaje("Rojo", "Disculpe, su usuario se encuentra bloqueado por superar los 10 intentos fallidos!");

                                $("#LOGIN").focus();
                            }
                            else
                            {								
                                if(RESULTADO==0)
                                {
                                    window.parent.Cargando(0);

                                    window.parent.MostrarMensaje("Amarillo", "Disculpe, su usuario ha sido deshabilitado!");
                                }
                                else
                                {		
                                    if(RESULTADO==1)
                                    {
                                        window.parent.Cargando(0);

                                        window.parent.MostrarMensaje("Verde", "Recuperacion de contraseña exitosamente, revise su correo electronico!");
                                        
                                        setTimeout(function() {
                                            window.location.href="./";
                                        }, 3000);
                                    }
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

        function RecargarCaptcha()
        {
            document.getElementById('captcha').src='Includes/Plugins/cool-php-captcha-0.3.1/captcha.php?'+Math.random();
            $('#TxtCaptcha').val('');
            $('#TxtCaptcha').focus();
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

        function MostrarMensaje(Tipo, Mensaje)
        {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000,
                positionClass: "toast-bottom-center"
            };
            
            switch(Tipo)
            {					
                case "Verde":
                    toastr.success(Mensaje, "Procesado");	
                break;

                case "Amarillo":
                    toastr.warning(Mensaje, "Alerta");	
                break;

                case "Rojo":
                    toastr.error(Mensaje, "Error");	
                break;

                case "Azul":
                    toastr.info(Mensaje, "Informacion");	
                break;
            }
        }

        function ValidarConexionError(Resultado)
        {
            var Arreglo=jQuery.parseJSON(Resultado);

            var CONEXION=Arreglo['CONEXION'];

            if(CONEXION=="NO")
            {		
                window.parent.Cargando(0);

                var MSJ_ERROR=Arreglo['MSJ_ERROR'];	
<?php
                if(IpServidor()=="10.10.30.52")
                {
?>	
                    alert(MSJ_ERROR);
<?php
                }
?>
                window.parent.MostrarMensaje("Rojo", "Error, No se puedo conectar con el servidor, por favor notificar al correo ssp@bolipuertos.gob.ve, envie captura de pantalla.");

                return 0;
            }
            else
            {
                var ERROR=Arreglo['ERROR'];

                if(ERROR=="SI")
                {		
                    window.parent.Cargando(0);

                    var MSJ_ERROR=Arreglo['MSJ_ERROR'];	
<?php
                    if(IpServidor()=="10.10.30.52")
                    {
?>	
                        alert(MSJ_ERROR);
<?php
                    }
?>
                    window.parent.MostrarMensaje("Rojo", "Error de ejecución, por favor notificar al correo ssp@bolipuertos.gob.ve, envie captura de pantalla.");

                    return 0;
                }
                else
                {
                    return 1;
                }
            }
        }
    </script>
</body>

</html>
