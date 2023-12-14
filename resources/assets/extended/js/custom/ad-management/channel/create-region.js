"use strict";

// Class definition
var CreateRegion = function () {


    var modelContent,createRegionForm,createRegionModal;

    createRegionForm = $('#create_region_form');
    createRegionModal = $('#modal_create_region');
    modelContent = $('#modal_create_region div.modal-content');

    // Public functions
    return {
        // Initialization
        init: function () {
            $('#create_region_button').on('click',function(t){

                t.preventDefault();

                // Simulate ajax request
                axios.post(createRegionForm.attr('action'), new FormData(createRegionForm[0]))
                .then(function(response) {
                    modelContent.html(response.data.modelContent);
                    StoreRegion.init();

                })
                .catch(function(error) {
                    console.log(error);
                    window.location.reload();

                })
                .then(function() {

                });

            })
        }
    };
}();

var StoreRegion = function () {
    var form,storeRegionModal;
    
    storeRegionModal = $('#modal_create_region');

    return {
        init: function () {
            $('#store_region_submit_button').on('click', function(t) {
                // Prevent button default action
                t.preventDefault();

                // Disable button to avoid multiple click
                $(this).prop('disabled',true);
                $(this).find('.indicator-label').hide();
                $(this).find('.indicator-progress').show();

                // Simulate ajax request
                axios.post($('#store_region_form').attr('action'), new FormData($('#store_region_form')[0]))
                .then(function(response) {


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
                            storeRegionModal.modal('hide');
                            var table = $('#channel_region_list_table').DataTable();
                            table.ajax.reload();
                        }
                    });
                })
                .catch(function(error) {
                    console.log(error.response.data.errors);

                    let dataErrors = error.response.data.errors;

                    $('.errors').html('');
                    for (const errorsKey in dataErrors) {
                        $('.'+errorsKey+'_error').html(dataErrors[errorsKey]);
                        $('input[name="'+errorsKey+'"]').addClass('is-invalid');
                    }


                })
                .then(function() {

                    // Hide loading indication
                    $('#store_region_submit_button').find('.indicator-label').show();
                    $('#store_region_submit_button').find('.indicator-progress').hide();
                    $('#store_region_submit_button').prop('disabled',false);
                });
            });
        }
    };
    

    
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    CreateRegion.init();
});