<?php if(!class_exists('raintpl')){exit;}?><?php if(!defined("RUN_MODE")){ ?>

<?php echo die(); ?>

<?php } ?>


<?php $isWidthSearchBar=$this->var['isWidthSearchBar'] = false;?>

<?php if($setting->top->right and strpos(',searchAndLogin,search,loginAndSearch,', ',' . $setting->top->right . ',') !== false){ ?>

  <?php $isWidthSearchBar=$this->var['isWidthSearchBar'] = true;?>

<?php } ?>

<?php if($setting->top->right == 'custom'){ ?>

  <?php foreach(array('searchAndLogin', 'search', 'loginAndSearch') as $searchItem): ?>

    <?php if(strpos($setting->topRightContent, strtoupper($searchItem)) !== false){ ?>

      <?php $isWidthSearchBar=$this->var['isWidthSearchBar'] = true;?>

      <?php break; ?>

<?php } ?>

  <?php endforeach; ?>

<?php } ?>

<header id='header' class='<?php if($setting->bottom){ ?>

<?php echo 'without-navbar'; ?>

<?php } ?>'>
  <?php if($setting->top->left or $setting->top->right){ ?>

  <div id='headNav' class='<?php if($setting->top->left == 'slogan'){ ?>

<?php echo 'with-slogan'; ?>

<?php } ?>

<?php if($isWidthSearchBar){ ?>

<?php echo ' with-searchbar'; ?>

<?php } ?>'>
    <div class='row'>
      <?php if($setting->top->left == 'slogan'){ ?>

        <div id='siteSlogan' class='nobr'><span><?php echo $config->site->slogan;?></span></div>
      <?php }elseif($setting->topLeftContent){ ?>

        <div class='nobr pull-left'><span><?php echo htmlspecialchars_decode($setting->topLeftContent, ENT_QUOTES); ?></span></div>
      <?php } ?>

      <?php if($setting->top->right == 'loginAndSearch'){ ?>

        <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'searchbar'));?>

        <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'sitenav'));?>

      <?php }elseif($setting->top->right == 'searchAndLogin'){ ?>

        <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'sitenav'));?>

        <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'searchbar'));?>

      <?php }elseif($setting->top->right == 'login'){ ?>

        <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'sitenav'));?>

      <?php }elseif($setting->top->right == 'search'){ ?>

        <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'searchbar'));?>

<?php } ?>

      <?php if($setting->top->right == 'custom'){ ?>

        <?php if(strpos($setting->topRightContent, '$LOGIN') === false and strpos($setting->topRightContent, '$SEARCH') === false){ ?>

          <?php echo " <div class='custom-top-right'>" . htmlspecialchars_decode($setting->topRightContent, ENT_QUOTES) .  "</div> "; ?>

        <?php }else{ ?>

          <div class='custom-top-right'>
          <?php $loginPos=$this->var['loginPos']  = strpos($setting->topRightContent, '$LOGIN');?>

          <?php $searchPos=$this->var['searchPos'] = strpos($setting->topRightContent, '$SEARCH');?>

          <?php if($loginPos !== false and $searchPos !== false){ ?>

            <?php if($loginPos > $searchPos){ ?>

              <?php echo "<div class='custom-top-right-content'>" . htmlspecialchars_decode(substr($setting->topRightContent, $loginPos + 6), ENT_QUOTES) . "</div>"; ?>

              <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'sitenav'));?>

              <?php echo "<div class='custom-top-right-content'>" . htmlspecialchars_decode(substr($setting->topRightContent, $searchPos + 7, $loginPos - $searchPos - 7), ENT_QUOTES) . "</div>"; ?>

              <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'searchbar'));?>

              <?php echo "<div class='custom-top-right-content'>" . htmlspecialchars_decode(substr($setting->topRightContent, 0, $searchPos), ENT_QUOTES) . "</div>"; ?>

            <?php }else{ ?>

              <?php echo "<div class='custom-top-right-content'>" . htmlspecialchars_decode(substr($setting->topRightContent, $searchPos + 7), ENT_QUOTES) . "</div>"; ?>

              <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'searchbar'));?>

              <?php echo "<div class='custom-top-right-content'>" . htmlspecialchars_decode(substr($setting->topRightContent, $loginPos + 6, $searchPos - $loginPos - 6), ENT_QUOTES) . "</div>"; ?>

              <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'sitenav'));?>

              <?php echo "<div class='custom-top-right-content'>" . htmlspecialchars_decode(substr($setting->topRightContent, 0, $loginPos), ENT_QUOTES) . "</div>"; ?>

<?php } ?>

            <?php if($loginPos !== false){ ?>

              <?php echo "<div class='custom-top-right-content'>" . htmlspecialchars_decode(substr($setting->topRightContent, $loginPos + 6), ENT_QUOTES) . "</div>"; ?>

              <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'sitenav'));?>

              <?php echo "<div class='custom-top-right-content'>" . htmlspecialchars_decode(substr($setting->topRightContent, 0, $loginPos), ENT_QUOTES) . "</div>"; ?>

            <?php }else{ ?>

              <?php echo "<div class='custom-top-right-content'>" . htmlspecialchars_decode(substr($setting->topRightContent, $searchPos + 7), ENT_QUOTES) . "</div>"; ?>

              <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'searchbar'));?>

              <?php echo "<div class='custom-top-right-content'>" . htmlspecialchars_decode(substr($setting->topRightContent, 0, $searchPos), ENT_QUOTES) . "</div>"; ?>

<?php } ?>

          <?php } ?>

          </div>
        <?php } ?>

<?php } ?>

    </div>
  </div>
  <?php } ?>

  <div id='headTitle' class='<?php if($setting->middle->center == 'nav'){ ?>

