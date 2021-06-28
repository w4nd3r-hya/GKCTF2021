<?php if(!defined("RUN_MODE")) die();?>
<?php
$config->file->require = new stdclass();
$config->file->require->edit = 'title';

if(!isset($config->file->thumbs))
{
    $config->file->thumbs = array();
    $config->file->thumbs['s'] = array('width' => '80',  'height' => '80');
    $config->file->thumbs['m'] = array('width' => '300', 'height' => '300');
    $config->file->thumbs['l'] = array('width' => '800', 'height' => '600');
}
else
{
    $config->file->thumbs = json_decode($config->file->thumbs, true);
}

$config->file->imageExtensions  = array('jpeg', 'jpg', 'gif', 'png', 'bmp');
$config->file->videoExtensions  = array('flv', 'webmv', 'wav', 'rtmp', 'ogg', 'mp3', 'mp4', 'm4v', 'swf');

$config->file->mediaTypes = new stdclass();
$config->file->mediaTypes->flv  = 'flv';
$config->file->mediaTypes->mp3  = 'mp3';
$config->file->mediaTypes->mp4  = 'm4v';
$config->file->mediaTypes->m4v  = 'm4v';
$config->file->mediaTypes->webm = 'webmv';
$config->file->mediaTypes->ogg  = 'ogg';
$config->file->mediaTypes->rtmp = 'rtmp';
$config->file->mediaTypes->wav  = 'wav';

$config->file->editorExtensions = array_merge($config->file->imageExtensions, $config->file->videoExtensions);

$config->file->mimes['default'] = 'application/octet-stream';
$config->file->mimes['txt']  = 'text/plain';
$config->file->mimes['jpg']  = 'image/jpeg';
$config->file->mimes['jpeg'] = 'image/jpeg';
$config->file->mimes['gif']  = 'image/gif';
$config->file->mimes['png']  = 'image/png';
$config->file->mimes['bmp']  = 'image/x-ms-bmp';
$config->file->mimes['xml']  = 'application/xml';
$config->file->mimes['html'] = 'text/html';

$config->file->tables   = array();
$config->file->tables[] = 'file.pathname';
$config->file->tables[] = 'article.content';
$config->file->tables[] = 'block.content';
$config->file->tables[] = 'book.content';
$config->file->tables[] = 'product.content';
$config->file->tables[] = 'reply.content';
$config->file->tables[] = 'thread.content';
$config->file->tables[] = 'wx_message.content';
$config->file->tables[] = 'slide.image';

$config->file->ueditor["imageActionName"]       = "uploadimage";
$config->file->ueditor["imageFieldName"]        = "upfile";
$config->file->ueditor["imageMaxSize"]          = 2048000;
$config->file->ueditor["imageAllowFiles"]       = array(".png", ".jpg", ".jpeg", ".gif", ".bmp");
$config->file->ueditor["imageCompressEnable"]   = true;
$config->file->ueditor["imageCompressBorder"]   = 1600;
$config->file->ueditor["imageInsertAlign"]      = "none";
$config->file->ueditor["imageUrlPrefix"]        = "";
$config->file->ueditor["imagePathFormat"]       = "";
$config->file->ueditor["imageManagerUrlPrefix"] = "";
$config->file->ueditor["imageManagerListSize"]  = 20;

$config->file->ueditor["snapscreenActionName"]  = "uploadimage";
$config->file->ueditor["snapscreenInsertAlign"] = "none";
$config->file->ueditor["snapscreenUrlPrefix"]   = "";
$config->file->ueditor["snapscreenPathFormat"]  = "";

$config->file->ueditor["videoActionName"] = "uploadvideo";
$config->file->ueditor["videoFieldName"]  = "upfile";
$config->file->ueditor["videoMaxSize"]    = 102400000;
$config->file->ueditor["videoAllowFiles"] = array(".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg", ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid");
$config->file->ueditor["videoUrlPrefix"]  = "";
$config->file->ueditor["videoPathFormat"] = "";
