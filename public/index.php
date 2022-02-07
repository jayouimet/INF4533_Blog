<?php
    require_once '../src/Application.php';
    require_once '../controllers/HomeController.php';
    require_once '../controllers/ContactController.php';
    require_once '../controllers/UserController.php';
    
    $app = new Application(dirname(__DIR__), "/INF4533_Blog");

    $app->router->set404("errors/404");

    $app->router->get('/', [HomeController::class, 'getHome']);
    $app->router->get('/contact', [ContactController::class, 'getContact']);

    $app->router->post('/contact', [ContactController::class, 'postContact']);

    // User Register
    $app->router->get('/register', [UserController::class, 'getRegister']);

    $app->router->post('/register', [UserController::class, 'postRegister']);

    $app->run();
?>