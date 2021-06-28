<?php if(!class_exists('raintpl')){exit;}?><?php if(!defined("RUN_MODE")){ ?>

<?php echo die(); ?>

<?php } ?>

<?php $module=$this->var['module'] = $control->moduleName;?>

<?php $method=$this->var['method'] = $control->methodName;?>


<?php if(!isset($config->$module->editor->$method)){ ?>

<?php return ;; ?>

<?php } ?>



<?php echo js::set('jsRoot', $jsRoot); ?>

<?php echo js::set('webRoot', $webRoot); ?>



<?php $editors=$this->var['editors'] = $config->{$module}->editor->$method;?>

<?php $temp=$this->var['temp'] = $editors['id'] = explode(',', $editors['id']);?>

<?php echo js::set('editors', $editors); ?>


<?php echo $control->app->loadLang('file');?>

<?php echo js::set('errorUnwritable', $lang->file->errorUnwritable); ?>



<?php $editorLangs=$this->var['editorLangs'] = array('en' => 'en', 'zh-cn' => 'zh_CN', 'zh-tw' => 'zh_TW');?>

<?php $editorLang=$this->var['editorLang']  = isset($editorLangs[$app->getClientLang()]) ? $editorLangs[$app->getClientLang()] : 'en';?>

<?php echo js::set('editorLang', $editorLang); ?>



<?php echo css::import($jsRoot . 'kindeditor/themes/default/default.css'); ?>

<?php echo js::import($jsRoot  . 'kindeditor/kindeditor.min.js'); ?>

<?php echo js::import($jsRoot  . 'kindeditor/lang/' . $editorLang . '.js'); ?>



<?php $uid=$this->var['uid'] = uniqid('');?>

<?php echo js::set('uid', $uid); ?>


<script>

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
            
            '<?php echo str_replace(array("<",">"), array('', ''), $config->allowedTags->{RUN_MODE}); ?>':["class","id","style"],
            
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
            
            <?php if(!$control->loadModel('file')->canUpload()){ ?>

<?php echo "showLocal:false, imageTabIndex:0,"; ?>

<?php } ?>

            
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

</script>
