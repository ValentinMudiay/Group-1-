cgJsClass.gallery.info.collectInfo = function (gid,realId,data) {

        if(data==null){
            data = [];
        }

    if(typeof cgJsData[gid].vars.rawData[realId] != 'undefined'){


        if (Object.keys(data).length > 0) {

            var collectDataInfo = '';

            for(var fieldId in data){

                if(!data.hasOwnProperty(fieldId)){
                    break;
                }

                if(collectDataInfo==''){
                    collectDataInfo += data[fieldId]['field-content'];
                }else{
                    collectDataInfo += ' ; '+data[fieldId]['field-content'];
                }

            }

            if(Object.keys(cgJsData[gid].vars.categories).length>=1){
                collectDataInfo = cgJsClass.gallery.info.collectCategory(gid,realId,collectDataInfo);
            }


            collectDataInfo += ' ; '+cgJsData[gid].vars.rawData[realId]['NamePic'];
            collectDataInfo += ' ; '+cgJsData[gid].vars.rawData[realId]['post_name'];
            collectDataInfo += ' ; '+cgJsData[gid].vars.rawData[realId]['post_title'];

            if(cgJsData[gid].vars.rawData[realId].hasOwnProperty('Exif')){

                if(cgJsData[gid].vars.rawData[realId]['Exif'].hasOwnProperty('ApertureFNumber')){
                    collectDataInfo += ' ; '+cgJsData[gid].vars.rawData[realId]['Exif']['ApertureFNumber'];
                }
                if(cgJsData[gid].vars.rawData[realId]['Exif'].hasOwnProperty('ExposureTime')){
                    collectDataInfo += ' ; '+cgJsData[gid].vars.rawData[realId]['Exif']['ExposureTime'];
                }
                if(cgJsData[gid].vars.rawData[realId]['Exif'].hasOwnProperty('FocalLength')){
                    collectDataInfo += ' ; '+cgJsData[gid].vars.rawData[realId]['Exif']['FocalLength'];
                }
                if(cgJsData[gid].vars.rawData[realId]['Exif'].hasOwnProperty('ISOSpeedRatings')){
                    collectDataInfo += ' ; '+cgJsData[gid].vars.rawData[realId]['Exif']['ISOSpeedRatings'];
                }
                if(cgJsData[gid].vars.rawData[realId]['Exif'].hasOwnProperty('MakeAndModel')){
                    collectDataInfo += ' ; '+cgJsData[gid].vars.rawData[realId]['Exif']['MakeAndModel'];
                }
                if(cgJsData[gid].vars.rawData[realId]['Exif'].hasOwnProperty('Model')){
                    collectDataInfo += ' ; '+cgJsData[gid].vars.rawData[realId]['Exif']['Model'];
                }

            }

            cgJsData[gid].fullImageInfoData[realId] = collectDataInfo;


        }
        else{

            cgJsData[gid].vars.info[realId] = null;
            cgJsData[gid].fullImageInfoData[realId] = null;

            var collectDataInfo = '';

            if(Object.keys(cgJsData[gid].vars.categories).length>=1){
                collectDataInfo = cgJsClass.gallery.info.collectCategory(gid,realId,collectDataInfo);
            }

            collectDataInfo += ' ; '+cgJsData[gid].vars.rawData[realId]['NamePic'];
            collectDataInfo += ' ; '+cgJsData[gid].vars.rawData[realId]['post_name'];
            collectDataInfo += ' ; '+cgJsData[gid].vars.rawData[realId]['post_title'];
            cgJsData[gid].fullImageInfoData[realId] = collectDataInfo;

        }

    }

};
cgJsClass.gallery.info.collectCategory = function (gid,realId,collectDataInfo) {

            if(typeof cgJsData[gid].vars.rawData[realId] != 'undefined'){
                if(cgJsData[gid].vars.rawData[realId]['Category']>0){
                    var category = cgJsData[gid].vars.rawData[realId]['Category'];

                    if(typeof cgJsData[gid].vars.categories[category]!='undefined'){
                        collectDataInfo += ' ; '+cgJsData[gid].vars.categories[category]['Name'];
                    }

                }else if(cgJsData[gid].vars.categoriesLength>=1 && cgJsData[gid].options.pro.ShowOther==1){

                    collectDataInfo += ' ; '+cgJsClass.gallery.language.Other;
                }

                return collectDataInfo;
            }

};