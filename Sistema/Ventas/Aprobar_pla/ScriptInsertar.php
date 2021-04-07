<?php

$Nivel="../../../";
include($Nivel."includes/PHP/funciones.php");

$Conector=Conectar2();
//$Conector2 = Conectar3();

//$Conector_hosting=Conectar();


session_start();	

 $RIF=$_SESSION[$_SESSION['SiglasSistema'].'RIF'];
 $LOGIN=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];
    $num_sm = $_POST["num_sm"];
   
    $vSQL="exec [web].[SP_APROBAR_SOLICITUD_PLANIF] $num_sm, '$LOGIN'";
   
   $ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
   
   $CONEXION=$ResultadoEjecutar["CONEXION"];

   $ERROR=$ResultadoEjecutar["ERROR"];
   $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
   $resultPrin=$ResultadoEjecutar["RESULTADO"];

   if($CONEXION=="SI" and $ERROR=="NO")
   {		
        $ID			=	odbc_result($resultPrin,"ID");
        $MENSAJE	=	odbc_result($resultPrin,"MENSAJE");     
        $Arreglo["ID_BENEF"]=$ID;
        $Arreglo["MENSAJE"]=$MENSAJE;
        $Arreglo["CONEXION"]=$CONEXION;
        $Arreglo["ERROR"]=$ERROR;
   
   }
   else
   {
       $Arreglo["CONEXION"]=$CONEXION;
       $Arreglo["ERROR"]=$ERROR;
       $Arreglo["MSJ_ERROR"]=$MSJ_ERROR;

   }
       
   echo json_encode($Arreglo);
   
   $Conector->Cerrar();



?>