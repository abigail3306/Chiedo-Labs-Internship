<?php
/*
Template Name: Blog
*/
?>
<?
$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$blog_page_url = 'http://' . $_SERVER['HTTP_HOST'].$uri_parts[0];
$posts_per_page = 10;
if(!empty($_GET['page-no'])) $page_no = $_GET['page-no'];
$total_posts = wp_count_posts()->publish;
$last_page_no = ceil(($total_posts/$posts_per_page)) - 1;
if(empty($page_no)) $page_no = 1;
$offset = $posts_per_page*($page_no-1);
?>
<?php get_header(); ?>
<?php 
$args = array("post-type"=>"post","orderby"=>"date","order"=>"DESC",
              "posts_per_page" => $posts_per_page, 
              "offset" => $offset);
?>
<?php query_posts($args); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div>
  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
  <?php the_content(); ?>
</div>
<?php endwhile;?>
<div class="other_pages">
<?php if($page_no > 1): ?>
<?php $url = $blog_page_url.'?page-no='.($page_no-1); ?>
<a href="<?php echo $url ?>">Previous Page</a>
<?php endif; ?>
<?php if($page_no <= $last_page_no): ?>
<?php $url = $blog_page_url.'?page-no='.($page_no+1); ?>
<a href="<?php echo $url ?>">Next Page</a>
<?php endif; ?>
</div>
<?php include "sidebar-archive.php"; ?>
<?php get_footer(); ?>

