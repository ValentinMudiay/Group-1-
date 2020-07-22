cgJsClass.gallery.touch = {
    init: function ($){

        $(document).on('touchstart','.cgCenterDiv', function(e){

            jQuery(window).off('hashchange');

            cgJsClass.gallery.vars.keypressStartInSeconds = new Date().getTime()/1000;

            cgJsClass.gallery.touch.touchstart = e.originalEvent.changedTouches[0].pageX;

            if(cgJsClass.gallery.vars.isMobile==true){

                jQuery('html').addClass('cg_no_scroll');
                jQuery('body').addClass('cg_body_overflow_hidden');

            }



        });

        $(document).on('touchend','.cgCenterDiv', function(e){

            var gid = cgJsClass.gallery.vars.openedGallery;
            var touchstart = cgJsClass.gallery.touch.touchstart;
            var touchend = e.originalEvent.changedTouches[0].pageX;
            var distance = touchstart-touchend;

            if(distance>100 || distance<-100){

                var order = parseInt(cgJsClass.gallery.vars.openedGalleryImageOrder);

                // right
                if(distance<-100){

                    if(order==0){
                        cgJsClass.gallery.views.singleViewFunctions.clickPrevStep(gid);
                        return;
                    }
                    var newOrder = order-1;
                    //console.log('left');
                    //console.log(newOrder);
                    //cgJsClass.gallery.views.singleViewFunctions.setSliderMargin(newOrder,gid,'left');
                    cgJsClass.gallery.views.functions.appendAndRemoveImagesInSlider(gid,newOrder,cgJsData[gid].vars.maximumVisibleImagesInSlider,cgJsData[gid].vars.mainCGslider);

                    cgJsClass.gallery.views.singleView.openImage($,newOrder,false,gid,'left');

                }
                // left
                if(distance>100){

                    var newOrder = order+1;
                    if(newOrder>=cgJsData[gid].image.length){
                        cgJsClass.gallery.views.singleViewFunctions.clickNextStep(gid);
                        return;
                    }
                    //console.log('right');
                    //console.log(newOrder);
                    //cgJsClass.gallery.views.singleViewFunctions.setSliderMargin(newOrder,gid,'right');
                    cgJsClass.gallery.views.functions.appendAndRemoveImagesInSlider(gid,newOrder,cgJsData[gid].vars.maximumVisibleImagesInSlider,cgJsData[gid].vars.mainCGslider);

                    cgJsClass.gallery.views.singleView.openImage($,newOrder,false,gid,'right');
                }

            }

            cgJsClass.gallery.hashchange.activateHashChangeEvent();


            if(cgJsClass.gallery.vars.isMobile==true){

                setTimeout(function () {
                    jQuery('html').removeClass('cg_no_scroll');
                    jQuery('body').removeClass('cg_body_overflow_hidden');
                },300);

            }

        });

        /*        $(document).on('touchstart','.mainCGslider .cg_show', function(e){

                    jQuery(window).off('hashchange');
                    cgJsClass.gallery.vars.keypressStartInSeconds = new Date().getTime()/1000;

                    cgJsClass.gallery.touch.touchstartSlider = e.originalEvent.changedTouches[0].pageX;

                });

                $(document).on('touchend','.mainCGslider .cg_show', function(e){

                    var gid = cgJsClass.gallery.vars.openedGallery;
                    var touchstart = cgJsClass.gallery.touch.touchstartSlider;
                    var touchend = e.originalEvent.changedTouches[0].pageX;
                    var distance = touchstart-touchend;
                    var $mainCGslider = jQuery('#mainCGslider'+gid);


                    if(distance>100 || distance<-100){

                        var order = parseInt(cgJsClass.gallery.vars.openedGalleryImageOrder);

                        // right
                        if(distance<-100){

                            jQuery($mainCGslider).animate({
                                scrollLeft: distance+'px'
                            }, 'fast');

                        }
                        // left
                        if(distance>100){

                            jQuery($mainCGslider).animate({
                                scrollLeft: distance+'px'
                            }, 'fast');
                        }

                    }

                });*/

    },
    touchstart: 0,
    touchstartSlider: 0
};

