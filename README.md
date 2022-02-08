# INF4533_Blog
Repository for a blog for a school project

## Initial setup
Follow the steps bellow to setup the server

### WAMP/MAMP
If you are using MAMP, you can start the MAMP server and skip this step
If you are using WAMP, after starting the server, left click on the WAMP Icon -> Apache -> Apache modules -> Activate rewrite_module

### Config file
To run this server, you need a config file containing some vital information.
On the root of the project, create a config.ini file containing the following : 
```
[database]
db_servername   = database_server_name
db_username     = database_username
db_password     = database_password
db_databasename = database_name

[server_config]
path_from_root  = /some/path
```
The path_from_root value represents where in your host service directory the root of the project is located at.
For exemple, if it is located under /www/TestFolder in WAMP, the value would be /TestFolder
If located under /htdocs/TestFolder in XAMP, the value would be /TestFolder

## Using the Router
Contrary to legacy PHP, we will not be able to access files directly using the directory arborescence. 
Instead, we map the URL to a certain resource file. Let's have a look at that.

### /public/index.php
In this file we map the url to their according controller functions, let's consider this exemple: 
```
<?php
    require_once '../src/Application.php';
    require_once '../controllers/HomeController.php';
    require_once '../controllers/ContactController.php';
    require_once '../controllers/UserController.php';
    
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

    $app->router->get('/test', [UserController::class, 'test']);

    $app->run();
?>
```
Here we route the GET for / to the function getHome in the HomeController class, and the routes /contact for both GET and POST to the functions getContact and postContact in the ContactController class. Same goes for the user registration and the test route.

### Controllers (/controllers/ContactController.php)
Let's take for exemple the contact controller: 
```
<?php
    require_once '../src/Controller.php';
    require_once '../src/Request.php';

    class ContactController extends Controller {
        public function getContact(Request $request) {
            $body = $request->getBody();
            var_dump($body);
            return $this->render('contact');
        }

        public function postContact(Request $request) {
            $body = $request->getBody();
            var_dump($body);
            return $this->render('contactPosted');
        }
    }
?>
```
Here we create a controller class which inherits from Controller in /src/Controller.php. Then we create the functions getContact and postContact that have been mapped above.
If we need to get informations from the request, for exemple the body, we can add the Request object as a parameter to this function (/src/Request.php).
In this case we simply dump the content of the body and then render a view.

### Views (/views/home.php)
The views are basically our pages, it is what is getting shown to the user.
Here is an exemple for the home view: 
#### /controllers/HomeController.php
```
<?php
    require_once '../src/Controller.php';

    class HomeController extends Controller {
        public function getHome(Request $request) {
            $params = [
                'name' => "TestName"
            ];
            return $this->render('home', $params);
        }
    }
?>
```
#### /views/home.php
```
<h1>Home</h1>
<h3>
    <?php echo $name?>
</h3>
```
#### /views/layouts/main.php
(Prone to changes)
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        {{content}}
    </div>
</body>
</html>
```
Here once we call the getHome function in the controller, we render the main.php layout (prone to change) which then replaces the content of the {{content}} block to what is rendered by home.php.
Take note that we can use the variable $name in home.php because we have mapped it in the $params array in HomeController.php.

### Models
You can't have an MVC without the M.
Models represent our database objects and thus need to have a similar configuration. Our models will take care of querying the database and delete and upsert operations.

#### /models/User.php
(Work in progress)
```
<?php
    require_once dirname(__FILE__) . "/../src/database/DatabaseModel.php";

    class User extends DatabaseModel {
        public string $firstname = '';
        public string $lastname = '';
        public string $password = '';
        public string $passwordConfirm = '';
        public int $age = 0;

        public function rules(): array {
            return [
                'firstname' => [Rules::REQUIRED],
                'lastname' => [Rules::REQUIRED],
                'age' => [Rules::REQUIRED, [Rules::MIN_VAL, 'min' => 0], [Rules::MAX_VAL, 'max' => 200]],
                'password' => [Rules::REQUIRED, [Rules::MIN, 'min' => 8]],
                'passwordConfirm' => [Rules::REQUIRED, [Rules::MATCH, 'match' => 'password']],
            ];
        }

        public static function table(): string
        {
            return 'users';
        }

        public function attributes(): array
        {
            return ['firstname' => DatabaseTypes::DB_TEXT, 'lastname' => DatabaseTypes::DB_TEXT, 'password' => DatabaseTypes::DB_TEXT, 'age' => DatabaseTypes::DB_INT];
        }

        public function insert() {
            return parent::insert();
        }

        public function register(){
            // new user created
            return true;
        }
    }
?>
```
Here we create a User object with rules similar to the database. 
We must overwrite the table() function with the table name to which this Model is linked.
We must also overwrite the attributes() function so it returns a dictionary of key/value pairs where the key is the column name and the value is the data type.
Once this is done it is now possible to use the insert() function to automatically push the data for that user in the database.

### Migrations
To ensure database consistency, we have created a beta version of a migration system.
The migration manager will keep track of up and down migrations and when using the following commands will update the database state as such.
These scripts must be executed from the project root directory :

#### php scripts/migrate_up.php
This script will go through the migrations under /src/database/migrations and will execute all the up.sql migrations in ascending order of epoch if they haven't been executed yet.

#### php scripts/migrate_down.php
This script will go through the migrations under /src/database/migrations and will execute all the down.sql migrations in descending order of epoch if their corresponding up migrations have been executed.
