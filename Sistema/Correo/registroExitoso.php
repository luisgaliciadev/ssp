<?php		
	$Nivel="../../";
	include($Nivel."Includes/PHP/funciones.php");
	
	session_start();

	$LOGIN		      =	utf8_decode($_GET["LOGIN"]);
	$RAZON_SOCIAL		=	utf8_decode($_GET["RAZON_SOCIAL"]);
	$CLAVE		      =	utf8_decode($_GET["CLAVE"]);
	
  $RAZON_SOCIAL		=	str_replace('+', ' ', $RAZON_SOCIAL);
  $CLAVE		      =	str_replace('+', ' ', $CLAVE);
  

	if(IpServidor()!="10.10.30.52")
		$RAIZ="http://www.zonalotto.com/";
	else
    $RAIZ="http://10.10.30.52/SASPWEB/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Narrative Confirm Email</title>
  <style type="text/css">

  /* Take care of image borders and formatting */

  img {
    max-width: 600px;
    outline: none;
    text-decoration: none;
    -ms-interpolation-mode: bicubic;
  }

  a {
    border: 0;
    outline: none;
  }

  a img {
    border: none;
  }

  /* General styling */

  td, h1, h2, h3  {
    font-family: Helvetica, Arial, sans-serif;
    font-weight: 400;
  }

  td {
    font-size: 13px;
    line-height: 150%;
    text-align: left;
  }

  body {
    -webkit-font-smoothing:antialiased;
    -webkit-text-size-adjust:none;
    width: 100%;
    height: 100%;
    color: #37302d;
    background: #ffffff;
  }

  table {
    border-collapse: collapse !important;
  }


  h1, h2, h3 {
    padding: 0;
    margin: 0;
    color: #0b9354;
    font-weight: 400;
    line-height: 110%;
  }

  h1 {
    font-size: 35px;
  }

  h2 {
    font-size: 30px;
  }

  h3 {
    font-size: 24px;
  }

  h4 {
    font-size: 18px;
    font-weight: normal;
  }

  .important-font {
    color: #21BEB4;
    font-weight: bold;
  }

  .hide {
    display: none !important;
  }

  .force-full-width {
    width: 100% !important;
  }

  </style>

  <style type="text/css" media="screen">
      @media screen {
        @import url(http://fonts.googleapis.com/css?family=Open+Sans:400);

        /* Thanks Outlook 2013! */
        td, h1, h2, h3 {
          font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif !important;
        }
      }
  </style>

  <style type="text/css" media="only screen and (max-width: 600px)">
    /* Mobile styles */
    @media only screen and (max-width: 600px) {

      table[class="w320"] {
        width: 320px !important;
      }

      table[class="w300"] {
        width: 300px !important;
      }

      table[class="w290"] {
        width: 290px !important;
      }

      td[class="w320"] {
        width: 320px !important;
      }

      td[class~="mobile-padding"] {
        padding-left: 14px !important;
        padding-right: 14px !important;
      }

      td[class*="mobile-padding-left"] {
        padding-left: 14px !important;
      }

      td[class*="mobile-padding-right"] {
        padding-right: 14px !important;
      }

      td[class*="mobile-block"] {
        display: block !important;
        width: 100% !important;
        text-align: left !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        padding-bottom: 15px !important;
      }

      td[class*="mobile-no-padding-bottom"] {
        padding-bottom: 0 !important;
      }

      td[class~="mobile-center"] {
        text-align: center !important;
      }

      table[class*="mobile-center-block"] {
        float: none !important;
        margin: 0 auto !important;
      }

      *[class*="mobile-hide"] {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
        line-height: 0 !important;
        font-size: 0 !important;
      }

      td[class*="mobile-border"] {
        border: 0 !important;
      }
    }
  </style>
</head>
<body class="body" style="padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none" bgcolor="#ffffff">
<table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%">
  <tr>
    <td align="center" valign="top" bgcolor="#ffffff"  width="100%">

    <table cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td style="background:#00A65A" width="100%">
          <center>
            <table cellspacing="0" cellpadding="0" width="600" class="w320">
              <tr>
                <td valign="top" class="mobile-block mobile-no-padding-bottom mobile-center" width="270" style="background:#00A65A;padding:10px 10px 10px 20px;">
                  <a href="#" style="text-decoration:none;">
                    <img src="https://www.filepicker.io/api/file/X9R4FqRPaEIS3vMxFXgl" width="142" height="30" alt="Your Logo"/>
                  </a>
                </td>
                <td valign="top" class="mobile-block mobile-center" width="270" style="background:#00A65A;padding:10px 15px 10px 10px">
                  <table border="0" cellpadding="0" cellspacing="0" class="mobile-center-block" align="right">
                    <tr>
                      <td align="right">
                        <a href="#">
                        <img src="http://keenthemes.com/assets/img/emailtemplate/social_facebook.png"  width="30" height="30" alt="social icon"/>
                        </a>
                      </td>
                      <td align="right" style="padding-left:5px">
                        <a href="#">
                        <img src="http://keenthemes.com/assets/img/emailtemplate/social_twitter.png"  width="30" height="30" alt="social icon"/>
                        </a>
                      </td>
                      <td align="right" style="padding-left:5px">
                        <a href="#">
                        <img src="http://keenthemes.com/assets/img/emailtemplate/social_googleplus.png"  width="30" height="30" alt="social icon"/>
                        </a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </center>
        </td>
      </tr>
      <tr>
        <td style="border-bottom:1px solid #e7e7e7;">
          <center>
            <table cellpadding="0" cellspacing="0" width="600" class="w320">
              <tr>
                <td align="left" class="mobile-padding" style="padding:20px">

                  <br class="mobile-hide" />

                  <h2>¡Te damos la bienvenida a Bolivariana de Puertos, S.A.!</h2>
                  <br>
                  <p>
                    Hola <?php echo $RAZON_SOCIAL;?>, ya se creó tu cuenta:                  
                  </p>
                  <br>
                  <p>
                    <strong>Login:</strong> <?php echo $LOGIN;?>                  
                  </p>
                  <p>
                    <strong>Contraseña:</strong> <?php echo $CLAVE;?>                  
                  </p>
                  <br>
                  <p>
                    A partir de ahora puedes ingresar a nuetra app SSP.                  
                  </p>
                  <br>                    
                  <br>  
                </td>
                <td class="mobile-hide" style="padding-top:20px;padding-bottom:0; vertical-align:bottom;" valign="bottom">
                  <table cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                      <td align="right" valign="bottom" style="padding-bottom:0; vertical-align:bottom;">
                        <img  style="vertical-align:bottom;" src="https://www.filepicker.io/api/file/9f3sP1z8SeW1sMiDA48o"  width="174" height="294" />
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </center>
        </td>
      </tr>
      <tr>
        <td valign="top" style="background-color:#f8f8f8;border-bottom:1px solid #e7e7e7;">

          <center>
            <table border="0" cellpadding="0" cellspacing="0" width="600" class="w320" style="height:100%;">
              <tr>
                <td valign="top" class="mobile-padding" style="padding:20px;"><table cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                      <td style="padding-top:50px;">Bolivariana de Puertos, S.A. y app SSP para optimizar las solicitudes de servicios.</td>
                    </tr>
                </table>
                </td>
              </tr>
            </table>
          </center>
        </td>
      </tr>
      <tr>
        <td style="background-color:#00A65A;">
          <center>
            <table border="0" cellpadding="0" cellspacing="0" width="600" class="w320" style="height:100%;color:#ffffff" bgcolor="#00A65A" >
              <tr>
                <td align="right" valign="middle" class="mobile-padding" style="font-size:12px;padding:20px; background-color:#00A65A; color:#ffffff; text-align:left; ">
                  <a style="color:#ffffff;"  href="#">Contactanos</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                  <a style="color:#ffffff;" href="#">Facebook</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                  <a style="color:#ffffff;" href="#">Twitter</a>
                </td>
              </tr>
            </table>
          </center>
        </td>
      </tr>
    </table>

    </td>
  </tr>
</table>
</body>
</html>
