<?php if(!defined("RUN_MODE")) die();?>
<?php
include '../../common/view/header.lite.html.php';
js::import($jsRoot . 'fingerprint/fingerprint.js');
js::import($jsRoot . 'md5.js');
js::set('scriptName', $_SERVER['SCRIPT_NAME']);
js::set('random', $this->session->random);
?>
<div class='container'>
  <div id='adminLogin'>
    <div id='siteName'>
      <h4 class='text-ellipsis text-rightPadding'>
        <?php echo $this->config->site->name;?>
      </h4>
      <div class='pull-right'>
        <div class='dropdown' id='langs'>
          <button class='btn' style='width:81px' data-toggle='dropdown' title='Change Language/更换语言/更換語言'><?php echo $config->langs[$this->app->getClientLang()]; ?> <span class='caret'></span></button>
          <ul class='dropdown-menu'>
          <?php
          if(isset($config->cn2tw) and $config->cn2tw) unset($config->langs['zh-tw']);
          $clientLang = $this->app->getClientLang();
          unset($config->langs[$clientLang]);
          ?>
          <?php foreach($config->langs as $key => $value):?>
          <li class="<?php echo $key == $clientLang ? 'active' : ''; ?>">
            <?php echo html::a($this->createLink('admin', 'switchlang', "lang={$key}"), $value);?>
          </li>
          <?php endforeach;?>
          </ul>
        </div>
      </div>
    </div>
    <form method='post' id='ajaxForm' data-checkfingerprint='1'>
      <div id='formError' class='alert alert-danger hiding'></div>
      <div class='row'>
        <div class='col-xs-4 text-center'>
        <?php if($this->app->clientLang == 'en'):?>
        <?php echo html::image($this->config->webRoot . 'theme/default/default/images/main/logo.login.admin.en.png'); ?>
        <?php else:?>
        <?php echo html::image($this->config->webRoot . 'theme/default/default/images/main/logo.login.admin.png'); ?>
        <?php endif;?>
        </div>
        <div class='col-xs-8'>
          <table class="table table-form">
            <tr>
              <th class='w-60px'><?php echo $lang->user->account?></th>
              <td><?php echo html::input('account','',"class='form-control' placeholder='{$lang->user->inputAccountOrEmail}'");?></td>
            </tr>
            <tr>
              <th><?php echo $lang->user->password?></th>
              <td><?php echo html::password('password','',"class='form-control' placeholder='{$lang->user->inputPassword}'");?></td>
            </tr>
            <tr>
              <th><?php echo html::a('', $lang->save, "data-toggle='modal' class='hidden captchaModal'")?></th>
              <td>
                <?php echo html::submitButton($lang->user->login->common, 'btn btn-primary btn');?>
              </td>
            </tr>
          </table>
          <?php echo html::hidden('referer', $referer);?>
        </div>
      </div>
    </form>
  </div>
</div>
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);
?>
<style>
  #siteName{position:relative;}
  .text-rightPadding{padding-right:80px;}
  .pull-right{position:absolute;top:16px;right:20px;}
</style>
</body>
</html>
