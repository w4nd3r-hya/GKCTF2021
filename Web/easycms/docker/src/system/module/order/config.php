<?php if(!defined("RUN_MODE")) die();?>
<?php
$config->order = new stdclass();
$config->order->require = new stdclass();
$config->order->require->create   = 'account,address';
$config->order->require->delivery = 'deliveriedDate,express,waybill,deliveriedBy';
$config->order->require->setting  = 'payment,pid,key,confirmLimit,email';

$config->order->editor = new stdclass();
$config->order->editor->view = array('id' => 'lastComment', 'tools' => 'simple');

$config->order->statusFields = new stdclass();
$config->order->statusFields->not_paid  = 'payStatus';
$config->order->statusFields->paid      = 'payStatus';
$config->order->statusFields->not_send  = 'deliveryStatus';
$config->order->statusFields->send      = 'deliveryStatus';
$config->order->statusFields->confirmed = 'deliveryStatus';
$config->order->statusFields->normal    = 'status';
$config->order->statusFields->finished  = 'status';
$config->order->statusFields->canceled  = 'status';
$config->order->statusFields->expired   = 'status';

$config->order->processViews = new stdclass();
$config->order->processViews->shop  = 'processorder';
$config->order->processViews->score = 'processscore';

$config->order->require->savepay = 'sn,payment,payStatus';

$config->order->orderTypes = array();
$config->order->orderTypes[] = 'shop';
$config->order->orderTypes[] = 'score';

$config->order->statusTypes = array();
$config->order->statusTypes['not_paid']  = 'payStatus';
$config->order->statusTypes['paid']      = 'payStatus';
$config->order->statusTypes['not_send']  = 'deliveryStatus';
$config->order->statusTypes['send']      = 'deliveryStatus';
$config->order->statusTypes['confirmed'] = 'deliveryStatus';
$config->order->statusTypes['normal']    = 'status';
$config->order->statusTypes['finished']  = 'status';
$config->order->statusTypes['canceled']  = 'status';
$config->order->statusTypes['expired']   = 'status';
$config->order->statusTypes['all']       = 'status';
