cgJsClass.gallery.categories = {
    existingCategories: [0],
    init:function (gid,data) {// return true oder false für späteren check plus setzt categorien

        if(!cgJsData[gid].vars.existingCategories){
            cgJsData[gid].vars.existingCategories = [];
            cgJsData[gid].vars.existingCategories.push(0);
        }

        if(typeof data == 'object'){

            if(Object.keys(data).length>=1){

                // get categories id
                for(var property in cgJsData[gid].forms.upload){

                    if(!cgJsData[gid].forms.upload.hasOwnProperty(property)){
                        break;
                    }

                    if(cgJsData[gid].forms.upload[property].Field_Type=='selectc-f'){
                        cgJsData[gid].vars.categoriesUploadFormId = property;
                        cgJsData[gid].vars.categoriesUploadFormTitle = cgJsData[gid].forms.upload[property].Field_Content.titel;
                    }
                }

                var active = 0;
                var $cgCatSelectArea = null;
                var $labelContainerOrigin = null;

                if(cgJsData[gid].options.pro.CatWidget==1){

                    $cgCatSelectArea = jQuery('#mainCGdiv'+gid).find('.cg-cat-select-area');
                    $labelContainerOrigin =$cgCatSelectArea.find('label');
                    // vorher leeren bevor er mit labes gefüllt wird
                    $cgCatSelectArea.empty();

                }

                for(var i in data){

                    if(!data.hasOwnProperty(i)){
                        break;
                    }

                    var catId = data[i]['id'].toString();

                    cgJsData[gid].vars.existingCategories.push(parseInt(catId));//Important parseInt: because indexOf compare type always!

                    if(data[i]['Active']==1){

                        active = 1;

                        if(cgJsData[gid].options.pro.CatWidget==1){
                            var $labelContainer = $labelContainerOrigin;
                            $labelContainer.attr('data-cg-cat-id',catId);
                            $labelContainer.attr('data-cg-gid',gid);
                         //   $labelContainer.find('input').attr('data-cg-cat-id',catId).val(data[i]['id']).prop('checked',true).attr('data-cg-gid',gid);
                            $labelContainer.find('span.cg_select_cat').text(data[i]['Name']);
                            // wichtig!!! mit clone ansonsten verweißt die referenz immer auf $labelContainerOrigin !!!!!
                            $labelContainer.clone().appendTo($cgCatSelectArea);
                        }

                        cgJsData[gid].vars.categories[catId] = data[i];
                        cgJsData[gid].vars.categories[catId]['Checked'] = true;

                        if(cgJsData[gid].vars.categories[catId]['isShowTagInGallery']){
                            cgJsData[gid].vars.isShowTagInGallery = true;
                        }

                    }

                }

                if(cgJsData[gid].options.pro.ShowOther==1){

                    if(cgJsData[gid].options.pro.CatWidget==1){
                        $labelContainerOrigin.attr('data-cg-cat-id',0);
                        $labelContainerOrigin.attr('data-cg-gid',gid);
                     //   $labelContainerOrigin.find('input').attr('data-cg-cat-id',0).val(0).prop('checked',true).attr('data-cg-gid',gid);
                        $labelContainerOrigin.find('span.cg_select_cat').text(cgJsClass.gallery.language.Other);
                        $cgCatSelectArea.append($labelContainerOrigin);
                    }

                    // show other category object anlegen
                    cgJsData[gid].vars.categories[0] = {};
                    cgJsData[gid].vars.categories[0]['Checked'] = true;
                    cgJsData[gid].vars.categories[0]['Name'] = cgJsClass.gallery.language.Other;
                }

                if($cgCatSelectArea){
                    $cgCatSelectArea.css('display','flex');
                }

                return true;

            }else{
                return false;
            }

        }else{
            return false;
        }


    },
    initClick:function () {

        jQuery(document).on('click','.cg_select_cat_label',function(){

            var gid = jQuery(this).attr('data-cg-gid');

            var $element = jQuery(this);

            if(cgJsClass.gallery.function.general.tools.setWaitingForValues(gid,$element,'click')){
                return;
            }

            cgJsClass.gallery.categories.processCategories(gid,$element);

        });

    },
    processCategories: function (gid,$element,isCalledFromUpload) {


        // weil der selbe effekt wie bei sorting, bilder müssen appenden
        cgJsClass.gallery.vars.hasToAppend = true;

        cgJsClass.gallery.vars.categoryClicked = true;

        cgJsClass.gallery.getJson.abortGetJson(gid);

        //var catIdClicked = jQuery(this).attr('data-cg-cat-id');
        var categories = [];

        if($element.hasClass('cg_cat_checkbox_checked')) {
            cgJsData[gid].vars.categories[$element.attr('data-cg-cat-id')]['Checked'] = false;// then will be unchecked
            $element.addClass('cg_cat_checkbox_unchecked');
            $element.removeClass('cg_cat_checkbox_checked');
        } else if (!$element.hasClass('cg_cat_checkbox_checked')){
            cgJsData[gid].vars.categories[$element.attr('data-cg-cat-id')]['Checked'] = true;// then will be checked
            var catId = $element.attr('data-cg-cat-id');
            categories.push(catId);
            $element.addClass('cg_cat_checkbox_checked');
            $element.removeClass('cg_cat_checkbox_unchecked');
        }

        // go through all checkboxes to check
        var $cgCatSelectArea = $element.closest('.cg-cat-select-area');
        var isAllCategoriesUnchecked = true;
        $cgCatSelectArea.find('.cg_select_cat_label').each(function () {
            if(jQuery(this).hasClass('cg_cat_checkbox_checked')) {
                isAllCategoriesUnchecked = false;
                cgJsData[gid].vars.categories[jQuery(this).attr('data-cg-cat-id')]['Checked'] = true;
            } else if (!jQuery(this).hasClass('cg_cat_checkbox_checked')){
                cgJsData[gid].vars.categories[jQuery(this).attr('data-cg-cat-id')]['Checked'] = false;
            }
        });

        if(cgJsData[gid].options.pro.ShowCatsUnchecked==1){
            if(isAllCategoriesUnchecked==true){// handle as like all were true
                $cgCatSelectArea.find('.cg_select_cat_label').each(function () {
                    cgJsData[gid].vars.categories[jQuery(this).attr('data-cg-cat-id')]['Checked'] = true;
                });
            }
        }

        if(!isCalledFromUpload){
            if (cgJsData[gid].vars.openedRealId > 0) {
                cgJsClass.gallery.views.close(gid);
            }
        }

        var ids = cgJsClass.gallery.function.search.collectData(gid);
        cgJsClass.gallery.function.search.getFullImageDataFiltered(gid,ids);

        var step = 1; // Weil fängt mit erstem Schritt an
        cgJsClass.gallery.dynamicOptions.checkStepsCutImageData(jQuery,step,true,false,gid);


        cgJsClass.gallery.vars.categoryClicked = false;

    },
    checkAndSetCategoriesAfterUploadIfNecessary: function (gid,data,newImageIdsArray) {

        var processingInitiated = false;

        var $categoryElement = null


        for(var i in newImageIdsArray){

            if(!newImageIdsArray.hasOwnProperty(i)){
                break;
            }

            if(data[newImageIdsArray[i]]){

                // has to be changed then otherwise image can not appear and gallery can not load
                if(cgJsData[gid].vars.showCategories && parseInt(data[newImageIdsArray[i]].Category) && cgJsData[gid].options.pro.CatWidget==1){

                    if(cgJsData[gid].options.pro.ShowCatsUnchecked==1){// nothing to do if not one is checked!

                        var oneCategoriesIsChecked = false;

                        cgJsData[gid].vars.mainCGdiv.find('.cg-cat-select-area .cg_select_cat_label').each(function () {
                            if(jQuery(this).hasClass('cg_cat_checkbox_checked')){
                                oneCategoriesIsChecked = true;
                                return false;
                            }
                        });

                        if(oneCategoriesIsChecked){
                            // check the boxes here first
                            $categoryElement = cgJsData[gid].vars.mainCGdiv.find('.cg-cat-select-area .cg_select_cat_label[data-cg-cat-id="'+data[newImageIdsArray[i]].Category+'"]');
                            processingInitiated = true;
                        }

                    }else{// then can be done anyway!!!!!!

                        $categoryElement = cgJsData[gid].vars.mainCGdiv.find('.cg-cat-select-area .cg_select_cat_label[data-cg-cat-id="'+data[newImageIdsArray[i]].Category+'"]');
                        processingInitiated = true;

                    }

                }

            }

        }

        if($categoryElement){
            // check the boxes here first
            cgJsClass.gallery.categories.processCategories(gid,$categoryElement,true);
        }

        return processingInitiated;

    }
};