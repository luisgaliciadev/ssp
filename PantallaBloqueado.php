<?php 		
	$Nivel="";
	include($Nivel."includes/PHP/funciones.php");
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	if(!isset($_SESSION[$_SESSION['SiglasSistema'].'LOGIN'])) 
	{
		echo '
			<script>				
				window.location="'.$Nivel.'index.php";
			</script>';	
		exit;
	}
	
	$_SESSION[$_SESSION['SiglasSistema'].'BLOQUEADO']='SI';
	
	$LOGIN			= $_SESSION[$SiglasSistema.'LOGIN'];	
	$ID_LOCALIDAD	= $_SESSION[$SiglasSistema.'ID_LOCALIDAD'];
?>
<!DOCTYPE html>
<html>

<head>
	<title>SSP</title>

	<meta charset="utf-8">
	
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">  

	<link rel="stylesheet" href="<?php echo $Nivel;?>Includes/CSS/Loading.css">     
	
	<link href="<?php echo $Nivel;?>Includes/Plugins/toastr-master/toastr.css" rel="stylesheet"/>

    <link href="<?php echo $Nivel;?>Includes/Plugins/inspinia/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $Nivel;?>Includes/Plugins/inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo $Nivel;?>Includes/Plugins/inspinia/css/animate.css" rel="stylesheet">
    <link href="<?php echo $Nivel;?>Includes/Plugins/inspinia/css/style.css" rel="stylesheet">
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
        <div id="LoadingGB" class="LoadingGB" style="display:none;">
			<!-- <div class="spinner">
			<div class="rect1"></div>
			<div class="rect2"></div>
			<div class="rect3"></div>
			<div class="rect4"></div>
			<div class="rect5"></div>
			</div> -->
			<!-- <div class="sk-folding-cube">
				<div class="sk-cube1 sk-cube"></div>
				<div class="sk-cube2 sk-cube"></div>
				<div class="sk-cube4 sk-cube"></div>
				<div class="sk-cube3 sk-cube"></div>
			</div> -->
			<div class="sk-cube-grid">
				<div class="sk-cube sk-cube1"></div>
				<div class="sk-cube sk-cube2"></div>
				<div class="sk-cube sk-cube3"></div>
				<div class="sk-cube sk-cube4"></div>
				<div class="sk-cube sk-cube5"></div>
				<div class="sk-cube sk-cube6"></div>
				<div class="sk-cube sk-cube7"></div>
				<div class="sk-cube sk-cube8"></div>
				<div class="sk-cube sk-cube9"></div>
			</div>
			<div id="Cargando">Cargando...</div>
        </div>

<div class="lock-word animated fadeInDown">
    <span class="first-word"></span><span></span>
</div>
    <div class="middle-box text-center lockscreen animated fadeInDown">
        <div>
            <div class="m-b-md">
            <img alt="image" class="img-circle circle-border" src="Includes/Plugins/inspinia/img/profile_small.jpg">
            </div>
            <h3>Ventana de Ventas</h3>
            <p>Taquilla Unica Integral en cada Puerto, con enlace a Sede Central</p>
            <form class="m-t" role="form"  id="FromInicioSesion">
				<input type="hidden" id="LOGIN" value="<?php echo $LOGIN;?>">
                <input type="hidden" id="ID_LOCALIDAD" value="<?php echo $ID_LOCALIDAD;?>">
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Clave" required id="CLAVE" value="12345678">
                </div>
                <div class="form-group">
					<button type="submit" class="btn btn-primary block full-width">Desbloquear</button>
				</div>
                <div class="form-group">
					<button type="button" class="btn btn-white  block full-width" onClick="CerrarSesion();">Salir</button>
				</div>
            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo $Nivel;?>Includes/Plugins/inspinia/js/jquery-2.1.1.js"></script>
    <script src="<?php echo $Nivel;?>Includes/Plugins/inspinia/js/bootstrap.min.js"></script>
    
	<script>  					
		$(document).ready(function(e) 
		{				
			$('#CLAVE').focus();

			$('#FromInicioSesion').on('submit', function(e) 
			{
				e.preventDefault();

				VerificarUsuario();
			});

			$('#CLAVE').keyup(function(event) 
			{
				var keycode = (event.keyCode ? event.keyCode : event.which);

				if(keycode == '13') 
				{
					VerificarUsuario();
				}
			});

			//$('#CLAVE').val('');	
		});

		function CerrarSesion()
		{
			$.ajax(
			{
				type: "POST",
				dataType:"html",
				url: "Sistema/Sesion/CerrarSesion.php",			
				data: "",									
				cache: false,				
				success: function(result)
				{		
					window.location.href = "./"
				}
			});	
		}

		function VerificarUsuario()
		{			
			var ID_LOCALIDAD=$("#ID_LOCALIDAD").val();		
			var	LOGIN=$("#LOGIN").val();
			var CLAVE=$("#CLAVE").val();

			Parametros="&ID_LOCALIDAD="+ID_LOCALIDAD+"&LOGIN="+LOGIN+"&CLAVE="+CLAVE;

			$.ajax(
			{
				type: "POST",
				dataType:"html",
				url: "Sistema/Sesion/VerificarUsuario.PHP",			
				data: Parametros,	
				beforeSend: function() 
				{
					window.parent.Cargando(1);
				},												
				cache: false,			
				success: function(Resultado)
				{
					//alert(Resultado);

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
						window.parent.MostrarMensaje("Rojo", "Error, No se puedo conectar con el servidor, por favor notificar al correo 	ssp@bolipuertos.gob.ve, envie captura de pantalla.");
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
							window.parent.MostrarMensaje("Rojo", "Error de sentencia SQL, contacte al personal del departamento de sistemas.");
						}
						else
						{
							var RESULTADO=Arreglo['RESULTADO'];

							if(RESULTADO==1)
							{
								window.location.href='Principal.php';
							}
							else
							{	
								window.parent.Cargando(0);

								window.parent.MostrarMensaje("Rojo", "Disculpe, Usuario o Contraseña errados!");

								$('#CLAVE').focus();
							}
						}
					}		
				}						
			});
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
	</script>
</body>

</html>
