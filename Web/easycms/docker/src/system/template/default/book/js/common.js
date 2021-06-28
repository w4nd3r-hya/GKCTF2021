$(document).ready(function()
{
    $('.nav-system-book').addClass('active');
    $('#article' + v.objectID).addClass('active');
    if(v.fullScreen)
    {
        $('html, body').css('height', '100%');

        curPos = sessionStorage.getItem('curPos');
        if(curPos) $('.fullScreen-catalog').animate({scrollTop: curPos}, 0);

        $('.article').click(function(){sessionStorage.setItem('curPos', $('.fullScreen-catalog').scrollTop());});
    }
});
