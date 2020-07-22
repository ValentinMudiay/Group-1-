cgJsClass.gallery.categories.setSelectFromLocalStorage = function(){

    var cats = this.getLocalStorageCats();

    for(var cat in cats){

        if(!cats.hasOwnProperty(cat)){
            break;
        }

        jQuery("#cgCatSelectArea [value='"+cat+"'].cg_select_cat").prop('checked',cats[cat]);

        if(cats[cat]==true){
            jQuery("#cgCatSelectArea [value='"+cat+"'].cg_select_cat").closest('label').addClass('cg_cat_checkbox_checked');
            jQuery("#cgCatSelectArea [value='"+cat+"'].cg_select_cat").closest('label').removeClass('cg_cat_checkbox_unchecked');
        }
        else{
            jQuery("#cgCatSelectArea [value='"+cat+"'].cg_select_cat").closest('label').addClass('cg_cat_checkbox_unchecked');
            jQuery("#cgCatSelectArea [value='"+cat+"'].cg_select_cat").closest('label').removeClass('cg_cat_checkbox_checked');
        }
    }

    this.cgJsClassGalleryCategories = cats;


};
cgJsClass.gallery.categories.getLocalStorageCats = function(){

    if(cgJsClass.gallery.vars.checkLocalStorage==true){

        return JSON.parse(localStorage.getItem('cgJsClassGalleryCategories'));
    }

};
cgJsClass.gallery.categories.setLocalStorageSelectCats= function(){

    if(cgJsClass.gallery.vars.checkLocalStorage==true){

        var obj = {};

        jQuery("#cgCatSelectArea .cg_select_cat").each(function (index) {

            var catId = jQuery(this).val();
            var catChecked = jQuery(this).prop('checked');
            obj[catId] = catChecked;
            // {cg_cat_Holidays: true, cg_cat_Photos: true, cg_cat_other: true}
        });


        this.cgJsClassGalleryCategories = obj;

        localStorage.setItem('cgJsClassGalleryCategories',JSON.stringify(obj));

    }
};
cgJsClass.gallery.categories.changeFromLocalStorage = function(){
    // HIER GEHTS LOS!!!!
    var catsLocalStorage = this.getLocalStorageCats();

    for (var prop in catsLocalStorage) {

        var catId = prop;

        if(catsLocalStorage[prop]==false){

            jQuery('.cg_show[data-cat-id='+catId+']').addClass('cg_hide');
            jQuery('.cg_show[data-cat-id='+catId+']').removeClass('cg_visible');

        }
        if(catsLocalStorage[prop]==true){

            jQuery('.cg_show[data-cat-id='+catId+']').addClass('cg_visible');
            jQuery('.cg_show[data-cat-id='+catId+']').removeClass('cg_hide');

        }

    }

    cgJsClass.slider.slide.objects.resizingGallery();

};

cgJsClass.gallery.categories.removeLocalStorage = function () {

    localStorage.removeItem('cgJsClassGalleryCategories');
    localStorage.removeItem('cgJsClassIdsChecker');

};

cgJsClass.gallery.categories.changeObjectsFromLocalStorage = function(object) {

    var checkSlider = cgJsClass.slider.vars.cg_activate_gallery_slider;

    if(checkSlider==0){

        if(cgJsClass.gallery.vars.checkLocalStorage==true){


                    var catIds = this.getLocalStorageCats();

                var imagesWithCatIds = cgJsClass.slider.slide.values.activatedImageCategoriesIds;
                var ids = cgJsClass.slider.slide.values.activatedIds;

                for(var catId in catIds){

                    if(!catIds.hasOwnProperty(catId)){
                        break;
                    }

                    var catIdCheck = catIds[catId];

                    for(var imageId in imagesWithCatIds){

                        if(!imagesWithCatIds.hasOwnProperty(imageId)){
                            break;
                        }

                        var catIdImage = imagesWithCatIds[imageId];

                        if(catId==catIdImage){
                            ids[imageId] = catIdCheck;
                        }

                    }
                }

                cgJsClass.slider.slide.values.activatedIds = ids;

                localStorage.setItem('cgJsClassIdsChecker',JSON.stringify(ids));


        }
    }

};
