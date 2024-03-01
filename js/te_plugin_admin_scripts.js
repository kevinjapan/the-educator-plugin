//
// Admin scripts for The Educator Plugin
//

// 
// Handler for select image for Schools Custom Taxonomy (admin)
// uses WP Media Lib for img selection
// 
jQuery(function($){
   $('body').on('click', '.aw_upload_image_button', function(e){
       e.preventDefault();
       aw_uploader = wp.media({
           title: 'Custom image',
           button: {
               text: 'Use this image'
           },
           multiple: false
       }).on('select', function() {
            var attachment = aw_uploader.state().get('selection').first().toJSON();
            $('#school_image').val(attachment.url);

            // we trigger event to notify any event listeners that we have changed text
            var evt = new CustomEvent('change');
            document.getElementById('school_image').dispatchEvent(evt);
       })
       .open();
   });
});


// 
// Custom taxonomy - change the image if the associated text input field changes (admin)
//
const school_image = document.getElementById('school_image')
if(school_image) {
   school_image.addEventListener('change',(event) => {      
      const school_image_elem = document.getElementById('school_image_elem')
      if(school_image_elem) {
         school_image_elem.src = event.target.value
      }
   }) 
}
