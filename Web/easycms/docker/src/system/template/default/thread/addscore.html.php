{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The award score view file of thread module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     Thread
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
*}
{include TPL_ROOT . 'common/header.modal.html.php'}
<form method='post' action='{!inlink('addScore', "account=$account&objectType=$objectType&objectID=$objectID")}' id='addScoreForm' class='form'>
  <table class='table table-form borderless'>
    <tr>
      <th class="w-100px">{!echo $lang->score->count}</th>
      <td>{!html::input('count', '', "class='form-control'")}</td><td></td>
    </tr>  
    <tr>
      <th>{!echo $lang->score->note}</th>
      <td>{!html::textarea('note', '', "class='form-control'")}</td><td></td>
    </tr>  
    <tr><td></td><td>{!html::submitButton()}</td></tr>
  </table>
</form>
{include TPL_ROOT . 'common/footer.modal.html.php'}
