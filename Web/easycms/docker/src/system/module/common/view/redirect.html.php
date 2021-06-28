<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The html template file of deny method of user module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     chanzhiEPS
 * @version     $Id: deny.html.php 824 2010-05-02 15:32:06Z wwccss $
 */
include '../../common/view/header.lite.html.php';
?>
<style>
.alert.with-icon > .icon, .alert.with-icon > .icon + .content {padding: 20px 20px 20px;}
.alert.with-icon > .icon {padding-left: 35px;}
.alert-deny {max-width: 500px; margin: 8% auto; padding: 0; background-color: #FFF; border: 1px solid #DDD; box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.2); border-radius: 6px;}
.btn-link {border-color: none!important}
#mainInfo{padding:10px 0; font-size:14px;}
.btn-redirec{margin-left:14px;}
</style>
<div class='container w-600px'>
  <div class='alert with-icon alert-deny'>
    <i class='icon-info-sign icon'></i>
    <div class='content'>
      <div id='mainInfo'><?php echo $reason;?></div>
      <div class='actions'><?php printf($lang->redirecting, $locate);?></div>
    </div>
  </div>
</div>
</body>
<script>
$(function()
{
    setInterval(function()
    {
        var countDown = $('#countDown');
        var count = parseInt(countDown.text());
        if(count > 1)
        {
            countDown.text(count-1);
        }
        else
        {
            window.location.href = $('.btn-redirec').attr('href');
        }
    }, 1000);
})
</script>
</html>
