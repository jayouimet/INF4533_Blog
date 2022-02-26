<?php
    /**
     * The Controller class is only used as a parent class to use the render function in all controllers.
     */
    class Controller {
        public function render($view, $params = []) {
            return Application::$app->router->renderView($view, $params);
        }
    }
?>