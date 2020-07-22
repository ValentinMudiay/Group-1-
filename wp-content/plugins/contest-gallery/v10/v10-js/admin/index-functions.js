var cgJsClassAdmin = cgJsClassAdmin || {};
cgJsClassAdmin.index = {};

cgJsClassAdmin.index.vars = {
    cgVersionLocalStorageName: '',
    isIE: false,
    wpVersion: '',
    wpVersionForTinyMCE: 480 // as integer (4.8)
};

cgJsClassAdmin.index.functions = {
    load: function () {

    },
    cgLoadBackendLoader: function (isShowNoLoader,isDoNotEmptyContent) {
        var $wpBodyContent = jQuery('#wpbody-content');

        // do this first, it will be removed when empty
        var cgBackendHashVal = $wpBodyContent.find('#cgBackendHash').val();

        if(!isDoNotEmptyContent){
            $wpBodyContent.empty();
        }

        if(!isShowNoLoader){
            var $cgBackendLoader = '<div id="cgBackendLoader" class="cg-lds-dual-ring-div-gallery-hide cg-lds-dual-ring-div-gallery-hide-mainCGallery">' +
                '<div class="cg-lds-dual-ring-gallery-hide cg-lds-dual-ring-gallery-hide-mainCGallery">' +
                '</div>' +
                '</div>';
            $wpBodyContent.append($cgBackendLoader);
        }

        return cgBackendHashVal;
    },
    cgLoadBackend: function ($formLinkObject,isSaveData,isShowNoLoader,isDoNotEmptyContent) {

        var cgBackendHashVal = cgJsClassAdmin.index.functions.cgLoadBackendLoader(isShowNoLoader,isDoNotEmptyContent);

        var urlString = '';

        var GET_Data;

        if($formLinkObject.is('form')){
            GET_Data = $formLinkObject.attr('action');
        }else{// then must be link
            GET_Data = $formLinkObject.attr('href');
        }

        GET_Data = GET_Data.replace(/(\r\n|\n|\r)/gm, "");// replace linebreaks
        GET_Data = GET_Data.replace(/\s/g, "");// replace empty space

        if(GET_Data){
            urlString = GET_Data;
        }
        var form = $formLinkObject.get(0);

        var formPostData;

        if($formLinkObject.is('form')){
            formPostData = new FormData(form);
        }else{// then must be link
            formPostData = new FormData();
        }

        formPostData.append('action', 'post_contest_gallery_action_ajax');

        formPostData.append('cgBackendHash',cgBackendHashVal);

        // remove hash from string if exists
        if(urlString.indexOf('#')>=0){
            urlString = urlString.split('#')[0];
        }

        if(!isSaveData){
            cgJsClassAdmin.gallery.vars.isHashJustChanged = true;
            if(urlString.split('?page=contest-gallery/index.php&')[1]){
                location.hash = '#'+urlString.split('?page=contest-gallery/index.php&')[1];
            }else{
                location.hash = '';
            }
            //var newUrlForHistory = location.protocol + '//' + location.host + location.pathname + location.search + location.hash;
            //window.location.href = newUrlForHistory;

        }

        // window.history.replaceState({'action':urlString},'',location.pathname+location.hash);
        cgJsClassAdmin.index.functions.cgLoadBackendAjax(urlString,formPostData,$formLinkObject);
    },
    cgLoadBackendAjax: function (urlString,formPostData,$formLinkObject) {

        if(!$formLinkObject){
            $formLinkObject = jQuery('<div></div>');
        }

        // AJAX Call - Submit Form
        jQuery.ajax({
            url: 'admin-ajax.php'+urlString,
            method: 'post',
            data: formPostData,
            dataType: null,
            contentType: false,
            processData: false
        }).done(function(response) {

            cgJsClassAdmin.index.functions.noteIfIsIE();

            // cgJsClassAdmin.gallery.vars.isHashJustChanged = true;
            //console.log('urlString');
            //console.log(urlString);

            var $response = jQuery(new DOMParser().parseFromString(response, 'text/html'));
            var cgVersionCurrent = $response.find('#cgVersion').val();

            // check first some indexdb error
            if(cgJsClassAdmin.index.indexeddb.error && localStorage.getItem('cgVersionLocalStorage')!=cgVersionCurrent && sessionStorage.getItem(cgJsClassAdmin.index.vars.cgVersionLocalStorageName)!=cgVersionCurrent){

                var $wpBodyContent = jQuery('#wpbody-content');

                $wpBodyContent.prepend('<p id="cgNewGalleryVersionDetected">New Contest Gallery version detected. Page needs to be reloaded. <br>Reload will be initiated ...</p>');

                // set always this as backup! Before set in indexedDB
                localStorage.setItem(cgJsClassAdmin.index.vars.cgVersionLocalStorageName, cgVersionCurrent);

                // indexed DB has to be reseted then!
                indexedDB.deleteDatabase('cgJsClassAdminIndexedDB/localhost/wp-admin/admin.php');

                // set this so user can continue working in backend
                sessionStorage.setItem(cgJsClassAdmin.index.vars.cgVersionLocalStorageName, cgVersionCurrent);

                setTimeout(function () {
                    location.reload();
                },1000);

            }else if(!cgJsClassAdmin.index.indexeddb.error && (!cgJsClassAdmin.index.indexeddb.cgVersion || cgJsClassAdmin.index.indexeddb.cgVersion!=cgVersionCurrent && !cgJsClassAdmin.index.indexeddb.error)){

                var $wpBodyContent = jQuery('#wpbody-content');

                $wpBodyContent.prepend('<p id="cgNewGalleryVersionDetected">New Contest Gallery version detected. Page needs to be reloaded. <br>Reload will be initiated ...</p>');

                setTimeout(function () {
                    // set always this as backup! Before set in indexedDB
                    localStorage.setItem(cgJsClassAdmin.index.vars.cgVersionLocalStorageName, cgVersionCurrent);
                    cgJsClassAdmin.index.indexeddb.setAdminData(cgVersionCurrent,true);
                },4000);

            }else{

                // set always this as backup! Before set in indexedDB
                localStorage.setItem(cgJsClassAdmin.index.vars.cgVersionLocalStorageName, cgVersionCurrent);

                // IMPORTANT!!!! Has to be set everytime here!!!!!
                cgJsClassAdmin.index.indexeddb.setAdminData(cgVersionCurrent);

                var $wpBodyContent = jQuery('#wpbody-content').empty();

                $wpBodyContent.empty();
                //  var htmlDom = new DOMParser().parseFromString(response, 'text/html');
                //   var html = htmlDom.firstChild.innerHTML;

                $wpBodyContent.find('#cgBackendLoader').remove();

                $wpBodyContent.append($response.find('body').html());// stats with html and contains body. Body content has to be inserted. Otherwise error because html can not be inserted in html.
                jQuery('#cgGalleryLoader').addClass('cg_hide');

                if($formLinkObject.hasClass('cg_load_backend_copy_gallery')){

                    if($wpBodyContent.find('#cgProcessedImages').length){
                        $formLinkObject.find('.cg_copy_start').val($wpBodyContent.find('#cgProcessedImages').val());
                        $formLinkObject.find('.option_id_next_gallery').val($wpBodyContent.find('#cgNextIdGallery').val());
                        cgJsClassAdmin.index.functions.cgLoadBackend($formLinkObject,true,true,true);
                    }else{
                        if($wpBodyContent.find('#cgGalleryBackendDataManagement').length){
                            cgJsClassAdmin.gallery.vars.isHashJustChanged = true;
                            location.hash = '#option_id='+$wpBodyContent.find('#cgNextIdGallery').val()+'&edit_gallery=true';

                            cgJsClassAdmin.gallery.functions.load(jQuery,false,$formLinkObject);
                        }
                    }

                }else{

                    if(jQuery("#cgOptionsLoader").length){
                        setTimeout(function () {
                            jQuery("#cgOptionsLoader").addClass('cg_hide');
                            //jQuery("#cg_main_options").addClass('cg_fade_in_0_2');
                            jQuery("#cg_main_options").removeClass('cg_hidden');
                            jQuery("#cg_save_all_options").removeClass('cg_hidden');
                        },500);
                    }

                    if($wpBodyContent.find('#cgGalleryBackendDataManagement').length){
                        cgJsClassAdmin.gallery.functions.load(jQuery,false,$formLinkObject);
                    }

                    if($wpBodyContent.find('#cg_main_options').length){
                        cgJsClassAdmin.options.functions.loadOptionsArea(jQuery,$formLinkObject,$response);
                    }

                    if($wpBodyContent.find('#ausgabe1.cg_create_upload').length){
                        cgJsClassAdmin.createUpload.functions.load(jQuery,$formLinkObject,$response);
                    }

                    if($wpBodyContent.find('#ausgabe1.cg_registry_form_container').length){
                        cgJsClassAdmin.createRegistry.functions.load(jQuery,$formLinkObject,$response);
                    }


                    jQuery("#cg_changes_saved").fadeOut(4000);
                    //cgJsClassAdmin.gallery.vars.cgLoadOptions(jQuery);

                    //window.scrollTo(0,0);

                }

            }

            cgJsClassAdmin.index.functions.noteIfIsIE();


        }).fail(function(xhr, status, error) {

            cgJsClassAdmin.index.functions.noteIfIsIE();


        }).always(function() {

        });
    },
    versionToLowForTinymce: '<p class="cg-version-to-low-for-tinymce">WordPress version 4.8 and higher is required to display this textarea as modern TinyMCE editor</p>',
    getWpVersionAsInteger: function () {

        var wpVersion = jQuery('#cgWordPressVersion').val();
        return parseInt(wpVersion.replace('.','').replace('.','').replace('.','').replace('.','').replace('.',''));

    },
    initializeEditor: function(id){

        if(cgJsClassAdmin.index.functions.getWpVersionAsInteger()>=cgJsClassAdmin.index.vars.wpVersionForTinyMCE){// then tinymce can be initialized

            wp.editor.remove(id);

            wp.editor.initialize(id, {
                tinymce: true,
                quicktags: true
            });

        }else{
           // setTimeout(function () {
                jQuery(cgJsClassAdmin.index.functions.versionToLowForTinymce).insertAfter('#'+id);// have to be id, does not work with object!
               // debugger
           // },100);
        }


    },
    setEditors: function($, $textareas){

        if(cgJsClassAdmin.index.functions.getWpVersionAsInteger()>=cgJsClassAdmin.index.vars.wpVersionForTinyMCE){// then tinymce can be initialized

            $textareas.each(function () {// do only for visible first

                cgJsClassAdmin.index.functions.initializeEditor($(this).attr('id'));

            });

        }else{// let textarea as textarea and show message

            $textareas.each(function () {// do only for visible first

               $(cgJsClassAdmin.index.functions.versionToLowForTinymce).insertAfter('#'+$(this).attr('id'));// have to be id, does not work with object!

            });

        }

    },
    checkIfIsIE: function () {

        try{

            // checks if edge or ie !

            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");

            if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))  // If Internet Explorer, return version number
            {
                cgJsClassAdmin.index.vars.isIE = true;
            }

        }catch(e){

        }

    },
    noteIfIsIE: function () {

        if(cgJsClassAdmin.index.vars.isIE){
            jQuery('#cgIeWarning').remove();
            jQuery('#wpbody-content').prepend('<p id="cgIeWarning" style="width:937px;text-align:center;">' +
                '<b>You are using Internet Explorer which will not be supported anymore by Microsoft.</b><br>' +
                'For proper backend functionality please use latest versions of currently supported browsers:<br>' +
                'Chrome, Firefox, Edge, Opera' +
                '</p>');
        }

    }
};