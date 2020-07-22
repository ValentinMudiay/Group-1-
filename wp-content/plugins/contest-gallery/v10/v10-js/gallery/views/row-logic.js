cgJsClass.gallery.rowLogic = {
    init: function (jQuery,gid,openPage,calledFromUpload,openImage,stepChange,viewChange,randomButtonClicked,isCopyUploadToAnotherGallery) {
        // gallery index
        var gid = gid;

        //!IMPORTANT current view look for resize
        cgJsData[gid].vars.currentLook='row';

        if(cgJsData[gid].image.length<1){
            return;
        }

        var $ = jQuery;

        var cg_gallery_resize = $('#cg_gallery_resize').val();

        // Wenn alle Bilder geladen wurden, sollten hinsichtlich pagination nichts mehr passieren
        var cg_all_images_loaded = $('#cg_all_images_loaded').val();

        // Array für neue Höhen
        var newHeight1 = [];

        var newHeight2 = 0;

        // Beginn des Nenners
        var ratio = 0;

        // Array für mehrere Nenner (Gesamtzähler)
        var denominator1 = [];
        // a bestimmt mehrere Nenner
        var a = 0;

        // Gesamter Zähler
        var newNumerator = 0;

        // Beginn des Zählers im Bruch
        var numerator = 0;

        // width/height
        var divArray = [];

        // Neue Höhe
        var newHeight = 0;

        var partNumerator = 0;

        // Anzahl der hochgeladenen Bilder
        //  var n = $( ".cg_show" ).length;
        var n = Object.keys(cgJsData[gid].image).length;

        var cg_InfiniteScrollGallery = cgJsData[gid].options.general.InfiniteScroll;

     //   cgJsData[gid].vars.cgCenterDivAppearenceHelper.removeClass('cg_hide');


        // Wie viele Bilder sollen in einer Reihe dargestellt werden. Einstellung erfolgt durch User in Options
        var picsInRow = parseInt(cgJsData[gid].options.general.PicsInRow);

        var opacity = parseFloat(cgJsData[gid].options.visual.RowViewBorderOpacity);

        var borderColor = cgJsData[gid].options.visual.RowViewBorderColor;

        var border = parseInt(cgJsData[gid].options.visual.RowViewBorderWidth);
        var border = 0;

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

        var cg_horizontalSpace = parseInt(cgJsData[gid].options.visual.RowViewSpaceWidth);
        var cg_verticalSpace = parseInt(cgJsData[gid].options.visual.RowViewSpaceHeight);
     //   var cg_horizontalSpace = 0;
      //  var cg_verticalSpace = 0;

        // extra korrektur sonst fehler bei ansicht
        if(border>0){
            if(cg_horizontalSpace==0){
                cg_horizontalSpace = 1;
            }
            if(cg_verticalSpace==0){
                cg_verticalSpace = 1;
            }
        }

        if(cgJsClass.gallery.vars.fullwindow==gid){
            // -40 wegen padding 20 rechts links und 15 wege scroll bar die beim parent hinzugefügt wird
            //var widthMainCGallery = $(window).width()-55;
            var widthMainCGallery = $(window).width()-cgJsClass.gallery.function.general.tools.getScrollbarWidthDependsOnBrowser();
        }else{
            var widthMainCGallery = $('#mainCGdivContainer'+gid).width();
        }

        if(widthMainCGallery<247){
            widthMainCGallery = 247;
        }

        var widthmain = widthMainCGallery;



        cgJsClass.gallery.views.functions.destroyRangeSlider(gid);

        // Wenn pagination an ist, dann muss der erste Width Wert hier eingetragen werden

        // resize old
        /*        if(cg_gallery_resize==0 && check_cg_widthMainCGallery!=0){widthmain=$("#cg_widthMainCGallery").val(); }

                else{widthmain=widthmain;}*/


        //Width welches aktuell durchlaufen wurde, wird eingetragen
        // $("#cg_widthMainCGallery").val(widthmain);

        //var widthmainDiv = widthmain-5;

        //Hauptwidth der cg_gallery wird als css eingetragen

        var $mainCGallery = $('#mainCGallery'+gid);
        var $mainCGslider = $('#mainCGslider'+gid);
        var $mainCGdiv = $('#mainCGdiv'+gid);



        $mainCGdiv.css('width',widthmain+'px');
        $mainCGallery.css('width',100+'%');
        $mainCGallery.css('visibility','hidden');
        $mainCGallery.removeClass('cg_fade_in_new');

        cgJsData[gid].vars.cgCenterDiv.css('width',widthmain+'px');

        cgJsData[gid].vars.widthmain = widthmain;

        var appendNew = cgJsClass.gallery.views.functions.checkAndAppendFromSliderToGallery($mainCGallery,$mainCGslider);

        if(openPage==true || viewChange==true){
            $mainCGallery.removeClass('cg_fade_in_new').addClass('cg_hidden');
        }

        // manchmal wird width nicht gesetzt, deswegen sicherheithalber nochmal setzen
        if(openPage === true){
            if($mainCGdiv.css('width')!=true){
                $mainCGallery.css('visibility','hidden');
                setTimeout(function () {
                    $mainCGdiv.css('width',cgJsData[gid].vars.widthmain+'px');
                    setTimeout(function () {
                        //          $mainCGallery.css('visibility','visible').addClass('cg_fade_in_new');
                    },100);
                },100);
            }
        }else{

            $mainCGallery.addClass('cg_hidden');
            $mainCGallery.removeClass('cg_fade_in');
            $mainCGallery.css('visibility','visible');
        }

        // $('#cgGalleryViewSortControl'+gid).width(widthmain);

        // Der erste horizontalSpace (von links kommend) darf nicht vorkommen, der letzte soll abgezogen werden!
        // Wenn nicht null dann muss immer von beiden seiten border hinzugefügt werden




        if(parseInt(cgJsData[gid].options.visual.RowViewBorderRadius)>5){var cg_CircleImages=1;}
        else{var cg_CircleImages=0;}



        if(cg_horizontalSpace!=0 || cg_CircleImages==1){
            widthmain = widthmain-(border*2+cg_horizontalSpace)* picsInRow+cg_horizontalSpace;
        }
        // Wenn null dann muss border immer nur von einer Seite hinzugefügt werden
        else{
            widthmain = widthmain-(border+cg_horizontalSpace)* picsInRow+cg_horizontalSpace-border;
        }


//	alert(widthmain);


        // Gesamtbreite wird neu berechnet, da Anzahl der Bilder (.cg_image) kleiner ist als eingestellte Anzahl der Bilder in einer Reihe in Options
        if(n < picsInRow){

            widthmain = widthmain/picsInRow*n;
            picsInRow = n;

            //alert("Widthmain"+widthmain);

        }


        // alert("Widthmain: "+widthmain);


        var widthLastRow = widthmain/picsInRow*(n-Math.floor(n/picsInRow)*picsInRow);


        //var lastRow = $("#cg_last_row").val();


        //  alert(picsInRow);   alert(picsPerSite); alert(lastRow);


        var width2 = 0;

        var lastRowLeft = n-(n-Math.floor(n/picsInRow)*picsInRow);

        var picsInLastRow = n-lastRowLeft;

        //alert(picsInLastRow);

        var lastImages = 1;

        // Orientierungsvariable bei Durcharbeiten des großen Arrays
        var r = 0;

        var classCounter = 0;

     //   console.log('image')
        //console.log(cgJsData[gid].image)
     //   console.trace()

       cgJsClass.gallery.resize.galleryIcons($mainCGallery,openPage,false,gid,widthmain);

        $.each(cgJsData[gid].image, function( index,value ) {

            var arrIndex = index;

            var firstKey = Object.keys(value)[0];

            //  var objectKey = Object.keys(firstKey)[0];
            var objectKey = firstKey;
            // var objectKey = value[firstKey]['rowid'];


            var categoryId = cgJsData[gid].image[index][firstKey]['Category'];

            if(typeof cgJsData[gid].vars.categories[categoryId] != 'undefined'){


                if(cgJsData[gid].vars.showCategories == true && cgJsData[gid].vars.categories[categoryId]['Checked']==false){

                    //cgJsData[gid].image[index][firstKey]['imageObject'].remove();

                    return;

                }

            }


            classCounter++;

            r++;


            var width = parseInt(cgJsData[gid].image[index][objectKey].Width);
            var height = parseInt(cgJsData[gid].image[index][objectKey].Height);

/*            var cgRotationThumbNumber = parseInt(cgJsData[gid].image[index][objectKey].rThumb);


            if(cgRotationThumbNumber=='90' || cgRotationThumbNumber=='270'){

                var cgRotateRatio = width/height;
                var cgWidthOriginalImgContainer = width;
                width = height;
                width = width*cgRotateRatio;
                height = cgWidthOriginalImgContainer;

            }*/

            var div = width / height;

            ratio  = ratio + div;


            if (r % picsInRow == 0) {

                denominator1.push(ratio);

                newHeight = Math.floor(widthmain/ratio);

                newHeight1.push(newHeight);

                newHeight2 = newHeight;

                a++;

                newNumerator = 0;

                newHeight = 0;

                ratio = 0;

                divArray.length = 0;

                partNumerator = 0;


            }


            // Sobald es beendet ist, wird die letzte Zeile berechnet. Breite wird neu berechnet, entsprechend Anzahl der Bilder.
            if (n/r == 1) {



                denominator1.push(ratio);

                //Neue Breite wird berechnet
                var newWidthmain = widthmain/picsInRow*picsInLastRow;

                newHeight = Math.floor(newWidthmain/ratio);

                newHeight1.push(newHeight);

                newHeight2 = newHeight;

            }

        });


        // Gibt an in welcher Zeile man sich befindet (Bezoggen auf den vorher ermittelten Array, bestimmte Anzahl an Bildern haben die gleiche Größe)
        var h = 0;

        var cg_pagination_position_count = parseInt($('#cg_pagination_position_count').val());
        if(cg_pagination_position_count==0){var h = 0; }
        else{
            if(cg_gallery_resize==1){

                var h = 0;

            }
            else{

                var h = (cg_pagination_position_count+1)/picsInRow;
            }

            var firstRow = cg_pagination_position_count;

            //Für Border
            var onlyFirstTime = cg_pagination_position_count;

        }

        var g = 0;

        var r = 0;

        // Horizontal Space hier nicht hinzufügen da von links kommend nur Border zählt
        var aggregateWidth=border;


        var rowsDone = 0;

// Wichtig für Lazy Load. Border oben soll nur beim ersten Mal geladen werden.
        var onlyFirstTime = 0;

        // Wird für Lazy Load verwendet. +1 wird erst am ende hinzuaddiert
        var count=0;

        // Zur Ermittlung des Abstandes zum Rand des HTMLs für Pagination
        var cg_imgOffsetHTML = 0;

        // Sobald cg_pagination 1 erreicht hat, dann loading gif anzeigen und nicht mehr laden, bis weiter gescrollt wird
        var cg_pagination = 0;


        $.each(cgJsData[gid].image, function( index,value ) {

            var arrIndex = index;

            var firstKey = Object.keys(value)[0];

            //  var objectKey = Object.keys(firstKey)[0];
            var objectKey = firstKey;
            // var objectKey = value[firstKey]['rowid'];



            var categoryId = cgJsData[gid].image[index][firstKey]['Category'];

            if(typeof cgJsData[gid].vars.categories[categoryId] != 'undefined'){


                if(cgJsData[gid].vars.showCategories == true && cgJsData[gid].vars.categories[categoryId]['Checked']==false){

                    //cgJsData[gid].image[index][firstKey]['imageObject'].remove();

                    return;

                }

            }





            r++;

            g++;

            var setNewHeight = newHeight1[h];

            var widthOriginalImg = parseInt(cgJsData[gid].image[index][objectKey].Width);
            var heightOriginalImg = parseInt(cgJsData[gid].image[index][objectKey].Height);


            var realId = cgJsData[gid].image[index][firstKey]['id'];

            // thumb wird nicht verwendet, da thumb quadratisches abgeschnittenes bild ist und somot nicht passen könnte
            var imgSrcMedium = cgJsClass.gallery.function.general.tools.checkSsl(cgJsData[gid].vars.rawData[realId].medium);
            // thumbnail_size_w, medium_size_w and large_size_w calculation will be done in init-gallery-getjson imageDataPreProcess with calculateSizeImageDataPreProcess function
            var imgSrcMediumWidth = parseInt(cgJsData[gid].vars.rawData[realId].medium_size_w);
            var imgSrcLarge = cgJsClass.gallery.function.general.tools.checkSsl(cgJsData[gid].vars.rawData[realId].large);
            // thumbnail_size_w, medium_size_w and large_size_w calculation will be done in init-gallery-getjson imageDataPreProcess with calculateSizeImageDataPreProcess function
            var imgSrcLargeWidth = parseInt(cgJsData[gid].vars.rawData[realId].large_size_w);
            var imgSrcOriginal = cgJsClass.gallery.function.general.tools.checkSsl(cgJsData[gid].vars.rawData[realId].full);

            var imgSrc = imgSrcLarge;


            if(cg_CircleImages==1){$(this).css({"border-radius": ""+cgJsClass.gallery.options.visual.RowViewBorderRadius+"%"}); var circleImagesOverflow = "overflow:hidden";}

            var cg_Use_as_URL = cgJsData[gid].vars.formHasUrlField;
            var cg_ForwardToURL = cgJsData[gid].options.general.ForwardToURL;
            var cg_ForwardFrom = cgJsData[gid].options.general.ForwardFrom;
            var cg_FullSizeImageOutGallery = cgJsData[gid].options.general.FullSizeImageOutGallery;

            //Achtung entspricht nicht der Anzahl der tatsächlich geladenen Bilder. Fängt mit 0 an. Wird auch für das gesammelte Height und Width Array verwendet.
            // Hier muss es nochmal sein, so wie es oben sein muss
            var cg_pagination_position_count = $('#cg_pagination_position_count').val();


            // Wenn resize gemacht wurde gerade und logic läuft, dann sollen ALLE nochmal abgearbeitet werden
            if(count<=cg_pagination_position_count && cgJsData[gid].options.general.InfiniteScroll==1 && cg_pagination_position_count!=0 && cg_gallery_resize!=1){
                //var cg_do_nothing = 1;
            }
            else{

                var realId = cgJsData[gid].image[index][firstKey]['id'];


                var imgDataWidth = parseInt(cgJsData[gid].vars.rawData[realId].Width);


                //   if(typeof cgJsData[gid].image[index][firstKey]['imageObject'] === "undefined" || cgJsData[gid].image[index][firstKey]['imageObject'] == null) {
                if(typeof cgJsData[gid].imageObject[realId]  === "undefined") {


                    var imageTarget = '';
                    var imageHref = '';
                    if(cgJsData[gid].options.general.FullSizeImageOutGallery==1){
                        imageTarget = 'target="_blank"';
                        imageHref = imgSrcOriginal;
                    }



                    var cgShowObject = $("<div data-cg-cat-id='"+categoryId+"' data-cg-id='"+realId+"'  data-cg-order='"+index+"' data-cg-gid='"+gid+"' class='cg_show cg-cat-"+categoryId+"' id='cg_show"+realId+"'>");

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

                // Die Verteilung der Borders hat zuerst zu kommen --- ENDE

                var newWidthDiv = Math.ceil(widthOriginalImg*newHeight1[h]/heightOriginalImg);

                aggregateWidth = aggregateWidth+newWidthDiv;
                if (g % picsInRow == 0) {

                    //	  alert("aggregateWidth:" +aggregateWidth);

                    if(onlyFirstTime==0){
                        var newWidthDiv = newWidthDiv+(widthmain-aggregateWidth)+border;
                    }
                    else{var newWidthDiv = newWidthDiv+(widthmain-aggregateWidth);}

                    var setNewHeight = newWidthDiv*heightOriginalImg/widthOriginalImg;

                    aggregateWidth=0;

                    onlyFirstTime++;

                }

                // pauschal border none und margin unset
                // sonst falsche anzeige falls eine view davor margin und border hatte und diese nicht
                cgShowObject.css({
                    'border':'none',
                    'margin':'unset',
                    'height': newHeight1[h],
                    'width': newWidthDiv,
                    'float':'left'
                });

                // Verteilung Border und Margin rechts und links

                if(r == 1){
                    cgShowObject.css({"border-left": "rgba"+rgba+"  solid "+border+"px"});
                }

                // Jedes mal wenn eine Reihe abgearbeitet wurde, gleich beim ersten Bild border-left wieder setzten!!!
                // wenn letztes Bild vorher war, dann margin nicht setzten
                if ((r-1) % picsInRow == 0){
                    if(border>0){
                        cgShowObject.css({"border-left": "rgba"+rgba+"  solid "+border+"px"});
                    }
                    // wichtig!!! pauschal auf 0 setzen!!!
                    cgShowObject.css({"margin-left": 0});
                }
                else{
                    if(cg_horizontalSpace>0){
                        cgShowObject.css({"margin-left": ""+cg_horizontalSpace+"px"});
                    }
                    if(border>0){
                        cgShowObject.css({"border-left": "rgba"+rgba+"  solid "+border+"px"});
                    }
                }

                //Border rechts muss immer sein!
                $(cgShowObject).css({"border-right": "rgba"+rgba+"  solid "+border+"px"});

                // Verteilung Border und Margin rechts und links --- ENDE!

                // Verteilung Border und Margin oben und unten

                // ACHTUNG!!!!! Wenn horizontaler Abstand gesetzt und verticaler nicht gesetzt ist, dann werdden die oberen und unteren Borders
                //trotzdem so gesetzt als ob verticaler Abstand eingestellt ist, damit es nicht fehlerhaft aussieht.

                if(rowsDone==0){

                    //Falls verticalSpace NULL und Pagination aktiviert ist, dann border-top nur dann setzten wenn cg_pagination_position_count NULL ist!!!!
                    if(cg_pagination_position_count==0 && cg_verticalSpace==0 ){
                        cgShowObject.css({"border-top": "rgba"+rgba+"  solid "+border+"px"});
                        //alert(1);
                    }
                    else{
                        // Vertical Space nicht null ist, oder Circle border aktiviert ist, dann kann immer gesetzt werden!
                        if(cg_verticalSpace!=0 || (cg_verticalSpace==0 && cg_horizontalSpace!=0 ) || cg_CircleImages==1){
                            cgShowObject.css({"border-top": "rgba"+rgba+"  solid "+border+"px"});
                        }
                        else{
                            // Ansonsten nur beim ersten durchlauf!
                            if(rowsDone==0 && cg_InfiniteScrollGallery!=1){
                                cgShowObject.css({"border-top": "rgba"+rgba+"  solid "+border+"px"});
                            }
                        }
                        //alert(2);
                    }

                    cgShowObject.css({"border-bottom": "rgba"+rgba+"  solid "+border+"px"});
                    if(cg_verticalSpace!=0 || (cg_verticalSpace==0 && cg_horizontalSpace!=0 )){
                        cgShowObject.css({"margin-bottom": ""+cg_verticalSpace+"px"});
                    }
                }
                else{
                    if(cg_verticalSpace!=0 || (cg_verticalSpace==0 && cg_horizontalSpace!=0) || cg_CircleImages==1){

                        cgShowObject.css({"margin-bottom": ""+cg_verticalSpace+"px"});
                        cgShowObject.css({"border-top": "rgba"+rgba+"  solid "+border+"px"});
                        cgShowObject.css({"border-bottom": "rgba"+rgba+"  solid "+border+"px"});
                    }
                    else{
                        cgShowObject.css({"border-bottom": "rgba"+rgba+"  solid "+border+"px"});
                    }
                }


                // Verteilung Border und Margin oben und unten --- ENDE


                // Höhe von input Field ausgleichen wenn es zu lang ist --- ACHTUNG ANDERE LOGIK BEI ROW VIEW

                //var heightAppend = $(this).find("div#cg_hide").height(); <<< funktioniert bei Row View nicht


//alert(heightAppend);

                //var divHthumbHappend = newHeight1[h]-56; // height von cg_height

//alert(divHthumbHappend);

                //$(this).find("[id*=cg_Field1IdGalleryView]").css('max-height',divHthumbHappend);
                // $(this).find("[id*=cg_Field1IdGalleryView]").css('overflow','hidden');

                // Setzten in die Mitte falls Circle aktiviert ist
                //var testHeightLala = $(this).find("[id*=cg_hide]").height();
                //alert(testHeightLala);
                if(cg_CircleImages==1){
                    //  $(this).find("[id*=cg_hide]").css('margin-bottom',newHeight1[h]/2-45.75/2);
                    //$(this).find("[id*=cg_hide]").css('padding-left',10);
                }

                // Höhe von input Field ausgleichen wenn es zu lang ist --- ENDE

                var width = parseInt(cgJsData[gid].image[index][objectKey].Width);
                var height = parseInt(cgJsData[gid].image[index][objectKey].Height);

                var cgImageThumbRotation = "cg"+cgJsData[gid].image[index][objectKey].rThumb+"degree";

                var heightDependOnNewWidth = newWidthDiv*height/width;

                if(heightDependOnNewWidth < newHeight1[h]){

                    var newWidthImage = (newHeight1[h]*width/height)+2;

                }
                else{
                    var newWidthImage = (newWidthDiv+2);
                }


                /*                var cgRotationThumbNumber = parseInt(cgJsData[gid].image[index][objectKey].rThumb);

                                var cgRotateRatio = 1;

                                if(cgRotationThumbNumber=='90' || cgRotationThumbNumber=='270'){


                                    var cgRotateRatio = width/height;
                                    var cgWidthOriginalImgContainer = width;
                                    width = height;
                                    width = width*cgRotateRatio;
                                    height = cgWidthOriginalImgContainer;

                                    var heightDependOnNewWidth = newWidthDiv*height/width;


                                    if(heightDependOnNewWidth < setNewHeight){

                                        var newWidthImage = (setNewHeight*width/height)+2;

                                    }
                                    else{
                                        var newWidthImage = (newWidthDiv*cgRotateRatio+4);
                                    }


                                }
                                else{

                                    var heightDependOnNewWidth = newWidthDiv*height/width;

                                    if(heightDependOnNewWidth < newHeight1[h]){

                                        var newWidthImage = (newHeight1[h]*width/height)+2;

                                    }
                                    else{
                                        var newWidthImage = (newWidthDiv+2);
                                    }

                                }*/



                //	var cg_hideRowViewWidth = $(this).find( "#cg_hide").width();
                //alert(newWidthImage);

                //       $(this).find( "[id*=cg_hide]").css('width',newWidthDiv);
                //     $(this).find( "[id*=cg_Field1IdGalleryView]").css('width',newWidthDiv);


                // if(showAlways==1){

                //    $(this).find("[id*=cg_hide]").show();
                //     $(this).find( "[id*=cg_Field1IdGalleryView]").show();



                //    if(newWidthDiv<cg_hide_hide_width){

                //    $(this).find("[id*=cg_hide]").hide();
                //    $(this).find("[id*=cg_Field1IdGalleryView]").hide();

                //   }

            }

            // Prüfung und bestimmung der URL Weiterleitung, falls aktiviert ist


            // Positionen Info Comments und Rating auf den Galerie Images

            // INFO
            if(cgJsData[gid].options.visual.TitlePositionGallery==2){
                //    $(this).find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css('text-align','center');
                //	$(this).find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css("padding-right","27px");
                //	$(this).find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css("padding-left","23px");
                //	$(this).find("[id*=cg_Field1IdGallery]").find("div").css("padding-left","23px");
                //	$(this).find("[id*=cg_Field1IdGallery]").find("div").css("padding-right","23px");
                //   $(this).find("[id*=cg_Field1IdGallery]").css('text-align','center');

            }
            else if(cgJsData[gid].options.visual.TitlePositionGallery==3){
                //  $(this).find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css('text-align','right');
                //	$(this).find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css("padding-right","27px");
                //	$(this).find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css("padding-left","23px");
                //	$(this).find("[id*=cg_Field1IdGallery]").find("div").css("padding-left","23px");
                //	$(this).find("[id*=cg_Field1IdGallery]").find("div").css("padding-right","23px");
                //   $(this).find("[id*=cg_Field1IdGallery]").css('text-align','right');

            }
            else{
                //   $(this).find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css('text-align','left');
                //	$(this).find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css("padding-right","17px");
                //	$(this).find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css("padding-left","13px");
                //	$(this).find("[id*=cg_Field1IdGallery]").find("div").css("padding-left","13px");
                //	$(this).find("[id*=cg_Field1IdGallery]").find("div").css("padding-right","13px");
                //     $(this).find("[id*=cg_Field1IdGallery]").css('text-align','left');
            }

            // COMMENTS
            if(cgJsData[gid].options.visual.CommentPositionGallery==2){
                // $(this).find("div[id*=cg_hide]").find(".cg_info_comment_gallery_div").css("text-align","center");
            }
            else if(cgJsData[gid].options.visual.CommentPositionGallery==3){
                //   $(this).find("div[id*=cg_hide]").find(".cg_info_comment_gallery_div").css("text-align","right");
            }
            else{

            }

            // RATING
            if(cgJsData[gid].options.visual.RatingPositionGallery==2){
                //  $(this).find("div[id*=cg_hide]").find(".cg_gallery_rating_div").css("text-align","center");
            }
            else if(cgJsData[gid].options.visual.RatingPositionGallery==3){
                // $(this).find("div[id*=cg_hide]").find(".cg_gallery_rating_div").css("text-align","right");
            }
            else{

            }

            // Positionen Info Comments und Rating auf den Galerie Images --- ENDE


            if(cg_Use_as_URL==1 && cg_ForwardToURL==1  && cg_ForwardFrom==2){

                //Prüfen ob vom user ein http bei entries der url mit eingetragen wurde, wenn nicht dann hinzufügen

                var cg_img_url_entry = $("#cg_img_url"+realId+"").val();

                if (typeof cg_img_url_entry === 'undefined') { }
                else if(cg_img_url_entry.indexOf("http") > -1) { cg_img_url_entry = cg_img_url_entry;}
                else{ cg_img_url_entry = "http://"+cg_img_url_entry;}
                //alert(cg_img_url_entry);

                // alert(cg_a_href_img);

            }
            else{



            }

            // Prüfung und bestimmung der URL Weiterleitung, falls aktiviert ist -- ENDE

            // Zum Schluss wird ermittelt wieviel Zeilen bereits abgearbeitet wurden
            if (r % picsInRow == 0){

                rowsDone++;

            }

            // SEHR WICHTIG!!!! Das muss vorher gemacht werden. Damit später der richtige OffSet zum Document angezeigt wird!
            cgShowObject.css('display','inline');


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


            var cgRotationThumbNumber = parseInt(cgJsData[gid].image[index][objectKey].rThumb);

            // Extra Korrektur für rotated images wenn in single view vorher korrigiert wurden
            if(cgRotationThumbNumber=='270' || cgRotationThumbNumber=='90'){
                cgShowObject.find('#cgGalleryInfo'+realId).css({
                    'top': 'unset',
                    'display': 'block'
                });
            }

            if(cgJsData[gid].options.general.FbLikeGallery>=1){
                cgShowObject.find('#cgFacebookGalleryDiv'+realId).removeClass('cg_hide');
            }

           // if(typeof cgJsData[gid].image[index][firstKey]['imageObject'] === "undefined"){
            if(typeof cgJsData[gid].imageObject[realId] == "undefined"){


                var postTitle = '',
                    postAlt = '';

/*                if(cgJsData[gid].image[index][objectKey].hasOwnProperty('post_title')){
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


                var cgShowPositionHelper = $('<span id="cgShowPositionHelper'+realId+'" class="cg_show_position_helper" data-cg-gid="'+gid+'"></span>');

                if(cgJsData[gid].image[index][objectKey].rThumb=='270' || cgJsData[gid].image[index][objectKey].rThumb=='90'){
                    imageObject.find('.cg_append').css({
                        'width': newHeight1[h]+'px',
                        'height': newWidthDiv+'px',
                    })
                }else{
                    imageObject.find('.cg_append').addClass('cg_append_hundert_percent');
                }

                // thumb wird nicht verwendet, da thumb quadratisches abgeschnittenes bild ist und somot nicht passen könnte
                if(newWidthImage<=imgSrcMediumWidth){
                    imgSrc = imgSrcMedium;
                }
                else if(newWidthImage<=imgSrcLargeWidth){
                    imgSrc = imgSrcLarge;
                }
                else{
                    imgSrc = imgSrcOriginal;
                }

                // always image large to go sure when rotated!!! Otherwsise could be looking washed because low resolution.
                if(cgJsData[gid].image[index][objectKey].rThumb=='270' || cgJsData[gid].image[index][objectKey].rThumb=='90'){
                    imageObject.find('.cg_append').css('background','url("'+imgSrcLarge+'") no-repeat center center');
                }else{
                    imageObject.find('.cg_append').css('background','url("'+imgSrc+'") no-repeat center center');
                }

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


/*                var imageObject = cgShowObject.append("<div class='cg_append' id='cg_append"+realId+"'>"+
                    "<a "+cg_a_href_img+" "+cg_href_img_blank+" "+cg_a_href_title+" >"+
                    "<img src='"+imgSrc+"' data-order='"+r+"' style='float:left;position:absolute;left: -2px ;right: -2px ;max-width:none;" +
                    ""+circleImagesOverflow+";' width='"+newWidthImage+"' height='"+setNewHeight+"' "+cg_id_class_img+">"+
                    "</a>" +
                    "</div>"+ratingCommentDiv+"");*/

                    if(calledFromUpload===true){
                        $mainCGallery.append(cgShowObject);
                    }else{
                        $mainCGallery.append(cgShowObject);
                    }

                    cgShowObject.addClass('cg_fade_in');

                    cgJsData[gid].imageObject[realId] = cgShowObject ;
                    cgJsData[gid].image[index][firstKey]['imageObject'] = cgJsData[gid].imageObject[realId];

                    if(typeof cgJsData[gid].rating[realId] == 'undefined'){
                        cgJsClass.gallery.dynamicOptions.getRatingAndComments(realId,arrIndex,objectKey,gid);
                    }else{
                        cgJsClass.gallery.dynamicOptions.setRatingAndComments(realId,arrIndex,objectKey,gid);
                    }

                    if(typeof cgJsData[gid].vars.info[realId] == 'undefined'){
                        cgJsClass.gallery.info.getInfo(realId,gid,false,arrIndex,openPage);
                    }else{
                        cgJsClass.gallery.info.setInfo(realId,gid,false,arrIndex,cgJsData[gid].vars.info[realId]);
                    }

                    if(imgSrc==imgSrcOriginal || imgDataWidth<newWidthImage){
                        if(typeof cgJsData[gid].vars.rawData['imgSrcOriginalWidth'] == 'undefined'){
                            var img = new Image();
                            img.src = imgSrc;
                            img.onload = function() {
                                cgJsData[gid].vars.rawData[realId]['imgSrcOriginalWidth'] = this.width;
                                cgJsData[gid].vars.rawData[realId]['imgSrcOriginalHeight'] = this.height;
                                var differenceCheck = newWidthImage-this.width;// WidthThumbPic kann man nehmen weil diese sich nicht ändert
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
                if(newWidthImage<=imgSrcMediumWidth){
                    imgSrc = imgSrcMedium;
                }
                else if(newWidthImage<=imgSrcLargeWidth){
                    imgSrc = imgSrcLarge;
                }
                else{
                    imgSrc = imgSrcOriginal;
                }

                    if(cgJsClass.gallery.vars.hasToAppend==true || calledFromUpload===true){
                        cgShowObject.appendTo($mainCGallery);
                        cgShowObject.removeClass('hide');
                    }


                    if(cgJsData[gid].image[index][objectKey].rThumb=='270' || cgJsData[gid].image[index][objectKey].rThumb=='90'){
                        cgShowObject.find('.cg_append').css({
                            'background': 'url("'+imgSrcLarge+'") no-repeat center center',// always image large to go sure when rotated!!! Otherwsise could be looking washed because low resolution.
                            'width': ''+newHeight1[h]+'px',
                            'height': ''+newWidthDiv+'px',
                            'border': 'none'
                        });
                    }else{
                        cgShowObject.find('.cg_append').css({
                            'background': 'url("'+imgSrc+'") no-repeat center center',
                            'width': ''+newWidthDiv+'px',
                            'height': ''+newHeight1[h]+'px',
                            'border': 'none'
                        });
                    }

                    cgShowObject.attr({
                        'data-cg-order': index
                    });

            }


            //Zeile durch, nicht entfernen!!!!!
            if (g % picsInRow == 0) {

                h++;

            }

        });

        $mainCGdiv.find('.cg-lds-dual-ring-div-gallery-hide-mainCGallery').addClass('cg_hide');
        $mainCGallery.removeClass('cg_hide').addClass('cg_fade_in');
        cgJsData[gid].vars.cgCenterDivAppearenceHelper.addClass('cg_hide');

        cgJsClass.gallery.vars.switchViewsClicked=false;

     //   cgJsClass.gallery.resize.resizeInfo(gid,openPage);

        if(openPage==true || viewChange==true){
            // if(appendNew){
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
            //  }
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
