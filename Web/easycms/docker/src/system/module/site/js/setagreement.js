$(document).ready(function()
{
    $('[name=agreement]').change(function()
    {
        var agreement = $('[name=agreement]:checked').val(); 
        if(agreement == 'close')
        {
            $('#agreementTitle').parents('tr').addClass('hide');
            $('#agreementContent').parents('tr').addClass('hide');
        }
        else
        {
            $('#agreementTitle').parents('tr').removeClass('hide');
            $('#agreementContent').parents('tr').removeClass('hide');
        }
    });

    $('[name=agreement]').change();
});
