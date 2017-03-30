jQuery(document).ready(function($){ 
    //var result = $('#gavias-blockbuilder-setting input:not(.input-file-upload), #gavias-blockbuilder-setting select, #gavias-blockbuilder-setting textarea').serializeObject();
   //result = $.extend({}, result);
   //console.log(JSON.stringify(result));
   
  $('.cpb-form-setting-save').click(function(){
    var result = $('#gavias-blockbuilder-setting input:not(.input-file-upload), #gavias-blockbuilder-setting select, #gavias-blockbuilder-setting textarea').serializeObject();
    result = $.extend({}, result);
    console.log(JSON.stringify(result));
    result = base64Encode(JSON.stringify(result));
    
    var pid = $("#custom_pagebuilder_page_id").val();
    console.log(pid);
    var data = {
       data: result,
       pid: pid
    };
    console.log(data);
    $.ajax({
         url: drupalSettings.custom_pagebuilder.saveConfigURL,
         type: 'POST',
         data: data,
         dataType: 'json',
         success: function (data) {
             //console.log(data);
            alert("Save Data");
          //$('#save').val('Save');
          //notify('success', 'Block Builder setting updated');
          //window.location = drupalSettings.gavias_blockbuilder.url_redirect;
         },
         error: function (jqXHR, textStatus, errorThrown) {
           //alert(textStatus + ":" + jqXHR.responseText);
           //notify('black', 'Block Builder setting not updated');
         }
      });
  }) 
  
})