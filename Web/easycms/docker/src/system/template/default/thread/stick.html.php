{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The transfer view of thread module of ZenTaoMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     thread 
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
*}
{include TPL_ROOT . 'common/header.modal.html.php'}
{include TPL_ROOT . 'common/datepicker.html.php'}
<form method='post' id='ajaxForm' action='{!inlink('stick', "threadID={{$thread->id}}")}'>
  <table class='table table-form'>
    <tr>
      <th class='w-80px'>{$lang->thread->stick}</th>
      <td>{!html::radio('stick', $lang->thread->sticks, $thread->stick)}</td>
    </tr>
    <tr class="{if($thread->stick == 0)}{!'hide'}{/if}">
      <th class='w-80px'>{$lang->thread->stickBold}</th>
      <td>
        {$checked = $thread->stickBold ? 'checked' : ''}
        {!"<input type='checkbox' name='stickBold' id='stickBold' value='1' {{$checked}} />"}
      </td>
    </tr>
    <tr class="{if($thread->stick == 0)} {!'hide'} {/if}">
      <th class='w-80px'>{$lang->thread->stickTime}</th>
      <td>
        <div class='input-append date'>
          {!html::input('stickTime', formatTime($thread->stickTime), "class='form-control form-datetime'")}
          <span class='add-on'><button class='btn btn-default' type='button'><i class='icon-calendar'></i></button></span>
        </div>
      </td>
    </tr>
    <tr>
      <td></td>
      <td colspan='2'>{!html::submitButton()}</td>
    </tr>
  </table>
</form>
{include TPL_ROOT . 'common/footer.modal.html.php'}
