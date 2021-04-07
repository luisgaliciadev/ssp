<?php
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	$ID_ROL = $_SESSION[$SiglasSistema."ID_ROL"];
	
	$ID_MODULO=$_POST['vID_MODULO'];	
	$vNB_MODULO=$_POST["vNB_MODULO"];
	
	$Nivel="";
?>
<!DOCTYPE html>
<html>
	<head>       
        <link rel="stylesheet" type="text/css" href="<?php echo $Nivel;?>Includes/Plugins/css_tree/_styles.css" media="screen">
    
    <script>
		var CadMenusActivados="";
            
		$(document).ready(function(e) 
		{
			window.parent.Cargando(0);
		});
		
		function AsigDesaModulo(ID_MODULO, ID_ROL, FG_SUB_MODULO, CHECK)
		{
			ID_MODULO="ID_MODULO="+ID_MODULO;
			ID_ROLN="&ID_ROL="+ID_ROL;
			FG_SUB_MODULO="&FG_SUB_MODULO="+FG_SUB_MODULO;
			CHECK="&CHECK="+CHECK;
			
			PARAMETROS=ID_MODULO+ID_ROLN+FG_SUB_MODULO+CHECK;
			
			$.ajax(
			{
				url: 'Sistema/Seguridad/PermisologiasModulos/AsigDesaModulo.php',
				data: PARAMETROS,
				type: 'post',
				beforeSend: function() 
				{			
					window.parent.Cargando(1);
				},
				success: function(Resultado)
				{
					window.parent.Cargando(0);
					
					if(window.parent.ValidarConexionError(Resultado)==1)
					{
						RecargarMenu(ID_ROL);
								
						//window.parent.ConstruirMenu();
						
						//window.parent.ActivarMenu('<?php echo $ID_MODULO;?>');
					}
				}
			});
		}
		
		function RecargarMenu(ID_ROL)
		{
			if(ID_ROL!=0)
			{
				ID_ROL="ID_ROL="+ID_ROL;
				vCadMenusActivados="&CadMenusActivados="+CadMenusActivados;
				
				PARAMETROS=ID_ROL+vCadMenusActivados;
				
				$.ajax(
				{
					url: 'Sistema/Seguridad/PermisologiasModulos/RecargarMenu.php',
					data: PARAMETROS,
					type: 'GET',
					beforeSend: function() 
					{			
						window.parent.Cargando(1);
					},
					success: function(Resultado)
					{
						//alert(data);
						window.parent.Cargando(0);
						
						if(window.parent.ValidarConexionError(Resultado)==1)
						{
							var Arreglo=jQuery.parseJSON(Resultado);
							
							var Menu=Arreglo['Menu'];	
							
							$("#Menu").html(Menu);
								
							//window.parent.ConstruirMenu();
							
							//window.parent.ActivarMenu('<?php echo $ID_MODULO;?>');
						}
					}
				});
			}
			else
			{
				$("#Menu").html("");
			}
		}
			
		function CKNivel(ID_MODULO)
		{					
			if($("#"+ID_MODULO).is(':checked'))
			{
				Pos = CadMenusActivados.indexOf(ID_MODULO);
				
				if(Pos<0)
					CadMenusActivados+=ID_MODULO+";";
			}
			else
			{
				Cant = ID_MODULO.length;
				CantCad = CadMenusActivados.length;
				
				Pos = CadMenusActivados.indexOf(ID_MODULO);
				
				A = CadMenusActivados.substring(0, Pos);
				
				B = CadMenusActivados.substring(Pos+Cant+1, CantCad);
				
				CadMenusActivados=A+B;
			}
		}
	</script>    
	<style>
        .tree
        {
            margin-top:15px; 
            margin-left:15px;
        }
    </style>
</head>
<body>  
    <input type="hidden" id="ID_ROL" value="<?php echo $ID_ROL;?>">
    
    <div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-10">
			<h2><?php echo $vNB_MODULO;?></h2>
			<?php echo construirBreadcrumbs(substr($_POST["vID_MODULO"], 6, strlen($_POST["vID_MODULO"])));?>
		</div>
	</div>  
	
	<div class="wrapper wrapper-content animated fadeInRight col-md-4 col-md-offset-4">
		<div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
					<div class="ibox-content">
                        <form id="vForm">
                            <label for="ID_ROL">Rol:</label>
                            <select id="ID_ROL" class="form-control" onChange="CadMenusActivados=''; RecargarMenu(this.value);">
                                <option value='0'>SELECCIONE...</option>
<?php
                                $vSQL="SELECT * FROM TB_ADMIN_USU_ROL WHERE FG_ACTIVO=1 ORDER BY NB_ROL ASC";
                                
                                $ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
                                
                                $CONEXION=$ResultadoEjecutar["CONEXION"];						
                                $ERROR=$ResultadoEjecutar["ERROR"];
                                $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
                                $result=$ResultadoEjecutar["RESULTADO"];
                                
                                if($CONEXION=="SI" and $ERROR=="NO")
                                {		
                                    while ($registro=odbc_fetch_array($result))
                                    {			
                                        $ID_ROL=$registro["ID_ROL"];
                                        $NB_ROL=utf8_encode($registro["NB_ROL"]);
                                        
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
                        </form>
                        <ol id="Menu" class="tree Arbol" style="width:390px; margin-bottom:15px; border:0px solid #000;"></ol>
                    </div>
                </div>
            </div>
		</div>
	</div>
</body>
</html>