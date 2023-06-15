/**
 * Código js que se ejecuta al pulsar el botón de Guardar Recorte. Con ajax llama al método del controlador que guarda una copia de la imagen en el servidor
 * y te redirecciona a la pantalla que te hace una previsualización del doc recortado y te da la opción de descargar en pdf o img
 */


$(document).ready(function () {

    //cuando clic en el btn
    $('#btnSend').on('click', function(){

        //convierto el canvas en img jpeg
       let img_canvas =  document.getElementById('canvasJCrop');
       let dataURL = img_canvas.toDataURL('image/jpeg', 1.0); //devuelve un data URI, 1.0 parámetro para mas calidad - image/jpeg formato


        //mando la ubicaciónde la imagen al método que la guarda en el servidor
        $.ajax({
            
            // la URL para la petición
            url : 'index.php?controller=process_controller&action=process',

            // path donde se encuentra la img
            data : {path_img: dataURL},

            // especifica si será una petición POST o GET
            type : 'POST',

            // código a ejecutar si la petición es satisfactoria
            success : function(data) {
                
                location.href ='index.php?controller=process_controller&action=viewPage1';
            },
            
            error: function(){
                alert('error');
            }

        });


    });
});