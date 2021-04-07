<?php
	$Nivel="../../";	
	include($Nivel."includes/funciones.php");
	
$conector=Conectar();
$ANO_REGISTRO		 =	$_GET["ANO_REGISTRO"];

$vSQL = "SELECT [RIF]
      ,[RAZON_SOCIAL]
      ,[CI_EMPLEADO]
      ,[NB_EMPLEADO]
      ,[PUERTO_ACCESO]
      ,[ANO_REGISTRO]
  FROM [dbo].[VIEW_RPT_EMPLEADOS_TRANSPORTISTAS_ACT_IMP]
  WHERE  ANO_REGISTRO=$ANO_REGISTRO
  ORDER BY [RAZON_SOCIAL]"; 

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LISTADO DE EMPLEADOS</title>
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
    </style>
<body onload="window.parent.$('#Loading').css('display','none');">
<script>
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
<table width="1300" border="0" align="center" class="tabla" >
  <tr>
    <td align="center" valign="middle">
      <img src="../../imagen/header.png" width="885" height="52" />
    </td>
  </tr>
  <tr>
    <td align="center" valign="middle">
      <strong><h1>BOLIVARIANA DE PUERTOS (BOLIPUERTOS), S.A</h1></strong>
      <h1>LISTADO DE EMPLEADOS CON PASES IMPRESOS </h1>
       <h1>PERIODO <?php echo $ANO_REGISTRO;?></h1>
      
    </td>
  </tr>
</table>
<p>&nbsp;</p>

<table width="1300" border="1" align="center" style="border-collapse:collapse;" class="tabla">
<tr>
</tr>
<tr>
</tr>

   <tr style="background-color:#999">
   <td width="50" >
    	<div align="center">
        	<label style="text-align:center"  class="Estilo1">NRO </label>
        </div>
    </td>
     <td width="100" >
    	<div align="center">
        	<label style="text-align:center"  class="Estilo1">CLIENTE </label>
        </div>
    </td>
    <td width="100" >
    	<div align="center">
        	<label style="text-align:center"  class="Estilo1">RIF </label>
        </div>
    </td>
    <td width="100" >
    	<div align="center">
        	<label style="text-align:center"  class="Estilo1">CI EMPLEADO</label>
        </div>
    </td>
      <td width="100" >
    	<div align="center">
        	<label style="text-align:center"  class="Estilo1">NOMBRE EMPLEADO </label>
        </div>
    </td>
    <td width="100" >
    	<div align="center">
        	<label style="text-align:center"  class="Estilo1">PUERTO ACCESO </label>
        </div>
    </td>
</tr>
  
  
  <?php
	$pintar=0;
	$i=0;
	$result=$conector->Ejecutar($vSQL);
	while (odbc_fetch_row($result))  
		{ 
			$i=$i+1;
		if($pintar)
		{
			$clase="class='color'";
			$pintar=0;
		}
		else
		{
			$clase="";
			$pintar=1;
		}
									
				echo "<tr $clase>";
				echo " 
				<td><div align=\"center\">".$i."</div></td>
				<td><div align=\"center\">".odbc_result($result,"RAZON_SOCIAL")."</div></td>
				<td><div align=\"center\">".odbc_result($result,"RIF")."</div></td>
				<td><div align=\"center\">".odbc_result($result,"CI_EMPLEADO")."</div></td>
				<td><div align=\"center\">".odbc_result($result,"NB_EMPLEADO")."</div></td>
				<td><div align=\"center\">".odbc_result($result,"PUERTO_ACCESO")."</div></td>
				";
				echo "</tr>";
			
		}

	  
  ?>
</table>

</div>  
</body>
</html>
