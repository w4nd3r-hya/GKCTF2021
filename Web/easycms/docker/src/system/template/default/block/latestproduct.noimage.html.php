{if(!defined("RUN_MODE"))} {!die()} {/if}
  <div class='panel-body'>
    <ul class='ul-list'>
      {foreach($products as $product)}
        {$url = helper::createLink('product', 'view', "id=$product->id", "category={{$product->category->alias}}&name=$product->alias")}
        <li>
          <span class='text-latin pull-right'>
          {if(isset($content->showPrice) and $content->showPrice)}
            <span>
            {if(!$product->unsaleable)}
              {if($product->negotiate)}
                &nbsp;&nbsp;
                <strong class='text-danger'>{$lang->product->negotiate}</strong>
              {else}
                {if($product->promotion != 0)}
                  {if($product->price != 0)}
                    <small class='text-muted'>{$config->product->currencySymbol}</small>
                    <del><small class='text-muted'>{$product->price}</small></del>
                  {/if}
                  &nbsp; <small class='text-muted'>{$config->product->currencySymbol}</small>
                  <strong class='text-danger'>{$product->promotion}</strong>
                {elseif($product->price != 0)}
                   &nbsp; <small class='text-muted'>{$config->product->currencySymbol}</small>
                   <strong class='text-important'>{$product->price}</strong>
                {/if}
              {/if}
            {/if}
          {/if}
          </span>
          {if(isset($content->showViews) and $content->showViews)}
            <span> <i class="icon icon-eye-open"></i> {!echo $product->views} </span>
          {/if}
          </span>
          {if(isset($content->showCategory) and $content->showCategory == 1)}
            {if($content->categoryName == 'abbr')}
            {$categoryName = '[' . ($product->category->abbr ? $product->category->abbr : $product->category->name) . '] '}
            {!html::a(helper::createLink('product', 'browse', "categoryID={{$product->category->id}}", "category={{$product->category->alias}}"), $categoryName)}
            {else}
            {!html::a(helper::createLink('product', 'browse', "categoryID={{$product->category->id}}", "category={{$product->category->alias}}"), '[' . $product->category->name . '] ')}
            {/if}
          {/if}
          {!html::a($url, $product->name)}
        </li>
        {if(isset($content->showInfo) and isset($content->infoAmount))}
          {$productInfo = empty($product->desc) ? $product->content : $product->desc}
          {$productInfo = strip_tags($productInfo)}
          {$productInfo = (mb_strlen($productInfo) > $content->infoAmount) ? mb_substr($productInfo, 0 , $content->infoAmount, 'utf8') : $productInfo}
        <div style='padding-left:30px;'>{!echo $productInfo}</div>
        {/if}
      {/foreach}
    </ul>
  </div>
