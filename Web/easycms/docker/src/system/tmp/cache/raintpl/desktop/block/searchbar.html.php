<?php if(!class_exists('raintpl')){exit;}?><?php if(!defined("RUN_MODE")){ ?>

<?php echo die(); ?>

<?php } ?>

<?php if($isSearchAvaliable){ ?>

  <div id='searchbar' data-ve='search'>
    <form action='<?php echo helper::createLink('search'); ?>' method='get' role='search'>
      <div class='input-group'>
        <?php echo $config->searchWordPlaceHolder;?>

        <?php if($config->requestType == 'GET'){ ?>

<?php echo html::hidden($config->moduleVar, 'search') . html::hidden($config->methodVar, 'index'); ?>

<?php } ?>

        <div class='input-group-btn'>
          <button class='btn btn-default' type='submit'><i class='icon icon-search'></i></button>
        </div>
      </div>
    </form>
  </div>
<?php } ?>


