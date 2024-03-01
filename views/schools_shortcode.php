<?php
//
// Schools front-end shortcode UI
//
$terms = get_terms( array( 
   'taxonomy' => 'te_school',    // exclude all non 'school' taxonomies.
   'parent'   => 0,              // top-level only
   'hide_empty' => false,         // show all regardless
));

?>  

<section class="feature_tiles teasers fade_in">
   <ul>
      <?php
      foreach($terms as $term) {
         $image = get_term_meta($term->term_id, 'school_image', true);
         ?>
         <li style="border:none;">
            <?php
            if($image) {
               ?><img style="border-radius:.25rem;" src="<?php echo $image; ?>"/><?php
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
</section>