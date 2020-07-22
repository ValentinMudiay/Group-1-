<?php

wp_enqueue_script( 'jquery-touch-punch' );
wp_enqueue_script( 'jquery-ui-sortable' );

wp_enqueue_script( 'jquery-ui-datepicker' );

wp_enqueue_editor();


wp_enqueue_script( 'cg_gallery_admin_index_events', plugins_url( '/v10/v10-js/admin/index-events.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_script( 'cg_gallery_admin_index_functions', plugins_url( '/v10/v10-js/admin/index-functions.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_script( 'cg_gallery_admin_index_indexeddb', plugins_url( '/v10/v10-js/admin/index-indexeddb.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_script( 'cg_gallery_admin_objects', plugins_url( '/v10/v10-js/admin/gallery/gallery-admin-objects.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_script( 'cg_gallery_admin_functions', plugins_url( '/v10/v10-js/admin/gallery/gallery-admin-functions.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_style( 'cg_css_general_rotate_image', plugins_url('/v10/v10-css/general/cg_rotate_image.css', __FILE__), false, '10.9.8.8.1' );
wp_enqueue_script( 'cg_gallery_admin_events', plugins_url( '/v10/v10-js/admin/gallery/gallery-admin-events.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_script( 'cg_check_wp_admin_upload_v10', plugins_url( '/v10/v10-js/admin/gallery/cg_check_wp_admin_upload.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_style( 'cg_backend_gallery', plugins_url('/v10/v10-css/backend/cg_backend_gallery.css', __FILE__), false, '10.9.8.8.1' );

wp_enqueue_script( 'cg_js_admin_main_menu_events', plugins_url( '/v10/v10-js/admin/main-menu-events.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_script( 'cg_js_admin_main_menu_functions', plugins_url( '/v10/v10-js/admin/main-menu-functions.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );

wp_enqueue_script( 'cg_general_admin_functions', plugins_url( '/v10/v10-js/admin/general_admin_functions.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );

wp_enqueue_script( 'cg_js_admin_corrections_and_improvements', plugins_url( '/v10/v10-js/admin/options/corrections-and-improvements.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );


wp_enqueue_script( 'cg_js_admin_options_edit_options', plugins_url( '/v10/v10-js/admin/options/edit-options-events.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_script( 'cg_js_admin_options_edit_options_functions', plugins_url( '/v10/v10-js/admin/options/edit-options-functions.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_script( 'cg_color_picker_js', plugins_url( '/v10/v10-admin/options/color-picker.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
#wp_enqueue_script( 'cg_options_tabcontent_js', plugins_url( '/v10/v10-admin/options/cg_options_tabcontent.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_style( 'cg_datepicker_css', plugins_url('/v10/v10-admin/options/datepicker.css', __FILE__), false, '10.9.8.8.1' );
wp_enqueue_style( 'cg_color_picker_css', plugins_url('/v10/v10-admin/options/color-picker.css', __FILE__), false, '10.9.8.8.1' );

//wp_enqueue_script( 'cg_backend_bootstrap_js', plugins_url( '/v10/v10-js/admin/bootstrap.min.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
//wp_enqueue_style( 'cg_backend_bootstrap_css', plugins_url('v10-css/backend/cg_backend_bootstrap.css', __FILE__), false , '10.9.8.8.1' );


wp_enqueue_script( 'cg_js_admin_options_show_votes', plugins_url( '/v10/v10-js/admin/show_votes.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );

wp_enqueue_script( 'cg_js_admin_gallery_rotate_image', plugins_url( '/v10/v10-js/admin/gallery/rotate_image.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_style( 'cg_css_general_rotate_image', plugins_url('v10-css/general/cg_rotate_image.css', __FILE__), false, '10.9.8.8.1' );


wp_enqueue_style( 'cg_options_style_v10', plugins_url('v10-css/cg_options_style.css', __FILE__), false , '10.9.8.8.1' );
wp_enqueue_script( 'cg_admin_create_upload_create_upload_v10', plugins_url( '/v10/v10-js/admin/create-upload/create-upload-events.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_script( 'cg_admin_create_upload_create_upload_tinymce', plugins_url( '/v10/v10-js/admin/create-upload/create-upload-tinymce.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_script( 'cg_admin_create_upload_create_upload_v10_functions', plugins_url( '/v10/v10-js/admin/create-upload/create-upload-functions.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_script( 'cg_admin_create_upload_tinymce', plugins_url( '/v10/v10-js/admin/create-upload/tinymce.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );


wp_enqueue_script( 'cg_create_registry_events', plugins_url( '/v10/v10-js/admin/create-registry/create-registry-events.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
wp_enqueue_script( 'cg_create_registry_functions', plugins_url( '/v10/v10-js/admin/create-registry/create-registry-functions.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );


wp_enqueue_style( 'cg_backend_gallery', plugins_url('v10-css/backend/cg_backend_gallery.css', __FILE__), false, '10.9.8.8.1' );
wp_enqueue_script( 'cg_admin_users_management_users_management_v10', plugins_url( '/v10/v10-js/admin/users-management/users-management-events.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );


wp_enqueue_script( 'define_output', plugins_url( '/v10/v10-js/admin/define_output.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );


//wp_enqueue_script( 'change_text_inform_user', plugins_url( '/v10/v10-js/change_text_inform_user.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );


wp_enqueue_script( 'cg_check_wp_admin_upload_v10', plugins_url( '/v10/v10-js/admin/gallery/cg_check_wp_admin_upload.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );

/*        wp_localize_script( 'cg_gallery_view_control_backend', 'post_cg_gallery_view_control_backend_wordpress_ajax_script_function_name', array(
            'cg_gallery_view_control_backend_ajax_url' => admin_url( 'admin-ajax.php' )
        ));*/
wp_enqueue_script( 'cg_check_wp_admin_upload_v10', plugins_url( '/v10/v10-js/admin/gallery/cg_check_wp_admin_upload.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );


