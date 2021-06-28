<?php if(!class_exists('raintpl')){exit;}?><?php if(!defined("RUN_MODE")){ ?>



<?php echo die(); ?>

<?php } ?>

<?php if(!defined("RUN_MODE")){ ?>



<?php echo die(); ?>

<?php } ?>

<?php $extView=$this->var['extView']=$control->getExtViewFile(TPL_ROOT . 'common/header.lite.html.php');?>



<?php if($extView){ ?>



  <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($extView);?>

  <?php return helper::cd(); ?>

<?php } ?>

<?php $sysURL=$this->var['sysURL']=rtrim($sysURL, '/');?>



<?php if(isset($mobileURL)){ ?>



<?php $mobileURL=$this->var['mobileURL']=ltrim($mobileURL, '/');?>

<?php } ?>

<!DOCTYPE html>
<html xmlns:wb="http://open.weibo.com/wb" lang='<?php echo $app->getClientLang();?>


' class='m-<?php echo $thisModuleName;?> m-<?php echo $thisModuleName;?>-<?php echo $thisMethodName;?>'>
<head profile="http://www.w3.org/2005/10/profile">
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Cache-Control"  content="no-transform">
  <?php if($app->getClientLang() == 'en'){ ?>



    <meta name="Generator" content="Zsite<?php echo $config->version;?> www.zsite.net'">
  <?php }else{ ?>

    <meta name="Generator" content="chanzhi<?php echo $config->version;?> www.chanzhi.org'">
  <?php } ?>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php if(isset($mobileURL)){ ?>



    <link rel="alternate" media="only screen and (max-width: 640px)" href="<?php echo $sysURL;?>/<?php echo $mobileURL;?>">
  <?php } ?>


  <?php if(isset($sourceURL)){ ?>



    <link rel="canonical" href="<?php echo $sysURL;?>/<?php echo $sourceURL;?>" >
  <?php }else{ ?>

    <?php if(isset($canonicalURL)){ ?>


 <link rel="canonical" href="<?php echo $sysURL;?>/<?php echo $canonicalURL;?>" > <?php } ?>

<?php } ?>

  <?php if($thisModuleName == 'user' and $thisMethodName == 'deny'){ ?>


 <meta http-equiv='refresh' content="5;url=<?php echo helper::createLink('index'); ?>


"> <?php } ?> 

  <?php if(!isset($title)){ ?>


   <?php $title=$this->var['title']    = '';?>

<?php } ?>

  <?php if(!empty($title)){ ?>


   <?php $title=$this->var['title']   .= $lang->minus;?>

<?php } ?>

  <?php if(empty($keywords)){ ?>


 <?php $keywords=$this->var['keywords'] = $config->site->keywords;?>

<?php } ?>

  <?php if(empty($desc)){ ?>


     <?php $desc=$this->var['desc']     = $config->site->desc;?>

<?php } ?>


  <?php echo html::title($title . $config->site->name); ?>



  <?php echo html::meta('keywords', $keywords); ?>



  <?php echo html::meta('description', $desc); ?>



  <?php if(isset($config->site->meta)){ ?>


<?php echo $config->site->meta;?>

<?php } ?>


  <?php if($config->debug){ ?>



    <?php echo js::import($jsRoot . 'jquery/min.js'); ?>



    <?php echo js::import($jsRoot . 'zui/min.js'); ?>



    <?php echo js::import($jsRoot . 'chanzhi.js'); ?>



    <?php echo js::import($jsRoot . 'my.js'); ?>



    <?php echo css::import($webRoot . 'zui/css/min.css'); ?>



    <?php echo css::import($themeRoot . 'common/style.css'); ?>



    <?php if(file_exists($customCssFile)){ ?>


 <?php echo css::import($customCssURI, "id='themeStyle'", $version = false); ?>

<?php } ?>

  <?php }else{ ?>

    <?php if($cdnRoot){ ?>



      <?php echo css::import($cdnRoot . '/theme/default/default/chanzhi.all.css', '', $version = false); ?>



    <?php }else{ ?>

      <?php echo css::import($themeRoot . 'default/chanzhi.all.css'); ?>

<?php } ?>

    <?php if(file_exists($customCssFile)){ ?>


 <?php echo css::import($customCssURI, "id='themeStyle'", $version = false); ?>

<?php } ?>

    <?php if($cdnRoot){ ?>



      <?php echo js::import($cdnRoot  . '/js/chanzhi.all.js', $version = false); ?>



    <?php }else{ ?>

      <?php echo js::import($jsRoot     . 'chanzhi.all.js'); ?>

<?php } ?>

<?php } ?>

  <?php if(isset($pageCSS)){ ?>


 <?php echo css::internal($pageCSS); ?>

<?php } ?>

  <?php echo js::exportConfigVars(); ?>



  <?php echo js::set('theme', array('template' => CHANZHI_TEMPLATE, 'theme' => CHANZHI_THEME, 'device' => $app->clientDevice)); ?>



  <?php echo html::icon($favicon); ?>



  <?php echo html::rss(helper::createLink('rss', 'index', '', '', 'xml'), $config->site->name); ?>



  
  <!--[if lt IE 9]>
    <?php if($config->debug){ ?>



      <?php echo js::import($jsRoot . 'html5shiv/min.js'); ?>



      <?php echo js::import($jsRoot . 'respond/min.js'); ?>



    <?php }else{ ?>

      <?php if($cdnRoot){ ?>



  	    <link href="<?php echo $cdnRoot;?>/js/respond/cross-domain/respond-proxy.html" id="respond-proxy" rel="respond-proxy" />
        <link href="/js/respond/cross-domain/respond.proxy.gif" id="respond-redirect" rel="respond-redirect" />
        <?php echo js::import($jsRoot . 'html5shiv/min.js'); ?>



        <?php echo js::import($jsRoot . 'respond/min.js'); ?>



        <?php echo js::import($jsRoot . 'respond/cross-domain/respond.proxy.js'); ?>



      <?php }else{ ?>

  	    <?php echo js::import($jsRoot . 'chanzhi.all.ie8.js'); ?>

<?php } ?>

    <?php } ?>

  <![endif]-->
  <!--[if lt IE 10]>
    <?php if($config->debug){ ?>


 <?php echo js::import($jsRoot . 'jquery/placeholder/min.js'); ?>

<?php } ?>

    <?php if(!$config->debug){ ?>


 <?php echo js::import($jsRoot . 'chanzhi.all.ie9.js'); ?>

<?php } ?>

  <![endif]-->
  
  <?php echo js::set('lang', $lang->js); ?>



  <?php if(!empty($config->oauth->sina) and !is_object($config->oauth->sina)){ ?>



    <?php $sina=$this->var['sina']=json_decode($config->oauth->sina);?>

<?php } ?>

  <?php if(!empty($config->oauth->qq) and !is_object($config->oauth->qq)){ ?>



    <?php $qq=$this->var['qq']=json_decode($config->oauth->qq);?>

<?php } ?>

  <?php if(!empty($sina->verification)){ ?>


 <?php echo $sina->verification;?>

<?php } ?>

  <?php if(!empty($qq->verification)){ ?>


 <?php echo $qq->verification;?>

<?php } ?>

  <?php if(!empty($sina->widget)){ ?>



    <?php echo js::import('https://tjs.sjs.sinajs.cn/open/api/js/wb.js'); ?>

<?php } ?>

  <?php $baseCustom=$this->var['baseCustom']=isset($config->template->custom) ? json_decode($config->template->custom, true) : array();?>



  <?php if(!empty($baseCustom["CHANZHI_TEMPLATE"]["CHANZHI_THEME"]['js'])){ ?>



    <?php echo js::execute($baseCustom["CHANZHI_THEME"]["CHANZHI_THEME"]['js']); ?>

<?php } ?>

  <?php echo $control->block->printRegion($layouts, 'all', 'header');?>



</head>
<body>
<?php $customCssFile=$this->var['customCssFile'] = $control->loadModel('ui')->getCustomCssFile(CHANZHI_TEMPLATE, CHANZHI_THEME);?>



<?php if(!file_exists($customCssFile) or !is_readable($customCssFile)){ ?>



  <?php $resultCustomCss=$this->var['resultCustomCss'] = $control->loadModel('ui')->createCustomerCss(CHANZHI_TEMPLATE, CHANZHI_THEME);?>

<?php } ?>

<?php if(isset($resultCustomCss) and $resultCustomCss['result'] != 'success'){ ?>



  <?php if(!empty($resultCustomCss['message'])){ ?>



    <div class='alert alert-danger'> <?php echo $lang->customCssError;?> </div>
  <?php } ?>

<?php } ?>

