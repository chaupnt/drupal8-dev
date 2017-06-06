/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function($){
   // add
	$('.cpb-add-images-field').click(function( event ){
      //event.preventDefault();
      var wrapper = $(this).closest('.cpbuilder-upload-image');
      var id_wrapper = wrapper.data('id_gen');
  		var image_count = wrapper.find('.wrapper-fields-images-upload .field-group').length + 1;
  		var name = $(this).attr('rel-name');
  		var field_wrapper = $(this).parent().prev('.multiple-image-uploads-default');//$('.multiple-image-uploads-default');
  		var new_image = field_wrapper.children('.field-group').clone();
                  wrapper.find('input.cpb-carousel-count').val(image_count);
                  new_image.find('input.title-carousel').attr('name', name+'[title]');
                  new_image.find('input.subtitle-carousel').attr('name', name+'[sub_title]');
  		new_image.find('input.file-input').attr('name',name+'[url_image]');
                  new_image.children('.wrapper-content-fields').attr('id', "cpbuilder-upload-carousel-"+ image_count +"-"+id_wrapper);
                  new_image.find('form.upload').attr('id', "upload-carousel-"+ image_count +"-"+id_wrapper);
  		new_image.appendTo(wrapper.find('.wrapper-fields-images-upload'));
		  auto_upload_image_form();  
	}); 
});
