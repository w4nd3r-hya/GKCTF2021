{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div class='row'>
  {foreach($books as $book)}
  <div class='col-xs-6 col-sm-4 col-md-3'>
    <div class='card'>
      <div class='card-heading text-center'>
        {!html::a($control->createLink('book', 'browse', "nodeID=$book->id", "book=$book->alias") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), $book->title)}
      </div>
      <div class='card-content text-muted'>{!echo $book->summary}</div>
      <div class='card-actions'>
        <span class='text-muted'><i class='icon-user'></i> {!echo $book->author}</span>
        <span class='text-muted'><i class='icon-time'></i> {!echo $book->addedDate}</span>
      </div>
    </div>
  </div>
  {/foreach}
  {if($pager->pageTotal > 1)}
  <div class='col-xs-12 col-sm-12 col-md-12 pull-left'>{$pager->show('right', 'short')}</div>
  {/if}
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
