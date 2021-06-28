$(document).ready(function()
{
    $.setAjaxForm('#setSystemForm', function(response)
    {
        if(response.reason == 'captcha')
        {
            $('.captchaModal').click();
        }
        if('success' == response.result) 
        {
          $.get(location.href, function(){window.location.reload();});
        }
    });

    $('[name^=requestType]').change(function()
    {
        if(!$('[value=PATH_INFO]').prop('checked') && v.requestType == 'pathinfo')
        {
            $('#requestTypeTip').fadeIn();
        }
        else
        {
            $('#requestTypeTip').hide();
        }
    });

    $('[name^=requestType]').change();
});
