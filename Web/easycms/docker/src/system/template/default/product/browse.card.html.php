{if(!defined("RUN_MODE"))} {!die()} {/if}
<section id="cardMode" class='cards cards-products cards-borderless hide'>
  {foreach($products as $product)}
  <div class='col-sm-4 col-xs-6'>
    <div class='card' data-ve='product' id='product{$product->id}'>
      {if(empty($product->image))}
        {!html::a(inlink('view', "id=$product->id", "category={{$product->category->alias}}&name=$product->alias"), '<div class="media-placeholder" data-id="' . $product->id . '">' . $product->name . '</div>', "class='media-wrapper'");}
      {else}
        {$title = $product->image->primary->title ? $product->image->primary->title : $product->name}
        {!html::a(inlink('view', "id=$product->id", "category={{$product->category->alias}}&name=$product->alias"), html::image($control->loadModel('file')->printFileURL($product->image->primary, 'middleURL'), "title='{{$title}}' alt='{{$product->name}}'"), "class='media-wrapper'")}
      {/if}
      <div class='card-heading'>
        {$showPrice    = isset($control->config->product->showPrice) ? $control->config->product->showPrice : true}
        {$showViews    = isset($control->config->product->showViews) ? $control->config->product->showViews : true}
        {$namePosition = isset($control->config->product->namePosition) ? 'text-' . $control->config->product->namePosition : ''}
        {if($showPrice)}
        <div class='price'>
          {$currencySymbol = $control->config->product->currencySymbol}
          {if(!$product->unsaleable)}
            {if($product->negotiate)}
               {!echo "<span class='text-danger'>" . $lang->product->negotiate . '</span>'}
            {else}
               {if($product->promotion != 0)}
                 {!echo "<strong class='text-danger' style='margin:-3px;'>" . $currencySymbol . $product->promotion . '</strong>'}
               {else}
                 {if($product->price != 0)}
                   {!echo "<strong class='text-danger' style='margin:-3px;'>" . $currencySymbol . $product->price . '</strong>'}
                 {/if}
              {/if}
            {/if}
          {/if}
        </div>
        {/if}
        <div class='text-nowrap text-ellipsis {$namePosition}'>
          <span>{!html::a(inlink('view', "id={{$product->id}}", "category={{$product->category->alias}}&name=$product->alias"), $product->name, "style='color:{{$product->titleColor}}'")}</span>
          {if($showViews)}<span data-toggle='tooltip' class='text-muted views-count' title='{$lang->product->viewsCount}'><i class="icon icon-eye-open"></i> {!echo $config->viewsPlaceholder . $product->id . $config->viewsPlaceholder}</span>{/if}
        </div>
      </div>
    </div>
  </div>
  {/foreach}
</section>
