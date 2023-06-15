/*código para mostrar la imagen cargada en el input file. 
* Compruebo si existe $_File en el método del controlador y devulevo desde ese método la ubicación o url 
* Una vez obtenida la url añado al div del dom la imagen para que la muestre
*/

//ejecuta las funciones una vez cargada totalmente la página web(DOM)
$(document).ready(function () {

    //si se produce un cambio en el input file es que se ha subido un documento
    $('#document_input').change(function () {

        var imagen = document.getElementById("document_input").files;//guardo el input file

        let ext = $(this).val().split('.').pop();//guardo la extensión del documento subido 

        //si la extensión es pdf lo convierto antes de mostrarla
        if (ext == 'pdf') {

            pdf_converted_js(); //

        } else {


            min_size(imagen[0]);//accedo al primer elemento


            // Los docuementos subidos, pueden ser muchos o uno
            const docs = this.files; //files es una propiedad de input que contiene los archivos seleccionados por el usuario. this es input

            for (let i = 0; i < docs.length; i++) {

                // cast a objectURL
                const objectURL = URL.createObjectURL(docs[i]);

                $('#temp_img_div').append('<img id="' + this.name + '_' + i + '" src="' + objectURL + '">');//añado la img

            }

        }

    });
});


//await palabra clave hace que la función pause la ejecución y espere una promesa resuelta antes de continuar
//la función a pausar es min_size que espera la promesa resuelta que es load Image
//método para validar el tamaño mínimo.  

async function min_size(imagen) {
    const result = await loadImage(imagen);

    // Aquí ya tendríamos acceso al resultado

    if(result.ancho<400 || result.alto<300){

        alert('documento muy pequeño!...Suba un nuevo documento');

        location.href ='index.php?controller=process_controller&action=index';

    }else if(result.ancho>800 || result.alto>800){//si es demasiado grande la redimensiono

        resize();
    
    }

    //muestro el título de recorte
    $('#h2_recorta').removeClass('visibility');
    
}

//método que devulve el anchoxalto de una img. Creo objeto Image y accedo a sus propiedades
async function loadImage(imagen) {
    let obj = new Object();

    let _URL = window.URL || window.webkitURL;
    let img = new Image(); // devuelve un HTMLImageElement instanciado justo como document.createElement('img')
    img.src = _URL.createObjectURL(imagen);
    img.onload = function () {
        obj.ancho = img.width;
        obj.alto = img.height;


        //array asociativo para guardar las medidas. JS no tiene asociativos utiliza objetos literales
    }

        alert('documento subido!');


    return obj;

}

//método para convertir pdf a jpeg. Llamo al controlador por ajax y me devuleve el archivo convertido
function pdf_converted_js() {

    var formData = new FormData(document.getElementById("form_doc")); //guardo el form que enviare al controlador php

    //mando la ubicaciónde la imagen al método que la guarda en el servidor
    $.ajax({

        // la URL para la petición
        url: 'index.php?controller=process_controller&action=pdf_converted',

        type: "post",

        dataType: "html",

        data: formData,

        cache: false,

        contentType: false,

        processData: false,


        // código a ejecutar si la petición es satisfactoria
        success: function (data) {

           alert('Hay que instalar extensión php Imagick!!!!')
        },

        error: function () {
            alert('error');
        }

    });
}




//método para redimensionar cuando es mas grande del estándar
function resize(){

  //  $('img').attr('width', '600px');

}

