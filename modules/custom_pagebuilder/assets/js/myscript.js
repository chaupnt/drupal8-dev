jQuery(document).ready(function($){ 
  $('.cpb-form-setting-save').click(function(){
    var result = $('#gavias-blockbuilder-setting input:not(.input-file-upload), #gavias-blockbuilder-setting select, #gavias-blockbuilder-setting textarea').serializeObject();
    result = $.extend({}, result);
    result = base64Encode(JSON.stringify(result));
      //console.log(result);
    var pid = $("input[name=gavias_blockbuilder_id]").val();
    var data = {
       data: result,
       pid: pid
    };
    console.log(result);
  }) 
  
})