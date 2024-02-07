(function ($) {
    window.addEventListener("load", updateFontSize);
    window.addEventListener("resize", updateFontSize);
    updateFontSize();
    jQuery(document).on('click', '.show-filter-advance', function() {
        jQuery('.advance-filter').slideToggle();
        jQuery(this).toggleClass('active');
    });
    jQuery(document).on('click', '#load-more-sidebar', function() {
        var numItems = $('.list-news-document .new-item').length
        if(numItems < 6){
            
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    'action': 'load_more_new_document',
                    numItems:numItems,
                },
                beforeSend:function(response){
                    console.log(response);
                },
                success: function(response){
                    jQuery('.list-news-document').append(response);
                },

                error: function (response) {
                    console.log(response);
                }
            });
        }
    });

    function updateFontSize() {
        var _width = window.innerWidth;
        if (_width >= 850) {
            var _font_size = parseInt((_width / 1680) * 100);
        } else {
            var _font_size = parseInt((_width / 390) * 100);
        }
        $('#body_font_size').html('<style>body {font-size: ' + _font_size + '%}</style>');
    }
    jQuery(document).on('click','.btn-link-copy', function(){
        // Select the text field
        jQuery(this).select();
        //jQuery(this).setSelectionRange(0, 99999); // For mobile devices
        //console.log('123');
        
        // Copy the text inside the text field
        navigator.clipboard.writeText(jQuery(this).attr('data-clipboard-text'));
        jQuery('.copied').css('display','block');
        setTimeout(function() {
            jQuery('.copied').css('display','none');
        }, 3000);
    });
    function checkScreenSize(){
        var newWindowWidth = $(window).width();
        if (newWindowWidth < 481) {            
            // if(jQuery('.menu-footer h3>button').length == 0){
            //     jQuery('.menu-footer h3').append('<button class="toggle" aria-label="Toggle"> <i class="icon-angle-down"></i> </button>');
            // }
        }
    }

    $(document).ready(function () {
        // jQuery(document).on('click','.menu-footer h3 button', function(){
        //     jQuery(this).closest('.col-inner').find('ul').slideToggle();
        //     jQuery(this).toggleClass('active-arrow');
        // });
        $('.slider-intro').slick({
            dots: true,
            infinite: true,arrows: false,
            speed: 500,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                  breakpoint: 480,
                  settings: {
                    arrows: false,
                    slidesToShow: 1
                  }
                }
              ]
          });
        $(window).on("resize", function (e) {
            checkScreenSize();
        });
        checkScreenSize();

    });
    $('.form-advance-filter select').select2({
        placeholder: 'This is my placeholder',
        allowClear: true
      });
      $('#type_document').select2({
        allowClear: false
      });
      jQuery(document).on('change','#province-store', function(){
        var id_province = jQuery('#province-store').val();
        jQuery.ajax({
          type: "POST",
          url: ajaxurl,
          data: {
              'action': 'load_ward_location',
              id_province:id_province,
          },
          beforeSend:function(response){
              console.log('Loading');
          },
          success: function(response){
              jQuery('#ward-store').html(response);
          },

          error: function (response) {
              console.log(e.message);
          }
        });

        store_load(id_province);
    });

    jQuery(document).on('change','#ward-store', function(){
      var id_ward = jQuery('#ward-store').val();
      store_load(id_ward);
    });

    function store_load(id_location){
     
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                'action': 'load_store_by_location',
                id_location:id_location,
                //id_ward:id_ward,
            },
            beforeSend:function(response){
                console.log('Loading');
            },
            success: function(response){
                jQuery('.wrap-store-main .list-store-item').html(response);
            },

            error: function (response) {
                console.log(e.message);
            }
        });
    }


    jQuery(document).on('click','.item-store', function(){
        jQuery('.list-store-item .item-store').removeClass('active');
        jQuery(this).addClass('active');
        var iframe_link = jQuery(this).find('.iframe-textarea').text();
        if(iframe_link.length){
            jQuery('.wrap-store-main .column-right').html(iframe_link);
        }
        
    });

})(jQuery);

// document.addEventListener('touchstart', onTouchStart, {passive: true});

// function onTouchStart(){
//     preventDefault();
// }