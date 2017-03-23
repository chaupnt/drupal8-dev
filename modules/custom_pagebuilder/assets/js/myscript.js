jQuery(document).ready(function($){ 
  console.log(drupalSettings.custom_pagebuilder.saveConfigURL);
  $('.cpb-form-setting-save').click(function(){
    var result = $('#gavias-blockbuilder-setting input:not(.input-file-upload), #gavias-blockbuilder-setting select, #gavias-blockbuilder-setting textarea').serializeObject();
    result = $.extend({}, result);
    result = base64Encode(JSON.stringify(result));
      //console.log(result);
    var pid = $("input[name=custom_pagebuilder_page_id]").val();
    var data = {
       data: result,
       pid: pid
    };
    $.ajax({
         url: drupalSettings.custom_pagebuilder.saveConfigURL,
         type: 'POST',
         data: data,
         dataType: 'json',
         success: function (data) {
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