{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The read view file of book for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     book
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{if(!empty($control->config->book->fullScreen) or $control->get->fullScreen)}
  {include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.lite')}
  {!js::set('fullScreen', 1)}
  <div class='fullScreen-book'>
    <div class='fullScreen-content'>
      <div class='fullScreen-inner'>
        <div class='appheader'>
          <div class='heading'>
            <h2>{$article->title}</h2>
            <div class='caption text-muted'>
              <small><i class='icon-time icon-large'></i> {!formatTime($article->addedDate)}</small> &nbsp;&nbsp;
              <small><i class='icon-user icon-large'></i> {!$article->author}</small> &nbsp;&nbsp;
              <small><i class='icon-eye-open'></i> {$config->viewsPlaceholder}</small>
            </div>
          </div>
        </div>
        
        <div class='panel-section article' id='book' data-id='{$article->id}'>
          {if($article->summary)}
            <section class='abstract hidden bg-gray-pale small with-padding'><strong>{$lang->book->summary}</strong>{!echo $lang->colon . $article->summary}</section>
          {/if}
          <div class='panel-body'>
            <hr class="space">
            <section class='article-content'>
              {$article->content}
            </section>
          </div>
          {if(!empty($article->files))}
            <section class="article-files">
              {$control->loadModel('file')->printFiles($article->files)}
            </section>
          {/if}
          <div class='panel-footer'>
            <div class='article-moreinfo hidden clearfix'>
              {if($article->editor)}
                 {$editor = $control->loadModel('user')->getByAccount($article->editor)}
                 {if(!empty($editor))}
                    <p class='text-muted'><i class='icon-edit'></i> {!printf($lang->book->lblEditor, $editor->realname, formatTime($article->editedDate))}</p> 
                 {/if}
               {/if}
              {if($article->keywords)} <p class='small'><strong class="text-muted">{$lang->book->keywords}</strong><span class="article-keywords">{!echo $lang->colon . $article->keywords}</span></p> {/if}
            </div>
            {if(isset($prevAndNext))}
              {@extract($prevAndNext)}
              {if($prev)}
                {!html::a(inlink('read', "articleID=$prev->id", "book={{$book->alias}}&node={{$prev->alias}}") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), "<i class='icon-arrow-left'></i> " . $prev->title, "class='btn block text-left default'")}
              {else}
                <a href='###' class='btn block text-left default disabled'><i class='icon-arrow-left'></i> {!print($lang->book->none)}</a>
              {/if}
              {if($next)}
                {!html::a(inlink('read', "articleID=$next->id", "book={{$book->alias}}&node={{$next->alias}}") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), "<i class='icon-arrow-right'></i> " . $next->title, "class='btn block text-left default'")}
              {else}
                <a href='###' class='btn block text-left default disabled'>{!print($lang->book->none)}<i class='icon-arrow-right'></i></a>
              {/if}
              {!html::a(inlink('browse', "bookID={{$parent->id}}", "book={{$book->alias}}&title={{$parent->alias}}") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), "<i class='icon-list-ul'></i> " . $lang->book->chapter, "class='btn block text-left default'")}
              {if(!$control->get->fullScreen)} <a href='/' class='btn block text-left default home'><i class='icon-home'></i> {$lang->book->goHome}</a> {/if}
            {/if}
          </div>
        </div>
  
        {if(commonModel::isAvailable('message'))}
          <div id='commentBox'>
            {$control->fetch('message', 'comment', "objectType=book&objectID=$article->id")}
          </div>
        {/if}
        <div class='block-region region-bottom blocks' data-region='book_read-bottom'>{$control->loadModel('block')->printRegion($layouts, 'book_read', 'bottom')}</div>
      </div>
    </div>
  </div>
  {if(isset($pageJS))} {!js::execute($pageJS)} {/if}
  </body>
  </html>

{else}
  {include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.simple')}
  {include TPL_ROOT . 'common/files.html.php'}
  {!js::set('fullScreen', 0)}
  <div class='block-region region-top blocks' data-region='book_read-top'>{$control->loadModel('block')->printRegion($layouts, 'book_read', 'top')}</div>
  <div class='book'>
    <div class='appheader'>
      <div class='heading'>
        <h2>{$article->title}</h2>
        <div class='caption text-muted'>
          <small><i class='icon-time icon-large'></i> {!formatTime($article->addedDate)}</small> &nbsp;&nbsp;
          <small><i class='icon-user icon-large'></i> {$article->author}</small> &nbsp;&nbsp;
          <small><i class='icon-eye-open'></i> {$config->viewsPlaceholder}</small>
        </div>
      </div>
    </div>
    
    <div class='panel-section article' id='book' data-id='{$article->id}'>
      {if($article->summary)}
        <section class='abstract hidden bg-gray-pale small with-padding'><strong>{$lang->book->summary}</strong>{!echo $lang->colon . $article->summary}</section>
      {/if}
      <div class='panel-body'>
        <hr class="space">
        <section class='article-content'>
          {$article->content}
        </section>
      </div>
      {if(!empty($article->files))}
        <section class="article-files">
          {$control->loadModel('file')->printFiles($article->files)}
        </section>
      {/if}
      <div class='panel-footer'>
        <div class='article-moreinfo hidden clearfix'>
          {if($article->editor)}
             {$editor = $control->loadModel('user')->getByAccount($article->editor)}
             {if(!empty($editor))}
               <p class='text-muted'><i class='icon-edit'></i> {!printf($lang->book->lblEditor, $editor->realname, formatTime($article->editedDate))}</p>
             {/if}
          {/if}
          {if($article->keywords)}
            <p class='small'><strong class="text-muted">{$lang->book->keywords}</strong><span class="article-keywords">{!echo $lang->colon . $article->keywords}</span></p>
          {/if}
        </div>
        {if(isset($prevAndNext))}
          {@extract($prevAndNext)}
          {if($prev)}
            {!html::a(inlink('read', "articleID=$prev->id", "book={{$book->alias}}&node={{$prev->alias}}") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), "<i class='icon-arrow-left'></i> " . $prev->title, "class='btn block text-left default'")}
          {else}
            <a href='###' class='btn block text-left default disabled'><i class='icon-arrow-left'></i> {!print($lang->book->none)}</a>
          {/if}
          {if($next)}
            {!html::a(inlink('read', "articleID=$next->id", "book={{$book->alias}}&node={{$next->alias}}") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), "<i class='icon-arrow-right'></i> " . $next->title, "class='btn block text-left default'")}
          {else}
            <a href='###' class='btn block text-left default disabled'>{!print($lang->book->none)}<i class='icon-arrow-right'></i></a>
          {/if}
          {!html::a(inlink('browse', "bookID={{$parent->id}}", "book={{$book->alias}}&title={{$parent->alias}}") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), "<i class='icon-list-ul'></i> " . $lang->book->chapter, "class='btn block text-left default'")}
        {/if}
      </div>
    </div>
  
    {if(commonModel::isAvailable('message'))}
      <div id='commentBox'>
        {!$control->fetch('message', 'comment', "objectType=book&objectID=$article->id")}
      </div>
    {/if}
    <div class='block-region region-bottom blocks' data-region='book_read-bottom'>{$control->loadModel('block')->printRegion($layouts, 'book_read', 'bottom')}</div>
  </div>
  {include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
{/if}
