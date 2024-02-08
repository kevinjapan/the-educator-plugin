<?php
$args = array(
   'post_type' => 'post',
   'category_name' => 'news',
   'posts_per_page' => 10,
);

$loop = new WP_Query($args);

// we limit to 6 most recent
$count = 0;

?>         

<section class="feature_tiles stagger_tiles fade_in" style="width:90%;">
   <ul>
      <?php
      while ( $loop->have_posts() ) {
         $loop->the_post();
            ?>            
            <li style="border:none;">
               <?php if(has_post_thumbnail()):?>
                  <img src="<?php the_post_thumbnail_url('large'); ?>"/>
               <?php endif;?>
               
               <h4><?php the_title();?></h4>
               <?php the_excerpt();?>
               
               <div class="wp-block-button te_button wee_te_button" style="margin-top:2rem;margin-bottom:0;">
                  <a class="wp-block-button__link wp-element-button" href="<?php the_permalink(); ?>">read more</a>
               </div>
            </li>
         <?php
         $count++;
         if($count > 5) break;
      }
      ?>
   </ul>

   <?php
   $category_id = get_cat_ID('news');
   ?>
   <div class="wp-block-buttons te_buttons is-layout-flex">
      <div class="wp-block-button te_button">
         <a href="<?php echo get_category_link($category_id); ?>" 
            class="wp-block-button__link wp-element-button">Read More News..</a>
      </div>
   </div>


</section>