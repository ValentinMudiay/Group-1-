cgJsClass.gallery.thumbLogic = {
    init: function (jQuery,gid,openPage,calledFromUpload,openImage,stepChange,viewChange,randomButtonClicked,isCopyUploadToAnotherGallery) {

        if(typeof openPage == 'undefined'){
            openPage = false;
        }

        // gallery index
        var gid = gid;

        //!IMPORTANT current view look for resize
        cgJsData[gid].vars.currentLook='thumb';


        var $ = jQuery;

        var cg_gallery_resize = $('#cg_gallery_resize').val();


        // Ermitteln von Breite des parent Divs nach resize

        if(cgJsClass.gallery.vars.fullwindow==gid){
            // -40 wegen padding 20 rechts links und 15 wege scroll bar die beim parent hinzugefügt wird
            // var widthMainCGallery = $('body').width()-55;
            var widthMainCGallery = $(window).width()-cgJsClass.gallery.function.general.tools.getScrollbarWidthDependsOnBrowser();
        }else{
            var widthMainCGallery = $('#mainCGdivContainer'+gid).width();
        }

        if(widthMainCGallery<247){
            widthMainCGallery = 247;
        }

        // Breite des divs in dem sich die Galerie befindet
        var widthmain = widthMainCGallery;

        var $mainCGallery = $('#mainCGallery'+gid);
        var $mainCGdiv = $('#mainCGdiv'+gid);

        $mainCGdiv.css('width',widthmain+'px');
        cgJsData[gid].vars.cgCenterDiv.css('width',widthmain+'px');

        var sliderView = false;

        if((cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow) || cgJsData[gid].options.general.SliderLook==1 ){
            sliderView = true;
        }

        cgJsData[gid].vars.widthmain = widthmain;

        cgJsClass.gallery.views.functions.destroyRangeSlider(gid);

        var $mainCGslider = $('#mainCGslider'+gid);
        cgJsData[gid].vars.mainCGslider = $mainCGslider;

        if(cgJsData[gid].image.length<1){
            $mainCGdiv.find('#cgLdsDualRingMainCGdivHide'+gid).addClass('cg_hide');
            $mainCGslider.addClass('cg_hide');
            $mainCGslider.find('#cgLdsDualRingMainCGdivHide'+gid).addClass('cg_hide');

            return;
        }else{
            if(sliderView){
                $mainCGdiv.find('#cgLdsDualRingMainCGdivHide'+gid).removeClass('cg_hide');
                $mainCGslider.find('#cgLdsDualRingMainCGdivHide'+gid).removeClass('cg_hide');
            }
        }


        if(sliderView == true){

            if(cgJsData[gid].image.length==0){
                $mainCGslider.addClass('cg_hide');
            }else{
                $mainCGslider.removeClass('cg_hide');
            }

            //   cgJsData[gid].vars.cgCenterDivAppearenceHelper.addClass('cg_hide');

            //  cgJsData[gid].vars.currentLook='slider';

            var approximateWidth = 150;

            if(widthmain<800){
                approximateWidth = 130;
            }

            /*            if(widthmain<700){
                            approximateWidth = 110;
                        }
                        if(widthmain<600){
                            approximateWidth = 100;
                        }

                        if(widthmain<500){
                            approximateWidth = 80;
                        }*/


            var maximumVisibleImagesInSlider = Math.round(widthmain/approximateWidth);
            if (maximumVisibleImagesInSlider % 2 == 0) {// then even!!! Has to be maken odd
                maximumVisibleImagesInSlider = maximumVisibleImagesInSlider+1;
            }
            cgJsData[gid].vars.maximumVisibleImagesInSlider = maximumVisibleImagesInSlider;
            var newWidth = widthmain/maximumVisibleImagesInSlider;
            var newWidthMultiplikator = newWidth/approximateWidth;
            var newHeight = 100*newWidthMultiplikator;
            var widthSlider = newWidth;
            cgJsData[gid].vars.widthSliderPreview = widthSlider;
            var heightSlider = newHeight;
            var heightSliderContainer = heightSlider+10;// +2 because of padding for little space between scrollbar and border selected

            if(cgJsClass.gallery.vars.isEdge){
                heightSliderContainer = heightSliderContainer + 7;
            }
            if(cgJsClass.gallery.vars.isFF){
                heightSliderContainer = heightSliderContainer + 7;
            }

            //  var imagesCount = Object.keys(cgJsData[gid].vars.rawData).length;
            // var widthmainCgSlider = newWidth*imagesCount+newWidth*maximumVisibleImagesInSlider;// newWidth*maximumVisibleImagesInSlider ist sicherheitsabstand rechts

            // if(stepChange!=true){
            $mainCGallery.css('width',widthmain+'px');


            $mainCGslider.css({
                'width': widthmain+'px',
                //'height': heightSliderContainer+'px'
            });

            var countImages = Object.keys(cgJsData[gid].image).length;

            if(countImages*cgJsData[gid].vars.widthSliderPreview < cgJsData[gid].vars.widthmain){
                var paddingLeftSlider = ((cgJsData[gid].vars.widthmain-(countImages*cgJsData[gid].vars.widthSliderPreview))/2)
                $mainCGslider.css('padding-left',paddingLeftSlider+'px');
            }else{
                $mainCGslider.css('padding-left','0');
            }

            //   }

            if($mainCGallery.find('.cg_show').length>=1){// then must come from slider look
                // $('#mainCGallery'+gid).addClass('cg_hidden');
                $mainCGallery.find('.cg_show').appendTo($mainCGslider);
            }

        }else{
            //       cgJsData[gid].vars.cgCenterDivAppearenceHelper.removeClass('cg_hide');
            $mainCGallery.css('width',widthmain+'px');
            cgJsClass.gallery.views.functions.checkAndAppendFromSliderToGallery($mainCGallery,$mainCGslider);

        }

        cgJsData[gid].vars.cgCenterDiv.css('width',widthmain+'px');
        cgJsData[gid].vars.thumbViewWidthFromLastImageInRow = widthmain;// vorab festlegung hier, eigentliche anpassung erfolgt unten, hier ist allerdings nützlich bei open full size das erste mal

        if(openPage==true || viewChange==true){
            $('#mainCGallery'+gid).removeClass('cg_fade_in_new').addClass('cg_hidden');
        }

        if(calledFromUpload){
            $('#mainCGallery'+gid).removeClass('cg_fade_in_new').addClass('cg_hidden');
        }

        $mainCGallery.removeClass('cg_fade_in_new');

        // manchmal wird width nicht gesetzt, deswegen sicherheithalber nochmal setzen
        if(openPage===true && sliderView==false){
            if($mainCGdiv.css('width')!=true){
                $mainCGallery.css('visibility','hidden');
                setTimeout(function () {
                    $mainCGdiv.css('width',cgJsData[gid].vars.widthmain+'px');
                    setTimeout(function () {
                        //    $mainCGallery.css('visibility','visible').addClass('cg_fade_in_new');
                    },100);
                },100);
            }
        }else{

            $mainCGallery.addClass('cg_hidden');
            $mainCGallery.removeClass('cg_fade_in');
            $mainCGallery.css('visibility','visible');
        }

        if(sliderView == true && viewChange===true){

            $mainCGdiv.find('#cgLdsDualRingMainCGdivHide'+gid).removeClass('cg_hide');

        }

        //$('#cgGalleryViewSortControl'+gid).width(widthmain);

        var opacity = parseFloat(cgJsData[gid].options.visual.ThumbViewBorderOpacity);

        var borderColor = cgJsData[gid].options.visual.ThumbViewBorderColor;

        var hex2rgb = function(hexStr){
            // note: hexStr should be #rrggbb
            var hex = parseInt(hexStr.substring(1), 16);
            var r = (hex & 0xff0000) >> 16;
            var g = (hex & 0x00ff00) >> 8;
            var b = hex & 0x0000ff;
            return [r, g, b];
            //return r;
        };

        if(borderColor==''){
            borderColor = '#000000';
        }

        var rcolor = hex2rgb(borderColor);

        var rgba = "("+rcolor[0]+","+rcolor[1]+","+rcolor[2]+", "+opacity+")";

        // Summe der einzelnen Breiten
        var aggregateWidth = 0;

        // wird am Ende verabeitet
        var i = 0;

        // wird am Anfang verabeitet
        var r = 0;

        //var WidthThumb = parseInt($('#cg_WidthThumb').val());
        //var HeightThumb = parseInt($('#cg_HeightThumb').val());
        var WidthThumb = parseInt(cgJsData[gid].options.general.WidthThumb);
        var HeightThumb = parseInt(cgJsData[gid].options.general.HeightThumb);

        //var border = parseInt(cgJsData[gid].options.visual.ThumbViewBorderWidth);
        var border = 0;

        var DistancePicsX = parseInt(cgJsData[gid].options.general.DistancePics);
        var DistancePicsV = parseInt(cgJsData[gid].options.general.DistancePicsV);


        if(sliderView==true){
            DistancePicsX = 0;
            DistancePicsV = 0;
            border=0;
        }


        // extra korrektur sonst fehler bei ansicht
        if(border>0){
            if(DistancePicsX==0){
                DistancePicsX = 1;
            }
            if(DistancePicsV==0){
                DistancePicsV = 1;
            }
        }


        if(parseInt(cgJsData[gid].options.visual.ThumbViewBorderRadius)>5){var cg_CircleImages=1;}
        else{var cg_CircleImages=0;}

        //ACHTUNG!! Das hier wichtig. Int Value geht nach einem Lauf verloren.
        widthmain = parseInt(widthmain);
        DistancePicsX = parseInt(DistancePicsX);

        //alert(widthmain+DistancePicsX);

        var xMultiFull  = (widthmain+DistancePicsX)/(WidthThumb+2*border+DistancePicsX);

        // Genauer Multiplikator zur Exakten Berechnung von WidthThumb beim Adjustment, welches jetzt standardmäßig immer aktiviert ist bei dieser Ansicht.
        if(xMultiFull<=1){
            var xMulti1 = xMultiFull;



            //Wichtig! Zum Ausgleich in der Breite je nach Anzahl der Bilder.
            var xMultiFull1 = 0;


        }

        else{

            xMultiFull1 = xMultiFull.toString();

            var xMulti = xMultiFull1.split(".");

            var picsInRow = parseInt(xMulti[0]);


            var xMulti1 = (widthmain+DistancePicsX)/(((WidthThumb+2*border+DistancePicsX)*picsInRow));

        }

        //Wichtig! Zum Ausgleich in der Breite je nach Anzahl der Bilder.
        var xMultiFull1Adjustment = Math.ceil(xMultiFull1);

        WidthThumb=WidthThumb*xMulti1;
        WidthThumb=Math.floor(WidthThumb)-xMultiFull1Adjustment;

        HeightThumb=HeightThumb*xMulti1;
        DistancePicsX=DistancePicsX*xMulti1;
        DistancePicsV=DistancePicsV*xMulti1;

        border=border*xMulti1;

        //  var cg_pics_per_row = Math.floor(widthmain/(WidthThumb + DistancePicsX+border*2));
        //alert(cg_gallery_resize);

        // var aggregateWidth = parseInt($('.aggregateWidth').val()); // Hidden Feld zum sammeln und abrufen von aggregateWidth über Jquery

        var firstRow = 0;

        var classCounter = 0;

        var firstRealId = null;

        // needs only for row logic!!!!
        cgJsClass.gallery.resize.galleryIcons($mainCGallery,openPage,true,gid,widthmain);

        if(sliderView == true){
            cgJsClass.gallery.resize.galleryIconsSlider($mainCGslider,openPage,false,gid,widthmain);
        }

        $.each(cgJsData[gid].image, function( index,value ) {

            var arrIndex = index;

            var firstKey = Object.keys(value)[0];

            //  var objectKey = Object.keys(firstKey)[0];
            var objectKey = firstKey;
            // var objectKey = value[firstKey]['rowid'];


            var categoryId = cgJsData[gid].image[index][firstKey]['Category'];


            if(typeof cgJsData[gid].vars.categories[categoryId] != 'undefined'){


                if(cgJsData[gid].vars.showCategories == true && cgJsData[gid].vars.categories[categoryId]['Checked']==false){


                    return;

                }

            }

            classCounter++;

            r++;

            //var imgSrcThumbWidth = parseInt(cgJsData[gid].image[index][objectKey].thumbnail_size_w);
            var realId = cgJsData[gid].image[index][firstKey]['id'];

            // thumb wird nicht verwendet, da thumb quadratisches abgeschnittenes bild ist und somot nicht passen könnte
            var imgSrcMedium = cgJsClass.gallery.function.general.tools.checkSsl(cgJsData[gid].vars.rawData[realId].medium);
            // thumbnail_size_w, medium_size_w and large_size_w calculation will be done in init-gallery-getjson imageDataPreProcess with calculateSizeImageDataPreProcess function
            var imgSrcMediumWidth = parseInt(cgJsData[gid].vars.rawData[realId].medium_size_w);
            var imgSrcLarge = cgJsClass.gallery.function.general.tools.checkSsl(cgJsData[gid].vars.rawData[realId].large);
            // thumbnail_size_w, medium_size_w and large_size_w calculation will be done in init-gallery-getjson imageDataPreProcess with calculateSizeImageDataPreProcess function
            var imgSrcLargeWidth = parseInt(cgJsData[gid].vars.rawData[realId].large_size_w);
            var imgSrcOriginal = cgJsClass.gallery.function.general.tools.checkSsl(cgJsData[gid].vars.rawData[realId].full);
            // schon mal pauschal ausmachen
            var imgSrc = imgSrcLarge;


            var cg_Use_as_URL = cgJsData[gid].vars.formHasUrlField;
            var cg_ForwardToURL = cgJsData[gid].options.general.ForwardToURL;
            var cg_ForwardFrom = cgJsData[gid].options.general.ForwardFrom;
            var cg_FullSizeImageOutGalleryNewTab = cgJsData[gid].options.general.FullSizeImageOutGalleryNewTab;
            var cg_FullSizeImageOutGallery = cgJsData[gid].options.general.FullSizeImageOutGallery;

            //Achtung entspricht nicht der Anzahl der tatsächlich geladenen Bilder. Fängt mit 0 an. Wird auch für das gesammelte Height und Width Array verwendet.
            var cg_pagination_position_count = $('#cg_pagination_position_count').val();

            // Wenn resize gemacht wurde gerade und logic läuft, dann sollen ALLE nochmal abgearbeitet werden

            if(i<=cg_pagination_position_count && cgJsData[gid].options.general.InfiniteScroll==1 && cg_pagination_position_count!=0 && cg_gallery_resize!=1){
                //var cg_do_nothing = 1;
            }

            else{

                var realId = cgJsData[gid].image[index][firstKey]['id'];

                if(!firstRealId){
                    firstRealId=realId;
                }

                var imgDataWidth = parseInt(cgJsData[gid].vars.rawData[realId].Width);

                //if(typeof cgJsData[gid].image[index][firstKey]['imageObject'] === "undefined") {
                // if(typeof cgJsData[gid].vars.rawData[realId]['imageObject'] === "undefined") {
                if(typeof cgJsData[gid].imageObject[realId] === "undefined") {

                    //         var imageTitle = cgJsData[gid].image[index][firstKey]['post_title'];
                    /*

                                        var imageTarget = '';

                                        if(cg_FullSizeImageOutGallery==1){
                                            imageTarget = 'target="_blank"';
                                            var imageHref = imgSrcOriginal;
                                        }
                                        else{
                                            var imageHref = location.href+'#!image/'+realId+'/'+imageTitle;
                                        }


                    */
                    var imageTarget = '';
                    var imageHref = '';
                    if(cgJsData[gid].options.general.FullSizeImageOutGallery==1){
                        imageTarget = 'target="_blank"';
                        imageHref = imgSrcOriginal;
                    }


                    var cgShowObject = $("<div data-cg-cat-id='"+categoryId+"' data-cg-gid='"+gid+"' data-cg-id='"+realId+"' data-cg-cat-gid='"+gid+"' data-cg-order='"+index+"' class='cg_show cg-cat-"+categoryId+"' id='cg_show"+realId+"'>");

                }
                else{

                    // Pauschal blink class cg_blink_image_disappear entfernen
                    // var cgShowObject = cgJsData[gid].image[index][firstKey]['imageObject'].removeClass('cg_hide').removeClass('cg_blink_image_disappear').removeClass('cg_fade_in');
                    var cgShowObject = cgJsData[gid].imageObject[realId].removeClass('cg_hide').removeClass('cg_blink_image_disappear').removeClass('cg_fade_in');
                    cgJsData[gid].image[index][firstKey]['imageObject'] = cgJsData[gid].imageObject[realId];

                }

                if(cgJsClass.gallery.vars.switchViewsClicked==true){
                    cgShowObject.removeAttr('style width height');
                    cgShowObject.find('.cg_append').removeAttr('style width height');
                    // cgShowObject.find('.cg_append_image').removeAttr('style width height');
                }



                var widthOriginalImg = parseInt(cgJsData[gid].image[index][objectKey].Width);
                var heightOriginalImg = parseInt(cgJsData[gid].image[index][objectKey].Height);


                var cgRotationThumbNumber = parseInt(cgJsData[gid].image[index][objectKey].rThumb);

                var cgImageThumbRotation = "cg"+cgJsData[gid].image[index][objectKey].rThumb+"degree";


                if(cgRotationThumbNumber=='90' || cgRotationThumbNumber=='270'){
                    var cgRotateRatio = widthOriginalImg/heightOriginalImg;
                    var cgWidthOriginalImgContainer = widthOriginalImg;
                    widthOriginalImg = heightOriginalImg;
                    heightOriginalImg = cgWidthOriginalImgContainer;
                }


                var cg_a_href_title = '';

                // Ermittlung der Höhe nach Skalierung. Falls unter der eingestellten Höhe, dann nächstgrößeres Bild nehmen.
                var heightScaledThumb = WidthThumb*heightOriginalImg/widthOriginalImg;

                // Falls unter der eingestellten Höhe, dann größeres Bild nehmen (normales Bild oder panorama Bild, kein Vertikalbild)
                if (heightScaledThumb <= HeightThumb) {

                    // Bestimmung von Breite des Bildes
                    var WidthThumbPic = HeightThumb*widthOriginalImg/heightOriginalImg;

                    // Bestimmung von Breite des Bildes
                    var WidthThumbPic = WidthThumbPic+2;
                    //$WidthThumbPic = $WidthThumbPic.'px';

                    // Bestimmung wie viel links und rechts abgeschnitten werden soll
                    var paddingLeftRight = (WidthThumbPic-WidthThumb)/2;

                    if(cgRotationThumbNumber=='90' || cgRotationThumbNumber=='270'){
                        WidthThumbPic= WidthThumbPic*cgRotateRatio;
                        var paddingLeftRight = (WidthThumbPic-WidthThumb*cgRotateRatio)/2;
                    }

                    paddingLeftRight = paddingLeftRight+'px';

                    var padding = "left: -"+paddingLeftRight+";right: -"+paddingLeftRight+"";

                    var HeightThumbImageValue = HeightThumb+"px";

                }

                // Falls über der eingestellten Höhe, dann kleineres Bild nehmen (kein Vertikalbild)
                if (heightScaledThumb > HeightThumb) {

                    if(cgRotationThumbNumber=='90' || cgRotationThumbNumber=='270'){

                        var WidthThumbPic = (WidthThumb+2)*cgRotateRatio;

                    }
                    else{
                        // Bestimmung von Breite des Bildes
                        var WidthThumbPic = (WidthThumb+2);
                    }

                    // Bestimmung wie viel oben und unten abgeschnitten werden soll
                    var heightImageThumb = WidthThumb*heightOriginalImg/widthOriginalImg;
                    var paddingTopBottom = (heightImageThumb-HeightThumb)/2;
                    paddingTopBottom = paddingTopBottom+'px';

                    var padding = "top: -"+paddingTopBottom+";bottom: -"+paddingTopBottom+"";

                    var HeightThumbImageValue = "auto";

                }


                var putDistancePicsX = DistancePicsX;

                var widthToAggregateToCheck = WidthThumb + border*2;

                // DistancePicsX folgt dann weiter unten!
                aggregateWidth = aggregateWidth + WidthThumb + border*2;

                var check3849 = r-1;


                // ACHTUNG DAS HIER IST NUR FÜR DistancePicX!
                if(check3849 % picsInRow == 0){

                    putDistancePicsX=0;

                    if(r-1!=0){firstRow++;}

                }

                if(r==1 && xMultiFull<=1){

                    putDistancePicsX=0;

                }

                if(r==2 && xMultiFull<=1){

                    firstRow++;

                }

                // pauschal border none und margin unset
                // sonst falsche anzeige falls eine view davor margin und border hatte und diese nicht
                cgShowObject.css({
                    'border':'none',
                    'margin':'unset',
                    'width': WidthThumb,
                    'margin-left':putDistancePicsX,
                    'margin-right':0
                });

                // cgShowObject.find( "[id*=cg_hide]").css('width',WidthThumb);
                // cgShowObject.find( "[id*=cg_Field1IdGalleryView]").css('width',WidthThumb);

                if(firstRow==0 && cg_pagination_position_count==0){
                    cgShowObject.css('margin-top',0);
                }
                else{cgShowObject.css('margin-top',DistancePicsV);}

                if(cg_CircleImages==1){cgShowObject.css({"border-radius": ""+cgJsData[gid].options.visual.ThumbViewBorderRadius+"%"}); var circleImagesOverflow = "overflow:hidden";}

                cgShowObject.css('display','inline-block');
                cgShowObject.css('vertical-align','top');

                widthToAggregateToCheck = widthToAggregateToCheck + DistancePicsX;
                aggregateWidth = aggregateWidth + DistancePicsX;

                // var aggregateWidthCheck = aggregateWidth+100;


                // Höhe von input Field ausgleichen wenn es zu lang ist --- ENDE

                var heightInfoDiv = cgShowObject.find("div[id*=cg_hide]").height();
                cgShowObject.find("div[id*=cg_hide]").children("div").css('position','relative !important');
                var heightInfoDivInfo = cgShowObject.find("div[id*=cg_hide]").children(".cg_info_depend_on_radius").height();

                if(cg_CircleImages==1){// Achtung! Div height hier nehmen!!!
                    cgShowObject.find("[id*=cg_hide]").css('margin-bottom',HeightThumb/2-heightInfoDiv/2);

                }

                // Positionen Info Comments und Rating auf den Galerie Images

                // INFO
                if(cgJsData[gid].options.visual.TitlePositionGallery==2){
                    cgShowObject.find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css('text-align','center');
                    cgShowObject.find("[id*=cg_Field1IdGallery]").css('text-align','center');

                }
                else if(cgJsData[gid].options.visual.TitlePositionGallery==3){
                    cgShowObject.find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css('text-align','right');
                    cgShowObject.find("[id*=cg_Field1IdGallery]").css('text-align','right');

                }
                else{
                    cgShowObject.find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css('text-align','left');
                    cgShowObject.find("[id*=cg_Field1IdGallery]").css('text-align','left');
                }

                // COMMENTS
                if(cgJsData[gid].options.visual.CommentPositionGallery==2){
                    cgShowObject.find("div[id*=cg_hide]").find(".cg_info_comment_gallery_div").css("text-align","center");
                }
                else if(cgJsData[gid].options.visual.CommentPositionGallery==3){
                    cgShowObject.find("div[id*=cg_hide]").find(".cg_info_comment_gallery_div").css("text-align","right");
                }
                else{

                }

                // RATING
                if(cgJsData[gid].options.visual.RatingPositionGallery==2){
                    cgShowObject.find("div[id*=cg_hide]").find(".cg_gallery_rating_div").css("text-align","center");
                }
                else if(cgJsData[gid].options.visual.RatingPositionGallery==3){
                    cgShowObject.find("div[id*=cg_hide]").find(".cg_gallery_rating_div").css("text-align","right");
                }
                else{

                }

                // Positionen Info Comments und Rating auf den Galerie Images --- ENDE

                if(cg_Use_as_URL==1 && cg_ForwardToURL==1 && cg_ForwardFrom==2){

                    //Prüfen ob vom user ein http bei entries der url mit eingetragen wurde, wenn nicht dann hinzufügen

                    var cg_img_url_entry = $("#cg_img_url"+realId+"").val();

                    if (typeof cg_img_url_entry === 'undefined') { }
                    else if(cg_img_url_entry.indexOf("http") > -1) { cg_img_url_entry = cg_img_url_entry; }
                    else{ cg_img_url_entry = "http://"+cg_img_url_entry;}


                }
                else{

                    //   var cg_id_class_img = "data-cg_image_id='"+realId+"' id='cg_image_id"+realId+"' class='cg_append_image cg_image"+r+" "+cgImageThumbRotation+"'";

                    //Prüfen ob FullSizeImageOutGalleryNewTab aktiviert ist

                    if(cg_FullSizeImageOutGallery==1){
                        if(cg_FullSizeImageOutGalleryNewTab==1){var cg_href_img_blank = "target='_blank'";}
                        else{var cg_href_img_blank = "";}
                    }

                }

                if(cgJsData[gid].options.general.AllowComments>=1 || cgJsData[gid].options.general.AllowRating>=1 || cgJsData[gid].options.general.FbLikeGallery>=1){

                    var hideTillHover = '';

                    if(cgJsData[gid].options.general.ShowAlways!=1) {

                        hideTillHover = 'cg_hide_till_hover';

                    }

                    var ratingCommentDiv = '<div data-cg_image_id="'+realId+'" class="cg_image'+classCounter+' cg_gallery_info '+hideTillHover+'" id="cgGalleryInfo'+realId+'">' +
                        '</div>';
                }
                else{

                    var ratingCommentDiv = '';

                }

                if(sliderView==true){

                    cgShowObject.css({
                        'width': widthSlider+'px',
                        'height': heightSlider+'px',
                        'float' : 'none'
                    });

                    WidthThumb = widthSlider;
                    HeightThumb = heightSlider;

                    if(cgJsData[gid].options.general.FbLikeGallery>=1){
                        cgShowObject.find('#cgFacebookGalleryDiv'+realId).addClass('cg_hide');
                    }

                }else{
                    if(cgJsData[gid].options.general.FbLikeGallery>=1){
                        cgShowObject.find('#cgFacebookGalleryDiv'+realId).removeClass('cg_hide');
                    }
                }

                // Extra Korrektur für rotated images wenn in single view vorher korrigiert wurden
                if(cgRotationThumbNumber=='270' || cgRotationThumbNumber=='90'){
                    cgShowObject.find('#cgGalleryInfo'+realId).css({
                        'top': 'unset',
                        'display': 'block'
                    });
                }



                //  if(typeof cgJsData[gid].image[index][objectKey]['imageObject'] === "undefined"){
                // if(typeof cgJsData[gid].vars.rawData[realId]['imageObject'] === "undefined"){
                if(typeof cgJsData[gid].imageObject[realId] === "undefined"){

                    var postTitle = '',
                        postAlt = '';

                    /*                    if(cgJsData[gid].image[index][objectKey].hasOwnProperty('post_title')){
                                            if(cgJsData[gid].image[index][objectKey]['post_title']!=''){
                                                postTitle = 'title="'+cgJsData[gid].image[index][objectKey]['post_title']+'"';
                                            }
                                        }

                                        if(cgJsData[gid].image[index][objectKey].hasOwnProperty('post_alt')){
                                            if(cgJsData[gid].image[index][objectKey]['post_alt']!=''){
                                                postAlt = 'alt="'+cgJsData[gid].image[index][objectKey]['post_alt']+'"';
                                            }
                                        }*/

                    var imageObject = $('<figure class="cg_figure"><div id="cg_append'+realId+'" class="cg_append '+cgImageThumbRotation+'" '+postTitle+' '+postAlt+'></div><figcaption class="cg_figcaption"></figcaption></figure>');

                    //   var imageObject = $('<div id="cg_append'+realId+'" class="cg_append '+cgImageThumbRotation+'" style="width:'+WidthThumb+'px;height:'+HeightThumb+'px;" ></div>');

                    imageObject.find('.cg_append').css({"border": "rgba"+rgba+" solid "+border+"px"});

                    var cgShowPositionHelper = $('<span id="cgShowPositionHelper'+realId+'" class="cg_show_position_helper" data-cg-gid="'+gid+'"></span>');

                    // Prüfung und bestimmung der URL Weiterleitung, falls aktiviert ist --- ENDE

                    // thumb wird nicht verwendet, da thumb quadratisches abgeschnittenes bild ist und somot nicht passen könnte
                    if(WidthThumbPic<=imgSrcMediumWidth){
                        imgSrc = imgSrcMedium;
                    }
                    else if(WidthThumbPic<=imgSrcLargeWidth){
                        imgSrc = imgSrcLarge;
                    }
                    else{
                        imgSrc = imgSrcOriginal;
                    }


                    if(cgJsData[gid].image[index][objectKey].rThumb=='270' || cgJsData[gid].image[index][objectKey].rThumb=='90'){
                        imageObject.find('.cg_append').css({
                            // 'width': HeightThumb+'px',
                            //  'height': WidthThumb+3+'px',
                            'width': 100+'%',
                            'height': 150+'%'
                        });
                        imgSrc = imgSrcLarge;
                    }else{
                        imageObject.find('.cg_append').addClass('cg_append_hundert_percent');
                    }

                    // always image large to go sure when rotated!!! Otherwsise could be looking washed because low resolution.
                    if(cgJsData[gid].image[index][objectKey].rThumb=='270' || cgJsData[gid].image[index][objectKey].rThumb=='90'){
                        imageObject.find('.cg_append').css('background','url("'+imgSrcLarge+'") no-repeat center center');
                    }else{
                        imageObject.find('.cg_append').css('background','url("'+imgSrc+'") no-repeat center center');
                    }

                    cgShowObject.css({
                        'width': WidthThumb+'px',
                        'height': HeightThumb+'px'
                    });




                    if(cgJsData[gid].options.general.FullSizeImageOutGallery==1){
                        imageTarget = 'target="_blank"';
                        imageHref = imgSrcOriginal;

                        var contentWrapped =  $("<a href='"+imageHref+"' "+imageTarget+"></a>");
                        contentWrapped.append(imageObject);
                        contentWrapped.append(ratingCommentDiv);
                        cgShowObject.append(contentWrapped);

                    }else{
                        cgShowObject.append(imageObject).append(ratingCommentDiv);
                        cgShowObject.append(cgShowPositionHelper);
                    }


                    /*                        var imageObject = cgShowObject.append("<div class='cg_append' id='cg_append"+realId+"' " +
                                            "style='width:"+WidthThumb+"px;height:"+HeightThumb+"px;'>"+
                                            "<a "+cg_a_href_img+" "+cg_href_img_blank+" "+cg_a_href_title+" >"+
                                            "<img src='"+imgSrc+"' data-order='"+r+"' style='position:absolute;"+padding+";max-width:none;"+circleImagesOverflow+";' " +
                                            "width='"+WidthThumbPic+"px' height='"+HeightThumbImageValue+"' "+cg_id_class_img+" >"+
                                            "</a>" +
                                            "</div>"+ratingCommentDiv+"");*/


                    if(sliderView==true){
                        if(i < maximumVisibleImagesInSlider){
                            $mainCGslider.append(cgShowObject);
                        }
                    }else{
                        if(calledFromUpload===true){
                            $mainCGallery.append(cgShowObject);
                        }else{
                            $mainCGallery.append(cgShowObject);
                        }
                    }


                    cgShowObject.addClass('cg_fade_in');
                    cgJsData[gid].imageObject[realId] = cgShowObject;
                    cgJsData[gid].image[index][firstKey]['imageObject'] = cgJsData[gid].imageObject[realId];

                    if(typeof cgJsData[gid].rating[realId] == 'undefined'){
                        cgJsClass.gallery.dynamicOptions.getRatingAndComments(realId,arrIndex,objectKey,gid,openPage);
                    }else{
                        cgJsClass.gallery.dynamicOptions.setRatingAndComments(realId,arrIndex,objectKey,gid);
                    }

                    if(typeof cgJsData[gid].vars.info[realId] == 'undefined'){
                        cgJsClass.gallery.info.getInfo(realId,gid,false,arrIndex,openPage,sliderView);
                    }else{
                        cgJsClass.gallery.info.setInfo(realId,gid,false,arrIndex,cgJsData[gid].vars.info[realId]);
                    }


                    if(imgSrc==imgSrcOriginal || imgDataWidth<WidthThumbPic){
                        if(typeof cgJsData[gid].vars.rawData['imgSrcOriginalWidth'] == 'undefined'){
                            var img = new Image();
                            img.src = imgSrc;
                            img.onload = function() {
                                cgJsData[gid].vars.rawData[realId]['imgSrcOriginalWidth'] = this.width;
                                cgJsData[gid].vars.rawData[realId]['imgSrcOriginalHeight'] = this.height;
                                var differenceCheck = WidthThumbPic-this.width;// WidthThumbPic kann man nehmen weil diese sich nicht ändert
                                if(differenceCheck>20){// then stretch will be visible better show real size then
                                    // man muss cgJsData[gid].image[index][firstKey]['imageObject'] statt imageObject weil sich imageObject sich zur Laufzeit ändert
                                    cgJsData[gid].imageObject[realId].find('.cg_append').addClass('cg_background_size_unset');
                                }
                            };
                        }
                    }


                }
                else{

                    // thumb wird nicht verwendet, da thumb quadratisches abgeschnittenes bild ist und somot nicht passen könnte

                    if(WidthThumbPic<=imgSrcMediumWidth){
                        imgSrc = imgSrcMedium;
                    }
                    else if(WidthThumbPic<=imgSrcLargeWidth){
                        imgSrc = imgSrcLarge;
                    }
                    else{
                        imgSrc = imgSrcOriginal;
                    }

                    /*                        var imageObjectUnvisible = false;
                                            if(typeof cgJsData[gid].imageObject[realId] != "undefined"){
                                                if(cgJsData[gid].imageObject[realId].is(':visible') == false){
                                                    imageObjectUnvisible = true;
                                                }
                                            }*/

                    if(cgJsClass.gallery.vars.hasToAppend==true || calledFromUpload===true){

                        if(sliderView==true){

                            cgShowObject.appendTo($mainCGslider);

                        }else{

                            cgShowObject.appendTo($mainCGallery);

                        }

                        cgShowObject.removeClass('hide');
                    }


                    if(cgJsData[gid].image[index][objectKey].rThumb=='270' || cgJsData[gid].image[index][objectKey].rThumb=='90'){
                        cgShowObject.find('.cg_append').css({
                            "border": "rgba"+rgba+" solid "+border+"px",
                            "background":'url("'+imgSrcLarge+'") no-repeat center center',// always image large to go sure when rotated!!! Otherwsise could be looking washed because low resolution.
                            'width': 100+'%',
                            // 'width': HeightThumb+'px',
                            //  'height': WidthThumb+3+'px',
                            'height': 150+'%'
                        });
                    }else{
                        cgShowObject.find('.cg_append').css({
                            "border": "rgba"+rgba+" solid "+border+"px",
                            "background":'url("'+imgSrc+'") no-repeat center center',
                            'width': 100+'%',
                            'height': 100+'%'
                            //'width': WidthThumb+'px',
                            //   'height': HeightThumb+'px'
                        });
                    }


                    cgShowObject.css({
                        'width': ''+WidthThumb+'px',
                        'height': ''+HeightThumb+'px',
                        'border': 'none'
                    });

                    cgShowObject.attr({
                        'data-cg-order': index
                    });


                }


            }

            i++;

        });


        if(sliderView==true){

            var $cgSliderRangeContainer = $( "<div id='cgSliderRangeContainer"+gid+"' class='cg-slider-range-container'><div id='cgSliderRange"+gid+"' class='cg-slider-range'></div></div>");
            var $cgSliderRange = $cgSliderRangeContainer.find('.cg-slider-range');

            var countImages = Object.keys(cgJsData[gid].image).length;

            cgJsData[gid].vars.cgSliderRange = $cgSliderRange;
            if(countImages>=maximumVisibleImagesInSlider){
                var widthSliderHandlePercentage = maximumVisibleImagesInSlider*100/countImages;
            }else{
                widthSliderHandlePercentage = 100;
            }

            if(widthSliderHandlePercentage!=100){
                var widthSliderHandle = Math.floor(widthMainCGallery/100*widthSliderHandlePercentage);
            }else{
                widthSliderHandle=0;
            }

            if(widthSliderHandle<13 && widthSliderHandlePercentage!=100){
                widthSliderHandle = 13;
            }

            $cgSliderRangeContainer.css({
                'width': widthMainCGallery+'px',
            });

            $cgSliderRangeContainer.insertAfter($mainCGslider);

            $cgSliderRange.slider({
                value: 0,
                step: 1,
                max: Object.keys(cgJsData[gid].image).length-1,
                stop: function( event, ui ) {
                    /*                  $(ui.handle).removeClass('ui-state-focus');
                                        $(ui.handle).removeClass('ui-corner-all');
                                        $(ui.handle).removeClass('ui-state-hover');
                                        $(ui.handle).removeClass('ui-state-default');*/
                },
                start: function( event, ui ) {
                    /*                    $(ui.handle).removeClass('ui-state-focus');
                                        $(ui.handle).removeClass('ui-corner-all');
                                        $(ui.handle).removeClass('ui-state-hover');
                                        $(ui.handle).removeClass('ui-state-default');*/
                },
                slide: function( event, ui ) {
                    cgJsClass.gallery.views.functions.appendAndRemoveImagesInSlider(gid,ui.value,maximumVisibleImagesInSlider,$mainCGslider,true);
                }
            });

            var marginLeftHandle = widthSliderHandle/2;
            var cgSliderRangeWidth = widthMainCGallery-widthSliderHandle;

            $cgSliderRange.css('width',cgSliderRangeWidth+'px');
            $cgSliderRange.find('.ui-slider-handle').css({
                'width':widthSliderHandle+'px',
                'margin-left':'-'+marginLeftHandle+'px'
            });

            if(cgJsData[gid].vars.openedRealId){// openPage or FullWindow for example, load the images that it can be clicked later
                var order = cgJsClass.gallery.function.general.tools.getOrderByGidAndRealId(gid,cgJsData[gid].vars.openedRealId);
                cgJsClass.gallery.views.functions.appendAndRemoveImagesInSlider(gid,order,maximumVisibleImagesInSlider,$mainCGslider);
            }

        }


        cgJsClass.gallery.vars.switchViewsClicked=false;

        $(".checkFirstTimeWholeWidth").val(0);
        $(".aggregateWidth").val(0);

        var adjustThumbViewWidth = function () {

            // Anpassung Breite hier!!!!!

            var firstRealId = null;
            var realIdBefore = 0;
            var aggregateWidthSet = false;
            var realId = 0;
            var newXmulti = 1;
            var realIdOffset = 0;

            $.each(cgJsData[gid].image, function( index,value ) {

                var firstKey = Object.keys(value)[0];
                realId = cgJsData[gid].image[index][firstKey]['id'];

                if(!firstRealId){
                    firstRealId=realId;
                }

                // Exception. Sonderanpassung breite divs damit gallery container gleich breit ist wie single vie container
                if(aggregateWidthSet==false){
                    if(typeof offset1Top == 'undefined'){
                        var offset1Left = $mainCGallery.find('#cg_show'+firstRealId).offset().left;
                        var offset1Top = $mainCGallery.find('#cg_show'+firstRealId).offset().top;
                    }

                    var offsetToCompareTop = $mainCGallery.find('#cg_show'+realId).offset().top;
                    if(offset1Top<offsetToCompareTop){

                        var positionToCompareLeftRealIdBefore = $mainCGallery.find('#cg_show'+realIdBefore).position().left;// position function == position offset of parent element
                        if(index<=1){// Dann wurde nur ein Bild durchgegangen, das nächste liegt schon drunter
                            cgJsData[gid].vars.thumbViewWidth = $mainCGallery.find('#cg_show'+firstRealId).outerWidth();
                        }else{
                            // Achtung! In dieser Phase ist WidthThumb der durcschnitt zusammen mit border und distancePicsX!!!!
                            // border/2 wegen cg_append border und border gilt immer für rechts und links bei thumb view

                            if(border){
                                var restWidth = Math.floor(widthmain-(positionToCompareLeftRealIdBefore+$mainCGallery.find('#cg_show'+realIdBefore).outerWidth()+DistancePicsX*2));
                                newXmulti = restWidth/(index+1);
                            }else if(DistancePicsX){
                                var restWidth = Math.floor(widthmain-(positionToCompareLeftRealIdBefore+$mainCGallery.find('#cg_show'+realIdBefore).outerWidth()+DistancePicsX*2));
                                newXmulti = restWidth/(index+1);
                            }
                            else{
                                var restWidth = widthmain-(positionToCompareLeftRealIdBefore+$mainCGallery.find('#cg_show'+realIdBefore).width());
                                newXmulti = restWidth/(index+1);
                            }

                            realIdOffset = realIdBefore;

                            cgJsData[gid].vars.thumbViewWidth = positionToCompareLeftRealIdBefore+$mainCGallery.find('#cg_show'+realIdBefore).outerWidth()+DistancePicsX*2+border*2;
                        }

                        //    $('#mainCGdiv'+gid).css('width',cgJsData[gid].vars.thumbViewWidth+'px');
                        aggregateWidthSet = true;
                        return false;

                    }

                    realIdBefore = realId;

                }

            });

            var newThumbWidth = newXmulti+WidthThumb;
            $mainCGallery.find('.cg_show').css('width',newThumbWidth+'px');
            if(realIdOffset){
                cgJsData[gid].vars.thumbViewWidthFromLastImageInRow = $mainCGallery.find('#cg_show'+realIdOffset).position().left+$mainCGallery.find('#cg_show'+realIdOffset).outerWidth()+DistancePicsX;
            }else{
                cgJsData[gid].vars.thumbViewWidthFromLastImageInRow = $mainCGallery.find('#cg_show'+firstRealId).position().left+$mainCGallery.find('#cg_show'+firstRealId).outerWidth();
            }

            if(aggregateWidthSet==false){
                cgJsData[gid].vars.thumbViewWidthFromLastImageInRow = false;
                // last realId of each loop before
                var positionLeft = cgJsData[gid].imageObject[realId].position().left;// position function == position offset of parent element
                var processedWidth = positionLeft+cgJsData[gid].imageObject[realId].outerWidth()+DistancePicsX;
                var compareWidth = $mainCGdiv.width()-processedWidth;
                // Dann kann man davon ausgehen, dass nur noch ganz wenig Breite rechts fehlt
                if(compareWidth<100){
                    cgJsData[gid].vars.thumbViewWidth = processedWidth+DistancePicsX;
                    //  $('#mainCGdiv'+gid).css('width',cgJsData[gid].vars.thumbViewWidth+'px');
                }else{
                    cgJsData[gid].vars.thumbViewWidth = $mainCGdiv.width();
                }
            }

            // Anpassung Breite hier!!!!! --- ENDE




        };

        if(!sliderView){
            if(openPage){

                setTimeout(function(){
                    // have to be done always with latency otherwise functionality might break, because of later appearence of images
                    adjustThumbViewWidth();

                },101);

            }else{
                // have to be done always with latency otherwise functionality might break, because of later appearence of images
                setTimeout(function(){

                    adjustThumbViewWidth();

                },101);
            }

        }


        if(sliderView==true){

            $mainCGslider.removeClass('cg_hide');
            $mainCGdiv.find('#cgSliderRangeContainer'+gid).removeClass('cg_hide');
            $mainCGdiv.find('.cg_gallery_thumbs_control .cg_view_switcher').addClass('cg_disabled');

        }


        if((openPage==true || viewChange==true) && cgJsClass.gallery.vars.fullwindow==false){

            //   if(appendNew){
            setTimeout(function () {
                $mainCGallery.css('visibility','visible').addClass('cg_fade_in_new cg_animation').removeClass('cg_hidden');
            },100);
            // }

        }else{

        }
        if(sliderView==false){
            setTimeout(function () {
                $mainCGallery.css('visibility','visible').addClass('cg_fade_in cg_animation').removeClass('cg_hidden');
            },1);
        }

        if(sliderView==false){
            // before returns kommen muss es ausgeführt werden!
            $mainCGdiv.find('.cg-lds-dual-ring-div-gallery-hide-mainCGallery').addClass('cg_hide');
            $mainCGallery.removeClass('cg_hide').addClass('cg_fade_in');
        }

        cgJsData[gid].vars.cgCenterDivAppearenceHelper.addClass('cg_hide');// has to be removed in all cases

        if(cgJsData[gid].options.general.FullSizeImageOutGallery==1 && !sliderView){
            return;
        }

        if(cgJsData[gid].options.general.OnlyGalleryView==1 && !sliderView){
            return;
        }

        if(sliderView==true && openPage!=true){

            if(cgJsData[gid].vars.openedRealId >= 1 && randomButtonClicked!=true){
                setTimeout(function () {

                    $mainCGdiv.find('.cg-lds-dual-ring-div-gallery-hide-mainCGallery').addClass('cg_hide');
                    $mainCGallery.css('visibility','visible').removeClass('cg_hidden');
                    $mainCGallery.removeClass('cg_hide').addClass('cg_fade_in');
                    if(!isCopyUploadToAnotherGallery){
                        $mainCGslider.find('#cg_append'+cgJsData[gid].vars.openedRealId).addClass('cg_open_gallery_slider_look').click();
                    }

                },200);
            }else{

                $mainCGdiv.find('.cg-lds-dual-ring-div-gallery-hide-mainCGallery').addClass('cg_hide');
                $mainCGallery.removeClass('cg_hide').addClass('cg_fade_in');

                if(!isCopyUploadToAnotherGallery){
                    $mainCGslider.find('.cg_show:first-child .cg_append').addClass('cg_open_gallery_slider_look').click();
                }


            }

            return;

        }
        else if(sliderView==true && openPage==true){

            if(openPage==true){
                setTimeout(function () {

                    $mainCGdiv.find('.cg-lds-dual-ring-div-gallery-hide-mainCGallery').addClass('cg_hide');

                    if(sliderView && calledFromUpload){
                        // do not remove cg_hide
                        $mainCGallery.addClass('cg_hide cg_called_from_upload');
                    }else{
                        $mainCGallery.removeClass('cg_hide').addClass('cg_fade_in');
                    }

                    var $imageToClick;

                    if(cgJsData[gid].vars.openedRealId < 1){
                        $imageToClick = $mainCGslider.find('.cg_show:first-child .cg_append').addClass('cg_open_gallery_slider_look');
                    }
                    if(cgJsData[gid].vars.openedRealId >= 1){
                        $imageToClick = $mainCGslider.find('#cg_append'+cgJsData[gid].vars.openedRealId).addClass('cg_open_gallery');
                    }

                    if(!cgJsData[gid].vars.isRemoveImageSliderViewCheck){
                        if(!isCopyUploadToAnotherGallery){
                            $imageToClick.click();
                        }
                    }else{

                        if(!isCopyUploadToAnotherGallery){
                            // have to be done two times image image was deleted
                            $imageToClick.click();
                            $imageToClick.click();
                        }

                        cgJsData[gid].vars.isRemoveImageSliderViewCheck = false;

                        if(Object.keys(cgJsData[gid].vars.rawData).length>=1){
                            jQuery($mainCGslider).removeClass('cg_hide');
                        }

                    }


                },500);
            }else{

                $mainCGdiv.find('.cg-lds-dual-ring-div-gallery-hide-mainCGallery').addClass('cg_hide');
                $mainCGallery.removeClass('cg_hide').addClass('cg_fade_in');

                if(!isCopyUploadToAnotherGallery){
                    $mainCGslider.find('.cg_show:first-child .cg_append').click();
                }


            }
            return;

        }

        //    cgJsClass.gallery.resize.resizeInfo(gid,openPage);

        if((openPage==true || viewChange==true) && sliderView==false){
            //   if(appendNew){
            setTimeout(function () {

                $mainCGallery.css('visibility','visible').removeClass('cg_hidden');

                if(!isCopyUploadToAnotherGallery){

                    if(cgJsData[gid].vars.openedRealId >= 1){
                        setTimeout(function () {
                            if(openPage==true){
                                $mainCGallery.find('#cg_append'+cgJsData[gid].vars.openedRealId).addClass('cg_open_gallery').click();
                            }else{
                                $mainCGallery.find('#cg_append'+cgJsData[gid].vars.openedRealId).click();
                            }
                        },600);// because of fade in
                    }

                }

            },100);

            // }
        }else{

            $mainCGallery.removeClass('cg_fade_in');// remove class for smooth behaviour when single image view it might be set again
            setTimeout(function () {

                $mainCGallery.css('visibility','visible').removeClass('cg_hidden');

                if(cgJsData[gid].vars.openedRealId >= 1 && cgJsData[gid].options.pro.SliderFullWindow!=1){
                    $mainCGallery.addClass('cg_fade_in');

                    setTimeout(function () {

                        if(!isCopyUploadToAnotherGallery){
                            $mainCGallery.find('#cg_append'+cgJsData[gid].vars.openedRealId).click();
                        }

                        cgJsData[gid].vars.mainCGdiv.find('.cg_header').removeClass('cg_pointer_events_none');
                        cgJsData[gid].vars.mainCGdiv.find('.cg_further_images_container').removeClass('cg_pointer_events_none');
                    },600);// because of fade in
                }

            },100);

        }




    }
};
