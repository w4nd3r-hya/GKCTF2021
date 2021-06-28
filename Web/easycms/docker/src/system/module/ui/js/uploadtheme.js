$(document).ready(function()
{
    $.setAjaxForm('#uploadForm', function(response) 
    {
        if(response.result == 'success')
        {
            setTimeout(function()
            {
                $('#ajaxModal').attr('ref', response.locate).load(response.locate, function()
                {
                    $.ajustModalPosition();
                });
            }, 3000);
        }
    });

    $.setAjaxLoader('.okFile', '#ajaxModal');

    $('[name=type]').change(function()
    {
        if($(this).val() == 'full') 
        {
            $('#typeTip').text( v.lang.fullImportTip );
        }
        else
        {
            $('#typeTip').text( v.lang.importTip );
        }
    })
});
