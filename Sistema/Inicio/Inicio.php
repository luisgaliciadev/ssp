<?php 
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	ValidarSesion($Nivel);
	
	$vNB_MODULO=$_POST["vNB_MODULO"];	
	
	$Nivel="";
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	$RIF=$_SESSION[$SiglasSistema.'RIF'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Inicio</title>
    <style type="text/css">
    .wrapper.wrapper-content.animated.fadeInRight .row .col-lg-12 .ibox.float-e-margins .ibox-title h5 {
	font-weight: bold;
	font-size: 18px;
}
    .wrapper.wrapper-content.animated.fadeInRight .row .col-lg-12 .ibox.float-e-margins .ibox-content {
	font-size: 18px;
	text-align: justify;
}
    </style>
	</head>
	<body>    
		<div class="row wrapper border-bottom white-bg page-heading">
			<div class="col-lg-10">
				<h2><?php echo $vNB_MODULO;?></h2>
				<ol class="breadcrumb">
					<li>
						<a href="./">
							<i class="fa fa-home"></i> 
							<strong>Inicio</strong>
						</a>
					</li>
				</ol>
			</div>
		   
		
		<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
				
						<div class="ibox-content">
                    <h2>SSP</h2>
                    <DIV> <small>Objetivo Sistema de Servicio Portuario</small></DIV>
							
                    <div class="col-lg-4">
						<div class="widget style1 navy-bg">
							<div class="row">
								<div class="col-xs-4">
									<i class="fa fa-anchor fa-4x"></i>
								</div>
								<div class="col-xs-8 text-right">
									<span> Una Ventana &Uacute;nica para el cliente </span>
								</div>
							</div>
						</div>
					
                   
						<div class="widget style1 navy-bg">
							<div class="row">
							<div class="col-xs-4">
								<i class="fa fa-line-chart fa-4x"></i>
							</div>
							<div class="col-xs-8 text-right">
								<span>Asesor&iacute;a previa a la llegada del buque</span>
								
							</div>
							</div>
						</div>
                    
                       
                      </div>
                      
                      <div class="col-lg-4">
                		<div class="widget style1 lazur-bg">
						<div class="row">
							<div class="col-xs-4">
								<i class="fa fa-calculator fa-4x"></i>
							</div>
							<div class="col-xs-8 text-right">
								<span> Preliquidaci&oacute;n y forma de pago On-Line </span>
								
							</div>
						</div>
                	</div>
                	
                		<div class="widget style1 lazur-bg">
							<div class="row">
							<div class="col-xs-4">
								<i class="fa fa-window-restore fa-4x"></i>
							</div>
							<div class="col-xs-8 text-right">
								<span>Estandarizaci&oacute;n de los procesos</span>
								
							</div>
							</div>
						</div>
                      
               
					
            	</div>	
						
						 <div class="col-lg-4">
                		<div class="widget style1 yellow-bg">
						<div class="row">
							<div class="col-xs-4">
								<i class="fa fa-clipboard fa-4x"></i>
							</div>
							<div class="col-xs-8 text-right">
								<span> Simplificaci&oacute;n de Tramites y Procedimientos </span>
								
							</div>
						</div>
                	</div>
                	
                		<div class="widget style1 yellow-bg">
							<div class="row">
							<div class="col-xs-4">
								<i class="fa fa-handshake-o fa-4x"></i>
							</div>
							<div class="col-xs-8 text-right">
								<span>Respuesta expedita al Cliente</span>
								
							</div>
							</div>
						</div>
                      
               
					
            	</div>	
						
						
						<!--<div class="ibox-content">
							<div><img src="Includes/Imagenes/i1.png"> Una Ventana &Uacute;nica para el cliente</div>
							<div><br></br></div>
							
							<div><img src="Includes/Imagenes/i2.png"> Asesor&iacute;a previa a la llegada del buque</div>
							
							<div><br></br></div>
							<div>
							<img src="Includes/Imagenes/i3.png"> Preliquidaci&oacute;n y forma de pago On-Line</div>
							<div><br></br></div>
							
							<div><img src="Includes/Imagenes/i4.png"> Simplificaci&oacute;n de Tramites y Procedimientos </div>
                           <div><br></br></div>
                            <div><img src="Includes/Imagenes/i5.png"> Estandarizaci&oacute;n de los procesos </div>
                            <div><br></br></div>
                            <div><img src="Includes/Imagenes/i6.png"> Respuesta expedita al Cliente </div>
                            <div><br></br></div>
							<div><img src="Includes/Imagenes/i7.png"> Sistema Integrado de Servicios Portuarios </div>
							<div><br></br></div>
							<div><img src="Includes/Imagenes/i8.png"> Planificaci&oacute;n del Negocio, Financiero y Operativo </div>
						</div>-->
					
				</div>
			</div>
		</div> 
		</div>
		</div>
		</div> 
        <script>
			$(document).ready(function(e) 
			{
				window.parent.Cargando(0);	
				//window.parent.MostrarMensaje("Rojo", "El archivo excel seleccionado no contiene cargas.");
            });			
        </script>
	</body>
</html>
