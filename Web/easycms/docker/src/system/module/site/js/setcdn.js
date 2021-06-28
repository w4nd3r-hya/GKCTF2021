$(document).ready(function()
{
    $('input[name=open]').change(function()
    {
        $('.cdn-host').toggle($('#open1').prop('checked'));
    });
    $('input[name=open]').change();
    $.setAjaxForm('#cdnForm', function(response)
    {
        if(response.result != 'success')
        {
            if(response.message.length)
            {
                $.each(response.message, function(key, file)
                {
                    $('#messageBox').append(file + '<br>').parent().show();
                })
            }
        }
    });
    $('#cdnForm input').change(function(){ $('#messageBox').html('').parent().hide();});
    $('.cdnreseter').click(function()
    {
        $('#messageBox').html('').parent().hide();
        $('#site').val($('#site').data('default'));
    })
})
