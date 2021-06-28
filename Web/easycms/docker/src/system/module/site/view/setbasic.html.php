<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The setbasic view file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      xiying Guang <guanxiying@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php js::set('closeScoreTip', $lang->site->closeScoreTip);?>
<?php js::set('requestTypeTip', $lang->site->requestTypeTip);?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-globe'></i> <?php echo $lang->site->setBasic;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='setBasicForm' class='form-inline'>
      <table class='table table-form'>
        <tr>
          <th class='col-xs-2'><?php echo $lang->site->status;?></th> 
          <td class='col-xs-6'><?php echo html::radio('status', $lang->site->statusList, isset($this->config->site->status) ? $this->config->site->status : 'normal', "class='checkbox'");?></td><td></td>
        </tr>
        <?php $class = $this->config->site->status == 'pause' ? '' : 'hide';?>
        <tr class="pauseTip <?php echo $class?>">
          <th><?php echo $lang->site->pauseTip;?></th> 
          <td><?php echo html::textarea('pauseTip', !empty($this->config->site->pauseTip) ? $this->config->site->pauseTip : $lang->site->defaultTip);?></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->type;?></th> 
          <td><?php echo html::radio('type', $lang->site->typeList, isset($this->config->site->type) ? $this->config->site->type : 'portal', "class='checkbox'");?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->mobileTemplate;?></th> 
          <td><?php echo html::radio('mobileTemplate', $lang->site->mobileTemplateList, $this->config->site->mobileTemplate, "class='checkbox'");?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->gzipOutput;?></th> 
          <td><?php echo html::radio('gzipOutput', $lang->site->gzipOutputList, isset($this->config->site->gzipOutput) ? $this->config->site->gzipOutput : 'close', "class='checkbox'");?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->name;?></th> 
          <td><?php echo html::input('name', $this->config->site->name, "class='form-control'");?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->copyright;?></th> 
          <td><?php echo html::input('copyright', $this->config->site->copyright, "class='form-control'");?></td><td></td>
        </tr>
        <?php $firstType = true;?>
        <?php $numberOfModuleType = count((array)$lang->site->moduleAvailable);?>
        <?php foreach($lang->site->moduleAvailable as $moduleType => $moduleList):?>
        <tr>
          <?php 
            if($firstType)
            { 
              echo "<th rowspan='" . $numberOfModuleType . "'>" . $lang->site->module . "</th>"; 
              $firstType = false;
            }
          ?>
          <td colspan='2' class='setModules'><?php echo html::checkbox('modules', $lang->site->moduleAvailable->{$moduleType}, isset($this->config->site->modules) ? $this->config->site->modules : '');?></td>
        </tr>
        <?php endforeach;?>
        <tr>
          <th><?php echo $lang->site->keywords;?></th> 
          <td colspan='2'><?php echo html::input('keywords', $this->config->site->keywords, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->indexKeywords;?></th> 
          <td colspan='2'><?php echo html::input('indexKeywords', $this->config->site->indexKeywords, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->slogan;?></th> 
          <td colspan='2'><?php echo html::input('slogan', $this->config->site->slogan, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->meta;?></th> 
          <td colspan='2'><?php echo html::textarea('meta', htmlspecialchars($this->config->site->meta), "placeholder='{$lang->site->metaHolder}' class='form-control' rows=3");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->desc;?></th> 
          <td colspan='2'><?php echo html::textarea('desc', htmlspecialchars($this->config->site->desc), "class='form-control' rows='3'");?></td> 
        </tr>
       <tr class='icpSN'>
          <th><?php echo $lang->site->icpSN;?></th> 
          <td colspan='2'>
            <div class='row'>
              <?php $placeholder = ($this->app->getClientLang() == 'en') ? "placeholder='{$lang->site->icpTip}'" : '';?>
              <div class='col-sm-4'><?php echo html::input('icpSN', isset($this->config->site->icpSN) ? $this->config->site->icpSN : '', "class='form-control col-xs-2' $placeholder");?></div>
              <div class='col-sm-8'>
                <div class='input-group'>
                  <span class="input-group-addon"><?php echo $lang->site->icpLink;?></span>
                  <?php echo html::input('icpLink', isset($this->config->site->icpLink) ? $this->config->site->icpLink : 'http://www.miitbeian.gov.cn', "class='form-control'")?>
                </div>
              </div>
            </div>
          </td>
        </tr>
        <tr class='policeSN'>
          <th><?php echo $lang->site->policeSN;?></th> 
          <td colspan='2'>
            <div class='row'>
              <?php $placeholder = ($this->app->getClientLang() == 'en') ? "placeholder='{$lang->site->policeTip}'" : '';?>
              <div class='col-sm-4'><?php echo html::input('policeSN', isset($this->config->site->policeSN) ? $this->config->site->policeSN : '', "class='form-control col-xs-2' $placeholder");?></div>
              <div class='col-sm-8'>
                <div class='input-group'>
                  <span class="input-group-addon"><?php echo $lang->site->policeLink;?></span>
                  <?php echo html::input('policeLink', isset($this->config->site->policeLink) ? $this->config->site->policeLink : 'http://www.miitbeian.gov.cn', "class='form-control'")?>
                </div>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan='2'>
            <?php echo html::submitButton();?>
            <span class='hidden tip alert alert-info' style='marging: 0.3px'></span>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
