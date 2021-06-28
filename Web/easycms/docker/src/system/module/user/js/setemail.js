$(document).ready(function()
{
    appendFingerprint('#emailForm');
    $('#mailSender').click(function()
    {
        text = $(this).text();
        $(this).text(v.sending);
        var data = {email: $('#email').val()};
        var url = $(this).attr('href');

        $.post(url, data, function(response)
        {
            if(response.result == 'success')
            {
               $('#responser').html(response.message).show();
               $('#mailSender').hide();
            }
            else
            {
                bootbox.alert(response.message);
                $('#mailSender').text(text).prop('disabled', false);
            }
        }, 'json')

        $('#mailSender').attr('disabled', 'disabled');
        return false;
    });
    $.setAjaxForm('#emailForm', function(response)
    {
        if('success' == response.result) window.location.reload();
    });
})
