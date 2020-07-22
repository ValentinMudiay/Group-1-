<?php

// PLUGIN VERSION CHECK HERE --- END

//wp_enqueue_script( 'cg_v10_01_old_check_back_button_click', plugins_url( '/v10-js/01_old/cg_check_back_button_click.js', __FILE__ ), array('jquery'), '10.9.8.8.1');

//wp_enqueue_script( 'cg_v10_01_old_rate', plugins_url( '/v10-js/01_old/cg_rate.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );

//wp_enqueue_script( 'cg_v10_01_old_comment', plugins_url( '/v10-js/01_old/cg_comment.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );


/* script_loader_tag works only from WordPress 4.1 on
add_filter( 'script_loader_tag', function ( $tag, $handle ) {

    if ( 'cg_v10_show_gallery_jquery_gallery_init' !== $handle )
        return $tag;

    return str_replace( ' src', ' defer="defer" src', $tag );
}, 10, 2 );*/

wp_enqueue_script( 'jquery-touch-punch' );
wp_enqueue_script( 'jquery-ui-slider' );
wp_enqueue_script( 'jquery-ui-datepicker' );


wp_enqueue_style( 'cg_v10_contest_style',  plugins_url('/v10-css/style.css', __FILE__), false, '10.9.8.8.1' );
wp_enqueue_style( 'cg_v10_contest_gallery_form_style',  plugins_url('/v10-css/cg_gallery_form_style.css', __FILE__), false, '10.9.8.8.1' );
wp_enqueue_style( 'cg_v10_contest_general_form_style',  plugins_url('/v10-css/cg_general_form_style.css', __FILE__), false, '10.9.8.8.1' );
wp_enqueue_style( 'cg_datepicker_frontend',  plugins_url('/v10-css/cg_datepicker_frontend.css', __FILE__), false, '10.9.8.8.1' );


wp_enqueue_style( 'cg_v10_contest_style',  plugins_url('/v10-css/style.css', __FILE__), false, '10.9.8.8.1' );
wp_enqueue_style( 'cg_v10_css_general_rotate_image', plugins_url('/v10-css/general/cg_rotate_image.css', __FILE__), false, '10.9.8.8.1' );


//wp_enqueue_script( 'cg_v10_01_old_show_gallery_jquery', plugins_url( '/v10-js/01_old/show_gallery_jquery.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
//wp_enqueue_script( 'cg_v10_show_gallery_jquery_new', plugins_url( '/v10-js/gallery/show_gallery_jquery_new.js', __FILE__ ), array('jquery'), '10.9.8.8.1');


//wp_enqueue_style( 'cg_v10_contest_style_slider',  plugins_url('/v10-css/style_slider.css', __FILE__), false, '10.9.8.8.1' );
//wp_enqueue_script( 'cg_01_v10_old_show_gallery_jquery_image_slider', plugins_url( '/v10-js/01_old/show_gallery_jquery_image_slider_new_slider.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
//wp_enqueue_script( 'show_v10_gallery_jquery_image_slider_control', plugins_url( '/v10-js/01_old/show_gallery_jquery_image_slider_control.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );


wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_init', plugins_url( '/v10-js/gallery/init-gallery-v10.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_init_getjson', plugins_url( '/v10-js/gallery/init-gallery-getjson.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_init_resize', plugins_url( '/v10-js/gallery/init-gallery-resize.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_init_hover', plugins_url( '/v10-js/gallery/init-gallery-hover.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_init_touch', plugins_url( '/v10-js/gallery/init-gallery-touch.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_init_documentclick', plugins_url( '/v10-js/gallery/init-gallery-documentclick.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_init_indexeddb', plugins_url( '/v10-js/gallery/init-gallery-indexeddb.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_init_hashchange', plugins_url( '/v10-js/gallery/init-gallery-hashchange.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_init_comment', plugins_url( '/v10-js/gallery/comment/init-comment-v10.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_click_comment', plugins_url( '/v10-js/gallery/comment/click-comment-v10.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
//wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_open_comment_frame', plugins_url( '/v10-js/gallery/comment/open-comment-frame-v10.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_set_comments_single_image_view', plugins_url( '/v10-js/gallery/comment/set-comments-single-image-view.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_set_comment', plugins_url( '/v10-js/gallery/comment/setcomment.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_dynamic_options', plugins_url( '/v10-js/gallery/dynamic-options.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_show_gallery_jquery_gallery_sorting_init_sorting', plugins_url( '/v10-js/gallery/sorting/init-sorting.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_show_gallery_jquery_gallery_sorting_sort_desc', plugins_url( '/v10-js/gallery/sorting/sort-desc.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_show_gallery_jquery_gallery_sorting_sort_asc', plugins_url( '/v10-js/gallery/sorting/sort-asc.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_show_gallery_jquery_gallery_sorting_sort_byrowid', plugins_url( '/v10-js/gallery/sorting/sort-byrowid.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_show_gallery_jquery_gallery_sorting_sort_countc', plugins_url( '/v10-js/gallery/sorting/sort-countc.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_show_gallery_jquery_gallery_sorting_sort_countr', plugins_url( '/v10-js/gallery/sorting/sort-countr.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_show_gallery_jquery_gallery_sorting_sort_counts', plugins_url( '/v10-js/gallery/sorting/sort-counts.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_show_gallery_jquery_gallery_sorting_sort_random', plugins_url( '/v10-js/gallery/sorting/sort-random.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_show_gallery_jquery_gallery_sorting_sort_random_button', plugins_url( '/v10-js/gallery/sorting/sort-random-button.js', __FILE__ ), array('jquery'), '10.9.8.8.1');

