<?php

declare(strict_types=1);

// require_once('./src/Request.php');

spl_autoload_register(function (string $name) {
    $name = str_replace(['\\', 'App/'], ['/', ''], $name);
    $path = "src/$name.php";
    require_once($path);
});


require_once('./src/utils/debug.php');
$configuration = require_once('./config/config.php');

use App\Request;
use App\Controller\AbstractController;
use App\Controller\NoteController;
use App\Exception\AppException;
use App\Exception\ConfigurationException;
// use App\Request;



// error_reporting(0);
// ini_set('display_errors', '0');


$request = new Request($_GET, $_POST, $_SERVER);



try {
    AbstractController::initConfiguration($configuration);
    $controller = new NoteController($request);
    $controller->run();
} catch (ConfigurationException $e) {
    echo "<h1>Wystąpił błąd aplikacji</h1>";
    echo "<p>Błąd konfiguracji - skontaktuj się z administratorem xyz@gmail.com</p>";
} catch (AppException $e) {
    echo "<h1>Wystąpił błąd w aplikacji</h1>";
    echo '<h3>' . $e->getMessage() . '</h3>';
    // echo '<h3>' . $e->getPrevious()->getMessage() . '</h3>';
} catch (\Throwable $e) {
    echo "<h1>Wystąpił błąd aplikacji!</h1>";
    dump($e);
}
