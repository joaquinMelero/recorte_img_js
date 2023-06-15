
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


?>
<?php

/*
directorio raíz que se encarga de gestionar la aplicación y las diferentes peticiones de rutas de los controladores
*/

require_once 'controller/process_controller.php';

//defino por defecto el controlador y acción(vista) (parámetros)
define("DEFAULT_CONTROLLER", "process_controller");
define("DEFAULT_ACTION", "index");


//si se carga un controller inyectado por url
if (isset($_GET['controller'])) { 

    $controllerPath = 'controller/' . $_GET['controller'] . '.php'; //la url

    require_once $controllerPath;

    $controller = new $_GET['controller']; //se crea un objeto controlador con el nombre guardado

    $dataToView["data"] = array();

    if (method_exists($controller, $_GET['action'])) { //si el controlador se ha creado llamo a la acción que carga la vista

        $dataToView["data"] = $controller->{$_GET["action"]}();//array para guardar la información del controller

        require_once 'view/' . $controller->view . '.php';
    }

} else {  //si no entra el nombre controlador por url cargo los default de config 

    $controllerPath = 'controller/' . constant("DEFAULT_CONTROLLER") . '.php';

    require_once $controllerPath;

    $classController = DEFAULT_CONTROLLER; //controlador por defecto

    $controller = new $classController;

    $dataToView["data"] = array();//array para guardar la información del controller
    
    if (method_exists($controller, constant("DEFAULT_ACTION"))) {//si el controlador se ha creado llamo a la acción que carga la vista

        $dataToView["data"] = $controller->{constant("DEFAULT_ACTION")}();

        require_once 'view/' . $controller->view . '.php';
    }

}
    

?>