<?php
/**
 * The search results page
 *
*/

get_header(); ?>

<?php
/**
 * The template for displaying Search Results pages.
 */
?>
<?php get_header(); ?>
  <?php if ( have_posts() ) : ?>
    <?php printf( __( 'Search Results for: %s', 'twentythirteen' ), get_search_query() ); ?>

    <?php while ( have_posts() ) : the_post(); ?>
      <?php the_title() ?>
      <?php echo get_the_excerpt() ?>
    <?php endwhile; ?>
  <?php else : ?>
    Sorry there were no search results.
  <?php endif; ?>
<?php get_footer(); ?>

