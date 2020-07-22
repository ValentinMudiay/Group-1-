cgJsClass.gallery.views.checkFurtherImagesSteps = {
    init: function ($,gid) {

        var currentImageData;
        var PicsPerSite = parseInt(cgJsData[gid].options.general.PicsPerSite);

        if(cgJsData[gid].vars.sorting=='date-desc'){
            currentImageData = cgJsData[gid].vars.sortedDateDescFullData;
        }

        if( cgJsData[gid].vars.sorting=='date-asc'){
            currentImageData = cgJsData[gid].vars.sortedDateAscFullData;
        }

        if( cgJsData[gid].vars.sorting=='rating-desc'){
            currentImageData = cgJsData[gid].vars.sortedRatingDescFullData;
        }

        if( cgJsData[gid].vars.sorting=='rating-asc'){
            currentImageData = cgJsData[gid].vars.sortedRatingAscFullData;
        }

        if( cgJsData[gid].vars.sorting=='comments-desc'){
            currentImageData = cgJsData[gid].vars.sortedCommentsDescFullData;
        }

        if( cgJsData[gid].vars.sorting=='comments-asc'){
            currentImageData = cgJsData[gid].vars.sortedCommentsAscFullData;
        }

        if( cgJsData[gid].vars.sorting=='random'){
            currentImageData = cgJsData[gid].vars.sortedRandomFullData;
        }

        var length = Object.keys(currentImageData).length;
        var steps = Math.floor(length/PicsPerSite);



        if(steps<1){return;}

        var count = 1;

        // hier schon mal ersten step kreieren
        if(!cgJsData[gid].steps.hasOwnProperty(count)){
            cgJsData[gid].steps[count] = [];
        }

        for(var index in currentImageData){

            if(!currentImageData.hasOwnProperty(index)){
                break;
            }

            var check = parseInt(index);

            // somit wird die erste property erst mit zwei hier kreiert
            if(check % PicsPerSite == 0 && check / PicsPerSite >= 1){

                count++;
                // count zwei hier somit
                if(!cgJsData[gid].steps.hasOwnProperty(count)){
                    cgJsData[gid].steps[count] = [];
                }

            }

            cgJsData[gid].steps[count].push(currentImageData[index]);

            check++;

        }


    }
};