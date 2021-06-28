$(document).ready(function()
{
    $( document ).on( 'click', '.finisher', function()
    {
        confirmLink = $(this).data('rel');
        bootbox.confirm(v.finishWarning, function(result)
        {
            if(!result) return true;
            $.getJSON(confirmLink, function (response)
            {
                if(response.result == 'success')
                {
                    bootbox.alert(response.message, function(){ location.reload(); });
                }
            })
        });
        return true;
    });
    setTimeout(function(){fixedTheadOfList('#orderList')}, 100);
    function fixedTheadOfList(tableID)
    {
        if($(tableID).size() == 0) return false;
        if($(tableID).css('display') == 'none') return false;
        if($(tableID).find('thead').size() == 0) return false;
    
        fixTheadInit();
        $(window).scroll(fixThead);//Fix table head when scrolling.
        $('.side-handle').click(function(){setTimeout(fixTheadInit, 300);});//Fix table head if module tree is hidden or displayed.
    
        var tableWidth, theadOffset, fixedThead, $fixedThead;
        function fixThead()
        {
            theadOffset = $(tableID).find('thead').offset().top;
            $fixedThead = $(tableID).parent().find('.fixedTheadOfList');
            if($fixedThead.size() <= 0 &&theadOffset < $(window).scrollTop())
            {
                tableWidth  = $(tableID).width();
                fixedThead  = "<table class='fixedTheadOfList'><thead>" + $(tableID).find('thead').html() + '</thead></table>';
                $(tableID).before(fixedThead);
                $('.fixedTheadOfList').addClass($(tableID).attr('class')).width(tableWidth);
            }
            if($fixedThead.size() > 0 && theadOffset >= $(window).scrollTop()) $fixedThead.remove();
        }
        function fixTheadInit()
        {
            $fixedThead = $(tableID).parent().find('.fixedTheadOfList');
            if($fixedThead.size() > 0) $fixedThead.remove();
            fixThead();
        }
    }
})
