<!--fichero que muestra el documento que se ha subido a carpeta temp_document modificado con las especificaciones requeridas 
y te da la opción de descargarlo-->

<?php
include_once 'view/templates/head.php';
require_once 'functions/functions.php';
?>


<body>

  <h1>Descarga de documentos</h1>

  <div id="container">

  <!--muestra los documento guardados en el servidor ya recortados-->
    <?php show_temp_doc(); ?>

    <button id="btn_down" class="visibility"><a href="temp_document/firma_ok.png" download="doc_recortado">Descargar JPEG</a></button><!--al pulsar el boton js para guardar en el servidor-->

    <p><button id="btn_sign" >Firmar Documento</button></p><!--al pulsar se habilita la firma-->

    <!--espacio para firmar-->
    <div id="sign_div" class="visibility">

      <canvas id="canvas" class="canvas" width="250" height="180"></canvas>

      <div class="option_sign">
        <input type="color" id="color" value="#FF9200" style="width: 2em; height: 1.2em;">
        <button id="btn_clear">Repetir Firma</button>
        <button id="btn_save">Guardar Firma</button>
      </div>

    </div>

  </div>



  <?php
    include_once 'view/templates/footer.php';
    ?>