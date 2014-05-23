<?php get_header(); ?>
    <div>
      <?php while ( have_posts() ) : the_post(); ?>
        <div>
          <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
          <?php the_excerpt(); ?>
        </div>
      <?php endwhile;?>
    </div>
<?php get_footer(); ?>


