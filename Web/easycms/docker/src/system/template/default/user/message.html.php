{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div class='row'>
  {include TPL_ROOT . 'user/side.html.php'}
  <div class='col-md-10'>
    <form id='ajaxForm' method='post' target='hiddenwin' action="{!echo $control->createLink('message', 'batchDelete')}">
      <div class='panel'>
        <div class='panel-heading'><strong><i class='icon-comments-alt'></i> {!echo $lang->user->messages}</strong></div>
        <table class='table table-bordered table-hover' id='messages'>
          <thead>
            <tr class='text-center hidden-xxxs'>
              <th class='w-10px'><input type='checkbox' id='selectAll'></th>
              <th class='w-80px hidden-xxxs'>{!echo $lang->message->from}</th>
              <th class='w-150px hidden-xxs'>{!echo $lang->message->date}</th>
              <th>{!echo $lang->message->content}</th>
              <th class='w-60px hidden-xs'>{!echo $lang->message->readed}</th>
              <th class='w-80px hidden-xxs'>{!echo $lang->actions}</th>
            </tr>
          </thead>
          <tbody>
            {foreach($messages as $message)}
            <tr class='text-center'>
              <td><input type='checkbox' name='messages[]' value="{$message->id}" /></td>
              <td class='hidden-xxxs'>{!echo $message->from}</td>
              <td class='hidden-xxs'>{!substr($message->date, 5)}</td>
              <td class='text-left break-all'>{!echo $message->content}</td>
              <td class='hidden-xs'>{!echo $lang->message->readedStatus[$message->readed]}</td>
              {if(!$message->readed)}
              <td class='hidden-xxs'>{!html::a($control->createLink('message', 'view', "message=$message->id"), $message->link ? $lang->message->view : $lang->message->readed)}</td>
              {else}
              <td class='hidden-xxs'>{!echo $message->link ? html::a($control->createLink('message', 'view', "message=$message->id"), $lang->message->view) : $lang->message->readed}</td>
              {/if}
            </tr>
            {/foreach}
          </tbody>
          <tfoot>
            <tr>
              <td colspan='6'>
                {if($messages)}
                    {!html::submitButton($lang->message->deleteSelected)}
                {/if}
                {$pager->show()}
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    </form>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
