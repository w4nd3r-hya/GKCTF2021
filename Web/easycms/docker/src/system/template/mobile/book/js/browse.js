$(document).ready(function()
{
    function scrollCenter()
    {
        var left = $('.book.active').position().left;
        $('.book-nav').scrollLeft(left - $(window).width()/2 + $('.book.active').width()/2);
    }
    scrollCenter();

    $(document).on('click', '.chapter', function()
    {
        $('.chapter').removeClass('active');
        $('.down-triangle').removeClass('active');
        $('.article').removeClass('active');
        $(this).addClass('active');
        $(this).parent().parent().parent().siblings().children('details').removeAttr('open');
        if($(this).parent().parent().attr('open') === false) $(this).find('.down-triangle').addClass('active');
    });

    $(document).on('click', '.article', function()
    {
        $('.article').removeClass('active');
        $(this).addClass('active');
    });
});
