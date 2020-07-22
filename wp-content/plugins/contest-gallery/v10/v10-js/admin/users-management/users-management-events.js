jQuery(document).ready(function($){

    $(document).on('click','#cgRegistrationSearchReset',function () {

        $('#cgUsersManagement').click();

    });

    $(document).on('click','#cg_create_user_data_csv_submit',function () {

        var $cg_create_user_data_csv = $('#cg_create_user_data_csv');

        $cg_create_user_data_csv.insertBefore('#cgRegistrationSearchSubmit');

        var $cgUsersManagementForm = $('#cgUsersManagementForm');
        $cgUsersManagementForm.removeClass('cg_load_backend_submit');
        $cgUsersManagementForm.find('#cgRegistrationSearchSubmit').click();

        setTimeout(function () {
            // set back hidden input field
            $cg_create_user_data_csv.appendTo('#cg_create_user_data_csv_container');
            $cgUsersManagementForm.removeClass('cg_load_backend_submit');
            $(this).removeClass('cg_disabled_no_pointer_events');
        },100)

    });

});