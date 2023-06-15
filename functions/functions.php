<?php

/* archivo para definir métodos puntuales*/

//método para mostrar el contenido de la carpeta del servidor dociment_temp
function show_temp_doc()
{
    //guardo la dirección del directorio
    $dir = "temp_document";
    
    // Abre un directorio conocido, y procede a leer el contenido
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) { //mientras hay archivos
                if ($file != "." && $file != ".." && validaFormatoImg($file)) { //archicos distintos de . y .. y con extensión adecuada

                    if (!empty($file)) {

                        echo "<a id='recorte'><img src ='" . $dir . "/" . $file . "'></a>"; 
                    }

                    $file = readdir($dh); //lee archivo dentro del directorio
                }
            }
            closedir($dh); //cierra el directorio 
        }
    }
}

//función que valida el formato de imagen .jpg, .png, bmp o .gif. Devuelve true o false
function validaFormatoImg($archivo)
{

    return preg_match("([^\\s]+(\\.(?i)(jpe?g|png|gif|bmp))$)", $archivo);
}
