"use strict";

// Class definition
var DatePicker = function () {
    
    // Public functions
    return {
        // Initialization
        init: function () {
            $(".date").daterangepicker( {
                    autoApply: true,
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoUpdateInput: false,
                    minYear: 2000,
                    maxYear: parseInt(moment().format("YYYY"),12),
                    locale: {
                      format: 'YYYY-MM-DD'
                    }
                }, function(start, end, label) {
                    
                }
            ).on("apply.daterangepicker", function (e, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD'));
                $(picker).focus();
                
            });

        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    DatePicker.init();
});
