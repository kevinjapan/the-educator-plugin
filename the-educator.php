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

// to do :
// - first get 'course running
// - then investigate expand this to handle all The Educator Theme functionality? (cf wda single plugins for each)

// to do :
// - courses will be organized into 'schools' or 'departments' - which we will model w/ categories (using archive/single etc)
//



// to do : 
// - shortcode for 'courses' - we can list eg on any page we desire to.
// - shortcode for 'schools'


class TheEducator {

   
	public function __construct() {

      register_activation_hook(__FILE__,array($this,'te_educator_activate'));
      register_deactivation_hook(__FILE__,array($this,'te_educator_deactivate'));

      // register_uninstall_hook(__FILE__,'pluginprefix_function_to_run');       // we have uninstall.php file
      

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
      
      // Schools taxonomy meta (inc featured_image,..)                        // to do : rename and tidy meta fields..
      add_action('te_school_add_form_fields',array($this,'taxonomy_add_custom_field'));
      add_action('te_school_edit_form_fields',array($this,'taxonomy_edit_custom_field'));
      add_action('admin_enqueue_scripts',array($this,'aw_include_script'));   // to do : file name
      add_action('created_te_school',array($this,'save_taxonomy_custom_meta_field'));
      add_action('edited_te_school',array($this,'update_taxonomy_custom_meta_field'));




   // Assets
   //

      add_action('wp_enqueue_scripts',array($this,'enqueue_assets'));


   // UI front-end shortcodes
   //

      add_shortcode('courses',array($this,'courses_shortcode_html'));      // to do : rename and enable for TE.

   }



// Housekeeping
//

   // to do : & uninstall..

   public function te_educator_activate() {
      
      // to do : move create_course_post_type call here?

      // Clear the permalinks (after the post type has been registered?)
      flush_rewrite_rules(); 

      // Populate default terms for 'te_school' taxonomy
      $this->insert_default_schools();

   }

   public function te_educator_deactivate() {

      // Unregister the post type, so the rules are no longer in memory  // to do : go with this here?
      // unregister_post_type( 'te_course' );

   }


// Custom Post Types
//

