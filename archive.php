<?php get_header(); ?>
    <div>
      <?php while ( have_posts() ) : the_post(); ?>
        <div>
          <?php the_title(); ?>
          <?php the_excerpt(); ?>
        </div>
      <?php endwhile;?>
    </div>
<?php get_footer(); ?>


