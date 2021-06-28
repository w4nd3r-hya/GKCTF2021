{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{$common->printPositionBar($control->app->getModuleName())}
<div class='panel' id='companyContact'>
  <div class='panel-heading'>
    <strong><i class='icon icon-comments-alt'></i> {!echo $lang->company->contact}</strong>
    {if(!empty($block->content->moreText) and !empty($block->content->moreUrl))}
    <div class='pull-right'>{!html::a($block->content->moreUrl, $block->content->moreText)}</div>
    {/if}
  </div>
  <div class='panel-body'>
    <table class='table table-data'>
      {foreach($contact as $item => $value)}
      <tr>
        <th>{!echo $control->lang->company->$item . $control->lang->colon}</th>
        <td>{!echo $value}</td>
      </tr>
      {/foreach}
    </table>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
