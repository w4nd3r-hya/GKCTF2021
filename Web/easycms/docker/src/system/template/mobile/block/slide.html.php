{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The about front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Yidong wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
/php*}
{$block->content = json_decode($block->content)}
{$groupID = !empty($block->content->group) ? $block->content->group : ''}
{$slides  = $model->loadModel('slide')->getList($groupID)}
{$slideID = 'slide' . $block->id . '-' . $groupID}
{$group   = $model->loadModel('tree')->getByID($groupID)}
{$globalButtons = !empty($group->desc) ? json_decode($group->desc, true) : array()}
{$slideStyle    = !empty($block->content->style) ? $block->content->style : 'carousel'}
{if($slides)}
  <div class='block{$blockClass}' id='block{$block->id}'>
    {if($slideStyle == 'tile')}
      <div id="{$slideID}" class='tile slide' data-id='{$groupID}'>
    {else}
      <div id='{$slideID}' class='carousel slide' data-ride='carousel' data-ve='carousel' data-id='{$groupID}'>
        <div class='carousel-inner'>
    {/if}
    {$height = 0}
    {$index = 0}
    {foreach($slides as $slide)}
      {$url    = empty($slide->mainLink) ? '' : " data-url='" . $slide->mainLink . "'"}
      {$target = " data-target='" . (isset($slide->target) && $slide->target ? '_blank' : '_self') . "'"}
      {if($height == 0 and $slide->height)} {$height = $slide->height} {/if}
      {if($slide->backgroundType == 'image')}
        <div class='item{!echo ($index === 0) ? ' active' : ''}' {!echo $url . ' ' . $target}>
        {!print(html::image($slide->image,"alt= '$slide->title' title='$slide->title'"))}
      {else}
        <div class='item{!echo ($index === 0) ? ' active' : ''}' {!echo $url . ' ' . $target} style='{!echo 'background-color: ' . $slide->backgroundColor . '; height: ' . $height . 'px'}'>
      {/if}
        <div class="{$slideStyle}-caption">
          <h2 style='color:{$slide->titleColor}'>{$slide->title}</h2>
          <div>{$slide->summary}</div>
          {foreach($globalButtons as $id => $globalButton)}
            {foreach($globalButton as $key => $global)}
              {if(!$global)} {continue} {/if}
              {if(trim($slides[$id]->label[$key]) != '')}
                {if($slides[$id]->buttonUrl[$key])} {!html::a($slides[$id]->buttonUrl[$key], $slides[$id]->label[$key], "class='btn btn-{{$slides[$id]->buttonClass[$key]}}' target='{{$slides[$id]->buttonTarget[$key]}}'")} {/if}
                {if(!$slides[$id]->buttonUrl[$key])} {!html::commonButton($slides[$id]->label[$key], "btn btn-{{$slides[$id]->buttonClass[$key]}}")} {/if}
              {/if}
            {/foreach}
          {/foreach}

          {foreach($slide->label as $key => $label)}
            {if(!empty($globalButtons[$slide->id][$key]))} {continue} {/if}
            {if(trim($label) != '')}
              {if($slide->buttonUrl[$key])}  {!html::a($slide->buttonUrl[$key], $label, "class='btn btn-{{$slide->buttonClass[$key]}}' target='{{$slide->buttonTarget[$key]}}'")} {/if}
              {if(!$slide->buttonUrl[$key])} {!html::commonButton($label, "btn {{$slide->buttonClass[$key]}}")} {/if}
            {/if}
          {/foreach}
        </div>
      </div>
      {@$index++}
    {/foreach}
      {if($slideStyle == 'carousel')}
        </div>
        {if(count($slides) > 1)}
          <ol class="carousel-indicators">
          {@$index = 0}
          {foreach($slides as $slide)}
            <li data-target="#{$slideID}" data-slide-to="{$index}"{!echo ($index === 0) ? '  class="active"' : ''}></li>
            {@$index++}
          {/foreach}
          </ol>
          <a class='left carousel-control' href='#{$slideID}' data-slide='prev'> <i class='icon icon-chevron-left'></i> </a>
          <a class='right carousel-control' href='#{$slideID}' data-slide='next'> <i class='icon icon-chevron-right'></i> </a>
        {/if}
      {/if}
    </div>
  </div>
{/if}
