$(function()
{
    $('.media-placeholder').each(function()
    {
        var $this = $(this);
        $this.attr('style', 'background-color: hsl(' + $this.data('id') * 57 % 360 + ', 80%, 90%)');
    });

    $('[data-toggle="tooltip"]').tooltip({container: 'body'});

    $(document).on('click', '#modeControl a', function()
    {
        $('#modeControl a').removeClass('active');
        $(this).addClass('active');
        $('#modeControl').parents('.list-condensed').find('section').hide();
        $('#' + $(this).data('mode') + 'Mode').show();
    })

    $('a[data-mode=' + v.defaultMode  + ']').click();

    $('.price').each(function()
    {
         if($(this).find('strong').length > 0)
         {
             $('.price').css('height', '30px');
             return false;
         }
    });
    
    var fieldName = 'order';
    var orderType = 'desc';
    $(document).on('click', '.setOrder', function()
    {
        if($(this).data('field') == fieldName)
        {
            orderType = orderType == 'asc' ? 'desc' : 'asc';
            fieldName = $(this).data('field');
        }
        else
        {
            orderType = 'desc';
            fieldName = $(this).data('field');
        }

        $.cookie('productOrderBy[' + v.categoryID + ']', fieldName + '_' + orderType);

        r = Math.ceil(Math.random() * 1000000);
        url = location.href;
        url = url.indexOf('r=') != -1 ? url.substring(0, url.indexOf('r=') - 1) : url;
        if(config.requestType == 'GET' && url.indexOf('pageID') < 0) url = url + '&pageID=1';
        url = config.requestType == 'GET' ? url + '&r=' + r + ' #products' : url + '?r=' + r + ' #products';
        $('#mainContainer').load(url, function(){ setSorterClass()});

        $('#mainContainer').load(url, function()
        {
            setSorterClass()
            $('.pager > a').each(function()
            {
                href = $(this).attr('href');
                if(href.indexOf('r=') < 0) return true;
                $(this).attr('href', href.substring(0, href.indexOf('r=') - 1));
            });
        });
    });

    function setSorterClass()
    {
        if(orderType == 'asc')
        {
            $("[data-field=" + fieldName + "]").parent().removeClass('header').addClass('headerSortUp');
        }
        if(orderType == 'desc')
        {
            $("[data-field=" + fieldName + "]").parent().removeClass('header').addClass('headerSortDown');
        }
        $('#modeControl').find('[data-mode=' + type +']').click();
    }
})
