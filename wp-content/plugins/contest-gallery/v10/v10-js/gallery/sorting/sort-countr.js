cgJsClass.gallery.sorting.countR = function (gid) {

    var newObj = {};

    var countImages = Object.keys(cgJsData[gid].fullImageDataFiltered).length;
    var Manipulate = cgJsData[gid].options.pro.Manipulate;


    jQuery.each(cgJsData[gid].fullImageDataFiltered, function( index,value ) {

        // index = array index
        // value = object
        // firstKey = object Key
        var firstKey = Object.keys(value)[0]; // objectKey = image ID
        var object = value[firstKey];

        var add = parseInt(object['CountRtotal']);
        var newFirstKey = parseInt(add+'00000');

        // nach rating setzen
        if(add>0){


            if(newObj.hasOwnProperty(newFirstKey)==false){

                newObj[newFirstKey] = object;

            }
            else{

                for (var i=0; i<=countImages; i++) {

                    newFirstKey = newFirstKey+1;

                    if(newObj.hasOwnProperty(newFirstKey)==false) {

                        newObj[newFirstKey] = object;
                        break;
                    }
                }
            }

        }
        else{ // wenn null dann nach id setzen

            var id = object['id']; // objectKey = image ID
            newObj[id] = object;

        }


    });


    return newObj;

};

cgJsClass.gallery.sorting.countRaverage = function (gid) {

    var newObj = {};

    var countImages = Object.keys(cgJsData[gid].fullImageDataFiltered).length;
    var Manipulate = cgJsData[gid].options.pro.Manipulate;


    jQuery.each(cgJsData[gid].fullImageDataFiltered, function( index,value ) {

        // index = array index
        // value = object
        // firstKey = object Key
        var firstKey = Object.keys(value)[0]; // objectKey = image ID
        var object = value[firstKey];

        // !IMPORTANT: parseFloat here!!!!
     //   var add = parseFloat(object['RatingAverage'])*10;// Punkt darf hier nicht sein damit es schön aufgezählt wird. Also keine 2.5 sondern dann 25
   //     var newFirstKey = parseInt(add+'00000');
        var newFirstKey = object['RatingAverageForSecondarySorting'];

        // nach rating setzen
        if(newFirstKey>0){

            if(newObj.hasOwnProperty(newFirstKey)==false){

                newObj[newFirstKey] = object;

            }
            else{

                for (var i=0; i<=countImages; i++) {

                    newFirstKey = newFirstKey+1;

                    if(newObj.hasOwnProperty(newFirstKey)==false) {

                        newObj[newFirstKey] = object;
                        break;
                    }
                }
            }

        }
        else{ // wenn null dann nach id setzen

            var id = object['id']; // objectKey = image ID
            newObj[id] = object;

        }


    });

    // convert to array for proper sorting
    var newArray = [];
    jQuery.each(newObj, function( index,value ) {
        value.sortedKeyBefore = index;
        newArray.push(value);
    });

    newArray.sort(function(a, b) {
        return a.RatingAverageForSecondarySorting - b.RatingAverageForSecondarySorting;
    });

    var newObjSortedLikeNewArray = {};
    newArray.forEach(function (value) {
        newObjSortedLikeNewArray[value.sortedKeyBefore] = value;
    });

    return newObjSortedLikeNewArray;

};