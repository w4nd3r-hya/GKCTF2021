<?php if(!defined("RUN_MODE")) die();?>
<table class='table table-borderless w-p100'>
  <tr class='original'>
    <td>
      <?php echo "<i class='icon-user'></i> <strong>{$message->from}</strong> &nbsp;";?>
      <?php echo "<span class='gray'>$message->date</span>";?>
      <?php if(!empty($message->link))  echo html::a($message->link, $message->link, "target='_blank'");?>
      <br/>
      <?php if(!empty($message->phone))  echo "<i class='icon-phone text-info icon'></i> " . str2Entity($message->phone) . "&nbsp; ";?>
      <?php if(!empty($message->mobile)) echo "<i class='icon-mobile text-info icon'></i> " . str2Entity($message->mobile) . "&nbsp; ";?>
      <?php if(!empty($message->email))  echo "<i class='icon-envelope text-warning icon'></i> " . str2Entity($message->email) . "&nbsp; ";?>
      <?php if(!empty($message->qq))     echo "<strong class='text-danger'>QQ</strong> " . str2Entity($message->qq) . "&nbsp; ";?>
    </td>
  </tr>
  <tr class='original'>
    <td class='content-box'>
      <textarea name="" id="" rows="2" class="form-control borderless" spellcheck="false"><?php echo $message->content;?></textarea>
    </td>
  </tr>
</table>
