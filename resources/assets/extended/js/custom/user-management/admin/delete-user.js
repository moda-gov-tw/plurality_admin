// Class definition

var DeleteUser = function() {

  var _delete = function(userID){
    var o = document.getElementById("kt_table_users");
    var table = $(o).DataTable();

    $.ajax({
      async: true,
      headers:{
        'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      dataType:"json",
      data: { id: userID },
      url: "/user-management/delete-admin-user",
      success: function (data) {
        
        if(data.success == false){
          alert(data.errors);
        }

        table.ajax.reload();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(thrownError);
      }
    });
  };


  var _init = function() {
    
    $('#kt_table_users').on('click','.delete-user',function(){
    
      var user_id = $(this).attr('data-user-id');

      $.ajax({
        async: true,
        type: "GET",
        dataType:"json",
        url: "/user-management/get-admin-user/"+user_id,
        success: function (response) {
          
          // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
          Swal.fire({
            html:response.message + response.user_name,
            icon: "warning",
            buttonsStyling: false,
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: response.button_text, 
            cancelButtonText: response.cancel_button_text,
            customClass: {
              confirmButton: "btn btn-warning",
              cancelButton: "btn btn-danger"
            }
          }).then(function(result) {
            if (result.isConfirmed) {
              _delete(response.user_id);
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
  DeleteUser.init();
});