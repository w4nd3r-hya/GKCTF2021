$(document).ready(function()
{   
    $.setAjaxForm('#fileForm', function(response)
    {
        if(response.result == 'fail')
        {
            if(response.error && response.error.length)
            {
                bootbox.dialog(
                {
                    message: response.error,
                    buttons:
                    {
                        back:
                        {  
                            label:     v.lang.back,
                            className: 'btn-primary',
                            callback:  function(){location.reload();}
                        },
                        'continue':
                        {  
                            label:     v.lang['continue'],
                            className: 'btn-primary',
                            callback:  function()
                            {
                                $('#fileForm #submit').append("<input value='1' name='continue' class='hide'>");
                                $('#fileForm #submit').click();
                            }
                        }
                    }  
                });
            }
        }
        else
        {
            setTimeout(function(){location.href = createLink('file', 'browsesource');}, 1200);
        }
    })

    $('.image-view').click(function()
    {
        $('.image-view').addClass('active');
        $('.list-view').removeClass('active');
        $('#imageView').show();
        $('.batchSelect').show();
        $('#listView').hide();
        $.cookie('sourceViewType', 'image', {path: config.cookiePath});
    });

    $('.list-view').click(function()
    {
        $('.list-view').addClass('active');
        $('.image-view').removeClass('active');
        $('#listView').show();
        $('#imageView').hide();
        $('.batchSelect').hide();
        $.cookie('sourceViewType', 'list', {path: config.cookiePath});
    });

    var type = $.cookie('sourceViewType');
    if(type == '') type = 'image';
    $('.' + type + '-view').click();
    
    $('.file-source input').mouseover(function(){$(this).select()});

    var hasFlash = false;
    try {
          hasFlash = Boolean(new ActiveXObject('ShockwaveFlash.ShockwaveFlash'));
    } catch(exception) {
          hasFlash = ('undefined' != typeof navigator.mimeTypes['application/x-shockwave-flash']);
    }
    if(!hasFlash){ $('.file-url').attr("disabled",false);}
    if(!hasFlash){ $('.copyBtn').click(function(){
      $(this).popover({trigger:'manual', content:v.noFlashTip, placement:'bottom', tipClass:'noflashTip'}).popover('toggle');
      $(this).parent().prev().focus();
    })}

    $('.checkAll').click(function()
    {
        $(this).closest('#' + $(this).val()).find(':checkbox').prop('checked', $(this).prop('checked'));
    });

    $('.batchSelect').click(function()
    {
        $('#imageView .file-source .input-group .input-group-addon').toggleClass('hidden');
        $('#imageView .clearfix .actions').toggleClass('hidden');
    })

    $.setAjaxForm('.deleteForm', function(response)
    {
        if(response.result == 'success') location.href = location.href;
    });
});
