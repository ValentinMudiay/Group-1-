jQuery(document).ready(function($){

    // copy show tooltip

    $(document).on('mouseenter','.cg_tooltip',function () {

        if($(this).closest('.cg_shortcode_parent').attr('id')=='cgDeleteZipFileHintContainer'){
            $(this).append('<span class="cg_tooltiptext" style="width: 140px;margin-left:-71px;">Copy zip file link</span>');
        }
        else{
            $(this).append('<span class="cg_tooltiptext">Copy</span>');
        }

    });

    $(document).on('mouseleave','.cg_tooltip',function () {

        $(this).find('.cg_tooltiptext').remove();

    });

    $(document).on('click','.cg_tooltip',function () {

        var $containerWithToCopyValue = $(this).parent().find('.cg_shortcode_copy_text');

        if($containerWithToCopyValue.is('input')){
            var copyText = $containerWithToCopyValue.val();
        }else{
            var copyText = $containerWithToCopyValue.text();
        }

        var el = document.createElement('textarea');
        el.value = copyText;
        el.setAttribute('readonly', '');
        el.style.position = 'absolute';
        el.style.left = '-9999px';
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);

        $(this).find('.cg_tooltiptext').text('Copied');

    });


    // show cg-info

    $(document).on('mouseenter','.cg-info-icon',function () {
        $(this).parent().find('.cg-info-container').first().show();

    });

    $(document).on('mouseleave','.cg-info-icon',function () {

        $(this).parent().find('.cg-info-container').first().hide();

    });



});