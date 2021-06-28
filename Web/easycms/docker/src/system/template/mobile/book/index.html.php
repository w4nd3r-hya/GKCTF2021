{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
<div class='books' id="books">
  {foreach($books as $book)}
    <div class='book'>
      <p class='book-header'>{!html::a($control->createLink('book', 'browse', "nodeID=$book->id", "book=$book->alias") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), $book->title)}</p>
      <div class='book-summary'>{$book->summary}</div>
      <div class='book-footer'>
        <span class='article-amount'>{!printf($lang->book->articleAmount,$book->articleAmount)}</span>
        <span class='article-added-date'>{!formatTime($book->addedDate, 'Y-m-d')}</span>
      </div>
    </div>
  {/foreach}
</div>

{$pager->createPullUpJS('#books', $lang->mobile->pullUpHint, helper::createLink('book', 'index', 'pageID=$ID'), true)}

{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
