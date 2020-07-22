cgJsClass.gallery.info.getInfo = function (realId,gid,setInfoSingleView,arrIndex,openPage) {

    var uploadFolderUrl = cgJsData[gid].vars.uploadFolderUrl;

    if(cgJsData[gid].vars.openedRealId){

        // alle getInfo requests abbrechen, damit info nicht mehrfach gesetzt wird
      //  if(cgJsData[gid].vars.jsonGetInfo.length>0){
         //   for(var key in cgJsData[gid].vars.jsonGetInfo){
              //  cgJsData[gid].vars.jsonGetInfo[key].abort();
          //  }
       // }
        cgJsData[gid].vars.jsonGetInfo = [];

    }

    cgJsData[gid].vars.jsonGetInfo.push(jQuery.getJSON( uploadFolderUrl+"/contest-gallery/gallery-id-"+cgJsData[gid].vars.gidReal+"/json/image-info/image-info-"+realId+".json",{_: new Date().getTime()}).done(function(data){

        cgJsClass.gallery.info.setInfo(realId,gid,setInfoSingleView,arrIndex,data,openPage);

    }));

};