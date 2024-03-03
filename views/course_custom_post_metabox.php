<?php
//
// Admin 'Add Course' Form - Course Details
//
// Custom Fields
// tagline, topics, ucas_code, duration, study_mode, start_month, learning_mode
//

// to do : limit input text lengths - rollout
?>
   <label class="te_label">
      <span class="te_label_text">Tagline</span>
      <input   
         id="te_course_tagline_field"
         name="_te_course_array_fields[tagline]"
         value="<?php echo esc_attr($details['tagline']); ?>" 
         type="text"/>
   </label>

   <div class="te_legend">
         <div>Enter a comma-separated list of topics for this course</div>
   </div>
   <label class="te_label">
      <span class="te_label_text">Topics</span>
      <input    
         id="te_course_topics_field"
         name="_te_course_array_fields[topics]"
         value="<?php echo esc_attr($details['topics']); ?>" 
         type="text"/>
   </label>
               
   <label class="te_label">
      <span class="te_label_text">Duration</span>
      <input    
         id="te_course_ucas_code_field"
         name="_te_course_array_fields[ucas_code]"
         value="<?php echo esc_attr($details['ucas_code']);?>" 
         type="text"/> 
   </label>
            
   <label class="te_label">
      <span class="te_label_text">Duration</span>
      <input   
         id="te_course_duration_field"
         name="_te_course_array_fields[duration]" 
         value="<?php echo esc_attr($details['duration']);?>"
         type="text"/>
   </label>

   <label class="te_label">
      <span class="te_label_text">Study Mode</span>
      <select name="_te_course_array_fields[study_mode]" id="te_course_study_mode_field">
         <option value="Full Time" <?php selected($details['study_mode'],'Full Time');?> >Full Time</option>
         <option value="Part Time" <?php selected($details['study_mode'],'Part Time');?> >Part Time</option>
         <option value="Work Placement" <?php selected($details['study_mode'],'Work Placement');?> >Work Placement</option>
      </select>
   </label>

   <label class="te_label">
      <span class="te_label_text">Start Month</span>
      <select name="_te_course_array_fields[start_month]" id="te_course_start_month_field">
         <option value="January" <?php selected($details['start_month'],'January');?> >January</option>
         <option value="February" <?php selected($details['start_month'],'February');?> >February</option>
         <option value="March" <?php selected($details['start_month'],'March');?> >March</option>
         <option value="April" <?php selected($details['start_month'],'April');?> >April</option>
         <option value="May" <?php selected($details['start_month'],'May');?> >May</option>
         <option value="June" <?php selected($details['start_month'],'June');?> >June</option>
         <option value="July" <?php selected($details['start_month'],'July');?> >July</option>
         <option value="August" <?php selected($details['start_month'],'August');?> >August</option>
         <option value="September" <?php selected($details['start_month'],'September');?> >September</option>
         <option value="October" <?php selected($details['start_month'],'October');?> >October</option>
         <option value="November" <?php selected($details['start_month'],'November');?> >November</option>
         <option value="December" <?php selected($details['start_month'],'December');?> >December</option>
      </select>
   </label>

   <label class="te_label">
      <span class="te_label_text">Learning Mode</span>
      <select name="_te_course_array_fields[learning_mode]" id="te_course_learning_mode_field">
         <option value="On Campus Learning" <?php selected($details['learning_mode'],'On Campus Learning');?> >On Campus Learning</option>
         <option value="Online Learning" <?php selected($details['learning_mode'],'Online Learning');?> >Online Learning</option>
      </select> 
   </label>              
