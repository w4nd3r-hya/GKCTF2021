$(document).ready(function()
{
    $('body').tooltip(
    {
         html: true,
         selector: "[data-toggle=tooltip]",
         container: "body"
    });  

    /* Scroll function. */
    function yrScroll()
    {
         if( $("#book").offset()) var headerHeight = $("#book").offset().top;
         if( $('.col-md-9').offset()) { var footerHeight = $('.col-md-9').offset().top + $('.col-md-9').height() - $(window).height();}

         var listTitleHeight = $(".book-catalog .panel-heading").height();

         var catalogWidth  = $('.book-catalog').width();
         var catalogHeight = $(window).height() - 10;
         $(".book-catalog").css({'max-height': catalogHeight, 'overflow-y': 'auto', 'overflow-x': 'hidden'});

         if($('.books .active').length)
         {
             var listScrollTop =  $(".books .active").position().top;
             var listMoveSize = listScrollTop > ( $(".bookScrollListsBox").height() - listTitleHeight ) / 2 ? listScrollTop : 0;
             var scrollMoveSize = listMoveSize / $(".books").height(); 
             $(".bookScrollListsBox").scrollTop
             (
                 $(".bookScrollListsBox .books").height() * scrollMoveSize -($(".bookScrollListsBox").height() / 2 - $(".bookScrollListsBox .panel-heading").height() - 47)
             );
         }


         /* Bind scroll event */
         $(document).on("scroll", function ()
         {
              $(".page-wrapper").css({"min-height":$(".book-catalog").height()})
              if($(document).scrollTop() > headerHeight )
              {
                   $('.book-catalog').css({'position': 'fixed', 'top':'0', 'width': catalogWidth});

                   if($(document).scrollTop() > footerHeight)
                   {
                       catalogHeight2 = $(window).height() - $('.blocks.all-bottom').outerHeight() - $('#footer').outerHeight() - 60;
                       $('.book-catalog').css({'max-height': catalogHeight2, 'overflow-y': 'auto', 'overflow-x': 'hidden'});
                   }
                   else
                   {
                       $('.book-catalog').css({'max-height': catalogHeight, 'overflow-y': 'auto', 'overflow-x': 'hidden'});
                   }
              }
              else if( $(document).scrollTop() < headerHeight )
              {
                   $('.book-catalog').css({'position': 'relative' });
              }
         });
    };
    yrScroll();

    $('.previous > a, .next > a').css('max-width', (($('.pager').width() - $('.pager > .back > a').width()) * 0.45));

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
