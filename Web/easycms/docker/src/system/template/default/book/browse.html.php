{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{if(isset($node))} {$common->printPositionBar($node->origins)} {/if}
{!js::set('fullScreen', (!empty($control->config->book->fullScreen) or $control->get->fullScreen) ? 1 : 0)}
<div class='row blocks' data-region='book_browse-topBanner'>{$control->block->printRegion($layouts, 'book_browse', 'topBanner', true)}</div>
<div class='panel' id='bookCatalog' data-id='{if(isset($node))}{$node->id}{/if}'>
  {if(!empty($book) && $book->title)}
  <div class='panel-heading clearfix'>
    <div class='dropdown'>
      <a data-toggle='dropdown' class='dropdown-toggle' href='javascript:;'><strong>{$book->title}</strong> <span class='caret'></span></a>
      <ul role='menu' class='dropdown-menu'>
        {foreach($books as $bookMenu)}
        <li>{!html::a(inlink("browse", "id=$bookMenu->id", "book=$bookMenu->alias") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), $bookMenu->title)}</li>
        {/foreach}
      </ul>
    </div>
  </div>
  {/if}
  <div class='panel-body'>
    <div class='books'>{if(!empty($catalog))} {$catalog} {/if}</div>
  </div>
</div>
<div class='row blocks' data-region='book_browse-bottomBanner'>{$control->block->printRegion($layouts, 'book_browse', 'bottomBanner', true)}</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
