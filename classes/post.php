<?php

require_once("vendor/php-markdown-lib/Michelf/Markdown.inc.php");

class Post{
  function __construct($filename){
    $file = file("posts/" . $filename);
    //Get/set metadata
    $this->title = str_replace("\n", "", $file[0]);
    $this->date = str_replace("\n", "", substr($file[1], 2));
    $this->author = str_replace("\n", "", $file[2]);
    $this->description = str_replace("\n", "", $file[3]);
    
    $components_of_date = explode("-", $this->date); //Explode to divide month and year
    //DIvide hour, minutes, day
    $components_of_date[3] = substr($components_of_date[2], 3,2); //Get hour
    $components_of_date[4] = substr($components_of_date[2], 6,7); //Get minutes
    $components_of_date[2] = substr($components_of_date[2], 0,2); //Get day
    $this->timestamp = mktime($components_of_date[3], $components_of_date[4], 0, $components_of_date[1], $components_of_date[2], $components_of_date[0]);
    $this->url = rawurlencode(substr($filename, 0, -3));
    $this->filename = $filename;
    //Empty it!
    $file[0] = "";
    $file[1] = "";
    $file[2] = "";
    $file[3] = "";
    //Content
    $markdown = implode($file);
    $this->source = $markdown;
    $this->content = \Michelf\Markdown::defaultTransform($markdown);
  }
}

class Posts{
  function get_all($page=1, $page_max_posts=10){
    $posts = array();
    $dir = scandir("posts/",1);
    $count = 0;
    foreach($dir as $filename){
      if(substr($filename,0,1) != "."){
        $post = new Post($filename);
        $all_posts[$post->date] = clone $post;
        $post = null;
        $count = $count + 1;
        
      }
    }
    krsort($all_posts);
    
    $i = 0;
    foreach($all_posts as $key => $post){
      if($post->timestamp <= time()){
        $posts_numberd[$i] = $post;
        $i = $i + 1;
      }
    }
    
    unset($all_posts);
    $all_posts = $posts_numberd;
    unset($posts_numberd);
    
    $pages_count = ceil($count % $page_max_posts);
    $first = ($page - 1) * $page_max_posts;
    $last = $first + $page_max_posts;
    foreach($all_posts as $num => $post){
      if($num >= $first && $num < $last){
        $posts[$post->date] = $post;
      }
    }
    return $posts;
  }

  public function get($filename){
    return new Post($filename);
  }
}
