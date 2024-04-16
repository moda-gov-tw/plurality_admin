"use strict";
var AccountSettingsChangePassword = function() {
    // Elements
    var form;
    var submitButton;
    var handleForm = function(e) {


        // Handle form submit
        submitButton.on('click', function(e) {
            // Prevent button default action
            e.preventDefault();
            
            // Disable button to avoid multiple click
            submitButton.prop('disabled',true);
            submitButton.attr('data-kt-indicator', 'on');

            // Simulate ajax request
            axios.post(form.attr('action'), new FormData(form[0]))
                .then(function(response) {

                    $('.errors').html('');

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

                        }
                    });

                    $('#currentpassword').val('');
			        $('#newpassword').val('');
			        $('#newpassword_confirmation').val('');
                })
                .catch(function(error) {
                    let dataMessage = error.response.data.message;
                    let dataErrors = error.response.data.errors;
                    $('.errors').html('');
                    for (const errorsKey in dataErrors) {
                        $('#'+errorsKey+'_error').html(dataErrors[errorsKey]);
                    }
                    
                })
                .then(function() {
                    // always executed
                    // Hide loading indication
                    submitButton.removeAttr('data-kt-indicator');

                    // Enable button
                    submitButton.prop('disabled',false);
                });

        });

    }

    // Public Functions
    return {
        // public functions
        init: function() {
            form = $('#kt_signin_change_password');
            submitButton = $('#kt_password_submit');

            
            handleForm();
        }
    };
}();
jQuery(document).ready(function() {
    AccountSettingsChangePassword.init()
});
