cgJsClass.gallery.sorting.random = function (gid){

    function shuffle(array) {
        var currentIndex = array.length, temporaryValue, randomIndex;

        // While there remain elements to shuffle...
        while (0 !== currentIndex) {

            // Pick a remaining element...
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;

            // And swap it with the current element.
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }

        return array;
    }

    // Used like so
    var newObj = shuffle(cgJsData[gid].fullImageDataFiltered);
    cgJsData[gid].vars.sortedRandomFullData = newObj.slice(0);

    return newObj;

};