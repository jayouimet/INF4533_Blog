<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';

    require_once dirname(__FILE__) . '/../models/User.php';
    require_once dirname(__FILE__) . '/../models/Post.php';
    require_once dirname(__FILE__) . '/../models/Comment.php';

    require_once dirname(__FILE__) . '/../src/providers/AuthProvider.php';

    class PostController extends Controller {
        /**
         * Function called when trying to use the method GET on the post page
         *
         * @param Request $request The request
         * @param Response $response The response
         * @return void
         */
        public function getAddPost(Request $request, Response $response) {
            if (!AuthProvider::isAuthed())
                return $response->redirect('/');
            /* Create a post model to then give it to the registration form */
            $postModel = new Post();
            $params = [
                'post' => $postModel
            ];
            return $this->render('pages/posts/createPost', $params);
        }

        /**
         * Function called when trying to use the method POST on the post page
         *
         * @param Request $request The request
         * @param Response $response The response
         * @return void
         */
        public function postAddPost(Request $request, Response $response) {
            if (!AuthProvider::isAuthed())
                return $response->redirect('/');
            /* We try to save the post sent from the request.body */
            $user = AuthProvider::getSessionObject();
            $post = new Post();
            $post->loadData($request->getBody());

            if($post->validate()){
                $user->posts[] = $post;
                $user->upsert();
                $response->redirect('/posts/' . $post->getId());
            }

            $params = [
                'model' => $post
            ];
            return $this->render('pages/posts/createPost', $params);
        }

        public function getPost(Request $request, Response $response) {
            /* Create a post model to then give it to the registration form */
            $id = $request->getRouteParam('id');
            $post = Post::getOne(['id' => $id]);
            if (!$post) {
                return $this->render('errors/404', []);
            }
            $post->fetch();
            $params = [
                'post' => $post,
                'comment' => new Comment()
            ];
            return $this->render('pages/posts/showPost', $params);
        }
    }
?>