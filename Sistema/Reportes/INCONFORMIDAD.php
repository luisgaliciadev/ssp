<?PHP 
	$Nivel="../../";
	include($Nivel."includes/funciones.php");
	
	$conector=Conectar();
	
	session_start();
		
	$id_empr_acta = $_GET["id_empr_acta"];
	$id_empresa = $_GET["id_empresa"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo includes($Nivel);?> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>LISTADO DE ACTAS DE INCOFORMIDAD </title>
</head>
<body>



   
   <DIV style="width:800px; margin: auto;">  

<?PHP 

$sql="select * from empresa where id_empresa = $id_empresa ";
$cn2=$conector->Ejecutar($sql);

$nb_empresa = odbc_result($cn2,'razon_social');
$rif = odbc_result($cn2,'rif');

$sql="select * from VIEW_RP_DOCU_INCON where id_empr_acta = $id_empr_acta  ";
$cn2=$conector->Ejecutar($sql);

$body = "<h3><strong> $nb_empresa ($rif)</strong></h3></br></br>";
$aux = 1;
while(odbc_fetch_row($cn2))
{
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="class='Normal'";
		$pintar=1;
	}
	
	$nb_documento=odbc_result($cn2,'nb_docum');
	$NB_INCONFOR =odbc_result($cn2,'NB_INCONFORM');
	$DS_INCONF =odbc_result($cn2,'DS_INCONF');
	
	if($aux == 1)
	{
		$nro_acta=odbc_result($cn2,'nro_acta');
?>
     <br />
     <br />
				<h3><strong> Datos de Documentos con Inconformidad  <?php echo $nro_acta;?> </strong></h3>
     <br />
     <br />
				<table  width='800px' border="1" style="border-collapse:collapse; margin:auto;">
					<tr >
					<th>DOCUMENTO</th>
					<th>TIPO DE INCONFORMIDAD</th>
					<th>DESCRIP.</th>
					
					</tr>
<?php
		$aux = 1 + $aux;
	}
?>
		<tr <?php echo $clase;?>>
			<td ><?php echo $nb_documento;?></td>
			<td ><?php echo $NB_INCONFOR;?></td>
			<td ><?php echo $DS_INCONF;?></td>
		</tr>
<?php
}
?>
</table>
     <br />
     <br />

<?php
$aux = 1;

// datos de garantias inconformes
$sql="select * from VIEW_RP_GARAN_INCON where id_empr_acta = $id_empr_acta ";
$cn2=$conector->Ejecutar($sql);
$pintar=0;
while(odbc_fetch_row($cn2))
{
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="class='Normal'";
		$pintar=1;
	}
	$nb_categoria=odbc_result($cn2,'nb_categoria');
	$nb_tgarantia=odbc_result($cn2,'nb_tgarantia');
	$nb_emp_asegur=odbc_result($cn2,'nb_emp_asegur');
	$nro_docum=odbc_result($cn2,'nro_docum');
	$NB_INCONFOR =odbc_result($cn2,'NB_INCONFORM');
	$DS_INCONF =odbc_result($cn2,'DS_INCONF');
	
	if($aux == 1){
	
		
		$nro_acta=odbc_result($cn2,'nro_acta');
?>
     <br />
     <br />
				<h3> <strong>Documentos de las Garantias (Nº. Acta <?php echo $nro_acta;?>)</strong></h3>
     <br />
     <br />
				<table width='800px' border="1" style="border-collapse:collapse; margin:auto;">
					<tr>
					<th>CATEGORIA</th>
					<th>TIPO DE GARANTIA</th>
					<th>EMPRESA ASEGURADORA</th>
					<th>Nº DOCUMENTO</th>
					<th>INCONFORMIDAD</th>
					<th>DESCRIPCION</th>
					</tr>
<?php
			$aux = 1 +$aux ;
	
	}
?>
		<tr <?php echo $clase;?>>
			<td ><?php echo $nb_categoria;?></td>
			<td ><?php echo $nb_tgarantia;?></td>
			<td ><?php echo $NB_INCONFOR;?></td>
			<td ><?php echo $DS_INCONF;?></td>
		</tr>
<?php

}

?>
</table>

<?php

$aux = 1;

// datos de EMPLEADOS inconformes

$sql="select * from VIEW_RP_EMPL_INCO where id_empr_acta = $id_empr_acta  ";
$cn2=$conector->Ejecutar($sql);
$pintar=0;
while(odbc_fetch_row($cn2))
{
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="class='Normal'";
		$pintar=1;
	}
	
	$ci_empleado=odbc_result($cn2,'ci_empleado');
	$nb_empleado=odbc_result($cn2,'nb_empleado');
	$nb_cargo=odbc_result($cn2,'nb_cargo');
	$NB_INCONFOR =odbc_result($cn2,'NB_INCONFORM');
	$DS_INCONF =odbc_result($cn2,'DS_INCONF');
	
	
	if($aux == 1){
		$nro_acta=odbc_result($cn2,'nro_acta');
?>
     <br />
     <br />
				<h3> <strong>Datos de los Empleados (Nº. Acta <?php echo $nro_acta;?>)</strong></h3>
     <br />
     <br />
				<table width='800px' border="1" style="border-collapse:collapse; margin:auto;">
					<tr>
					<th>CEDULA</th>
					<th>NOMBRE</th>
					<th>CARGO</th>
					<th>INCONFORMIDAD</th>
					<th>DESCRIPCION</th>
					</tr>
<?php
			$aux = 1 +$aux ;
	
	}
