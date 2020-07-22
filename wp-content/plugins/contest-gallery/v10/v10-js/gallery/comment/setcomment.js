cgJsClass.gallery.comment.setComment = function (realId,addCountC,gid) {

        if(cgJsData[gid].options.general.AllowComments>=1){

            var CountC = parseInt(cgJsData[gid].comment[realId]);
            if(CountC>=1 || addCountC>=1){
                var starLook = 'cg_gallery_comments_div_icon_on';
            }else{
                var starLook = 'cg_gallery_comments_div_icon_off';
            }

            if(addCountC == 0) {

                var imageObject = cgJsData[gid].imageObject[realId];

                var position = '';

                if(cgJsData[gid].options.visual['CommentPositionGallery']==2){
                    position = 'cg_center';
                }

                if(cgJsData[gid].options.visual['CommentPositionGallery']==3){
                    position = 'cg_right';
                }



                var commentDiv = '<div class="cg_gallery_comments_div"><div class="cg_gallery_comments_div_child '+position+'" ><div class="cg_gallery_comments_div_icon '+starLook+' cg_gallery_comments_div_icon'+realId+'"></div>' +
/*                    '<img class="cg_png_comments_icon" data-cg_id="'+realId+'" src="'+cgJsClass.gallery.vars.pluginsUrl+'/contest-gallery/v10/v10-css/comments_icon.png" style="cursor:pointer;">' +*/
                    '<div class="cg_gallery_comments_div_count'+realId+' cg_gallery_comments_div_count">'+CountC+'</div></div>';
                imageObject.find('.cg_gallery_info').append(commentDiv);

                var rowIdOfRealId = cgJsData[gid].vars.rawData[realId]['rowid'];

                for(var key in cgJsData[gid].fullImageData){

                    if(!cgJsData[gid].fullImageData.hasOwnProperty(key)){
                        break;
                    }

                    if(cgJsData[gid].fullImageData[key]==rowIdOfRealId){
                        cgJsData[gid].fullImageData[key][rowIdOfRealId]['CountC'] = CountC;
                    }
                }

            }

            if(addCountC > 0 || addCountC < 0){

                var CountC = parseInt(cgJsData[gid].comment[realId]);
                CountC = CountC+parseInt(addCountC);
                cgJsData[gid].comment[realId] = CountC;

                cgJsClass.gallery.dynamicOptions.setNewCountToMainImageArray(realId,'CountC',CountC,gid);

                if(CountC==0){
                    var starLook = 'cg_gallery_comments_div_icon_off';
                }

                jQuery('.cg_gallery_comments_div_icon'+realId).removeClass('cg_gallery_comments_div_icon_on').removeClass('cg_gallery_comments_div_icon_off').addClass(starLook);
                jQuery('.cg_gallery_comments_div_count'+realId).text(CountC);

                for(var key in cgJsData[gid].fullImageData){

                    if(!cgJsData[gid].fullImageData.hasOwnProperty(key)){
                        break;
                    }

                    var firstKey = Object.keys(cgJsData[gid].fullImageData[key])[0];

                    if(cgJsData[gid].fullImageData[key][firstKey]['id']==realId){
                        cgJsData[gid].fullImageData[key][firstKey]['CountC'] = CountC;
                        break;
                    }

                }


            }

        }

}


