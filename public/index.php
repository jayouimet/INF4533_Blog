<?php
    require_once dirname(__FILE__) . '/../src/Application.php';
    require_once dirname(__FILE__) . '/../controllers/HomeController.php';
    require_once dirname(__FILE__) . '/../controllers/ContactController.php';
    require_once dirname(__FILE__) . '/../controllers/UserController.php';
    require_once dirname(__FILE__) . '/../controllers/DatabaseController.php';
    require_once dirname(__FILE__) . '/../controllers/CommentController.php';
    require_once dirname(__FILE__) . '/../controllers/PostController.php';

    session_start();
    
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

    /*user->posts : [
        someNewPost : noId so always insert
        postInBd1 (modified)
        postInBd2 
        (deletedPost)
    ]

    private or protected in dbModel attr inBD updated at each select [
        id -> status (ex deleted if id present in array but not in posts its is assumed as deleted, modified, unchanged)
    ]

    id need an event on every attr for user->posts to set the post inbd key val to modified

    user->upsert*/

    $app = new Application(dirname(__DIR__), $appConfig);

    $app->router->set404("errors/404");

    $app->router->get('/', [HomeController::class, 'getHome']);
    $app->router->get('/contact', [ContactController::class, 'getContact']);

    $app->router->post('/contact', [ContactController::class, 'postContact']);

    // User Register
    $app->router->get('/register', [UserController::class, 'getRegister']);

    $app->router->post('/register', [UserController::class, 'postRegister']);

    $app->router->post('/logout', [UserController::class, 'postLogout']);

    $app->router->get('/login', [UserController::class, 'login']);
    
    $app->router->post('/login', [UserController::class, 'login']);

    $app->router->get('/test', [UserController::class, 'test']);

    $app->router->get('/migrate_up', [DatabaseController::class, 'getUp']);

    $app->router->get('/migrate_down', [DatabaseController::class, 'getdown']);

    $app->router->get('/addcomment', [CommentController::class, 'getAddComment']);

    $app->router->post('/addcomment', [CommentController::class, 'postAddComment']);

    $app->router->get('/comments', [CommentController::class, 'getShowComment']);

    $app->router->get('/addpost', [PostController::class, 'getAddPost']);

    $app->router->post('/addpost', [PostController::class, 'postAddPost']);

    $app->router->get('/posts', [PostController::class, 'getPosts']);

    $app->router->get('/posts/{id}', [PostController::class, 'getPost']);

    $app->run();
?>