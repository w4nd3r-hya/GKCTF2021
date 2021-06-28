<?php if(!defined("RUN_MODE")) die();?>
<?php
$this->loadModel('thread');
$limit  = zget($widget->params, 'limit', 10);
$threads = $this->thread->getListForWidget($limit);
?>
<table class='table table-data table-hover table-fixed'>
  <?php foreach($threads as $thread):?>
  <tr>
    <td>
      <?php echo html::a(commonModel::createFrontLink('thread', 'view', "id={$thread->id}"), $thread->title, "target='_blank'");?>
    </td>
    <?php 
      $realName = $this->loadModel("user")->getPairs();
      echo "<td class='w-55px text-center' title='{$realName[$thread->author]}'>";
      echo $realName[$thread->author];
      echo "</td>";
    ?>
    <?php if(!empty($this->config->forum->postReview) and $this->config->forum->postReview == 'open'):?>
    <td class='w-50px text-center'><?php echo zget($lang->thread->statusList, $thread->status);?></td>
    <?php endif;?>
    <td class='w-80px'><?php echo formatTime($thread->addedDate, 'm-d H:i');?></td>
  </tr>
  <?php endforeach;?>
</table>
