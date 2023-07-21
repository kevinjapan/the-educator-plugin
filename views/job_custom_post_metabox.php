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