<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The thread module english file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->thread->common    = 'Subject';

$lang->thread->id          = 'ID';
$lang->thread->title       = 'Title';
$lang->thread->board       = 'Board';
$lang->thread->author      = 'Author';
$lang->thread->content     = 'Text';
$lang->thread->file        = 'File: ';
$lang->thread->postedDate  = 'Created On';
$lang->thread->replies     = 'Reply';
$lang->thread->replyCount  = 'Replies';
$lang->thread->views       = 'View';
$lang->thread->lastReply   = 'Last Reply';
$lang->thread->isLink      = 'Link';
$lang->thread->link        = 'Link';
$lang->thread->discussion  = 'Discussion';

$lang->thread->post           = 'Post';
$lang->thread->postTo         = 'Post to';
$lang->thread->browse         = 'Thread';
$lang->thread->stick          = 'Sticky';
$lang->thread->edit           = 'Edit';
$lang->thread->status         = 'Status';
$lang->thread->approve        = 'Approve';
$lang->thread->display        = 'Dispaly';
$lang->thread->hide           = 'Hide';
$lang->thread->show           = 'Show';
$lang->thread->transfer       = 'Repost';
$lang->thread->switchStatus   = 'Hide/Display';
$lang->thread->deleteFile     = 'Delete File';
$lang->thread->unreplied      = "<span class='text-important'> Not Replied</span>";
$lang->thread->quote          = 'Quote';
$lang->thread->latest         = 'Latest';
$lang->thread->stickTime      = 'Top End Time';
$lang->thread->stickBold      = 'Title Bold';

$lang->thread->sticks[0] = 'No Sticky';
$lang->thread->sticks[1] = 'Sticky';
$lang->thread->sticks[2] = 'Global Sticky ';

$lang->thread->displayList['hidden'] = 'Hidden';
$lang->thread->displayList['normal'] = 'Normal';

$lang->thread->statusList['wait']     = 'Pending';
$lang->thread->statusList['approved'] = 'Approved';

$lang->thread->confirmDeleteThread = "Do you want to delete it?";
$lang->thread->confirmHideReply    = "Do you want to hide it?";
$lang->thread->confirmHideThread   = "Do you want to hide it?";
$lang->thread->confirmDeleteReply  = "Do you want to delete it?";
$lang->thread->confirmDeleteFile   = "Do you want to delete it?";
$lang->thread->canNotDelete        = "Delete thread faild, the reason is no authority.";

$lang->thread->lblEdited       = 'Last edited by %s on %s';
$lang->thread->message         = '%s replied in #%s the thread %s, which is %s';
$lang->thread->readonly        = 'Read Only';
$lang->thread->successStick    = 'Done!';
$lang->thread->successUnstick  = 'Cancelled!';
$lang->thread->successHide     = 'Done!';
$lang->thread->successShow     = 'Done!';
$lang->thread->readonlyMessage = 'This post is <strong>Read Only</strong>. You cannot reply to it.';
$lang->thread->successTransfer = 'Done!';
$lang->thread->thanks          = 'It will be posted once approved.';
$lang->thread->replySuccess    = 'Replied.';
$lang->thread->viewReplies     = 'View your reply';
$lang->thread->stayCurrent     = 'Stay on the current page';
$lang->thread->quoteTitle      = "<div class='quote-title'>Post by %s on %s</div>";    
$lang->thread->replyFloor      = "Reply <strong>#%s</strong>";    
$lang->thread->bindEmail       = 'Please bind Email';

$lang->thread->score    = 'Points';
$lang->thread->scoreSum = "<i class='text-warning icon icon-plus'><b>%s</b></i> ";
$lang->thread->scores[5]  = '+ 5';
$lang->thread->scores[10] = '+ 10';
$lang->thread->scores[50] = '+ 50';
$lang->thread->scores[100]= '+ 100';

$lang->thread->placeholder = new stdclass();
$lang->thread->placeholder->link = 'Enter a link. External links are OK.';

/* Adjust the pager. */
if(!isset($lang->pager->settedInForum))
{
    $lang->pager->noRecord = '';
    $lang->pager->digest   = str_replace('Record', 'Reply', $lang->pager->digest);
}