<?php echo 'with-navbar'; ?>

<?php } ?>

<?php if($setting->middle->center == 'slogan'){ ?>

<?php echo ' with-slogan'; ?>

<?php } ?> '>
    <div class='row'>
      <div id='siteTitle'>
        <?php if($setting->middle->left == 'logo'){ ?>

          <?php if($logo){ ?>

          <div id='siteLogo' data-ve='logo'><?php echo html::a(helper::createLink('index'), html::image($model->loadModel('file')->printFileURL($logo), "class='logo' alt='{$config->company->name}' title='{$config->company->name}'")); ?></div>
          <?php }else{ ?>

          <div id='siteName' data-ve='logo'><h2><?php echo html::a(helper::createLink('index'), $config->site->name); ?></h2></div>
          <?php } ?>

<?php } ?>

        <?php if($setting->middle->center == 'slogan'){ ?>

        <div id='siteSlogan' data-ve='slogan'><span><?php echo $config->site->slogan;?></span></div>
        <?php } ?>

      </div>
      <?php if($setting->middle->center == 'nav'){ ?>

      <div id='navbarWrapper'><?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'nav'));?></div>
      <?php } ?>

      <?php if($setting->middle->right == 'search' and $setting->middle->center != 'nav'){ ?>

<?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'searchbar'));?>

<?php } ?>

    </div>
  </div>
</header>
<?php if($setting->top->right == 'custom'){ ?>

  <style>
  
  #searchbar{padding-left: 10px;}
  .custom-top-right {display:inline-block; width:auto; float:right; position:relative;margin-right: 5px;margin-left: 5px;}
  .custom-top-right-content {display:inline-block; width:auto; float:right; position:relative;margin-right: 5px;margin-left: 5px;}
  
  <?php if($config->template->desktop->theme != 'wide'){ ?>

    
    #searchbar .form-control{height: 25px; line-height: 25px;}
    #searchbar .btn{line-height: 10px;}
    
<?php } ?>

  
  #searchbar {float: right;}
  #searchbar > form {float: none; margin: 4px 0}
  @media (max-width: 767px){#headNav > .row > #searchbar {display: none} }
  
  </style>
<?php } ?>

<?php if(strpos(strtolower($setting->bottom), 'nav') !== false){ ?>

<?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'nav'));?>

<?php } ?>


<style>
#header {padding: 0; margin-bottom: 14px;}
#headNav {min-height: 30px; line-height: 30px; padding: 0; margin-bottom: 8px;}
#headNav, #headTitle {position: static; display: block;}
#headNav > .row {margin: 0}
#headTitle > .row, #headNav > .row {display: table; width: 100%; margin: 0}
#headNav > .row > #siteNav,
#headNav > .row > #siteSlogan,
#headNav > .row > #searchbar,
#headTitle > .row > #siteTitle,
#headTitle > .row > #searchbar {display: table-cell; vertical-align: middle;}

#headTitle {padding: 0;}
#siteNav {text-align: right; float: right; display: inline-block !important;}
@media (max-width: 767px){#siteNav {padding-left: 8px; padding-right: 8px;} }

#searchbar {max-width: initial;}
#searchbar > form {max-width: 200px; float: right;}
#navbar .navbar-nav {width: 100%}
#navbarCollapse {padding: 0;}
#navbar .navbar-nav {margin: 0;}
#navbar li.nav-item-searchbar {float: right;}
#navbar li.nav-item-searchbar #searchbar > form {margin: 4px;}


<?php if($setting->top->right == 'loginAndSearch'){ ?>

 #searchbar{padding-left: 10px;} 
<?php } ?>


<?php if($setting->top->right == 'searchAndLogin'){ ?>

 #searchbar{padding-right: 10px;} 
<?php } ?>


<?php if(strpos(',search,searchAndLogin,loginAndSearch,', ',' . $setting->top->right . ',') !== false){ ?>

<?php if($config->template->desktop->theme != 'wide'){ ?>


#searchbar .form-control{height: 25px; line-height: 25px;}
#searchbar .btn{line-height: 10px;}

<?php } ?>


#searchbar {float: right;}
#searchbar > form {float: none; margin: 4px 0}
@media (max-width: 767px){#headNav > .row > #searchbar {display: none} }

<?php } ?>


<?php if($setting->bottom == 'navAndSearch' or ($setting->middle->center == 'nav' and $setting->middle->right == 'search')){ ?>

 #searchbar {min-width: 80px} 
<?php } ?>


<?php if($setting->top->left == 'slogan' or $setting->topLeftContent){ ?>


#headNav #siteSlogan {padding: 0; font-size: 16px; line-height: 30px; text-align: left;}
@media (max-width: 767px){#headNav #siteSlogan {padding-left: 8px; padding-right: 8px;} }

<?php } ?>


<?php if($setting->middle->center == 'nav'){ ?>


#headTitle > .row > #navbarWrapper {display: table-cell; vertical-align: middle; padding-left: 8px;}
#headTitle > .row > #navbarWrapper > #navbar {margin:0}
#siteTitle, #siteLogo img {min-width: 150px;}
@media (max-width: 767px)
{
  #headTitle {padding: 0;}
  #headTitle > .row {margin: 0; display: block;}
  #headTitle > .row > #siteTitle {display: block; position: absolute; z-index: 10015; left: 8px;}
  #headTitle > .row > #navbarWrapper {display: block; padding: 0}
  #headTitle > .row > #navbarWrapper > #navbar {margin-bottom: 14px; width: 100%}
  #headTitle #siteLogo img {margin-top: 2px;}
}

<?php } ?>

</style>