   // Courses - create custom post type 'te_course'
   //
   public function create_course_post_type() {

      // to do : verify text-domain and rollout.

      $labels = array(
         'name'              => _x('Courses','te_textdomain'),
         'singular_name'     => _x('Course','te_textdomain'),
         'search_items'      => __('Search Course'),
         'all_items'         => __('All Courses'),
         'parent_item'       => __('Parent Course'),
         'parent_item_colon' => __('Parent Course:'),
         'edit_item'         => __('Edit Course'),
         'update_item'       => __('Update Course'),
         'add_new_item'      => __('Add New Course'),
         'new_item_name'     => __('New Course Name'),
         'menu_name'         => __('Courses'),
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
				__( 'Course Details', 'te' ),
				array( $this, 'render_course_post_meta_box' ),
				$post_types,
				'advanced',
				'high'
			);
		}
	}

   // display Course custom meta box
   //
   public function render_course_post_meta_box($post) {

		wp_nonce_field('te_courses_meta_box','te_courses_meta_nonce');

		$tagline = get_post_meta( $post->ID, 'te_course_tagline', true );
		$teacher = get_post_meta( $post->ID, 'te_course_teacher', true );

      // to do : topics - store as a single meta array - model on array from wda 'packages'  - but store as a csv?
		$topics = get_post_meta( $post->ID, 'te_course_topics', true );

      // to do : add these fields to course form..	
      //         - study_mode,start_month,learning_mode are all dropdown select option.

      $ucas_code = get_post_meta( $post->ID, 'te_course_ucas_code', true );         // eg 'C300'
      $duration = get_post_meta( $post->ID, 'te_course_duration', true );           // eg '48 months'
      $study_mode = get_post_meta( $post->ID, 'te_course_study_mode', true );       // eg 'Full Time'
      $start_month = get_post_meta( $post->ID, 'te_course_start_month', true );     // eg 'September'
      $learning_mode = get_post_meta( $post->ID, 'te_course_learning_mode', true ); // eg 'On Campus Learning'

      // to do : limit input text lengths - rollout
      // to do : wrap label around input?
      ?>	
      <div class="form-wrap">
         <div class="form-field term-image-wrap">
            <label for="te_course_custom_metabox_teacher">Teacher</label>
            <input type="text" name="te_course_teacher_field" id="te_course_teacher_field" value="<?php echo $teacher; ?>">
         </div>
         <div class="form-field term-image-wrap">
            <label for="te_course_custom_metabox_tagline">Tagline</label>
            <input type="text" name="te_course_tagline_field" id="te_course_tagline_field" value="<?php echo $tagline; ?>">
         </div>
         <div class="form-field term-image-wrap">
            <label for="te_course_custom_metabox_tagline">Topics</label>
            <span>Enter a comma-separated list of topics for this course:</span>
            <input type="text" name="te_course_topics_field" id="te_course_topics_field" value="<?php echo $topics; ?>">
         </div>
         
         <div class="form-field term-image-wrap">
            <label for="te_course_custom_metabox_ucas_code">UCAS code</label>
            <input type="text" name="te_course_ucas_code_field" id="te_course_ucas_code_field" value="<?php echo $ucas_code; ?>">
         </div>
         <div class="form-field term-image-wrap">
            <label for="te_course_custom_metabox_duration">Duration</label>
            <input type="text" name="te_course_duration_field" id="te_course_duration_field" value="<?php echo $duration; ?>">
         </div>
         <div class="form-field term-image-wrap">
            <label for="te_course_custom_metabox_study_mode">Study Mode</label>
            <input type="text" name="te_course_study_mode_field" id="te_course_study_mode_field" value="<?php echo $study_mode; ?>">
         </div>
         <div class="form-field term-image-wrap">
            <label for="te_course_custom_metabox_start_month">Start Month</label>
            <input type="text" name="te_course_start_month_field" id="te_course_start_month_field" value="<?php echo $start_month; ?>">
         </div>
         <div class="form-field term-image-wrap">
            <label for="te_course_custom_metabox_learning_mode">Learning Mode</label>
            <input type="text" name="te_course_learning_mode_field" id="te_course_learning_mode_field" value="<?php echo $learning_mode; ?>">
         </div>
   </div>
      <?php
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

		// Sanitize the user input
		$tagline = sanitize_text_field( $_POST['te_course_tagline_field'] );
		$teacher = sanitize_text_field( $_POST['te_course_teacher_field'] );
      $topics = sanitize_text_field( $_POST['te_course_topics_field'] );
      $ucas_code = sanitize_text_field( $_POST['te_course_ucas_code_field'] );
      $duration = sanitize_text_field( $_POST['te_course_duration_field'] );
      $study_mode = sanitize_text_field( $_POST['te_course_study_mode_field'] );
      $start_month = sanitize_text_field( $_POST['te_course_start_month_field'] );
      $learning_mode = sanitize_text_field( $_POST['te_course_learning_mode_field'] );

      // if (isset($_POST)) die(print_r('listen'));     // debug
      
		// Update the meta fields
		update_post_meta( $post_id, 'te_course_tagline', $tagline);
		update_post_meta( $post_id, 'te_course_teacher', $teacher);
		update_post_meta( $post_id, 'te_course_topics', $topics);
		update_post_meta( $post_id, 'te_course_ucas_code', $ucas_code);
		update_post_meta( $post_id, 'te_course_duration', $duration);
		update_post_meta( $post_id, 'te_course_study_mode', $study_mode);
		update_post_meta( $post_id, 'te_course_start_month', $start_month);
		update_post_meta( $post_id, 'te_course_learning_mode', $learning_mode);
	}



