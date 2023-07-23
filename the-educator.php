<?php
/*
Plugin Name: The Educator
Plugin URI: 
Description: Create Custom Post Types and UIs for The Educator Theme
Version: 1.0.0
Author: edk
Author URI: evolutiondesuka.com
*/

// ensure application access only
if( !defined('ABSPATH') ) {
   exit;
}


if ( ! class_exists( 'TheEducator' ) ) {

   class TheEducator {

      public function __construct() {

         register_activation_hook(__FILE__,array($this,'te_educator_activate'));
         register_deactivation_hook(__FILE__,array($this,'te_educator_deactivate'));
         // register_uninstall_hook(__FILE__,'pluginprefix_function_to_run');          // see uninstall.php 

      // Custom Post Types
      //

         // Courses
         add_action('init',array($this,'create_course_post_type'));
         add_action('add_meta_boxes',array( $this,'add_course_post_meta_box')); 
         add_action('save_post',array($this,'save_course_post_meta'));

         // Jobs
         add_action('init',array($this,'create_job_post_type'));
         add_action('add_meta_boxes',array( $this,'add_job_post_meta_box')); 
         add_action('save_post',array($this,'save_job_post_meta'));
         
      // Custom Taxonomies
      //
         // Categories 'news','research news'
         add_action('init',array($this,'add_custom_categories'));

         // Schools     
         add_action('init',array($this,'register_taxonomy_schools'));
         
         // Schools taxonomy meta (inc featured_image,..)
         add_action('te_school_add_form_fields',array($this,'school_taxonomy_add_custom_fields'));
         add_action('te_school_edit_form_fields',array($this,'school_taxonomy_edit_custom_fields'));
         add_action('created_te_school',array($this,'save_school_taxonomy_custom_meta_field'));
         add_action('edited_te_school',array($this,'update_school_taxonomy_custom_meta_field'));

         // enable WP Media Lib for img selection
         add_action('admin_enqueue_scripts',array($this,'te_media_lib_script'));


      // Assets
      //

         add_action('wp_enqueue_scripts',array($this,'enqueue_assets'));

      // UI front-end shortcodes
      //

         add_shortcode('courses',array($this,'courses_shortcode_html'));
         add_shortcode('jobs',array($this,'jobs_shortcode_html'));
         add_shortcode('latest_news',array($this,'news_shortcode_html'));
         add_shortcode('schools',array($this,'schools_shortcode_html'));

      }


   // Housekeeping
   //
      public function te_educator_activate() {

         // Clear the permalinks (after the post type has been registered?)
         flush_rewrite_rules(); 

         // Populate default terms for 'te_school' taxonomy
         $this->insert_default_schools();
      }

      public function te_educator_deactivate() {
         // Unregister the post type, so the rules are no longer in memory
         // unregister_post_type( 'te_course' );
      }


   // Custom Post Types
   //

      // Courses - create custom post type 'te_course'
      //
      public function create_course_post_type() {

         $labels = array(
            'name'              => _x('Courses','the-educator'),
            'singular_name'     => _x('Course','the-educator'),
            'all_items'         => __('All Courses','the-educator'),
            'search_items'      => __('Search Course','the-educator'),
            'parent_item'       => __('Parent Course','the-educator'),
            'parent_item_colon' => __('Parent Course:','the-educator'),
            'edit_item'         => __('Edit Course','the-educator'),
            'update_item'       => __('Update Course','the-educator'),
            'add_new_item'      => __('Add New Course','the-educator'),
            'new_item_name'     => __('New Course Name','the-educator'),
            'menu_name'         => __('Courses','the-educator'),
         );

         $args = array(
            'labels' => $labels,
            'description' => 'Course Custom Post Type',
            'supports' => array('title','editor','thumbnail'),
            'hierarchical' => true,
            'taxonomies' => array('category'),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'course'), 
            'exclude_from_search' => true,
            'publicly_queryable' => true,    // false will exclude archive- and single- templates
            'menu_icon' => 'dashicons-media-text',
         );
         register_post_type('te_course',$args);
      }


   // Custom Meta Box for 'te_course' posts.
   //

      // edit Course post
      //
      public function add_course_post_meta_box( $post_type ) {
         // Limit meta box to certain post types
         $post_types = array( 'te_course' );

         if ( in_array( $post_type, $post_types ) ) {

            add_meta_box(
               'te_course',
               __( 'Course Details', 'the-educator' ),
               array( $this, 'render_course_post_meta_box' ),
               $post_types,
               'advanced',
               'high'
            );
         }
      }

      // future : we want this list configurable by site owner
      //
      private function get_default_course_details() {
         return array(
            'tagline' => '',
            'topics' => '',
            'ucas_code' => '',                        // eg 'C300'
            'duration' => '',                         // eg '48 months'
            'study_mode' => 'Full Time',              // eg 'Full Time'
            'start_month' => 'September',             // eg 'September'
            'learning_mode' => 'On Campus Learning',  // eg 'On Campus Learning'
         );
      }

      // display Course custom meta box
      //
      public function render_course_post_meta_box($post) {

         wp_nonce_field('te_courses_meta_box','te_courses_meta_nonce');

         $saved_details= get_post_meta( $post->ID, '_te_course_details_meta_key', true );
         $default_details = $this->get_default_course_details();
         $details = wp_parse_args( $saved_details, $default_details ); // Merge the two in case any fields don't exist in the saved data

         // to do : limit input text lengths - rollout

         require_once 'views/course_custom_post_metabox.php';
      }

      // save Course custom meta box
      //
      public function save_course_post_meta($post_id) {

         //if (isset($_POST)) die(print_r($_POST));     // debug

         if ( ! isset( $_POST['te_courses_meta_nonce'] ) ) {
            return $post_id;
         }
         $nonce = $_POST['te_courses_meta_nonce'];
         if ( ! wp_verify_nonce( $nonce, 'te_courses_meta_box' ) ) {
            return $post_id;
         }

         // autosave, our form has not been submitted
         if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
         }

         // Check the user's permissions.
         if (!current_user_can('edit_page',$post_id)) {
            return $post_id;
         }

         // Set up an empty array
         $sanitized = array();

         // Loop through each of our fields
         foreach ( $_POST['_te_course_array_fields'] as $key => $detail ) {

            // Sanitize the data and push it to our new array
            // `wp_filter_post_kses` allows through anything you can include a post.
            $sanitized[$key] = wp_filter_post_kses( $detail );

         }
         // Save our submissions to the database
         update_post_meta( $post_id, '_te_course_details_meta_key', $sanitized );
      }


   // Jobs - create custom post type 'te_job'
   //

      public function create_job_post_type() {
      
         $labels = array(
            'name'              => _x('Jobs','the-educator'),
            'singular_name'     => _x('Job','the-educator'),
            'all_items'         => __('All Jobs','the-educator'),
            'search_items'      => __('Search Job','the-educator'),
            'parent_item'       => __('Parent Job','the-educator'),
            'parent_item_colon' => __('Parent Job:','the-educator'),
            'edit_item'         => __('Edit Job','the-educator'),
            'update_item'       => __('Update Job','the-educator'),
            'add_new_item'      => __('Add New Job','the-educator'),
            'new_item_name'     => __('New Job Name','the-educator'),
            'menu_name'         => __('Jobs','the-educator'),
         );

         $args = array(
            'labels' => $labels,
            'description' => 'Job Custom Post Type',
            'supports' => array('title','editor','thumbnail'),
            'hierarchical' => false,
            'taxonomies' => array('category'),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'job'),
            'exclude_from_search' => true,
            'publicly_queryable' => true,    // false will exclude archive- and single- templates
            'menu_icon' => 'dashicons-media-text',
         );
         register_post_type('te_job',$args);   
      }


   // Custom Meta Box for 'te_job' posts.
   //

      // edit Job page
      //
      public function add_job_post_meta_box( $post_type ) {
         // Limit meta box to certain post types
         $post_types = array( 'te_job' );

         if ( in_array( $post_type, $post_types ) ) {

            add_meta_box(
               'te_course',
               __( 'Job Details', 'the-educator' ),
               array( $this, 'render_job_post_meta_box' ),
               $post_types,
               'advanced',
               'high'
            );
         }
      }


      // future : we want this list configurable by site owner
      //
      private function get_default_job_details() {
         return array(
            'school_or_section' => '',             // eg 'Engineering'
            'staff_category' => '',                // eg 'Research'
            'position_type' => '',                 // eg 'Full Time'
            'duration' => '',                      // eg 'Funding/Activity Limited'
            'grade' => '',                         // eg 'Not Applicable'
            'salary' => '',                        // eg '£34,000 - £36,000'
            'location' => '',                      // eg 'Harlow, Essex'
            'ref' => '',                           // eg 'ENG215R'
            'closing_date' => '',                  // eg '16/08/2023'
         );
      }


      // display Job custom meta box
      //
      public function render_job_post_meta_box($post) {

         wp_nonce_field('te_jobs_meta_box','te_jobs_meta_nonce');

         $saved_details= get_post_meta( $post->ID, '_te_job_details_meta_key', true );
         $default_details = $this->get_default_job_details();
         $details = wp_parse_args( $saved_details, $default_details ); // Merge the two in case any fields don't exist in the saved data

         require_once 'views/job_custom_post_metabox.php';
      }

      // save Job custom meta box
      //
      public function save_job_post_meta($post_id) {

         if ( ! isset( $_POST['te_jobs_meta_nonce'] ) ) {
            return $post_id;
         }
         $nonce = $_POST['te_jobs_meta_nonce'];
         if ( ! wp_verify_nonce( $nonce, 'te_jobs_meta_box' ) ) {
            return $post_id;
         }

         // autosave, our form has not been submitted
         if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
         }

         // Check the user's permissions.
         if (!current_user_can('edit_page',$post_id)) {
            return $post_id;
         }

         // Set up an empty array
         $sanitized = array();

         // Loop through each of our fields
         foreach ( $_POST['_te_job_array_fields'] as $key => $detail ) {

            // Sanitize the data and push it to our new array
            // `wp_filter_post_kses` allows through anything you can include a post.
            $sanitized[$key] = wp_filter_post_kses( $detail );

         }

         // Save our submissions to the database
         update_post_meta( $post_id, '_te_job_details_meta_key', $sanitized );
      }


   // Custom Categories
   //

      // 'Posts' - additional categories supported by the educator theme template files : 'news','research news'
      //
      public function add_custom_categories() {
         wp_insert_term('Research News', 'category', array('slug' => 'research-news'));
         wp_insert_term('News', 'category', array('slug' => 'news'));
      }


   // Custom Taxonomies
   //

      public function register_taxonomy_schools() {
         $labels = array(
            'name'              => _x('Schools','the-educator'),
            'singular_name'     => _x('School','the-educator'),
            'all_items'         => __('All Schools','the-educator'),
            'search_items'      => __('Search Schools','the-educator'),
            'parent_item'       => __('Parent School','the-educator'),
            'parent_item_colon' => __('Parent School:','the-educator'),
            'edit_item'         => __('Edit School','the-educator'),
            'update_item'       => __('Update School','the-educator'),
            'add_new_item'      => __('Add New School','the-educator'),
            'new_item_name'     => __('New School Name','the-educator'),
            'menu_name'         => __('Schools','the-educator'),
         );

         $args   = array(
            'hierarchical'      => true, // make it hierarchical (like categories)
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => 'school' ],
         );
         register_taxonomy( 'te_school', [ 'te_course' ], $args );
      }


      // Term meta data for Schools taxonomy
      //

      // taxonomy custom fields - in our case, taxonomy term thumbnails - 
      // in our archive list of schools, each school will display a featured img.
      //
      public function school_taxonomy_add_custom_fields() {
         // to do : rename 'category_image' etc - be descriptive
         ?>
         <div class="form-field term-image-wrap">
            <label for="category_image"><?php _e( 'Image' ); ?></label>
            <p><a href="#" class="aw_upload_image_button button button-secondary"><?php _e('Upload Image'); ?></a></p>
            <input type="text" name="category_image" id="category_image" value="" size="40" />
         </div>
         <?php
      }
      public function school_taxonomy_edit_custom_fields($term) {
         $image = get_term_meta($term->term_id, 'category_image', true);
         ?>
         <tr class="form-field term-image-wrap">
            <th scope="row"><label for="category_image"><?php _e( 'Image' ); ?></label></th>
            <td>
               <p><a href="#" class="aw_upload_image_button button button-secondary"><?php _e('Upload Image'); ?></a></p><br/>
               <input type="text" name="category_image" id="category_image" value="<?php echo $image; ?>" size="40" />
            </td>
         </tr>
         <?php
      }
      public function save_school_taxonomy_custom_meta_field( $term_id ) {
         if ( isset( $_POST['category_image'] ) ) {
            update_term_meta($term_id, 'category_image', $_POST['category_image']);
         }
      }  
      public function update_school_taxonomy_custom_meta_field($term_id) {
            // some sources suggest separate 'save' and 'update' functionality?
            // if we do separate, use 'add_term_meta()' in 'save_school_taxonomy_custom_meta_field()'.
            $this->save_school_taxonomy_custom_meta_field($term_id);
      }

      // script for accessing WP media library to select featured image
      // 
      public function te_media_lib_script() {
         if (!did_action('wp_enqueue_media')) { wp_enqueue_media(); }
         wp_enqueue_script( 'te_media', get_stylesheet_directory_uri() . '/js/te_media.js', array('jquery'), null, false );
      }

      // Pre-populate Schools terms with a set of default standards.
      //
      public function insert_default_schools() {

         $default_schools = [
            '0' => array('name' => 'Engineering',            'slug' => '','description' => 'school of engineering'),
            '1' => array('name' => 'Science and Mathematics','slug' => '','description' => 'school of science and mathematics'),
            '2' => array('name' => 'Arts and Humanities',    'slug' => '','description' => 'school of arts and humanities'),
            '3' => array('name' => 'Agriculture',            'slug' => '','description' => 'school of agriculture'),
            '4' => array('name' => 'Business and Economics', 'slug' => '','description' => 'school of business and economics'),
         ];
         foreach($default_schools as $school) {
            if(!term_exists( $school['name'], 'te_school' )) {
               wp_insert_term(
                  $school['name'],  // the term 
                  'te_school',      // the taxonomy
                  array('slug' => $school['slug'],'description' => $school['description'],)
               );
            }
         }
      }


   // Assets
   //

      public function enqueue_assets() 
      {
         // we don't enqueue these assets since they are enqueued by The Educator theme

         //
         // to do : on-going
         // does WP enqueuing allow for theme/plugin duplication and prevent it? (include css only once?)
         // currently, we rely on WDA theme - so these plugins won't work in other themes. (require outline & wda.css)
         //
         
         // wp_enqueue_style(
         //    'wda_outline',
         //    plugin_dir_url( __FILE__ ) . 'css/outline.css',
         //    array(),
         //    1,
         //    'all'
         // );  
         // wp_enqueue_style(
         //    'wda_outline_layouts',
         //    plugin_dir_url( __FILE__ ) . 'css/outline-layouts.css',
         //    array(),
         //    1,
         //    'all'
         // );  
         // wp_enqueue_style(
         //    'wda_outline_custom_props',
         //    plugin_dir_url( __FILE__ ) . 'css/outline-custom-props.css',
         //    array(),
         //    1,
         //    'all'
         // );  
         // wp_enqueue_style(
         //    'wda_outline_utilities',
         //    plugin_dir_url( __FILE__ ) . 'css/outline-utilities.css',
         //    array(),
         //    1,
         //    'all'
         // ); 
         // wp_enqueue_script(
         //    'te',
         //    plugin_dir_url( __FILE__ ) . 'js/the-educator.js',
         //    array('jquery'),
         //    1,
         //    true
         // );
      }
      

   // UI front-end shortcodes
   //

      // [courses]
      //
      public function courses_shortcode_html() {
         ob_start(); // buffer output
         require_once 'views/courses_shortcode.php';
         $buffered_data = ob_get_clean();    // return buffered output
         return $buffered_data;
      }

      
      // [jobs]
      //
      public function jobs_shortcode_html() {
         ob_start(); // buffer output
         require_once 'views/jobs_shortcode.php';
         $buffered_data = ob_get_clean();    // return buffered output
         return $buffered_data;
      }

      
      // [news]
      //
      public function news_shortcode_html() {
         ob_start(); // buffer output
         require_once 'views/news_shortcode.php';
         $buffered_data = ob_get_clean();    // return buffered output
         return $buffered_data;
      }

      
      // [schools]
      //
      public function schools_shortcode_html() {
         ob_start(); // buffer output
         require_once 'views/schools_shortcode.php';
         $buffered_data = ob_get_clean();    // return buffered output
         return $buffered_data;
      }
   }

}


new TheEducator;