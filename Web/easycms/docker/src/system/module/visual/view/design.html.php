<?php if(!defined("RUN_MODE")) die();?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/codeeditor.html.php';?>
<?php
js::set('debug', $config->debug);
js::set('device', $this->app->clientDevice);
js::set('template', $template);
js::set('theme', $theme);
js::set('region', $region);
js::set('page', $page);
js::set('visualLang', $lang->visual->js);
?>
<div id='dsBox' class='dock fade'>
  <div class='box dock-left' id='dsPageList'>
    <ul class='nav dock'>
      <li>&nbsp; </li>
      <?php foreach($config->block->pageGroupList as $group => $pageList):?>
      <li class='group'>
        <ul>
          <?php foreach($pageList as $thisPage):?>
          <li class='item<?php if($thisPage == $page) echo ' active';?>'>
            <?php commonModel::printLink('visual', 'design', "page={$thisPage}", $lang->block->{$template}->pages[$thisPage]);?>
          </li>
          <?php endforeach;?>
        </ul>
      </li>
      <?php endforeach;?>
    </ul>
    <button title='<?php echo $lang->visual->design->hidePageTmpl?>' type='button' id='dsMenuToggle' class='ds-menu-toggle btn btn-link'><i class='icon icon-double-angle-left'></i></button>
  </div>
  <div id='dsMenu' class='dock dock-top'>
    <ol class='breadcrumb'>
      <li><?php commonModel::printLink('ui', 'setTemplate', '', $lang->ui->themeList, "title='{$lang->ui->setTheme}' id='backBtn'");?></li>
      <li><?php echo html::a('', $templateData['themes'][$theme]);?></li>
      <li><?php commonModel::printLink('visual', 'design', "page={$page}", $lang->block->{$template}->pages[$page]);?></li>
    </ol>
    <div class='actions dock-right'>
      <?php commonModel::printLink('visual', 'index', '', '<i class="icon icon-magic"></i> ' . $lang->visual->common, "class='btn btn-sm btn-success' target='_blank'");?>
      <?php commonModel::printLink('ui', 'exportTheme', '', '<i class="icon icon-download"></i> ' . $lang->ui->exportTheme, "class='btn btn-sm btn-primary' data-toggle='modal' data-width='600'");?>
    </div>
  </div>
  <div id='dsPreview' class='dock box'>
    <div class='dock' id='preview'>
      <div class='preview-page'>
        <?php
        foreach ($layout as $layoutItem)
        {
            $this->visual->printLayoutItem($layoutItem, $region, $page);
        }
        ?>
      </div>
      <div class='load-indicator'><i class='icon icon-spin icon-spinner icon-2x text-primary'></i></div>
    </div>
  </div>
  <div id='dsTool' class='dock-right box'>
    <header class='dock-top'>
      <ul class='nav nav-secondary nav-justified'>
        <li class='active'><a href='#tabBlock' data-toggle='tab'><?php echo $lang->visual->design->block?></a></li>
        <?php if($isPageAll): ?>
        <li><a href='#tabSkin' data-toggle='tab'><?php echo $lang->visual->design->skin?></a></li>
        <?php else:?>
        <li class='disabled'><a><?php echo $lang->visual->design->skin?></a></li>
        <?php endif;?>
        <li><a href='#tabCss' data-toggle='tab'><?php echo $lang->ui->theme->extraStyle?></a></li>
        <li><a href='#tabJS' data-toggle='tab'><?php echo $lang->ui->theme->extraScript?></a></li>
      </ul>
    </header>
    <div class='dock content tab-content'>
      <div class='tab-pane fade active in dock' id='tabBlock'>
        <div id='blocks' class='dock box'>
          <header class='dock-top'>
            <div class='form-group'>
              <select class='form-control' id='blockListSelector'>
                <?php foreach($categoryList as $category => $blockList):?>
                  <option value='<?php echo $category;?>'><?php echo $lang->block->categoryList[$category];?></option>
                <?php endforeach;?>
              </select>
            </div>
            <div class='actions dock-right'>
              <?php commonModel::printLink('block', 'create', '', '<i class="icon icon-plus"></i> ' . $lang->block->create, "class='btn btn-sm btn-link' data-toggle='modal' data-width='80%' data-type='iframe'");?>
            </div>
          </header>
          <div class='content dock' id='blockLists'>
            <?php foreach($categoryList as $category => $blockList):?>
              <div class='block-list clearfix hidden' data-id='<?php echo $category;?>'>
              <?php $isCategoryEmpty = true;?>
              <?php foreach($blocks as $block):?>
                <?php
                if(strpos($blockList, ",$block->type,") === false) continue;
                if(strpos($block->type, 'code') === false && !is_object($block)) $block->content = json_decode($block->content);
                $isCategoryEmpty = false;
                ?>
                <div class='block-item' data-type='<?php echo $block->type;?>' data-id='<?php echo $block->id;?>' data-title='<?php echo $block->title;?>'>
                  <div class='title' title='<?php echo $block->title;?>'>
                    <?php echo $block->title;?>&nbsp;
                    <?php if($typeList[$block->type] != $block->title):?>
                    <small class='text-muted nobr'><?php echo $typeList[$block->type] ?></small>
                    <?php endif; ?>
                  </div>
                  <div class='actions'>
                    <?php commonModel::printLink('block', 'edit', "block={$block->id}", '<i class="icon icon-pencil"></i>', "class='btn btn-link' data-toggle='modal' data-width='80%' data-type='iframe' title='$lang->edit'");?>
                    <?php commonModel::printLink('block', 'delete', "block={$block->id}", '<i class="icon icon-remove"></i>', "class='btn btn-link deleter' title='$lang->delete'");?>
                    <a class='btn btn-link btn-move' data-toggle='tooltip' title='<?php echo $lang->visual->design->dragAndAdd;?>'><i class="icon icon-move"></i></a>
                  </div>
                </div>
              <?php endforeach;?>
              <?php if($category == 'system'):?>
                <div class='block-item' data-type='region' data-id='region' data-title='<?php echo $lang->visual->js->subRegion;?>'>
                  <div class='title' title='<?php echo $lang->visual->js->subRegionDesc;?>'><?php echo $lang->visual->js->subRegion;?> &nbsp; <small class='text-muted nobr'><?php echo $lang->visual->js->subRegionDesc;?></small></div>
                  <div class='actions'>
                    <a class='btn btn-link btn-move' data-toggle='tooltip' title='<?php echo $lang->visual->design->dragAndAdd;?>'><i class="icon icon-move"></i></a>
                  </div>
                </div>
                <div class='block-item' data-type='region' data-id='region' data-random=true data-title='<?php echo $lang->visual->js->randomRegion;?>'>
                  <div class='title' title='<?php echo $lang->visual->js->randomRegionDesc;?>'><?php echo $lang->visual->js->randomRegion;?> &nbsp; <small class='text-muted nobr'><?php echo $lang->visual->js->randomRegionDesc;?></small></div>
                  <div class='actions'>
                    <a class='btn btn-link btn-move' data-toggle='tooltip' title='<?php echo $lang->visual->design->dragAndAdd;?>'><i class="icon icon-move"></i></a>
                  </div>
                </div>
              <?php $isCategoryEmpty = false;?>
              <?php endif; ?>
              <?php if($isCategoryEmpty):?>
              <div class='with-padding text-muted text-center'><?php echo $lang->visual->design->noBlockTip;?></div>
              <?php endif; ?>
              </div>
            <?php endforeach;?>
          </div>
        </div>
      </div>
      <?php if($isPageAll): ?>
      <div class='tab-pane fade dock' id='tabSkin'>
        <?php if(!$hasPriv):?>
        <div class='alert alert-danger'><?php echo $errors;?></div>
        <?php else:?>
        <form method='post' action='<?php echo helper::createLink('ui', 'customtheme', "theme={$theme}&template={$template}");?>' id='customThemeForm' class='form dock box' data-theme='<?php echo $theme?>' data-template='<?php echo $template?>'>
          <header class='dock-top'>
            <ul class='nav nav-tabs'>
              <?php if(isset($this->config->ui->themes[$template][$theme])):?>
              <?php $activedFirst = false; ?>
              <?php foreach($lang->ui->groups as $group => $name):?>
              <li<?php if(!$activedFirst) echo ' class="active"'?>><?php echo html::a('#' . $group . 'Tab', $name, "data-toggle='tab' class='theme-control-tab'");?></li>
              <?php if(!$activedFirst) $activedFirst = true;?>
              <?php endforeach;?>
              <?php endif;?>
            </ul>
          </header>
          <div class='content dock tab-content'>
            <?php if(isset($this->config->ui->themes[$template][$theme])):?>
            <?php foreach($lang->ui->groups as $group => $name):?>
            <?php $activedFirst = false; ?>
            <div class='tab-pane theme-control-tab-pane fade<?php if(!$activedFirst) echo ' active in';?>' id='<?php echo $group?>Tab'>
              <?php
                $options = isset($config->ui->themes[$template][$theme][$group]) ? $config->ui->themes[$template][$theme][$group] : '';
                if($options) foreach($options as $selector => $attributes):
              ?>
                <div class='theme-group'>
                  <div class='theme-group-name'><?php echo $lang->ui->{$selector};?></div>
                  <div class='them-item-list'>
                  <?php foreach($attributes as $label => $params):?>
                    <?php $value = isset($setting[$params['name']]) ? $setting[$params['name']] : '';?>
                    <div class='theme-item' title='@<?php echo $params['name']?>'><?php $this->ui->printFormControl($label, $params, $value);?></div>
                  <?php endforeach;?>
                  </div>
                </div>
              <?php endforeach;?>
            </div>
            <?php if(!$activedFirst) $activedFirst = true;?>
            <?php endforeach;?>
            <?php endif;?>
          </div>
          <footer class='dock-bottom'>
            <?php echo html::hidden('theme', $theme) . html::hidden('template', $template) . html::submitButton();?>
            <button type='button' id='resetTheme' class='btn btn-danger' data-success-tip='<?php echo $lang->ui->theme->resetTip?>'><?php echo $lang->ui->theme->reset?></button>
          </footer>
        </form>
        <?php endif;?>
      </div>
      <?php endif; ?>
      <form method='post' action='<?php echo helper::createLink('ui', 'setcode', "page={$page}");?>' class='tab-pane dock theme-control-tab-pane' id='tabCss'>
        <?php echo html::textarea('css', zget($this->config->css, "{$template}_{$theme}_{$page}", ''), "rows=20 class='form-control codeeditor' data-mode='css' data-height='350'");?>
        <footer class='dock-bottom'>
          <button type='submit' class='btn btn-primary'><?php echo $lang->save . ' ' . $lang->ui->theme->extraStyle;?></button>
        </footer>
     </form>
     <form method='post' action='<?php echo helper::createLink('ui', 'setcode', "page={$page}");?>' class='tab-pane dock theme-control-tab-pane' id='tabJS'>
        <?php echo html::textarea('js', zget($this->config->js, "{$template}_{$theme}_{$page}", ''), "rows=20 class='form-control codeeditor' data-mode='javascript' data-height='350'");?>
        <footer class='dock-bottom'>
          <button type='submit' class='btn btn-primary'><?php echo $lang->save . ' ' . $lang->ui->theme->extraScript;?></button>
        </footer>
    </form>
  </div>
</div>

<?php include '../../common/view/footer.admin.html.php';?>
