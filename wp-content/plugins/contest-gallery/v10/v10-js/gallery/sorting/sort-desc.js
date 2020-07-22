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