cgJsClass.gallery.function.general.ajax = {
    changesRecognized: function($){

        $(document).on('click','.cgChangeTopControlsStyleOptionClose',function () {

            var $element = $(this);
            var gid = $element.attr('data-cg-gid');

            var $cgChangeTopControlsStyleOption = $element.closest('.cgChangeTopControlsStyleOption');

            if($cgChangeTopControlsStyleOption.find('.cgChangeTopControlsStyleOptionStartingStyle').val()=='cg_fe_controls_style_white'){
                $cgChangeTopControlsStyleOption.find('.cgChangeTopControlsStyleOptionTestWhiteSites').click();
            }else{
                $cgChangeTopControlsStyleOption.find('.cgChangeTopControlsStyleOptionTestBlackSites').click();
            }

            // remove already here for instant removing
            $cgChangeTopControlsStyleOption.remove();

            jQuery.ajax({
                url: post_cg_changes_recognized_wordpress_ajax_script_function_name.cg_changes_recognized_ajax_url,
                method: 'post',
                data : {
                    action : 'post_cg_changes_recognized',
                    gid : cgJsData[gid].vars.gidReal,
                    galeryIDuser : gid,
                    galleryHash : cgJsData[gid].vars.galleryHash
                }
            }).done(function(response) {

                // script[data-cg-processing="true"]' does not exist in response in this case
/*                var parser = new DOMParser();
                var parsedHtml = parser.parseFromString(response, 'text/html');
                var script = jQuery(parsedHtml).find('script[data-cg-processing="true"]').first().html();*/

            }).fail(function(xhr, status, error) {

                cgJsClass.gallery.function.message.show('Something went wrong removing changes information. Information will be visible again.');

            }).always(function() {

            });
        });

    }
};