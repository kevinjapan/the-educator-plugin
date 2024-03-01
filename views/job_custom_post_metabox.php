<?php
//
// Admin 'Add Job' Form - Job Details
//
// Custom Fields
// school_or_section, staff_category, position_type, duration, grade, salary, location, ref, closing_date
//
?>
   <label class="te_label">
      <span class="te_label_text">School/Section</span>
      <input
         id="te_school_or_section_field" 
         name="_te_job_array_fields[school_or_section]" 
         value="<?php echo esc_attr($details['school_or_section']); ?>"
         type="text">      
   </label>

   <label class="te_label">
      <span class="te_label_text">Staff Category</span>
      <input
         id="te_job_staff_category_field" 
         name="_te_job_array_fields[staff_category]" 
         value="<?php echo esc_attr($details['staff_category']);  ?>" 
         type="text" >         
   </label>

   <label class="te_label">
      <span class="te_label_text">Position Type</span>
      <input
         id="te_job_position_type_field" 
         name="_te_job_array_fields[position_type]" 
         value="<?php echo esc_attr($details['position_type']); ?>" 
         type="text">
   </label>

   <label class="te_label">
      <span class="te_label_text">Duration of Post</span>
      <input 
         id="te_job_duration_field"
         name="_te_job_array_fields[duration]"
         value="<?php echo esc_attr($details['duration']);  ?>" 
         type="text" >
   </label>

   <label class="te_label">
      <span class="te_label_text">Grade</span>         
      <select name="_te_job_array_fields[grade]" id="te_job_grade_field">
         <option value="n/a" <?php selected($details['grade'],'n/a');?> >n/a</option>
         <option value="Grade 1" <?php selected($details['grade'],'Grade 1');?> >Grade 1</option>
         <option value="Grade 2" <?php selected($details['grade'],'Grade 2');?> >Grade 2</option>
         <option value="Grade 3" <?php selected($details['grade'],'Grade 3');?> >Grade 3</option>
         <option value="Grade 4" <?php selected($details['grade'],'Grade 4');?> >Grade 4</option>
         <option value="Grade 5" <?php selected($details['grade'],'Grade 5');?> >Grade 5</option>
         <option value="Grade 6" <?php selected($details['grade'],'Grade 6');?> >Grade 6</option>
         <option value="Grade 7" <?php selected($details['grade'],'Grade 7');?> >Grade 7</option>
         <option value="Grade 8" <?php selected($details['grade'],'Grade 8');?> >Grade 8</option>
         <option value="Grade 9" <?php selected($details['grade'],'Grade 9');?> >Grade 9</option>
         <option value="Grade 10"<?php selected($details['grade'],'Grade 10');?> >Grade 10</option>
      </select>
   </label>
 
   <label class="te_label">
      <span class="te_label_text">Salary</span>
      <select name="_te_job_array_fields[salary]" id="te_job_salary_field">
         <option value="£19,000 - £20,000" <?php selected($details['salary'],'£19,000 - £20,000');?> >£19,000 - £20,000</option>
         <option value="£20,000 - £21,000" <?php selected($details['salary'],'£20,000 - £21,000');?> >£20,000 - £21,000</option>
         <option value="£21,000 - £22,000" <?php selected($details['salary'],'£21,000 - £22,000');?> >£21,000 - £22,000</option>
         <option value="£22,000 - £23,000" <?php selected($details['salary'],'£22,000 - £23,000');?> >£22,000 - £23,000</option>
         <option value="£23,000 - £24,000" <?php selected($details['salary'],'£23,000 - £24,000');?> >£23,000 - £24,000</option>
         <option value="£24,000 - £25,000" <?php selected($details['salary'],'£24,000 - £25,000');?> >£24,000 - £25,000</option>
         <option value="£25,000 - £26,000" <?php selected($details['salary'],'£25,000 - £26,000');?> >£25,000 - £26,000</option>
         <option value="£26,000 - £27,000" <?php selected($details['salary'],'£26,000 - £27,000');?> >£26,000 - £27,000</option>
         <option value="£27,000 - £28,000" <?php selected($details['salary'],'£27,000 - £28,000');?> >£27,000 - £28,000</option>
         <option value="£28,000 - £29,000" <?php selected($details['salary'],'£28,000 - £29,000');?> >£28,000 - £29,000</option>
      </select>
   </label>
      
   <label class="te_label">
      <span class="te_label_text">Location</span>         
      <select name="_te_job_array_fields[location]" id="te_job_location_field">
         <option value="Aberdeen" <?php selected($details['location'],'Aberdeen');?> >Aberdeen</option>
         <option value="Culterty" <?php selected($details['location'],'Culterty');?> >Culterty</option>
         <option value="Banchory" <?php selected($details['location'],'Banchory');?> >Banchory</option>
      </select>
   </label>
      
   <label class="te_label">
      <span class="te_label_text">Ref.</span>      
      <input 
         id="te_job_ref_field" 
         name="_te_job_array_fields[ref]" 
         value="<?php echo esc_attr($details['ref']);  ?>"
         type="text">
   </label>
      
   <label class="te_label">
      <span class="te_label_text">Closing Date</span>
      <input
         id="te_job_closing_date_field" 
         name="_te_job_array_fields[closing_date]" 
         value="<?php echo esc_attr($details['closing_date']);  ?>"
         type="text">         
   </label>
