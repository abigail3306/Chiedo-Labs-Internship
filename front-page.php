<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div>
  <!-- You can replace the following with home page content -->
  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
  <?php the_content(); ?>
</div>
<?php endwhile;?>
<?php get_footer(); ?>
