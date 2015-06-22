<?php

date_default_timezone_set('America/Boise');

include_once('classes/myview.php');

$article_listing_view = new MyView();
$article_listing_view->articles = Array(
                                    Array('title' => "test article", 'description' => "this is the descrip"),
                                    Array('title' => "test article 2", 'description' => "this is the descrip also"),
                                  );
$article_view = $article_listing_view->render('article_listing.phtml', TRUE);

$main_view = new MyView();
$main_view->ad_header = file_get_contents("ads/header.html");
$main_view->ad_left_side = file_get_contents("ads/left.html");
$main_view->ad_right_side = file_get_contents("ads/right.html");
$main_view->company = "Test Company";
$main_view->site_name = "Site name";
$main_view->title = "Test Title";
$main_view->main_header = "Main header";
$main_view->lead_text = "Lead text goes here.  Can be somewhat long.";
$main_view->inner_content = $article_view;


$main_view->render('layout.phtml');

