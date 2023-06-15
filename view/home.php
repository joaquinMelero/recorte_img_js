<?php
include_once 'view/templates/head.php';
?>

<body>

    <h1>Procesador de documentos</h1>

    <div id="container">

        <!-- Formulario para que el usuario cargue el documento. Se envía al método que procesa la imagen dentro del controlador
            <form action="index.php?controller=process_controller&action=process" method="POST" enctype="multipart/form-data">-->

    <div id="form_doc_div">    
        <fieldset>
            <legend>Plataforma de documentación</legend>
            <form id="form_doc" method="post" enctype="multipart/form-data" name="form">
                <label>Sube el documento: </label> <input type="file" id="document_input" name="doc" multiple>
            </form>
        </fieldset>
    </div>


        <br>

        <!-- Si existe un documento cargado en el input lo muestra-->
        <div id="div_recorte" style="display: block;">
            <div id="temp_img_div">
                <div id="h2_recorta" class="visibility">
                    <h2>Recorta el documento</h2>
                </div>
            </div>
        </div>

        <br>
        <br>
        <!--se puede utilizar para dibujar gráficos a través de secuencias de comandos EN JS -->
        <canvas id="canvasJCrop"></canvas><!--dibujo el recorte-->
        <span id="measures"></span><!--muestro medidas-->

        <br>

        <button id="btnSend" type="submit" class="visibility btn_save" value="subir" name="up"> Guardar Recorte</button><!--al pulsar el boton js para guardar en el servidor-->

    </div>

    <?php
    include_once 'view/templates/footer.php';
    ?>