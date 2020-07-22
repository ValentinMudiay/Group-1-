cgJsClass.gallery.function.search.collectData = function (gid) {

/*
    var categories = [];

    // get realIds out of filter category
    if(cgJsData[gid].options.pro.CatWidget>=1 && Object.keys(cgJsData[gid].vars.categories).length>=1){

        for(var catId in cgJsData[gid].vars.categories){
            if(cgJsData[gid].vars.categories[catId]['Checked']){
                categories.push(catId);
            }
        }

        if(categories.length>=1){

            // alles realIds zuerst sammeln die entsprechende Categorie haben
            for(var realId in cgJsData[gid].vars.rawData){

                var catId = cgJsData[gid].vars.rawData[realId]['Category'];

                for(var index in categories){

                    if(categories[index]==catId){
                        ids[realId] = catId;
                        break;
                    }

                }

            }
        }

    }
*/
    var ids = {};

    var noCategories = false;
    if(cgJsData[gid].options.pro.CatWidget!=1){
        noCategories = true;
    }
    if(cgJsData[gid].vars.categoriesLength<1){
        noCategories = true;
    }

    // Zuerst alle felder nach infos durchsuchen!!!!!
    // get realIds out of search input
    cgJsData[gid].vars.searchInput = (cgJsData[gid].vars.searchInput==null) ? '': cgJsData[gid].vars.searchInput;

    if(cgJsData[gid].vars.searchInput.trim()!='' && cgJsData[gid].options.pro.Search==1){
        var val = cgJsData[gid].vars.searchInput;

        var valArray = val.split(" ");

        var valArrayNew = [];

        // array aus werten bilden die eingegeben wurden
        for(var key in valArray){

            if(!valArray.hasOwnProperty(key)){
                break;
            }

            if (valArray[key] == '') {
            }else{
                valArrayNew.push(valArray[key]);
            }

        }

        for(var realId in cgJsData[gid].fullImageInfoData){

            if(!cgJsData[gid].fullImageInfoData.hasOwnProperty(realId)){
                break;
            }

            // werte durchgehen die eingegeben wurden
            for(var key in valArrayNew){

                if(!valArrayNew.hasOwnProperty(key)){
                    break;
                }

                // den vorhanden ids werte hinzufügen wenn kein wert gefunden wurde, dann die id entfernen!!
                if(cgJsData[gid].fullImageInfoData[realId].toLowerCase().indexOf(valArrayNew[key].toLowerCase())>=0){

                    ids[realId] = val;

                }

            }

            // wenn es kategorien gibt eine der ids nicht in kategorien ist dann rausnehmen
            // Falls das Widget aktiviert und Kategorien rausgenommen wurden
            if(cgJsData[gid].vars.categoriesLength>=1 && cgJsData[gid].options.pro.CatWidget==1){

                // Kategorien check hier!!!!!
                var imageCatId = cgJsData[gid].vars.rawData[realId]['Category'];
                var checkCatId = false;

                for(var categoryId in cgJsData[gid].vars.categories){

                    if(!cgJsData[gid].vars.categories.hasOwnProperty(categoryId)){
                        break;
                    }

                    if(categoryId==imageCatId){

                        checkCatId = true;
                        // auch löschen wenn nicht gecheckt ist!!!!
                        if(cgJsData[gid].vars.categories[categoryId]['Checked']==false){
                            delete ids[realId];// aus den Kategorien löschen!!!
                        }

                        break;
                    }

                }

                // löschen wenn nicht in den Kategorien vorhanden ist!!!
                if(checkCatId==false){

                    if(ids.hasOwnProperty(realId)){

                        delete ids[realId];// aus den Kategorien löschen!!!
                    }

                }

            }

        }


    }else{

        for(var realId in cgJsData[gid].vars.rawData){

            if(!cgJsData[gid].vars.rawData.hasOwnProperty(realId)){
                break;
            }

            ids[realId] = '';
        }

        // wenn es kategorien gibt eine der ids nicht in kategorien ist dann rausnehmen
        // Falls das Widget aktiviert und Kategorien rausgenommen wurden
        if(cgJsData[gid].vars.categoriesLength>=1 && cgJsData[gid].options.pro.CatWidget==1){

            for(var realId in cgJsData[gid].vars.rawData){

                if(!cgJsData[gid].vars.rawData.hasOwnProperty(realId)){
                    break;
                }

                // Kategorien check hier!!!!!
                var imageCatId = cgJsData[gid].vars.rawData[realId]['Category'];
                var checkCatId = false;

                for(var categoryId in cgJsData[gid].vars.categories){

                    if(!cgJsData[gid].vars.categories.hasOwnProperty(categoryId)){
                        break;
                    }

                    if(categoryId==imageCatId){

                        checkCatId = true;
                        // auch löschen wenn nicht gecheckt ist!!!!
                        if(cgJsData[gid].vars.categories[categoryId]['Checked']==false){
                            delete ids[realId];// aus den Kategorien löschen!!!
                        }

                        break;
                    }

                }

                // löschen wenn nicht in den Kategorien vorhanden ist!!!
                if(checkCatId==false){

                    if(ids.hasOwnProperty(realId)){

                        delete ids[realId];// aus den Kategorien löschen!!!
                    }

                }

            }

        }

    }

    return ids;

};