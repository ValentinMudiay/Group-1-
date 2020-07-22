cgJsClass.gallery.function.search.getFullImageDataFiltered = function(gid,ids){

        cgJsData[gid].fullImageDataFiltered = [];

        for(var arrKey in cgJsData[gid].fullImageData){

            if(!cgJsData[gid].fullImageData.hasOwnProperty(arrKey)){
                break;
            }

            var firstKey = Object.keys(cgJsData[gid].fullImageData[arrKey])[0];
            var realIdToCompare = cgJsData[gid].fullImageData[arrKey][firstKey]['id'];

            if(ids.hasOwnProperty(realIdToCompare)){
                var obj = {};
                obj[firstKey] = cgJsData[gid].fullImageData[arrKey][firstKey];

                cgJsData[gid].fullImageDataFiltered.push(obj);

            }

        }

        var filtered = true;
        cgJsClass.gallery.sorting.initSort(gid,filtered);

        cgJsData[gid].fullImageDataFiltered = cgJsData[gid].image;


};