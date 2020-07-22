cgJsClass.gallery.function.message.init = function (){

    cgJsClass.gallery.function.message.clickConfirm();
    cgJsClass.gallery.function.message.clickClose();

};
cgJsClass.gallery.function.message.show = function (message,isShowConfirm,functionToProcess,processArguments,$clickedButton){

    if(cgJsClass.gallery.vars.fullwindow){
        var $cgMessagesContainer = jQuery('#mainCGdiv'+cgJsClass.gallery.vars.fullwindow).find('#cgMessagesContainer');
        $cgMessagesContainer.addClass('cg_hide');
    }else{
        var $cgMessagesContainer = jQuery('#cgMessagesContainer');
    }
    var $cgMessagesContent = $cgMessagesContainer.find('#cgMessagesContent');
    $cgMessagesContainer.css('height','unset');

    // values will be reseted this way
    if(cgJsClass.gallery.user.isEventinProcess){
        $cgMessagesContainer.find('.cg-lds-dual-ring-div-gallery-hide').remove();
        $cgMessagesContainer.find('#cgMessagesContent').css({
            'display': 'table-cell',// required to position center user asking message
            'padding-top': '15px'
        });
        $cgMessagesContainer.removeClass('cg_confirm');
        $cgMessagesContainer.find('#cgMessagesClose, #cgMessagesContent').removeClass('cg_hide');
        $cgMessagesContent.html(message);
        cgJsClass.gallery.user.isEventinProcess = false;
        return;
    }else{
        $cgMessagesContainer.find('#cgMessagesContent').removeAttr('style');// set to normal becaus user question maybe changed it
    }

    jQuery('body').addClass('cg_message_opened');

    if(message=="" || message==0 || message==null){
        message='';
    }

    cgJsClass.gallery.function.message.resize();

    $cgMessagesContainer.find('#cgMessagesConfirm').remove();
    $cgMessagesContent.html(message);

    if(isShowConfirm){
        $cgMessagesContainer.addClass('cg_confirm')
            .append('<span id="cgMessagesConfirm">' +
                '<span class="cg_messages_confirm_answer cg_messages_confirm_answer_yes" data-cg-gid="'+$clickedButton.attr('data-cg-gid')+'" data-cg-image-id="'+$clickedButton.attr('data-cg-image-id')+'" data-function-to-process="'+functionToProcess+'">'+cgJsClass.gallery.language.Yes+'</span>' +
                '<span class="cg_messages_confirm_answer cg_messages_confirm_answer_no">'+cgJsClass.gallery.language.No+'</span></span>');
        $cgMessagesContainer.find('.cg_messages_confirm_answer_yes').data('processArguments',processArguments);
        $clickedButton.closest('.cg_show').addClass('cg_opacity_0_3');
    }

    /*    if(cgJsClass.gallery.vars.fullwindow){
            $cgMessagesContainer.removeClass('cg_hide');
        }*/

    cgJsClass.gallery.vars.messageContainerShown=true;

    // IMPORTANT! can be initiated again and again because bodyclick listener will be removed after close
    cgJsClass.gallery.function.message.addCloseMessageFrameOnBodyClick();

    $cgMessagesContainer.removeClass('cg_hide');

};
cgJsClass.gallery.function.message.loaderTemplate = '<div class="cg-lds-dual-ring-div-gallery-hide"><div class="cg-lds-dual-ring-gallery-hide"></div></div>';
cgJsClass.gallery.function.message.clickConfirm = function(){

    jQuery(document).on('click','.cg_messages_container .cg_messages_confirm_answer_yes',function (e) {

        var $element = jQuery(this);
        var functionsArray = $element.attr('data-function-to-process').split('.');

        var fullLiteralFunctionObjectPath = window;

        functionsArray.forEach(function(functionName){
            fullLiteralFunctionObjectPath = fullLiteralFunctionObjectPath[functionName]
        });

        fullLiteralFunctionObjectPath.call(null,$element);

        return false;

    });

    jQuery(document).on('click','.cg_messages_container .cg_messages_confirm_answer_no',function (e) {

        cgJsClass.gallery.function.message.close();
        return false;

    });

};
cgJsClass.gallery.function.message.addCloseMessageFrameOnBodyClick = function(){

    jQuery('body.cg_message_opened').on('click',function (e) {

        if(cgJsClass.gallery.user.isEventinProcess){
            return;
        }

        // can return because other events are responsible for this
        if(jQuery(e.target).closest('#cgMessagesContainer').length==1){
            return;
        }

        cgJsClass.gallery.function.message.close();

        return false;

    });

};
cgJsClass.gallery.function.message.clickCloseInitieted = false;
cgJsClass.gallery.function.message.clickClose = function (){
    if(!cgJsClass.gallery.function.message.clickCloseInitieted){

        cgJsClass.gallery.function.message.clickCloseInitieted = true;

        jQuery(document).on('click','.cg_messages_container',function(e){
            if(cgJsClass.gallery.user.isEventinProcess){
                return;
            }
            if(jQuery(this).find('.cg_messages_confirm_answer').length>=1){
                return;
            }
            cgJsClass.gallery.function.message.close();
        });

        jQuery(document).on('click','.cg_messages_container',function(e){
            if(cgJsClass.gallery.user.isEventinProcess){
                return;
            }
            cgJsClass.gallery.function.message.close();
        });

    }

};
cgJsClass.gallery.function.message.close = function (){

    var $cgMessagesContainer = jQuery('.cg_messages_container');
    var $cg_messages_confirm_answer_yes = $cgMessagesContainer.find('.cg_messages_confirm_answer_yes');

    if($cg_messages_confirm_answer_yes.length){
        var imageId = $cg_messages_confirm_answer_yes.attr('data-cg-image-id');
        var gid = $cg_messages_confirm_answer_yes.attr('data-cg-gid');
        jQuery('#mainCGallery'+gid).find('#cg_show'+imageId).removeClass('cg_opacity_0_3');
    }

    $cgMessagesContainer.addClass('cg_hide').removeAttr('style').removeClass('cg_confirm');
    $cgMessagesContainer.find('#cgMessagesContent').empty();
    $cgMessagesContainer.find('#cgMessagesConfirm').remove();
    $cgMessagesContainer.find('.cg-lds-dual-ring-div-gallery-hide').remove();
    $cgMessagesContainer.find('#cgMessagesClose, #cgMessagesContent').removeClass('cg_hide');
    $cgMessagesContainer.find('#cgMessagesContent').removeAttr('style');
    cgJsClass.gallery.vars.messageContainerShown=false;
    cgJsClass.gallery.function.message.removeCloseMessageFrameOnBodyClick();

};
cgJsClass.gallery.function.message.removeCloseMessageFrameOnBodyClick = function(){

    jQuery('body.cg_message_opened').off('click');
    jQuery('body').removeClass('cg_message_opened');

};
cgJsClass.gallery.function.message.resize = function (){

    var $cgMessagesContainer = jQuery('.cg_messages_container');

    var left = jQuery(window).width()/2-250/2;
    $cgMessagesContainer.css('left',left+'px');
    //$cgMessagesContainer.removeClass('cg_hide');

};