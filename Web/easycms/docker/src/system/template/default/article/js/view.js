$(document).ready(function()
{
    function basename(str)
    {
        var pos = str.lastIndexOf('/');
        return str.substring(pos + 1,str.length);
    }

    $('body').tooltip(
    {
        html: true,
        selector: "[data-toggle=tooltip]",
        container: "body"
    }); 

    $('.article-content img').click(function(){
        var itemSrc  = $(this).attr('src');
        var itemName = basename(itemSrc).split('.')[0];
        if(typeof(itemName) == 'string')
        {
            $('.article-files .' + itemName).click();
        }
    });

    if($('.previous > a > span').width() > $('.previous > a').width())
    {
        previousSpanWidth = $('.previous > a').width() - $('.previous .icon-arrow-left').width() - 5;
        $('.previous > a > span').css('width', previousSpanWidth);
    }

    if($('.next > a > span').width() > $('.next > a').width())
    {
        nextSpanWidth = $('.next > a').width() - $('.next .icon-arrow-right').width() - 5;
        $('.next > a > span').css('width', nextSpanWidth);
    }
});
