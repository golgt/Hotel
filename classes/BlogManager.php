<?php 
require_once 'classes/BlogPost.php';
class BlogManager{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function getAllPosts(){
        $stmt = $this->pdo->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
        $posts = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $posts[] = new BlogPost($row);
        }
        return $posts;
    }
    public function getPostBySlug($slug){
        $stmt = $this->pdo->prepare("SELECT * FROM blog_posts WHERE slug = ?");
        $stmt->execute([$slug]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new BlogPost($data) : null;
    }
}
?>