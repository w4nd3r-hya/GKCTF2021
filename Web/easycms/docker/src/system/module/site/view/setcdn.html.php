<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The setupload  view file of site module of chanzhiEPS.
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
  <div class='panel-heading'><strong><i class='icon-globe'></i> <?php echo $lang->site->setCDN;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='cdnForm' class='form-inline'>
      <table class='table table-form'>
        <tr>
          <th class='w-100px'><?php echo $lang->site->useCDN;?></th>
          <td><?php echo html::radio('open', $lang->site->cdnList, $this->config->cdn->open, "class='checkbox'");?></td>
        </tr>
        <tr class="cdn-host <?php echo $this->config->cdn->open == 'open' ? '' : 'hide';?>">
          <th><?php echo $lang->site->cdn;?></th>
          <td class='w-500px'>
            <div class='input-group'>
              <?php echo html::input('site', !empty($this->config->cdn->site) ? $this->config->cdn->site : $config->cdn->host . $this->config->version . '/', "data-default='{$config->cdn->host}{$this->config->version}' class='form-control'");?>
              <span class='input-group-addon cdnreseter'><?php echo $lang->site->useDefaultCdn?></span>
            </div>
          </td>
          <td></td>
        </tr>
        <tr>
          <th></th>
          <td>
            <div class='hide'>
              <strong><?php echo $lang->site->cdnFileLost;?></strong>
              <pre id='messageBox' class='alert alert-danger'></pre>
            </div>
            <?php echo html::submitButton();?>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
