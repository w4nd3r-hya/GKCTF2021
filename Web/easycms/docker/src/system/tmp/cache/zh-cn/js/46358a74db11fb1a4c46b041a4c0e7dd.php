<?php if(!defined('RUN_MODE')) die();?>v.lang = {"confirmDelete":"\u60a8\u786e\u5b9a\u8981\u6267\u884c\u5220\u9664\u64cd\u4f5c\u5417\uff1f","deleteing":"\u5220\u9664\u4e2d","doing":"\u5904\u7406\u4e2d","loading":"\u52a0\u8f7d\u4e2d","updating":"\u66f4\u65b0\u4e2d...","timeout":"\u7f51\u7edc\u8d85\u65f6,\u8bf7\u91cd\u8bd5","errorThrown":"<h4>\u6267\u884c\u51fa\u9519\uff1a<\/h4>","continueShopping":"\u7ee7\u7eed\u8d2d\u7269","required":"\u5fc5\u586b","back":"\u8fd4\u56de","continue":"\u7ee7\u7eed","bindWechatTip":"\u53d1\u5e16\u529f\u80fd\u8bbe\u7f6e\u4e86\u7ed1\u5b9a\u5fae\u4fe1\u7684\u9650\u5236\uff0c\u8bf7\u5148\u7ed1\u5b9a\u5fae\u4fe1\u4f1a\u5458\u3002","importTip":"\u53ea\u5bfc\u5165\u4e3b\u9898\u7684\u98ce\u683c\u548c\u6837\u5f0f","fullImportTip":"\u5c06\u4f1a\u5bfc\u5165\u6d4b\u8bd5\u6570\u636e\u4ee5\u53ca\u66ff\u6362\u7ad9\u70b9\u6587\u7ae0\u3001\u4ea7\u54c1\u7b49\u6570\u636e"};;v.jsRoot = "\/chan7\/www\/js\/";;v.webRoot = "\/chan7\/www\/";;v.editors = {"id":["content"],"tools":"simple"};;v.errorUnwritable = "\u4e0a\u4f20\u76ee\u5f55\u4e0d\u53ef\u5199\uff0c\u65e0\u6cd5\u4e0a\u4f20\u9644\u4ef6\u3002";;v.editorLang = "zh_CN";;v.uid = "60d08aa43f8b6";;

var simple =
[ 'formatblock', 'fontsize', '|', 'bold', 'italic','underline', '|',
'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist', 'insertunorderedlist', '|',
'emoticons', 'image', 'media', 'link', '|', 'removeformat','undo', 'redo', 'source' ];

var full =
[ 'formatblock', 'fontsize', 'lineheight', '|', 'forecolor', 'hilitecolor', '|', 'bold', 'italic','underline', 'strikethrough', '|',
'justifyleft', 'justifycenter', 'justifyright', '|',
'emoticons', 'image', '|', 'link', 'unlink', 'anchor', 'flash', 'media', 'baidumap', '/',
'undo', 'redo', '|', 'cut', 'copy', '|', 'plainpaste', 'wordpaste', '|', 'removeformat', 'clearhtml','quickformat', '|',
'indent', 'outdent', 'subscript', 'superscript', 'insertorderedlist', 'insertunorderedlist', '|',
'table', 'code', 'hr', '|',
'fullscreen', 'source', 'about'];

