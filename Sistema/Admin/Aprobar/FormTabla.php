<?php
$Nivel="../../../";
include($Nivel."includes/PHP/funciones.php");

$Conector=Conectar2();

session_start();	

$SiglasSistema=$_SESSION['SiglasSistema'];
$Rif = $_SESSION[$SiglasSistema.'RIF'];

date_default_timezone_set('America/Caracas');
$num_sm = $_GET["num_sm"];
 
$sql = "SELECT * FROM WEB.VIEW_WEB_RPT_SOLMUELLE WHERE ID =  $num_sm ";
    $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
    $CONEXION=$ResultadoEjecutar["CONEXION"];						
    $ERROR=$ResultadoEjecutar["ERROR"];
    $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
    $result=$ResultadoEjecutar["RESULTADO"];
    if($CONEXION=="SI" and $ERROR=="NO")
    {
        while ($registro=odbc_fetch_array($result))
        {
            $BUQUE 	= utf8_encode(odbc_result($result,'NB_BUQUE'));
            $BANDERA = utf8_encode(odbc_result($result,'NACIONALIDAD')); 
            $ESLORA = odbc_result($result,'ESLORA'); 
            $TRB = odbc_result($result,'TRB'); 
            $CALADO_PROA = odbc_result($result,'CALADO_PROA'); 
            $CALADO_POPA = odbc_result($result,'CALADO_POPA'); 
            $VIAJE = odbc_result($result,'NRO_VIAJE'); 
            $CAPITAN = utf8_encode(odbc_result($result,'CAPITAN')); 
            $MUELLE = utf8_encode(odbc_result($result,'NB_BIEN')); 
            $ETA = odbc_result($result,'FECHA_ETA'); 
            $ETD = odbc_result($result,'FECHA_ETD'); 
            $PROCEDENCIA = utf8_encode(odbc_result($result,'PUERTO_PROC')); 
            $DESTINO = utf8_encode(odbc_result($result,'PUERTO_DESTINO')); 
            $TIPO_OPERACION = utf8_encode(odbc_result($result,'DS_TIPO_SOLICITUD')); 
            $CODIGO = utf8_encode(odbc_result($result,'CODIGO')); 
            $FECHA = FechaHoraNormal(odbc_result($result,'FECHA_REG')); 
            $RIF_CED_GENERA = utf8_encode(odbc_result($result,'RIF_CED_GENERA')); 
            $NB_PROVEED_BENEF = odbc_result($result,'NB_PROVEED_BENEF'); 

        }
    }
    else
    {	
        echo $MSJ_ERROR;
        exit;
    }
        
        
?>

<div class="table_responsive">
    <table border="1" class="table table-bordered ">
        <thead>
            <tr>
                <th colspan ="10" style = "text-align: center;" ><strong>Datos de la Solicitud de Muelle</strong> </th>
            </tr>
        </thead>
        <tbody>
        <?php
            echo '
            <tr>
                <td colspan ="6">Agente Naviero: <strong>'.$RIF_CED_GENERA.' - '.$NB_PROVEED_BENEF.'</td>
                <td colspan ="1">Solicitud: '.$CODIGO.'</td>
                <td colspan ="3">Fecha elaboraci&oacute;n: '.$FECHA.'</td>
            </tr>
            <tr>
                <td colspan ="3">Buque: '.$BUQUE.'</td>
                <td colspan ="3">Bandera: '.$BANDERA.'</td>
                <td>Eslora: '.$ESLORA.'</td>
                <td>TRB: '.$TRB.'</td>
                <td>Calado Proa: '.$CALADO_PROA.'</td>
                <td>Calado Popa: '.$CALADO_POPA.'</td>
            </tr>
            <tr>
                <td>Viaje: '.$VIAJE.'</td>
                <td colspan ="2">Capitan: '.$CAPITAN.'</td>
                <td>Pref. Muelle: '.$MUELLE.'</td>
                <td colspan ="2">ETA: '.$ETA.'</td>
                <td colspan ="2">ETD: '.$ETD.'</td>
                <td>Proc: '.$PROCEDENCIA.'</td>
                <td>Dest: '.$DESTINO.'</td>
            </tr>
            <tr>
                <td colspan ="10">Tipo de Operaci&oacute;n: '.$TIPO_OPERACION.'</td>
            </tr>
        </tbody>
     </table>';

     $sql = "SELECT * FROM  [web].[VIEW_LISTADO_PRELIQ_IDSM] WHERE ID =  $num_sm ";
     $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
     $CONEXION=$ResultadoEjecutar["CONEXION"];						
     $ERROR=$ResultadoEjecutar["ERROR"];
     $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
     $result=$ResultadoEjecutar["RESULTADO"];
     if($CONEXION=="SI" and $ERROR=="NO")
     {
         while ($registro=odbc_fetch_array($result))
         {
             $NB_STIPO_SERVICIO 	= utf8_encode(odbc_result($result,'NB_STIPO_SERVICIO'));
             $NB_PROVEED_BENEF = odbc_result($result,'NB_PROVEED_BENEF'); 
             $CODIGO_PRELIQ = odbc_result($result,'CODIGO_PRELIQ'); 
             $FECHA_EMISION = FechaHoraNormal(odbc_result($result,'FECHA_EMISION')); 
             $CAMBIO_DIVISA = odbc_result($result,'CAMBIO_DIVISA'); 
             $DS_TIPO_CTA = odbc_result($result,'DS_TIPO_CTA'); 
             $MONTO_NETO = odbc_result($result,'MONTO_NETO'); 
         }
     }
     else
     {	
         echo $MSJ_ERROR;
         exit;
     }
        
?>

</div>

<div class="table_responsive">

<table border="1" class="table table-bordered ">
    <thead>
        <tr>
            <th colspan ="7" style = "text-align: center;" ><strong>Preliquidaciones Generadas</strong> </th>
        </tr>
        <tr style = "text-align: center;">
            <th>Nombre Servicio</th>
            <th>Cliente</th>
            <th>Nro. Preliq</th>
            <th>Fecha Emision</th>
            <th>Cambio Divisa</th>
            <th>Tipo Moneda</th>
            <th>Monto Neto</th>
        </tr>
    </thead>
    <tbody>
    <?php
        echo '
        <tr>
            <td >'.$NB_STIPO_SERVICIO.'</td>
            <td >'.$NB_PROVEED_BENEF.'</td>
            <td >'.$CODIGO_PRELIQ.'</td>
            <td >'.$FECHA_EMISION.'</td>
            <td >'.number_format($CAMBIO_DIVISA, 2, ",", ".").'</td>
            <td >'.$DS_TIPO_CTA.'</td>
            <td > '.number_format($MONTO_NETO, 2, ",", ".").'</td>
        </tr>
        
    </tbody>
 </table>';

 $Conector->Cerrar();
?>

</div>
