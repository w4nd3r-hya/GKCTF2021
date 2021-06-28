{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The score view file of score module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     score
 * @version     $Id$
 * @link        http://www.chanzhi.net
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div class='row'>
  {include TPL_ROOT . 'user/side.html.php'}
  <div class='col-md-10'>
    <div class='panel'>
      <div class='panel-heading'><strong>{$lang->user->buyScore}</strong></div>
      <div class='panel-body'>
        <form method='post' id='ajaxForm'>
          <table class='table table-form'>
            <tr>
              <th width='100'>{$lang->score->setAmount}</th>
              <td>{!html::input('amount', '', "style='width:45px' onkeyup='getScore()'")}{$lang->score->amountUnit} <span class='ml-10px red'>{!printf($lang->score->buyWaring, $config->score->buyScore->minAmount, $config->score->buyScore->perYuan)}</span></td>
            </tr>
            <tr>
              <th>{$lang->score->getScore}</th>
              <td><span id='score'>0</span></td>
            </tr>
            <tr>
              <th></th>
              <td>{!html::submitButton()}</td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
var scoreConfig = {$config->score->buyScore->perYuan};
</script>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
