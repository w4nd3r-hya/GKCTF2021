{if(!defined("RUN_MODE"))} {!die()} {/if}
{if(isset($config->site->type) and $config->site->type == 'blog')}
  {include TPL_ROOT . 'blog/header.html.php'}
{else}
  {include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{/if}
{!$common->printPositionBar('search', null, $words)}
<div class='row'>
  <div class='col-md-12'>
    <div class='list list-condensed'>
      <header>
        <h2>{$lang->search->index}</h2>
      </header>
      <section class='items items-hover'>
        {foreach($results as $object)}
          <div class='item'>
            <div class='item-heading'>
              <div class="text-muted pull-right">
                <span title="{$lang->object->addedDate}"><i class='icon-time'></i> {!substr($object->editedDate, 0, 10)}</span>
              </div>
              <h4>{!html::a($object->url, $object->title)}</h4>
            </div>
            <div class='item-content'>
              {if(!empty($object->image->primary))}
                <div class='media pull-right'>
                  {$title = $object->image->primary->title ? $object->image->primary->title : strip_tags($object->title)}
                  {!html::a($object->url, html::image($control->loadModel('file')->printFileURL($object->image->primary, 'smallURL'), "title='$title' class='thumbnail'" ))}
                </div>
              {/if}
              <div class='text text-muted'>{$object->summary}</div>
            </div>
          </div>
        {/foreach}
      </section>
      <footer class='clearfix'>
        {!str_replace($words, urlencode($words), $pager->get('right', 'short'))}
        <span class='execute-info text-muted'>{!printf($lang->search->executeInfo, $pager->recTotal, $consumed)}</span> 
      </footer>
    </div>
  </div>
</div>
{if(isset($config->site->type) and $config->site->type == 'blog')}
  {include TPL_ROOT . 'blog/footer.html.php'}
{else}
  {include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
{/if}
