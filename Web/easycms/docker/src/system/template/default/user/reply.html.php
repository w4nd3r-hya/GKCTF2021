{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div class='page-user-control'>
  <div class='row'>
    {include TPL_ROOT . 'user/side.html.php'}
    <div class='col-md-10'>
      <div class='panel'>
        <div class='panel-heading'><strong><i class='icon-reply'></i> {!echo $lang->user->reply}</strong></div>
        <table class='table table-hover'>
          <thead>
            <tr class='text-center'>
              <th>{!echo $lang->thread->common}</th>
              <th>{!echo $lang->reply->addedDate}</th>
            </tr>  
          </thead>
          <tbody>
            {foreach($replies as $reply)}
            <tr>
              <td>{!html::a($control->createLink('thread', 'view', "id=$reply->thread") . "#$reply->id", $reply->title . " <i>(#$reply->id)</i>", "target='_blank'")}</td>
              <td class='text-center'>{!substr($reply->addedDate, 2, -3)}</td>
            </tr>  
            {/foreach}
          </tbody>
          <tfoot><tr><td colspan='2'>{$pager->show('right', 'short')}</td></tr></tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
