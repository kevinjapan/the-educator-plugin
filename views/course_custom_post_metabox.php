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
      <input   value="<?php echo esc_attr($details['study_mode']);?>" type="text"
               name="_te_course_array_fields[study_mode]" id="te_course_study_mode_field"  >
   </div>
   <div class="form-field term-image-wrap">
      <label for="te_course_custom_metabox_start_month">Start Month</label>
      <input   value="<?php echo esc_attr($details['start_month']); ?>" type="text"
               name="_te_course_array_fields[start_month]" id="te_course_start_month_field" >
   </div>
   <div class="form-field term-image-wrap">
      <label for="te_course_custom_metabox_learning_mode">Learning Mode</label>
      <input   value="<?php echo esc_attr($details['learning_mode']); ?>" type="text"
               name="_te_course_array_fields[learning_mode]" id="te_course_learning_mode_field"  >
   </div>
</div>