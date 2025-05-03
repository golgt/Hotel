<?php 
class BlogPost {
    public $id, $title, $slug, $image, $tag, $created_at, $content, $link;

    public function __construct($data){
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->slug = $data['slug'];
        $this->image = $data['image'];
        $this->tag = $data['tag'];
        $this->created_at = $data['created_at'];
        $this->link = $data['link'];
    }

    public function renderCard(){
        return '<div class="col-lg-4 col-md-6">
            <div class="blog-item set-bg" data-setbg="' . htmlspecialchars($this->image) . '">
                <div class="bi-text">
                    <span class="b-tag">' . htmlspecialchars($this->tag) . '</span>
                    <h4><a href="' . htmlspecialchars($this->link) . '">' . htmlspecialchars($this->title) . '</a></h4>
                    <div class="b-time"><i class="icon_clock_alt"></i> ' . date('d.m.Y', strtotime($this->created_at)) . '</div>
                </div>
            </div>
        </div>';
    }      
}
?>