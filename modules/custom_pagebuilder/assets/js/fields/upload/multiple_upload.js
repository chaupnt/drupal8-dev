/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function($){
   // add
	$('.cpb-add-tab').click(function(){
		// increase tabs counter
		//var tabs_counter = $(this).siblings('.cpb-tabs-count');
		//tabs_counter.val(tabs_counter.val()*1 + 1);
		
		var name = $(this).attr('rel-name');
		var field_wrapper = $('.multiple-image-uploads-default');
		var new_image = field_wrapper.children('.field-group').clone(true);
		new_image.children('input.file-input').attr('name',name+'[][url_image]');

		$('.wrapper-fields-images-upload .field-group').after(new_image);
		
	}); 
});
