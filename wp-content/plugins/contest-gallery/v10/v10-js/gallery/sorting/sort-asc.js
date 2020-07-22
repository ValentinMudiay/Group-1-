cgJsClass.gallery.sorting.asc = function (newData) {


    // create array for reverse
    var arr = [];
    for (var key in newData) {
        // add hasOwnPropertyCheck if needed

        var obj = {};

        obj[key] = newData[key];
        arr.push(obj);

    }


    return arr;
};