?>
			<tr <?php echo $clase;?>>
				<td ><?php echo $ci_empleado;?></td>
				<td ><?php echo $nb_empleado;?></td>
				<td ><?php echo $nb_cargo;?></td>
				<td ><?php echo $NB_INCONFOR;?></td>
				<td ><?php echo $DS_INCONF;?></td>
			</tr>
<?php

}
?>
</table>
<?php

$aux = 1;
// datos de vehiculos inconformes
$sql="select * from VIEW_RP_VEH_INCONF where id_empr_acta = $id_empr_acta  ";
$cn2=$conector->Ejecutar($sql);
$pintar=0;
while(odbc_fetch_row($cn2))
{
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="class='Normal'";
		$pintar=1;
	}
	
	$placa=utf8_encode (odbc_result($cn2,'placa'));
	$nb_modelo_veh=utf8_encode (odbc_result($cn2,'nb_modelo_veh'));
	$nb_tvehiculo=utf8_encode (odbc_result($cn2,'nb_tvehiculo'));
	$color=utf8_encode (odbc_result($cn2,'color'));
	$NB_INCONFOR =odbc_result($cn2,'NB_INCONFORM');
	$DS_INCONF =odbc_result($cn2,'DS_INCONF');
	
	
	if($aux == 1){
	
		
		$nro_acta=odbc_result($cn2,'nro_acta');
?>
     <br />
     <br />
				<h3> <strong>Datos de Vehiculos (Nº. Acta <?php echo $nro_acta;?>)</strong></h3>
     <br />
     <br />
				<table width='800px' border="1" style="border-collapse:collapse; margin:auto;">
					<tr>
					<th>PLACA</th>
					<th>MODELO</th>
					<th>TIPO DE VEHICULO</th>
					<th>COLOR</th>
					<th>INCONFORMIDAD</th>
					<th>DESCRIPCION</th>
					</tr>
<?php
			$aux = 1 +$aux ;
	
	}
?>
			<tr <?php echo $clase;?>>
				<td ><?php echo $placa;?></td>
				<td ><?php echo $nb_modelo_veh;?></td>
				<td ><?php echo $nb_tvehiculo;?></td>
				<td ><?php echo $color;?></td>
				<td ><?php echo $NB_INCONFOR;?></td>
				<td ><?php echo $DS_INCONF;?></td>
			</tr>
<?php

}
?>
</table>
<?php
$aux = 1;

// datos de maquinaria inconformes
$sql="select * from VIEW_RP_MAQ_INCON where id_empr_acta = $id_empr_acta ";
$cn2=$conector->Ejecutar($sql);
$pintar=0;
while(odbc_fetch_row($cn2))
{
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="class='Normal'";
		$pintar=1;
	}
	
	$SERIAL=utf8_encode (odbc_result($cn2,'SERIAL'));
	$DS_MAQEQUIP=utf8_encode (odbc_result($cn2,'DS_MAQEQUIP'));
	$NB_PROPIETARIO=utf8_encode (odbc_result($cn2,'NB_PROPIETARIO'));
	$NB_TIPO_MAQEQUIP=utf8_encode (odbc_result($cn2,'NB_TIPO_MAQEQUIP'));
	$NB_MARCA_MAQEQUIP=utf8_encode (odbc_result($cn2,'NB_MARCA_MAQEQUIP'));
	$NB_INCONFOR =odbc_result($cn2,'NB_INCONFORM');
	$DS_INCONF =odbc_result($cn2,'DS_INCONF');
	
	
	
	if($aux == 1){
	
?>
     <br />
     <br />
			<h3> <strong>Datos de Maquinarias y Equipos (Nº. Acta <?php echo $nro_acta;?>)</strong></h3>
     <br />
     <br />
				<table width='800px' border="1" style="border-collapse:collapse; margin:auto;">
					<tr>
					<th>SERIAL</th>
					<th>DESCRIPCIÓN</th>
					<th>PROPIETARIO</th>
					<th>TIPO MAQUINA</th>
					<th>MARCA</th>
					<th>INCONFORMIDAD</th>
					<th>DESCRIPCION</th>
					</tr>
<?php
			$aux = 1 +$aux ;
	
	}
?>
			<tr <?php echo $clase;?>>
				<td ><?php echo $SERIAL;?></td>
				<td ><?php echo $DS_MAQEQUIP;?></td>
				<td ><?php echo $NB_PROPIETARIO;?></td>
				<td ><?php echo $NB_TIPO_MAQEQUIP;?></td>
				<td ><?php echo $NB_MARCA_MAQEQUIP;?></td>
				<td ><?php echo $NB_INCONFOR;?></td>
				<td ><?php echo $DS_INCONF;?></td>
			</tr>
<?php

}
$conector->Cerrar();
?>
</table>
</DIV>
</body>
</html>