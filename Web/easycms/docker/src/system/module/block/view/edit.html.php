<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The edit view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php if(helper::isAjaxRequest()):?>
<?php include '../../common/view/header.modal.html.php';?>
<?php else:?>
<?php include '../../common/view/header.admin.html.php';?>
<?php endif;?>
<?php include '../../common/view/chosen.html.php';?>
<?php include '../../common/view/codeeditor.html.php';?>
<?php
js::set('type', $type);
$colorPlates = '';
foreach (explode('|', $lang->colorPlates) as $value)
{
    $colorPlates .= "<div class='color color-tile' data='#" . $value . "'><i class='icon-ok'></i></div>";
}
?>
<?php if(helper::isAjaxRequest()):?>
<form method='post' id='blockForm' class='blockForm ve-form' action="<?php echo inlink('edit', "blockID=$block->id")?>">
<?php else:?>
<form method='post' id='editForm' class='blockForm ve-form'>
<?php endif;?>
  <div class='panel'>
    <div class='panel-heading'>
      <ul class='nav nav-tabs'>
        <li><a href='#contentTab' data-toggle='tab'><?php echo $lang->block->content;?></a></li>
        <?php if($type != 'baidustat'):?>
        <?php if(strpos(',htmlcode, phpcode, header', $type) == false or $type == 'html'):?>
        <li><a href='#customTab' data-toggle='tab'><?php echo $lang->block->style;?></a></li>
        <?php endif;?>
        <li><a href='#cssTab' data-toggle='tab'><?php echo $lang->ui->theme->extraStyle; ?></a></li>
        <li><a href='#jsTab' data-toggle='tab'><?php echo $lang->ui->theme->extraScript; ?></a></li>
        <?php endif;?>
      </ul>
    </div>
    <div class='panel-body'>
      <div class='table-row'>
        <?php if(strpos(',htmlcode, phpcode, slide, header, baidustat', $type) === false):?>
        <div class='tab-content table-cell col-xs-7'>
        <?php elseif($type == 'html'):?>
        <div class='tab-content table-cell col-xs-9'>
        <?php else: ?>
        <div class='tab-content table-cell col-xs-12'>
        <?php endif; ?>
          <div class='tab-pane theme-control-tab-pane' id='contentTab'>
            <table align='center' class='table table-form mg-0'>
              <tr>
                <th class='w-120px'><?php echo $lang->block->type;?></th>
                <?php if(strpos(',htmlcode, phpcode, slide, header, baidustat', $type) === false):?>
                <td class='w-400px'><?php echo $this->block->createTypeSelector($template, $type, $block->id);?></td>
                <td></td>
                <?php else:?>
                <td><?php echo $this->block->createTypeSelector($template, $type, $block->id);?></td>
                <?php endif;?>
              </tr>
              <tr>
                <th><?php echo $lang->block->title;?></th>
                <td id='titleTDCell'><?php echo html::input('title', $block->title, "class='form-control'");?> </td>
              </tr>
              <?php if(isset($config->block->defaultIcons[$type])):?>
              <?php if(!isset($block->content->icon)) $block->content->icon = $config->block->defaultIcons[$type];?>
              <tr>
                <th><?php echo $lang->block->icon;?></th>
                <td> <?php echo html::select('params[icon]', '', '', "class='chosen-icons' data-value='{$block->content->icon}'");?> </td>
              </tr>
              <?php endif;?>
              <?php echo $this->fetch('block', 'blockForm', 'type=' . $type . '&id=' . $block->id);?>
              <?php if(isset($config->block->defaultMoreUrl[$type])):?>
              <tr>
                <th><?php echo $lang->block->moreLink;?></th>
                <td>
                  <div class='input-group'>
                    <?php echo html::input('params[moreText]', isset($block->content->moreText) ? $block->content->moreText : '', "class='form-control'  placeholder='{$lang->block->placeholder->moreText}'");?>
                    <span class="input-group-addon fix-border"><i class="icon icon-link"></i></span>
                    <?php echo html::input('params[moreUrl]', isset($block->content->moreUrl) ? $block->content->moreUrl : '', "class='form-control' placeholder='{$lang->block->placeholder->moreUrl}'");?>
                </td>
              </tr>
              <?php endif;?>
            </table>
          </div>
          <?php if(strpos(',htmlcode, phpcode, header, baidustat', $type) == false or $type == 'html'):?>
          <div class='tab-pane theme-control-tab-pane' id='customTab'>
            <table class='table table-form mg-0'>
              <?php if(isset($config->block->defaultIcons[$type])):?>
              <tr>
                <th class='w-100px'><?php echo $lang->block->icon;?></th>
                <td>
                  <div class='colorplate'>
                    <div class='input-group color active' data="<?php echo isset($block->content->custom->$theme->iconColor) ? $block->content->custom->$theme->iconColor : ''?>">
                      <span class='input-group-btn'>
                        <button type='button' class='btn dropdown-toggle' data-toggle='dropdown'>
                          <?php echo $lang->block->iconColor;?> <span class='caret'></span>
                        </button>
                        <div class='dropdown-menu colors'><?php echo $colorPlates; ?></div>
                      </span>
                      <?php echo html::input("params[custom][$theme][iconColor]", isset($block->content->custom->$theme->iconColor) ? $block->content->custom->$theme->iconColor : '', "class='form-control input-color text-latin' placeholder='" . $lang->colorTip . "'");?>
                    </div>
                  </div>
                </td>
                <td></td>
              </tr>
              <?php endif;?>
              <?php if($type != 'slide'):?>
              <tr>
                <th class='w-100px'><?php echo $lang->block->border;?></th>
                <td>
                  <div class='colorplate'>
                    <div class='input-group color active' data="<?php echo isset($block->content->custom->$theme->borderColor) ? $block->content->custom->$theme->borderColor : ''?>">
                      <span class='input-group-btn'>
                        <button type='button' class='btn dropdown-toggle' data-toggle='dropdown'>
                          <?php echo $lang->block->borderColor;?><span class='caret'></span>
                        </button>
                        <div class='dropdown-menu colors'><?php echo $colorPlates; ?></div>
                      </span>
                      <?php echo html::input("params[custom][$theme][borderColor]", isset($block->content->custom->$theme->borderColor) ? $block->content->custom->$theme->borderColor : '', "class='form-control input-color text-latin' placeholder='" . $lang->colorTip . "'");?>
                    </div>
                  </div>
                </td>
              </tr>
              <?php if($type == 'html'):?>
              <tr>
                <th class='w-80px'><?php echo $lang->block->padding;?></th>
                <td colspan='2'>
                  <div class='input-group'>
                    <span class='input-group-addon'><?php echo $lang->block->paddingTop;?></span>
                    <?php echo html::input("params[custom][$theme][paddingTop]", isset($block->content->custom->$theme->paddingTop) ? $block->content->custom->$theme->paddingTop : '', "class='form-control' placeholder='{$lang->block->placeholder->padding}'");?>
                    <span class='input-group-addon fix-border'><?php echo $lang->block->paddingRight;?></span>
                    <?php echo html::input("params[custom][$theme][paddingRight]", isset($block->content->custom->$theme->paddingRight) ? $block->content->custom->$theme->paddingRight : '', "class='form-control' placeholder='{$lang->block->placeholder->padding}'");?>
                    <span class='input-group-addon fix-border'><?php echo $lang->block->paddingBottom;?></span>
                    <?php echo html::input("params[custom][$theme][paddingBottom]", isset($block->content->custom->$theme->paddingBottom) ? $block->content->custom->$theme->paddingBottom : '', "class='form-control' placeholder='{$lang->block->placeholder->padding}'");?>
                    <span class='input-group-addon fix-border'><?php echo $lang->block->paddingLeft;?></span>
                    <?php echo html::input("params[custom][$theme][paddingLeft]", isset($block->content->custom->$theme->paddingLeft) ? $block->content->custom->$theme->paddingLeft : '', "class='form-control' placeholder='{$lang->block->placeholder->padding}'");?>
                  </div>
                </td>
              </tr>
              <?php endif;?>
              <?php if($type !== 'featuredProduct'):?>
              <tr>
                <th class='w-80px'><?php echo $lang->block->heading;?></th>
                <td>
                  <div class='colorplate'>
                    <div class='input-group color active' data="<?php echo isset($block->content->custom->$theme->titleColor) ? $block->content->custom->$theme->titleColor : ''?>">
                      <span class='input-group-btn'>
                        <button type='button' class='btn dropdown-toggle' data-toggle='dropdown'>
                          <?php echo $lang->block->textColor;?> <span class='caret'></span>
                        </button>
                        <div class='dropdown-menu colors'><?php echo $colorPlates; ?></div>
                      </span>
                      <?php echo html::input("params[custom][$theme][titleColor]", isset($block->content->custom->$theme->titleColor) ? $block->content->custom->$theme->titleColor : '', "class='form-control input-color text-latin' placeholder='" . $lang->colorTip . "'");?>
                    </div>
                  </div>
                </td>
                <td>
                  <div class='colorplate'>
                    <div class='input-group color active' data="<?php echo isset($block->content->custom->$theme->titleBackground) ? $block->content->custom->$theme->titleBackground : ''?>">
                      <span class='input-group-btn'>
                        <button type='button' class='btn dropdown-toggle' data-toggle='dropdown'>
                          <?php echo $lang->block->backgroundColor;?> <span class='caret'></span>
                        </button>
                        <div class='dropdown-menu colors'><?php echo $colorPlates; ?></div>
                      </span>
                      <?php echo html::input("params[custom][$theme][titleBackground]", isset($block->content->custom->$theme->titleBackground) ? $block->content->custom->$theme->titleBackground : '', "class='form-control input-color text-latin' placeholder='" . $lang->colorTip . "'");?>
                    </div>
                  </div>
                </td>
              </tr>
              <?php endif;?>
              <?php if($type != 'followUs'):?>
              <tr>
                <th rowspan='2' class='w-80px'><?php echo $lang->block->content;?></th>
                <td>
                  <div class='colorplate'>
                    <div class='input-group color active' data="<?php echo isset($block->content->custom->$theme->textColor) ? $block->content->custom->$theme->textColor : ''?>">
                      <span class='input-group-btn'>
                        <button type='button' class='btn dropdown-toggle' data-toggle='dropdown'>
                          <?php echo $lang->block->textColor;?><span class='caret'></span>
                        </button>
                        <div class='dropdown-menu colors'><?php echo $colorPlates; ?></div>
                      </span>
                      <?php echo html::input("params[custom][$theme][textColor]", isset($block->content->custom->$theme->textColor) ? $block->content->custom->$theme->textColor : '', "class='form-control input-color text-latin' placeholder='" . $lang->colorTip . "'");?>
                    </div>
                  </div>
                </td>
                <td>
                  <div class='colorplate'>
                    <div class='input-group color active' data="<?php echo isset($block->content->custom->$theme->linkColor) ? $block->content->custom->$theme->linkColor : ''?>">
                      <span class='input-group-btn'>
                        <button type='button' class='btn dropdown-toggle' data-toggle='dropdown'>
                          <?php echo $lang->block->linkColor;?><span class='caret'></span>
                        </button>
                        <div class='dropdown-menu colors'><?php echo $colorPlates; ?></div>
                      </span>
                      <?php echo html::input("params[custom][$theme][linkColor]", isset($block->content->custom->$theme->linkColor) ? $block->content->custom->$theme->linkColor : '', "class='form-control input-color text-latin' placeholder='" . $lang->colorTip . "'");?>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class='colorplate'>
                    <div class='input-group color active' data="<?php echo isset($block->content->custom->$theme->backgroundColor) ? $block->content->custom->$theme->backgroundColor : ''?>">
                      <span class='input-group-btn'>
                        <button type='button' class='btn dropdown-toggle' data-toggle='dropdown'>
                          <?php echo $lang->block->backgroundColor;?><span class='caret'></span>
                        </button>
                        <div class='dropdown-menu colors'><?php echo $colorPlates; ?></div>
                      </span>
                      <?php echo html::input("params[custom][$theme][backgroundColor]", isset($block->content->custom->$theme->backgroundColor) ? $block->content->custom->$theme->backgroundColor : '', "class='form-control input-color text-latin' placeholder='" . $lang->colorTip . "'");?>
                    </div>
                  </div>
                </td>
              </tr>
              <?php endif;?>
              <?php endif;?>
              <?php if($type == 'slide'):?>
              <tr>
                <th class='w-80px'><?php echo $lang->block->slideStyle;?></th>
                <td class='w-p40'><?php echo html::select('params[style]', $lang->block->slideStyleList, isset($block->content->style) ? $block->content->style : '', "class='form-control'")?></td><td></td>
              </tr>
              <?php endif;?>
              <tr>
                <th class='w-80px'><?php echo $lang->block->class;?></th>
                <td><?php echo html::input('params[class]', isset($block->content->class) ? $block->content->class : '', "class='form-control' placeholder='{$lang->block->placeholder->class}'");?></td>
              </tr>
            </table>
          </div>
          <?php endif;?>
          <div class='tab-pane theme-control-tab-pane' id='cssTab'>
            <?php echo html::textarea('css', (isset($block->content->custom->$theme->css) && !empty($block->content->custom->$theme->css)) ? $block->content->custom->$theme->css : "#blockID\n{\n  /*.panel-heading {}*/\n  /*.panel-body    {}*/\n}", "rows=20 class='form-control codeeditor' data-mode='css' data-height='350'");?>
            <p class='text-info text-tip'><?php echo $lang->block->placeholder->customStyleTip;?></p>
          </div>
          <div class='tab-pane theme-control-tab-pane' id='jsTab'>
            <?php echo html::textarea('js', isset($block->content->custom->$theme->js) ? $block->content->custom->$theme->js : '', "rows=20 class='form-control codeeditor' data-mode='javascript' data-height='350'");?>
            <?php if($this->app->clientDevice == 'mobile'):?><p class='text-info text-tip'><?php echo $lang->block->placeholder->mobileCustomScriptTip;?></p><?php endif;?>
            <?php if($this->app->clientDevice == 'desktop'):?><p class='text-info text-tip'><?php echo $lang->block->placeholder->desktopCustomScriptTip;?></p><?php endif;?>
          </div>
        </div>
      </div>
      <div class='form-footer'>
        <?php echo html::submitButton() . html::hidden('blockID', $block->id);?>
        <?php if(!helper::isAjaxRequest()):?>
        <?php echo html::a($this->createLink('guarder', 'validate', "url=&target=modal&account=&type=okFile"), $lang->save, "data-toggle='modal' class='hidden captchaModal'")?>
        <?php echo html::a($this->session->blockList, $this->lang->goback, "class='btn btn-default btn-cancel hidden-ve'");?>
        <?php endif;?>
      </div>
    </div>
  </div>
</form>
<?php /* hidden navSource start .*/ ?>
<div id='grade1NavSource' class='hide'>
  <li class='liGrade1'>
    <?php echo $this->loadModel('nav')->createEntry(1, null, 'desktop_bottom');?>
    <ul class='ulGrade2'></ul>
  </li>
</div>
<div id='grade2NavSource' class='hide'>
  <ul class='ulGrade2'>
    <li class='liGrade2'>
      <?php echo $this->loadModel('nav')->createEntry(2, null, 'desktop_bottom');?>
    </li>
  </ul>
</div>
<?php /* hidden navSource end.*/ ?>
<?php if(helper::isAjaxRequest()):?>
<?php include '../../common/view/footer.modal.html.php';?>
<?php else:?>
<?php include '../../common/view/footer.admin.html.php';?>
<?php endif;?>
