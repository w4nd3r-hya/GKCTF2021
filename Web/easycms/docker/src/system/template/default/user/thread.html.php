{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div class='page-user-control'>
  <div class='row'>
    {include TPL_ROOT . 'user/side.html.php'}
    <div class='col-md-10'>
      <div class='panel'>
        <div class='panel-heading'><strong><i class='icon-share'></i> {!echo $lang->user->thread}</strong></div>
        <table class='table table-hover'>
          <thead>
            <tr class='text-center hidden-xxxs'>
              <th>{!echo $lang->thread->title}</th>
              <th class='hidden-xxs'>{!echo $lang->thread->postedDate}</th>
              {if(isset($control->config->forum) and zget($control->config->forum, 'postReview', '') == 'open')}
              <th class='hidden-xxxs'>{!echo $lang->thread->status}</th>
              {/if}
              <th class='hidden-xs'>{!echo $lang->thread->views}</th>
              <th class='hidden-xxxs'>{!echo $lang->thread->replies}</th>
              <th colspan='2' class='hidden-xxs'>{!echo $lang->thread->lastReply}</th>
            </tr>  
          </thead>
          <tbody>
            {foreach($threads as $thread)}
            <tr class='text-center'>
              <td class='text-left'>{!html::a($control->createLink('thread', 'view', "id=$thread->id"), $thread->title, "target='_blank'")}</td>
              <td class='w-120px hidden-xxs'>{!substr($thread->addedDate, 2, -3)}</td>
              {if(isset($control->config->forum->postReview) and $control->config->forum->postReview == 'open')}
              <td>
                <span class="{!echo $thread->status == 'approved' ? 'text-success' : ''}">
                  {!zget($lang->thread->statusList, $thread->status)}
                </span>
              </td>
              {/if}
              <td class='w-50px hidden-xs'>{!echo $thread->views}</td>
              <td class='w-50px hidden-xxxs'>{!echo $thread->replies}</td>
              <td class='w-200px text-left hidden-xxs'>{if($thread->replies)} {!substr($thread->repliedDate, 2, -3) . ' ' . $thread->repliedByRealname} {/if}</td>  
            </tr>  
            {/foreach}
          </tbody>
          <tfoot><tr><td colspan='7'>{$pager->show('right', 'short')}</td></tr></tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
