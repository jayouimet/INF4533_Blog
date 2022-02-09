<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';

    class ContactController extends Controller {
        public function getContact(Request $request, Response $response) {
            $body = $request->getBody();
            var_dump($body);
            return $this->render('contact');
        }

        public function postContact(Request $request, Response $response) {
            $body = $request->getBody();
            var_dump($body);
            return $this->render('contactPosted');
        }
    }
?>