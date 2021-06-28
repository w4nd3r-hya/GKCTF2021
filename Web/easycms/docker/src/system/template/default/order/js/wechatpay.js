$(document).ready(function ()
{
    if(v.payStatus != 'paid')
    {
        setInterval(function()
        {
            $.getJSON(createLink('order', 'ajaxQuery', 'orderID=' + v.orderID + '&tradeID=' + v.tradeID), function(data)
            {
                if(data.return_code == 'SUCCESS' && data.trade_state == 'SUCCESS') window.location.reload();
            })
        }, 5000);
    }
});
