{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The transfer view of thread module of ZenTaoMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     thread 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
*}
{include TPL_ROOT . 'common/header.modal.html.php'}
{!js::set('parents', $parents)}
{!js::set('currentBoard', $thread->board)}
<form id='ajaxForm' class='form-horizontal' action='{!inlink('transfer', "threadID=$thread->id")}'  method='post'>
  <div class='form-group'>
    <label for='link' class='col-xs-2 control-label'>{!echo $lang->thread->board}</label>
    <div class='col-xs-8'>
      {!html::select('targetBoard', $boards, '', "class='form-control chosen'")}
    </div>
  </div>
  <div class='form-group'>
    <div class='col-xs-2'></div>
    <div class='col-xs-8'>
      {!html::submitButton()}
    </div>
  </div>
</form>
{include TPL_ROOT . 'common/footer.modal.html.php'}