// Jobs - create custom post type 'te_job'
//

   public function create_job_post_type() {
   
      $labels = array(
         'name'              => _x('Jobs','te_textdomain'),
         'singular_name'     => _x('Job','te_textdomain'),
         'search_items'      => __('Search Job'),
         'all_items'         => __('All Jobs'),
         'parent_item'       => __('Parent Job'),
         'parent_item_colon' => __('Parent Job:'),
         'edit_item'         => __('Edit Job'),
         'update_item'       => __('Update Job'),
         'add_new_item'      => __('Add New Job'),
         'new_item_name'     => __('New Job Name'),
         'menu_name'         => __('Jobs'),
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
				__( 'Job Details', 'te' ),
				array( $this, 'render_job_post_meta_box' ),
				$post_types,
				'advanced',
				'high'
			);
		}
   }


      // $school_or_section = get_post_meta( $post->ID, 'te_job_school_or_section', true );        // eg 'Engineering'
      // $staff_category = get_post_meta( $post->ID, 'te_job_staff_category', true );              // eg 'Research'
      // $position_type = get_post_meta( $post->ID, 'te_job_postion_type', true );                 // eg 'Full Time'
      // $duration = get_post_meta( $post->ID, 'te_job_duration', true );                          // eg 'Funding/Activity Limited'
      // $grade = get_post_meta( $post->ID, 'te_job_grade', true );                                // eg 'Not Applicable'
      // $salary = get_post_meta( $post->ID, 'te_job_salary', true );                              // eg '£34,000 - £36,000'
      // $location = get_post_meta( $post->ID, 'te_job_location', true );                          // eg 'Harlow, Essex'
      // $ref = get_post_meta( $post->ID, 'te_job_ref', true );                                    // eg 'ENG215R'
      // $closing_date 

  // future : we want this list configurable by site owner
  private function get_default_job_details() {
   return array(
      'school_or_section' => '',
      'staff_category' => '',
      'position_type' => '',
      'duration' => '',
      'grade' => '',
      'salary' => '',
      'location' => '',
      'ref' => '',
      'closing_date' => '',
   );
}


   // display Job custom meta box
   //
   public function render_job_post_meta_box($post) {

		wp_nonce_field('te_jobs_meta_box','te_jobs_meta_nonce');

   $saved_details= get_post_meta( $post->ID, '_te_job_details_meta_key', true );
   $default_details = $this->get_default_job_details();  // to do : ?
   $details = wp_parse_args( $saved_details, $default_details ); // Merge the two in case any fields don't exist in the saved data


      // to do : save all details in a single array - $details
      //
      // $school_or_section = get_post_meta( $post->ID, 'te_job_school_or_section', true );        // eg 'Engineering'
      // $staff_category = get_post_meta( $post->ID, 'te_job_staff_category', true );              // eg 'Research'
      // $position_type = get_post_meta( $post->ID, 'te_job_postion_type', true );                 // eg 'Full Time'
      // $duration = get_post_meta( $post->ID, 'te_job_duration', true );                          // eg 'Funding/Activity Limited'
      // $grade = get_post_meta( $post->ID, 'te_job_grade', true );                                // eg 'Not Applicable'
      // $salary = get_post_meta( $post->ID, 'te_job_salary', true );                              // eg '£34,000 - £36,000'
      // $location = get_post_meta( $post->ID, 'te_job_location', true );                          // eg 'Harlow, Essex'
      // $ref = get_post_meta( $post->ID, 'te_job_ref', true );                                    // eg 'ENG215R'
      // $closing_date = get_post_meta( $post->ID, 'te_job_closing_date', true );                  // eg '16/08/2023'
     
      ?>
      <div class="form-wrap">
         <div class="form-field term-image-wrap">
            <label for="te_job_custom_metabox_school_or_section">School/Section</label>
            <input value="<?php echo esc_attr($details['school_or_section']); ?>"
                   name="_te_job_array_fields[school_or_section]" id="te_school_or_section_field" type="text">
         </div>
         <div class="form-field term-image-wrap">
            <label for="te_job_custom_metabox_staff_category">Staff Category</label>
            <input value="<?php echo esc_attr($details['staff_category']);  ?>" type="text" 
                   name="_te_job_array_fields[staff_category]" id="te_job_staff_category_field" >
         </div>
         <div class="form-field term-image-wrap">
            <label for="te_job_custom_metabox_position_type">Position Type</label>
            <input value="<?php echo esc_attr($details['position_type']); ?>" type="text" 
                   name="_te_job_array_fields[position_type]" id="te_job_position_type_field" >
         </div>
         <div class="form-field term-image-wrap">
            <label for="te_job_custom_metabox_duration">Duration of Post</label>
            <input value="<?php echo esc_attr($details['duration']);  ?>" type="text" 
                   name="_te_job_array_fields[duration]" id="te_job_duration_field">
         </div>
         <div class="form-field term-image-wrap">
            <label for="te_job_custom_metabox_grade">Grade</label>
            <input value="<?php echo esc_attr($details['grade']);  ?>" type="text" 
                   name="_te_job_array_fields[grade]" id="te_job_grade_field">
         </div>
         <div class="form-field term-image-wrap">
            <label for="te_job_custom_metabox_salary">Salary</label>
            <input value="<?php echo esc_attr($details['salary']);  ?>" type="text" 
                   name="_te_job_array_fields[salary]" id="te_job_salary_field">
         </div>
         <div class="form-field term-image-wrap">
            <label for="te_job_custom_metabox_location">Location</label>
            <input value="<?php echo esc_attr($details['location']);  ?>" type="text" 
                   name="_te_job_array_fields[location]" id="te_job_location_field">
         </div>
         <div class="form-field term-image-wrap">
            <label for="te_job_custom_metabox_ref">Ref.</label>
            <input value="<?php echo esc_attr($details['ref']);  ?>" type="text" 
                   name="_te_job_array_fields[ref]" id="te_job_ref_field">
         </div>
         <div class="form-field term-image-wrap">
            <label for="te_job_custom_metabox_closing_date">Closing Date</label>
            <input value="<?php echo esc_attr($details['closing_date']);  ?>" type="text" 
                   name="_te_job_array_fields[closing_date]" id="te_job_closing_date_field">
         </div>
      </div>
      <?php 

   }

   // save Job custom meta box
   //
	public function save_job_post_meta($post_id) {

      //if (isset($_POST)) die(print_r($_POST));     // debug

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
			// `wp_filter_post_kses` strips our dangerous server values
			// and allows through anything you can include a post.
			$sanitized[$key] = wp_filter_post_kses( $detail );
		}

		// Save our submissions to the database
		update_post_meta( $post_id, '_te_job_details_meta_key', $sanitized );



      // to do : remove once details array working:
      //
		// Sanitize the user input
      // $school_or_section = sanitize_text_field( $_POST['te_job_school_or_section_field'] );
      // $staff_category = sanitize_text_field( $_POST['te_job_staff_category_field'] );
      // $position_type = sanitize_text_field( $_POST['te_job_position_type_field'] );
      // $duration = sanitize_text_field( $_POST['te_job_duration_field'] );
      // $grade = sanitize_text_field( $_POST['te_job_grade_field'] );
      // $salary = sanitize_text_field( $_POST['te_job_salary_field'] );
      // $location = sanitize_text_field( $_POST['te_job_location_field'] );
      // $ref = sanitize_text_field( $_POST['te_job_ref_field'] );
      // $closing_date = sanitize_text_field( $_POST['te_job_closing_date_field'] );
      
		// Update the meta fields
      // update_post_meta( $post_id, 'te_course_school_or_section', $school_or_section);
      // update_post_meta( $post_id, 'te_course_staff_category', $staff_category);
      // update_post_meta( $post_id, 'te_course_position_type', $position_type);
      // update_post_meta( $post_id, 'te_course_duration', $duration);
      // update_post_meta( $post_id, 'te_course_grade', $grade);
      // update_post_meta( $post_id, 'te_course_salary', $salary);
      // update_post_meta( $post_id, 'te_course_location', $location);
      // update_post_meta( $post_id, 'te_course_ref', $ref);
      // update_post_meta( $post_id, 'te_course_closing_date', $closing_date);
   }


