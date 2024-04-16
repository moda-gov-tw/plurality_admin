// Class definition

var DeleteExhibition = function() {

  var _delete = function(productID){
    var o = document.getElementById("exhibition_list_table");
    var table = $(o).DataTable();

    $.ajax({
      async: true,
      headers:{
        'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      dataType:"json",
      data: { id: productID },
      url: "/content-management/delete-exhibition",
      success: function (data) {
        
        if(data.success == false){
          alert(data.errors);
        }
        else{
          Swal.fire({
              text: data.message,
              icon: "success",
              buttonsStyling: false,
              confirmButtonText: "Ok",
              customClass: {
                  confirmButton: "btn btn-primary"
              }
          }).then(function(result) {
              
          });
        }

        table.ajax.reload();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(thrownError);
      }
    });
  };


  var _init = function() {

    
    $('#exhibition_list_table').on('click','.delete-exhibition',function(){
    
      var exhibition_id = $(this).attr('data-exhibition-id');

      $.ajax({
        async: true,
        type: "GET",
        dataType:"json",
        url: "/content-management/get-exhibition/"+exhibition_id,
        success: function (response) {
          
          // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
          Swal.fire({
            html:response.message + response.exhibition_title,
            icon: "warning",
            buttonsStyling: false,
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: response.button_text, 
            cancelButtonText: response.cancel_button_text,
            customClass: {
              confirmButton: "btn btn-danger",
              cancelButton: "btn btn-secondary"
            }
          }).then(function(result) {
            if (result.isConfirmed) {
              _delete(response.exhibition_id);
            }
          });
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
      });
    });



  };

  return {
    init: function() {
      _init();
    },
  };
}();

jQuery(document).ready(function() {
  DeleteExhibition.init();
});