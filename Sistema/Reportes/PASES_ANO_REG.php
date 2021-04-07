<?php
	
	$Nivel="../../";	
	include($Nivel."includes/funciones.php");
	
	$conector=Conectar();

	//$id_localidad=$_GET["puerto"];
	//$Abogado=$_GET["Abogado"];
	//$ano=$_GET["ANO_REGISTRO"];
	//$mes=$_GET["mes"];
	
	/*$id_localidad=2;
	
	$ano=2014;
	$mes=3;*/
	
	
	/*//$vSQL="SELECT  [NB_LOCALIDAD] FROM [dbo].[TB_LOCALIDAD] WHERE [ID_LOCALIDAD]=$id_localidad";
	
	if($result=$conector->Ejecutar($vSQL))
	{
		while(odbc_fetch_row($result))
		{ 
								
			$nombre=odbc_result($result,'NB_LOCALIDAD'); 
				
		}
	}
*/

function fentrada2($cambio){ 
        $uno=substr($cambio, 0, 4); 
        $dos=substr($cambio, 5, 2); 
        $tres=substr($cambio, 8, 2); 
        $resul = ($tres."/".$dos."/".$uno); 
        return $resul; 
    }
	


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LISTADO DE EXPEDIENTES POR PUERTO  </title>
</head>
<style>
    
	<style>
        .Estilo1 {font-weight: bold; color:#000000 }
		
		.tabla
		{
			font-size:12px;
			font-family:Arial, Helvetica, sans-serif;
			
		}
		
		th
		{
			background-color:#999;
		}
		
		.color
		{
			background-color:#E6E6E6;
		}
		.color2
		{
			background-color:#FF9;
		}
		.color3
		{
			background-color:#3CC;
		}
    </style>
<body onload="window.parent.$('#Loading').css('display','none');">
<script type="text/javascript">
    function ImpDiv(Id)
    {
        var div=document.getElementById(Id);
        
        var VenImp=window.open(' ','popimpr');
        
        VenImp.document.open();
        //VenImp.document.write("holaaa");
        VenImp.document.write(div.innerHTML);
        VenImp.document.close();
        VenImp.print();
        VenImp.close();
    }
</script>
<input type="button" id="Imprimir" value="Imprimir" onclick="ImpDiv('imprimir');" class="button small btnSistema"/>
<div id="imprimir">
<table width="1300" border="0" align="center" class="tabla">
  <tr>
    <td align="center" valign="middle">
      <img src="../../imagen/header.png" width="885" height="52" />
    </td>
  </tr>
   
  <tr>
    <td align="center" valign="middle"><h1>VEH&Iacute;CULOS REGISTRADOS POR A&Ntilde;O</h1>
    </td>
    
  </tr>
  <tr>
   	<td align="center" valign="middle" >
        <h2>
        A&Ntilde;O: 2014
  
   </h2>
   </td>
  </tr> 

 
</table>
<p></p>
<table width="1300" border="1" align="center" style="border-collapse:collapse;" class="tabla">
<tr style="background-color:#999">
					<td width="20" >
							<div align="center" ><b>
								<label style="text-align:center"  class="Estilo1">NRO </label>
							</b></div>
						</td>
                        <td width="150" >
							<div align="left"><b>
								<label style="text-align:center"  class="Estilo1">NOMBRE EMPRESA </label>
							</b></div>
						</td>
    					<td width="30" >
							<div align="center"><b>
								<label style="text-align:center"  class="Estilo1">CATEGORIAS</label>
							</b></div>
						</td>
					   
						<td width="30" >
							<div align="center"><b>
								<label style="text-align:center"  class="Estilo1"> CANTIDAD REG </label>
							</b></div>
						</td>
						<td width="30" >
							<div align="center"><b>
								<label style="text-align:center"  class="Estilo1">LOCALIDAD</label>
							</b></div>
						</td>
						
					</tr>
<?php
	$NRO=0;
	
  	$vSQL	="SELECT        TB_TIPO_VEHICULO.NB_TVEHICULO, EMPRESA.RAZON_SOCIAL, TB_LOCALIDAD.NB_LOCALIDAD, COUNT(TB_TIPO_VEHICULO.NB_TVEHICULO) 
                         AS CANT_REGISTRADO, dbo.CategoriasEmpresa(EMPRE_VEHICULO.ID_EMPRESA) AS CATEGORIAS, TB_TIPO_VEHICULO.ID_TVEHICULO, 
                         TB_LOCALIDAD.ID_LOCALIDAD
FROM            EMPRE_VEHICULO INNER JOIN
                         TB_TIPO_VEHICULO ON EMPRE_VEHICULO.ID_TVEHICULO = TB_TIPO_VEHICULO.ID_TVEHICULO INNER JOIN
                         EMPRESA ON EMPRE_VEHICULO.ID_EMPRESA = EMPRESA.ID_EMPRESA INNER JOIN
                         TB_LOCALIDAD ON EMPRE_VEHICULO.ID_LOCALIDAD = TB_LOCALIDAD.ID_LOCALIDAD
GROUP BY TB_LOCALIDAD.NB_LOCALIDAD, EMPRESA.RAZON_SOCIAL, TB_TIPO_VEHICULO.ID_TVEHICULO, TB_TIPO_VEHICULO.NB_TVEHICULO, EMPRESA.ID_EMPRESA, 
                         EMPRE_VEHICULO.ID_EMPRESA, TB_LOCALIDAD.ID_LOCALIDAD
ORDER BY TB_LOCALIDAD.NB_LOCALIDAD, TB_TIPO_VEHICULO.ID_TVEHICULO";	
	$result=$conector->Ejecutar($vSQL);
	$con_total	=0;
	while (odbc_fetch_row($result))  
		{ 
			$cont_pbl=$cont_pbl + odbc_result($result,"CANT_REGISTRADO");
			$id_localidad=odbc_result($result,"ID_LOCALIDAD");
			$NRO=$NRO+1;
			echo "<tr $clase>";
			echo " 				
							<td style=\"text-align:center\"><div align=\"center\">".$NRO."</div></td>
							<td style=\"text-align:left\"><div align=\"left\">".odbc_result($result,"RAZON_SOCIAL")."</div></td>
							<td style=\"text-align:center\"><div align=\"center\">".odbc_result($result,"CATEGORIAS")."</div></td>
							<td style=\"text-align:center\"><div align=\"center\">".odbc_result($result,"CANT_REGISTRADO")."</div></td>
								<td style=\"text-align:center\"><div align=\"center\">".odbc_result($result,"NB_LOCALIDAD")."</div></td>
							";
							echo "</tr>";
		}
			
					echo "</tr>
					<tr>
						<td>
						&nbsp;
						</td>
						&nbsp;
						<td>
						&nbsp;
						</td>
						<td style=\"text-align:right\"><b>TOTALES:
						&nbsp;</b>
						</td>
						<td style=\"text-align:center\">".$cont_pbl."
						</td>
						<td>
						&nbsp;
						</td>
					</tr>";
					$conector->Cerrar();
?>  
 </table>
</div>  
</body>
</html>
