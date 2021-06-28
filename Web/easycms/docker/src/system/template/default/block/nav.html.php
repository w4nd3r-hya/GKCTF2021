{if(!defined("RUN_MODE"))} {!die()} {/if}
{$topNavs = $model->loadModel('nav')->getNavs('desktop_top')}
<nav id='navbar' class='navbar' data-type='desktop_top'>
  <div class='navbar-header'>
    <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#navbarCollapse'>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
    </button>
  </div>
  <div class='collapse navbar-collapse' id='navbarCollapse'>
    <ul class='nav navbar-nav'>
      {$navCount = count($topNavs)}
      {$i =0}
      {foreach($topNavs as $nav1)}
        {if(empty($nav1->children))}
          <li class='{!$nav1->class}'>{!html::a($nav1->url, $nav1->title, "target='$nav1->target'")}</li>
        {else}
          <li class="{!echo $nav1->hover . " " . $nav1->class}">
            {!html::a($nav1->url, $nav1->title . " <b class='caret'></b>", 'class="dropdown-toggle" data-toggle="dropdown"')}
            <ul class='dropdown-menu' role='menu'>
              {foreach($nav1->children as $nav2)}
                {if(empty($nav2->children))}
                  <li class='{!$nav2->class}'>{!html::a($nav2->url, $nav2->title, "target='$nav2->target'")}</li>
                {else}
                  <li class="dropdown-submenu {!$nav2->class} {if($i == $navCount -1)} pull-left {/if}">
                    {!html::a($nav2->url, $nav2->title, ($nav2->target != 'modal') ? "target='$nav2->target'" : '')}
                    <ul class='dropdown-menu' role='menu'>
                      {foreach($nav2->children as $nav3)}
                        <li>{!html::a($nav3->url, $nav3->title, ($nav3->target != 'modal') ? "target='$nav3->target'" : '')}</li>
                      {/foreach}
                    </ul>
                  </li>
                {/if}
              {/foreach}<!-- end nav2 -->
            </ul>
          </li>
        {/if}
        {$i += 1}
      {/foreach}<!-- end nav1 -->
      {if(!$setting->compatible && ($setting->bottom == 'navAndSearch' or ($setting->middle->center == 'nav' and $setting->middle->right == 'search')))}
      <li class='nav-item-searchbar'>{include TPL_ROOT . 'block' . DS . "searchbar.html.php"}</li>
      {/if}
    </ul>
  </div>
</nav>

