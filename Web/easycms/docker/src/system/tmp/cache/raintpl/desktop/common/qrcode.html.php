<?php if(!class_exists('raintpl')){exit;}?><?php if(!defined("RUN_MODE")){ ?>

<?php echo die(); ?>

<?php } ?>

<?php if(isset($config->wechatPublic->hasPublic) and $config->wechatPublic->hasPublic){ ?> 
<?php $publicList=$this->var['publicList']=$control->loadModel('wechat')->getList();?>

<?php } ?>

<?php $qrcode=$this->var['qrcode'] = zget($config->ui, 'QRCode', '0');?>

<?php if(!empty($publicList) or (extension_loaded('gd') && $qrcode)){ ?>

<div id='rightDocker' class='hidden-xs'>
  <button id='rightDockerBtn' class='btn' data-toggle="popover" data-placement="left" data-target='$next'><i class='icon-qrcode'></i></button>
  <div class='popover fade'>
    <div class='arrow'></div>
    <div class='popover-content docker-right'>
      <table class='table table-borderless'>
        <tr>
          <?php if(isset($publicList)){ ?>

            <?php foreach($publicList as $public): ?>

              <?php if(!$public->qrcode){ ?>

<?php continue; ?>

<?php } ?>

              <td>
                <div class='heading'><i class='icon-weixin'>&nbsp;</i> <?php echo $public->name;?></div>
                <?php echo html::image('data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7', "data-src='{$public->qrcode}' width='200' height='200'"); ?>

              </td>
            <?php endforeach; ?>

<?php } ?>

          <?php if(extension_loaded('gd') && $qrcode){ ?>

            <td>
              <div class='heading'>
                <i class='icon-mobile-phone'></i>
                <?php echo $lang->qrcodeTip;?>

              </div>
              <?php echo html::image('data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7', "width='200' height='200' data-src='" . helper::createLink('misc', 'qrcode') . "'"); ?>

            </td>
          <?php } ?>

        </tr>
      </table>
    </div>
  </div>
</div>
<?php } ?>