wp_enqueue_script( 'cg_show_gallery_jquery_gallery_user_events', plugins_url( '/v10-js/gallery/user/user-events.js', __FILE__ ), array('jquery'), '10.9.8.8.1');

wp_enqueue_script( 'cg_show_gallery_jquery_gallery_fblike_setfblike', plugins_url( '/v10-js/gallery/fblike/setfblike.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_fblike_click_fblike_div', plugins_url( '/v10-js/gallery/fblike/click-fblike-div.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_rating', plugins_url( '/v10-js/gallery/rating/rating.js', __FILE__ ), array('jquery'), '10.9.8.8.1');

wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_setratingonestar', plugins_url( '/v10-js/gallery/rating/setratingonestar.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_setratingfivestar', plugins_url( '/v10-js/gallery/rating/setratingfivestar.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_init_order_gallery', plugins_url( '/v10-js/gallery/views/init-order-gallery.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_steps_init_clone_further_images_step', plugins_url( '/v10-js/gallery/views/steps/clone-further-images-step.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_close_single_view', plugins_url( '/v10-js/gallery/views/close-single-view.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_init_single_view_', plugins_url( '/v10-js/gallery/views/single/init-single-view.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_init_single_view_scroll', plugins_url( '/v10-js/gallery/views/single/init-single-view-scroll.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_init_single_view_click_events', plugins_url( '/v10-js/gallery/views/single/init-single-view-click-events.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_init_single_view_functions', plugins_url( '/v10-js/gallery/views/single/init-single-view-functions.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_steps_click_further_images_step', plugins_url( '/v10-js/gallery/views/steps/click-further-images-step.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_steps_check_further_images_step', plugins_url( '/v10-js/gallery/views/steps/check-further-images-steps.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_init_keypress', plugins_url( '/v10-js/gallery/views/init-keypress.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_function_search_init_search', plugins_url( '/v10-js/gallery/function/search/init-search.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_function_search_search_get_full_image_data_filtered', plugins_url( '/v10-js/gallery/function/search/search-get-full-image-data-filtered.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_function_search_search_input', plugins_url( '/v10-js/gallery/function/search/search-input.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_function_search_search_collect_data', plugins_url( '/v10-js/gallery/function/search/search-collect-data.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_function_message', plugins_url( '/v10-js/gallery/function/message/message.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_function_general_tools', plugins_url( '/v10-js/gallery/function/general/tools.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_function_general_check_filtered', plugins_url( '/v10-js/gallery/function/general/check-filtered.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_function_general_mobile', plugins_url( '/v10-js/gallery/function/general/mobile.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_function_general_time', plugins_url( '/v10-js/gallery/function/general/time.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_init_fullscreen', plugins_url( '/v10-js/gallery/views/init-fullscreen.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_init_fullwindow', plugins_url( '/v10-js/gallery/views/init-fullwindow.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_info_get_info', plugins_url( '/v10-js/gallery/info/get-info.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_info_set_info', plugins_url( '/v10-js/gallery/info/set-info.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_info_set_info_gallery_view', plugins_url( '/v10-js/gallery/info/set-info-gallery-view.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_info_set_info_single_image_view', plugins_url( '/v10-js/gallery/info/set-info-single-image-view.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_info_collect_info', plugins_url( '/v10-js/gallery/info/collect-info.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_switch_view', plugins_url( '/v10-js/gallery/views/switch-views.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_height_logic', plugins_url( '/v10-js/gallery/views/height-logic.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_thumb_logic', plugins_url( '/v10-js/gallery/views/thumb-logic.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_row_logic', plugins_url( '/v10-js/gallery/views/row-logic.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_views_functions', plugins_url( '/v10-js/gallery/views/functions.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_vars', plugins_url( '/v10-js/gallery/vars.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_categories_init', plugins_url( '/v10-js/gallery/categories/init-categories-v10.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_categories_storage', plugins_url( '/v10-js/gallery/categories/storage.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_categories_change', plugins_url( '/v10-js/gallery/categories/change.js', __FILE__ ), array('jquery'), '10.9.8.8.1');

// Achtung! Nicht von hier verschieben und die Reihenfolge beachten. Wp_enque kommt for wp_localize
wp_enqueue_script( 'cg_rate_v10_oneStar', plugins_url( '/v10-js/gallery/rating/click-rate-onestar.js', __FILE__ ), array('jquery'), '10.9.8.8.1');

wp_localize_script( 'cg_rate_v10_oneStar', 'post_cg_rate_v10_oneStar_wordpress_ajax_script_function_name', array(
    'cg_rate_v10_oneStar_ajax_url' => admin_url( 'admin-ajax.php' )
));

// Reihenfolge beachten
wp_enqueue_script( 'cg_rate_v10_fiveStar', plugins_url( '/v10-js/gallery/rating/click-rate-fivestar.js', __FILE__ ), array('jquery'), '10.9.8.8.1');

wp_localize_script( 'cg_rate_v10_fiveStar', 'post_cg_rate_v10_fiveStar_wordpress_ajax_script_function_name', array(
    'cg_rate_v10_fiveStar_ajax_url' => admin_url( 'admin-ajax.php' )
));


// Reihenfolge beachten
wp_enqueue_script( 'cg_gallery_form_upload', plugins_url( '/v10-js/gallery/upload/init-gallery-upload-form.js', __FILE__ ), array('jquery'), '10.9.8.8.1');

wp_localize_script( 'cg_gallery_form_upload', 'post_cg_gallery_form_upload_wordpress_ajax_script_function_name', array(
    'cg_gallery_form_upload_ajax_url' => admin_url( 'admin-ajax.php' )
));

wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_upload_validation', plugins_url( '/v10-js/gallery/upload/upload-validation.js', __FILE__ ), array('jquery'), '10.9.8.8.1');

wp_enqueue_script( 'cg_gallery_form_upload_functions', plugins_url( '/v10-js/gallery/upload/functions.js', __FILE__ ), array('jquery'), '10.9.8.8.1');

wp_enqueue_script( 'cg_show_set_comments_v10', plugins_url( '/v10-js/gallery/comment/show-set-comments-v10.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );

wp_localize_script( 'cg_show_set_comments_v10', 'cg_show_set_comments_v10_wordpress_ajax_script_function_name', array(
    'cg_show_set_comments_v10_ajax_url' => admin_url( 'admin-ajax.php' )
));

// user delete image. REIHENFOLGE BEACHTEN!
wp_enqueue_script( 'cg_gallery_user_delete_image', plugins_url( '/v10-js/gallery/user/user-delete-image.js', __FILE__ ), array('jquery'), '10.9.8.8.1');

wp_localize_script( 'cg_gallery_user_delete_image', 'post_cg_gallery_user_delete_image_wordpress_ajax_script_function_name', array(
    'cg_gallery_user_delete_image_ajax_url' => admin_url( 'admin-ajax.php' )
));

// message recognized. REIHENFOLGE BEACHTEN!
wp_enqueue_script( 'cg_changes_recognized', plugins_url( '/v10-js/gallery/function/general/ajax/changes-recognized.js', __FILE__ ), array('jquery'), '10.9.8.8.1');

wp_localize_script( 'cg_changes_recognized', 'post_cg_changes_recognized_wordpress_ajax_script_function_name', array(
    'cg_changes_recognized_ajax_url' => admin_url( 'admin-ajax.php' )
));

//wp_enqueue_script( 'post_cg_set_comment_v10', plugins_url( '/v10-js/gallery/comment/submit-comment-v10.js', __FILE__ ), array('jquery'), '10.9.8.8.1');

//wp_localize_script( 'post_cg_set_comment_v10', 'post_cg_set_comment_v10_wordpress_ajax_script_function_name', array(
//  'cg_set_comment_v10_ajax_url' => admin_url( 'admin-ajax.php' )
//));

@ob_start();

include("v10-frontend/v10-get-data.php");

$frontend_gallery = @ob_get_clean();

apply_filters( 'cg_filter_frontend_gallery', $frontend_gallery );