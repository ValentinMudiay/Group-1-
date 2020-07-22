jQuery(document).ready(function($){
    //console.log($('#cgImgSource').width());
    //console.log($('#cgImgSource').height());
    if($('#cgImgSource').height()>=$('#cgImgSource').width()){
        //console.log(0);
        $('#cgImgSourceContainerMain').height($('#cgImgSource').height());
    }
    else{//console.log(1);
        $('#cgImgSourceContainerMain').height($('#cgImgSource').width());
    }


    if($('#cgImgThumb').height()>=$('#cgImgThumb').width()){//console.log(2);
        $('#cgImgThumbContainerMain').height($('#cgImgThumb').height());
    }
    else{//console.log(3);
        $('#cgImgThumbContainerMain').height($('#cgImgThumb').width());
    }


    $(document).on('click','#cgRotateSource',function () {
     //   cgSameHeightDivImage();

        if(!$('#cgImgSource').hasClass('cg90degree') && !$('#cgImgSource').hasClass('cg180degree') && !$('#cgImgSource').hasClass('cg270degree')){
            $('#cgImgSource').addClass('cg90degree');
            $('#rSource').val(90);
        }
        else if($('#cgImgSource').hasClass('cg90degree')){
            $('#cgImgSource').removeClass('cg90degree');
            $('#cgImgSource').addClass('cg180degree');
            $('#rSource').val(180);
        }
        else if($('#cgImgSource').hasClass('cg180degree')){
            $('#cgImgSource').removeClass('cg180degree');
            $('#cgImgSource').addClass('cg270degree');
            $('#rSource').val(270);
        }
        else if($('#cgImgSource').hasClass('cg270degree')){
            $('#cgImgSource').removeClass('cg270degree');
            $('#rSource').val(0);
        }
    });
    $(document).on('click','#cgResetSource',function () {
        cgSameHeightDivImage();
        $('#cgImgSource').removeClass('cg90degree');
        $('#cgImgSource').removeClass('cg180degree');
        $('#cgImgSource').removeClass('cg270degree');
        $('#rSource').val(0);

    });


    function cgSameHeightDivImage(){
        /*        if($('#cgImgSource').hasClass('cg90degree') || $('#cgImgSource').hasClass('cg270degree')){
                    $('#cgImgSource').width(cgContainerImageWidth);
                    $('#cgImgSourceContainer').height(cgContainerImageHeight);
                    console.log(1);
                }
                else{
                    $('#cgImgSource').width(cgContainerImageWidth);
                    $('#cgImgSource').width(cgContainerImageHeight);
                    $('#cgImgSourceContainer').height(cgContainerImageWidth);
                    console.log(2);
                }*/
    }


    $(document).on('click','#cgRotateThumb',function () {
        if(!$('#cgImgThumb').hasClass('cg90degree') && !$('#cgImgThumb').hasClass('cg180degree') && !$('#cgImgThumb').hasClass('cg270degree')){
            $('#cgImgThumb').addClass('cg90degree');
            $('#rThumb').val(90);
        }
        else if($('#cgImgThumb').hasClass('cg90degree')){
            $('#cgImgThumb').removeClass('cg90degree');
            $('#cgImgThumb').addClass('cg180degree');
            $('#rThumb').val(180);
        }
        else if($('#cgImgThumb').hasClass('cg180degree')){
            $('#cgImgThumb').removeClass('cg180degree');
            $('#cgImgThumb').addClass('cg270degree');
            $('#rThumb').val(270);
        }
        else if($('#cgImgThumb').hasClass('cg270degree')){
            $('#cgImgThumb').removeClass('cg270degree');
            $('#rThumb').val(0);
        }
    });
    $(document).on('click','#cgResetThumb',function () {
        $('#cgImgThumb').removeClass('cg90degree');
        $('#cgImgThumb').removeClass('cg180degree');
        $('#cgImgThumb').removeClass('cg270degree');
        $('#rThumb').val(0);
    });

});