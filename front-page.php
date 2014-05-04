<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div>
  <!-- README: 
    -  Download and install the following plugins from wp-starter-plugins
    -  - siteorigin-panels (after setting up go tho settings -> Page Builder and uncheck copy content to post content)
    -  - black-studio-tinymce-widget 
    -  - all-in-one-seo-pack
    -  - when PHP is needed in these areas, this is when you should write a shortcode which is easy
    -  We will now be using the page builder for our theme so incorporate this as you develop for all pages. It will make    -    things easier for our clients.
    -  If you notice any weird behavior, search functions.php for anything with the words EXPERIMENTAL and try removing.
    -->
  <!-- don't forget to add cheatsteet -->
  <!-- EXPERIMENTAL - you can now try using more more html5. --> 
  <!-- You can replace the following with home page content -->
  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
  <?php the_content(); ?>
  <input type="date" />
</div>
<?php endwhile;?>
<?php get_footer(); ?>
