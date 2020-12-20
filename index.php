<?php
ob_start();
// inicio sesion, va a mostrarme si se guardo el usuario bien
session_start();

// uso el autoload para cargar todos los controllers
require_once 'autoload.php';

// traigo los parameters
require_once 'config/parameters.php';
// traigo los helpers
require_once 'helpers/utils.php';
// traigo la base de datos, recordar que ya dentro de esa clase no es solo que crea la variabe que conecta sino que tambien usa return para conectarla
require_once 'config/db.php';


// traigamos algunos layouts

// los productos los pongo desde producto controller, index que me muestra los products, luego esa url que tambien me muestra
// los productos destacados va a ser mi pagina principal
// podria sino directamemte haber usado require_once con los products tambien

// nosotros vamos a subir a la url info sobre el controlador, la clase y el metodo que queremos que se ejecute
// esa es la manera que vamos a generar acciones en la pagina, ahora el index va a ser el que agarre la info del controlador y la accion que se subio a la url para generar un comando

// veamos como funciona el index para accionar los metodos de las clases de los controladores
// si existe controller=... en la url entonces le doy a la variable nombre de controlador su valor.'Controller'
if (isset($_GET['controller'])) {
    $nombre_controlador = $_GET['controller'] . 'Controller';

    // ahora si no aparece controller en la url, el controller predeterminado que le vamos a poner es productos

} elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
    $nombre_controlador = controller_default;



} else {
    $error = new errorController();
    $error->index();

    exit();
}

// si existe la clase nombre del controlador, creo un nuevo objeto controlador= nombre del controlador(ese objeto va a existir
// ya que cada controlador adentro tiene una clase con su mismo nombre, asi que si aparece el nombre en la url, existe la clase)
if (class_exists($nombre_controlador)) {
    $controlador = new $nombre_controlador();


    // ahora si tambien aparece action=... o sea en la url esta el nombre del controlador/clase y un metodo que quiero usar
    // a ese metodo o accion le pongo el nombre action y luego corro el comando $controlador->$action

    if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
        $action = $_GET['action'];
        $controlador->$action();

        // ahora si no aparece action en la url, la action predeterminado que le vamos a poner es index
        // entonces cuando no pasamos valores a la url va a quedar de manera predetermianda productoController action=Index
    } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $action_default = action_default;
        $controlador->$action_default();

    } else {
        $error = new errorController();
        $error->index();

    }
} else {
    $error = new errorController();
    $error->index();
}



ob_end_flush();
