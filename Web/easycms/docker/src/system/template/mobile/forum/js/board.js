$(function()
{
    $('.operations .trigger').on('click', function ()
    {
        var options = $(this).parent().children('.options');
        if(options.hasClass('hidden'))
        {
            $(this).addClass('active');
            options.removeClass('hidden');
        }
        else
        {
            $(this).removeClass('active');
            options.addClass('hidden');
        }
    });
});