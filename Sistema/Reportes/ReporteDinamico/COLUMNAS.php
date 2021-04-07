<?php
	$Nivel="../../../";	
	include($Nivel."includes/funciones.php");
	
	$conector=Conectar();
	
	session_start();
	
	$ID_ROL = $_SESSION[$SiglasSistema."ID_ROL"];
	$ID_USUARIO=$_SESSION[$SiglasSistema.'ID_USUARIO'];
	
	$IdVentana=$_GET['IdVentana'];
	$IdVentanaP=$_GET['IdVentanaP'];
		
	$ID_REP_DIN=$_GET['ID_REP_DIN'];
	$Columnas=$_GET['Columnas'];
	$CamposColumnas=$_GET['CamposColumnas'];
	$ID_REP_DIN_CAMPOS=$_GET['ID_REP_DIN_CAMPOS'];
	
	$Cad="";
	$CadSeleccionados="";
	
	if($Columnas)
	{
		$ArregloColumnas=explode(",",$Columnas);
		$CantidadColumnas=count($ArregloColumnas);
		
		$ArregloCamposColumnas=explode(",",$CamposColumnas);
		$CantidadCamposColumnas=count($ArregloCamposColumnas);
		
		$ArregloID_REP_DIN_CAMPOS=explode(",",$ID_REP_DIN_CAMPOS);
		$CantidadID_REP_DIN_CAMPOS=count($ArregloID_REP_DIN_CAMPOS);
		
		for($Ite=0; $Ite<$CantidadID_REP_DIN_CAMPOS; $Ite++)
		{
			$Cad.=" AND ID_REP_DIN_CAMPOS<>".$ArregloID_REP_DIN_CAMPOS[$Ite]." ";	
			
			$CadSeleccionados.='<li value="'.$ArregloID_REP_DIN_CAMPOS[$Ite].'" class="ui-state-default" style="">'.$ArregloColumnas[$Ite].'</li>';
		}
	}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>CamposColumnas</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php echo includes($Nivel);?>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <style>
            #sortable1, #sortable2 
            {
                border: 1px solid #eee;
                width: 220px;
                min-height: 20px;
                list-style-type: none;
                margin: 0;
                padding: 5px 0 0 0;
                float: left;
                margin-right: 10px;
                min-height:333px;
            }
            
            #sortable1 li, #sortable2 li 
            {
                margin: 0 5px 5px 5px;
                padding: 5px;
                font-size: 1.2em;
                width: auto;
                cursor:pointer;
            }
        </style>
        
        <script>
            $( function() 
            {
                $( "#sortable1, #sortable2" ).sortable(
                {
                    connectWith: ".connectedSortable"
                }).disableSelection();
            });
          
            function Aceptar()
            {
                var Ite=0;
                						
				parent.<?php echo $IdVentanaP;?>.ArrayColumnasID_REP_DIN_CAMPOS=[];
				parent.<?php echo $IdVentanaP;?>.ArrayColumnasNB_CAMPO=[];
				parent.<?php echo $IdVentanaP;?>.ArrayColumnasNB_CAMPO_SQL=[];
				parent.<?php echo $IdVentanaP;?>.ArrayColumnasTIPO_CAMPO_HTML=[];
				parent.<?php echo $IdVentanaP;?>.ArrayColumnasSELECT_FLAG=[];
                
                $('#sortable2 li').each(function(indice, elemento) 
                {
                    Ite++;
					
					$.ajax(
					{
						type: "GET",
						url: "FILTROS_CONSULTA.php",
						data: "ID_REP_DIN_CAMPOS="+$(elemento).attr("value"),
						async: false,
						beforeSend: function() 
						{			
							window.parent.$("#Loading").css("display","");
						},
						success: function(html)
						{							
							window.parent.$("#Loading").css("display","none");	
					
							var Arreglo=jQuery.parseJSON(html);
							
							parent.<?php echo $IdVentanaP;?>.ArrayColumnasID_REP_DIN_CAMPOS[Ite-1]=Arreglo['ID_REP_DIN_CAMPOS'];	
							parent.<?php echo $IdVentanaP;?>.ArrayColumnasNB_CAMPO[Ite-1]=Arreglo['NB_CAMPO'];	
							parent.<?php echo $IdVentanaP;?>.ArrayColumnasNB_CAMPO_SQL[Ite-1]=Arreglo['NB_CAMPO_SQL'];				
							parent.<?php echo $IdVentanaP;?>.ArrayColumnasTIPO_CAMPO_HTML[Ite-1]=Arreglo['TIPO_CAMPO_HTML'];		
							parent.<?php echo $IdVentanaP;?>.ArrayColumnasSELECT_FLAG[Ite-1]=Arreglo['SELECT_FLAG'];		
						}
					});
                });				
				
				parent.<?php echo $IdVentanaP;?>.AgregarColumnasD();
				
				parent.CerrarVentana('<?php echo $IdVentana;?>');
            }
        </script>
    </head>
    <body>
        <div style="margin:auto; width:500px; height:50px; border:#000000 solid 0px; padding:10px;">
            <div style="margin-bottom:10px;">Arrastre los campos a seleccionar y coloquelos en el orden que desea que se visualicen en el reporte.</div>
            <div style="width:220px; float:left;">
                <div style="width:100px; ">Campos:</div>
            </div>
            <div style="width:220px; float:right; margin-left:10px;">
                <div>Seleccionados:</div>
            </div>
        </div>
        <div style="margin:auto; width:500px; height:350px; border: #D5D3D3 solid 1px; padding:10px; overflow-y:scroll; overflow-x:hidden; ">
<?php 
	$vSQL="SELECT 
				*
			FROM            
				TB_REP_DIN_CAMPOS
			WHERE        
				(FG_ACTIVO = 1) AND 
				(ID_REP_DIN = $ID_REP_DIN) $Cad
			ORDER BY 
				ORDEN";
	
	if($result=$conector->Ejecutar($vSQL))
	{
?> 
		<div style="width:220px; float:left;">
			<ul id="sortable1" class="connectedSortable">
<?php 
				while(odbc_fetch_row($result))
				{
					$ID_REP_DIN_CAMPOS=odbc_result($result,'ID_REP_DIN_CAMPOS');
					$NB_CAMPO=odbc_result($result,'NB_CAMPO');
					$NB_CAMPO_SQL=odbc_result($result,'NB_CAMPO_SQL');
?> 
            		<li class="ui-state-default" value="<?php echo $ID_REP_DIN_CAMPOS;?>"><?php echo $NB_CAMPO;?></li>
<?php 
				}
?>
			</ul>
        </div>
<?php 
	}
	else
	{
		echo $vSQL;
	}
?>
 
            <div style="width:220px; float:right; margin-left:10px;">
                <ul id="sortable2" class="connectedSortable"><?php echo $CadSeleccionados;?></ul>
            </div>
        </div>
        <div style="margin:auto; width:150px; height:50px; border:#000000 solid 0px; margin-top:10px;">
            <input name="agregar" type="button" id="agregar" value="Agregar" class="button small btnSistema" onClick="Aceptar();"/>
            <input name="cancelar" type="button" id="cancelar" value="Cancelar" onClick="javascript:parent.CerrarVentana('<?php echo $IdVentana;?>');" class="button small btnSistema"/>
        </div>
    </body>
</html>