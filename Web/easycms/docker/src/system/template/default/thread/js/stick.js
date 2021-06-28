$(document).ready(function()
{
    $(document).on('click', 'input[name=stick]', function()
    {
        if($('#stick1').prop('checked'))
        {
            $(this).parents('tr').nextUntil("tr:last-child").hide();
        }
        else
        {
            $(this).parents('tr').nextUntil("tr:last-child").show();
        }
    });
})
