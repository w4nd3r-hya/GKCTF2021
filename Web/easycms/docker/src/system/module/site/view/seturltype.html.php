<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The seturltype view file of site module of chanzhiEPS.
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
<?php js::set('requestTypeTip', $lang->site->requestTypeTip);?>
<?php js::set('requestType', $requestType);?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-globe'></i> <?php echo $lang->site->setUrlType;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='setSystemForm' class='form-inline'>
      <table class='table table-form'>
        <tr>
          <th class='w-100px'><?php echo $lang->site->requestType;?></th> 
          <td class='w-280px'><?php echo html::radio('requestType', $lang->site->requestTypeList, $this->config->frontRequestType);?></td>
          <td><span id='requestTypeTip' class='text-important'><?php echo $lang->site->requestTypeTip?></span></td>
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
</div>
<?php include '../../common/view/footer.admin.html.php';?>
