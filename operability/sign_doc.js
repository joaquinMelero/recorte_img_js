/*código para habilitar la firma con ratón al documento

layerX es igual que x. Un número que especifica bien la altura del objeto cuando es pasado con el evento resize o 
la posición vertical del cursor en pixels relativa al layer en el que ha ocurrido el evento. layerY es igual que y. 
*/


//declaro las variables como globales
var mousePressed = false;
var lastX, lastY;
var context;

//ejecuta las funciones una vez cargada totalmente la página web(DOM)
$(document).ready(function () {

    //si existe el elemento img
    if ($('img').length) {


        //obtener el nombre de la img de carpeta temp_documents. solo tengo una, no utilizo id
        let element_img = $('img').attr('src');

        //si está en el servidor la imagen correcta oculto el botón de firmar y habilito la descarga
        if (element_img.substring(20, 40) == 'ok.png') {
            $('#btn_sign').addClass('visibility');
            $('#btn_down').removeClass('visibility');
        }


        //si se produce un clic en el botón firmar
        $('#btn_sign').on('click', function () {

            $('#sign_div').removeClass('visibility');//se hace visible la firma

            let canvas = document.getElementById('canvas'); //guardo el elemento canvas
            context = canvas.getContext('2d');//getContext devuelve un contexto de dibujo en el canvas. "2d", dando lugar a la creación de un objeto renderizado a dos dimensiones

            //método que dibuja la firma enel canvas
            sign_document(canvas);

            //si pulsas en el boton de volver a firmar
            $('#btn_clear').on('click', function () {
                resetCanvas();
            });


            //si pulsas en el boton guardar firma
            $('#btn_save').on('click', function () {
                //método para unir la firma al documento
                save_sign(canvas);
            });


        });

    }

});


//código para pintar en el elemento canvas. Se hace con eventos. 
//Para obtener las posiciones relativas del mouse al elemento canvas (propiedades layerX y layerY), canvas tiene que tener estilo relativo
function sign_document(canvas) {

    //evento cuando se presiona con el raton en un elemento
    canvas.onmousedown = function (e) {
        draw(e.layerX, e.layerY);
        mousePressed = true; //guardo el estado del ratón presionado
        console.log(mousePressed);
    };

    //si se mantiene pulsado el ratón sigue dibujando todas las cordenadas por donde se va moviendo el raton dentro del cnavas
    canvas.onmousemove = function (e) {
        if (mousePressed) {
            draw(e.layerX, e.layerY);
        }
    };

    //evento que controla cuando se deja de presionar el ratón y pasa a falso la variable que controla el estado del ratón
    canvas.onmouseup = function (e) {
        mousePressed = false;
    };

    //evento ocurre cuando el puntero del mouse deja un elemento. controlar que se sale el canvas
    canvas.onmouseleave = function (e) {
        mousePressed = false;
    };

}

//métod para dibujar las lineas continuas minetras esté el ratón pulsado
function draw(x, y) {
    if (mousePressed) {
        context.beginPath(); //método para decirle al contexto del canvas que vamos a empezar a dibujar un camino
        context.strokeStyle = document.getElementById('color').value;//utilizo el color que ha seleccionado el usurio en el input
        context.lineWidth = 1;//grosor de la linea
        context.lineJoin = 'round';//ripo linea
        context.moveTo(lastX, lastY);//método para mover el puntero imaginario donde comenzaremos a hacer el camino. Recibe como parámetros los puntos x e y donde ha de moverse el puntero para dibujo
        context.lineTo(x, y);//método para dibujar una línea recta, desde la posición actual del puntero de dibujo, hasta el punto (x,y) que se pasan como parámetros
        context.closePath(); //cerrar el camino 
        context.stroke(); //método que realmente dibuja el camino definido con moveTo() y lineTo()
    }
    lastX = x; lastY = y; //se actuliza la posición al último punto donde se mueve le ratón
}

//método para resetaear el canvas al pulsar en el boton volver a firmar
function resetCanvas() {

    //context.fillStyle = '#ff0000'; //se actualiza el color del canvas a blanco
    context.fillRect(0, 0, canvas.width, canvas.height); //dibuja un rectángulo relleno en la posición ( x, y )
}

//método para firmar el documento. recibe el elemento canvas. Llama al método join_doc del controlador que:
//1-convierte la firma (canvas a jpeg)
//2- une con GD la firma como marca de agua al recorte del servidor
//3-muestra el doc firmado
function save_sign(img_canvas) {

    let dataURL = img_canvas.toDataURL('image/png', 1.0); //devuelve un data URI, 1.0 parámetro para mas calidad - image/jpeg formato

    //mando la ubicaciónde la imagen al método que la une a la imagen del documeno del servidor
    $.ajax({

        // la URL para la petición
        url: 'index.php?controller=process_controller&action=join_doc',

        // path donde se encuentra la img
        data: { path_img: dataURL },

        // especifica si será una petición POST o GET
        type: 'POST',

        // código a ejecutar si la petición es satisfactoria
        success: function (data) {

            location.href = 'index.php?controller=process_controller&action=viewPage1';

        },

        error: function () {
            alert('error');
        }

    });


}