$(document).ready(initKindeditor);
function initKindeditor(afterInit)
{
    $(':input[type=submit]').after("<input type='hidden' id='uid' name='uid' value=" + v.uid + ">");
    var nextFormControl = 'input:not([type="hidden"]), textarea:not(.ke-edit-textarea), button[type="submit"], select';

    $.each(v.editors.id, function(key, editorID)
    {
        if(typeof(v.editors.filterMode) == 'undefined') v.editors.filterMode = true;
        editorTool = eval(v.editors.tools);
        var K = KindEditor, $editor = $('#' + editorID);
        keEditor = K.create('#' + editorID,
        {
            width:'100%',
            items:editorTool,
            cssPath:[v.webRoot + 'zui/css/min.css'],
            bodyClass:'article-content',
            urlType:'absolute',
            uploadJson: createLink('file', 'ajaxUpload', 'uid=' + v.uid),
            imageTabIndex:1,
            filterMode:v.editors.filterMode,
            allowFileManager:false,
            langType:v.editorLang,
            htmlTags:{
            
            'pspanh1h2h3h4h5emustrongbrolulliimgabfonthrpreembedvideoaudio':["class","id","style"],
            
            video: ["id", "class", "width", "height", "src", "controls"],
            object: ["type", "data", "width", "height"], param: ["name", "value"],
            audio: ["src", "controls", "id", "class", "width", "height"],
            font:["id","class","color","size","face",".background-color"],span:["id","class",".color",".background-color",".font-size",".font-family",".background",".font-weight",".font-style",".text-decoration",".vertical-align",".line-height"],div:["id","class","align",".border",".margin",".padding",".text-align",".color",".background-color",".font-size",".font-family",
            ".font-weight",".background",".font-style",".text-decoration",".vertical-align",".margin-left"],table:["id","class","border","cellspacing","cellpadding","width","height","align","bordercolor",".padding",".margin",".border","bgcolor",".text-align",".color",".background-color",".font-size",".font-family",".font-weight",".font-style",".text-decoration",".background",".width",".height",".border-collapse"],"td,th":["id","class","align","valign","width","height","colspan","rowspan","bgcolor",".text-align",
            ".color",".background-color",".font-size",".font-family",".font-weight",".font-style",".text-decoration",".vertical-align",".background",".border"],a:["id","class","href","target","name"],embed:["id","class","src","width","height","type","loop","autostart","quality",".width",".height","align","allowscriptaccess","allowfullscreen"],img:["id","class","src","width","height","border","alt","title","align",".width",".height",".border"],"p,ol,ul,li,blockquote,h1,h2,h3,h4,h5,h6":["id","class","align",".text-align",".color",
            ".background-color",".font-size",".font-family",".background",".font-weight",".font-style",".text-decoration",".vertical-align",".text-indent",".margin-left"],pre:["id","class"],hr:["id","class",".page-break-after"],"br,tbody,tr,strong,b,sub,sup,em,i,u,strike,s,del":["id","class"],iframe:["id","class","src","frameborder","width","height",".width",".height"],style:[]},
            afterBlur: function(){this.sync();$('#' + editorID).prev('.ke-container').removeClass('focus');},
            afterFocus: function(){$('#' + editorID).prev('.ke-container').addClass('focus');},
            afterChange: function(){$('#' + editorID ).change().hide();},
            
            
            
            afterCreate : function()
            {
                var doc = this.edit.doc;
                var cmd = this.edit.cmd;
                /* Paste in chrome. */
                /* Code reference from http://www.foliotek.com/devblog/copy-images-from-clipboard-in-javascript/. */
                if(K.WEBKIT)
                {
                    $(doc.body).bind('paste', function(ev)
                    {
                        var $this = $(this);
                        var original =  ev.originalEvent;
                        var clipboardItems = original.clipboardData && original.clipboardData.items;
                        var clipboardItem = null;
                        if(clipboardItems)
                        {
                            var IMAGE_MIME_REGEX = /^image\/(p?jpeg|gif|png)$/i;
                            for (var i = 0; i < clipboardItems.length; i++)
                            {
                                if (IMAGE_MIME_REGEX.test(clipboardItems[i].type))
                                {
                                    clipboardItem = clipboardItems[i];
                                    break;
                                }
                            }
                        }
                        var file = clipboardItem && clipboardItem.getAsFile();
                        if (!file) return;
                        var reader = new FileReader();
                        reader.onload = function (evt)
                        {
                            var result = evt.target.result;
                            var result = evt.target.result;
                            var arr = result.split(",");
                            var data = arr[1]; // raw base64
                            var contentType = arr[0].split(";")[0].split(":")[1];

                            html = '<img src="' + result + '" alt="" />';
                            $.post(createLink('file', 'ajaxPasteImage', 'uid=' + v.uid), {editor: html}, function(data)
                            {
                                if(data) return cmd.inserthtml(data);

                                alert(v.errorUnwritable);
                                return cmd.inserthtml(html);
                            });
                        };

                        reader.readAsDataURL(file);
                    });
                }

                /* Paste in firefox.*/
                if(K.GECKO)
                {
                    K(doc.body).bind('paste', function(ev)
                    {
                        setTimeout(function()
                        {
                            var html = K(doc.body).html();
                            if(html.search(/<img src="data:.+;base64,/) > -1)
                            {
                                $.post(createLink('file', 'ajaxPasteImage', "uid=" + v.uid), {editor: html}, function(data)
                                {
                                    if(data) return K(doc.body).html(data);

                                    alert(v.errorUnwritable);
                                    return K(doc.body).html(data);
                                });
                            }
                        }, 80);
                    });
                }
                /* End */
            },
            afterTab: function(id)
            {
                var $next = $editor.next(nextFormControl);
                if(!$next.length) $next = $editor.parent().next().find(nextFormControl);
                if(!$next.length) $next = $editor.parent().parent().next().find(nextFormControl);
                $next = $next.first();
                var keditor = $next.data('keditor');
                if(keditor) keditor.focus(); else $next.focus();
            }
        });
        try
        {
            if(!window.editor) window.editor = {};
            window.editor['#'] = window.editor[editorID] = keEditor;
            $editor.data('keditor', keEditor);
        }
        catch(e){}
    });

    if($.isFunction(afterInit)) afterInit();
}

;v.viewReplies = "\u67e5\u770b\u56de\u5e16\u5185\u5bb9";;v.stayCurrent = "\u7559\u5728\u5f53\u524d\u9875\u9762";;v.quoteTitle = "<div class='quote-title'>\u539f\u5e16\u7531 %s \u4e8e %s \u53d1\u8868<\/div>";;v.discussion = 0;;v.isCurrentPage = true;;
$(function()
{
    var videoContainer = "<video id=\"VIDEO_ID\" class=\"video-js vjs-default-skin vjs-big-play-centered\" controls preload=\"auto\" loop=\"loop\" data-setup='{\"autoplay\": VIDEO_AUTOSTART, \"width\": VIDEO_WIDTH, \"height\": VIDEO_HEIGHT, \"controlBar\": {\"fullscreenToggle\": VIDEO_FULLSCREEN}}'><source src=\"VIDEO_SRC\" type=\"video\/VIDEO_TYPE\" \/> <\/video>";
    $('embed').each(function(index)
    {
        if($(this).hasClass('videojs')) 
        {
            var $embed      = $(this),
                src         = $embed.attr('src'),
                w           = $embed.width(),
                h           = $embed.height(),
                type        = src.match(/t=\w+/g),
                autostart   = $embed.attr('autostart'),
                fullscreen  = $embed.attr('allowfullscreen'),
                containerID = 'video_' + index;

            $container = videoContainer.replace(/VIDEO_SRC/g, src);
            $container = $container.replace(/VIDEO_WIDTH/, w);
            $container = $container.replace(/VIDEO_HEIGHT/, h);
            $container = $container.replace(/VIDEO_ID/, containerID);
            $container = $container.replace(/VIDEO_AUTOSTART/, autostart);
            $container = $container.replace(/VIDEO_FULLSCREEN/, fullscreen);
            $container = $container.replace(/VIDEO_TYPE/, type[0].replace('t=', ''));
            $(this).replaceWith($container);
        }
    })
});
;$().ready(function() { $('#execIcon').tooltip({title:$('#execInfoBar').html(), html:true, placement:'right'}); }); ;$(document).ready(function()
{
    $('#isLink').change(function()
    {   
        if($(this).prop('checked'))
        {   
            $('.threadInfo').hide();
            $('.link').show();
        }   
        else
        {   
            $('.threadInfo').show();
            $('.link').hide();
        }   
    }); 

    $('.color').each(function()
    {
        var $this = $(this);
        var c = $this.attr('data');
        if(!c) return;
        var cc = new Color(c).contrast().hexStr();

        ($this.hasClass('input-group') ? $this.find('.input-group-btn .dropdown-toggle') : $this).css({'background': c, 'color': cc}).find('.caret').css('border-top-color', cc);
    }).click(function()
    {
        var $this = $(this);
        if($this.hasClass('input-group')) return;
        var $plate = $this.closest('.colorplate');
        $plate.find('.color.active').removeClass('active');
        if($this.hasClass('color-tile')) $plate.find('.input-color').val($this.attr('data')).change();
        $this.addClass('active');
    });

    $('.input-color').on('keyup change', function()
    {
        var $this = $(this);
        var val = $this.val();

        $this.closest('.colorplate').find('.color.active').removeClass('active');

        if(Color.isColor(val))
        {
            var ic = (new Color(val)).contrast().hexStr();
            $this.attr('placeholder', val).closest('.color').removeClass('error').find('.input-group-btn .dropdown-toggle').css({'background': val, 'color': ic}).find('.caret').css('border-top-color', ic);;
        }
        else
        {
            $this.closest('.color').addClass('error');
        }
    });
});
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

;
function loadCartInfo(twinkle)
{
    $('#siteNav').load(createLink('misc', 'printTopBar'),
        function()
        {
            if(twinkle) 
            {
                bootbox.dialog(
                {  
                    message: v.addToCartSuccess,  
                    buttons:
                    {  
                        back:
                        {  
                            label:     v.lang.continueShopping,
                            className: 'btn-primary',  
                            callback:  function(){location.reload();}  
                        },
                        cart:
                        {  
                            label:     v.gotoCart,  
                            className: 'btn-primary',  
                            callback:  function(){location.href = createLink('cart', 'browse');}  
                        }  
                    }  
                });
            }
        }
    );
}
