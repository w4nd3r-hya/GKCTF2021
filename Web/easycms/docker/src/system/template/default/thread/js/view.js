$(document).ready(function()
{
    $.setAjaxForm('#replyForm', function(response)
    {
        if(response.result == 'success')
        {
            if(!v.isCurrentPage && (v.discussion == '0' || (v.discussion == '1' && response.replyID == 0)))
            {
                bootbox.dialog(
                {  
                    message: response.replySuccess,  
                    buttons:
                    {  
                        lastPage:
                        {  
                            label:     v.viewReplies,
                            className: 'btn-primary',  
                            callback:  function(){location.href = response.locate;}  
                        },
                        back:
                        {  
                            label:     v.stayCurrent,  
                            className: 'btn-primary',  
                            callback:  function(){location.href = removeAnchor(location.href);}  
                        }  
                    }  
                });
            }
            else
            {
                $('#submit').popover({container: 'body', trigger:'manual', content:response.replySuccess, placement: 'right', tipClass: 'popover-success  popover-ajaxform'}).popover('show');
                setTimeout(function(){$('#submit').popover('destroy');}, 2000);
                setTimeout(function(){location.href = response.locate;}, 1200);
            }
        }
        else
        {
            if(response.reason == 'needChecking')
            {
                $('#captchaBox').html(Base64.decode(response.captcha)).show();
            }
        }
    });

    $.setAjaxForm('#addScoreForm');

    $.setAjaxJSONER('.switcher', function(response){ bootbox.alert(response.message, function(){location.href = response.locate; return false;});});
    $('.nav-system-forum').addClass('active');

    /* remove empty element */
    $('.speaker > ul > li > span:empty').closest('li').remove();

    $('.thread-reply-btn').click(function()
    {
        if($(this).data('reply')) $('input[name=reply]').val($(this).data('reply'));
    })

    $(document).on('click', '.quote', function()
    {
        if($(this).parents('.alert-replies').length)
        {
            var $quote = $(this).parents('.thread-content');
            var date   = $quote.find('.reply-date').html();
            var user   = $quote.find('.reply-author').html().replace('\：', '');
            var quoteTitle = v.quoteTitle.replace('\%\s', user).replace('\%\s', date);

            var quoteContent = '[quote]';
            quoteContent += quoteTitle;
            quoteContent += $quote.find('.reply-content').html();
            quoteContent += '[/quote]';
        }
        else
        {
            var $quote     = $(this).parents('.panel.reply');
            var date       = $quote.find('.panel-heading span.muted').html().replace(/<[^>]+>/g,'');
            var user       = $quote.find('.table .speaker .thread-author').html().replace(/<[^>]+>/g, '');
            var quoteTitle = v.quoteTitle.replace('\%\s', user).replace('%s', date);
            
            var quoteContent = '[quote]';
            quoteContent += quoteTitle;
            quoteContent += $quote.find('.table .thread-wrapper .thread-content').html();
            quoteContent += '[/quote]';
        }

        KindEditor.html('#content', quoteContent);
    })
    
    $('.alert-primary').parent('.reply-content').css('display', 'block');
});
