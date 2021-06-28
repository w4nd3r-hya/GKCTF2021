{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{$common->printPositionBar()}
<div class='row blocks' data-region='page_index-top'>{$control->block->printRegion($layouts, 'page_index', 'top', true)}</div>
<div class='row'>
  <div class='col-md-9'>
    <div class='list list-condensed'>
      <header><h2>{$control->lang->page->list}</h2></header>
      <section class='items items-hover' id='pageList'>
        {foreach($pages as $page)}
          {$url = inlink('view', "id=$page->id", "name=$page->alias")}
          <div class='item' id='page{!echo $page->id}' data-ve='page'>
            <div class='item-heading'>
              <h4>{!html::a($url, $page->title)}</h4>
            </div>
            <div class='item-content'>
              {if(!empty($page->image))}
                <div class='media pull-right'>
                  {$title = $page->image->primary->title ? $page->image->primary->title : $page->title}
                  {!html::a($url, html::image($control->loadModel('file')->printFileURL($page->image->primary, 'smallURL'), "title='$title' class='thumbnail'" ))}
                </div>
              {/if}
              <div class='text text-muted'>{!helper::substr($page->summary, 120, '...')}</div>
            </div>
            <div class='item-footer text-muted'>
              <span><i class='icon-eye-open'></i> {$page->views}</span> &nbsp;
              <span><i class='icon-time'></i> {!substr($page->addedDate, 0, 10)}</span>
            </div>
          </div>
        {/foreach}
      </section>
    </div>
  </div>
  <div class='col-md-3'><side class='page-side blocks blocks' data-region='page_index-side'>{$control->block->printRegion($layouts, 'page_index', 'side')}</side></div>
</div>
<div class='row blocks' data-region='page_index-bottom'>{$control->block->printRegion($layouts, 'page_index', 'bottom', true)}</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
