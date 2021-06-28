{if(!defined("RUN_MODE"))} {!die()} {/if}
{$module = $control->moduleName}
{$method = $control->methodName}
{!js::set('themeRoot', $themeRoot)}
{if(!isset($config->$module->editor->$method))} {@return true} {/if}
{$editor=$config->$module->editor->$method}
{$editorIdList=explode(',', $editor['id'])}
{!js::set('editorIdList', $editorIdList)}
{$editorLangs  = array('en' => 'en', 'zh-cn' => 'zh-cn', 'zh-tw' => 'zh-tw')}
{$editorLang   = isset($editorLangs[$app->getClientLang()]) ? $editorLangs[$app->getClientLang()] : 'en'}
{$uid = uniqid('')}
{!js::set('kuid', $uid)}
<script type="text/javascript" charset="utf-8" src="{$app->getWebRoot()}js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="{$app->getWebRoot()}js/ueditor/ueditor.all.min.js"> </script>
<script>
var editor = {!json_encode($editor)};
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
    $(':input[type=submit]').after("<input type='hidden' id='uid' name='uid' value=" + v.kuid + '>');
    var options =
    {
        lang: '{$editorLang}',
        toolbars: {$editor['tools']},
        serverUrl: '{$control->createLink('file', 'apiforueditor', "uid=$uid")}',
        autoClearinitialContent:false,
        wordCount:false,
        {if($editorLang != 'zh-cn' and $editorLang != 'zh-tw')}
        iframeCssUrl:'',
        {/if}
        enableAutoSave:false,
        autoHeightEnabled: false,
        elementPathEnabled:false,
        initialFrameWidth: '100%',
        initialFrameHeight: 400,
        zIndex: 5
    };
    if(!window.editor) window.editor = {};
    $.each(v.editorIdList, function(key, editorID)
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
                $(this.container).css('z-index', fullscreen ? 1050 : 5);
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
