<?php if(!class_exists('raintpl')){exit;}?><?php if(!defined("RUN_MODE")){ ?>


<?php echo die(); ?>

<?php } ?>

<?php $topNavs=$this->var['topNavs'] = $model->loadModel('nav')->getNavs('desktop_top');?>


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
      <?php $navCount=$this->var['navCount'] = count($topNavs);?>


      <?php $i=$this->var['i'] =0;?>

      <?php foreach($topNavs as $nav1): ?>


        <?php if(empty($nav1->children)){ ?>


          <li class='<?php echo $nav1->class; ?>'><?php echo html::a($nav1->url, $nav1->title, "target='$nav1->target'"); ?>

</li>
        <?php }else{ ?>

          <li class="<?php echo $nav1->hover . " " . $nav1->class; ?>">
            <?php echo html::a($nav1->url, $nav1->title . " <b class='caret'></b>", 'class="dropdown-toggle" data-toggle="dropdown"'); ?>


            <ul class='dropdown-menu' role='menu'>
              <?php foreach($nav1->children as $nav2): ?>


                <?php if(empty($nav2->children)){ ?>


                  <li class='<?php echo $nav2->class; ?>'><?php echo html::a($nav2->url, $nav2->title, "target='$nav2->target'"); ?>

</li>
                <?php }else{ ?>

                  <li class="dropdown-submenu <?php echo $nav2->class; ?> <?php if($i == $navCount -1){ ?>

 pull-left <?php } ?>">
                    <?php echo html::a($nav2->url, $nav2->title, ($nav2->target != 'modal') ? "target='$nav2->target'" : ''); ?>


                    <ul class='dropdown-menu' role='menu'>
                      <?php foreach($nav2->children as $nav3): ?>


                        <li><?php echo html::a($nav3->url, $nav3->title, ($nav3->target != 'modal') ? "target='$nav3->target'" : ''); ?>

</li>
                      <?php endforeach; ?>

                    </ul>
                  </li>
                <?php } ?>

              <?php endforeach; ?><!-- end nav2 -->
            </ul>
          </li>
        <?php } ?>

        <?php $i=$this->var['i'] += 1;?>

      <?php endforeach; ?><!-- end nav1 -->
      <?php if(!$setting->compatible && ($setting->bottom == 'navAndSearch' or ($setting->middle->center == 'nav' and $setting->middle->right == 'search'))){ ?>


      <li class='nav-item-searchbar'><?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw(TPL_ROOT . 'block' . DS . "searchbar.html.php");?></li>
      <?php } ?>

    </ul>
  </div>
</nav>

