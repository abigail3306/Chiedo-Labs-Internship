<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div>
  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
  <?php the_content(); ?>
</div>

<?php endwhile;?>
<?php get_footer(); ?>