// Custom Categories
//

// 'Posts' can be any of the following category: 'news','research news'
   public function add_custom_categories() {
      //Create Custom Category
      wp_insert_term(
         'Research News', 
         'category', 
         array('slug' => 'research-news')
      );
      wp_insert_term(
         'News', 
         'category', 
         array('slug' => 'news')
      );
      // to do : tidy / delete these on removing plugin?
   }





// Custom Taxonomies
//

   public function register_taxonomy_schools() {
      $labels = array(
         'name'              => _x('Schools','taxonomy general name'),
         'singular_name'     => _x('School','taxonomy singular name'),
         'search_items'      => __('Search Schools'),
         'all_items'         => __('All Schools'),
         'parent_item'       => __('Parent School'),
         'parent_item_colon' => __('Parent School:'),
         'edit_item'         => __('Edit School'),
         'update_item'       => __('Update School'),
         'add_new_item'      => __('Add New School'),
         'new_item_name'     => __('New School Name'),
         'menu_name'         => __('Schools'),
      );

      // to do : add text-domain to items above eg: 'add_or_remove_items' => __('Remove Feature', 'my_plugin'),

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
   public function taxonomy_add_custom_field() {
      // to do : rename 'category_image' etc - better descriptive
      ?>
      <div class="form-field term-image-wrap">
         <label for="category_image"><?php _e( 'Image' ); ?></label>
         <p><a href="#" class="aw_upload_image_button button button-secondary"><?php _e('Upload Image'); ?></a></p>
         <input type="text" name="category_image" id="category_image" value="" size="40" />
      </div>
      <?php
   }
   public function taxonomy_edit_custom_field($term) {
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
   public function save_taxonomy_custom_meta_field( $term_id ) {
      if ( isset( $_POST['category_image'] ) ) {
         update_term_meta($term_id, 'category_image', $_POST['category_image']);
      }
      // if( isset( $_POST['feature-group'] ) && '' !== $_POST['feature-group'] ){
      //    $group = sanitize_title( $_POST['feature-group'] );
      //    update_term_meta( $term_id, 'feature-group', $group );
      // }
   }  
   public function update_taxonomy_custom_meta_field($term_id) {

         // to do : some sources suggest separate 'save' and 'update' functionality?
         // if we do separate, use 'add_term_meta()' in 'save_taxonomy_custom_meta_field()'.
         $this->save_taxonomy_custom_meta_field($term_id);
   }

   // script for accessing WP media library to select featured image
   //
   public function aw_include_script() {
      if ( ! did_action( 'wp_enqueue_media' ) ) {
         wp_enqueue_media();
      }
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
      //    plugin_dir_url( __FILE__ ) . 'js/web-dev-agent.js',
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

      $args = array(
         'post_type' => 'te_course',
         'posts_per_page' => 10,
      );
      $loop = new WP_Query($args);

      // we limit to 3 most recent projects
      $count = 0;

      ?>
      <section class="animated_tiles">
         <h3>Courses</h3>
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
                     <p><?php echo get_post_meta( get_the_ID(), 'te_course_tagline', true );?></p>
                     <!-- <p><?php echo get_the_excerpt();?></p> -->
                     <button><a href="<?php echo get_permalink(get_the_ID()); ?>">course details</a></button>
                  </li>
               <?php
               $count++;
               if($count > 2) break;
            }
            ?>
         </ul>
         
         <button class="">
            <a href="<?php echo get_post_type_archive_link('te_course'); ?>">More Courses</a>
         </button>

      </section>
      <?php
      $buffered_data = ob_get_clean();    // return buffered output
      return $buffered_data;
   }

}


new TheEducator;