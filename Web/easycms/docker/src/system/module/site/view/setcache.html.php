<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The setcache view file of site module of chanzhiEPS.
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
<?php js::set('closeScoreTip', $lang->site->closeScoreTip);?>
<?php js::set('clearing', $lang->site->clearingCache);?>
<?php js::set('cleared', $lang->site->clearedCache);?>
<?php js::set('clear', $lang->site->clearCache);?>
<?php js::set('clearCacheTip', sprintf($lang->site->clearCacheTip, $cacheRoot));?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-globe'></i> <?php echo $lang->site->setCache;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='form-inline'>
      <table class='table table-form'>
        <tr>
          <th class='w-100px'><?php echo $lang->site->openCache;?></th> 
          <td colspan='2'><?php echo html::radio('status', $lang->site->cacheTypes, isset($this->config->cache->type) ? $this->config->cache->type : 'file', "class='checkbox'");?></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->cachePage;?></th>
          <td colspan='2'><?php echo html::radio('cachePage', $lang->site->cachePageOptions, isset($this->config->cache->cachePage) ? $this->config->cache->cachePage : 'open');?></td>
        </tr>
        <tr>
          <th><?php echo $lang->site->cacheExpired;?></th>
          <td class='w-200px'>
            <div class='input-group'>
              <?php echo html::input('cacheExpired', $this->config->cache->expired / 3600, "class='form-control'");?>
              <span class='input-group-addon'><?php echo $lang->site->hour;?></span>
            </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td id='saveCacheSetting'>
            <?php echo html::submitButton();?>
            <?php echo html::a(inlink('clearCache'), $lang->site->clearCache, "class='btn btn-primary' id='clearButton'");?>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
