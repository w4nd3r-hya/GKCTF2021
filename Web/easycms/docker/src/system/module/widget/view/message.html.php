<?php if(!defined("RUN_MODE")) die();?>
<?php
$this->loadModel('message');
$limit  = zget($widget->params, 'limit', 10);
$messages = $this->message->getListForWidget($limit);
$messageCount = 0;
$commentCount = 0;
$replyCount   = 0;
foreach($messages as $message)
{
    if($message->type == 'message') $messageCount += 1;
    if($message->type == 'comment') $commentCount += 1;
    if($message->type == 'reply')   $replyCount   += 1;
}
?>
<table class='table table-data table-hover table-fixed'>
  <?php foreach($messages as $message):?>
  <tr>
    <td>
    <?php
    $href = helper::createLink('message', 'reply', "id={$message->id}");
    echo $message->from . $lang->colon . html::a($href, $message->content, "data-toggle='modal'");
    ?>
    </td>
  </tr>
  <?php endforeach;?>
</table>
<?php if($messageCount) echo html::a(helper::createLink('message', 'admin', "type=message"), $lang->widget->message . "[$messageCount]", "class='panel-action btn-count'");?>
<?php if($commentCount) echo html::a(helper::createLink('message', 'admin', "type=comment"), $lang->widget->comment . "[$commentCount]", "class='panel-action btn-count'");?>
<?php if($replyCount)   echo html::a(helper::createLink('message', 'admin', "type=reply"), $lang->widget->reply . "[$replyCount]",       "class='panel-action btn-count'");?>
<script>
$(document).ready(function()
{
    var panel = $('#widget' + <?php echo $widget->order;?>);
    if(panel.find('.panel-actions > .panel-action').length == 0)
    {
       $('.btn-count').prependTo(panel.find('.panel-actions')).show();
    }
})
</script>
