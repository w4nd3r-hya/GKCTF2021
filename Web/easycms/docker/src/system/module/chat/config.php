<?php
$config->chat->require = new stdclass();
$config->chat->require->create = 'gid, name, type';
$config->chat->require->edit   = 'gid, name, type';

$config->chat->user = new stdclass();
$config->chat->user->canEditFields = array('avatar', 'birthday', 'gender', 'email', 'skype', 'qq', 'yahoo', 'gtalk', 'wangwang', 'site', 'mobile', 'phone', 'address', 'zipcode', 'clientStatus');
