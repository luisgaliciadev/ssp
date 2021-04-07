<?php
	$Nivel="../../../";
	
	include($Nivel."includes/PHP/funciones.php");
	
	session_start();
	
	$ID_BL=$_GET['ID_BL'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta charset="utf-8">
</head>
<body>
<input id="ID_BL" name="ID_BL" type="hidden" value="<?php echo $ID_BL;?>"/>
	<form id="vForm" class="">
    	<div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Numero del Contenedor:</label>
                    <input type="text" id="COD_CONTE" style="text-transform:none; width:85%; float:left; margin-right:5px;margin-bottom:5px;" class="form-control" required onkeyup="TeclearBuscarContenedor(event)"/>
                    <button type="button" class="btn btn-primary fa fa-floppy-o" style="width:10%; height: 33px; float:left;" title="Guardar" onclick="BuscarContenedor()" id="btnbCOD_CONTE"></button>
                    <button type="button" class="btn btn-danger fa fa-ban" style="width:10%; height: 33px; float:left; display:none;" title="Cancelar" onclick="EliminarContenedor()" id="btneCOD_CONTE"></button>
                </div>
                <div class="form-group">
                    <label>Almacen/Patio:</label>
                    <input type="text" id="ALMACEN" style="text-transform:none; float:left; margin-bottom:5px;" class="form-control" required disabled="disabled"/>
                    <input id="COD_ALMA" name="COD_ALMA" type="hidden"/>
                </div>
                <div class="form-group">
                    <label>Cedula del Chofer:</label>
                    <input type="text" id="CEDULA_COND" style="text-transform:none; width:85%; float:left; margin-right:5px;margin-bottom:5px;" class="form-control" required onkeyup="TeclearBuscarConductor(event)"/>
                    <button type="button" class="btn btn-primary fa fa-floppy-o" style="width:10%; height: 33px; float:left;" title="Guardar" onclick="BuscarConductor()" id="btnbCEDULA_COND"></button>
                    <button type="button" class="btn btn-danger fa fa-ban" style="width:10%; height: 33px; float:left; display:none;" title="Cancelar" onclick="EliminarConductor()" id="btneCEDULA_COND"></button>
                </div>
                <div class="form-group">
                    <label>Nombre del Chofer:</label>
                    <input type="text" id="NOMBRE" style="text-transform:none; float:left; margin-bottom:5px;" class="form-control" required disabled="disabled"/>
                </div>
                <div class="form-group">
                    <label>Fecha de vigencia de licencia de conducir:</label>
                    <input type="text" id="F_VENC_LIC" style="text-transform:none; float:left; margin-bottom:5px;" class="form-control" required disabled="disabled"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> Placa del Chuto:</label>
                    <input type="text" id="PLACA_VEHICULO" style="text-transform:none; width:85%; float:left; margin-right:5px;" class="form-control" required onkeyup="TeclearBuscarChuto(event)"/>
                    <button type="button" class="btn btn-primary fa fa-floppy-o" style="width:10%; height: 33px; float:left;" title="Guardar" onclick="BuscarChuto()" id="btnbPLACA_VEHICULO"></button>
                    <button type="button" class="btn btn-danger fa fa-ban" style="width:10%; height: 33px; float:left; display:none;" title="Cancelar" onclick="EliminarChuto()" id="btnePLACA_VEHICULO"></button>
                </div>
                <div class="form-group">
                    <label>Fecha de vigencia de la Poliza RCV:</label>
                    <input type="text" id="F_VIG_POLIZA" style="text-transform:none; float:left; margin-bottom:5px;" class="form-control" required disabled="disabled"/>
                </div>
                <div class="form-group">
                    <label>¿El remolque pertenece al vehiculo?:</label>
                    <input type="checkbox" id="CHOTO_REMOLQUE" onclick="RemolqueChuto();"/>
                </div>
                <div class="form-group">
                    <label> Placa del Remolque:</label>
                    <input type="text" id="PLACA_REMOLQUE" style="text-transform:none; width:85%; float:left; margin-right:5px;margin-bottom:5px;" class="form-control" required onkeyup="TeclearBuscarRemolque(event)"/>
                    <button type="button" class="btn btn-primary fa fa-floppy-o" style="width:10%; height: 33px; float:left;" title="Guardar" onclick="BuscarRemolque()" id="btnbPLACA_REMOLQUE"></button>
                    <button type="button" class="btn btn-danger fa fa-ban" style="width:10%; height: 33px; float:left; display:none;" title="Cancelar" onclick="EliminarRemolque()" id="btnePLACA_REMOLQUE"></button>
                    <button type="button" class="btn btn-danger fa fa-ban" style="width:10%; height: 33px; float:left; display:none;" title="Cancelar" onclick="$('#CHOTO_REMOLQUE').click();" id="btnePLACA_REMOLQUE2"></button>
                </div>
                <div class="form-group">
                    <label>Destino: &nbsp; &nbsp; &nbsp; &nbsp;</label>
                    <input type="text" id="DESTINO" style="text-transform:none; width:85%; float:left; margin-right:5px;margin-bottom:5px;" class="form-control" required />
                    <button type="button" class="btn btn-primary fa fa-floppy-o" style="width:10%; height: 33px; float:left;" title="Guardar" onclick="GuardarDestino()" id="btnbDESTINO"></button>
                    <button type="button" class="btn btn-danger fa fa-ban" style="width:10%; height: 33px; float:left; display:none;" title="Cancelar" onclick="EliminarDestino()" id="btneDESTINO"></button>
                </div>
            </div>
        </div>
        <div class="row">       
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btbCancelar">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
	</form>
  <footer></footer>
    <script>
        $(document).ready(function(e) 
        {								
            $('#CEDULA_COND').keydown(function (e)
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
                    //case code == 86 || code == 69 || code == 71 || code == 74 || code == 80:
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
            
            $("#COD_CONTE").focus();
            
            $('#vForm').on('submit', function(e) 
            {
                e.preventDefault();
                
                ValidarBtbRegistrar();
            });
        });
			
		function RemolqueChuto()
		{
			if($("#CHOTO_REMOLQUE").is(':checked'))
			{
				$("#PLACA_REMOLQUE").attr("disabled",true);
				$("#btnbPLACA_REMOLQUE").hide();
				$("#btnePLACA_REMOLQUE2").show();
				
				$("#DESTINO").focus();
				
				$("#PLACA_REMOLQUE").val("N/A");
			} 
			else 
			{
				EliminarRemolque();
				$("#btnePLACA_REMOLQUE2").hide();
			}
		}
        
        function TeclearBuscarContenedor(e)
        {
            var key=e.keyCode || e.which;
            
            if (key==13)
            {
                BuscarConductor();
            }
            
            e.preventDefault();	
        }
        
        function BuscarContenedor()
        {
            var	COD_CONTE=$("#COD_CONTE").val();
            
            var	ID_BL=$("#ID_BL").val();
            
            if(!COD_CONTE.trim())
            {
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar el Numero del Contenedor.");
                $("#COD_CONTE").focus();
                return;
            }
            
            Parametros="COD_CONTE="+COD_CONTE+"&ID_BL="+ID_BL;
            
            $.ajax(
            {
                type: "POST",
                dataType:"html",
                url: "Sistema/OrdenCarga/Contenedor/BuscarContenedor.PHP",			
                data: Parametros,	
                beforeSend: function() 
                {
                    window.parent.parent.Cargando(1);
                },												
                cache: false,			
                success: function(Resultado)
                {
                    //alert(Resultado);
                    
                    window.parent.parent.Cargando(0);
					
					if(window.parent.ValidarConexionError(Resultado)==1)
					{	
                    	var Arreglo=jQuery.parseJSON(Resultado);                    
                    
                        var Existe=Arreglo['Existe'];
                        
                        if(Existe==0)
                        {
                            window.parent.MostrarMensaje("Rojo", "Numero del Contenedor no existe!.");
                            
                            $("#COD_CONTE").attr("disabled",false);
                            $("#btneCOD_CONTE").hide();
                            $("#btnbCOD_CONTE").show();															
                        }
                        else
                        {
                            var FG_ORDEN=Arreglo['FG_ORDEN'];
                            
                            if(FG_ORDEN==0)
                            {
                                var COD_ALMA=Arreglo['COD_ALMA'];	
                                var ALMACEN=Arreglo['ALMACEN'];		
                                            
                                $("#COD_CONTE").attr("disabled",true);
                                $("#btnbCOD_CONTE").hide();
                                $("#btneCOD_CONTE").show();
                                $("#CEDULA_COND").focus();
                                
                                $("#COD_ALMA").val(COD_ALMA);
                                $("#ALMACEN").val(ALMACEN);
                                
                                window.parent.MostrarMensaje("Azul", "Numero del Contenedor encontrado.");	
                            }
                            else
                            {
                                $("#COD_CONTE").attr("disabled",false);
                                $("#btneCOD_CONTE").hide();
                                $("#btnbCOD_CONTE").show();
                                
                                window.parent.MostrarMensaje("Rojo", "Disculpe, El Numero del Contenedor ya posee una Orden de Carga Asociada.");					
                            }
                        }
                    }
                }						
            });
        }
        
        function EliminarContenedor()
        {
            $("#COD_CONTE").attr("disabled",false);
            $("#COD_CONTE").val("");
            $("#COD_CONTE").focus();
            
            $("#btneCOD_CONTE").hide();
            $("#btnbCOD_CONTE").show();		
        }
        
        function TeclearBuscarConductor(e)
        {
            var key=e.keyCode || e.which;
            
            if (key==13)
            {
                BuscarConductor();
            }
            
            e.preventDefault();	
        }
        
        function BuscarConductor()
        {
            var	CEDULA_COND=$("#CEDULA_COND").val();
            
            if(!CEDULA_COND.trim())
            {
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar la Cedula del Chofer.");
                $("#CEDULA_COND").focus();
                return;
            }
            
            Parametros="CEDULA_COND="+CEDULA_COND;
            
            $.ajax(
            {
                type: "POST",
                dataType:"html",
                url: "Sistema/OrdenCarga/BuscarConductor.PHP",			
                data: Parametros,	
                beforeSend: function() 
                {
                    window.parent.parent.Cargando(1);
                },												
                cache: false,			
                success: function(Resultado)
                {
                    //alert(Resultado);
                    
                    window.parent.parent.Cargando(0);
                    
					if(window.parent.ValidarConexionError(Resultado)==1)
					{	
                    	var Arreglo=jQuery.parseJSON(Resultado);
						
                        var Existe=Arreglo['Existe'];
                        
                        if(Existe==0)
                        {
                            window.parent.MostrarMensaje("Rojo", "Disculpe, Cedula del Chofer no existe.");	
                            
                            $("#CEDULA_COND").attr("disabled",false);
                            $("#btneCEDULA_COND").hide();
                            $("#btnbCEDULA_COND").show();															
                        }
                        else
                        {
                            if(Existe==1)
                            {
                                $("#CEDULA_COND").attr("disabled",false);
                                $("#btneCEDULA_COND").hide();
                                $("#btnbCEDULA_COND").show();
                                
                                window.parent.MostrarMensaje("Rojo", "Disculpe, Cedula del Chofer ya posee una Orden de Carga Asociada.");					
                            }
                            else
                            {
                                var NOMBRE=Arreglo['NOMBRE'];
                                var F_VENC_LIC=Arreglo['F_VENC_LIC'];
                                var VIGENCIA_LIC=Arreglo['VIGENCIA_LIC'];
                                
                                if(VIGENCIA_LIC==0)
                                {
                                    $("#CEDULA_COND").attr("disabled",false);
                                    $("#btneCEDULA_COND").hide();
                                    $("#btnbCEDULA_COND").show();
                                    
                                    $("#NOMBRE").val(NOMBRE);
                                    $("#F_VENC_LIC").val(F_VENC_LIC);
                                    
                                    window.parent.MostrarMensaje("Rojo", "Disculpe, el chofer posee la licencia vencida.");					
                                }
                                else
                                {									
                                    $("#CEDULA_COND").attr("disabled",true);
                                    $("#btnbCEDULA_COND").hide();
                                    $("#btneCEDULA_COND").show();
                                    $("#PLACA_VEHICULO").focus();
                                    
                                    $("#NOMBRE").val(NOMBRE);
                                    $("#F_VENC_LIC").val(F_VENC_LIC);
                                    
                                    window.parent.MostrarMensaje("Azul", "Chofer encontrado.");	
                                    
                                    //ValidarBtbRegistrar();	
                                }	
                            }
                        }
                    }
                }						
            });
        }
        
        function EliminarConductor()
        {
            $("#CEDULA_COND").attr("disabled",false);
            $("#CEDULA_COND").val("");
            $("#CEDULA_COND").focus();
            
            $("#btneCEDULA_COND").hide();
            $("#btnbCEDULA_COND").show();				
            
            $("#NOMBRE").val("");		
            $("#F_VENC_LIC").val("");
            
            //ValidarBtbRegistrar();
        }

        function TeclearBuscarChuto(e)
        {
            var key=e.keyCode || e.which;
            
            if (key==13)
            {
                BuscarChuto();
            }
            
            e.preventDefault();	
        }
        
        function BuscarChuto()
        {
            var	PLACA_VEHICULO=$("#PLACA_VEHICULO").val();
            
            if(!PLACA_VEHICULO.trim())
            {
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar la Placa del Chuto.");
                $("#PLACA_VEHICULO").focus();
                return;
            }
                        
            Parametros="PLACA_VEHICULO="+PLACA_VEHICULO+"&ID_TIPO_CARGA=1";
            
            $.ajax(
            {
                type: "POST",
                dataType:"html",
                url: "Sistema/OrdenCarga/BuscarChuto.PHP",			
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
                    	var Arreglo=jQuery.parseJSON(Resultado);
						
                        var Existe=Arreglo['Existe'];
                        
                        if(Existe==0)
                        {							
                            $("#PLACA_VEHICULO").attr("disabled",false);
                            $("#btnePLACA_VEHICULO").hide();
                            $("#btnbPLACA_VEHICULO").show();
                            
                            window.parent.MostrarMensaje("Rojo", "Disculpe, Placa del Chuto no se encuentra registrada.");									
                        }
                        else
                        {
                            if(Existe==1)
                            {
                                $("#PLACA_VEHICULO").attr("disabled",false);
                                $("#btnePLACA_VEHICULO").hide();
                                $("#btnbPLACA_VEHICULO").show();
                                
                                window.parent.MostrarMensaje("Rojo", "Disculpe, Placa del Chuto ya posee una Orden de Carga Asociada.");					
                            }
                            else
                            {
                                var F_VIG_POLIZA=Arreglo['F_VIG_POLIZA'];
                                var VIGENCIA_POLIZA=Arreglo['VIGENCIA_POLIZA'];
                                
                                if(VIGENCIA_POLIZA==0)
                                {
                                    $("#PLACA_VEHICULO").attr("disabled",false);
                                    $("#btnePLACA_VEHICULO").hide();
                                    $("#btnbPLACA_VEHICULO").show();
                                    
                                    $("#F_VIG_POLIZA").val(F_VIG_POLIZA);
                                    
                                    window.parent.MostrarMensaje("Rojo", "Disculpe, el chuto posee la Poliza vencida.");					
                                }
                                else
                                {									
                                    
                                    $("#PLACA_VEHICULO").attr("disabled",true);
                                    $("#btnbPLACA_VEHICULO").hide();
                                    $("#btnePLACA_VEHICULO").show();
                                    $("#PLACA_REMOLQUE").focus();
                                    
                                    $("#F_VIG_POLIZA").val(F_VIG_POLIZA);
                                    
                                    window.parent.MostrarMensaje("Azul", "Chuto encontrado.");	
                                    
                                    //ValidarBtbRegistrar();	
                                }
                            }
                        }
                    }
                }						
            });
        }
        
        function EliminarChuto()
        {
            $("#PLACA_VEHICULO").attr("disabled",false);
            $("#PLACA_VEHICULO").val("");
            $("#PLACA_VEHICULO").focus();
            
            $("#btnePLACA_VEHICULO").hide();
            $("#btnbPLACA_VEHICULO").show();
            
            $("#F_VIG_POLIZA").val("");
            //ValidarBtbRegistrar();
        }
        
        function TeclearBuscarRemolque(e)
        {
            var key=e.keyCode || e.which;
            
            if (key==13)
            {
                BuscarRemolque();
            }
            
            e.preventDefault();	
        }
        
        function BuscarRemolque()
        {
            var	PLACA_REMOLQUE=$("#PLACA_REMOLQUE").val();
            
            if(!PLACA_REMOLQUE.trim())
            {		
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar la Placa del Remolque.");	
                $("#PLACA_REMOLQUE").focus();
                return;
            }
                        
            Parametros="PLACA_REMOLQUE="+PLACA_REMOLQUE;
            
            $.ajax(
            {
                type: "POST",
                dataType:"html",
                url: "Sistema/OrdenCarga/BuscarRemolque.PHP",			
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
						var Arreglo=jQuery.parseJSON(Resultado);
					 
                        var Existe=Arreglo['Existe'];
                        
                        if(Existe==0)
                        {
                            $("#PLACA_REMOLQUE").attr("disabled",false);
                            $("#btnePLACA_REMOLQUE").hide();
                            $("#btnbPLACA_REMOLQUE").show();
                                
                            window.parent.MostrarMensaje("Rojo", "Disculpe, Placa del Remolque no se encuentra registrada.");
                        }
                        else
                        {
                            if(Existe==1)
                            {
                                $("#PLACA_REMOLQUE").attr("disabled",false);
                                $("#btnePLACA_REMOLQUE").hide();
                                $("#btnbPLACA_REMOLQUE").show();
                                
                                window.parent.MostrarMensaje("Rojo", "Disculpe, Placa del Remolque ya posee una Orden de Carga Asociada.");					
                            }
                            else
                            {
                                $("#PLACA_REMOLQUE").attr("disabled",true);
                                $("#btnbPLACA_REMOLQUE").hide();
                                $("#btnePLACA_REMOLQUE").show();
                                $("#DESTINO").focus();
                                
                                window.parent.MostrarMensaje("Azul", "Remolque encontrado.");
                                
                                //ValidarBtbRegistrar();
                            }
                        }
                    }
                }						
            });
        }
        
        function EliminarRemolque()
        {
            $("#PLACA_REMOLQUE").attr("disabled",false);
            $("#PLACA_REMOLQUE").val("");
            $("#PLACA_REMOLQUE").focus();
            
            $("#btnePLACA_REMOLQUE").hide();
            $("#btnbPLACA_REMOLQUE").show();
            
            //ValidarBtbRegistrar();
        }

        function Teclear(e)
        {
            var key=e.keyCode || e.which;
            
            if (key==13)
            {
                GuardarDestino();
            }
            
            e.preventDefault();	
        }
        
        function GuardarDestino()
        {
            var	DESTINO=$("#DESTINO").val();
            
            if(!DESTINO.trim())
            {
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar el Destino.");
                $("#DESTINO").focus();
                return;
            }
            
            $("#DESTINO").attr("disabled",true);
            
            $("#btnbDESTINO").hide();
            $("#btneDESTINO").show();
            
            //ValidarBtbRegistrar();
        }
        
        function EliminarDestino()
        {
            $("#DESTINO").attr("disabled",false);
            $("#DESTINO").val("");
            $("#DESTINO").focus();
            
            $("#btnbDESTINO").show();
            $("#btneDESTINO").hide();
            
            //ValidarBtbRegistrar();
        }
        
        function ValidarBtbRegistrar()
        {
            var	ID_BL=$("#ID_BL").val();
            var	COD_ALMA=$("#COD_ALMA").val();
            
            var	COD_CONTE=$("#COD_CONTE").val();
            var	CEDULA_COND=$("#CEDULA_COND").val();
            var	CEDULA_COND=$("#CEDULA_COND").val();
            var	PLACA_VEHICULO=$("#PLACA_VEHICULO").val();
            var	PLACA_REMOLQUE=$("#PLACA_REMOLQUE").val();
            var	DESTINO=$("#DESTINO").val();
            
            if(!(COD_CONTE.trim() && $("#COD_CONTE").is(':disabled')))
            {
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar y guardar el Numero del Contenedor.");
                $("#COD_CONTE").focus();
                return;
            }
            
            if(!(CEDULA_COND.trim() && $("#CEDULA_COND").is(':disabled')))
            {
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar y guardar la Cedula del Chofer.");
                $("#CEDULA_COND").focus();
                return;
            }
            
            if(!(PLACA_VEHICULO.trim() && $("#PLACA_VEHICULO").is(':disabled')))
            {
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar y guardar la Placa del Chuto.");
                $("#PLACA_VEHICULO").focus();
                return;
            }
            
            if(!(PLACA_REMOLQUE.trim() && $("#PLACA_REMOLQUE").is(':disabled')))
            {
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar y guardar la Placa del Remolque.");
                $("#PLACA_REMOLQUE").focus();
                return;
            }
            
            if(!(DESTINO.trim() && $("#DESTINO").is(':disabled')))
            {
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar y guardar el Destino.");
                $("#DESTINO").focus();
                return;
            }
            
            Registrar();
        }
        
        function Registrar()
        {
            var	ID_BL=$("#ID_BL").val().trim();
            var	COD_ALMA=$("#COD_ALMA").val().trim();		
            var	COD_CONTE=$("#COD_CONTE").val();		
            var	CEDULA_COND=$("#CEDULA_COND").val().trim();
            var	PLACA_VEHICULO=$("#PLACA_VEHICULO").val().trim();
            var	PLACA_REMOLQUE=$("#PLACA_REMOLQUE").val().trim();
            var	DESTINO=$("#DESTINO").val().trim();
            
            if(!COD_CONTE.trim())
            {
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar el Numero del Contenedor.");
                $("#COD_CONTE").focus();
                return;
            }
            
            if(!ID_BL.trim())
            {
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe seleccionar el Buque.");
                $("#ID_BL").focus();
                return;
            }
            
            if(!(CEDULA_COND.trim() && $("#CEDULA_COND").is(':disabled')))
            {
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar y guardar la Cedula del Chofer.");
                $("#CEDULA_COND").focus();
                return;
            }
            
            if(!(PLACA_VEHICULO.trim() && $("#PLACA_VEHICULO").is(':disabled')))
            {
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar y guardar la Placa del Chuto.");
                $("#PLACA_VEHICULO").focus();
                return;
            }
            
            if(!(PLACA_REMOLQUE.trim() && $("#PLACA_REMOLQUE").is(':disabled')))
            {
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar y guardar la Placa del Remolque.");
                $("#PLACA_REMOLQUE").focus();
                return;
            }
            
            if(!DESTINO.trim())
            {
                window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar y guardar el Destino.");
                $("#DESTINO").focus();
                return;
            }
                
            Parametros="ID_BL="+ID_BL+"&COD_ALMA="+COD_ALMA+"&COD_CONTE="+COD_CONTE+"&CEDULA_COND="+CEDULA_COND+"&PLACA_VEHICULO="+PLACA_VEHICULO+"&PLACA_REMOLQUE="+PLACA_REMOLQUE+"&DESTINO="+DESTINO;
                
            $.ajax(
            {
                type: "POST",
                dataType:"html",
                url: "Sistema/OrdenCarga/Contenedor/GuardarOrdenCarga.PHP",			
                data: Parametros,	
                beforeSend: function() 
                {
                    window.parent.parent.Cargando(1);
                },												
                cache: false,			
                success: function(Resultado)
				{
					if(window.parent.ValidarConexionError(Resultado)==1)
					{
						window.parent.MostrarMensaje("Verde", "Orden de Carga Registrada Exitosamente.");
						
						$("#btbCancelar").click();
					
						var Arreglo=jQuery.parseJSON(Resultado);						
					
						var ID_ORDEN_PESAJE=Arreglo['ID_ORDEN_PESAJE'];
						
						//window.parent.ReporteOrdenCarga(ID_ORDEN_PESAJE);
						
						window.parent.$("#vModalTitulo").html("");
						window.parent.$("#vModalContenido").html("");
								
						Parametros="ID_ORDEN_PESAJE="+ID_ORDEN_PESAJE;
						
						$.ajax(
						{
							type: "get",
							url: "Sistema/OrdenCarga/ReporteOrdenCarga.php",
							data: Parametros,
							cache: false,
							beforeSend: function() 
							{		
							},
							success: function(Resultado)
							{									
								if(window.parent.parent.ValidarConexionError(Resultado)==1)
								{		
									window.parent.$("#vModalTitulo").html('Orden de Carga Nro: '+ID_ORDEN_PESAJE);
									
									window.parent.$("#vModalContenido").html('<iframe height="500" width="100%" frameborder="0" style="border:#999 solid 0px; margin-left:0px; margin-top:0px; border-radius:0px;background:#FFF;" scrolling="auto" src="Sistema/OrdenCarga/ReporteOrdenCargaConsulta.php?ID_ORDEN_PESAJE='+ID_ORDEN_PESAJE+'" name="iframe" id="iframe"></iframe>');
																
									window.parent.$("#vModal").modal();
						
									window.parent.FiltroConsulta(1);
								}
							}
						});	
					}
				}
            });
        }
    </script>
  
</body>
</html>