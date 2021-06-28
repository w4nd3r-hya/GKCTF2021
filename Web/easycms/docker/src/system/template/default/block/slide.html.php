{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
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
*}
{$block->content = json_decode($block->content)}
{$groupID        = !empty($block->content->group) ? $block->content->group : ''}
{$slides         = $model->loadModel('slide')->getList($groupID)}
{$slideID        = 'slide' . $block->id . '-' . $groupID}
{$group          = $model->loadModel('tree')->getByID($groupID)}
{$globalButtons  = zget($group, 'desc', '') ? json_decode($group->desc, true) : array()}
{$slideStyle     = !empty($block->content->style) ? $block->content->style : 'carousel'}
{if($slides)}
<div class='block {!echo $blockClass}' id='block{!echo $block->id}'>
  {if($slideStyle == 'tile')}
  <div id="{!echo $slideID}" class='tile slide' data-id='{!echo $groupID}'>
  {else}
  <div id='{!echo $slideID}' class='carousel slide' data-ride='carousel' data-ve='carousel' data-id='{!echo $groupID}'>
    <div class='carousel-inner'>
  {/if}
      {$height = 0; $index = 0}
      {foreach($slides as $slide)}
        {$url    = empty($slide->mainLink) ? '' : " data-url='" . $slide->mainLink . "'"}
        {$target = " data-target='" . ($slide->target ? '_blank' : '_self') . "'"}
        {if($height == 0 and $slide->height)} {$height = $slide->height} {/if}
        {$itemClass = 0 === $index++ ? 'item active' : 'item'}
        {if($slide->backgroundType == 'image')}
          <div data-id='{!echo $slide->id}' class='{!echo $itemClass }'{!echo $url . ' ' . $target}>
          {!print(html::image($slide->image,"alt='{{$slide->title}}' title='{{$slide->title}}'"))}
        {else}
          <div data-id='{!echo $slide->id}' class='{!echo $itemClass }'{!echo $url . ' ' . $target} style='{!echo 'background-color: ' . $slide->backgroundColor . '; height: ' . $height . 'px'}'>
        {/if}
          <div class="{!echo $slideStyle . '-caption'}">
            <h2 style='color:{!echo $slide->titleColor}'>{!echo $slide->title}</h2>
            <div>{!echo $slide->summary}</div>
            {foreach($globalButtons as $id => $globalButton)}
              {foreach($globalButton as $key => $global)}
                {if(!$global)} {continue} {/if}
                {if(trim($slides[$id]->label[$key]) != '')}
                  {if($slides[$id]->buttonUrl[$key])}  {!html::a($slides[$id]->buttonUrl[$key], $slides[$id]->label[$key], "class='btn btn-lg btn-{{$slides[$id]->buttonClass[$key]}}' target='{{$slides[$id]->buttonTarget[$key]}}'")} {/if}
                  {if(!$slides[$id]->buttonUrl[$key])} {!html::commonButton($slides[$id]->label[$key], "btn btn-lg btn-{{$slides[$id]->buttonClass[$key]}}")} {/if}
                {/if}
              {/foreach}
            {/foreach}

            {foreach($slide->label as $key => $label)}
              {if(!empty($globalButtons[$slide->id][$key]))} {continue} {/if}
              {if(trim($label) != '')}
                {if($slide->buttonUrl[$key])} {!html::a($slide->buttonUrl[$key], $label, "class='btn btn-lg btn-{{$slide->buttonClass[$key]}}' target='{{$slide->buttonTarget[$key]}}'")} {/if}
                {if(!$slide->buttonUrl[$key])} {!html::commonButton($label, "btn btn-lg btn-{{$slide->buttonClass[$key]}}")} {/if}
              {/if}
            {/foreach}
          </div>
        </div>
      {/foreach}
    {if($slideStyle == 'carousel')}
      </div>
      {if(count($slides) > 1)}
      <a class='left carousel-control' href='#{!echo $slideID}' data-slide='prev'><i class='icon icon-chevron-left'></i></a>
      <a class='right carousel-control' href='#{!echo $slideID}' data-slide='next'><i class='icon icon-chevron-right'></i></a>
      {/if}
    {/if}
  </div>
</div>
{/if}
