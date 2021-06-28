{if(!defined("RUN_MODE"))} {!die()} {/if}
{if($isSearchAvaliable)}
  <div id='searchbar' data-ve='search'>
    <form action='{!helper::createLink('search')}' method='get' role='search'>
      <div class='input-group'>
        {$config->searchWordPlaceHolder}
        {if($config->requestType == 'GET')} {!html::hidden($config->moduleVar, 'search') . html::hidden($config->methodVar, 'index')} {/if}
        <div class='input-group-btn'>
          <button class='btn btn-default' type='submit'><i class='icon icon-search'></i></button>
        </div>
      </div>
    </form>
  </div>
{/if}

