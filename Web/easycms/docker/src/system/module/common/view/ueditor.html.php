<?php if(!defined("RUN_MODE")) die();?>
<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php
$module = $this->moduleName;
$method = $this->methodName;
js::set('themeRoot', $themeRoot);
if(!isset($config->$module->editor->$method)) return;
$editor = $config->$module->editor->$method;
$editor['id'] = explode(',', $editor['id']);
$editorLangs  = array('en' => 'en', 'zh-cn' => 'zh-cn', 'zh-tw' => 'zh-tw');
$editorLang   = isset($editorLangs[$app->getClientLang()]) ? $editorLangs[$app->getClientLang()] : 'en';

/* set uid for upload. */
$uid = uniqid('');
js::set('kuid', $uid);
?>
<script charset="utf-8" src="<?php echo $this->app->getWebRoot() . "js/"?>ueditor/ueditor.config.js"></script>
<script charset="utf-8" src="<?php echo $this->app->getWebRoot() . "js/"?>ueditor/ueditor.all.min.js"> </script>
<style>
.edui-default.form-control{height: auto; padding: 0; box-shadow: none; width: auto;}
#edui_fixedlayer {z-index: 1050!important;}
.edui-editor-toolbarbox[style*="fixed"] {top: 41px!important;}
</style>
<script>
window.UEDITOR_HOME_URL = '<?php echo $this->config->webRoot . 'js/ueditor/' ?>';
var editor = <?php echo json_encode($editor);?>;
var simple = [[
    'paragraph', 'fontfamily', 'fontsize', 'lineheight', '|',
    'bold', 'italic', 'underline', 'strikethrough', '|',
    'justifyleft', 'justifycenter', 'justifyright', '|',
    'pasteplain', 'emotion', 'simpleupload', '|',
    'link', 'unlink', 'anchor',
    'undo', 'redo', 'removeformat','insertorderedlist', 'insertunorderedlist', '|',
    'source', 'help']];
var full = [[
    'paragraph', 'fontfamily', 'fontsize','|',
    'forecolor', 'backcolor', '|', 'lineheight', 'indent', '|',
    'bold', 'italic', 'underline', 'strikethrough', '|',
    'justifyleft', 'justifycenter', 'justifyright', '|',
    'insertorderedlist', 'insertunorderedlist', 'pasteplain',
    'fullscreen'],
    [
    'undo', 'redo', 'removeformat', '|',
    'link', 'unlink', 'anchor', '|',
    'inserttable', '|',
    'emotion', 'simpleupload', 'insertimage','insertvideo', 'map', '|',
    'insertcode', 'source', 'searchreplace', 'help']
    ];

function initUeditor(afterInit)
{
    $(':input[type=submit]').after("<input type='hidden' id='uid' name='uid' value=" + v.kuid + ">");
    var options =
    {
        lang: '<?php echo $editorLang?>',
        toolbars: <?php echo $editor['tools']?>,
        serverUrl: '<?php echo $this->createLink('file', 'apiforueditor', "uid=$uid")?>',
        autoClearinitialContent: false,
        wordCount: false,
        initialStyle: 'p{line-height:1em}embed,.edui-upload-video,.edui-faked-video{background:url(\'<?php echo $jsRoot?>ueditor/themes/default/images/videologo.gif\') no-repeat center center; border:1px solid gray;}',
        <?php if($editorLang != 'zh-cn' and $editorLang != 'zh-tw') echo "iframeCssUrl:'',"; //When lang is zh-cn or zh-tw then load ueditor/themes/iframe.css file for font-family and size of editor.?>
        enableAutoSave: false,
        elementPathEnabled: false,
        initialFrameWidth: '100%',
        autoHeightEnabled: false,
        initialFrameHeight: 400,
        zIndex: 5,
        removeFormatTags: 'big,dfn,font,ins,strike,tt,u',
        removeFormatAttributes: 'lang,hspace',
        allowDivTransToP: false
    };
    if(!window.editor) window.editor = {};
    $.each(editor.id, function(key, editorID)
    {
        var $editor = $('#' + editorID);
        if($editor.length)
        {
            var ueditor = UE.getEditor(editorID, options);
            window.editor['#'] = window.editor[editorID] = ueditor;
            $editor.addClass('ueditor').data('ueditor', ueditor);

            ueditor.addListener('ready', function()
            {
                $(this.container).parent().removeClass('form-control');
            });
            ueditor.addListener('fullscreenchanged', function(e, fullscreen)
            {
                var $container = $(this.container).css('z-index', fullscreen ? 1050 : 5);
                if (fullscreen && window.navigator.userAgent.indexOf('Firefox') > -1) {
                    $container.css('top', 0);
                }
            });
        }
    });

    if($.isFunction(afterInit)) afterInit();
}
$(document).ready(initUeditor);
</script>
<style>
.edui-editor-iframeholder{min-height:180px;}
</style>
