{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div class='page-user-control'>
  <div class='row'>
    {include TPL_ROOT . 'user/side.html.php'}
    <div class='col-md-10'>
      <div class='panel'>
        <div class='panel-heading'><strong><i class='icon-envelope-alt'></i> {$lang->user->submission}</strong>
          <div class='panel-actions'>
            {@commonModel::printLink('article', 'post', '', '<i class="icon-plus"></i> ' . $lang->article->post, 'class="btn btn-primary"')}
          </div>
        </div>
        {if(!empty($articles))}
        <table class='table table-hover table-striped tablesorter'>
          <thead>
            <tr>
              <th class='text-center w-50px'>{$lang->article->id}</th>
              <th class='text-center'>{$lang->article->title}</th>
              <th class='text-center w-160px'>{$lang->article->submissionTime}</th>
              <th class='text-center w-60px'>{$lang->article->status}</th>
              <th class='text-center w-60px'>{$lang->article->views}</th>
              <th class="text-center w-120px">{$lang->actions}</th>
            </tr>
          </thead>
          <tbody>
          {$maxOrder = 0}
          {foreach($articles as $article)}
            <tr>
              <td class='text-center'>{$article->id}</td>
              <td>
                {if($article->submission == articleModel::SUBMISSION_STATUS_APPROVED)}
                  {if($article->type == 'book')}
                      {!html::a($control->article->createPreviewLink($article->bookID, '', $article->type), $article->title, "target='_blank'")}
                  {else}
                        {!html::a($control->article->createPreviewLink($article->id), $article->title, "target='_blank'")}
                  {/if}
                {else}
                  {!echo $article->title}
                {/if}
              </td>
              <td class='text-center'>{!echo $article->editedDate}</td>
              <td class='text-center'>{!echo $lang->submission->status[$article->submission]}</td>
              <td class='text-center'>{!echo $article->views}</td>
              <td class='text-center'>
              {if($article->submission != articleModel::SUBMISSION_STATUS_APPROVED)}
                 {@commonModel::printLink('article', 'modify', "articleID=$article->id", $lang->edit)}
                 {@commonModel::printLink('article', 'delete', "articleID=$article->id", $lang->delete, 'class="deleter"')}
              {else}
                 {!html::a('javascript:;', $lang->edit, "class='disabled'") . html::a('javascript:;', $lang->delete, "class='disabled'")}
              {/if}
              </td>
            </tr>
            {/foreach}
          </tbody>
          <tfoot><tr><td colspan='6'>{$pager->show()}</td></tr></tfoot>
        </table>
        {else}
        <div class='panel-body'>
          {!echo $lang->article->noSubmission}
          {!html::a(inlink('post'), "<i class='icon icon-plus'> </i>{{$lang->article->post}}", "class='btn btn-success'")}
        </div>
        {/if}
      </div>
    </div>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
