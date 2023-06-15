<?php
/* 
 * Clase para guardar el documento recibido por file. Las propiedades son las características del documento.
 * Propiedades: 
 * imagesx — Obtener el ancho de una imagen
 * imagesy — Obtener el alto de una imagen
 * imagescale — Redimensiona una imagen usando un nuevo ancho y alto
 * imagerotate — Rotar una imagen con un ángulo dado
 * imagerectangle — Dibuja un rectángulo
 * imagecrop — Recorta una imagen usando las coordenadas, el tamaño, x, y, ancho y alto dados
 * imagecopyresampled — Copia y cambia el tamaño de parte de una imagen redimensionándola
 * imagecopyresized — Copia y cambia el tamaño de parte de una imagen
 * image_type_to_extension — Obtiene la extensión de un tipo de imagen
 * image_type_to_mime_type — Obtiene el tipo Mime de un tipo de imagen devuelto por getimagesize, exif_read_data, exif_thumbnail, exif_imagetype
 * 
 * 
 */


 class document_model{

    private $document_name; //nombre del docuemto
    private $document_url; //ubicación del documento en el servidor

    public function __construct($name , $url) {

        $this->document_name = $name;
        $this->document_url =$url;
		
	}


    /*Método toString*/
    public function toString(){
        echo 'Mombre docuemnto: '.$this->document_name . ' Ubicación: '. $this->document_url;
    }


    /*Método que crea una imagen GD para trabajar con la extensión GD*/
    public function create_img_GD(){
        
        $img = imagecreatefromjpeg($this->document_url);

        return $img;
    }





 }