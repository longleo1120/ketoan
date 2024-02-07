jQuery(document).ready(function( $ ) {
    $(".share-job a.copy-link").click(function() {
        const url = window.location.href;
        navigator.clipboard.writeText(url)
            .then(() => {
                $('.share-job a.copy-link .tooltiptext').show();
                setTimeout(function() {
                    $('.share-job a.copy-link .tooltiptext').hide();
                }, 1500);
            })
            .catch((error) => {
                console.error(`Could not copy ${url} to clipboard: ${error}`);
            });
    });
  
        var wpcf7Elm = document.querySelector("#wpcf7-f40-o2 form");
    
        wpcf7Elm.addEventListener( 'wpcf7mailsent', function( event ) {
    
            //var data_id = document.querySelector("#progress-apply").getAttribute('data-id');
            //var value_job = document.querySelector("#progress-apply").getAttribute('value');
            var data_id = document.querySelector(".progress-bar").getAttribute('data-id');
            $.ajax({
              type : "post",
              dataType : "json", 
              url : ajaxurl,
              data : {
                'action': 'save_apply_job',
                data_id:data_id,
                //value_job:value_job,
              },
              success: function(response) {
                  if(response.success) {
                    console.log( 'Thành công');
                  }
                  else {
                    console.log( 'lỗi 1');
                  }
              },
              error: function( response){
                  console.log( 'lỗi');
              }
          })
        
        }, false );
    

    $(".file-job .wpcf7-form-control-wrap .wpcf7-file").on('change', function() {
        var fp = $(this);
        var lg = fp[0].files.length; // get length
        var items = fp[0].files;
        var fileName = '';
        if (lg > 0) {
          for (var i = 0; i < lg; i++) {
            fileName = items[i].name; // get file name
          }
          $(".file-job .label-file span").html(fileName);
        }
    });
});