jQuery(document).ready(function($) {

    /* ==========================================================================
       Inferno globally
       ========================================================================== */

    /* Form elements
       ========================================================================== */
    $("#inferno-canvas .radio, .inferno-meta-box .radio").buttonset();


    /* Upload button
       ========================================================================== */
    $('#inferno-canvas .media .button-upload, .inferno-meta-box .media .button-upload').live('click', function() {
        $element = $(this);
        window.send_to_editor = function(html) {
            imgurl = $('img', html).attr('src');
            $element.parent().find('input[type="hidden"]').val(imgurl);
            $element.parent().find('.media-preview').html('<img src="' + $element.parent().find('input[type="hidden"]').val() + '" alt="" />');
            tb_remove();
        };
        tb_show('', 'media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true');
        return false;
    });


    /* Image picker
       ========================================================================== */
    $('.imagepicker select').imagepicker();


    /* Google webfonts button
       ========================================================================== */
    $('#inferno-canvas .googlefont-desc, #inferno-canvas .googlefont-setting, #inferno-canvas .button.googlefont.hide').hide();
    $('#inferno-canvas .button.googlefont.hide').hide();
    $('#inferno-canvas .button.googlefont').live('click', function() {
        var btn = $(this);
        var googlefonts_container = btn.parent().parent().find('.googlefont-desc, .googlefont-setting');
        btn.parent().find('.button.googlefont').css({ display: 'none' });
        if(btn.hasClass('hide')) {
            btn.parent().find('.button.googlefont.show').css({ display: 'inline-block' });
            googlefonts_container.slideUp(200);
        } else if(btn.hasClass('show')) {
            btn.parent().find('.button.googlefont.hide').css({ display: 'inline-block' });
            googlefonts_container.slideDown(200);
        }           
    });
    $('#inferno-canvas .button.googlefont.hide').live('click', function() {
        var googlefonts_container = $(this).parent().parent().find('.googlefont-desc, .googlefont-setting');
        $(this).parent().find('.button.googlefont.show').show();
        $(this).hide();
        googlefonts_container.slideUp(200);            
    });

    $('#inferno-canvas .googlefont-setting input').live('keyup', function(){
        var google_font = $(this).val().split(' ').join('+');
        $(this).parent().find('.googlefont-link').attr('href', 'http://fonts.googleapis.com/css?family=' + google_font);
        $(this).parent().find('.googlefont-canvas').attr('style', 'font-family: \'' + $(this).val() + '\' !important;');
    });

    /* ==========================================================================
       Inferno Canvas
       ========================================================================== */

    /* Tabs
       ========================================================================== */
    $("#inferno-canvas").tabs({
        hide: { effect: 'fadeOut', duration: 150 },
        show: { effect: 'fadeIn', duration: 150 }
    });

    /* Ajax form
       ========================================================================== */
    function successResponse(responseText, statusText, xhr, $form) {
        $('.inferno-message.ajax.success').show(250);
        $('.inferno-message.ajax.success i').animate({ fontSize: '30px' }, 200);
        $('.inferno-message.ajax.success p').animate({ fontSize: '12px' }, 200);
        setTimeout(function() {
            $('.inferno-message.ajax.success').hide(250);
            $('.inferno-message.ajax.success i').animate({ fontSize: '0px' }, 200);
            $('.inferno-message.ajax.success p').animate({ fontSize: '0px' }, 200);
        }, 5000);
    }

    function errorResponse() {
        $('.inferno-message.ajax.error').show(250);
        $('.inferno-message.ajax.error i').animate({ fontSize: '30px' }, 200);
        $('.inferno-message.ajax.error p').animate({ fontSize: '12px' }, 200);
        setTimeout(function() {
            $('.inferno-message.ajax.error').hide(250);
            $('.inferno-message.ajax.error i').animate({ fontSize: '0px' }, 200);
            $('.inferno-message.ajax.error p').animate({ fontSize: '0px' }, 200);
        }, 5000);
    }

    function showRequest(formData, jqForm, options) {
        // formData is an array; here we use $.param to convert it to a string to display it 
        // but the form plugin does this for you automatically when it submits the data 
        var queryString = $.param(formData);
     
        // jqForm is a jQuery object encapsulating the form element.  To access the 
        // DOM element for the form do this: 
        // var formElement = jqForm[0]; 
     
        alert('About to submit: \n\n' + queryString);
     
        // here we could return false to prevent the form from being submitted; 
        // returning anything other than false will allow the form submit to continue 
        return true;
    }

    $('#inferno-panel-form').ajaxForm({
        beforeSubmit: ($('#inferno-panel-form').data('debug') === true ? showRequest : null),
        success: successResponse,
        error: errorResponse
    });

    /* Reset button
       ========================================================================== */
    $('#inferno-canvas .media .button-reset').live('click', function(){
        $container = $(this).parent();
        $container.find('.media-preview img').hide(200);
        $container.find('input[type="hidden"]').val('');
    });

    /* Advanced mode
       ========================================================================== */
    $('#inferno-canvas .field.advanced').slideUp(0);
    $('#inferno-canvas button.advanced-mode').live('click', function(e){
        e.preventDefault();
        var btn = $(this);
        if(btn.hasClass('inactive')) {
            btn.removeClass('inactive').addClass('active');
            $('#inferno-canvas .field.advanced').slideDown(200);
        } else if(btn.hasClass('active')) {
            btn.removeClass('active').addClass('inactive');
            $('#inferno-canvas .field.advanced').slideUp(200);
        }
    });


    /* ==========================================================================
       Inferno Shortcode Generator
       ========================================================================== */

    $(document).ajaxComplete(function() {
        $("#inferno-generator .radio").buttonset();
    });

    $("#inferno-generator-insert").live('click', function(){
        $inferno_shortcode_result = $("#inferno-generator-result");
        $inferno_shortcode_select = $("#inferno-generator-select");
        $inferno_shortcode_result.val(""); // flush
        var inferno_shortcode_only_atts = $("#inferno-shortcode-only-atts").val() === 'true' ? true : false;
        var inferno_shortcode_content_att = $("#inferno-shortcode-content-att").val() !== '' ? $("#inferno-shortcode-content-att").val() : false;


        $("#inferno-generator .inferno-setting").each(function(){
            $setting = $(this);
            if($setting.val()) {
                $inferno_shortcode_result.val($inferno_shortcode_result.val() + ' ' + $setting.attr('name') + '="' + $setting.val() + '"');
            }
        });
        $inferno_shortcode_result.val('[' + $inferno_shortcode_select.val() + ' ' + $inferno_shortcode_result.val() + ']');
        if(!inferno_shortcode_only_atts) $inferno_shortcode_result.val($inferno_shortcode_result.val() + '[' + $inferno_shortcode_select.val()  + ']');

        var shortcode = $inferno_shortcode_result.val();
        window.send_to_editor(shortcode);
        tb_remove();

        // Prevent default action
        event.preventDefault();
        return false;
    });
});