{if(!defined("RUN_MODE"))} {!die()} {/if}
<div class='panel-body'>
  <div class='cards cards-custom'>
    {foreach($books as $book)}
      {$recPerRow = $content->recPerRow}
      <div class='pull-left with-padding' style="width:{!echo 100 / $recPerRow}%" data-recperrow="{$recPerRow}">
        <div class='card with-margin'>
          <div class='card-heading text-center'>
            {!html::a(helper::createLink('book', 'browse', "nodeID=$book->id", "book=$book->alias") . ($model->get->fullScreen ? "?fullScreen={{$model->get->fullScreen}}" : ''), $book->title)}
          </div>
          <div class='card-content text-muted text-center'>{!strip_tags(htmlspecialchars_decode($book->content))}</div>
          <div class='card-actions'>
            <span class='text-muted'><i class='icon-user'></i> {$book->author}</span>
            <span class='text-muted'><i class='icon-time'></i> {!formatTime($book->addedDate, 'Y-m-d')}</span>
          </div>
        </div>
      </div>
    {/foreach}
  </div>
</div>
<style>
.card .card-heading{height: 100px; font-size: 15px; white-space: normal; display: table; width: 100%;}
.card .card-heading a{display: table-cell; vertical-align: middle;}
.card-content{height: 80px;}
.card-actions{position: relative; bottom:5px; right: 5px;}
</style>
