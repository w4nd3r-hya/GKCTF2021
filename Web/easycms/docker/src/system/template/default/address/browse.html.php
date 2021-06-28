{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The zipcode view of zipcode module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     zipcode 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
*}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div class="page-user-control">
  <div class="row">
    {include TPL_ROOT . 'user/side.html.php'}
    <div class="col-md-10">
      <div class="panel">
        <div class='panel-heading'>
          <strong>{$lang->address->browse}</strong>
          <div class='panel-actions'>{!html::a('javascript:;', $lang->address->create, "id='createBtn' class='btn btn-primary'")}</div>
        </div>
        <div class="panel-body">
          <div id='createForm'></div>
          {foreach($addresses as $address)}
            {$checked = isset($checked) ? '' : 'checked'}
            <div class='item'>
              <div class='address-list'>
                {if(helper::isAjaxRequest())} <span><input type='radio' {!echo $checked} name='deliveryAddress' value='{!echo $address->id}'/></span> {/if}
                <strong>{!echo $address->contact}</strong>
                <span> {!str2Entity($address->phone)}</span>
                <span class='text-muted'> {!echo $address->address}</span>
                <span class='text-muted'> {!echo $address->zipcode}</span>
                <span class='pull-right'>
                {!html::a(helper::createLink('address', 'edit', "id=$address->id"), $lang->edit, "class='editor'")}
                {!html::a(helper::createLink('address', 'delete', "id=$address->id"), $lang->delete, "class='deleter'")}
                </span>
            </div>
            <div class='form-edit'>
            </div>
          </div>
          {/foreach}
        </div>
      </div>
    </div>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
