$(document).ready(function()
{
    $('[name*=payment]').change(function()
    {
        if($('[name*=payment][value=alipay]').prop('checked'))
        {
            $('.alipay-item').show();
        }

        if($('[name*=payment][value=wechatpay]').prop('checked'))
        {
            $('.wechatpay-item').show();
        }

        if($('[name*=payment][value=alipaySecured]').prop('checked'))
        {
            $('.alipay-item').show();
        }

        if($('[name*=payment][value=paypal]').prop('checked'))
        {
            $('.paypal-item').show();
        }

        if(!$('[name*=payment][value=alipay]').prop('checked') && !$('[name*=payment][value=alipaySecured]').prop('checked')) $('.alipay-item').hide();
        if(!$('[name*=payment][value=wechatpay]').prop('checked')) $('.wechatpay-item').hide();
        if(!$('[name*=payment][value=paypal]').prop('checked')) $('.paypal-item').hide();
    })
    $('[name*=payment]').change();
})
