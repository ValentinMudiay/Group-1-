var contGallSubmitLoaderShow = function ($,$field) {

    // position for loader will be calculated
    var $loader = $field.parent().find('.cg_form_div_image_upload_preview_loader_container');
    var widthSubmitButton = $field.width();
    var heightSubmitButton = $field.height();
    /*            console.log('width')
                console.log($field.position().left);
                console.log(parseInt($field.css('marginLeft')));*/
    $loader.css('visibility','hidden');
    $loader.removeClass('cg_hide');
    /*            console.log($field.outerWidth());
                console.log($loader.outerWidth());
                console.log('height')
                console.log($field.position().top);
                console.log(parseInt($field.css('marginTop')));
                console.log($field.outerHeight());
                console.log($loader.outerHeight());*/
    var left = $field.position().left+parseInt($field.css('marginLeft'))+($field.outerWidth()/2-$loader.outerWidth()/2);
    var top = $field.position().top+parseInt($field.css('marginTop'))+(($field.outerHeight()-$loader.outerHeight())/2);
    $field.val('');
    $field.width(widthSubmitButton);
    $field.height(heightSubmitButton);
    $field.addClass('cg_pointer_events_none');
    $loader.css({
        'top' : top+'px',
        'left' : left+'px',
        'visibility' : 'visible',
    }).addClass('cg_pointer_events_none');


};

var contGallSubmitLoaderHide = function ($,$field,value) {

    $field.removeClass('cg_pointer_events_none');
    $field.val(value);
    var $loader = $field.parent().find('.cg_form_div_image_upload_preview_loader_container');
    $loader.addClass('cg_hide');

};