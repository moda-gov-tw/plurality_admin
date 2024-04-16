"use strict";
var ChangeUserRole = function() {
	
	var getUserRoleForm,updateUserRoleForm,m,changeUserRoleModal,modelContent,updateUserRoleSubmitButton;

	getUserRoleForm = $('#get_user_role_form');
	changeUserRoleModal = $('#modal_change_user_role');
	modelContent = $('#modal_change_user_role div.modal-content');
	

	
	var initialModal = function(e) {
		
		updateUserRoleForm = $('#update_user_role_form');
		updateUserRoleSubmitButton = $('#update_user_role_submit');

		updateUserRoleSubmitButton.on('click', function(e) {
            // Prevent button default action
            e.preventDefault();

            // Disable button to avoid multiple click
            updateUserRoleSubmitButton.prop('disabled',true);

            //deprecated: replace by progressing bar
            // updateUserRoleSubmitButton.attr('data-kt-indicator', 'on');
            
            

            // Simulate ajax request
            axios.post(updateUserRoleForm.attr('action'), new FormData(updateUserRoleForm[0]))
                .then(function(response) {

                	ReloadDataTable.reload();

                    // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    Swal.fire({
                        text: response.data.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function(result) {
                        if (result.isConfirmed) {
                        	changeUserRoleModal.modal('hide');
                        }
                    });
                })
                .catch(function(error) {

                    console.log(error);
                    
                })
                .then(function() {
                    
                    
                });

        });


		return;
	}

	return {
		init: function(e) {


	                $('#kt_table_users tbody').on('click','[data-kt-users-table-filter="change_user_row"]',function(t){
	                    t.preventDefault();
	                    console.log('click');
	                    
	                    //set the user id that wanna be updated
	                    var user_id = $(this).attr('data-user-id');
	                    var row_id = $(this).attr('data-row-id');
	                    $('#get_user_role_id').attr('value',user_id);

	                    //set for datatable row data update
	                    $('#update_row_id').attr('value',row_id);
	                    $('#update_row_user_id').attr('value',user_id);


	                    // display loading bar, before request
			            const myInterceptor = axios.interceptors.request.use(function (config) {
			                modelContent.html('<div class="modal-body"><div class="progress"><div class="progress-bar progress-bar-success progress-bar-striped active progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%; height: 40px"></div></div></div>');

			                return config;
			            }, function (error) {
			                return Promise.reject(error);
			            });



	                    // Simulate ajax request
		            	axios.post(getUserRoleForm.attr('action'), new FormData(getUserRoleForm[0]))
		                .then(function(response) {
		                	
		                	modelContent.html(response.data.modelContent);
		                	initialModal();

		                	
		                })
		                .catch(function(error) {
		                    console.log(error);
		                    
		                })
		                .then(function() {
		                    axios.interceptors.request.eject(myInterceptor);
		                });

	                })
	            
				
		}
	}
}();

var ReloadDataTable = function() {

	function TrToData(row) {
	   return $(row).find('td').map(function(i,el) {
	        return el.innerHTML;
	   }).get();
	}
    
    
        
    return {
        reload: function() {
        	console.log('reload');
        	var e, o = document.getElementById("kt_table_users");

    		var table = $(o).DataTable();
            var reloadDatatableForm;

			reloadDatatableForm = $('#reload_datatable_form');
			
			// Simulate ajax request
            axios.post(reloadDatatableForm.attr('action'), new FormData(reloadDatatableForm[0]))
                .then(function(response) {
                	
                	var roleCell = table.cell($('#update_row_id').attr('value'),1);
                	roleCell.data(response.data).draw();

                	
                })
                .catch(function(error) {

                    console.log(error);
                    
                })
                .then(function() {
                    
                });
        }
    }
}();

jQuery(document).ready(function() {
	ChangeUserRole.init();
	
});

