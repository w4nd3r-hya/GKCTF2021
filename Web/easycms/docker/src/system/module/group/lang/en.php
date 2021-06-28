<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The group module English file of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     group
 * @version     $Id: en.php 4719 2013-05-03 02:20:28Z chencongzhi520@gmail.com $
 * @link        http://www.ranzhico.com
 */
$lang->group->common             = 'Privilege';
$lang->group->allGroups          = 'All Privileges';
$lang->group->browse             = 'Group List';
$lang->group->create             = 'Create Group';
$lang->group->edit               = 'Edit';
$lang->group->copy               = 'Copy';
$lang->group->delete             = 'Delete';
$lang->group->managePriv         = 'Privilege';
$lang->group->managePrivByGroup  = 'By Group';
$lang->group->managePrivByModule = 'By Module';
$lang->group->byModuleTips       = '<span class="tips">(Press shift/control to multi-select.)</span>';
$lang->group->manageMember       = 'Member';
$lang->group->linkMember         = 'Link Member';
$lang->group->unlinkMember       = 'Unlink Member';
$lang->group->confirmDelete      = 'Do you want to delete this member?';
$lang->group->successSaved       = 'Saved';
$lang->group->errorNotSaved      = 'Not saved. Please choose privilege.';

$lang->group->id       = 'ID';
$lang->group->name     = 'Name';
$lang->group->desc     = 'Description';
$lang->group->users    = 'User List';
$lang->group->module   = 'Module';
$lang->group->method   = 'Function';
$lang->group->priv     = 'Privilege';
$lang->group->option   = 'Option';
$lang->group->inside   = 'Group Member';
$lang->group->outside  = 'Non-Group Member';
$lang->group->other    = 'Other Modules';
$lang->group->all      = 'All Privilege';
$lang->group->extent   = 'Privilege Scope';
$lang->group->havePriv = 'Authorized';
$lang->group->noPriv   = 'Unauthorized';

$lang->group->selectAll = 'Select All';
$lang->group->manageAll = 'View All';

$lang->group->copyOptions['copyPriv'] = 'Copy Privilege';
$lang->group->copyOptions['copyUser'] = 'Copy User';

include (dirname(__FILE__) . '/resource.php');
