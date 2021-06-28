$(document).ready(function()
{
    $.setAjaxForm('#editForm');

    $('#isLink').change(function()
    {   
        if($(this).prop('checked'))
        {   
            $('.categoryInfo').hide();
            $('.link').show();
        }   
        else
        {   
            $('.categoryInfo').show();
            $('.link').hide();
        }   
    }); 

    $('#isLink').change();
});
