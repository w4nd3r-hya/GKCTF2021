{if(!defined("RUN_MODE"))} {!die()} {/if}
{if(!empty($control->config->book->fullScreen) or $control->get->fullScreen)}
  {include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header.lite')}
  {!js::set('objectType', 'book')}
  {!js::set('objectID', $article->id)}
  {!js::set('fullScreen', 1)}
  <style>body{overflow:hidden;}</style>
  <div class='fullScreen-book'>
    <div class='fullScreen-catalog pANeli bookScrollListsBox'>
      {if(!empty($book) && $book->title)}
        <div class='panel-heading clearfix'>
          <div class='dropdown pull-left'>
            <a href='javascript:;' data-toggle='dropdown' class='dropdown-toggle'><strong>{!echo $book->title}</strong> <i class='caret-down'></i></a>
            <ul role='menu' class='dropdown-menu'>
              {foreach($books as $bookMenu)}
              <li>{!html::a(inlink("browse", "id=$bookMenu->id", "book=$bookMenu->alias") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), $bookMenu->title)}</li>
              {/foreach}
            </ul>
          </div>
          {if(!$control->get->fullScreen)}
          <div class='pull-right home'><a href='/' title='{!echo $lang->book->goHome}'><i class='icon-home'></i></a></div>
          {/if}
        </div>
      {/if}
      <div class='panel-body'>
        <div class='books'>
          {if(!empty($bookInfoLink) and !empty($book->content))} {!echo "<span id='bookInfoLink'>" . $bookInfoLink . "</span>"} {/if}
          {if(!empty($allCatalog))} {!echo $allCatalog} {/if}
        </div>
        <div class='powerby'>{!printf($lang->poweredBy, $config->version, k(), "<span class='icon icon-chanzhi'><i class='ic1'></i><i class='ic2'></i><i class='ic3'></i><i class='ic4'></i><i class='ic5'></i><i class='ic6'></i><i class='ic7'></i></span> <span class='name'>" . $lang->chanzhiEPSx . '</span>' . $config->version)}</div>
      </div>
    </div>
    <div class='fullScreen-content panel'>
      <div class='fullScreen-inner'>
        <header>
          <h2>{!echo $article->title}</h2>
          <dl class='dl-inline'>
            <dd data-toggle='tooltip' data-placement='top' data-original-title='{!printf($lang->book->lblAddedDate, formatTime($article->addedDate))}'><i class='icon-time icon-large'></i> {!echo formatTime($article->addedDate)}</dd>
            <dd data-toggle='tooltip' data-placement='top' data-original-title='{!printf($lang->book->lblAuthor, $article->author)}'><i class='icon-user icon-large'></i> {!echo $article->author}</dd>
            <dd data-toggle='tooltip' data-placement='top' data-original-title='{!printf($lang->book->lblViews, $article->views)}'><i class='icon-eye-open'></i> {!echo $config->viewsPlaceholder}</dd>
            {if($article->editor)}
              <dd data-toggle='tooltip' data-placement='top' ><i class='icon-edit icon-large'></i>{!printf($lang->book->lblEditor, $control->loadModel('user')->getByAccount($article->editor)->realname, formatTime($article->editedDate))}</dd>
            {/if}
          </dl>
          {if($article->summary and $article->type != 'book')}
            <section class='abstract'><strong>{!echo $lang->book->summary}</strong>{!echo $lang->colon . $article->summary}</section>
          {/if}
        </header>
        <section class='article-content'>
          {if(isset($content))} {$content} {/if}
        </section>
        <section>{$control->loadModel('file')->printFiles($article->files)}</section>
        <footer>
          {if($article->keywords)}
            <p class='small'><strong class='text-muted'>{$lang->book->keywords}</strong><span class='article-keywords'>{!echo $lang->colon . $article->keywords}</span></p>
          {/if}
          {if(isset($prevAndNext))}
            {@extract($prevAndNext)}
            <ul class='pager pager-justify'>
              {if($prev)}
                <li class='previous' title='{!echo $prev->title}'>{!html::a(inlink('read', "articleID=$prev->id", "book={{$book->alias}}&node={{$prev->alias}}") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), "<i class='icon-arrow-left'></i> <span>" . $prev->title . '</span>')}</li>
              {else}
                <li class='previous disabled'><a href='###'><i class='icon-arrow-left'></i> {!print($lang->book->none)}</a></li>
              {/if}
              {if($control->config->book->chapter == 'home' or !$control->get->fullScreen)}
                <li class='back'>{!html::a(inlink('browse', "bookID{{$parent->id}}", "book={{$book->alias}}&title={{$parent->alias}}") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), "<i class='icon-list-ul'></i> " . $lang->book->chapter)}</li>
              {/if}
              {if($next)}
                <li class='next' title='{!echo $next->title}'>{!html::a(inlink('read', "articleID=$next->id", "book={{$book->alias}}&node={{$next->alias}}") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), '<span>' . $next->title . "</span> <i class='icon-arrow-right'></i>")}</li>
              {else}
                <li class='next disabled'><a href='###'> {!print($lang->book->none)}<i class='icon-arrow-right'></i></a></li>
              {/if}
            </ul>
          {/if}
        </footer>
        {if(commonModel::isAvailable('message'))}
        <div id='commentBox'>
          {!echo $control->fetch('message', 'comment', "objectType=book&objectID={{$article->id}}")}
        </div>
        {/if}
        <div class='blocks' data-region='book_read-bottom'>{$control->block->printRegion($layouts, 'book_read', 'bottom')}</div>
      </div>
    </div>
  </div>
  {include TPL_ROOT . 'common/video.html.php'}
  {if($config->debug)} {!js::import($jsRoot . 'jquery/form/min.js')} {/if}
  {if(isset($pageJS))} {!js::execute($pageJS)} {/if}
  </body>
  </html>
  {else}
  {include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
  {!js::set('objectType', 'book')}
  {!js::set('objectID', $article->id)}
  <div class='row blocks' data-region='book_read-top'>{$control->block->printRegion($layouts, 'book_read', 'top', true)}</div>
  {$common->printPositionBar($article->origins)}
  {if($control->config->book->chapter == 'left')}
  <div class='row'>
    <div class='col-md-3'>
      <div class='panel book-catalog bookScrollListsBox'>
        {if(!empty($book) && $book->title)}
          <div class='panel-heading clearfix'>
            <div class='dropdown pull-left'>
            <a href='javascript:;' data-toggle='dropdown' class='dropdown-toggle'><i class="icon icon-book"></i><strong>{!echo $book->title}</strong> <span>{!echo $lang->book->more}<i class='icon icon-caret-down'></i></span></a>
              <ul role='menu' class='dropdown-menu'>
                {foreach($books as $bookMenu)}
                  <li>{!html::a(inlink("browse", "id=$bookMenu->id", "book=$bookMenu->alias") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), $bookMenu->title)}</li>
                {/foreach}
              </ul>
            </div>
            <div class='pull-right home hide'><a href='/' title='{!echo $lang->book->goHome}'><i class='icon-home'></i></a></div>
          </div>
        {/if}
        <div class='panel-body'>
          <div class='books'>
            {if(!empty($bookInfoLink) and !empty($book->content))} {!echo "<span id='bookInfoLink'>" . $bookInfoLink . "</span>"} {/if}
            {if(!empty($allCatalog))} {!echo $allCatalog} {/if}
          </div>
        </div>
      </div>
    </div>
    <div class='col-md-9'>
  {/if}
  <div class='article book-content' id='book' data-id='{$article->id}'>
    <header>
      <h2>{!echo $article->title}</h2>
      <dl class='dl-inline'>
        <dd data-toggle='tooltip' data-placement='top' data-original-title='{!printf($lang->book->lblAddedDate, formatTime($article->addedDate))}'><i class='icon-time icon-large'></i> {!echo formatTime($article->addedDate)}</dd>
        <dd data-toggle='tooltip' data-placement='top' data-original-title='{!printf($lang->book->lblAuthor, $article->author)}'><i class='icon-user icon-large'></i> {!echo $article->author}</dd>
        <dd data-toggle='tooltip' data-placement='top' data-original-title='{!printf($lang->book->lblViews, $article->views)}'><i class='icon-eye-open'></i> {!echo $config->viewsPlaceholder}</dd>
        {if($article->editor)}
        <dd data-toggle='tooltip' data-placement='top' ><i class='icon-edit icon-large'></i>{!printf($lang->book->lblEditor, $control->loadModel('user')->getByAccount($article->editor)->realname, formatTime($article->editedDate))}</dd>
        {/if}
      </dl>
      {if($article->summary and $article->type != 'book')}
        <section class='abstract'><strong>{!echo $lang->book->summary}</strong>{!echo $lang->colon . $article->summary}</section>
      {/if}
    </header>
    <section class='article-content'>
      {if(isset($content) and $article->type != 'book')} {$content} {/if}
      {if($article->type == 'book')}  {$article->content} {/if}
  
    </section>
    <section>{$control->loadModel('file')->printFiles($article->files)}</section>
    <footer>
      {if($article->keywords)}
        <p class='small'><strong class='text-muted'>{!echo $lang->book->keywords}</strong><span class='article-keywords'>{!echo $lang->colon . $article->keywords}</span></p>
      {/if}
      {if(isset($prevAndNext))}
        {@extract($prevAndNext)}
        <ul class='pager pager-justify'>
          {if($prev)}
            <li class='previous' title='{!echo $prev->title}'>{!html::a(inlink('read', "articleID=$prev->id", "book={{$book->alias}}&node={{$prev->alias}}") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), "<i class='icon-arrow-left'></i> <span>" . $prev->title . '</span>')}</li>
          {else}
            <li class='previous disabled'><a href='###'><i class='icon-arrow-left'></i> {!print($lang->book->none)}</a></li>
          {/if}
          {if($control->config->book->chapter == 'home' or !$control->get->fullScreen)}
            <li class='back'> {!html::a(inlink('browse', "bookID={{$parent->id}}", "book={{$book->alias}}&title={{$parent->alias}}") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), "<i class='icon-list-ul'></i> " . $lang->book->chapter)} </li>
          {/if}
          {if($next)}
            <li class='next' title='{!echo $next->title}'>{!html::a(inlink('read', "articleID=$next->id", "book={{$book->alias}}&node={{$next->alias}}") . ($control->get->fullScreen ? "?fullScreen={{$control->get->fullScreen}}" : ''), '<span>' . $next->title . "</span> <i class='icon-arrow-right'></i>")}</li>
          {else}
            <li class='next disabled'><a href='###'> {!print($lang->book->none)}<i class='icon-arrow-right'></i></a></li>
          {/if}
        </ul>
      {/if}
    </footer>
  </div>
  {if(commonModel::isAvailable('message'))} {!echo "<div id='commentBox'>" . $control->fetch('message', 'comment', "objectType=book&objectID={{$article->id}}") . "</div>"} {/if}
  <div class='blocks' data-region='book_read-bottom'>{$control->block->printRegion($layouts, 'book_read', 'bottom')}</div>
  {if($control->config->book->chapter == 'left')}
    </div>
  </div>
  {/if}
  {include TPL_ROOT . 'common/video.html.php'}
  {include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
{/if}
