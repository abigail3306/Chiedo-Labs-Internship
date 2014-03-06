<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div>
  <!-- You can replace the following with home page content -->
  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
  <?php the_content(); ?>
  <!--READ ME. DO NOT DELETE UNTIL YOU IMPLEMENT.-->
<h1>For security purposes, you need to create the following two files.</h1>
  wp-content/uploads/.htaccess

  The file will have the following contents in bold (obviously do not copy the bold tags).
  <b>
    #This should block execution of PHP in this directory. This is good to block hacker
    <Files *.php*>
        deny from all
    </Files>
  </b>
</div>
<?php endwhile;?>
<?php get_footer(); ?>
