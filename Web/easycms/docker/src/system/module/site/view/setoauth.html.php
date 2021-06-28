<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The setbasic view file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      xiying Guang <guanxiying@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='row'>
  <?php foreach($lang->user->oauth->providers as $providerCode => $providerName):?>
  <?php isset($this->config->oauth->$providerCode) ? $oauth = json_decode($this->config->oauth->$providerCode) : $oauth = '';?>
  <div class='col-sm-6 panel-box <?php echo $providerCode . '-panel';?>'>
    <div class='panel'>
      <div class='panel-heading'>
        <strong><i class="icon-<?php echo $providerCode; ?>"></i> <?php echo $providerName;?></strong>
        <div class='panel-actions'>
        <?php if($app->clientLang == 'zh-cn' or ($app->clientLang == 'en' and strpos('github,facebook', $providerCode) !== false)):?>
        <?php $langParam = $app->clientLang == 'en' ? '&lang=en' : '';?>
        <?php echo html::a('http://api.chanzhi.org/goto.php?item=help_' . $providerCode . 'oauth' . $langParam, '<i class="icon-question-sign"></i> ' . $lang->site->oauthHelp, "target='_blank' class='btn btn-link'");?>
        <?php endif;?>
        </div>
      </div>
      <div class='panel-body'>
        <form method='post' id='<?php echo $providerCode;?>AjaxForm' class='form-horizontal'>
          <table class="table table-form">
            <?php if($providerCode == 'sina'):?>
            <tr>
              <th class='w-100px'><?php echo $lang->user->oauth->verification;?></th>
              <td class='w-p75'>
                <div class='input-group'>
                  <?php if(isset($oauth->isVertified)):?> 
                    <?php echo html::input('verification', '', "class='form-control'");?>
                    <span class="input-group-addon">
                      <?php echo "<input type='checkbox' name='isVertified' id='isVertified' value='1' checked='checked' /> <span>{$lang->site->isVertified}</span>";?>
                    </span>
                  <?php else:?> 
                    <?php echo html::input('verification', isset($oauth->verification) ? $oauth->verification : '', "class='form-control'");?>
                    <span class="input-group-addon">
                      <?php echo "<input type='checkbox' name='isVertified' id='isVertified' value='1' /> <span>{$lang->site->isVertified}</span>";?>
                    </span>
                  <?php endif;?> 
                </div>
              </td>
            </tr>
            <?php endif;?>
            <tr>
              <th class='w-100px'><?php echo $lang->user->oauth->{$providerCode}->clientID;?></th>
              <td class='w-p75'>
                <?php echo html::input('clientID', isset($oauth->clientID) ? $oauth->clientID : '', "class='form-control'");?>
              </td>
            </tr>
            <tr>
              <th><?php echo $lang->user->oauth->{$providerCode}->clientSecret;?></th>
              <td>
                <?php echo html::input('clientSecret', isset($oauth->clientSecret) ? $oauth->clientSecret : '', "class='form-control'");?>
              </td>
            </tr>
            <?php if($providerCode == 'sina'):?>
            <tr>
              <th><?php echo $lang->user->oauth->widget;?></th>
              <td><?php echo html::input('widget', isset($oauth->widget) ? $oauth->widget : '', "class='form-control'");?></td>
            </tr>
            <?php endif;?>
            <?php if($providerCode == 'qq'):?>
            <tr>
              <th><?php echo $lang->user->oauth->callbackURL;?></th>
              <td>
                <?php $callbackURL = commonModel::createFrontLink('user', 'oauthCallback', "provider=qq");?>
                <?php if($callbackURL == $this->config->webRoot . 'user-oauthCallback-qq.html'):?>
                <?php echo commonModel::getSysURL() . $callbackURL;?>
                <?php else:?>
                <?php echo commonModel::getSysURL() . $this->config->webRoot. 'index.php/user-oauthCallback-qq.html';?>
                <?php endif;?>
              </td>
            </tr>
            <?php endif;?>
            <?php if(in_array($providerCode, array('github', 'twitter', 'facebook', 'google'))):?>
            <tr>
              <th><?php echo $lang->user->oauth->callbackURL;?></th>
              <td>
                <?php $callbackURL = $this->loadModel('user')->createOAuthCallbackURL($providerCode);?>
                <?php echo $callbackURL;?>
              </td>
            </tr>
            <?php endif;?>
            <?php if($providerCode == 'wechat'):?>
            <tr>
              <th><?php echo $lang->user->oauth->wechat->autoLogin;?></th>
              <td><?php echo html::radio('autoLogin', $lang->user->oauth->wechat->autoLoginList, isset($oauth->autoLogin) ? $oauth->autoLogin : 'off', "class='checkbox'");?></td>
            </tr>
            <?php endif;?>
            <tr>
             <th></th> 
             <td>
                <?php
                if($providerCode == 'wechat' and !extension_loaded('openssl'))
                {
                  echo html::submitButton('', "btn btn-primary", 'disabled') . html::hidden('provider', $providerCode);
                }
                else
                {
                  echo html::submitButton() . html::hidden('provider', $providerCode);
                }
                ?>
             </td>
            </tr>
            <?php if($providerCode == 'wechat' and !extension_loaded('openssl')):?>
            <tr><th></th><td class='red'><?php echo $lang->site->wechatLoginTip;?></td></tr>    
            <?php endif;?>
          </table>
        </form>
      </div>
    </div>
  </div>
  <?php endforeach;?>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
