$(document).ready(function()
{
    /* Set current active moduleMenu. */
    if(typeof(v.path) != 'undefined')
    {
        $('.leftmenu li.active').removeClass('active');
        $.each(v.path, function(index, bookID) 
        { 
            $(".book-list a[href$='bookID=" + bookID + "']").parent().css('font-weight', 'bold');
        })
    }
    else
    {
        $(".book-list a[href*='" + config.currentMethod + "']").css('font-weight', 'bold');
    }
});
