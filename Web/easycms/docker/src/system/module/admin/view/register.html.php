<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The view file of bug module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     admin
 * @version     $Id: view.html.php 2568 2012-02-09 06:56:35Z shiyangyangwork@yahoo.cn $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php js::set('certifiedMobile', $this->session->certifiedMobile);?>
<?php js::set('certifiedEmail', $this->session->certifiedEmail);?>
<?php if($register):?>
<?php js::set('certifiedMobile', $bindedUser->mobileCertified ? $bindedUser->mobile : '');?>
<?php if($bindedUser->emailCertified) js::set('certifiedEmail', $bindedUser->email);?>
<div class='panel'>
  <div class='panel-heading borderless'><strong><i class='icon-user'></i> <?php echo $lang->admin->bindedInfo;?></strong></div>
  <div class='panel-body'>
    <table class='table table-form' id="certifyTable">
      <tr>
        <th class='w-100px text-right'><?php echo $lang->user->account;?></th>
        <td class='text-middle'> <?php echo $bindedUser->account;?> </td>
      </tr>
      <tr>
        <th class='text-right'><?php echo $lang->user->realname;?></th>
        <td class='text-middle'> <?php echo $bindedUser->realname;?> </td>
      </tr>
      <tr>
        <th class='text-right'><?php echo $lang->user->company;?></th>
        <td class='text-middle'> <?php echo $bindedUser->company;?> </td>
      </tr>
      <tr>
        <th class='text-right'><?php echo $lang->user->email;?></th>
        <td>
          <?php echo str2Entity($bindedUser->email);?>
          <?php if($bindedUser->emailCertified)  echo "<i class='label label-success icon icon-check'>{$lang->user->certified}</i>"; ?>
          <?php if(!$bindedUser->emailCertified) echo html::a(inlink('checkemail'), $lang->user->certifyNow, "class='btn btn-xs btn-primary' data-toggle='modal'"); ?>
        </td>
      </tr>
      <tr>
        <th class='text-right'><?php echo $lang->user->mobile;?></th>
        <td>
          <?php echo str2Entity($bindedUser->mobile);?>
          <?php if($bindedUser->mobileCertified) echo "<i class='label label-success icon icon-check'>{$lang->user->certified}</span>"?>
          <?php if(!$bindedUser->mobileCertified) echo html::a(inlink('checkMobile'), $lang->user->certifyNow, "data-toggle='modal' class='btn btn-xs btn-primary'");?>
        </td>
      </tr>
      <tr>
        <th></th>
        <td>
          <?php echo html::a(inlink('unbind'), $lang->admin->rebind, "id='rebindBtn' class='btn'");?>
          <?php echo html::a(inlink('getUserByApi'), $lang->admin->community->update, "id='rebindBtn' class='btn'");?>
        </td>
      </tr>
    </table>
  </div>
</div>
<?php elseif(!$apiConnected):?>
<div class='alert alert-warning'>
<?php printf($lang->admin->connectApiFail);?>
</div>
<?php else:?>
<div class='col-md-6'>
  <div class='panel' id='registerPanel'>
    <div class='panel-heading'>
      <strong><?php echo $lang->admin->community->caption;?></strong>
    </div>
    <div class='panel-body'>
      <form method="post" id='registerForm'>
        <table class='table table-form'>
          <tr>
            <th class='w-120px'><?php echo $lang->user->account;?></th>
            <td colspan='2'>
              <div class="required required-wrapper"></div>
              <?php echo html::input('account', '', "class='form-control' placeholder='{$lang->admin->community->lblAccount}'");?>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->user->realname;?></th>
            <td colspan='2'>
              <div class="required required-wrapper"></div>
              <?php echo html::input('realname', '', "class='form-control'");?>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->user->company;?></th>
            <td colspan='2'><?php echo html::input('company', '', "class='form-control'");?></td>
          </tr>
          <tr>
            <th><?php echo $lang->user->mobile;?></th>
            <td style='padding-right:0;'>
              <?php echo html::input('mobile', $this->session->certifiedMobile, "class='form-control'");?>
            </td>
            <td >
              <?php if($this->session->certifiedMobile) echo "<span class='certified label label-success'><i class='icon icon-check'> </i>{$lang->admin->checked}</span>";?>
              <?php echo html::a($this->createLink('sms', 'sendcertifycode'), $lang->user->getCertifyCode, "id='smsSender' class='btn uncertified'");?> 
            </td>
            <td class='w-180px td-captcha'>
              <div class="required required-wrapper"></div>
              <div class='input-group'>
                <span class='input-group-addon borderless'><?php echo $lang->user->captcha;?></span>
                <?php echo html::input('mobileCode', '', "class='form-control'");?>
              </div>
            </td>
          </tr>  
          <tr>
            <th><?php echo $lang->user->email;?></th>
            <td style='padding-right:0;'><?php echo html::input('email', $this->session->certifiedEmail, "class='form-control'");?></td>
            <td>
              <?php if($this->session->certifiedEmail) echo "<span class='certified label label-success'><i class='icon icon-check'> </i>{$lang->admin->checked}</span>";?>
              <?php echo html::a($this->createLink('sms', 'sendcertifycode'), $lang->user->getCertifyCode, "id='mailSender' class='uncertified btn'");?>
            </td>
            <td class='td-captcha'>
              <div class="required required-wrapper"></div>
              <div class='input-group'>
                <span class='input-group-addon borderless'><?php echo $lang->user->captcha;?></span>
                <?php echo html::input('emailCode', '', "class='form-control'");?>
              </div>
            </td>
          </tr>  
          <tr>
            <th><?php echo $lang->user->password;?></th>
            <td colspan='2'>
              <div class="required required-wrapper"></div>
              <?php echo html::password('password1', '', "class='form-control' placeholder='{$lang->admin->community->lblPasswd}'");?>
            </td>
          </tr>  
          <tr>
            <th><?php echo $lang->user->password2;?></th>
            <td colspan='2'><?php echo html::password('password2', '', "class='form-control'") . '<span class="star">*</span>';?></td>
          </tr> 
          <tr>
            <th></th>
            <td colspan="4">
              <?php echo html::submitButton($lang->admin->community->submit);?>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<div class='col-md-6'>
  <div class='panel' id='bindPanel'>
    <div class='panel-heading'>
      <strong><?php echo $lang->admin->bind->caption;?></strong>
    </div>
    <div class='panel-body'>
      <form id='bindForm' action="<?php echo inlink('bind');?>" method="post">
        <table class='table table-form w-500px'>
          <tr>
            <th class='w-100px'><?php echo $lang->user->account;?></th>
            <td>
              <?php echo html::input('account', '', "class='form-control'");?>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->user->password;?></th>
            <td>
              <?php echo html::password('password', '', "class='form-control'");?>
            </td>
          </tr>
          <tr>
            <th></th><td><?php echo html::submitButton($lang->admin->bind->submit);?></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php endif;?>
<?php include '../../common/view/footer.admin.html.php';?>
