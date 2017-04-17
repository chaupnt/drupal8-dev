(function($) {
    $(function(){
        // Initialize the jQuery File Upload plugin
        $('.upload').each(function(){
            var $this = $(this);
            var $_id = $(this).attr('data-id');
            $(this).fileupload({
                add: function (e, data) {
                    if( typeof(data.form.context.id) != "undefined" ) {
                        var $_id = data.form.context.id;
                        //alert(data.form.context.id);
                        $('#cpbuilder-' + $_id + ' .loading').each(function(){
                                $(this).css('display', 'inline-block'); 
                        });
                        var jqXHR = data.submit().done(function(data){
                            data = JSON.parse(data);
                            $('#cpbuilder-' + $_id + ' .loading').each(function(){
                                $(this).css('display', 'none'); 
                            });
                            $('#cpbuilder-' + $_id + ' input.file-input').each(function(){
                                $(this).val(data['file_url']); 
                            });

                            $('#cpbuilder-' + $_id + ' .custompagebuilder-image-demo').each(function(){
                                $(this).attr('src', data['file_url_full']);
                            });

                            $('#cpbuilder-' + $_id + ' .custompagebuilder-field-upload-remove').each(function(){
                                $(this).css('display', 'inline-block');
                            });
                        });
                    }
                },

                progress: function(e, data){
                
                },
                fail: function(e, data){
                    // Something has gone wrong!
                    data.context.addClass('error');
                }
            });
        });
        $(document).ready(function () {
             custompagebuilder_load_images();
             custompagebuilder_choose_image();
        });

        function custompagebuilder_load_images(){
            $('.btn-get-images-upload').click(function(){
                $this = $(this);
                $.ajax({
                 url: drupalSettings.custom_pagebuilder.getImageUpload,
                 type: 'POST',
                 success: function (data) {
                    var html = '';
                    $.each(data['data'], function( index, value ) {
                        if(value['file_url_full'] != 'undefined' || value['file_url_full']){
                            html += '<a data-image="'+value['file_url']+'" data-image-demo="'+value['file_url_full']+'" class="btn-choose-image-upload" ><img src="'+value['file_url_full']+'"/></a>';
                        }
                    });
                   $this.parents('.cpbuilder-upload-image').find('.custompagebuilder-box-images .custompagebuilder-box-images-inner .list-images').each(function(){
                        $(this).html(html);
                        $(this).parents('.custompagebuilder-box-images').addClass('open-popup');
                    })
                },
                 error: function (jqXHR, textStatus, errorThrown) {
                   alert(textStatus + ":" + jqXHR.responseText);
                 }
              });
            });  
        }

        function custompagebuilder_choose_image(){

            $( ".cpbuilder-upload-image" ).delegate( ".btn-choose-image-upload", "click", function() {
                var file_url = $(this).attr('data-image');
                var file_url_full = $(this).attr('data-image-demo');
                $(this).parents('.cpbuilder-upload-image').find('input.file-input').each(function(){
                    $(this).val(file_url); 
                });

                $(this).parents('.cpbuilder-upload-image').find('.custompagebuilder-image-demo').each(function(){
                    $(this).attr('src', file_url_full);
                });

                $(this).parents('.cpbuilder-upload-image').find('.custompagebuilder-field-upload-remove').each(function(){
                    $(this).css('display', 'inline-block');
                });

                $(this).parents('.custompagebuilder-box-images').removeClass('open-popup');
            });

            $('.cpbuilder-upload-image .close').click(function(){
                $(this).parents('.custompagebuilder-box-images').removeClass('open-popup');
            });
        }

        // Helper function that formats the file sizes
        function formatFileSize(bytes) {
            if (typeof bytes !== 'number') {
                return '';
            }

            if (bytes >= 1000000000) {
                return (bytes / 1000000000).toFixed(2) + ' GB';
            }

            if (bytes >= 1000000) {
                return (bytes / 1000000).toFixed(2) + ' MB';
            }

            return (bytes / 1000).toFixed(2) + ' KB';
        }

    });

    $(document).ready(function(){
        $('.custompagebuilder-field-upload-remove').click(function(){
          $(this).parent().find('.custompagebuilder-image-demo').attr('src', $(this).attr("data-src"));
          $(this).parent().find('input.file-input').val('');
        })
    });

})(jQuery);