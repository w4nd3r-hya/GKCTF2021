$(document).ready(function()
{
    var height = 0;
    $('.card').each(function()
    {
        if($(this).height() > height) height = $(this).height();
    });

    $('.card').css('height', height);
})
