<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The setdomain view file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php js::set('closeScoreTip', $lang->site->closeScoreTip);?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-globe'></i> <?php echo $lang->site->setDomain;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='form-inline'>
      <table class='table table-form'>
        <tr>
          <th class='w-100px'><?php echo $lang->site->domain;?></th> 
          <td class='w-p40'><?php echo html::input('domain',  isset($this->config->site->domain) ? $this->config->site->domain : '', "class='form-control'");?></td>
          <td><?php echo html::a('javascript:void(0)', "<i class='icon-question-sign'></i>", "data-custom='{$lang->site->domainTip}' data-toggle='modal' data-icon='question-sign' data-title='{$lang->site->domain}'")?></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->allowedDomain;?></th> 
          <td><?php echo html::input('allowedDomain',  isset($this->config->site->allowedDomain) ? $this->config->site->allowedDomain : '', "class='form-control'");?></td>
          <td><?php echo html::a('javascript:void(0)', "<i class='icon-question-sign'></i>", "data-custom='{$lang->site->allowedDomainTip}' data-toggle='modal' data-icon='question-sign' data-title='{$lang->site->allowedDomain}'")?></td>
        </tr>
        <tr title="<?php echo $lang->site->schemeTip;?>">
          <th><?php echo $lang->site->scheme;?></th> 
          <td><?php echo html::radio('scheme', $lang->site->schemeList, isset($this->config->site->scheme) ? $this->config->site->scheme : 'http', "class='checkbox'");?></td>
          <td></td>
        </tr>
        <tr>
          <th></th>
          <td colspan='2'><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
