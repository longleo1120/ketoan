(function($) {

    
    
    function single_banner_banner(){
        console.log('123456');
        if(jQuery('section.is-full-height').length > 0){
            if (window.screen.width > 760 &&  window.screen.width < 1020 ) {
            
                if(jQuery("section.is-full-height .section_style_banner").length > 0){
                    jQuery("section.is-full-height .section_style_banner").html('<style>.select-language section.is-full-height{height:calc(100vw - 52em) !important;min-height:unset !important;} section.is-full-height{height:calc(100vw - 52em) !important;min-height:unset !important;}</style>');
                }else{
                    jQuery("section.is-full-height").append('<div class="section_style_banner"> <style>.select-language section.is-full-height{height:calc(100vw - 52em) !important;min-height:unset !important;} section.is-full-height{height:calc(100vw - 52em) !important;min-height:unset !important;}</style></div>');
                }
                //jQuery(".slider-home.banner-homepage .slider .flickity-viewport").attr('height', '57em !important');
        
            }else{
                jQuery('.section_style_banner').remove();
                
            }
        
        }else{
            setTimeout(() => {
                single_banner_banner();
            }, 100);
            
        }
        
    }
    single_banner_banner();


})(jQuery);
    