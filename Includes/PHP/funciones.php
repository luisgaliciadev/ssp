<?php 
	error_reporting(E_ERROR | E_PARSE);
	
	session_start();
	
	$_SESSION['SiglasSistema']="M";
	
	set_time_limit(300);
	
	date_default_timezone_set('America/Caracas');
		
	if(isset($_SESSION[$_SESSION['SiglasSistema'].'LOGIN']))
	{
		$_SESSION[$_SESSION['SiglasSistema'].'TIEMPO_INICIAL']=time();
	}
	
	function Conectar()
	{		
		if(!isset($_SESSION[$_SESSION['SiglasSistema'].'LOGIN']))
		{
			$CI_USUARIO=0;
		}
		else
		{
			$CI_USUARIO=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];
		}
		
		$Host		= "";
		$BaseDatos	= "";
		$Usuario	= "";
		$Clave		= "";
		
		$_SESSION['BaseDatos']=$BaseDatos;
		
		$Conector = new Conexion($BaseDatos, $Host, $Usuario, $Clave, $CI_USUARIO);
		
		return $Conector;
	}
	
	function Conectar2()
	{		
		if(!isset($_SESSION[$_SESSION['SiglasSistema'].'LOGIN']))
		{
			$CI_USUARIO=0;
		}
		else
		{
			$CI_USUARIO=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];
		}
		
		$NB_SERVERNAME	= $_SESSION[$_SESSION['SiglasSistema'].'NB_SERVERNAME'];
		$NBDB			= $_SESSION[$_SESSION['SiglasSistema'].'NBDB'];
		$ACCES_USER		= $_SESSION[$_SESSION['SiglasSistema'].'ACCES_USER'];
		$PASS_USER		= $_SESSION[$_SESSION['SiglasSistema'].'PASS_USER'];			
						
	
		
		$_SESSION['BaseDatos']=$NBDB;
		
		$Conector = new Conexion($NBDB, $NB_SERVERNAME, $ACCES_USER, $PASS_USER, $CI_USUARIO);
		
		return $Conector;	
	}
	
	function Conectar3()
	{		
		if(!isset($_SESSION[$_SESSION['SiglasSistema'].'LOGIN']))
		{
			$CI_USUARIO=0;
		}
		else
		{
			$CI_USUARIO=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];
		}
		
		$NB_SERVERNAME	= $_SESSION[$_SESSION['SiglasSistema'].'NB_SERVERNAME3'];
		$NBDB			= $_SESSION[$_SESSION['SiglasSistema'].'NBDB3'];
		$ACCES_USER		= $_SESSION[$_SESSION['SiglasSistema'].'ACCES_USER3'];
		$PASS_USER		= $_SESSION[$_SESSION['SiglasSistema'].'PASS_USER3'];			

		
		$_SESSION['BaseDatos']=$NBDB;
		
		$Conector = new Conexion($NBDB, $NB_SERVERNAME, $ACCES_USER, $PASS_USER, $CI_USUARIO);
		
		return $Conector;
	}
	
	function includes($Nivel, $TipoArchivo)
	{
		$Includes = "";
		
		return $Includes;
	}
		
	class Conexion
	{		
		private $id_conn;
		private $NB_BASE_DATOS;
		private $CI_USUARIO;
		
		public function __construct($lBaseDatos, $lHost, $lUsuario, $lClave, $lCI_USUARIO)
		{
			$dsn = "Driver={SQL Server};Database=".$lBaseDatos.";Server=".$lHost.";Integrated Security=SSPI;Persist Security Info=False;";
			
			if($this->id_conn=odbc_connect($dsn,$lUsuario,$lClave))
			{
				$this->NB_BASE_DATOS=$lBaseDatos;
				$this->CI_USUARIO=$lCI_USUARIO;
			}
			else
			{
				$this->id_conn=0; 
			}
		}			
				
		public function Cerrar()
		{
			$Conector=$this->id_conn;
			
			odbc_close($Conector);
		}
				
		public function Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='SI', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID=0)
		{
			$Conector=$this->id_conn;
			
			if($INSERT_MAYUSCULA=="SI")
			{
				$vSQL2=strtoupper($vSQL);
				$vSQL3=strtoupper($vSQL);
			}
			else
			{
				$vSQL2=$vSQL;
				$vSQL3=strtoupper($vSQL);
			}
			
			if(BuscarEnCadena($vSQL3, 'SELECT'))
			{
				$ACCION='SELECT';	
				$NB_TABLA="";										
			}	
			else
			{					
				if(BuscarEnCadena($vSQL3, 'INSERT'))
				{
					$ACCION='INSERT';
					$NB_TABLA=strtolower(trim(BuscarEntre($vSQL2,"INTO","(")));							
				}	
				else
				{				
					if(BuscarEnCadena($vSQL3, 'UPDATE'))
					{	
						$ACCION='UPDATE';
						$NB_TABLA=strtolower(trim(BuscarEntre($vSQL2,"UPDATE","SET")));							
					}
					else
					{
										
						if(BuscarEnCadena($vSQL3, 'EXEC'))
						{	
							$ACCION='EXEC';	
							$NB_TABLA="";						
						}
						else
						{
							if(BuscarEnCadena($vSQL3, 'DELETE'))
							{
								$ACCION='DELETE';
								$NB_TABLA=strtolower(trim(BuscarEntre($vSQL2,"FROM","WHERE")));								
							}
						}
					}
				}
			}
								
			if($Conector==0)			
			{
				$ArregloResultado["CONEXION"]="NO";	
				$ArregloResultado["ERROR"]="SI";
					
				if(IpServidor()=="10.10.30.52")
				{	
					$ArregloResultado["MSJ_ERROR"]="No se puedo conectar con el servidor, error: ".odbc_error();
				}
				else
				{
					$ArregloResultado["MSJ_ERROR"]="Error, No se puedo conectar con el servidor, por favor notificar al correo sbs@bolipuertos.gob.ve, envie captura de pantalla.";
				}
				
				return $ArregloResultado;
			}
			else
			{
				$ArregloResultado["CONEXION"]="SI";	
									
				if($ACCION!='SELECT' and $ACCION!='EXEC')
				{
					$NB_BASE_DATOS=$this->NB_BASE_DATOS;
					
					if(strpos($NB_TABLA, ".")>0)
					{
						$NB_BASE_DATOS=BuscarBaseDatos($NB_TABLA);
						$NB_TABLA=BuscarTabla($NB_TABLA);
					}
					
					$vSQL4="SELECT 
								isc.COLUMN_NAME AS Primary_key 
							FROM 
								INFORMATION_SCHEMA.COLUMNS AS isc INNER JOIN 
								INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS kcs ON 
								isc.TABLE_NAME = kcs.TABLE_NAME AND 
								isc.COLUMN_NAME = kcs.COLUMN_NAME AND 
								LEFT(kcs.CONSTRAINT_NAME, 2) = 'PK'
							WHERE 
									table_name = '$NB_TABLA' AND 
									TABLE_CATALOG = '$NB_BASE_DATOS'";
						
					if($result2=odbc_exec($Conector,$vSQL4))
					{						
						$registro2=odbc_fetch_array($result2);
						
						$NB_CAMPO_ID=$registro2["Primary_key"];
						
						/*if($NB_CAMPO_ID)
						{
							$AUTO_INCREMENTADO=1;
						}
						else
						{
							$AUTO_INCREMENTADO=0;
						}*/
					}
				}
				
				$vSQL2=utf8_decode($vSQL2);
				
				if($result=odbc_exec($Conector, $vSQL2))
				{
					$ArregloResultado["ERROR"]="NO";
										
					switch($ACCION)
					{								
						case 'SELECT':						
							$ArregloResultado["RESULTADO"]=$result;
							
							return $ArregloResultado; 
						break;
							
						case 'INSERT':
							/*if($AUTO_INCREMENTADO)
							{
								$VALOR_CAMPO_ID=$this->IdInsertado();
							}
							else
							{
								$VALOR_CAMPO_ID=0;
							}*/
							
							$ID_INSERTADO=$this->IdInsertado();
								
							$this->Bitacora($ACCION, $NB_TABLA, $VALOR_CAMPO_ID, $vSQL2);
							
							$ArregloResultado["RESULTADO"]=$result;
							$ArregloResultado["ID_INSERTADO"]=$ID_INSERTADO;
							
							return $ArregloResultado; 				
						break;
						
						case 'UPDATE':
							//$VALOR_CAMPO_ID=EncIdUpdate($vSQL2, $NB_CAMPO_ID);
							$VALOR_CAMPO_ID=0;
							
							$this->Bitacora($ACCION, $NB_TABLA, $VALOR_CAMPO_ID, $vSQL2);
							
							$ArregloResultado["RESULTADO"]=$result;
							
							return $ArregloResultado; 								
						break;	
													
						case 'EXEC':
							$VALOR_CAMPO_ID=0;
							
							if($SP_BITACORA=='SI')
							{
								if($SP_ACCION)
									$ACCION=$ACCION.'/'.$SP_ACCION;
									
								$this->Bitacora($ACCION, $SP_NB_TABLA, $SP_VALOR_CAMPO_ID, $vSQL2);
							}
							
							$ArregloResultado["RESULTADO"]=$result;
							
							return $ArregloResultado; 
						break;
						
						case 'DELETE':
							//$VALOR_CAMPO_ID=EncIdUpdate($vSQL2,$NB_CAMPO_ID);
							$VALOR_CAMPO_ID=0;
							
							$this->Bitacora($ACCION, $NB_TABLA, $VALOR_CAMPO_ID, $vSQL2);
							
							$ArregloResultado["RESULTADO"]=$result;
							
							return $ArregloResultado; 
						break;
					}
				}
				else
				{
					if(IpServidor()=="10.10.30.52")
					{							
						$MSJ_ERROR=utf8_encode(odbc_errormsg($Conector));
											
						$LOG=$this->LogErrores($ACCION, $MSJ_ERROR, $vSQL2);
						
						
						$MSJ_ERROR=$MSJ_ERROR.", en la sentencia SQL: ".$vSQL2;
					}
					else
					{
						$MSJ_ERROR="Error de ejecución, por favor notificar al correo sbs@bolipuertos.gob.ve, envie captura de pantalla.";
					}
					
					$ArregloResultado["ERROR"]="SI";		
					$ArregloResultado["MSJ_ERROR"]=$MSJ_ERROR;
					
					return $ArregloResultado;										
				}
			}
		}
	
		public function IdInsertado()
		{
			$Conector=$this->id_conn;
			
			$vSQL = "SELECT @@identity as ID";
			
			if($rs=odbc_exec($Conector, $vSQL))
			{
				$row = odbc_fetch_array($rs);
				$id=$row['ID'];	
				return $id;
			}
		}
		
		private function Bitacora($ACCION, $NB_TABLA, $VALOR_CAMPO_ID, $SENTENCIA_SQL)
		{
			$Conector=$this->id_conn;
						
			$NB_BASE_DATOS=$this->NB_BASE_DATOS;			
			$CI_USUARIO=$this->CI_USUARIO;
			
			$VALOR_CAMPO_ID=str_replace("'","",$VALOR_CAMPO_ID);
			
			if($NB_TABLA)
			{
				if(strpos($NB_TABLA, ".")>0)
				{
					$NB_BASE_DATOS=BuscarBaseDatos($NB_TABLA);
					$NB_TABLA=BuscarTabla($NB_TABLA);
				}
				
				if($NB_TABLA)
				{
					if(strpos($NB_TABLA, ".")>0)
					{
						$NB_BASE_DATOS=BuscarBaseDatos($NB_TABLA);
						$NB_TABLA=BuscarTabla($NB_TABLA);
					}
					
					$vSQL="SELECT 
								isc.COLUMN_NAME AS Primary_key 
							FROM 
								INFORMATION_SCHEMA.COLUMNS AS isc INNER JOIN 
								INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS kcs ON 
								isc.TABLE_NAME = kcs.TABLE_NAME AND 
								isc.COLUMN_NAME = kcs.COLUMN_NAME AND 
								LEFT(kcs.CONSTRAINT_NAME, 2) = 'PK'
							WHERE 
									table_name = '$NB_TABLA' AND 
									TABLE_CATALOG = '$NB_BASE_DATOS'";
															
					if($result2=odbc_exec($Conector,$vSQL))
					{
						$registro2=odbc_fetch_array($result2);
						
						$NB_CAMPO_ID=$registro2["Primary_key"];
					}
					else
					{
						return $vSQL;
					}
				}
				else
				{
					$NB_CAMPO_ID='';
				}
			}
			else
			{
				$NB_CAMPO_ID='';
			}
			
			$SENTENCIA_SQL=str_replace("'",'"',$SENTENCIA_SQL);		
			
			$IP_DESTINO=IpCliente();
			
			$vSQL2=strtoupper("insert into TB_BITACORA
						(
							CI_USUARIO, 
							ACCION, 
							NB_BASE_DATOS, 
							NB_TABLA, 
							NB_CAMPO_ID, 
							VALOR_CAMPO_ID, 
							SENTENCIA_SQL, 
							IP_DESTINO
						) 
					values
						(
							'$CI_USUARIO',
							'$ACCION',  
							'$NB_BASE_DATOS', 
							'$NB_TABLA', 
							'$NB_CAMPO_ID', 
							'$VALOR_CAMPO_ID', 
							'$SENTENCIA_SQL', 
							'$IP_DESTINO'
						);");	
						
			if(odbc_exec($Conector,$vSQL2))
			{
				return true;
			}
			else
			{
				//return false;	
				return $vSQL2;
			}
		}
		
		private function LogErrores($ACCION, $MSJ_ERROR, $SENTENCIA_SQL)
		{
			$Conector=$this->id_conn;
			
			$CI_USUARIO=$this->CI_USUARIO;	
						
			$RUTA_ARCHIVO=$_SERVER['PHP_SELF'];		
			
			$MSJ_ERROR=str_replace("'",'"',$MSJ_ERROR);
			
			$SENTENCIA_SQL=str_replace("'",'"',$SENTENCIA_SQL);
			
			$IP_DESTINO=IpCliente();
			
			$vSQL=strtoupper("
				insert into TB_LOG_ERRORES 
					(CI_USUARIO, ACCION, SENTENCIA_SQL, MSJ_ERROR, RUTA_ARCHIVO, IP_DESTINO) 
				values 
					('$CI_USUARIO', '$ACCION', '$SENTENCIA_SQL', '$MSJ_ERROR', '$RUTA_ARCHIVO', '$IP_DESTINO');");
			
			if(odbc_exec($Conector, $vSQL))
			{
				return 1;
			}
			else
			{
				return $vSQL;	
			}
		}
	}
	
	function BuscarEnCadena($cadena,$segmento)
	{
		$cad=strpos($cadena, $segmento);
		
		if($cad>-1) 
		{ 
			return true;
		} 
		else 
		{ 
			return false;
		} 
	}		
	
	function BuscarEntre($vSQL,$desde_p,$hasta_p)
	{	
		if(is_null($hasta_p))
			$hasta_p=strlen($vSQL);
		
		$desde=strpos($vSQL, $desde_p)+strlen($desde_p);
		$hasta=strpos($vSQL, $hasta_p);
		$hasta-=$desde;
		
		return substr($vSQL,$desde,$hasta);
	}	
	
	function BuscarBaseDatos($cadena)
	{
		$largo=strlen($cadena);
		$pos_punto=strpos($cadena, ".");
		$lt=$largo-$pos_punto;
		$bdat=substr($cadena,0,$pos_punto);	
		return $bdat;
	}
	
	function BuscarTabla($cadena)
	{
		$largo=strlen($cadena);
		$pos_punto=strpos($cadena, ".");
		$lt=$largo-$pos_punto;
		$tabla_=substr($cadena,$pos_punto+1,$lt);
		return $tabla_;
	}
		
	function IpCliente() 
	{
        return $_SERVER['REMOTE_ADDR'];
    }
		
	function IpServidor() 
	{
        return gethostbyname($server_NAME);
    }
	
	function FechaSQL($FechaNormal)
	{ 
		if($FechaNormal)
		{
			$FechaSQL=date("Y-m-d",strtotime($FechaNormal)); 
		}
		else
		{
			$FechaSQL="";
		}
		
		return $FechaSQL;
	} 
	

	function FechaBD($FechaNormal)
	{ 
		if($FechaNormal)
		{
			$FechaSQL=date("Ymd",strtotime($FechaNormal)); 
		}
		else
		{
			$FechaSQL="";
		}
		
		return $FechaSQL;
	} 
	
	function FechaNormal($FechaSQL)
	{
		if($FechaSQL)
		{
			$FechaSQL=date("d/m/Y",strtotime($FechaSQL));
		}
		else
		{
			$FechaSQL="";
		}
		
		return $FechaSQL;
	}
	
	function FechaInput($FechaSQL)
	{
		if($FechaSQL)
		{
			$FechaSQL=date("Y-m-d",strtotime($FechaSQL));
		}
		else
		{
			$FechaSQL="";
		}
		
		return $FechaSQL;
	}
	
	function FechaHoraNormal($FechaSQL)
	{
		if($FechaSQL)
		{
			$FechaHoraNormal=date("d/m/Y h:m:s a",strtotime($FechaSQL));
		}
		else
		{
			$FechaHoraNormal="";
		}
		
		return $FechaHoraNormal;
	}
	
	function FechaHoraSql($FechaSQL)
	{
		if($FechaSQL)
		{
			$FechaHoraNormal=date("Y-m-d h:i:s ",strtotime($FechaSQL));
		}
		else
		{
			$FechaHoraNormal="";
		}
		
		return $FechaHoraNormal;
	}
	
	function BuscarEnArreglo($Arreglo, $Buscar)
	{
		foreach ($Arreglo as &$valor) 
		{
			if($valor==$Buscar)
			{
				return true;
			}
		}
		
		return false;
	}	
	
	function ArregloSplit($Arreglo)
	{
		$Cadena="";
		for($Ite=0; $Ite<count($Arreglo); $Ite++) 
		{
			$Cadena.=$Arreglo[$Ite].";";
		}
		
		return $Cadena;
	}
	
	function ValidarSesion($Nivel)
	{
		if(!isset($_SESSION[$_SESSION['SiglasSistema'].'LOGIN'])) 
		{
			echo '
				<script>
					//alert("Disculpe su sesion a expirado, debe iniciar sesion nuevamente.");
					
					window.location="'.$Nivel.'index.php";
				</script>';	
			exit;
		}
		else
		{
			if($_SESSION[$_SESSION['SiglasSistema'].'BLOQUEADO']=="SI") 
			{
				echo '
					<script>						
						window.location="'.$Nivel.'PantallaBloqueado.php";
					</script>';	
				exit;
			}
		}
	}
	
	function Paginador($PagTotal, $PagActual, $Cantidad)
	{
		$CadPaginador='
		<div class="text-right" style="width:100%; margin-top:10px;">
			<div class="btn-group">';
		
		if($PagTotal>0)
		{
			if($PagActual>1)
			{
				$CadPaginador.='<input type="button" class="btn btn-ms btn-default" value="1" onClick="window.parent.PrimeraPagina()"/>';
				$CadPaginador.='<input type="button" class="btn btn-ms btn-default" value="<<"  onClick="window.parent.PaginaAtras('.$PagActual.')"></button>';
			}
			else
			{
				$CadPaginador.='<input type="button" class="btn btn-ms btn-default disabled" value="1" onClick="window.parent.PrimeraPagina()"/>';
				$CadPaginador.='<input type="button" class="btn btn-ms btn-default disabled" value="<<" onClick="window.parent.PaginaAtras('.$PagActual.')"/>';
			}   
			 
			for($i=$PagActual-$Cantidad;$i<$PagActual;$i++)
			{
				if ($i>=1)
				{
					$CadPaginador.='<input type="button"  class="btn btn-ms btn-default" value="'.$i.'" onClick="window.parent.AsignarPagina('.$i.')"/>';
				}
			} 
			
			for($i=$PagActual;$i<=$PagActual+$Cantidad;$i++)
			{
				if ($i<=$PagTotal)
				{
					if ($PagActual==$i)
					{
						$CadPaginador.='<input type="button" class="btn btn-ms btn-primary" value="'.$i.'" disabled="disabled"/>';
					}
					else
					{
						$CadPaginador.='<input type="button" class="btn btn-ms btn-default" value="'.$i.'" onClick="window.parent.AsignarPagina('.$i.')"/>';
					}
				}
			}
			
			if ($PagActual<$PagTotal)
			{
				$CadPaginador.='<input type="button"  class="btn btn-ms btn-default" value=">>" onClick="window.parent.PaginaSiguiente('.$PagActual.');"/>';
				$CadPaginador.='<input type="button" class="btn btn-ms btn-default" value="'.$PagTotal.'"  onClick="window.parent.ultimaPagina('.$PagTotal.')"/>';
			}else
			{
				$CadPaginador.='<input type="button" class="btn btn-ms btn-default disabled" value=">>"/>';
				$CadPaginador.='<input type="button" class="btn btn-ms btn-default disabled" value="'.$PagTotal.'"/>';
			}
		}
		
		$CadPaginador.='</div></div>';
		
		return $CadPaginador;
	}
	
	function ValidarUsuarioADNuevoDominio($UsuarioAD, $ClaveAD)
	{
		$host='10.50.10.50';
		$port=389;
		$dn="dc=bolipuertos,dc=gob,dc=ve";
		
		$sr=''; 
		$result=0;
		 
		$ds=ldap_connect($host, $port);  // conexion del Server LDAP
	
		if($ds) 
		{
			$sr=ldap_search($ds, $dn, "uid=".$UsuarioAD);  
			
			$info = ldap_get_entries($ds, $sr);
			
			for ($i=0; $i<$info["count"]; $i++) 
			{
				$displayname=$info[$i]["displayname"][0];
				$d=$info[$i]["dn"];
			}
			
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3); //Indico la version del protocolo
			
			$r=@ldap_bind($ds, $d, $ClaveAD); 
			
			if($r)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	function ValidarUsuarioADViejoDominio($UsuarioAD, $ClaveAD)
	{
		$ldaprdn = $UsuarioAD."@bppc.gob"; 
		$ds = "bppc.gob"; 
		$dn = "dc=bppc,dc=gob";  
		$puertoldap = 389; 
		
		$ldapconn = ldap_connect($ds, $puertoldap);
		
		ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION,3); 
		ldap_set_option($ldapconn, LDAP_OPT_REFERRALS,0); 
		
		$ldapbind = @ldap_bind($ldapconn, $ldaprdn, $ClaveAD); 
		
		if ($ldapbind)
		{
			$filter="(|(SAMAccountName=".trim($UsuarioAD)."))";			
			$fields = array("SAMAccountName"); 
			
			$sr = @ldap_search($ldapconn, $dn, $filter, $fields); 
			
			$info = @ldap_get_entries($ldapconn, $sr); 
			
			$NombreAD = $info[0]["samaccountname"][0];
			
			return true;
		}
		else
		{ 
		
			ldap_close($ldapconn); 
			
			return false;
		} 
	} 
	
	function LimpiaEspacios($cadena)
	{
		$cadena = str_replace(' ', '', $cadena);
		return $cadena;
	}

	function EnviarCorreo
	(
		$EmisorCorreo, 
		$EmisorNombre, 
		$EmisorCorreoResponder,
		$EmisorNombreResponder,
		$DestinatarioCorreo,
		$DestinatarioNombre,
		$Asunto,
		$Plantilla,
		$Nivel
	)
	{
		require($Nivel.'Includes/Plugins/PHPMailer-master/PHPMailerAutoload.php');
		
		$PHPMailer 	=	new PHPMailer;												// Create a new PHPMailer instance		
		$PHPMailer	->	isSendmail();												// Set PHPMailer to use the sendmail transport		
		$PHPMailer	->	IsSMTP();                           						// Usamos el metodo SMTP de la clase PHPMailer
		$PHPMailer	->	SMTPDebug  = 0;                    	 						// enables SMTP debug information (for testing)
														   							// 1 = errors and messages
														   							// 2 = messages only
		$PHPMailer 	-> 	CharSet 	= 	'UTF-8'; 									// Activo condificacción utf-8
		$PHPMailer	->	SMTPAuth	=	true;                  						// habilitado SMTP autentificación
		//$PHPMailer	->	SMTPSecure	=	"tls";                 						// sets the prefix to the servier
		$PHPMailer	->	Port		=	25;                    						// puerto del server SMTP
		$PHPMailer	->	Host		=	"190.9.128.50"; 							// SMTP server
		$PHPMailer	->	Username   	=	"ssp@bolipuertos.gob.ve";					// SMTP server Usuario
		$PHPMailer	->	Password   	=	"0123456789";          						// SMTP server password		
		$PHPMailer	->	Subject 	=	$Asunto;									// Establecer el asunto del mensaje
		$PHPMailer	->	setFrom($EmisorCorreo, $EmisorNombre);						// Establecer desde donde será enviado el correo electronico
		$PHPMailer	->	addReplyTo($EmisorCorreoResponder, $EmisorNombreResponder); // Establecer una direccion de correo electronico alternativa para responder
		$PHPMailer	->	addAddress($DestinatarioCorreo, $DestinatarioNombre);		// Establecer a quien será enviado el correo electronico
		$PHPMailer	->	msgHTML(file_get_contents($Plantilla));						// convertir HTML dentro del cuerpo del mensaje
		
		if (!$PHPMailer->send()) 													// send the message, check for errors
		{
			$Arreglo["RESULTADO"]	=	0;
			$Arreglo["MSJ_ERROR"]	=	$PHPMailer->ErrorInfo;
		}
		else 
		{
			$Arreglo["RESULTADO"]	=	1;
		}
		
		return $Arreglo;
	}

	function construirBreadcrumbs($vID_MODULO){
		$CONECTOR=Conectar();
		
		$vSQL="EXEC SP_CONSTRUIR_BREADCRUMS $vID_MODULO";
		
		$ResultadoEjecutar=$CONECTOR->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
		
		$CONEXION=$ResultadoEjecutar["CONEXION"];
		$ERROR=$ResultadoEjecutar["ERROR"];
		$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
		$RESULTADO=$ResultadoEjecutar["RESULTADO"];
		
		if($CONEXION=="SI" and $ERROR=="NO")
		{	
			$breadcrumbs='
						<ol class="breadcrumb">			  
							<li>								
								<a href="./">
									<i class="fa fa-home"></i> 
									<strong>Inicio</strong>
								</a>
							</li>';
					
			while($REGISTROS=odbc_fetch_array($RESULTADO))
			{				
				$NIVEL			=	$REGISTROS["NIVEL"];
				$ID_MODULO		=	$REGISTROS["ID_MODULO"];
				$ID_MODULO_P	=	$REGISTROS["ID_MODULO_P"];
				$NB_MODULO		=	utf8_encode($REGISTROS["NB_MODULO"]);
				$RUTA			=	$REGISTROS["RUTA"];
				$ICONO			=	$REGISTROS["ICONO"];
			
				if($vID_MODULO==$ID_MODULO)
				{
					$breadcrumbs.='
							<li class="active">
								<a href="javascript:" onClick="AbrirModulo(\'MenDes'.$ID_MODULO.'\', \''.$NB_MODULO.'\', \''.$RUTA.'\')">
									<i class="fa fa-'.$ICONO.'"></i> 
									<strong>'.$NB_MODULO.'</strong>
								</a>
							</li>';
				}
				else
				{
					$breadcrumbs.='
							<li>
								<i class="fa fa-'.$ICONO.'"></i> '.$NB_MODULO.'
							</li>';
				}
			}
      		
			$breadcrumbs.='
						</ol>';	
		
			$CONECTOR->Cerrar();
			
			return $breadcrumbs;
		}
		else
		{		
			echo '
					<script>
						alert("'.$MSJ_ERROR.'");
					</script>
				';
		
			$CONECTOR->Cerrar();
			
			exit;
		}
	}
?>
