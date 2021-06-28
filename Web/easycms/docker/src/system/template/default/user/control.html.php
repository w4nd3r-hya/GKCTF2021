{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div class="page-user-control">
  <div class="row">
    {include TPL_ROOT . 'user/side.html.php'}
    <div class="col-md-10">
      <div class="panel panel-body">
        <div class="jumbotron-bg">
          {!printf($lang->user->control->welcome, $user->realname)}
        </div>
      </div>
    </div>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
