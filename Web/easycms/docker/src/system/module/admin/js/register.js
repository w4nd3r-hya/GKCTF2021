$(document).ready(function()
{
    $.setAjaxForm('#registerForm');
    $.setAjaxForm('#bindForm');
    $('#bindPanel').height($('#registerPanel').height());
    $('#rebindBtn').click(function()
    {
        bootbox.confirm(v.lang.confirmRebind, function(result)
        {
            if(result) location.href = $('#rebindBtn').attr('href');
        });    
        return false;
    });

    $(document).on('click', '#smsSender', function()
    {
        if(!$('#mobile').val()) return false;
        url = createLink('admin', 'getMobileCodeByApi', "mobile=" + $('#mobile').val());
        $.getJSON(url, function(response)
        {
            if(response.result == 'success')
            {
                 $('#smsSender').popover({trigger:'manual', content:response.message, placement:'right'}).popover('show');
                 $('#smsSender').next('.popover').addClass('popover-success');
                 function distroy(){$('#smsSender').popover('destroy')}
                 setTimeout(distroy,3000);
            }
            else
            {
                bootbox.alert(response.message);
            }
        });
        return false;
    });

    $(document).on('click', '#mailSender', function()
    {
        if(!$('#email').val()) return false;
        url = createLink('admin', 'getEmailCodeByApi', "email=" + $('#email').val());
        $.getJSON(url, function(response)
        {
            if(response.result == 'success')
            {
                 $('#mailSender').popover({trigger:'manual', content:response.message, placement:'right'}).popover('show');
                 $('#mailSender').next('.popover').addClass('popover-success');
                 function distroy(){$('#mailSender').popover('destroy')}
                 setTimeout(distroy,3000);
            }
            else
            {
                bootbox.alert(response.message);
            }
        });
        return false;
    });
   
    $('#mobile').change(function()
    {
        if($(this).val() == v.certifiedMobile && v.certifiedMobile)
        {
            $(this).parents('tr').find('.certified').show();
            $('#mobileCode').parents('td').hide();
            $(this).parents('tr').find('.uncertified').hide();
        }

        if($(this).val() != v.certifiedMobile)
        {
            $(this).parents('tr').find('.certified').hide();
            $(this).parents('tr').find('.uncertified').show();
            $('#mobileCode').parents('td').show();
        }
    });

    $('#email').change(function()
    {
        if($(this).val() == v.certifiedEmail && v.certifiedEmail)
        {
            $(this).parents('tr').find('.certified').show();
            $(this).parents('tr').find('.uncertified').hide();
            $('#emailCode').parents('td').find('div').hide();
        }

        if($(this).val() != v.certifiedEmail || !v.certifiedEmail)
        {
            $(this).parents('tr').find('.certified').hide();
            $(this).parents('tr').find('.uncertified').show();
            $('#emailCode').parents('td').find('div').show();
        }
    });

    $('#mobile').change();
    $('#email').change();
});
