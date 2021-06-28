{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The latest article front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
*}
{* Set $themRoot. *}
{$themeRoot = $config->webRoot . 'theme/'}
{$app->loadModuleConfig('forum')}

{* Decode the content and get articles. *}
{$content = json_decode($block->content)}
{$method  = 'get' . ucfirst(str_replace('thread', '', strtolower($block->type)))}
{$threads = $model->loadModel('thread')->$method(empty($content->category) ? 0 : $content->category, $content->limit)}
{$boards  = $model->dao->select('*')->from(TABLE_CATEGORY)->where('type')->eq('forum')->andWhere('grade')->eq(2)->fetchAll('id')}
{*/php*}
<div id="block{!echo $block->id}" class='panel panel-block {!echo $blockClass}'>
  <div class='panel-heading'>
    <strong>{!echo $icon . $block->title}</strong>
    {if(!empty($content->moreText) and !empty($content->moreUrl))}
      <div class='pull-right'>{!html::a($content->moreUrl, $content->moreText)}</div>
    {/if}
  </div>
  <div class='panel-body'>
    <ul class='ul-list'>
      {foreach($threads as $thread)}
      <li>
        {if(isset($content->showCategory) and $content->showCategory == 1)}
          {if($content->categoryName == 'abbr')}
            {$boardName = '[' . ($boards[$thread->board]->abbr ? $boards[$thread->board]->abbr : $boards[$thread->board]->name) . '] '}
            {!html::a(helper::createLink('forum', 'board', "boardID={{$thread->board}}", "category={{$boards[$thread->board]->alias}}"), $boardName)}
          {else}
            {!html::a(helper::createLink('forum', 'board', "boardID={{$thread->board}}", "category={{$boards[$thread->board]->alias}}"), '[' . $boards[$thread->board]->name . '] ')}
          {/if}
        {/if}

        {$bold = ''}
        {if($thread->stick && (!formatTime($thread->stickTime) || $thread->stickTime > date('Y-m-d H:i:s')) and $thread->stickBold)}
        {$bold = 'font-weight:bold;'}
        {/if}
        {!html::a(helper::createLink('thread', 'view', "id=$thread->id"), $thread->title, "title={{$thread->title}} style='{{$bold}}color:{{$thread->color}}'")}
        {if($thread->stick && (!formatTime($thread->stickTime) || $thread->stickTime > date('Y-m-d H:i:s')))}<span class='red'><i class="icon icon-arrow-up"></i></span>{/if}

        <span class='pull-right'>{!substr($thread->addedDate, 0, 10)}</span>
      </li>
      {/foreach}
    </ul>
  </div>
</div>
