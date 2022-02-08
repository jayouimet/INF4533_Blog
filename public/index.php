<?php
    require_once '../src/Application.php';
    require_once '../controllers/HomeController.php';
    require_once '../controllers/ContactController.php';
    require_once '../controllers/UserController.php';
    require_once '../controllers/TestController.php';
    
    $ini = parse_ini_file('../config.ini');

    $appConfig = [
        'baseUrl' => $ini['path_from_root'],
        'dbConfig' => [
            'servername' => $ini['db_servername'],
            'username' => $ini['db_username'],
            'password' => $ini['db_password'],
            'databasename' => $ini['db_databasename']
        ]
    ];

    $app = new Application(dirname(__DIR__), $appConfig);

    $app->router->set404("errors/404");

    $app->router->get('/', [HomeController::class, 'getHome']);
    $app->router->get('/contact', [ContactController::class, 'getContact']);

    $app->router->post('/contact', [ContactController::class, 'postContact']);

    // User Register
    $app->router->get('/register', [UserController::class, 'getRegister']);

    $app->router->post('/register', [UserController::class, 'postRegister']);

    $app->run();
?>