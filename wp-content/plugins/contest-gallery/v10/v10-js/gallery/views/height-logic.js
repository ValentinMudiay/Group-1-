cgJsClass.gallery.heightLogic = {
    init: function (jQuery,gid,openPage,calledFromUpload,openImage,stepChange,viewChange,randomButtonClicked,isCopyUploadToAnotherGallery) {
      //  debugger
        // gallery index
        var gid = gid;

        //!IMPORTANT current view look for resize
        cgJsData[gid].vars.currentLook='height';

        if(cgJsData[gid].image.length<1){
            return;
        }

        var $ = jQuery;

        var HeightLookHeight = parseInt(cgJsData[gid].options.general.HeightLookHeight);

        // Wenn alle Bilder geladen wurden, sollten hinsichtlich pagination nichts mehr passieren
        var cg_all_images_loaded = $('#cg_all_images_loaded').val();

        // Neue Höhe
        var newHeight = 0;

        if(cgJsClass.gallery.vars.fullwindow==gid){
            // -40 wegen padding 20 rechts links und 15 wege scroll bar die beim parent hinzugefügt wird
            // var widthMainCGallery = $(window).width()-55;
            var widthMainCGallery = $(window).width()-cgJsClass.gallery.function.general.tools.getScrollbarWidthDependsOnBrowser();
        }else{
            var widthMainCGallery = $('#mainCGdivContainer'+gid).width();
        }

        if(widthMainCGallery<247){
            widthMainCGallery = 247;
        }


        // Breite des divs in dem sich die Galerie befindet
        var widthmain = widthMainCGallery;

        cgJsClass.gallery.views.functions.destroyRangeSlider(gid);

        /* // alert(cg_gallery_resize);
          if(cg_InfiniteScrollGallery==1 && cg_gallery_resize==1){$("#cg_widthMainCGallery").val(widthmain);}


          if(cg_gallery_resize==1 && cg_InfiniteScrollGallery==1){
              widthmain=$("#cg_widthMainCGallery").val();//alert(widthmain);
             // Resize ist zu Ende, nach dem cgHeightLogic ausgeführt wurde
            // $('#cg_gallery_resize').val(0);

              }*/

        // Zur Überprüfung was beim letzten Mal für ein Width war
        //var check_cg_widthMainCGallery = $("#cg_widthMainCGallery").val();
        //alert(check_cg_widthMainCGallery);
/*        if(cg_gallery_resize==0 && check_cg_widthMainCGallery!=0){widthmain=$("#cg_widthMainCGallery").val();}

        else{widthmain=widthmain;}*/

        //alert(widthmain);

        //var widthmainReal = widthmain;


        //$(".werte").append('<br> WidthMain: '+widthmain+'<br>');

        // die einzelnen neu ermittelten Breiten die durch die vorgegebene Höhe entstehen werden gesammelt
        var widthArray = [];

        // die einzelnen Höhen sollen gesammelt werden. Bei Runter- und Hochskaliertung, ist es eine notwendige Angabe im Div
        var heightArray = [];

        // Die Breite der Inhaltsboxen wird ermittelt
        var widthDivArray = [];

        // Sammeln der ursprünglichen Höhe
        var realHeightArray = [];

        // Sammeln der ursprünglichen Breite
        var realWidthArray = [];

        // Anzahl der Durchläufe muss gezählt werden um den letzten Durchlauf zu ermitteln
        var lastLoopProcess = $("#cg_count").val();

        // Anzahl der Durchläufe muss gezählt werden um den letzten Durchlauf zu ermitteln
        var last = [];

        // Anzahl der hochgeladenen Bilder
        var n = Object.keys(cgJsData[gid].image).length;

       // cgJsData[gid].vars.cgCenterDivAppearenceHelper.removeClass('cg_hide');

        // var opacity = $('#cg_HeightViewBorderOpacity').val();
        var opacity = parseInt(cgJsData[gid].options.visual.HeightViewBorderOpacity);

        //opacity = opacity.substring(1);

//opacity = opacity.substring(1);

//alert(opacity);

     //   var borderColor = $("#cg_HeightViewBorderColor").val();
        var borderColor = cgJsData[gid].options.visual.HeightViewBorderColor;

        //alert(borderColor);

 //       var border = parseInt($("#cg_HeightViewBorderWidth").val());
     //   var border = parseInt(cgJsData[gid].options.visual.HeightViewBorderWidth);
        var border = 0;


        // Der erste horizontalSpace (von links kommend) darf nicht vorkommen, der letzte soll abgezogen werden!
        // Wenn nicht null dann muss immer von beiden seiten border hinzugefügt werden
        /*if(cg_horizontalSpace!=0){
            widthmain = widthmain-(border*2+cg_horizontalSpace)* picsInRow+cg_horizontalSpace;
        }
        // Wenn null dann muss border immer nur von einer Seite hinzugefügt werden
        else{
            widthmain = widthmain-(border+cg_horizontalSpace)* picsInRow+cg_horizontalSpace-border;
        }*/


        //alert(border);
        // alert(addBorder);
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

//alert(rcolor[0]);

        var rgba = "("+rcolor[0]+","+rcolor[1]+","+rcolor[2]+", "+opacity+")";

//alert(rgba);

// rgba(255, 0, 0, .5)

//alert(cg_HeightViewSpaceWidth);
//alert(cg_HeightViewSpaceHeight);

        var cg_horizontalSpace = parseInt(cgJsData[gid].options.visual.HeightViewSpaceWidth);
        var cg_verticalSpace = parseInt(cgJsData[gid].options.visual.HeightViewSpaceHeight);

      //  var cg_horizontalSpace = 0;
       // var cg_verticalSpace = 0;

        // extra korrektur sonst fehler bei ansicht
        if(border>0){
            if(cg_horizontalSpace==0){
                cg_horizontalSpace = 1;
            }
            if(cg_verticalSpace==0){
                cg_verticalSpace = 1;
            }
        }


        if(cgJsData[gid].options.visual.HeightViewBorderRadius>5){var cg_CircleImages=1;}
        else{var cg_CircleImages=0;}


        // Hier müssen die VAR neue gesetzt werden!!! Später immer ohne VAR!
        // Wenn horizontal space nicht an ist, dann wird Border immer nur rechts hinzugefügt. Beim ersten Mal sollte border einmal links hinzugefügt werden.
        // ACHTUNG!!! Bei height view, nur wenn kein Circle Image gesetzt ist und horizantol Border 0 ist,
        // wird am Anfang ein border gesetzt als width und dann später nur ein border rechts immer dazu addiert.
        // Ansonsten wird kein Border gesetzt. Sondern danach immer rechts und links border dazu addiert.
        if(cg_horizontalSpace==0 && cg_CircleImages==0){
            var aggregateWidth = border;
        }
        // Wenn horizontal space an ist, dann soll border immer rechts und links dazu adiert werden, wegen den Abständen.
        // Beim ersten Mal muss nichts hinzugefügt werden. Da beim ersten Bild rechts und links border hinzugefügt wird.
        else{
            var aggregateWidth = 0;
        }


        // Gesamtzahl der verarbeiteten Bilder
        var countProcessedPics = 0;

        // Summer der Gesamtlänge, um die alle Bilder, die in die Gesamtbreite reinpassen, insgesamt reduziert werden können.
        // Mehr als 46% kann von einem Bild nicht abgezogen werden ( zuerst 10% Höhe, danach 20% Links, 20% Rechts >>>  46% prozent insgesamt als Reduzierung bei einem Bild möglich )
        var aggregateAcceptableReducedSize = 0;

        // Orientierungsvariable bei Durcharbeiten des großen Arrays
        var r = 0;

        // Orientierungsvariable bei Durcharbeiten des cgCenterDivgroßen Arrays
        var i = 0;


        // Orientierungsvariable wenn width und widthDiv berechnet wurden
        var widthDone = 0;

        // 1. Die neue Höhe jedes einzelnen Bildes muss ermittelt werden. Diese wird in einem Array gesammelt.



        var $mainCGallery = $('#mainCGallery'+gid);
        var $mainCGslider = $('#mainCGslider'+gid);

        var $mainCGdiv = $('#mainCGdiv'+gid);
        $mainCGdiv.css('width',widthmain+'px');

        $mainCGallery.css('width',100+'%');
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

        // needs only for row logic!!!!
        cgJsClass.gallery.resize.galleryIcons($mainCGallery,openPage,true,gid,widthmain);

        $.each(cgJsData[gid].image, function( index,value ) {

            var firstKey = Object.keys(value)[0];

            var objectKey = firstKey;

            var categoryId = cgJsData[gid].image[index][firstKey]['Category'];

            if(typeof cgJsData[gid].vars.categories[categoryId] != 'undefined'){


                if(cgJsData[gid].vars.showCategories == true && cgJsData[gid].vars.categories[categoryId]['Checked']==false){

                    //cgJsData[gid].image[index][firstKey]['imageObject'].remove();

                    return;

                }

            }

            i=r;
            // console.log('first_show_continue');
            r++;


            // Die original Image Größen werden ermittelt über die hidden Felder. Die beim ersten Load von php ermittelt wurden.
        //    var width = $(this).find(".widthOriginalImg").val();
          //  console.log(value);
          //  console.log(cgJsClass.gallery.image[index]);
            var width = parseInt(cgJsData[gid].image[index][objectKey].Width);
         //   console.log(cgJsClass.gallery.image[index].Width);

            //     var height = $(this).find(".heightOriginalImg").val();
            var height = parseInt(cgJsData[gid].image[index][objectKey].Height);

         //   var cgRotationThumbNumber = parseInt($(this).find('.cgRotationThumbNumber').val());
            var cgRotationThumbNumber = parseInt(cgJsData[gid].image[index][objectKey].rThumb);


            /*	// Ermittlung der Höhe nach Skalierung. Falls unter der eingestellten Höhe, dann nächstgrößeres Bild nehmen.
                var widthScaledThumb = HeightLookHeight*width/height;
                    // Ermittlung der Höhe nach Skalierung. Falls unter der eingestellten Höhe, dann nächstgrößeres Bild nehmen.
                    $heightScaledThumb = $WidthThumb*$heightOriginalImg/$widthOriginalImg;

                if (heightScaledThumb > HeightLookHeight) {


                    if(cgRotationThumbNumber=='90' || cgRotationThumbNumber=='270'){

                        width = width*cgRotateRatio;

                    }


                }*/


            realHeightArray.push(height);
            realWidthArray.push(width);



            var newWidth = width*HeightLookHeight/height;

            // die einzelnen neu ermittelten Breiten die durch die vorgegebene Höhe entstehen werden gesammelt
            widthArray.push(newWidth);
            heightArray.push(HeightLookHeight);
            widthDivArray.push(newWidth);

       //     console.log('HeightLookHeight')
        //    console.log(HeightLookHeight)
       //     console.log(width)
    //        console.log(height)
     //       console.log(newWidth)

            // Wenn horizontal space nicht an ist, dann wird Border immer nur rechts hinzugefügt
            if(cg_horizontalSpace==0){
                aggregateWidth = aggregateWidth + newWidth + border;
            }
            // Wenn horizontal space an ist, dann soll border immer rechts und links dazu adiert werden, wegen den Abständen.
            else{
                widthDone = 0;
                aggregateWidth = aggregateWidth + newWidth + border*2;//ACHTUNG!!! Horizontal Space wird zum schluss der Schleife immer hinzugefügt. Dadurch wird beim letzten Element horizontalSpace nicht unnötig hinzuaddiert!
            }

            // zuerst 10% Höhe, danach 20% Links, 20% Rechts >>> 46% prozent insgesamt als Reduzierung möglich
            var acceptableReducedSize = newWidth/100*46;

            // Summer der Gesamtlänge, um die alle Bilder, die in die Gesamtbreite reinpassen, insgesamt reduziert werden können.
            aggregateAcceptableReducedSize = aggregateAcceptableReducedSize + newWidth;

            //widthmain = widthmain-cg_border_width*2;

            //$(".werte").append('<br> aggregateWidth '+r+' :'+aggregateWidth+'<br>');
            ////$(".werte").append('<br>'+r+' :'+src+'<br>');
            //$(".werte").append('<br> step '+r+' :'+lastLoopProcess+'<br>');

            //$(".werte").append('<br>Durchgang: '+i+'<br>');


            //alert(aggregateWidth);

            // Wenn es der letzte Durchlauf ist und die gesammelte Breite unter 90% der Gesamtbreite ergibt dann wird nichts gemacht


         //   console.log('aggregateWidth');
         //   console.log(aggregateWidth);
            if (aggregateWidth < widthmain/100*90 && lastLoopProcess == r) {
                //alert(aggregateWidth);
                for (i = countProcessedPics; i < r; i++) {

                    //$(".werte").append('<br> Variante 0:<br>');
                    //$(".werte").append('<br> widthArray['+i+']: '+widthArray[i]+'<br>');

                    widthArray[i] = widthArray[i];
                    widthDivArray[i] = widthDivArray[i];

                    //alert("Variante 1");

                    //$(".werte").append('<br> Neue Breite:'+newWidth+'<br>');
                    //$(".werte").append('<br> widthArray['+i+']: '+widthArray[i]+'<br>');

                }

                // Gesammelte Breite wieder zurück auf Null setzen
                if(cg_horizontalSpace==0){
                    aggregateWidth = border;
                }
                else{
                    aggregateWidth = 0;
                }

                widthDone = 1;

            }


            // Wenn die gesammelte Breite über 90% der Gesamtbreite ergibt, dann wird hochskaliert. Die Höhe bleibt die vorgegebene Höhe
            else if (aggregateWidth >= widthmain/100*90 && aggregateWidth <= widthmain) {
                //alert(aggregateWidth);
                for (i = countProcessedPics; i < r; i++) {

                    //$(".werte").append('<br> Variante 1:<br>');
                    //$(".werte").append('<br> widthArray['+i+']: '+widthArray[i]+'<br>');

                    newWidth = widthArray[i]/(aggregateWidth*100/widthmain)*100;
                    widthArray[i] = newWidth;
                    widthDivArray[i] = newWidth;

                    //$(".werte").append('<br> Neue Breite:'+newWidth+'<br>');
                    //$(".werte").append('<br> widthArray['+i+']: '+widthArray[i]+'<br>');


                    //alert("Variante 2");


                }

                countProcessedPics = r;

                // Gesammelte Breite wieder zurück auf Null setzen
                if(cg_horizontalSpace==0){
                    aggregateWidth = border;
                }
                else{
                    aggregateWidth = 0;
                }

                widthDone = 1;

                last[r] = 'on';
                //alert(last[r]);

                //$(".werte").append('<br> countProcessedPics: '+countProcessedPics+'<br/>');
                //$(".werte").append('<br> last['+r+']: '+last[r]+'<br>');

                //widthmain = widthmainReal;

                //alert(2);

            }

            // Wenn die gesammelte Breite größer als die Gesamtbreit ist, dann wird runterskaliert oder abgeschnitten
            else if(aggregateWidth > widthmain){
                //	alert(3);
                //alert(aggregateWidth);
                // Größe des Überhangs
                overhang = aggregateWidth - widthmain;

                overhangInPercent = overhang*100/widthmain;

                //$(".werte").append('<br> overhangInPercent: '+overhangInPercent+'<br/>');

                // Wenn der Überhang nur unter 10% ist dann werden die Bilder NUR runterskaliert auf 100% (man kann auch hochskalieren, glaubenssache :))
                if (overhangInPercent <= 10) {


                    for (i = countProcessedPics; i < r; i++) {

                        //$(".werte").append('<br> Variante 2:<br>');
                        //$(".werte").append('<br> widthArray['+i+']: '+widthArray[i]+'<br>');
                        wholePercent=100+overhangInPercent;

                        newWidth = widthArray[i]/wholePercent*100;

                        //newWidth = widthArray[i]/wholePercent*100;
                        newHeight = heightArray[i]/wholePercent*100;
                        //newHeight = heightArray[i]/wholePercent*100;
                        widthArray[i] = newWidth;
                        heightArray[i] = newHeight;
                        widthDivArray[i] = newWidth;

                        //alert(newWidth);

                        //$(".werte").append('<br> Neue Breite:'+newWidth+'<br>');
                        //$(".werte").append('<br> widthArray['+i+']: '+widthArray[i]+'<br>');

                    }

                    countProcessedPics = r;

                    last[r] = 'on';
                    //alert(last[r]);

                    //$(".werte").append('<br> countProcessedPics: '+countProcessedPics+'<br/>');
                    //$(".werte").append('<br> last['+r+']: '+last[r]+'<br>');

                    //alert(3);
                    //	alert("Variante 3");

                }

                // Wenn der Überhang nur über 10% und unter 46% ist dann werden die Bilder abgeschnitten und runterskaliert
                if (overhangInPercent > 10 && overhangInPercent <=46) {

                    for (i = countProcessedPics; i < r; i++) {

                        //$(".werte").append('<br> Variante 3:<br>');
                        //$(".werte").append('<br> overhangInPercent: '+overhangInPercent+'<br/>');
                        //$(".werte").append('<br> widthArray['+i+']: '+widthArray[i]+'<br>');


                        newWidth = widthArray[i]/100*90;
                        newHeight = heightArray[i]/100*90;
                        widthArray[i] = newWidth;
                        heightArray[i] = newHeight;
                        //widthDivArray[i] = widthDivArray[i]/100*(100-Math.ceil((overhangInPercent-10)));
                        widthDivArray[i] = newWidth;

                        //alert(newHeight);
                        //alert(newWidth);

                        //$(".werte").append('<br> Neue Breite:'+newWidth+'<br>');
                        //$(".werte").append('<br> Neue Div Breite:'+widthDivArray[i]+'<br>');
                        //$(".werte").append('<br> widthArray['+i+']: '+widthArray[i]+'<br>');

                    }

                    countProcessedPics = r;

                    last[r] = 'on';
                    //alert(last[r]);
                    //$(".werte").append('<br> countProcessedPics: '+countProcessedPics+'<br/>');
                    //$(".werte").append('<br> last['+r+']: '+last[r]+'<br>');

                    //alert(4);

                    //alert("Variante 4");

                }

                // Wenn der Überhang über 46% ist dann werden die Bilder abgeschnitten und runterskaliert. Beim letzten in der Reihe wird alles was über 46% ist komplett abgeschnitten.
                if (overhangInPercent > 46) {


                    for (i = countProcessedPics; i < r; i++) {

                        //$(".werte").append('<br> Variante 4: '+newWidth+'<br>');

                        newWidth = widthArray[i]/100*90;
                        newHeight = heightArray[i]/100*90;
                        widthArray[i] = newWidth;
                        heightArray[i] = newHeight;
                        widthDivArray[i] = widthDivArray[i]/100*(100-36);

                    }

                    countProcessedPics = r;

                    last[r] = 'on';
                    //alert(last[r]);
                    //$(".werte").append('<br> countProcessedPics: '+countProcessedPics+'<br/>');
                    //$(".werte").append('<br> last['+r+']: '+last[r]+'<br>');

                    //alert(5);

                    //alert("Variante 5");

                }

                // Gesammelte Breite wieder zurück auf Null setzen
                if(cg_horizontalSpace==0){
                    aggregateWidth = border;
                }
                else{
                    aggregateWidth = 0;
                }

                widthDone = 1;

                //widthmain = widthmainReal;

            }

            if(cg_horizontalSpace!=0 && widthDone==0){
                aggregateWidth = aggregateWidth + cg_horizontalSpace;
                //alert(aggregateWidth);
            }




        });


        // var h = 0;
        var i = 0;
        var r = 0;



        // Hier müssen die VAR neue gesetzt werden!!! Später immer ohne VAR!
        // Gesammelte Breite wieder zurück auf Null setzen
        // ACHTUNG!!! Bei height view, nur wenn kein Circle Image gesetzt ist und horizantol Border 0 ist,
        // wird am Anfang ein border gesetzt als width und dann später nur ein border rechts immer dazu addiert.
        // Ansonsten wird kein Border gesetzt. Sondern danach immer rechts und links border dazu addiert.
        if(cg_horizontalSpace==0 && cg_CircleImages==0){
            var aggregateWidth = border;
        }
        else{
            var aggregateWidth = 0;
        }


        // var checkAggregateWidth = border;

        var firstRow = 0;

        // Zur Ermittlung des Abstandes zum Rand des HTMLs für Pagination
        var cg_imgOffsetHTML = 0;

        // Sobald cg_pagination 1 erreicht hat, dann loading gif anzeigen und nicht mehr laden, bis weiter gescrollt wird
        var cg_pagination = 0;

        // Wie viele Rows wurden verarbeitet
        var rowsDone = 0;

        // Ermittlung der Durchgänge in einer Reihe
        var rInRow = 0;

        // console.log('second_show');

        var classCounter = 0;

     //   console.log('widthArray');
     //   console.log(widthArray);
      //  $( ".cg_show" ).each(function( i ) {
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

            i=r;

            // console.log(i);

            r++;
            rInRow++;

            var cgImageThumbRotation = "cg"+cgJsData[gid].image[index][objectKey].rThumb+"degree";


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


            var cg_Use_as_URL = cgJsData[gid].vars.formHasUrlField;
            var cg_ForwardToURL = cgJsData[gid].options.general.ForwardToURL;
            var cg_ForwardType = cgJsData[gid].options.general.ForwardType;
            var cg_ForwardFrom = cgJsData[gid].options.general.ForwardFrom;
            var cg_FullSizeImageOutGalleryNewTab = cgJsData[gid].options.general.FullSizeImageOutGalleryNewTab;
            var cg_FullSizeImageOutGallery = cgJsData[gid].options.general.FullSizeImageOutGallery;


            //Achtung entspricht nicht der Anzahl der tatsächlich geladenen Bilder. Fängt mit 0 an. Wird auch für das gesammelte Height und Width Array verwendet.
            var cg_pagination_position_count = $('#cg_pagination_position_count').val();


            // Wenn resize gemacht wurde gerade und logic läuft, dann sollen ALLE nochmal abgearbeitet werden

            if(i<=cg_pagination_position_count && cgJsData[gid].options.general.InfiniteScroll==1 && cg_pagination_position_count!=0){

               // console.log('do nothing');
                //var cg_do_nothing = 1;
            }
            else{

                var realId = cgJsData[gid].image[index][firstKey]['id'];

                var imgDataWidth = parseInt(cgJsData[gid].vars.rawData[realId].Width);

                // if(typeof cgJsData[gid].image[index][firstKey]['imageObject'] === "undefined") {
                if(typeof cgJsData[gid].imageObject[realId]  === "undefined") {

             //       var imageTitle = cgJsData[gid].image[index][firstKey]['post_title'];

            //        var imageTarget = '';

                    var imageTarget = '';
                    var imageHref = '';
                    if(cgJsData[gid].options.general.FullSizeImageOutGallery==1){
                        imageTarget = 'target="_blank"';
                        imageHref = imgSrcOriginal;
                    }


/*                    if(cg_FullSizeImageOutGallery==1){
                        imageTarget = 'target="_blank"';
                        var imageHref = imgSrcOriginal;
                    }
                    else{
                        var imageHref = location.href+'#!image/'+realId+'/'+imageTitle;
                    }*/

                    var cgShowObject = $("<div data-cg-cat-id='"+categoryId+"' data-cg-id='"+realId+"' data-cg-gid='"+gid+"' data-cg-order='"+index+"' class='cg_show cg-cat-"+categoryId+"' id='cg_show"+realId+"'>");

                }
                else{


                    // Pauschal blink class cg_blink_image_disappear entfernen
                 //   var cgShowObject = cgJsData[gid].image[index][firstKey]['imageObject'].removeClass('cg_hide').removeClass('cg_blink_image_disappear').removeClass('cg_fade_in');
                    var cgShowObject = cgJsData[gid].imageObject[realId] .removeClass('cg_hide').removeClass('cg_blink_image_disappear').removeClass('cg_fade_in');
                    cgJsData[gid].image[index][firstKey]['imageObject'] = cgJsData[gid].imageObject[realId];


                }

                if(cgJsClass.gallery.vars.switchViewsClicked==true){
                    cgShowObject.removeAttr('style width height');
                    cgShowObject.find('.cg_append').removeAttr('style width height');
                    // cgShowObject.find('.cg_append_image').removeAttr('style width height');
                }


                var cg_a_href_title = '';


                // width für Bilder array
                var width = Math.floor(widthArray[i]);


                // width für div array
                var height = Math.floor(heightArray[i])-3;


                var cgRotationThumbNumber = parseInt(cgJsData[gid].image[index][objectKey].rThumb);

                var cgRotateRatio = 1;

                var widthOriginalImg = cgJsData[gid].image[index][objectKey].Width;
                var heightOriginalImg = cgJsData[gid].image[index][objectKey].Height;

                var widthDiv = Math.floor(widthDivArray[i]);


/*                if(cgRotationThumbNumber=='90' || cgRotationThumbNumber=='270'){

                    // Ermittlung der Höhe nach Skalierung. Falls unter der eingestellten Höhe, dann nächstgrößeres Bild nehmen.
                    var heightScaledThumb = HeightLookHeight*heightOriginalImg/widthOriginalImg;

                    if (heightScaledThumb < HeightLookHeight) {

                        cgRotateRatio = widthOriginalImg/heightOriginalImg;
                        var widthDiv = Math.floor(widthDivArray[i])/cgRotateRatio;
                        width = width*cgRotateRatio;

                    }

                }*/

                // Perfekte Anpassung letztes Bild der Zeile
                if (last[r] == 'on'){

                    // Wenn horizontal Space nicht an ist, wird Border nur einmal von einer Seite abgezogen (später im CSS kommt wird es rechts hinzuaddiert)
                    // ACHTUNG!!! Bei height view, nur wenn kein Circle Image gesetzt ist und horizantol Border 0 ist,
                    // wird am Anfang ein border gesetzt als width und dann später nur ein border rechts immer dazu addiert.
                    // Ansonsten wird kein Border gesetzt. Sondern danach immer rechts und links border dazu addiert.
                    if(cg_horizontalSpace==0 && cg_CircleImages==0){
                        widthDiv = widthmain - aggregateWidth-border;
                    }
                    // Wenn horizontal Space an ist, dann wird Border von einer und anderen Seite abgezogen (später im CSS kommt wird es rechts und links hinzuaddiert)
                    else{
                        widthDiv = widthmain - aggregateWidth-border*2;
                    }


                    if(width<widthDiv){ width = widthDiv;}


                    // So wie als ob oben vor dem ersten Durchlauf
                    // Gesammelte Breite wieder zurück auf Null setzen
                    // ACHTUNG!!! Bei height view, nur wenn kein Circle Image gesetzt ist und horizantol Border 0 ist,
                    // wird am Anfang ein border gesetzt als width und dann später nur ein border rechts immer dazu addiert.
                    // Ansonsten wird kein Border gesetzt. Sondern danach immer rechts und links border dazu addiert.
                    if(cg_horizontalSpace==0 && cg_CircleImages==0){
                        aggregateWidth = border;
                    }
                    else{
                        aggregateWidth = 0;
                    }

                }

                else{
                    // ACHTUNG!!! Bei height view, nur wenn kein Circle Image gesetzt ist und horizantol Border 0 ist,
                    // wird am Anfang ein border gesetzt als width und dann später nur ein border rechts immer dazu addiert.
                    // Ansonsten wird kein Border gesetzt. Sondern danach immer rechts und links border dazu addiert.
                    if(cg_horizontalSpace==0 && cg_CircleImages==0){
                        aggregateWidth = aggregateWidth + widthDiv + border;
                    }
                    // Wenn horizontal space an ist, dann soll border immer rechts und links dazu adiert werden, wegen den Abständen.
                    else{

                        aggregateWidth = aggregateWidth + widthDiv + border*2 + cg_horizontalSpace;


                    }

                }

                // Image zentrieren --- ENDE


              //  cgShowObject.find( "[id*=cg_hide]").css('width',widthDiv);
              //  cgShowObject.find( "[id*=cg_Field1IdGalleryView]").css('width',widthDiv);


                // pauschal border none und margin unset
                // sonst falsche anzeige falls eine view davor margin und border hatte und diese nicht
                cgShowObject.css({
                    'border':'none',
                    'margin':'unset',
                    'width': widthDiv,
                    'height': height,
                    'float':'left',
                    'display':'inline'
                });


                if(cg_CircleImages==1){cgShowObject.css({"border-radius": ""+cgJsData[gid].options.visual.HeightViewBorderRadius+"%"});
               // var circleImagesOverflow = "overflow:hidden";
                }

                // Verteilung Border und Margin rechts und links

                if(r == 1){
                    cgShowObject.css({"border-left": "rgba"+rgba+"  solid "+border+"px"});
                    //borderLeft = "rgba"+rgba+"  solid "+border+"px";
                }

                var rCheck = r-1;

                // Jedes mal wenn eine Reihe abgearbeitet wurde, gleich beim ersten Bild border-left wieder setzten!!!
                // wenn letztes Bild vorher war, dann margin nicht setzten
                if (last[rCheck] == 'on' || r==1){
                    if(border>0){
                        cgShowObject.css({"border-left": "rgba"+rgba+"  solid "+border+"px"});
                        //borderLeft = "rgba"+rgba+"  solid "+border+"px";
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
                        //borderLeft = "rgba"+rgba+"  solid "+border+"px";
                    }
                }

                //Border rechts muss immer sein!
                cgShowObject.css({"border-right": "rgba"+rgba+"  solid "+border+"px"});
                //borderRight = "rgba"+rgba+"  solid "+border+"px";


                // Verteilung Border und Margin rechts und links --- ENDE!

                // Positionen Info Comments und Rating auf den Galerie Images

                // INFO
                if(cgJsData[gid].options.general.TitlePositionGallery==2){
                    cgShowObject.find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css('text-align','center');
                    //	cgShowObject.find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css("padding-right","27px");
                    //	cgShowObject.find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css("padding-left","23px");
                    //	cgShowObject.find("[id*=cg_Field1IdGallery]").find("div").css("padding-left","23px");
                    //	cgShowObject.find("[id*=cg_Field1IdGallery]").find("div").css("padding-right","23px");
                    cgShowObject.find("[id*=cg_Field1IdGallery]").css('text-align','center');

                }
                else if(cgJsData[gid].options.general.TitlePositionGallery==3){
                    cgShowObject.find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css('text-align','right');
                    //	cgShowObject.find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css("padding-right","27px");
                    //	cgShowObject.find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css("padding-left","23px");
                    //	cgShowObject.find("[id*=cg_Field1IdGallery]").find("div").css("padding-left","23px");
                    //	cgShowObject.find("[id*=cg_Field1IdGallery]").find("div").css("padding-right","23px");
                    cgShowObject.find("[id*=cg_Field1IdGallery]").css('text-align','right');

                }
                else{
                    cgShowObject.find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css('text-align','left');
                    //	cgShowObject.find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css("padding-right","17px");
                    //	cgShowObject.find("div[id*=cg_hide]").find(".cg_info_depend_on_radius").css("padding-left","13px");
                    //	cgShowObject.find("[id*=cg_Field1IdGallery]").find("div").css("padding-left","13px");
                    //	cgShowObject.find("[id*=cg_Field1IdGallery]").find("div").css("padding-right","13px");
                    cgShowObject.find("[id*=cg_Field1IdGallery]").css('text-align','left');
                }

                // COMMENTS
                if(cgJsData[gid].options.general.TitlePositionGallery==2){
                    cgShowObject.find("div[id*=cg_hide]").find(".cg_gallery_comments_div").css("text-align","center");
                }
                else if(cgJsData[gid].options.general.TitlePositionGallery==3){
                    cgShowObject.find("div[id*=cg_hide]").find(".cg_gallery_comments_div").css("text-align","right");
                }
                else{

                }

                // RATING
                if(cgJsData[gid].options.general.TitlePositionGallery==2){
                    cgShowObject.find("div[id*=cg_hide]").find(".cg_gallery_rating_div").css("text-align","center");
                }
                else if(cgJsData[gid].options.general.TitlePositionGallery==3){
                    cgShowObject.find("div[id*=cg_hide]").find(".cg_gallery_rating_div").css("text-align","right");
                }
                else{

                }


                // Positionen Info Comments und Rating auf den Galerie Images --- ENDE


                // Verteilung Border und Margin oben und unten

                //Extra Bearbeitung falls gerade resized wurde

                if(border!=0){
                    cgShowObject.css({"border-top": "rgba"+rgba+"  solid "+border+"px"});
                    //borderTop = "rgba"+rgba+"  solid "+border+"px";
                }

                // ACHTUNG!!!!! Wenn horizontaler Abstand gesetzt und verticaler nicht gesetzt ist, dann werdden die oberen und unteren Borders
                //trotzdem so gesetzt als ob verticaler Abstand eingestellt ist, damit es nicht fehlerhaft aussieht.


                if(rowsDone==0){

                    //Falls verticalSpace NULL und Pagination aktiviert ist, dann border-top nur dann setzten wenn cg_pagination_position_count NULL ist!!!!
                    if(cg_pagination_position_count==0 && cg_verticalSpace==0){
                        cgShowObject.css({"border-top": "rgba"+rgba+"  solid "+border+"px"});
                        //borderTop = "rgba"+rgba+"  solid "+border+"px";
                        //alert(1);
                    }
                    else{
                        // Vertical Space nicht null ist, dann kann immer gesetzt werden!
                        if(cg_verticalSpace!=0 || (cg_verticalSpace==0 && cg_horizontalSpace!=0 ) || cg_CircleImages==1){
                            cgShowObject.css({"border-top": "rgba"+rgba+"  solid "+border+"px"});
                            //borderTop = "rgba"+rgba+"  solid "+border+"px";
                        }
                        else{
                            // Ansonsten nur beim ersten durchlauf!
                            if(rowsDone==0 && cgJsClass.gallery.options.general.InfiniteScroll!=1){
                                cgShowObject.css({"border-top": "rgba"+rgba+"  solid "+border+"px"});
                                //borderTop = "rgba"+rgba+"  solid "+border+"px";
                            }
                        }

                    }

                    cgShowObject.css({"border-bottom": "rgba"+rgba+"  solid "+border+"px"});
                    //borderBottom= "rgba"+rgba+"  solid "+border+"px";
                    if(cg_verticalSpace!=0 || (cg_verticalSpace==0 && cg_horizontalSpace!=0 )){
                        cgShowObject.css({"margin-bottom": ""+cg_verticalSpace+"px"});
                        //borderBottom= "rgba"+rgba+"  solid "+border+"px";
                    }
                }
                else{
                    if(cg_verticalSpace!=0 || (cg_verticalSpace==0 && cg_horizontalSpace!=0 ) || cg_CircleImages==1){
                        cgShowObject.css({"margin-bottom": ""+cg_verticalSpace+"px"});
                        cgShowObject.css({"border-top": "rgba"+rgba+"  solid "+border+"px"});
                        //borderTop = "rgba"+rgba+"  solid "+border+"px";
                        cgShowObject.css({"border-bottom": "rgba"+rgba+"  solid "+border+"px"});
                        //borderBottom= "rgba"+rgba+"  solid "+border+"px";
                    }
                    else{
                        cgShowObject.css({"border-bottom": "rgba"+rgba+"  solid "+border+"px"});
                        //borderBottom= "rgba"+rgba+"  solid "+border+"px";
                    }
                }


                // Verteilung Border und Margin oben und unten --- ENDE


                // Setzten in die Mitte falls Circle aktiviert ist
                if(cg_CircleImages==1){// Achtung! Div height hier nehmen!!!
                    cgShowObject.find("[id*=cg_hide]").css('margin-bottom',height/2-45.75/2);
                    //cgShowObject.find("[id*=cg_hide]").css('padding-left',10);
                }

                // Höhe von input Field ausgleichen wenn es zu lang ist --- ENDE

                // Prüfung und bestimmung der URL Weiterleitung, falls aktiviert ist

                if(cg_Use_as_URL==1 && cg_ForwardToURL==1 && cg_ForwardFrom==2){

                    //Prüfen ob vom user ein http bei entries der url mit eingetragen wurde, wenn nicht dann hinzufügen

                    var cg_img_url_entry = $("#cg_img_url"+realId+"").val();

                    if (typeof cg_img_url_entry === 'undefined') { }
                    else if(cg_img_url_entry.indexOf("http") > -1) { cg_img_url_entry = cg_img_url_entry; }
                    else{ cg_img_url_entry = "http://"+cg_img_url_entry;}


                    var cg_a_href_img = "href='"+cg_img_url_entry+"'";

                  //  var cg_a_href_title = "title='Go to "+cg_img_url_entry+"'";

                    if(cg_ForwardType==2){

                        var cg_href_img_blank = "target='_blank'";

                    }

                    else{

                        var cg_href_img_blank = "";

                    }

                   // var cg_id_class_img = "id='cg_image_id"+realId+"' class='"+cgImageThumbRotation+"'";

                    // alert(cg_a_href_img);

                }
                else{

                   // var cg_a_href_img = "href='"+hrefCGpic+"' class='cg_href_image'";
                   // var cg_id_class_img = "data-cg_image_id='"+realId+"' id='cg_image_id"+realId+"' class='cg_append_image cg_image"+classCounter+" "+cgImageThumbRotation+"'";
                   // var cg_href_img_blank = "";

                    //Prüfen ob FullSizeImageOutGalleryNewTab aktiviert ist
                    //alert(cg_FullSizeImageOutGalleryNewTab);
                    if(cg_FullSizeImageOutGallery==1){
                        if(cg_FullSizeImageOutGalleryNewTab==1){
                           // var cg_href_img_blank = "target='_blank'";
                        }
                        else{
                           // var cg_href_img_blank = "";
                        }
                    }
                }

                // Prüfung und bestimmung der URL Weiterleitung, falls aktiviert ist --- ENDE


                // Zum Schluss wird ermittelt wieviel Zeilen bereits abgearbeitet wurden
                if (last[r] == 'on'){

                    rowsDone++;

                }
                //  console.log(width);


            // rating and comment div here

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

               // rating and comment div here  ---- ENDE

               // if(typeof cgJsData[gid].image[index][firstKey]['imageObject'] === "undefined"){
                if(typeof cgJsData[gid].imageObject[realId]  === "undefined"){

/*                    var rotationClass = cgImageThumbRotation;

                    if(cgRotationThumbNumber=='180'){
                        rotationClass = 'cg180degree';
                    }*/

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

                    if(cgJsData[gid].image[index][objectKey].rThumb=='270' || cgJsData[gid].image[index][objectKey].rThumb=='90'){
                        imageObject.find('.cg_append').css({
                            'width': ''+height+'px',// !IMPORTANT here when rotating 100% should not be used which is set in CSS files
                            'height': ''+widthDiv+'px'// !IMPORTANT here when rotating 100% should not be used which is set in CSS files
                        });
                        //!IMPORTANT here when rotating 100% should not be used which is set in CSS files. important has also to be set via attr, does not work via css with jquery
                      //  imageObject.attr('style',imageObject.attr('style')+'width:'+height+'px !important;height:'+widthDiv+'px !important;');
                    }else{
                        imageObject.find('.cg_append').addClass('cg_append_hundert_percent');
                    }

                    var cgShowPositionHelper = $('<span id="cgShowPositionHelper'+realId+'" class="cg_show_position_helper" data-cg-gid="'+gid+'"></span>');
/*                    imageObject.css({
                        "border-left": borderLeft,
                        "border-right": borderRight,
                        "border-top": borderTop,
                        "border-bottom": borderBottom
                    });*/


                        // thumb wird nicht verwendet, da thumb quadratisches abgeschnittenes bild ist und somot nicht passen könnte
                        if(width<=imgSrcMediumWidth){
                            imgSrc = imgSrcMedium;
                        }
                        else if(width<=imgSrcLargeWidth){
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


                        if(calledFromUpload===true){
                            $mainCGallery.append(cgShowObject);
                        }else{
                            $mainCGallery.append(cgShowObject);
                        }

                        cgShowObject.addClass('cg_fade_in');

                        cgJsData[gid].imageObject[realId] =cgShowObject ;
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

                        if(imgSrc==imgSrcOriginal || imgDataWidth < width){
                            if(typeof cgJsData[gid].vars.rawData['imgSrcOriginalWidth'] == 'undefined'){
                                var img = new Image();
                                img.src = imgSrc;
                                img.onload = function() {
                                    cgJsData[gid].vars.rawData[realId]['imgSrcOriginalWidth'] = this.width;
                                    cgJsData[gid].vars.rawData[realId]['imgSrcOriginalHeight'] = this.height;
                                    var differenceCheck = width-this.width;// WidthThumbPic kann man nehmen weil diese sich nicht ändert
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
                        if(width<=imgSrcMediumWidth){
                            imgSrc = imgSrcMedium;
                        }
                        else if(width<=imgSrcLargeWidth){
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
                                'width': ''+height+'px',// !IMPORTANT here when rotating 100% should not be used which is set in CSS files
                                'height': ''+width+'px',// !IMPORTANT here when rotating 100% should not be used which is set in CSS files
                                'border': 'none'
                            });
                        }else{
                            cgShowObject.find('.cg_append').css({
                                'background': 'url("'+imgSrc+'") no-repeat center center',
                                'width': ''+width+'px',
                                'height': ''+height+'px',
                                'border': 'none'
                            });
                        }

                        cgShowObject.attr({
                            'data-cg-order': index
                        });


                }


            }
            i++;
            if(i==n){$("#cg_all_images_loaded").val(1);}


        });

        $mainCGdiv.find('.cg-lds-dual-ring-div-gallery-hide-mainCGallery').addClass('cg_hide');
        $mainCGallery.removeClass('cg_hide').addClass('cg_fade_in');
        cgJsData[gid].vars.cgCenterDivAppearenceHelper.addClass('cg_hide');

        cgJsClass.gallery.vars.switchViewsClicked=false;

     //   cgJsClass.gallery.resize.resizeInfo(gid,openPage);

        if(openPage==true || viewChange==true){
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
