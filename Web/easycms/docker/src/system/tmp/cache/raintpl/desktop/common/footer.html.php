<?php if(!class_exists('raintpl')){exit;}?><?php if(!defined("RUN_MODE")){ ?>

<?php echo die(); ?>

<?php } ?>

  <div class='blocks all-bottom row' data-region='all-bottom'>
  <?php echo $control->block->printRegion($layouts, 'all', 'bottom', true); ?>
  </div>
  </div></div>
  
  <footer id='footer' class='clearfix'>
    <div class='wrapper'>
      <div id='footNav'>
        <?php echo html::a(helper::createLink('sitemap', 'index'), '<i class=\'icon-sitemap\'></i> ' . $lang->sitemap->common, "class='text-linki'"); ?>
        <?php if(empty($config->links->index) && !empty($config->links->all)){ ?>
        <?php echo html::a(helper::createLink('links', 'index'), "<i class='icon-link'></i> " . $lang->link); ?>

<?php } ?>
      </div>
      <span id='copyright'>
       <?php $copyright=$this->var['copyright']=empty($config->site->copyright) ? '' : $config->site->copyright . '-';?>
       <?php $contact=$this->var['contact']=json_decode($config->company->contact);?>
       <?php $company=$this->var['company']=(empty($contact->site) or $contact->site == $control->server->http_host) ? $config->company->name : html::a('http://' . $contact->site, $config->company->name, "target='_blank'");?>
       &copy; <?php echo $copyright;?> <?php echo date('Y'); ?> <?php echo $company;?> &nbsp;&nbsp;
      </span>
      <span id='icpInfo'>
        <?php if(!empty($config->site->icpLink) and !empty($config->site->icpSN)){ ?>
          <?php echo html::a(strpos($config->site->icpLink, 'http://') !== false ? $config->site->icpLink : 'http://' . $config->site->icpLink, $config->site->icpSN, "target='_blank'"); ?>

<?php } ?>
        <?php if(empty($config->site->icpLink) and !empty($config->site->icpSN)){ ?>
          <?php echo $config->site->icpSN;?>

<?php } ?>
        <?php if(!empty($config->site->policeLink) and !empty($config->site->policeSN)){ ?>
          <?php echo html::a(strpos($config->site->policeLink, 'http://') !== false ? $config->site->policeLink : 'http://' . $config->site->policeLink, html::image($webRoot . 'theme/default/default/images/main/police.png'), "target='_blank'"); ?>

<?php } ?>
      </span>
      <div id='powerby'>
          <?php echo commonModel::printPowerdBy(); ?>
      </div>
      <?php if($config->site->execInfo == 'show'){ ?>

<?php echo $config->execPlaceholder;?>

<?php } ?>
    </div>
  </footer>
  <?php if($config->debug){ ?>
    <?php echo js::import($jsRoot . 'jquery/form/min.js'); ?>

<?php } ?>
  <?php if(isset($pageJS)){ ?>
  <?php echo js::execute($pageJS); ?>

<?php } ?>
  <?php $extPath=$this->var['extPath']=TPL_ROOT . 'common' . DS . 'ext' . DS;?>
  <?php $extHookRule=$this->var['extHookRule']=$extPath . 'footer.front.*.hook.php';?>
  <?php $extHookFiles=$this->var['extHookFiles']=glob($extHookRule);?>
  <?php foreach($extHookFiles as $hook): ?>
  <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($hook);?>
  <?php endforeach; ?>
<a href='#' id='go2top' class='icon-arrow-up' data-toggle='tooltip' title='<?php echo $lang->back2Top;?>'></a>
</div>
<?php $qrcodeTpl=$this->var['qrcodeTpl']=$control->loadModel('ui')->getEffectViewFile('default', 'common', 'qrcode');?>
<?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($qrcodeTpl);?>
<div class='hide'><?php echo $control->loadModel('block')->printRegion($layouts, 'all', 'footer'); ?></div>
<?php if(commonModel::isAvailable('shop')){ ?>
  <?php $cartTpl=$this->var['cartTpl']=TPL_ROOT . 'common/cart.html.php';?>
  <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($cartTpl);?>

<?php } ?>
<?php $logTpl=$this->var['logTpl']=TPL_ROOT . 'common/log.html.php';;?>
<?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($logTpl);?>
<?php if($app->user->account != 'guest' and commonModel::isAvailable('score') and (!isset($config->site->resetMaxLoginDate) or $config->site->resetMaxLoginDate < date('Y-m-d'))){ ?>
  <script>$.get(createLink('score', 'resetMaxLogin'));</script>
<?php } ?>
</body>
</html>
