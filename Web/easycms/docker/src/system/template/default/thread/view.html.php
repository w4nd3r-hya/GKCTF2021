{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The view file of thread module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
 *}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{include TPL_ROOT . 'common/kindeditor.html.php'}

{!js::set('viewReplies', $lang->thread->viewReplies)}
{!js::set('stayCurrent', $lang->thread->stayCurrent)}
{!js::set('quoteTitle', $lang->thread->quoteTitle)}
{!js::set('discussion', $thread->discussion)}
{!js::set('isCurrentPage', ceil(($pager->recTotal + 1) / $pager->recPerPage) == $pager->pageID)}

{!echo "<div class='row blocks' data-grid='4' data-region='thread_view-top'>"}
{$control->block->printRegion($layouts, 'thread_view', 'top', true)}
{!echo "</div>"}

{$common->printPositionBar($board, $thread)}

{if($pager->pageID == 1)} {include $control->loadModel('ui')->getEffectViewFile('default', 'thread', 'thread')} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'thread', 'reply')}

{!echo "<div class='blocks' data-region='thread_view-bottom'>"}
{$control->block->printRegion($layouts, 'thread_view', 'bottom')}
{!echo "</div>"}

{include TPL_ROOT . 'common/video.html.php'}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
