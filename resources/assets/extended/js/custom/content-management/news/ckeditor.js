"use strict";

// Class definition
var NewsCKeditor = function () {
    
    // Public functions
    return {
        // Initialization
        init: function () {
            ClassicEditor
            .create(document.querySelector('#news_content'),{
                ckfinder: {
                    
                    // Upload the images to the server using the CKFinder QuickUpload command.
                    uploadUrl: "/content-management/upload-image?_token="+$('meta[name="csrf-token"]').attr('content'),
                },
            })
            .then(editor => {
                // console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });

        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    NewsCKeditor.init();
});
