<?php if(!defined("RUN_MODE")) die();?>
<?php
$config->site->help['sina'] = 'http://www.chanzhi.org/book/chanzhieps/41.html';
$config->site->help['qq']   = 'http://www.chanzhi.org/book/chanzhieps/57.html';

$config->site->editor = new stdclass();
$config->site->editor->setbasic = array('id' => 'pauseTip', 'tools' => 'simple');
$config->site->editor->setagreement = array('id' => 'agreementContent', 'tools' => 'simple');

if(!isset($config->site->mobileTemplate)) $config->site->mobileTemplate = 'close';

$config->themeSetting = new stdclass();
$config->themeSetting->primaryColor = '#D1270A' ;
$config->themeSetting->backColor    = '#FFFFFF';
$config->themeSetting->borderRadius = '4px';
$config->themeSetting->fontSize     = '14px';

$config->cdn->fileList[] = '/theme/default/default/chanzhi.all.admin.css';
$config->cdn->fileList[] = '/js/chanzhi.all.admin.js';
$config->cdn->fileList[] = '/theme/default/default/chanzhi.all.css';
$config->cdn->fileList[] = '/js/chanzhi.all.js';
