<?php

// Custom Fields
// tagline, topics, ucas_code, duration, study_mode, start_month, learning_mode


// future : limit input text lengths - rollout

?>

<div class="form-wrap">
   <div class="form-field term-image-wrap">
      <label for="te_course_custom_metabox_tagline">Tagline</label>
      <input   value="<?php echo esc_attr($details['tagline']); ?>" type="text"
               name="_te_course_array_fields[tagline]" id="te_course_tagline_field"  >
   </div>
   <div class="form-field term-image-wrap">
      <label for="te_course_custom_metabox_topics">Topics</label>
      <span>Enter a comma-separated list of topics for this course:</span>
      <input   value="<?php echo esc_attr($details['topics']); ?>" type="text"
               name="_te_course_array_fields[topics]" id="te_course_topics_field"  >
   </div>            
   <div class="form-field term-image-wrap">
      <label for="te_course_custom_metabox_ucas_code">UCAS code</label>
      <input   value="<?php echo esc_attr($details['ucas_code']); ?>" type="text"
               name="_te_course_array_fields[ucas_code]" id="te_course_ucas_code_field"  > 
   </div>
   <div class="form-field term-image-wrap">
      <label for="te_course_custom_metabox_duration">Duration</label>
      <input   value="<?php echo esc_attr($details['duration']); ?>" type="text"
               name="_te_course_array_fields[duration]" id="te_course_duration_field"  >
   </div>
   <div class="form-field term-image-wrap">
      <label for="te_course_custom_metabox_study_mode">Study Mode</label>
      <select name="_te_course_array_fields[study_mode]" id="te_course_study_mode_field">
         <option value="Full Time"        <?php selected($details['study_mode'],'Full Time');?> >Full Time</option>
         <option value="Part Time"        <?php selected($details['study_mode'],'Part Time');?> >Part Time</option>
         <option value="Work Placement"   <?php selected($details['study_mode'],'Work Placement');?> >Work Placement</option>
      </select>
   </div>
   <div class="form-field term-image-wrap">
      <label for="te_course_custom_metabox_start_month">Start Month</label>
      <select name="_te_course_array_fields[start_month]" id="te_course_start_month_field">
         <option value="January"        <?php selected($details['start_month'],'January');?> >January</option>
         <option value="February"        <?php selected($details['start_month'],'February');?> >February</option>
         <option value="March"   <?php selected($details['start_month'],'March');?> >March</option>
         <option value="April"   <?php selected($details['start_month'],'April');?> >April</option>
         <option value="May"   <?php selected($details['start_month'],'May');?> >May</option>
         <option value="June"   <?php selected($details['start_month'],'June');?> >June</option>
         <option value="July"   <?php selected($details['start_month'],'July');?> >July</option>
         <option value="August"   <?php selected($details['start_month'],'August');?> >August</option>
         <option value="September"   <?php selected($details['start_month'],'September');?> >September</option>
         <option value="October"   <?php selected($details['start_month'],'October');?> >October</option>
         <option value="November"   <?php selected($details['start_month'],'November');?> >November</option>
         <option value="December"   <?php selected($details['start_month'],'December');?> >December</option>
      </select>
   </div>
   <div class="form-field term-image-wrap">
      <label for="te_course_custom_metabox_learning_mode">Learning Mode</label>
      <select name="_te_course_array_fields[learning_mode]" id="te_course_learning_mode_field">
         <option value="On Campus Learning"        <?php selected($details['learning_mode'],'On Campus Learning');?> >On Campus Learning</option>
         <option value="Online Learning"        <?php selected($details['learning_mode'],'Online Learning');?> >Online Learning</option>
      </select>               
   </div>
</div>