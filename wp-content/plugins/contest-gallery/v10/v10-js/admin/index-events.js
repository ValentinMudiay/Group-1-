jQuery(document).ready(function($){

    cgJsClassAdmin.index.vars.cgVersionLocalStorageName = 'cgVersionLocalStorage'+'/'+location.hostname+location.pathname;

    cgJsClassAdmin.index.functions.checkIfIsIE();

    cgJsClassAdmin.index.indexeddb.init();

    cgJsClassAdmin.index.vars.wpVersion = cgJsClassAdmin.index.functions.getWpVersionAsInteger();

    if(location.hash!='' && location.hash!='#' && location.hash!='#main'){// then must be browser reload by user

        var cgBackendHashVal = cgJsClassAdmin.index.functions.cgLoadBackendLoader();

        var formPostData = new FormData();
        formPostData.append('action', 'post_contest_gallery_action_ajax');
        formPostData.append('cgBackendHash',cgBackendHashVal);

        cgJsClassAdmin.index.functions.cgLoadBackendAjax('?page=contest-gallery/index.php&'+location.hash.split('#')[1],formPostData);

    }else{// then must be main menu load

        var cgBackendHashVal = cgJsClassAdmin.index.functions.cgLoadBackendLoader();

        var formPostData = new FormData();
        formPostData.append('action', 'post_contest_gallery_action_ajax');
        formPostData.append('cgBackendHash',cgBackendHashVal);

        if(location.search.indexOf('option_id') >= 0 && location.search.indexOf('index.php&') >= 0){
            cgJsClassAdmin.gallery.vars.isHashJustChanged = true;
            cgJsClassAdmin.index.functions.cgLoadBackendAjax('?page=contest-gallery/index.php&'+location.search.split('index.php&')[1],formPostData);
        }else{
            cgJsClassAdmin.index.functions.cgLoadBackendAjax('?page=contest-gallery/index.php',formPostData);
        }

    }

    window.onhashchange = function() {
        if(cgJsClassAdmin.gallery.vars.isHashJustChanged){
            cgJsClassAdmin.gallery.vars.isHashJustChanged = false;
            return;
        }else{
            var formPostData = new FormData();
            formPostData.append('action', 'post_contest_gallery_action_ajax');
            formPostData.append('cgBackendHash',$('#cgBackendHash').val());
            if(location.hash.split('#')[1]){
                cgJsClassAdmin.index.functions.cgLoadBackendAjax('?page=contest-gallery/index.php&'+location.hash.split('#')[1],formPostData);
            }else{
                cgJsClassAdmin.index.functions.cgLoadBackendAjax('?page=contest-gallery/index.php',formPostData);
            }
        }
    };

    $(document).on('submit','.cg_load_backend_submit',function (e) {

        e.preventDefault();
        $(window).scrollTop(0);
        cgJsClassAdmin.index.functions.cgLoadBackend($(this),$(this).hasClass('cg_load_backend_submit_save_data'));

    });

    $(document).on('click','.cg_load_backend_link',function (e) {

        e.preventDefault();
        cgJsClassAdmin.index.functions.cgLoadBackend($(this));

    });


});