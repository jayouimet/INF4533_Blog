<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';

    require_once dirname(__FILE__) . '/../models/User.php';
    require_once dirname(__FILE__) . '/../models/Post.php';
    require_once dirname(__FILE__) . '/../models/Comment.php';

    class PostController extends Controller {
        /**
         * Function called when trying to use the method GET on the post page
         *
         * @param Request $request The request
         * @param Response $response The response
         * @return void
         */
        public function getAddPost(Request $request, Response $response) {
            /* Create a post model to then give it to the registration form */
            $postModel = new Post();
            $params = [
                'model' => $postModel
            ];
            return $this->render('posts/addPost', $params);
        }

        /**
         * Function called when trying to use the method POST on the post page
         *
         * @param Request $request The request
         * @param Response $response The response
         * @return void
         */
        public function postAddPost(Request $request, Response $response) {
            /* We try to save the post sent from the request.body */
            $postModel = new Post();
            $postModel->loadData($request->getBody());

            if($postModel->validate()){
                $response->redirect('/');
            }

            $params = [
                'model' => $postModel
            ];
            return $this->render('posts/addPost', $params);
        }

        /**
         * Function called when trying to use the method GET on the post page to see all posts
         *
         * @param Request $request The request
         * @param Response $response The response
         * @return void
         */
        public function getPosts(Request $request, Response $response) {
            /* Create a post model to then give it to the registration form */
            $posts = Post::get([]);
            $params = [
                'posts' => $posts
            ];
            return $this->render('posts/showPosts', $params);
        }
    }
?>