cgJsClass.gallery.sorting.desc = function (newData) {// by rowId sorted data!!!

    // create array for reverse
    var arr = [];

    for (var key in newData) {

        // add hasOwnPropertyCheck if needed
        var obj = {};

        obj[key] = newData[key];
        arr.push(obj);

    }

    var arrReverse = [];

    var iAdd = 0;

    for (var i=arr.length-1; i>=0; i--) {
        arrReverse[iAdd] =arr[i];
        iAdd++;
    }
    return arrReverse;


};
cgJsClass.gallery.sorting.sortByRowId = function (gid,init,isDoNotAddToImageDataFiltered) {

    var data = cgJsData[gid].vars.rawData;

    if(!isDoNotAddToImageDataFiltered){
        cgJsData[gid].fullImageDataFiltered = [];
    }

    var newData = {};
    var i = 0;
    for (var key in data){

        if(!data.hasOwnProperty(key)){
            break;
        }

        // check rThumb
        if(init===true){

            if(data[key]['rThumb']=='90' || data[key]['rThumb']=='270'){
                var Width = data[key]['Width'];
                var Height = data[key]['Height'];
                data[key]['Width'] = Height;
                data[key]['Height'] = Width;
            }
        }

        if(data[key]['rowid']!='0'){
            var newKey = data[key]['rowid'];
        }else{
            var newKey = key;// this is image id then!!!!
        }

        if(newData[newKey]){
            newKey = newKey+'1';
            newData[newKey] = data[key];
        }else{
            newData[newKey] = data[key];
        }

        // add real id to new object value
        newData[newKey]['id']  = parseInt(key);

      //  var newObject = {};
        //newObject[newData[newKey]['id']] = data[key];// für weitere verarbeitung in der art etabliert
        if(!isDoNotAddToImageDataFiltered){
            cgJsData[gid].fullImageDataFiltered[i] = {};
            cgJsData[gid].fullImageDataFiltered[i][newData[newKey]['id']] = data[key];
        }

        i++;

    }

    return newData;


};
cgJsClass.gallery.sorting.sortByRowIdFiltered = function (gid) {

    var newObj = {};

    jQuery.each(cgJsData[gid].fullImageDataFiltered, function( index,value ) {

        // index = array index
        // value = object
        // firstKey = object Key
        var firstKey = Object.keys(value)[0]; // objectKey = image ID
        var object = value[firstKey];

        var rowid = object['rowid']; // objectKey = image ID

        // entsprechend oben aufbau wie bei sortByRowId
        if(rowid!='0'){
            rowid = rowid;
        }else{
            rowid = object['id'];// this is image id then!!!!
        }

        if(newObj[rowid]){
            rowid = rowid+'1';// key is id!!!!
            newObj[rowid] = object;
        }else{
            newObj[rowid] = object;
        }

    });

    return newObj;


};