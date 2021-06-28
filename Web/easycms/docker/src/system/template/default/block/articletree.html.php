{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The category front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Yidong wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
*}
{$block->content  = json_decode($block->content)}
{$type            = str_replace('tree', '', strtolower($block->type))}
{$browseLink      = $type == 'article' ? 'createBrowseLink' : 'create' . ucfirst($type) . 'BrowseLink'}
{$startCategory = 0}
{if(isset($block->content->fromCurrent) and $block->content->fromCurrent)}
  {if($type == 'article' and $app->getModuleName() == 'article' and $model->session->articleCategory)}
    {$category = $model->loadModel('tree')->getByID($model->session->articleCategory)}
    {$startCategory = $category->parent}
  {/if}
  {if($type == 'blog' and $app->getModuleName() == 'blog' and $model->session->blogCategory)}
    {$category = $model->loadModel('tree')->getByID($model->session->blogCategory)}
    {$startCategory = $category->parent}
  {/if}
  {if($type == 'product' and $app->getModuleName() == 'product' and $model->session->productCategory)}
    {$category = $model->loadModel('tree')->getByID($model->session->productCategory)}
    {$startCategory = $category->parent}
  {/if}
{/if}
<div id="block{$block->id}" class='panel panel-block {$blockClass}'>
  <div class='panel-heading'>
    <strong>{!echo $icon . $block->title}</strong>
  </div>
  <div class='panel-body'>
    {if($block->content->showChildren)}
    {$treeMenu = $model->loadModel('tree')->getTreeMenu($type, $startCategory, array('treeModel', $browseLink), zget($block->content, 'initialExpand', 1))}
    {$treeMenu}
    {else}
    {$topCategories = $model->loadModel('tree')->getChildren($startCategory, $type)}
    <ul class='nav nav-secondary nav-stacked'>
      {foreach($topCategories as $topCategory)}
        {$browseLink = helper::createLink($type, 'browse', "categoryID={{$topCategory->id}}", "category={{$topCategory->alias}}")}
        {if($type == 'blog')} {$browseLink = helper::createLink('blog', 'index', "categoryID={{$topCategory->id}}", "category={{$topCategory->alias}}")} {/if}
        <li>{!html::a($browseLink, "<i class='icon-folder-close-alt '></i> &nbsp;" . $topCategory->name, "id='category{{$topCategory->id}}'")}</li>
      {/foreach}
    </ul>
    {/if}
  </div>
</div>
<script>
$(document).ready(function()
{
    $('.tree .list-toggle').mousedown(function(){$(this).parents('.panel-block').height('auto');})
    $('.row.blocks .tree').resize(function(){$(this).parents('.row.blocks').tidy({force: true});})
})
</script>
