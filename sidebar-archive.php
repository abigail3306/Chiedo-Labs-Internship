<?php 
  $categories = get_categories();
  $years = array();
  $months = array();

  /*
  Get the years for all posts in an array in Descending order
  */
  $yearloop = new WP_Query("post_type=post");
  while ( $yearloop->have_posts() ) : $yearloop->the_post();
      $years[] = get_the_date('Y');
  endwhile;

  $years = array_unique($years);
  sort($years);
  $years = array_reverse($years);
?>
<aside>
  <div class="categories"> 
    <div>Categories</div>
    <ul>
      <?php foreach($categories as $category) : ?>
        <li class="category">
          <?php if($category->name != "Uncategorized") : ?>
            <a class="category-sorter" name="<?php echo $category->name; ?>"><?php echo $category->name; ?></a> 
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div><!-- categories -->
  <div class="archives">
    <div>Archive</div>
    <ul>
      <?php foreach($years as $year) : ?>
        <?php if($year == date('Y')) : ?>
          <li><div class="year"><a href="<?php echo get_year_link($year); ?>"><?php echo $year; ?></a></div>
            <ul>
              <?php
                /*
                Get the months for all posts in an array in the given year
                */
                $loop = new WP_Query("year=$year");
                while ( $loop->have_posts() ) : $loop->the_post();
                $months[] = get_the_date('n');
                endwhile;
                $months = array_unique($months);
              ?>
              <?php foreach($months as $month) :?>
                <li class="month">
                  <a href="<?php echo get_month_link($year, $month); ?>">  
                    <?php echo date( 'F', mktime(0, 0, 0, $month) );?>
                  </a>
                </li>
              <?php endforeach;?>
            </ul>
          </li>
        <?php else : ?>
          <li><div class="year"><a href="<?php echo get_year_link($year); ?>"><?php echo $year; ?></a></div></li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  </div>
</aside>
