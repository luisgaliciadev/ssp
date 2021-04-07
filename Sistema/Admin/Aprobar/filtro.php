<!doctype html>
<?php 
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	ValidarSesion($Nivel);
	
	$vNB_MODULO=$_POST["vNB_MODULO"];
	
	$Nivel="";	

	$Rif = $_SESSION[$SiglasSistema.'RIF'];
?>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>

       
</head>

<body>
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-10">
			<h2><?php echo $vNB_MODULO;?></h2>
			<ol class="breadcrumb">
				<li>
					<a href="./">Inicio</a>
				</li>
				<li>
					Servicios Generales
				</li>
				<li class="active">
					<strong><?php echo $vNB_MODULO;?></strong>
				</li>
			</ol>
		</div>
	</div>    
	
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Aprobar Solicitud</h5>
					</div>
					<div class="ibox-content">
					<form role="form" id="form_sm" >
						
						<div class="form-group col-md-12" >
							<label> Numero de Solicitd de Muelle</label>
							<select class="form-control" id="num_sm"  required>
								<option value="">Seleccione...</option>
								<?php 
									$vSQL="exec [web].[SP_LISTADO_SM_VENTA_APROB]";
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
											$DES_SM=utf8_encode(odbc_result($result,'DES_SM'));
											
											echo "<option value=".$ID.">$DES_SM</option>";
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
						
						<div id="info" style="float:right">
						</div>
                                  
						<div class="row">
								
						</div>	

						<div class="row">
							<div class="form-group col-md-12" >	
								<div  id="consulta"></div>
							</div>
							<div class="form-group col-md-12 boton" >
								<button type="BUTTON" class="btn btn-primary" id="gen_pre">Aprobar Solicitud</button>			
							</div>	
						</div>	
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>


<script>
$( document ).ready(function() {
	window.parent.parent.Cargando(0);
	$(".boton").hide();
	
	

	
	$("#num_sm" ).change(function() {
		var num_sm = $("#num_sm").val();
		if (num_sm.length == 0){
			$(".boton").hide();
			$("#consulta").html('');
		}else{
			$("#consulta").load('Sistema/Admin/Aprobar/FormTabla.php?num_sm='+num_sm);
			$(".boton").show();
		}
		
		
	});

	$("#gen_pre" ).click(function() {
        
		var num_sm = $("#num_sm").val();
		Parametros="num_sm="+num_sm;
        
        
        if (num_sm.length == 0){
            alert("Disculpe, debe seleccionar una Solicitud de muelle");
            return false

        }

        $.ajax(
        {
            type: "POST",
            dataType:"html",
            url: "Sistema/Admin/Aprobar/ScriptInsertar.php",			
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
                        MostrarMensaje("Rojo", "Error de sentencia SQL, contacte al personal del departamento de sistemas.");
                        
                    }
                    else
                    {
                        
                        var Id = Arreglo['ID'];
                        
                        if(Id==0)
                        {
                            MostrarMensaje("Rojo", Arreglo['MENSAJE']);
                        }
                        else
                        {
                            MostrarMensaje("Verde", Arreglo['MENSAJE']);	
							$(".boton").hide();									
                            AbrirModulo("MenDes2041", "Aprobar Solicitud", "Sistema/Admin/Aprobar/filtro.php");

                        }
                    }
                }
                    
                
            }						
        });
		
		
		
		
	});

});
    </script>
</html>