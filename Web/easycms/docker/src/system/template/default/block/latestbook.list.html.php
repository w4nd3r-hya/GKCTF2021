{if(!defined("RUN_MODE"))} {!die()} {/if}
<div class='panel-body'>
  <ul class='ul-list'>
    {foreach($books as $book)}
    <li class='addDataList'>
      {!html::a(helper::createLink('book', 'browse', "nodeID=$book->id", "book=$book->alias"), $book->title)}
      <span class='pull-right'>{!substr($book->addedDate, 0, 10)}</span>
    </li>
    {/foreach}
  </ul>
</div>
