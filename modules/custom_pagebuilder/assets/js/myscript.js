jQuery(document).ready(function($){ 
    
    $('.color').colorPicker();
    
                // Live binding of buttons
    $(document).on('click', '.action-placement', function(e) {
        $('.action-placement').removeClass('active');
        $(this).addClass('active');
        $('.icp-opts').data('iconpicker').updatePlacement($(this).text());
        e.preventDefault();
        return false;
    });
    
    $('.icp-dd').iconpicker({});
    
    $(".iconpicker-item").on('click', function() {
        var $option = $(this).closest('.wrapper-custom-icon-fa');
        var class_name = $(this).attr('title').replace(".", "");
        $option.find('.iconpicker-component').html('<i class="fa '+ class_name +'"></i>');
        $option.next().val('fa ' + class_name);
    })
  
})