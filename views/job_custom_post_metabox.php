<?php

// Custom Fields
// school_or_section, staff_category, position_type, duration, grade, salary, location, ref, closing_date

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
      <select name="_te_job_array_fields[grade]" id="te_job_grade_field">
         <option value="n/a"        <?php selected($details['grade'],'n/a');?> >n/a</option>
         <option value="Grade 1"   <?php selected($details['grade'],'Grade 1');?> >Grade 1</option>
         <option value="Grade 2"   <?php selected($details['grade'],'Grade 2');?> >Grade 2</option>
         <option value="Grade 3"   <?php selected($details['grade'],'Grade 3');?> >Grade 3</option>
         <option value="Grade 4"   <?php selected($details['grade'],'Grade 4');?> >Grade 4</option>
         <option value="Grade 5"   <?php selected($details['grade'],'Grade 5');?> >Grade 5</option>
         <option value="Grade 6"   <?php selected($details['grade'],'Grade 6');?> >Grade 6</option>
         <option value="Grade 7"   <?php selected($details['grade'],'Grade 7');?> >Grade 7</option>
         <option value="Grade 8"   <?php selected($details['grade'],'Grade 8');?> >Grade 8</option>
         <option value="Grade 9"   <?php selected($details['grade'],'Grade 9');?> >Grade 9</option>
         <option value="Grade 10"  <?php selected($details['grade'],'Grade 10');?> >Grade 10</option>
      </select>
   </div>
   <div class="form-field term-image-wrap">
      <label for="te_job_custom_metabox_salary">Salary</label>
      <select name="_te_job_array_fields[salary]" id="te_job_salary_field">
         <option value="£19,000 - £20,000"   <?php selected($details['salary'],'£19,000 - £20,000');?> >£19,000 - £20,000</option>
         <option value="£20,000 - £21,000"   <?php selected($details['salary'],'£20,000 - £21,000');?> >£20,000 - £21,000</option>
         <option value="£21,000 - £22,000"   <?php selected($details['salary'],'£21,000 - £22,000');?> >£21,000 - £22,000</option>
         <option value="£22,000 - £23,000"   <?php selected($details['salary'],'£22,000 - £23,000');?> >£22,000 - £23,000</option>
         <option value="£23,000 - £24,000"   <?php selected($details['salary'],'£23,000 - £24,000');?> >£23,000 - £24,000</option>
         <option value="£24,000 - £25,000"   <?php selected($details['salary'],'£24,000 - £25,000');?> >£24,000 - £25,000</option>
         <option value="£25,000 - £26,000"   <?php selected($details['salary'],'£25,000 - £26,000');?> >£25,000 - £26,000</option>
         <option value="£26,000 - £27,000"   <?php selected($details['salary'],'£26,000 - £27,000');?> >£26,000 - £27,000</option>
         <option value="£27,000 - £28,000"   <?php selected($details['salary'],'£27,000 - £28,000');?> >£27,000 - £28,000</option>
         <option value="£28,000 - £29,000"   <?php selected($details['salary'],'£28,000 - £29,000');?> >£28,000 - £29,000</option>
      </select>
   </div>
   <div class="form-field term-image-wrap">
      <label for="te_job_custom_metabox_location">Location</label>
      <select name="_te_job_array_fields[location]" id="te_job_location_field">
         <option value="Aberdeen"   <?php selected($details['location'],'Aberdeen');?> >Aberdeen</option>
         <option value="Culterty"   <?php selected($details['location'],'Culterty');?> >Culterty</option>
         <option value="Banchory"   <?php selected($details['location'],'Banchory');?> >Banchory</option>
      </select>
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