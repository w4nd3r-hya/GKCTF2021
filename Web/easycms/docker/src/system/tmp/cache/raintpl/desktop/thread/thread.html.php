<?php if(!class_exists('raintpl')){exit;}?><?php if(!defined("RUN_MODE")){ ?>


<?php echo die(); ?>

<?php } ?>

<div class='panel thread'>
  <div class='panel-heading'>
    <i class='icon-comment-alt pull-left'></i>
    <div class='panel-actions'>
      <?php if($thread->readonly){ ?>

 <span class='label'><i class='icon-lock'></i><?php echo $lang->thread->readonly;?></span> <?php } ?>

    </div>
    <strong><?php echo $thread->title;?></strong>
    <div class='text-muted'><?php echo $thread->addedDate;?></div>
  </div>
  <table class='table'>
    <tr>
      <td class='speaker'>
        <?php if(isset($speakers[$thread->author])){ ?>


          <?php echo $control->thread->printSpeaker($speakers[$thread->author]);?>


        <?php }else{ ?>

          <?php echo $thread->author;?>

<?php } ?>

      </td>
      <td id='<?php echo $thread->id;?>' class='thread-wrapper'>
        <div class='thread-content article-content'><?php echo $thread->content;?></div>
        <?php if(!empty($thread->files)){ ?>


          <div class='article-files'><?php echo $control->thread->printFiles($thread, $control->thread->canManage($board->id, $thread->author));?>

</div>
        <?php } ?>

      </td>
    </tr>
  </table>
  <div class='thread-foot'>
    <?php if(commonModel::isAvailable('score') and !empty($thread->scoreSum)){ ?>


      <span ><?php echo sprintf($lang->thread->scoreSum, $thread->scoreSum); ?>

</span>
    <?php } ?>

    <?php if($thread->editor){ ?>


      <small class='text-muted'><?php printf($lang->thread->lblEdited, $thread->editorRealname, $thread->editedDate); ?>

</small>
    <?php } ?>

    <div class='pull-right thread-actions'>
      <?php if($control->app->user->account != 'guest'){ ?>


        <?php if($control->thread->canManage($board->id)){ ?>


          <span class='thread-more-actions'>
            <?php echo html::a(inlink('stick', "thread=$thread->id"), "<i class='icon-flag-alt'></i> " . zget($lang->thread->sticks, $thread->stick), "data-toggle='modal'"); ?>


            <?php if(commonModel::isAvailable('score') and $control->thread->canManage($board->id)){ ?>


              <?php $account=$this->var['account'] = helper::safe64Encode($thread->author);?>


              <?php echo html::a(inlink('addScore', "account={$account}&objectType=thread&objectID={$thread->id}"), $lang->thread->score, "data-toggle=modal"); ?>

<?php } ?>

            <?php if($thread->hidden){ ?>


              <?php echo html::a(inlink('switchstatus',   "threadID=$thread->id"), '<i class="icon-eye-open"></i> ' . $lang->thread->show, "class='switcher'"); ?>


            <?php }else{ ?>

              <?php echo html::a(inlink('switchstatus',   "threadID=$thread->id"), '<i class="icon-eye-close"></i> ' . $lang->thread->hide, "class='switcher'"); ?>

<?php } ?>

            <?php echo html::a(inlink('delete', "threadID=$thread->id"), '<i class="icon-trash"></i> ' . $lang->delete, "class='deleter'"); ?>


            <?php echo html::a(inlink('transfer',   "threadID=$thread->id"), '<i class="icon-location-arrow"></i> ' . $lang->thread->transfer, "data-toggle='modal'"); ?>


          </span>
        <?php } ?>

        <?php if($control->thread->canManage($board->id, $thread->author)){ ?>

 <?php echo html::a(inlink('edit', "threadID=$thread->id"), '<i class="icon-pencil"></i> ' . $lang->edit); ?>

<?php } ?>

        <a href='#reply' class='thread-reply-btn'><i class='icon-reply'></i> <?php echo $lang->reply->common;?></a>
      <?php }else{ ?>

         <a href="<?php echo $control->createLink('user', 'login', 'referer=' . helper::safe64Encode($control->app->getURI(true) . '#reply'));?>

" class="thread-reply-btn"><i class="icon-reply"></i> <?php echo $lang->reply->common;?></a>
      <?php } ?>

    </div>
  </div>
</div>
