{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The html template file of download method of file module of ZenTaoCMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoCMS
 * @version     $Id$
 */
/php*}
<div class='panel'>
<div class='panel-heading'><strong>{$lang->score->lblNoScore}</strong></div>
<table class='table table-form'> 
  <tr>
    <td>
      {!printf($lang->score->lblNoScoreReason, $lang->score->methods[$method], $score, $app->user->score)}
      <ol>
        <li>{!html::a($control->createLink('forum', 'index'), $lang->score->getByThread, "target='_blank'")}</li>
        <li>{!html::a($control->createLink('score', 'rule'), $lang->score->getScore, "target='_blank' class='btn'")}</li>
        <li>{!html::a($control->createLink('score', 'buyScore'), $lang->user->buyScore, "target='_blank'")}</li>
      </ol>
     {$lang->score->lblDetail}
     {!html::a('#', $lang->goback, "onclick=history.go(-1) class='btn'")}
     {!html::a($control->createLink('user', 'logout'), $lang->login, "class='btn'")}
    </td>
  </tr>  
</table>
</div>
