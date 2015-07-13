<?php

date_default_timezone_set('America/Boise');

require_once('classes/myview.php');
require_once('classes/post.php');


$main_view = new MyView();
$main_view->ad_header = file_get_contents("ads/header.html");
$main_view->ad_left_side = file_get_contents("ads/left.html");
$main_view->ad_right_side = file_get_contents("ads/right.html");
$main_view->company = "Test Company";
$main_view->site_name = "Site Name";
$main_view->title = "Site Title";
$main_view->main_header = "Main Header";
$main_view->lead_text = "Leader text";

if(isset($_GET['post']))
{
  $post_name = str_replace('.', '', rawurldecode(trim($_GET['post']))) . ".md";
  if(file_exists("posts/" . $post_name))
  {
    $post = new Post($post_name);
    $main_view->title .= " - ".$post->title;
    $main_view->main_header = $post->title;
    $main_view->lead_text = $post->description;
    $main_view->inner_content = $post->content;
  }
}
else
{
  $posts = new Posts();
  $post_listing_view = new MyView();
  $post_listing_view->posts = $posts->get_all();
  $main_view->inner_content = $post_listing_view->render('post_listing.phtml', TRUE);
}


$main_view->render('layout.phtml');

