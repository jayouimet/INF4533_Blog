<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';

    require_once dirname(__FILE__) . '/../models/User.php';
    require_once dirname(__FILE__) . '/../models/Post.php';
    require_once dirname(__FILE__) . '/../models/Comment.php';
    require_once dirname(__FILE__) . '/../models/Like.php';

    require_once dirname(__FILE__) . '/../src/providers/AuthProvider.php';

    class LikeController extends Controller {
        public function postLikePost(Request $request, Response $response) {
            if (!AuthProvider::isAuthed()) return;
            $body = $request->getBody();
            $user_id = AuthProvider::getSessionObject()->getId();
            $user = User::getOne(['id' => $user_id]);
            $likedPost = Like::getOne(['user_id' => $user->getId(), 'post_id' => $body["post_id"]]);

            if ($likedPost) {
                $likedPost->delete();
                $ret = ["liked" => false];
                $arrJson = json_encode($ret);
                echo $arrJson;
            } else {
                $post = Post::getOne(['id' => $body["post_id"]]);
                $newLike = new Like();
                $newLike->post = $post;
                $newLike->user = $user;
                $newLike->insert();
                $ret = ["liked" => true];
                $arrJson = json_encode($ret);
                echo $arrJson;
            }
        }
    }
?>