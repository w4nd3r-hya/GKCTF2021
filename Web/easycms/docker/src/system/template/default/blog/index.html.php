{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The index view file of blog module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('default', 'blog', 'header')}
{if(isset($category))}      {$path = array_keys($category->pathNames)} {/if} 
{if(!empty($path))}         {!js::set('path', $path)} {/if}
{if(!empty($category->id))} {!js::set('categoryID', $category->id)} {/if}
{if(!empty($category->id))} {!js::set('pageLayout', $control->block->getLayoutScope('blog_index', $category->id))} {/if}
{$root = '<li>' . $control->lang->currentPos . $control->lang->colon .  html::a($control->inlink('index'), $lang->blog->home) . '</li>'}
{if(!empty($category))} {!echo $common->printPositionBar($category, '', '', $root)} {/if}
{if(isset($articleIdList))}
  <script>{!echo "place" . md5(time()). "='" . $config->idListPlaceHolder . $articleIdList . $config->idListPlaceHolder . "';"}</script>
{else}
  <script>{!echo "place" . md5(time()) . "='" . $config->idListPlaceHolder . '' . $config->idListPlaceHolder . "';"}</script>
{/if}
<div class='row blocks' data-region='blog_index-topBanner'>{$control->block->printRegion($layouts, 'blog_index', 'topBanner', true)}</div>
<div class='row' id='columns' data-page='blog_index'>
  {if(!empty($layouts['blog_index']['side']) and !empty($sideFloat) && $sideFloat != 'hidden')}
    <div class="col-md-{!echo 12 - $sideGrid} col-main{if($sideFloat === 'left') echo ' pull-right'}">
  {else}
    <div class="col-md-12">
  {/if}
    <div class='row blocks' data-region='blog_index-top'>{$control->block->printRegion($layouts, 'blog_index', 'top', true)}</div>
    <div id='blogList'>
      {foreach($sticks as $stick)}
        {if(!isset($category))} {$category = array_shift($stick->categories)} {/if}
        {$url = inlink('view', "id=$stick->id", "category={{$category->alias}}&name=$stick->alias")}
        <div class="card" data-ve='blog' id='blog{!echo $stick->id}'>
          {if(!empty($stick->image))}
          {$pull     = (isset($control->config->blog->imagePosition) and $control->config->blog->imagePosition == 'left') ? 'pull-left' : 'pull-right'}
          {$imageURL = !empty($control->config->blog->imageSize) ? $control->config->blog->imageSize . 'URL' : 'smallURL'}
          <div class='media {!echo $pull}' style="max-width: {!echo !empty($control->config->blog->imageWidth) ? $control->config->blog->imageWidth . 'px' : '180px'}">
            {$title = $stick->image->primary->title ? $stick->image->primary->title : $stick->title}
            {$stick->image->primary->objectType = 'blog'}
            {!html::a($url, html::image($control->loadModel('file')->printFileURL($stick->image->primary, $imageURL), "title='$title' class='thumbnail'"))}
          </div>
          {/if}
          <h4 class='card-heading'>
            {!html::a($url, $stick->title, "style='color:{{$stick->titleColor}}'")}
            <span class='label label-danger'>{!echo $lang->article->stick}</span>
          </h4>
          <div class='card-content text-muted'>
            {$stick->summary}
          </div>
          <div class="card-actions text-muted">
            &nbsp; <span data-toggle='tooltip' title='{!printf($lang->article->lblAddedDate, formatTime($stick->addedDate))}'><i class="icon-time"></i> {!echo date('Y/m/d', strtotime($stick->addedDate))}</span>
            &nbsp; <span data-toggle='tooltip' title='{!printf($lang->article->lblAuthor, $stick->author)}'><i class="icon-user"></i> {!echo $stick->author}</span>
            &nbsp; <span data-toggle='tooltip' title='{!printf($lang->article->lblViews, $config->viewsPlaceholder . $stick->id . $config->viewsPlaceholder)}'><i class="icon-eye-open"></i> {!echo $config->viewsPlaceholder . $stick->id . $config->viewsPlaceholder}</span>
            {if(commonModel::isAvailable('message') and isset($stick->comments) and $stick->comments)}&nbsp; <a href="{!echo $url . '#commentForm'}"><span data-toggle='tooltip' title='{!printf($lang->article->lblComments, $stick->comments)}'><i class="icon-comments-alt"></i> {!echo $stick->comments}</span></a>{/if}
              {if(!empty($config->blog->showCategory))}
                {if($config->blog->categoryLevel == 'first')}
                  <span>[ {!echo ($config->blog->categoryName == 'full' or empty(zget($topCategoryList, $stick->category->id)->abbr)) ? zget($topCategoryList, $stick->category->id)->name : zget($topCategoryList, $stick->category->id)->abbr} ]</span>
                {else}
                  <span>[ {!echo ($config->blog->categoryName == 'full' or empty($stick->category->abbr)) ? $stick->category->name : $stick->category->abbr} ]</span>
                {/if} 
              {/if}            
          </div>
        </div>
        {@unset($articles[$stick->id])}
      {/foreach}
      {foreach($articles as $article)}
        {if(!isset($category))}{$category = array_shift($article->categories)}{/if}
        {$url = inlink('view', "id=$article->id", "category={{$category->alias}}&name=$article->alias")}
        <div class="card" data-ve='blog' id='blog{$article->id}'>
          {if(!empty($article->image))}
            {$pull     = (isset($control->config->blog->imagePosition) and $control->config->blog->imagePosition == 'left') ? 'pull-left' : 'pull-right'}
            {$imageURL = !empty($control->config->blog->imageSize) ? $control->config->blog->imageSize . 'URL' : 'smallURL'}
            <div class='media {!echo $pull}' style="max-width: {!echo !empty($control->config->blog->imageWidth) ? $control->config->blog->imageWidth . 'px' : '180px'}">
              {$title = $article->image->primary->title ? $article->image->primary->title : $article->title}
              {$article->image->primary->objectType = 'blog'}
              {!html::a($url, html::image($control->loadModel('file')->printFileURL($article->image->primary, $imageURL), "title='{{$title}}' class='thumbnail'"))}
            </div>
          {/if}
          <h4 class='card-heading'>{!html::a($url, $article->title, "style='color:{{$article->titleColor}}'")}</h4>
          <div class='card-content text-muted'>
            {!echo $article->summary}
          </div>
          <div class="card-actions text-muted">
            <span data-toggle='tooltip' title='{!printf($lang->article->lblAddedDate, formatTime($article->addedDate))}'><i class="icon-time"></i> {!echo date('Y/m/d', strtotime($article->addedDate))}</span>
            &nbsp; <span data-toggle='tooltip' title='{!printf($lang->article->lblAuthor, $article->author)}'><i class="icon-user"></i> {!echo $article->author}</span>
            &nbsp; <span data-toggle='tooltip' title='{!printf($lang->article->lblViews, $config->viewsPlaceholder . $article->id . $config->viewsPlaceholder)}'><i class="icon-eye-open"></i> {!echo $config->viewsPlaceholder . $article->id . $config->viewsPlaceholder}</span>
            {if(commonModel::isAvailable('message') and $article->comments)}&nbsp; <a href="{!echo $url . '#commentForm'}span data-toggle='tooltip' title='{!printf($lang->article->lblComments, $article->comments)}'><i class="icon-comments-alt"></i> {!echo $article->comments}</span></a>{/if}
              {if(isset($config->blog->showCategory) and $config->blog->showCategory)}
                {if($config->blog->categoryLevel == 'first')}
                    {!echo "<span>["}
                    {!echo ($config->blog->categoryName == 'full' or empty(zget($topCategoryList, $article->category->id)->abbr)) ? zget($topCategoryList, $article->category->id)->name : zget($topCategoryList, $article->category->id)->abbr}
                    {!echo "]</span>"}
                {else}
                    {!echo "<span>["}
                    {!echo ($config->blog->categoryName == 'full' or empty($article->category->abbr)) ? $article->category->name : $article->category->abbr}
                    {!echo "]</span>"}
                {/if} 
              {/if}            
          </div>
        </div>
      {/foreach}
      <div class='clearfix pager'>{$pager->show('right', 'short')}</div>
    </div>
    <div class='row blocks' data-region='blog_index-bottom'>{$control->block->printRegion($layouts, 'blog_index', 'bottom', true)}</div>
  </div>
  {if(!empty($layouts['blog_index']['side']) and !(empty($sideFloat) || $sideFloat === 'hidden'))}
  <div class='col-md-{!echo $sideGrid} col-side'>
    <side class='page-side'>
      <div class='blocks' data-region='blog_index-side'>{$control->block->printRegion($layouts, 'blog_index', 'side')}</div>
    </side>
  </div>
  {/if}
</div>
<div class='row'>{$control->block->printRegion($layouts, 'blog_index', 'bottomBanner', true)}</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'blog', 'footer')}
