# recorte_img_js
App web recorte img.

Esta aplicación web solicita al usuario un documento.

Plan: 
    1-El usuario sube un documento.
        1.1- Se comprueba la extensión .
    
    2- Se muestra en el home el jpeg  para que el usuario realice un recorte si es necesario. 

    3- Una vez recortado,se guarda el recorte, se muestra una pantalla donde se ve el documento recortado 
    
    4- Se firma el docuemnto y se muestran las opciobnes de descargar el docuumento en jpeg 
    
Estructura proyecto: 

1-Index: En este fichero recibiremos todas las peticiones para el controlador process_controller. Ej: cargar la vista.
Llamaremos al archivo index.php, pasándole como parámetros el nombre del controlador y la acción que necesitamos.
Será el propio controlador el que decida que vista se va a cargar, según las que tengamos definidas.

2-Home: vista inicial de la app, html con form para subir los documentos que se quieran adecuar a formato

3-Page1: Muestra el documento con el formato estándar para la empresa, la firma y da opción de descargar copia al usuario
