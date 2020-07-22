cgJsClass.gallery.function.general.checkFiltered = function (gid) {

    var filtered = false;

    var checkedCategories = [];

    // prüfen ob Kategorien verändert wurden und überhaupt existieren
    if(cgJsData[gid].options.pro.CatWidget>=1){

        var allCategoriesLength = Object.keys(cgJsData[gid].vars.categories).length;

        for(var catId in cgJsData[gid].vars.categories){

            if(!cgJsData[gid].vars.categories.hasOwnProperty(catId)){
                break;
            }

            if(cgJsData[gid].vars.categories[catId]['Checked']){
                checkedCategories.push(catId);
            }
        }

        if(checkedCategories.length!=allCategoriesLength){
            filtered = true;
        }

    }

    cgJsData[gid].vars.searchInput = (cgJsData[gid].vars.searchInput==null) ? '': cgJsData[gid].vars.searchInput;

    // prüfen ob Input was eingegeben ist
    if(cgJsData[gid].vars.searchInput!=''){
        filtered = true;
    }

    return filtered;


};