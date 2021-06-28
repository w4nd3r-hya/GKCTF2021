$(document).ready(function()
{
    $.setAjaxForm('#mailForm', function(response)
    {
        if(response.result == 'fail' && typeof(response.error != 'undefined'))
        {
            $('.panel-notice').removeClass('hide');
            $('#result').html(response.error);
        }
        return false;
    });
});
