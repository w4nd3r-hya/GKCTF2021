$(document).ready(function()
{
    $('#clearButton').click(function()
    {
        $(this).text(v.clearing);
       
        var submitButton = $(this);
        $.getJSON($(this).attr('href'), function(response)
        {
            if(response.result == 'success')
            {
                $('#clearButton').text(v.clear);
                submitButton.popover({trigger:'manual', content:v.cleared, placement: 'right', tipClass: 'popover-success popover-ajaxform'}).popover('show');
                setTimeout(function(){submitButton.popover('destroy');}, 3000);
                return true;
            }
            else
            {
                $('#clearButton').text(response.message).removeClass('btn-primary').addClass('btn-danger');
                $('#clearButton').attr("disabled","disabled")
                $('#saveCacheSetting').after(v.clearCacheTip);
                return false;
            }
        });
        return false;
    });
});
