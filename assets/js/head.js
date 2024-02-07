(function($) {

    function setViewport() {
        var viewport = document.querySelector('meta[name="viewport"]');

        if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
            if (window.innerWidth < 500) {
           
                viewport.setAttribute('content', 'width=device-width, initial-scale=1, user-scalable=no');
                
            } else {
                viewport.setAttribute('content', 'width=1360,user-scalable=yes');
                
                slider_home_banner();
            }

            let portrait = window.matchMedia("(orientation: portrait)");

            portrait.addEventListener("change", function(e) {
                if(e.matches) {
                    location.reload();
                } else {
                    location.reload();
                }
            })

        }else{
            if (window.screen.width < 500) {
           
                viewport.setAttribute('content', 'width=device-width, initial-scale=1, user-scalable=no');
               
               
            } else {
                viewport.setAttribute('content', 'width=1360,user-scalable=yes');
                
                slider_home_banner();
            }
            
        }

        
       
        
       
    }


    
    window.onload = setViewport;
    window.onresize = setViewport;
    setViewport()
    
   

    // if (navigator.userAgent.match(/(Lighthouse)/)) {
    //     $('#content > *').each(function (index){
    //         if(index > 1){
    //             $(this).remove();
    //         }
    //     });
    // }
    

    function slider_home_banner(){
    
        if(jQuery('.banner.is-full-height').length > 0){
            if (window.screen.width > 760 &&  window.screen.width < 1020 ) {
            
                if(jQuery(".banner.is-full-height .slide_style_banner_home").length > 0){
                    jQuery(".banner.is-full-height .slide_style_banner_home").html('<style>.select-language .banner.is-full-height{height:calc(100vw - 52em) !important} .banner.is-full-height{height:calc(100vw - 52em) !important}</style>');
                }else{
                    jQuery(".banner.is-full-height").append('<div class="slide_style_banner_home"> <style>.select-language .banner.is-full-height{height:calc(100vw - 52em) !important} .banner.is-full-height{height:calc(100vw - 52em) !important}</style></div>');
                }
                //jQuery(".slider-home.banner-homepage .slider .flickity-viewport").attr('height', '57em !important');
    
            }else{
                jQuery('.slide_style_banner_home').remove();
                
            }
    
        }else{
            setTimeout(() => {
                slider_home_banner();
            }, 100);
        }

       
        
        
    }
    slider_home_banner();


})(jQuery);
    