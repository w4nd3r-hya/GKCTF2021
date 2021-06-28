{if(!defined("RUN_MODE"))} {!die()} {/if}
{if(isset($config->site->type) and $config->site->type == 'blog')}
  {include TPL_ROOT . 'blog/header.html.php'}
{else}
  {include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
{/if}
<div class='panel panel-section'>
  <div class='panel-heading'>
    <strong>{$lang->search->index}</strong>
  </div>
  <div class='cards condensed cards-list'>
  {foreach($results as $object)}
    <a class='card' href='{$object->url}'>
      <div class='card-heading'>
        <h5>{$object->title}</h5>
      </div>
      <div class='table-layout'>
        <div class='table-cell'>
          <div class='card-content text-muted small'>{$object->summary}</div>
          <div class='card-footer small text-muted'>
            <span title="{$lang->article->addedDate}"><i class='icon-time'></i> {!substr($object->addedDate, 0, 10)}</span>
          </div>
        </div>
        {if(!empty($object->image->primary))}
          <div class='table-cell thumbnail-cell'>
           {$title = $object->image->primary->title ? $object->image->primary->title : $object->title}
           {!html::image($control->loadModel('file')->printFileURL($object->image->primary, 'smallURL'), "title='{{$title}}' class='thumbnail'" )}
          </div>
        {/if}
      </div>
    </a>
  {/foreach}
  </div>
  <div class='panel-footer'>
    <div class='small text-muted'>{!printf($lang->search->executeInfo, $pager->recTotal, $consumed)}</div>
    <hr class='space'>
    {$pager->show('justify')}
  </div>
</div>
{noparse}
<script>
$(function(){$('#searchToggle').dropdown('toggle');});
</script>
{/noparse}

{if(isset($config->site->type) and $config->site->type == 'blog')}
  {include TPL_ROOT . 'blog/footer.html.php'}
{else}
  {include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
{/if}
