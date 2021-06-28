{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.simple')}
<style>
.panel > .panel-heading, .panel-section > .panel-heading {padding:12px 10px 0px 10px}
.card {display:block}
.card .card-heading {padding:0px;overflow:hidden;margin-bottom:12px}
.card .card-title {float:left;max-width:80%;text-overflow:ellipsis;overflow:hidden;white-space:nowrap;font-size:1.5rem;font-weight:600;color:#333}
.card .bg-danger-pale {background-color:#F6CCD1;height:20px;width:42px;font-size:1.2rem;text-align:center;line-height:20px}
.card .text-danger {color:#D0021B}
.card-content, .card-footer {padding:0px;}
.card .pub-time {color:#666}
.card .pull-right > a {color:#666;font-size:1.5rem}
#footer {line-height:49px;height:49px}
.footer-right {width:100%;text-align:center}
.footer-right > .right-btn {width:50%;margin:auto}
.footer-right > .right-btn > button,input {width:100%;line-height:28px;height:30px;border-radius:4px;padding:0px;outline:none}
.footer-right > .right-btn > .btn-pub {border:1px solid #6F9AFE;color:#fff;background:linear-gradient(to right,#709BFE,#1B5AFF)}
</style>
<div class='panel-section'>
  <div class='panel-heading'>
    <div class='title strong'><i class='icon icon-envolope-alt'></i> {$lang->user->submission}</div>
  </div>
  <div class='cards condensed cards-list' id='submission'>
    {foreach($articles as $article)}
      <div class='card' id="article{$article->id}" data-ve='article'>
        <div class='card-heading'>
          <div class='pull-right'>
            <div class='bg-danger-pale text-danger'>{$lang->submission->status[$article->submission]}</div>
          </div>
          <div class='card-title'>
            {if($article->submission == articleModel::SUBMISSION_STATUS_APPROVED)} {!html::a($control->article->createPreviewLink($article->id), $article->title, "target='_blank'")} {/if}
            {if($article->submission != articleModel::SUBMISSION_STATUS_APPROVED)} {$article->title} {/if}
          </div>
        </div>
        <div class='table-layout'>
          <div class='table-cell'>
            <div class='card-content'>
              <div class='pull-right'>
                {if($article->submission != articleModel::SUBMISSION_STATUS_APPROVED)}
                  {!html::a(helper::createLink('article', 'modify', "articleID={{$article->id}}"), $lang->edit, "class='editor' data-toggle='modal'")}&nbsp;&nbsp;
                  {!html::a(helper::createLink('article', 'delete', "articleID={{$article->id}}"), $lang->delete, "class='deleter' data-locate='self'")}
                {else}
                  <a class='disabled'>{$lang->edit}</a>
                  <a class='disabled'>{$lang->delete}</a>
                {/if}
              </div>
              <div class='pub-time'>
                <span title="{$lang->article->submissionTime}">{$lang->article->submissionTime}：{!substr($article->editedDate, 5, -3)}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    {/foreach}
  </div>
  {$pager->createPullUpJS('#submission', $lang->mobile->pullUpHint, helper::createLink('article', 'submission', "orderBy=id_desc&recTotal=$pager->recTotal&recPerPage=$pager->recPerPage&pageID=\$ID"))}
  <footer class="appbar fix-bottom" id='footer' data-ve='navbar' data-type='mobile_bottom'>
    <div class='footer-right'>
      <div class='right-btn'>
        <button type='button' class='btn-pub' data-toggle='modal' data-remote="{!inlink('post')}"><i class='icon-plus'></i> {$lang->article->post}</button>
      </div>
    </div>
  </footer>
</div>
{include TPL_ROOT . 'common/form.html.php'}
