/* Keep session random valid. */
needPing = true;
$('#submit').click(function()
{
    var loginText = $(this).val();
    $(this).val($(this).data('loading'));
    var password = $('#password').val();
    var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
    var hasCaptcha = false;
    if(!reg.test($('#account').val())) password = md5(md5(md5($('#password').val()) + $('#account').val()) + v.random);
    if($('.captcha').size() > 0)
    {
        hasCaptcha = true;
        captchaInput = $('.captcha:last input:text').attr('id');
    }

    fingerprint = getFingerprint();

    loginURL = createLink('user', 'login');
    postData = "account=" + $('#account').val() + '&password=' + password + '&referer=' + encodeURIComponent($('#referer').val()) + '&fingerprint=' + fingerprint;
    if(hasCaptcha) postData += '&' + captchaInput + '=' + $('#' + captchaInput).val();
    $.ajax(
    {
        type: "POST",
        data: postData,
        url:loginURL,
        dataType:'json',
        success:function(data)
        {
            $('#submit').val(loginText);
            if(data.result == 'success') return location.href=data.locate;
            postData = "account=" + $('#account').val() + '&password=' + $('#password').val() + '&referer=' + encodeURIComponent($('#referer').val()) + '&fingerprint=' + fingerprint;
            if(hasCaptcha) postData += '&' + captchaInput + '=' + $('#' + captchaInput).val();
            $.ajax(
            {
                type: "POST",
                data: postData,
                url:loginURL,
                dataType:'json',
                success:function(data)
                {
                    if(data.result == 'fail') showFormError(data.message);
                    if(data.result == 'success') location.href=data.locate;
                    if(typeof(data) != 'object') showFormError(data);
                },
                error:function(data){showFormError(data.responseText);}
            })
        },
        error:function(data){showFormError(data.responseText); $('#submit').val(loginText);}
    })
    return false;
});

function showFormError(text)
{
    var error = $('#formError').text(text);
    var parent = error.closest('.form-group');
    if(parent.length) parent.show();
    else error.show();
}
