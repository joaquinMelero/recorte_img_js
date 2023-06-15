/**
 * con este código js el usuario recorta el documento a la medidia que cree correcto.
 * Se activa cuando se sube la imagen.
 */

$(document).ready(function () {

    //si se produce un cambio en el documento
    $(document).change(function () {

        //con find busco los elemtos img. si es mayor a cero es que hay imagen
        let element_img = $('#temp_img_div').find('img');

        if (element_img.length > 0) {//si hay alguna img se habilita la opción recorte

            //guardo los elementos del dom en variables
            let canvas = document.getElementById('canvasJCrop'), // etiqueta html para dibujar gráficos a través de secuencias de comandos
                img = document.getElementById('doc_0'), //elemento img
                measures = document.getElementById('measures'); //donde se mostraran las medidas

            //método que recibe las coordenadas del recorte de una imagen y dibuja una nueva imagen en etiqueta canvas.
            function cutOnCanvas(coords) {

                var context = canvas.getContext('2d'); //getContext devuelve un contexto de dibujo en el canvas. "2d", dando lugar a la creación de un objeto renderizado a dos dimensiones

                canvas.width = coords.w; //guardo el largo del recorte
                canvas.height = coords.h; //guardo el ancho del recorte

                if (canvas.width > 200 || canvas.height > 200) {//pongo un mínimo para que el usuario no haga recortes incoherentes 

                    //hago visisible botón de guardar recorte
                    $('#btnSend').removeClass('visibility');

                    //método para dibujar la imagen en el canva. Parámetros: img a recortar y las coordenadas coords
                    context.drawImage(img, coords.x, coords.y, coords.w, coords.h, 0, 0, coords.w, coords.h);

                } else {
                    alert('recorte muy pequeño...min:200x200!!');
                }

                measures.innerText = "width: " + canvas.width + " height: " + canvas.height; //muestro las medidas

            }

            //Jcrop es un plugin para jQuery que nos permite seleccionar de forma visual un área de una imagen
            $("#doc_0").Jcrop({
                onSelect: cutOnCanvas, //evento onSelect para llamar a una funcion
            });

        }

    });


});