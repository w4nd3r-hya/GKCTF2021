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
{$isRequestModal = helper::isAjaxRequest()}
{if($isRequestModal)}
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span></button>
        <h5 class='modal-title'></i> {$lang->user->buyScore}</h5>
      </div>
      <div class='modal-body'>
{else}
  {include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.simple')}
  <div class='panel panel-section'>
    <div class='panel-heading'><strong>{$lang->user->buyScore}</strong></div>
    <div class='panel-body'>
{/if}
    <form method='post' id='buyScoreForm' action="{$control->createLink('score', 'buyScore')}">
      <div class='form-group'>
        {!html::input('amount', '', "class='form-control' placeholder='{{$lang->score->setAmount}}' onkeyup='getScore()'")}
      </div>
      <div class='form-group'>
        {!printf($lang->score->buyWaring, $config->score->buyScore->minAmount, $config->score->buyScore->perYuan)}
      </div>
      <div class='form-group'>
        <span>{$lang->score->getScore}</span>
         <span id='score'>0</span>
      </div> 
      <div class='form-group'>
        {!html::submitButton('', 'btn primary block')}
      </div>
    </form>
{if($isRequestModal)}
      </div>
    </div>
  </div>
{else}
    </div>
  </div>
{include TPL_ROOT . 'common/form.html.php'}
{/if}
<script>
var $buyScoreForm = $('#buyScoreForm');
$buyScoreForm.ajaxform({onSuccess: function(response)
{
    if(response.result == 'success')
    {
        $.closeModal();
    }
}
});

var scoreConfig = {$config->score->buyScore->perYuan};
function getScore()
{
    $('#score').html(Math.round($('#amount').val() * scoreConfig));
}
</script>
