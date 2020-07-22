cgJsClass.gallery.sorting.countC = function (gid) {

    var newObj = {};

    var countImages = Object.keys(cgJsData[gid].fullImageDataFiltered).length;

    jQuery.each(cgJsData[gid].fullImageDataFiltered, function( index,value ) {

        // index = array index
        // value = object
        // firstKey = object Key
        var firstKey = Object.keys(value)[0]; // objectKey = image ID
        var object = value[firstKey];

        var add = parseInt(object['CountC']);
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