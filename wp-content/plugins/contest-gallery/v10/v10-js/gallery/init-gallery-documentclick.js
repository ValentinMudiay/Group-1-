cgJsClass.gallery.documentclick = {
    init: function (){

        jQuery(document).on('click',function(e){
            // reagiert so zu schnell auf click
/*            if(cgJsClass.gallery.vars.messageContainerShown){
                jQuery('#cgMessagesContainer').addClass('cg_hide');
                cgJsClass.gallery.vars.messageContainerShown=false;
            }*/
        });
    }
};