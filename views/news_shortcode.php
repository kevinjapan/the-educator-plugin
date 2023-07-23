<?php
$args = array(
   'post_type' => 'post',
   'category_name' => 'news',
   'posts_per_page' => 10,
);
$loop = new WP_Query($args);

// we limit to 6 most recent projects
$count = 0;
?>         

<section class="feature_tiles stagger_tiles fade_in" style="background:lightgrey;">
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
               <a style="float:right;" href="<?php the_permalink(); ?>">read more</a>
            </li>
         <?php
         $count++;
         if($count > 5) break;
      }
      ?>
   </ul>

   <!-- to do : get link to 'News' category -->
   <button class="">
      <a href="<?php echo get_category_link('News'); ?>">More News</a>
   </button>

</section>