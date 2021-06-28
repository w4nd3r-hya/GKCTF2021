<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The setlanguage view file of site module of chanzhiEPS.
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
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-globe'></i> <?php echo $lang->site->setLanguage;?></strong></div>
  <?php $myFile = $this->app->getConfigRoot() . 'my.php';?>
  <?php if(!is_writable($myFile)):?>
  <div class='alert alert-info'>
  <?php echo sprintf($lang->site->fileAuthority, 'chmod o=rwx ' . $myFile);?>
  </div> 
  <?php else:?>
  <div class='panel-body'>
    <form method='post' id='setSystemForm' class='form-inline'>
      <table class='table table-form'>
        <tr>
          <th class='col-xs-2'><?php echo $lang->site->lang;?></th>
          <td class='col-xs-6'><?php echo html::checkbox('enabledLangs', $config->langs, isset($config->enabledLangs) ? $config->enabledLangs : 'zh-cn');?></td><td></td>
        </tr>
        <tr id='twTR'>
          <th><?php echo $lang->site->twContent;?></th>
          <td><?php echo html::checkbox('cn2tw', array(1 => $lang->site->cn2tw), isset($this->config->cn2tw) ? $this->config->cn2tw : '');?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->defaultLang;?></th>
          <td>
            <?php echo html::radio('defaultLang', $config->langs, isset($this->config->defaultLang) ? $this->config->defaultLang : $this->app->getClientLang(), "class=''");?>
          </td>
          <td></td>
        </tr>
        <tr>
          <th></th>
          <td colspan='2'>
            <?php echo html::a($this->createLink('guarder', 'validate', "url=&target=modal&account=&type=okFile"), $lang->save, "data-toggle='modal' class='hidden captchaModal'")?>
            <?php echo html::submitButton();?>
          </td>
        </tr>
      </table>
    </form>
  </div>
  <?php endif;?>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
