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

    /* Change set lang imput. */
    $('input[type=checkbox]').change(function()
    {
        if($('input[type=checkbox][value=zh-cn]').prop('checked') && $('input[type=checkbox][value=zh-tw]').prop('checked'))
        {
            $('#twTR').show();
        }
        else
        {
            $('#twTR').hide();
        }

        $('input[type=checkbox]').each(function()
        {
            checked = $(this).prop('checked');
            lang = $(this).val();
            if(!checked)
            {
                $('#defaultLang').find('[value=' + lang  + ']').prop('disabled', true);
            }
            else
            {
                $('#defaultLang').find('[value=' + lang  + ']').prop('disabled', false);
            }
        })
    });

    $('input[type=checkbox]').change();
});
