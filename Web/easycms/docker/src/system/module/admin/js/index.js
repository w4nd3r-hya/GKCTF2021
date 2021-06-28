$(document).ready(function()
{
    $.cookie('currentGroup', 'home', {expires:config.cookieLife, path:config.cookiePath});
});

/**
 * index new order module,finisher button
 * click event
 */
 $(document).ready(function()
{
    $(document).on( 'click', '.finisher', function()
    {
        confirmLink = $(this).data('rel');
        $.getJSON(confirmLink, function (response)
        {
            if(response.result == 'success')
            {
                bootbox.alert(response.message, function(){ location.reload(); });
            }
        });
        return true;
    });
});

/**
 * Delete widget.
 * 
 * @param  int    $index 
 * @access public
 * @return void
 */
function deleteWidget(index)
{
    $.getJSON(createLink('widget', 'delete', 'index=' + index), function(data)
    {   
        if(data.result != 'success')
        {   
            alert(data.message);
            return false;
        }
        else {checkEmpty();}
    })  
}

/**
 * Sort widgets.
 * 
 * @param  object $orders  format is {'widget2' : 1, 'widget1' : 2, oldOrder : newOrder} 
 * @access public
 * @return void
 */
function sortWidgets(orders)
{

    var ordersMap = [];
    $.each(orders, function(widgetId, order) {ordersMap.push({id: widgetId, order: order});});
    ordersMap.sort(function(a, b) {return a.order - b.order;});
    var newOrders = $.map(ordersMap, function(order, idx) {return order.id});

    $.getJSON(createLink('widget', 'sort', 'orders=' + newOrders.join(',')), function(data)
    {
        // if(data.result == 'success') $.zui.messager.success(config.ordersSaved);
        location.reload();
    });
}

/**
 * Check dashboard wether is empty
 * @access public
 * @return void
 */
function checkEmpty()
{
    var $dashboard = $('#dashboard');
    var hasWidgets = !!$dashboard.children('.row').children().length;
    $dashboard.find('.dashboard-empty-message').toggleClass('hide', hasWidgets);
}

/**
 * Resize widget
 * @param  object $event
 * @access public
 * @return void
 */
function resizeWidget(event)
{
    var widgetID = event.element.find('.panel').data('id');
    $.getJSON(createLink('widget', 'resize', 'id=' + widgetID + '&grid=' + event.grid), function(data)
    {
        if(data.result !== 'success') event.revert();
    });
}

/**
 * Init table header
 * @access public
 * @return void
 */
function initTableHeader()
{
    $('#dashboard .panel-widget').each(function()
    {
        var $panel = $(this);
        var $table = $panel.find('.table:first');

        if(!$table.length || !$table.children('thead').length) return;

        var $header = $panel.children('.table-header-fixed');
        if(!$header.length)
        {
            $header = $('<div class="table-header-fixed"><table class="table table-fixed"></table></div>').css('right', $panel.width() - $table.width());
            $header.find('.table').addClass($table.attr('class')).append($table.find('thead').css('visibility', 'hidden').clone().css('visibility', 'visible'));
            $panel.addClass('with-fixed-header').append($header);
            var $heading = $panel.children('.panel-heading');
            if($heading.length) $header.css('top', $heading.outerHeight());
        }
    });
}

/**
 * Check refresh progress
 * @param  object $dashboard
 * @access public
 * @return void
 */
function checkRefreshProgress($dashboard, doneCallback)
{
    if($dashboard.find('.panel-loading').length) setTimeout(function() {checkRefreshProgress($dashboard, doneCallback);}, 500);
    else doneCallback();
}

$(function()
{
    var $dashboard = $('#dashboard').dashboard(
    {
        height            : 240,
        draggable         : true,
        shadowType        : false,
        afterOrdered      : sortWidgets,
        afterPanelRemoved : deleteWidget,
        sensitive         : true,
        panelRemovingTip  : config.confirmRemoveWidget,
        resizable         : true,
        onResize          : resizeWidget,
        afterRefresh      : initTableHeader
    });

    $dashboard.find('ul.dashboard-actions').addClass('hide').children('li').addClass('right').appendTo($('#modulemenu > .nav'));
    checkEmpty();
    initTableHeader();
    $('[data-toggle=tooltip]').tooltip({container: 'body'});

    $(document).on('click', '.refresh-all-panel', function()
    {
        var $icon = $(this).find('.icon-repeat').addClass('icon-spin');
        $dashboard.find('.refresh-panel').click();
        checkRefreshProgress($dashboard, function() {$icon.removeClass('icon-spin');});
    });
});
