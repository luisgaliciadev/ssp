<?php
if (isset($_FILES["file"]))
{
    $file = $_FILES["file"];
    $nombre = $file["name"];
    $tipo = $file["type"];
    $ruta_provisional = $file["tmp_name"];
    $size = $file["size"];
    $dimensiones = getimagesize($ruta_provisional);
    $width = $dimensiones[0];
    $height = $dimensiones[1];
    $carpeta = "Sistema/imagenes/";

    if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif')
    {
      echo "Error, el archivo no es una imagen"; 
    }
    else if ($size > 5500*5500)
    {
      echo "Error, el tamaño máximo permitido es un 1MB";
    }
    else if ($width > 5500 || $height > 5500)
    {
        echo "Error la anchura y la altura maxima permitida es 500px";
    }
    else if($width < 60 || $height < 60)
    {
        echo "Error la anchura y la altura mínima permitida es 60px";
    }
    else
    {
        $src = $carpeta.$nombre;
        copy($ruta_provisional, $src);
        echo "<img src='$src'>";
    }
}
?>