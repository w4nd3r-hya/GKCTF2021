$(document).ready(function()
{
    $(document).on('click', 'input[name=sticky]', function()
    {
        if($('#sticky1').prop('checked'))
        {
            $(this).parents('tr').nextUntil("tr:last-child").hide();
        }
        else
        {
            $(this).parents('tr').nextUntil("tr:last-child").show();
        }
    });
})
