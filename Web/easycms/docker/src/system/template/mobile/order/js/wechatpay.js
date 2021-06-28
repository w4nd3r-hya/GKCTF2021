function onBridgeReady()
{
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest',
        v.payConfig,
        function(res)
        {
            if(res.err_msg == "get_brand_wcpay_request:ok" ) checkPay();
        }
    );
}

if (typeof WeixinJSBridge == "undefined")
{
    if( document.addEventListener )
    {
        document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
    }
    else if (document.attachEvent)
    {
        document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
        document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
    }
}
else
{
    onBridgeReady();
}

if(window.navigator.userAgent.toLowerCase().match(/MicroMessenger/i) != 'micromessenger')
{
    if(v.type != 'referer')
    {
        window.location.href = v.openLink;
    }
}

$('.paid').click(checkPay());

function checkPay()
{
    $.getJSON($('.paid').attr('rel'), function(data){
        if(data.return_code == 'SUCCESS')
        {
            if(data.trade_state == 'SUCCESS')
            {
                window.location.href = v.orderLink;
            }
        }
    })
}
