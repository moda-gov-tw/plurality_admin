"use strict";

// Class definition
var DatePicker = function () {
    
    // Public functions
    return {
        // Initialization
        init: function () {
            $(".date").daterangepicker({
                timePicker: true,
                locale: {
                    format: "YYYY/MM/DD hh:mm A"
                }
            });

        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    DatePicker.init();
});
