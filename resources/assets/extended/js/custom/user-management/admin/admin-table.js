"use strict";

var AdminUsersList = function() {
    var table = $("#kt_table_users");
    
    var ajaxUrl = '/user-management/get-admin-users';
    return {
        init: function() {
            table.DataTable({ 
                scrollX: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                order: [
                    [2, "desc"]
                ],
                lengthMenu: [[5, 10, 50, -1], [5, 10, 50, "All"]],
                pageLength: 5,
                columnDefs: [{
                    orderable: !1,
                    targets: 3
                }],
                ajax: {
                    url: ajaxUrl,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataSrc:'data'
                },
                "columns": [
                    { "data": "name" },
                    { "data": "role" },
                    { "data": "created_at" },
                    { "data": "actions" }
                ],
                buttons: [
                ],
            })  
        }
    }
}();


jQuery(document).ready(function() {
    
    AdminUsersList.init();
});