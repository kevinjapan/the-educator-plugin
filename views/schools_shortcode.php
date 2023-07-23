<?php

// to do : we need to list 'school' terms..    not posts.


// -----------------------------------------------------
//
// to do : bring in from page-schools.php
//
// -----------------------------------------------------


$terms = get_terms( array( 
   'taxonomy' => 'te_school',    // exclude all non 'school' taxonomies.
   'parent'   => 0,              // top-level only
   'hide_empty' => false,         // show all regardless
));

// $args = array(
//    'post_type' => 'te_course',
//    'posts_per_page' => 20,    // get 'em all
// );
// $loop = new WP_Query($args);


?>         
<section class="feature_tiles teasers fade_in">
   <h3>Schools</h3>
   <ul>
      <?php
      foreach($terms as $term) {
         $image = get_term_meta($term->term_id, 'category_image', true);
         ?>
         <li style="border:none;">
            <?php
               //echo get_term_meta( $term->term_id, 'te_text', true )

               if($image) {
                  ?>
                  <img style="border-radius:.25rem;" src="<?php echo $image; ?>"/>
                  <?php
               }
               else {
                  ?><p style="height:20px;"></p><?php
               }
               ?>

            <h4 style="text-align:center;">
               <a href="<?php echo get_term_link($term->name,'te_school'); ?>"><?php echo $term->name;?></a>
            </h4>

         </li>
         <?php
      }
      ?>
   </ul>

   <button class="">
      <a href="<?php echo get_post_type_archive_link('te_course'); ?>">More Courses</a>
   </button>

</section>