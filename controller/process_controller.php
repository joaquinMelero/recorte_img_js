<?php
//Archivo para lógica de control. Intermediario entre view y model, se encarga de indicar a la vista y al modelo como deben actuar a continuación.

require_once 'model/document_model.php';

class process_controller
{

    public $page_title; //atributo para guardar el título de la acción (dinámico)
    public $view; // atributo para guardar la vista 
    public $documentObj; //atributo para guardar el objeto Documento

    public function __construct()
    {

        $this->page_title = "";
        $this->view = "home";
    }

    /* método para mostrar el título de la página */
    public function index()
    {

        $this->page_title = 'Procesador de documentos';

        require('view/home.php');
    }

    /*método par cargar la vista Page1*/
    public function viewPage1()
    {

        $this->page_title = 'Descarga de documentos';

        $this->view = "page1";
    }

    /*método que comprueba si es un archivo pdf, lo mueve al servidor  y lo convierte a jpg. Recibe por ajax el form*/
    public function pdf_converted()
    {

        //1-la comprobación pdf se hace en js

        //2-muevo el pdf al servidor 
        $origen = $_FILES["doc"]["tmp_name"];

        $carpetaDestino = 'temp_document/' . $_FILES["doc"]["name"];

        // movemos el archivo a la carpeta temp
        move_uploaded_file($origen, $carpetaDestino);

        //3-convierto el pdf a jpeg con Imagick
        
        $archivo = 'temp_document/' . $_FILES["doc"]["name"]; //nombre del pdf
        $img_path = 'temp_document/pdf.jpeg'; //ruta temporal para guardar el jpg

        
    // Convertir el PDF a JPEG
    $imagick = new Imagick();
    $imagick->readImage($archivo);
    $imagick->setImageFormat('jpeg');
    $imagick->writeImage($img_path);
    $imagick->destroy();

    
    unlink('temp_document/' . $_FILES["doc"]["name"]);//borro el archivo subido
      

    }

    /* método que recibe desde ajax la ubicación del doc en un directorio temporal del disco duro*/
    public function process()
    {

        //Recogemos el canvas enviado por el formulario
        $path_temp = substr($_POST['path_img'], 23); //filtro el contenido para decodificarlo
        $archivo = 'recorte.jpeg'; //nombre edl doc guardado en el servidor

        //decodificar de base64
        $path_temp = base64_decode($path_temp);

        //ruta del servidor donde guardar el recorte
        $path = 'temp_document/' . $archivo;

        // guardamos la imagen en el server
        if (!file_put_contents($path, $path_temp)) {
            // retorno si falla
            echo 'Archivo no subido a carpeta temp_document';
            return false;
        }
    }


    //método que recibe la ubicación de la firma como img jpeg y la une al recorte del servidor.
    //Marca de agua con libreria GD 
    public function join_doc()
    {

        $archivo = 'firma.png'; //nombre del doc guardado en el servidor

        $path_temp = substr($_POST['path_img'], 22); //filtro el contenido para decodificarlo. Guardo solo la ruta


        //ruta del servidor donde guardar la firma
        $rutaMarcaAgua = 'temp_document/' . $archivo;

        //decodificar de base64
        $path_temp = base64_decode($path_temp);


        //muevo la firma a la carpeta temp_document
        file_put_contents($rutaMarcaAgua, $path_temp);

        // Imagen base
        $abajo = imagecreatefromjpeg("temp_document/recorte.jpeg");
        // Imagen a superponer
        $arriba = imagecreatefrompng("temp_document/firma.png");

        $transp = imagecolorallocate($arriba, 0, 0, 0);

        // Hacer el fondo transparente
        imagecolortransparent($arriba, $transp);

        // Superponemos imagenes
        //0-Coordenada x del punto de destino
        //0-Coordenada y del punto de destino
        //0-Coordenada x del punto de origen. 
        //0 Coordenada y del punto de origen. 
        //220-Ancho original.
        //170-Alto original.
        imagecopy($abajo, $arriba, 0, 0, 0, 0, 220, 170);

        //muevo la imagen a temp y elimino las otras
        imagepng($abajo, "temp_document/firma_ok.png");
        unlink("temp_document/firma.png");
        unlink("temp_document/recorte.jpeg");

        // Liberamos memoria
        imagedestroy($abajo);
        imagedestroy($arriba);
    }


    /*método que detecta la orientación del documento y la corrige. Imagick
    1-Primero optimizamos la calidad de la imagen. 
        1.1 Recortar las imágenes, 
        1.2 corregir la perspectiva
        1.3  Mejorar el contraste. 
    Esto ya proporciona imágenes más legibles
    2-Convertir los documentos y las imágenes en texto. Si es PDF, se convierte en imagen y luego en texto. Esto crea un documento que permite realizar búsquedas y revela cuál es la orientación del texto.
    3-El documento debe ser rotado de manera que se pueda leer de izquierda a derecha para la mayoría de los idiomas
    */
    public function orientation()
    {
    }



    /*Método que extrae texto de una imagen co Tesseract OCR*/
}
