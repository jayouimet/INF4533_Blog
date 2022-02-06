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