<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The obtain view file of theme module of ChanZhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@xirangit.com>
 * @theme     theme
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div id='mainMenu'>
  <div class='container'>
    <ul class='nav nav-underline' id='navMenu'>
      <li><?php echo html::a(inlink('setTemplate'), $lang->ui->files->default->user['thread']);?></li>
      <li class='active'><?php echo html::a(inlink('themestore'), $lang->ui->themeStore);?></li>
    </ul>
    <ul class='nav nav-pills' id='deviceMenu'>
      <li<?php if($this->session->device != 'mobile') echo " class='active'";?>><?php echo html::a($this->createLink('ui', 'setDevice', "device=desktop"), '<i class="icon icon-desktop"></i> ' . $lang->ui->clientDesktop);?></li>
      <li<?php if($this->session->device == 'mobile') echo " class='active'";?>><?php echo html::a($this->createLink('ui', 'setDevice', "device=mobile"), '<i class="icon icon-tablet"></i> ' . $lang->ui->clientMobile);?></li>
    </ul>
  </div>
</div>
<div id='main' class='container'>
  <div id='mainHeader'>
    <ul class='nav nav-dots' id='typeNav'>
      <li data-type='internal' <?php echo ($type == 'byindustry' and $param == 'all') ? "class='active'" : '';?>><?php echo html::a(inlink('themestore'), $lang->ui->theme->all, "id='theme-all'");?></li>
      <?php foreach($lang->ui->theme->searchLabels as $code => $label):?>
      <li data-type='internal' <?php echo $type == $code ? "class='active'" : '';?>>
      <?php echo html::a(inlink('themestore', "type={$code}"), $label);?>
      </li>
      <?php endforeach;?>
      <li data-type='internal' <?php echo ($type == 'byindustry' and $param != 'all') ? "class='active'" : '';?>>
        <?php echo html::a('javascript:;', "<i class='icon icon-angle-down'></i> " . $lang->ui->byIndustry, "id='byindustry'");?>
      </li>
    </ul>
    <div id='industryBox' class='hide'><?php echo $industryTree;?></div>
  </div>
  <div id='mainContent'>
    <?php if($themes):?>
    <div id='storeThemes' class='cards cards-borderless themes row' data-param='<?php echo $param ?>'>
      <?php foreach($themes as $theme):?>
      <?php
      $currentRelease = $theme->currentRelease;
      $latestRelease  = isset($theme->latestRelease) ? $theme->latestRelease : '';

      $themeImages = array();
      ?>
      <div class="col-lg-1_5 col-md-3 col-sm-6">
        <div class="card theme">
          <div class='media-wrapper theme-img'>
            <?php if(!empty($theme->images)):?>
            <?php echo html::a('https://www.chanzhi.org/theme-viewsnap-0-' . $theme->code . '.html', html::image($theme->images[0]), "title='{$theme->name}' data-size='fullscreen' data-toggle='modal' data-show-header='false'");?>
            <?php endif;?>
          </div>
          <div class='theme-info'>
            <div class='theme-desc text-ellipsis'>
              <?php echo html::a($theme->viewLink, $theme->name, "target='_blank' title='{$theme->name}' class='theme-name'");?>
              <div class='pull-right text-muted'><i class='icon icon-thumbs-o-up'></i> <?php echo $theme->stars?> &nbsp; <i class='icon icon-download-alt'></i> <?php echo $theme->downloads?></div>
            </div>
            <div class='theme-price'>
              <?php if($theme->latestRelease->lifePrice):?>
              <?php echo "<strong class='price text-info'>￥" . number_format($theme->latestRelease->lifePrice, 2) . '</strong>'; ?>
              <?php elseif($theme->latestRelease->score):?>
              <?php echo "<strong class='price text-info'>" . $theme->latestRelease->score . $lang->ui->score. '</strong>'; ?>
              <?php else:?>
              <strong class='label label-success'>FREE </strong>
              <?php endif;?>
              <div class="actions">
                  <?php
                  if($theme->type != 'computer' and $theme->type != 'mobile' and isset($installeds[$theme->code]))
                  {
                      if($installeds[$theme->code]->version != $theme->latestRelease->releaseVersion and $this->theme->checkVersion($theme->latestRelease->chanzhiCompatible))
                      {
                          commonModel::printLink('theme', 'upgrade', "theme=$theme->code&downLink=" . helper::safe64Encode($currentRelease->downLink) . "&md5=$currentRelease->md5&type=$theme->type", $lang->ui->theme->upgrade, "data-toggle='modal' class='btn radius-btn btn-sm'");
                      }
                      else
                      {
                          echo html::a('javascript:;', $lang->ui->theme->installed, "class='disabled btn radius-btn btn-sm'");
                      }
                  }
                  else
                  {
                      echo html::a($theme->viewLink, $lang->package->buy, 'target="_blank" class="btn radius-btn btn-sm"');
                  }
                  echo html::a($theme->site, $lang->package->site, "target='_blank' class='btn radius-btn btn-sm'");
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div  class='modal fade'  id="<?php echo $theme->code . 'Modal'?>">
          <div class='modal-dialog'>
            <div class='modal-content'>
              <div class='modal-header'>
                <strong><?php echo $theme->name . "($currentRelease->releaseVersion)";?></strong>
                <div class='pull-right'>
                  <span class='text-muted'><i class='icon icon-thumbs-o-up'></i> <?php echo $theme->stars?></span> &nbsp;
                  <span class='text-muted'><i class='icon icon-download-alt'></i> <?php echo $theme->stars?></span>
                </div>
              </div>
              <div class='modal-body'>
                <p class=''><?php echo strip_tags($theme->abstract);?></p>
                <p>
                <?php
                echo "{$lang->package->author}:     {$theme->author} ";
                echo "{$lang->package->compatible}: {$lang->package->compatibleList[$currentRelease->compatible]} ";

                echo " {$lang->package->depends}: ";
                if(!empty($currentRelease->depends))
                {
                    foreach(json_decode($currentRelease->depends) as $code => $limit)
                    {
                        echo $code;
                        if($limit != 'all')
                        {
                            echo '(';
                            if(!empty($limit['min'])) echo '>= v' . $limit['min'];
                            if(!empty($limit['max'])) echo '<= v' . $limit['min'];
                            echo ')';
                        }
                        echo ' ';
                    }
                }
                ?>
                </p>
                <div class='text-center'>
                  <div class='btn-group text-center'>
                  <?php
                  echo html::a($theme->viewLink, $lang->package->view, 'class="btn" target="_blank"');
                  if($theme->type != 'computer' and $theme->type != 'mobile')
                  {
                      if(isset($installeds[$theme->code]))
                      {
                          if($installeds[$theme->code]->version != $theme->latestRelease->releaseVersion and $this->theme->checkVersion($theme->latestRelease->chanzhiCompatible))
                          {
                              commonModel::printLink('theme', 'upgrade', "theme=$theme->code&downLink=" . helper::safe64Encode($currentRelease->downLink) . "&md5=$currentRelease->md5&type=$theme->type", $lang->theme->upgrade, "class='btn' data-toggle='modal'");
                          }
                          else
                          {
                              echo html::a('javascript:;', $lang->theme->installed, "class='btn disabled'");
                          }
                      }
                  }

                  if(!$currentRelease->charge)
                  {
                      $label = $currentRelease->compatible ? $lang->package->installAuto : $lang->package->installForce;
                      commonModel::printLink('package', 'install',  "theme=$theme->code&downLink=" . helper::safe64Encode($currentRelease->downLink) . "&md5={$currentRelease->md5}&type=$theme->type&overridePackage=no&ignoreCompitable=yes", $label, "data-toggle='modal' class='btn'");
                  }
                  echo html::a($currentRelease->downLink, $currentRelease->charge ? $lang->package->buy : $lang->package->downloadAB, 'class="manual btn" target="_blank"');
                  echo html::a($theme->site, $lang->package->site, "class='btn' target='_blank'");
                  ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach;?>
    </div>
    <?php if($pager):?>
    <div class='clearfix'>
      <?php $pager->show('right', 'lite')?>
    </div>
    <?php endif; ?>
    <?php endif;?>
  </div>
</div>
<script>
$(function()
{
    var $industryBox = $('#industryBox');
    var toggleIndustryBox = function(toggle)
    {
      if (toggle === undefined) toggle = $industryBox.hasClass('hide');
      $industryBox.toggleClass('hide', !toggle);
      $('#byindustry').toggleClass('open', !!toggle);
    }
    <?php if($type == 'byindustry' and $param != 'all'):?>
    toggleIndustryBox(true);
    <?php endif;?>
    $('#byindustry').click(function()
    {
      toggleIndustryBox();
    })
})
</script>
<?php include '../../common/view/footer.admin.html.php';?>
