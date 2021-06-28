<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The forum module zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     forum
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->forum->common      = 'Forum';
$lang->forum->board       = 'Board';
$lang->forum->owners      = 'Moderator';
$lang->forum->threadList  = 'Thread List';
$lang->forum->threadCount = 'Thread';
$lang->forum->postCount   = 'Post';
$lang->forum->lastPost    = 'Last Post';
$lang->forum->readonly    = 'Read Only';
$lang->forum->notExist    = 'Board does not exist.'; 
$lang->forum->lblOwner    = " [ BM %s ]";

$lang->forum->post       = 'Post';
$lang->forum->admin      = 'Board Moderator';
$lang->forum->update     = 'Data Update';
$lang->forum->setting    = 'Forum Settings';
$lang->forum->postReview = 'Post Review';
$lang->forum->allBoards  = 'All Boards';
$lang->forum->index      = 'Index';
$lang->forum->bindWechat = 'Bind Wechat';

$lang->forum->updateDesc    = 'Number of threads on each board will be updated.';
$lang->forum->successUpdate = 'Done!';
$lang->forum->bindWechatTip = 'Posting sets the limit for binding WeChat. Please bind WeChat user first.';

$lang->forum->indexModeOptions = array();
$lang->forum->indexModeOptions['board']  = 'Board';
$lang->forum->indexModeOptions['latest'] = 'Latest Thread';
$lang->forum->indexModeOptions['stick']  = 'Sticky Thread';

$lang->forum->bindWechatOptions = array();
$lang->forum->bindWechatOptions['open']  = 'Open';
$lang->forum->bindWechatOptions['close'] = 'Close';

/* Adjust the pager. */
$lang->pager->noRecord      = '';
$lang->pager->digest        = str_replace('Record', 'Theme', $lang->pager->digest);
$lang->pager->settedInForum = true;    // Set this switch thus in thread module can avoid overiding them.

$lang->forum->postReviewOptions        = new stdclass(); 
$lang->forum->postReviewOptions->open  = 'On';
$lang->forum->postReviewOptions->close = 'Off';
