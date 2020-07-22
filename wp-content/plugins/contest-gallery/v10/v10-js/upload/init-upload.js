if(typeof cgJsFrontendArea == 'undefined'){
    cgJsClass = {};
}

if(typeof cgJsClass === 'undefined'){
    cgJsClass = {};
}else{
    cgJsClass = cgJsClass;
}

cgJsClass.gallery = cgJsClass.gallery || {};
cgJsClass.gallery.function = cgJsClass.gallery.function  || {};
cgJsClass.gallery.function.message = cgJsClass.gallery.function.message  || {};
cgJsClass.gallery.vars = cgJsClass.gallery.vars  || {};
cgJsClass.gallery.vars.messageContainerShown=false;
cgJsClass.gallery.user = cgJsClass.gallery.user  || {};
cgJsClass.gallery.dynamicOptions = cgJsClass.gallery.dynamicOptions  || {};
cgJsClass.gallery.uploadGeneral = cgJsClass.gallery.uploadGeneral ||  {};

jQuery(document).ready(function($){ //   return false;

    if(typeof cgJsFrontendArea == 'undefined'){
        return;
    }

    cgJsClass.gallery.function.message.clickClose();

    cgJsClass.gallery.uploadGeneral.functions.events($);

    if($('#cgRegUserUploadOnly').val()==2 && $('#cgRegUserMaxUpload').val()>=1){

        var gid = $('#cgUploadFormGalleryId').val();

        var cookieName = 'contest-gal1ery-'+gid+'-upload';
        var cookieValue = cgJsClass.gallery.dynamicOptions.getCookie(cookieName);

        if(!cookieValue){
            cgJsClass.gallery.dynamicOptions.setCookie(gid,cookieName,$('#cgUploadCookieId').val());
        }

        var cookieValue = cgJsClass.gallery.dynamicOptions.getCookie(cookieName);

        if(!cookieValue && $('#cgUploadRequiresCookieMessage').val()){
            cgJsClass.gallery.function.message.show($('#cgUploadRequiresCookieMessage').val());
        }

    }

});
