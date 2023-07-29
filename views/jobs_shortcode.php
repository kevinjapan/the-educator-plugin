<?php
$args = array(
   'post_type' => 'te_job',
   'posts_per_page' => 10,
);

$loop = new WP_Query($args);


// we limit to 3 most recent
$count = 0;

?>         
<section class="animated_tiles">
   <h3>Jobs</h3>
   <ul>
      <?php
      while ( $loop->have_posts() ) {
         $loop->the_post();
            ?>
            <li>
               <?php
               if(has_post_thumbnail()):?>
                  <img src="<?php the_post_thumbnail_url('large'); ?>"/>
               <?php endif;
               ?>
               <h3><?php echo get_the_title();?></h3>
               <!-- <p><?php echo get_the_excerpt();?></p> -->
               <button><a href="<?php echo get_permalink(get_the_ID()); ?>">job details</a></button>
            </li>
         <?php
         $count++;
         if($count > 2) break;
      }
      ?>
   </ul>

   <button class="">
      <a href="<?php echo get_post_type_archive_link('te_job'); ?>">More Jobs</a>
   </button>

</section>