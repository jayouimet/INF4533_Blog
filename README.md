# INF4533_Blog
Repository for a blog for a school project

## Initial setup
Follow the steps bellow to setup the server

### WAMP/MAMP
If you are using MAMP, you can start the MAMP server and skip this step
If you are using WAMP, after starting the server, left click on the WAMP Icon -> Apache -> Apache modules -> Activate rewrite_module

### Repository name
Place the root of the folder under /htdocs/INF433_BLOG/ if you are using MAMP and under /www/INF433_BLOG/ if you are using WAMP
In the future the subfolder will be optional and renamable through a config file

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
    
    $app = new Application(dirname(__DIR__), "/INF4533_Blog");

    $app->router->get('/', [HomeController::class, 'getHome']);
    $app->router->get('/contact', [ContactController::class, 'getContact']);

    $app->router->post('/contact', [ContactController::class, 'postContact']);

    $app->run();
?>
```
Here we run the app under the base path /INF4533_Blog. Then we route the GET for /INF4533_Blog/ to the function getHome in the HomeController class, and the routes /INF4533_Blog/contact for both GET and POST to the functions getContact and postContact in the ContactController class.

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
