<?php
/* MAY NOT WORK - NEEDS TO BE VALIDATED
 * The search results page
 */

get_header(); ?>
<?php 
/* Usable Search Variables */ 
$the_search = WP_Query("s=$s&showposts=-1"); 
$search_term =  '"' . wp_specialchars($s, 1) . '"'; 
$numer_of_results = $the_search->post_count; _e(''); 
wp_reset_query();
?>
      <div id="primary">
         <h2 class="page-title">
            <?php
               if(strlen($search_term) <= 30 ){ echo "Search results for $search_term"; }
               else echo "Search results";
            ?>
         </h2>
         <div id="content" role="main">
            <?php if ( have_posts() ) : ?>
               <?php while ( have_posts() ) : the_post(); ?>
                  <div class="content-block">
                     <a href="<?php the_permalink(); ?>" class="title"> <?php the_title(); ?> </a> 
                     <div class="content"> <?php the_excerpt(); ?> </div>
                  </div>
               <?php endwhile; ?>
            <?php else : ?>
               Sorry, no posts we're found.
            <?php endif; ?>
         </div><!-- #content -->
      </div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

