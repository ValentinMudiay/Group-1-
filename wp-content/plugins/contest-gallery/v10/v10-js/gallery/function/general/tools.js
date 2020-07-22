cgJsClass.gallery.function.general.tools = {
    setWaitingForValues: function(gid,$element,action,isWaitForInfoData){

        if((!cgJsClass.gallery.vars.isSortingDataAvailable && !cgJsClass.gallery.views.clickFurtherImagesStep.waitingInterval)
            ||
            (isWaitForInfoData && !cgJsClass.gallery.vars.isInfoDataAvailable && !cgJsClass.gallery.views.clickFurtherImagesStep.waitingInterval)
        ){

            var $mainCGdiv = jQuery('#mainCGdiv'+gid);
            var $mainCGslider = jQuery('#mainCGslider'+gid);
            $mainCGdiv.find('#mainCGallery'+gid).find('.cg_show').remove();
            $mainCGdiv.find('#cgLdsDualRingMainCGdivHide'+gid).removeClass('cg_hide');
            $mainCGslider.find('#cgLdsDualRingMainCGdivHide'+gid).removeClass('cg_hide');

            cgJsClass.gallery.views.clickFurtherImagesStep.waitingInterval = setInterval(function() {

                if(action=='click'){
                    $element.click();
                }
                if(action=='change'){
                    $element.trigger('change');
                }
            },500);

            return true;
        }

        if((cgJsClass.gallery.vars.isSortingDataAvailable && cgJsClass.gallery.views.clickFurtherImagesStep.waitingInterval)
            || (isWaitForInfoData && cgJsClass.gallery.vars.isInfoDataAvailable && cgJsClass.gallery.views.clickFurtherImagesStep.waitingInterval)){
            clearInterval(cgJsClass.gallery.views.clickFurtherImagesStep.waitingInterval);
            cgJsClass.gallery.views.clickFurtherImagesStep.waitingInterval = null;
            var $mainCGdiv = jQuery('#mainCGdiv'+gid);
            var $mainCGslider = jQuery('#mainCGslider'+gid);
            $mainCGdiv.find('#cgLdsDualRingMainCGdivHide'+gid).removeClass('cg_hide');
            $mainCGslider.find('#cgLdsDualRingMainCGdivHide'+gid).removeClass('cg_hide');
            return false;
        }else if((!cgJsClass.gallery.vars.isSortingDataAvailable) || (isWaitForInfoData && !cgJsClass.gallery.vars.isInfoDataAvailable)){
            return true;
        }

        return false;

    },
    modifyFullImageData: function(gid,realId,data){

        // do not forget it because of modifiying data!
        // id is not available in data!
        data['id'] = realId;

        for(var index in cgJsData[gid].fullImageData){

            if(!cgJsData[gid].fullImageData.hasOwnProperty(index)){
                break;
            }

            var firstKey = Object.keys(cgJsData[gid].fullImageData[index])[0];
            var realIdToCompare = cgJsData[gid].fullImageData[index][firstKey]['id'];

            if(realId == realIdToCompare){
                cgJsData[gid].fullImageData[index][firstKey] = data;
                break;
            }

        }

        for(var index in cgJsData[gid].fullImageDataFiltered){

            if(!cgJsData[gid].fullImageDataFiltered.hasOwnProperty(index)){
                break;
            }

            var firstKey = Object.keys(cgJsData[gid].fullImageDataFiltered[index])[0];
            var realIdToCompare = cgJsData[gid].fullImageDataFiltered[index][firstKey]['id'];

            if(realId == realIdToCompare){
                cgJsData[gid].fullImageDataFiltered[index][firstKey] = data;
                break;
            }

        }

    },
    checkSsl: function (imgUrl) {

        if(cgJsClass.gallery.vars.isSsl){
            if(imgUrl.indexOf('http://')===0){
                imgUrl = imgUrl.replace("http://", "https://");
                return imgUrl;
            }else{
                return imgUrl;
            }
        }else{
            if(imgUrl.indexOf('https://')===0){
                imgUrl = imgUrl.replace("https://", "http://");
                return imgUrl;
            }else{
                return imgUrl;
            }
        }

    },
    checkIfIsEdge: function () {

        // checks if edge

        var ua = window.navigator.userAgent;

/*        var msie = ua.indexOf('MSIE ');

        if (msie > 0) {
            // IE 10 or older => return version number
            cgJsClass.gallery.vars.isEdge = true;
        }

        var trident = ua.indexOf('Trident/');
        if (trident > 0) {
            // IE 11 => return version number
            var rv = ua.indexOf('rv:');
            cgJsClass.gallery.vars.isEdge = true;
        }*/

        if (ua.indexOf('Edge/') > 0 || ua.indexOf('Edg/')) {
            cgJsClass.gallery.vars.isEdge = true;
        }

    },
    checkIfInternetExplorer: function () {

        cgJsClass.gallery.vars.isInternetExplorer = false;

        // checks if edge or ie !

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))  // If Internet Explorer, return version number
        {
            cgJsClass.gallery.vars.isInternetExplorer = true;
        }

    },
    checkIfIsChrome: function () {

        // please note,
        // that IE11 now returns undefined again for window.chrome
        // and new Opera 30 outputs true for window.chrome
        // but needs to check if window.opr is not undefined
        // and new IE Edge outputs to true now for window.chrome
        // and if not iOS Chrome check
        // so use the below updated condition
        var isChromium = window.chrome;
        var winNav = window.navigator;
        var vendorName = winNav.vendor;
        var isOpera = typeof window.opr !== "undefined";
        var isIEedge = winNav.userAgent.indexOf("Edge") > -1;
        var isIOSChrome = winNav.userAgent.match("CriOS");

        if (isIOSChrome) {
            // is Google Chrome on IOS
        } else if(
            isChromium !== null &&
            typeof isChromium !== "undefined" &&
            vendorName === "Google Inc." &&
            isOpera === false &&
            isIEedge === false
        ) {
            cgJsClass.gallery.vars.isChrome = true;// is Google Chrome
        } else {
            cgJsClass.gallery.vars.isChrome = false;// not Google Chrome
        }

    },
    checkIfIsSafari: function () {

        var ua = navigator.userAgent.toLowerCase();
        if (ua.indexOf('safari') != -1) {
            if (ua.indexOf('chrome') > -1) {
                cgJsClass.gallery.vars.isSafari = false;// Chrome
            } else {
                cgJsClass.gallery.vars.isSafari = true; // Safari
            }
        }

    },
    checkIfIsFF: function () {

        cgJsClass.gallery.vars.isFF = false;

        if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1){
            cgJsClass.gallery.vars.isFF = true;
        }

    },
    checkError: function ($cgCenterDiv,gid,realId) {

        cgJsData[gid].vars.jsonGetImageCheck.push(jQuery.getJSON( cgJsData[gid].vars.uploadFolderUrl+"/contest-gallery/gallery-id-"+cgJsData[gid].vars.gidReal+"/json/image-data/image-data-"+realId+".json", {_: new Date().getTime()}).done(function( data ) {

        }).done(function(data){

            data = cgJsClass.gallery.function.general.tools.calculateSizeGetJsonImageData(data,realId,gid);

            // has to be set here, because was not set in php. Also image Object has to be reset on some places.
            data.id = realId;
            data.imageObject = cgJsData[gid].imageObject[realId];


        }).fail(function (error) {

            if(error.status=='404'){
                cgJsClass.gallery.function.general.tools.removeImageWhenError(gid,realId);
            }

        }));


    },
    checkErrorAbort: function (gid) {

        for(var key in cgJsData[gid].vars.jsonGetImageCheck){

            if(!cgJsData[gid].vars.jsonGetImageCheck.hasOwnProperty(key)){
                break;
            }

            cgJsData[gid].vars.jsonGetImageCheck[key].abort();
        }
        cgJsData[gid].vars.jsonGetImageCheck = [];


    },
    removeImageWhenError: function (gid,realId) {

        cgJsClass.gallery.getJson.removeImageFromImageData(gid,realId);
        cgJsClass.gallery.function.message.show(cgJsClass.gallery.language.ImageDeleted);

    },
    checkSetUserGalleryOptions: function (gid) {

        if(cgJsData[gid].vars.isUserGallery){
            cgJsData[gid].options.general.HideUntilVote = 0;
            cgJsData[gid].options.general.ShowOnlyUsersVotes = 0;
        }

    },
    checkIfSettingsRequiredInFullWindow: function (gid) {

        if((cgJsData[gid].options.pro.CatWidget==1  || cgJsData[gid].options.pro.Search==1 || cgJsData[gid].options.general.RandomSortButton==1 || cgJsData[gid].options.general.AllowSort==1)==false){
            jQuery('#cgCenterImageFullWindowConfiguration'+gid).remove();
            jQuery('#cgCenterDivCenterImageFullWindowConfiguration'+gid).remove();
        }

    },
    setBackgroundColor: function(gid){

        if(!cgJsClass.gallery.vars.backgroundColor){
            var $mainCGdivContainer = jQuery('#mainCGdivContainer'+gid);
            cgJsClass.gallery.function.general.tools.getBackgroundColor($mainCGdivContainer);
        }

        if(cgJsClass.gallery.vars.backgroundColor){
            var bgColor = cgJsClass.gallery.vars.backgroundColor;
            if(bgColor.indexOf(',')){
                var parts = bgColor.split(',');
                if(parts.length>3){
                    var opacityValue = parts[parts.length-1].split(')')[0].trim();
                    if(opacityValue.indexOf('0')!=-1){// must have opacity lower 1. So is transparent.
                        var newBgColor = '';
                        parts.forEach(function (value,index) {

                            if(index==parts.length-1){
                                newBgColor+='1)';
                            }else{
                                newBgColor+=value+',';
                            }
                        });
                        cgJsClass.gallery.vars.backgroundColor = newBgColor;

                    }
                }
            }

            jQuery('#mainCGdivUploadForm'+gid).css('background-color',cgJsClass.gallery.vars.backgroundColor);
            jQuery('#mainCGdivHelperParent'+gid).css('background-color',cgJsClass.gallery.vars.backgroundColor);
            jQuery('#mainCGdivFullWindowConfigurationArea'+gid).css('background-color',cgJsClass.gallery.vars.backgroundColor);
        }

    },
    getBackgroundColor: function($mainCGdivContainer,$parent){

        if(!$parent){
            $parent = $mainCGdivContainer.parent();
        }else{
            $parent = $parent.parent();
        }

        var backgroundColor = $parent.css('backgroundColor');
        var tagName = $parent.prop('tagName').toLowerCase();

        if((backgroundColor=='rgba(0, 0, 0, 0)' || backgroundColor=='transparent') && tagName!='html'){//if not set transparent is in IE
            this.getBackgroundColor(undefined,$parent);
        }else{
            cgJsClass.gallery.vars.backgroundColor = backgroundColor;
        }

    },
    testTopControlsStyle: function($){

        $(document).on('click','.cgChangeTopControlsStyleOptionTestWhiteSites',function () {
            var $element = $(this);
            var gid = $element.attr('data-cg-gid');
            $('#mainCGdivUploadForm'+gid).find('.cg_fe_controls_style_black').addClass('cg_fe_controls_style_white').removeClass('cg_fe_controls_style_black');

            var $mainCGdivHelperParent = $(this).closest('.mainCGdivHelperParent ');
            $mainCGdivHelperParent.addClass('cg_fe_controls_style_white').removeClass('cg_fe_controls_style_black');
            $mainCGdivHelperParent.find('.cg_fe_controls_style_black').addClass('cg_fe_controls_style_white').removeClass('cg_fe_controls_style_black');
            $('#cgMessagesContainer').addClass('cg_fe_controls_style_white').removeClass('cg_fe_controls_style_black');
            $(this).addClass('cg_hide');
            $(this).closest('.cgChangeTopControlsStyleOptionMessage').find('.cgChangeTopControlsStyleOptionTestBlackSites').removeClass('cg_hide');
        });

        $(document).on('click','.cgChangeTopControlsStyleOptionTestBlackSites',function () {
            var $element = $(this);
            var gid = $element.attr('data-cg-gid');
            $('#mainCGdivUploadForm'+gid).find('.cg_fe_controls_style_white').addClass('cg_fe_controls_style_black').removeClass('cg_fe_controls_style_white');

            var $mainCGdivHelperParent = $(this).closest('.mainCGdivHelperParent ');
            $mainCGdivHelperParent.addClass('cg_fe_controls_style_black').removeClass('cg_fe_controls_style_white');
            $mainCGdivHelperParent.find('.cg_fe_controls_style_white').addClass('cg_fe_controls_style_black').removeClass('cg_fe_controls_style_white');
            $('#cgMessagesContainer').addClass('cg_fe_controls_style_black').removeClass('cg_fe_controls_style_white');
            $(this).addClass('cg_hide');
            $(this).closest('.cgChangeTopControlsStyleOptionMessage').find('.cgChangeTopControlsStyleOptionTestWhiteSites').removeClass('cg_hide');
        });

        cgJsClass.gallery.function.general.ajax.changesRecognized($);


    },
    getScrollbarWidthDependsOnBrowser: function () {

        if(cgJsClass.gallery.vars.isMobile){
            return 0;
        }

        if(cgJsClass.gallery.vars.isChrome){
            return 13;
        }else if(cgJsClass.gallery.vars.isSafari){
            return 16;
        }else if(cgJsClass.gallery.vars.isFF){
            return 17;
        }else if(cgJsClass.gallery.vars.isEdge){
            return 16;
        }else{
            return 16;
        }

    },
    getValueForPreselectSort: function (valueForPreselectSort) {

        if(valueForPreselectSort=='date_descend'){
            return 'date-desc';
        }
        if(valueForPreselectSort=='date_ascend'){
            return 'date-asc';
        }

        if(valueForPreselectSort=='comments_descend'){
            return 'comments-desc';
        }
        if(valueForPreselectSort=='comments_ascend'){
            return 'comments-asc';
        }

        if(valueForPreselectSort=='rating_descend'){
            return 'rating-desc';
        }
        if(valueForPreselectSort=='rating_ascend'){
            return 'rating-asc';
        }

        if(valueForPreselectSort=='rating_descend_average'){
            return 'rating-desc-average';
        }
        if(valueForPreselectSort=='rating_ascend_average'){
            return 'rating-asc-average';
        }

        return 'date-desc';

    },
    checkHasNoBottomSpace: function (gid,data) {

        var hasNoFieldContent = true;

        for(var property in data){

            if(!data.hasOwnProperty(property)){
                break;
            }

            if(data[property]['field-content']){
                hasNoFieldContent = false;
                break;
            }

        }
        if (hasNoFieldContent && cgJsData[gid].options.general.FbLike!=1 && cgJsData[gid].options.general.AllowComments!=1) {
            return true;
        }else{
            return false;
        }


    },
    getOrderByGidAndRealId: function (gid,realId) {

        var order = 0;

        for(var index in cgJsData[gid].image){

            if(!cgJsData[gid].image.hasOwnProperty(index)){
                break;
            }

            var firstKey = Object.keys(cgJsData[gid].image[index])[0];

            var id = cgJsData[gid].image[index][firstKey]['id'];

            if(id==realId){
                order = index;
                break;
            }

        }

        return order;

    },
    calculateSizeImageDataPreProcess: function (data,gid) {

        for(var realId in data){

            if(!data.hasOwnProperty(realId)){
                break;
            }

            if(data[realId]['thumbnail_size_w'] && data[realId]['thumbnail']){
                data[realId]['thumbnail_size_w'] = cgJsClass.gallery.function.general.tools.calculateSize(data[realId]['thumbnail'],parseInt(data[realId]['thumbnail_size_w']),data[realId],'thumbnail_size_w',realId,gid);
            }
            if(data[realId]['medium_size_w'] && data[realId]['medium']){
                data[realId]['medium_size_w'] = cgJsClass.gallery.function.general.tools.calculateSize(data[realId]['medium'],parseInt(data[realId]['medium_size_w']),data[realId],'medium_size_w',realId,gid);
            }
            if(data[realId]['large_size_w'] && data[realId]['large']){
                data[realId]['large_size_w'] = cgJsClass.gallery.function.general.tools.calculateSize(data[realId]['large'],parseInt(data[realId]['large_size_w']),data[realId],'large_size_w',realId,gid);
            }


        }

        return data;

    },
    calculateSizeGetJsonImageData: function (data,realId,gid) {

        if(data['thumbnail_size_w'] && data['thumbnail']){
            data['thumbnail_size_w'] = cgJsClass.gallery.function.general.tools.calculateSize(data['thumbnail'],parseInt(data['thumbnail_size_w']),data,'thumbnail_size_w',realId,gid);
        }
        if(data['medium_size_w'] && data['medium']){
            data['medium_size_w'] = cgJsClass.gallery.function.general.tools.calculateSize(data['medium'],parseInt(data['medium_size_w']),data,'medium_size_w',realId,gid);
        }
        if(data['large_size_w'] && data['large']){
            data['large_size_w'] = cgJsClass.gallery.function.general.tools.calculateSize(data['large'],parseInt(data['large_size_w']),data,'large_size_w',realId,gid);
        }

        return data;

    },
    calculateSize: function (imagePath,fallbackSize,data,type,realId,gid) {

        try{

            var splitImagePath = imagePath.split('x');
            var splitWidthPart = splitImagePath[splitImagePath.length-2].split('-');
            var width = splitWidthPart[splitWidthPart.length-1];

            if(isNaN(width)){
                width = fallbackSize;
            }else{
                width = parseInt(width);
            }

        }catch(e){// happens only for small uploaded images
            //debugger;
            //console.log(data);
            //console.log(imagePath);
            width = fallbackSize;

            try{// to go sure, it is in try and catch
                jQuery("<img/>",{
                    load : function(){
                        //console.log(this.width+' '+this.height);
                        if(cgJsData[gid].vars.rawData[realId]){
                            cgJsData[gid].vars.rawData[realId][type] = this.width;
                        }
                    },
                    src  : imagePath
                });
            }catch(e){
                //debugger;
                console.log(e);
            }

        }

        return width;

    }
};