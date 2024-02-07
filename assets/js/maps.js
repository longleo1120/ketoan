var geocoder = null;
var map = null;
var customerMarker = null;
var gmarkers = [];
var closest = [];
//var map, infoWindow;

function initialize() {
    // alert("init");
    var directionsService = new google.maps.DirectionsService;
    var directionsRenderer = new google.maps.DirectionsRenderer;

    var lat_load = jQuery('.item-store.store-0').attr('data-lat');
    var lng_load = jQuery('.item-store.store-0').attr('data-lng');


    geocoder = new google.maps.Geocoder();
    // map = new google.maps.Map(document.getElementById('googleMap'), {
    //     zoom: 17,
    //     center: new google.maps.LatLng(lat_load, lng_load),
    //     mapTypeId: google.maps.MapTypeId.ROADMAP
    // });

}


function sortByDist(a, b) {
  return (a.distance - b.distance)
}

function sortByDistDM(a, b) {
  return (a.distance.value - b.distance.value)
}
function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(
      browserHasGeolocation
        ? "Error: The Geolocation service failed."
        : "Error: Your browser doesn't support geolocation."
    );
    infoWindow.open(map);
}
  


google.maps.event.addDomListener(window, 'load', initialize);


jQuery(document).on('click','#btn-search-store', function(){
    jQuery('.list-store-item').text('Đang tìm kiếm nhà hàng...');
    
    if (navigator.geolocation) {
        //var infowindow = new google.maps.InfoWindow();
        // var infoWindow = new google.maps.InfoWindow({
        //     content: name
        // });
        //navigator.geolocation.getCurrentPosition(showPosition);
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
        
                // infoWindow.setPosition(pos);
                // infoWindow.setContent("Bạn đang ở đây");
                // infoWindow.open(map);
                //map.setCenter(pos);

                store_load_maps(pos.lat,pos.lng);

            },
            () => {
                //handleLocationError(true, infoWindow, map.getCenter());
            }

        );

    } else { 
        
        console.log("Geolocation is not supported by this browser."); 
    }
    console.log(navigator.geolocation);
});


function store_load_maps(lat,lng){
    
    if(lat != '' && lng != ''){
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                'action': 'load_store_nearby',
                lat:lat,
                lng:lng,
            },
            beforeSend:function(response){
                
            },
            success: function(response){
                jQuery('.wrap-store-main .list-store-item').html(response);
            },
    
            error: function (response) {
                console.log(e.message);
            }
        });
    }else{
        console.log('maps ko dc truy cap');
    }

    
}




jQuery(document).on('click','#btn-call-store', function(){
   
    jQuery('#list-phone-number-store').text('Đang tìm kiếm nhà hàng...');
    
    if (navigator.geolocation) {
        //var infowindow = new google.maps.InfoWindow();
        var infoWindow = new google.maps.InfoWindow({
            content: name
        });
        //navigator.geolocation.getCurrentPosition(showPosition);
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
        
                infoWindow.setPosition(pos);
                infoWindow.setContent("Bạn đang ở đây");
                infoWindow.open(map);
                //map.setCenter(pos);
                //console.log(pos.lat,pos.lng);
                store_load_maps_lightbox(pos.lat,pos.lng);

            },
            () => {
                handleLocationError(true, infoWindow, map.getCenter());
            }

        );

    } else { 
        
        console.log("Geolocation is not supported by this browser."); 
    }
    console.log(navigator.geolocation);
});
 
function store_load_maps_lightbox(lat,lng){
    if(jQuery('#list-phone-number-store .store-list-phone').length > 0){
        
    }else{
        if(lat != '' && lng != ''){
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    'action': 'load_store_nearby_light_box',
                    lat:lat,
                    lng:lng,
                },
                beforeSend:function(response){
                    
                },
                success: function(response){
                    jQuery('#list-phone-number-store').html(response);
                },
        
                error: function (response) {
                    console.log(e.message);
                }
            });
        }else{
            console.log('cannot access maps');
        }
    }
    

    
}