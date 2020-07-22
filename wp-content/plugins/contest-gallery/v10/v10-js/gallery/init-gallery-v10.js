if(typeof cgJsFrontendArea == 'undefined'){
    cgJsClass = {};
}
if(typeof cgJsClass == 'undefined'){// !IMPORTANT otherwise might be broken if upload form after and gallery not visible
    cgJsClass = {};
}

cgJsClass = cgJsClass || {};
cgJsClass.gallery = cgJsClass.gallery ||  {};
cgJsClass.gallery.vars = cgJsClass.gallery.vars ||  {};
cgJsClass.gallery.language = cgJsClass.gallery.language ||  {};
cgJsClass.backend = true;
cgJsClass.gallery.dynamicOptions = cgJsClass.gallery.dynamicOptions ||  {};
cgJsClass.gallery.heightLogic = cgJsClass.gallery.heightLogic ||  {};
cgJsClass.gallery.thumbLogic = cgJsClass.gallery.thumbLogic ||  {};
cgJsClass.gallery.rowLogic = cgJsClass.gallery.rowLogic ||  {};
cgJsClass.gallery.documentclick = cgJsClass.gallery.documentclick ||  {};
cgJsClass.gallery.comment = cgJsClass.gallery.comment ||  {};
cgJsClass.gallery.views = cgJsClass.gallery.views ||  {};
cgJsClass.gallery.info = cgJsClass.gallery.info ||  {};
cgJsClass.gallery.sorting = cgJsClass.gallery.sorting ||  {};
cgJsClass.gallery.fbLike = cgJsClass.gallery.fbLike ||  {};
cgJsClass.gallery.getJson = cgJsClass.gallery.getJson ||  {};
cgJsClass.gallery.resize = cgJsClass.gallery.resize ||  {};
cgJsClass.gallery.hover = cgJsClass.gallery.hover ||  {};
cgJsClass.gallery.touch = cgJsClass.gallery.touch ||  {};
cgJsClass.gallery.categories = cgJsClass.gallery.categories ||  {};
cgJsClass.gallery.hashchange = cgJsClass.gallery.hashchange ||  {};
cgJsClass.gallery.user = cgJsClass.gallery.user ||  {};
cgJsClass.gallery.function = cgJsClass.gallery.function ||  {};
cgJsClass.gallery.function.search = cgJsClass.gallery.function.search ||  {};
cgJsClass.gallery.function.general = cgJsClass.gallery.function.general ||  {};
cgJsClass.gallery.function.general.ajax = cgJsClass.gallery.function.general.ajax ||  {};
cgJsClass.gallery.function.message = cgJsClass.gallery.function.message ||  {};
cgJsClass.gallery.uploadGeneral = cgJsClass.gallery.uploadGeneral ||  {};
/*var recursive = function(){
    jQuery(window).trigger('resize');
    console.log('resized');
    setTimeout(function () {
        recursive();
    },5000);
};
recursive();*/

jQuery(document).ready(function($){ //   return false;

    if(typeof cgJsFrontendArea == 'undefined'){
        return;
    }

    cgJsClass.gallery.vars.jQuery = $;

    $.fn.cgGoTo = function(){

        $('html, body').animate({
            scrollTop: $(this).offset().top - 100+'px'
        }, 'fast');
        return this; // for chaining...
    };


    cgJsClass.gallery.function.general.tools.checkIfIsChrome();
    cgJsClass.gallery.function.general.tools.checkIfIsSafari();
    cgJsClass.gallery.function.general.tools.checkIfIsFF();
    cgJsClass.gallery.function.general.tools.checkIfIsEdge();
    cgJsClass.gallery.function.general.tools.checkIfInternetExplorer();


    cgJsClass.gallery.function.general.mobile.check();

    if(cgJsClass.gallery.vars.isMobile==true){
        cgJsClass.gallery.vars.windowWidthLastResize=screen.width;
    }else{
        cgJsClass.gallery.vars.windowWidthLastResize=$(window).width();
    }

    cgJsClass.gallery.comment.init();
    cgJsClass.gallery.rating.init();
    cgJsClass.gallery.sorting.init();
    cgJsClass.gallery.fbLike.clickFbLikeDiv();
    cgJsClass.gallery.touch.init($);
   // cgJsClass.gallery.documentclick.init(); nicht notwendig aktuell!!!!
    cgJsClass.gallery.views.switchView.init();
    cgJsClass.gallery.function.message.init();
    cgJsClass.gallery.views.clickFurtherImagesStep.init();
    cgJsClass.gallery.function.search.init();
    cgJsClass.gallery.views.initSingleViewScroll();
    cgJsClass.gallery.views.keypress.init();
    cgJsClass.gallery.views.fullscreen.init();
    cgJsClass.gallery.views.fullwindow.init();
    cgJsClass.gallery.views.fullscreen.init();
    cgJsClass.gallery.hashchange.initCheckHashChangeEvent();
    cgJsClass.gallery.categories.initClick();

    var $mainCGallery = $('.mainCGallery');
    var length = $mainCGallery.length;

    // check if image was opened
    //cgJsClass.gallery.hashchange.checkHash(jQuery,null,null,true);

    cgJsClass.gallery.function.general.tools.testTopControlsStyle($);

    cgJsClass.gallery.vars.dom = {};
    cgJsClass.gallery.vars.dom.body = $('body');
    cgJsClass.gallery.vars.dom.html = $('html');

    cgJsClass.gallery.getJson.init($,$mainCGallery,0,length);

    cgJsClass.gallery.views.singleViewClickEvents.init($);

    cgJsClass.gallery.resize.init(jQuery);
    cgJsClass.gallery.upload.init(jQuery);
    cgJsClass.gallery.user.events(jQuery);


});
