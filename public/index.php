<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require 'config.php';

$app = new \Slim\App;
$app->get('/posts','posts');
$app->run();

function posts() {

    try {

            $posts = '';
            $db = getDB();
          
                $sql = "SELECT * FROM `wp_posts` LIMIT 0,30";
                $stmt = $db->prepare($sql);
                $stmt->bindParam("ID", $ID, PDO::PARAM_INT);
                $stmt->bindParam("post_title", $post_title, PDO::PARAM_STR);
                $stmt->bindParam("post_content", $post_content, PDO::PARAM_STR);
          
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_OBJ);
           
            $db = null;

            if($posts)
            echo '{"posts": ' . json_encode($posts) . '}';
            else
            echo '{"posts": ""}';
       
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

?>