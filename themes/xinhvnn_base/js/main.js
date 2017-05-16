/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function($) {

    $(".btn-filter-portfolio").click(function () {
        selectedClass = $(this).attr("data-rel");
        var wrapper = $(this).closest('.wrapper-portfolio-content');
        wrapper.find('.portfolio-content').fadeTo(100, 0.1);
        wrapper.find('.portfolio-content div').not("." + selectedClass).fadeOut().removeClass("scale-anm");

        setTimeout(function () {
            wrapper.find('.portfolio-content .' + selectedClass).fadeIn().addClass("scale-anm");
                    wrapper.find('.portfolio-content').fadeTo(300, 1);
        }, 300);
    });
    
    if($('.owl-carousel').length > 0) {
        $('.owl-carousel').owlCarousel();
    }

    $('.nav-tabs a.nav-link').click(function(e){
        //e.preventDefault()
        //$(this).tab('show')
    });

});