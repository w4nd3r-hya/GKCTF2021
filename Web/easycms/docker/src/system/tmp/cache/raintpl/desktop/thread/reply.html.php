<?php if(!class_exists('raintpl')){exit;}?><?php if(!defined("RUN_MODE")){ ?>

<?php echo die(); ?>

<?php } ?>

<?php foreach($replies as $reply): ?>

<?php $floor=$this->var['floor'] = $floors[$reply->id];?>

<div id = "<?php echo $reply->id; ?>" class="panel panel thread reply <?php echo $floor%2!=0?'striped':''; ?>">
  <div class='panel-heading'>
    <div class='panel-actions'>
      <strong><?php if($floor > 2){ ?>

<?php echo '#' . $floor; ?>

<?php } ?></strong>
      <?php echo html::a('', '', "name=$floor"); ?>

      <?php if($floor == 1){ ?>

        <strong class='text-danger'><?php echo $lang->reply->sofa; ?></strong>
      <?php }elseif($floor == 2){ ?>

        <strong class='text-success'><?php echo $lang->reply->stool; ?></strong>
      <?php } ?>

    </div>
    <span class='muted'>
      <i class='icon-comment-alt'></i> <?php echo $reply->addedDate; ?>

      <?php if(!$thread->discussion and $reply->reply){ ?>

      <?php echo sprintf($lang->thread->replyFloor, zget($floors, $reply->reply)); ?>

<?php } ?>

    </span>
  </div>
  <table class='table'>
    <tr>
      <td class='speaker'>
        <?php if(isset($speakers[$reply->author])){ ?>

            <?php echo $control->thread->printSpeaker($speakers[$reply->author]);?>

        <?php }else{ ?>

            <?php echo $reply->author; ?>

<?php } ?>

      </td>
      <td id='<?php echo $reply->id; ?>' class='thread-wrapper'>
        <div class='thread-content article-content'><?php echo $reply->content; ?></div>
        <?php if(!empty($reply->files)){ ?>

          <div class='article-files'><?php echo $control->reply->printFiles($reply, $control->thread->canManage($board->id, $reply->author));?></div>
        <?php } ?>

        <?php if($thread->discussion){ ?>

          <?php echo $control->reply->getByReply($reply);?>

<?php } ?>

      </td>
    </tr>
  </table>
  <div class='thread-foot'>
    <?php if(commonModel::isAvailable('score') and !empty($reply->scoreSum)){ ?>

      <?php echo sprintf($lang->thread->scoreSum, $reply->scoreSum); ?>

<?php } ?>

    <?php if($reply->editor){ ?>

      <small class='text-muted'><?php printf($lang->thread->lblEdited, $reply->editorRealname, $reply->editedDate); ?></small>
    <?php } ?>

    <div class="pull-right reply-actions thread-actions">
    <?php if($control->app->user->account != 'guest'){ ?>

    <span class="thread-more-actions">
      <?php if(commonModel::isAvailable('score') and $control->thread->canManage($board->id)){ ?>

        <?php $account=$this->var['account'] = helper::safe64Encode($reply->author);?>

        <?php echo html::a(inlink('addScore', "account={$account}&objectType=reply&objectID={$reply->id}"), $lang->thread->score, "data-toggle=modal"); ?>

<?php } ?>

      <?php if($control->thread->canManage($board->id)){ ?>

<?php echo html::a($control->createLink('reply', 'delete', "replyID=$reply->id"), '<i class="icon-trash"></i> ' . $lang->delete, "class='deleter'"); ?>

<?php } ?>

      <?php if($control->thread->canManage($board->id, $reply->author)){ ?>

<?php echo html::a($control->createLink('reply', 'edit',   "replyID=$reply->id"), '<i class="icon-pencil"></i> ' . $lang->edit); ?>

<?php } ?>

    </span>
    <a href="#reply" data-reply='<?php echo $reply->id; ?>' class="thread-reply-btn"><i class="icon-reply"></i> <?php echo $lang->reply->common; ?></a>
    <a href="#reply" data-reply='<?php echo $reply->id; ?>' class="thread-reply-btn quote"><i class="icon-quote-left"></i> <?php echo $lang->thread->quote; ?></a>
    <?php }else{ ?>

    <a data-reply='<?php echo $reply->id; ?>' href="<?php echo $control->createLink('user', 'login', 'referer=' . helper::safe64Encode($control->app->getURI(true) . '#' . $reply->id)); ?>" class="thread-reply-btn"><i class="icon-reply"></i> <?php echo $lang->reply->common; ?></a>
    <?php } ?>

    </div>
  </div>
</div>
<?php endforeach; ?>


<div class='clearfix pager'><?php echo $pager->show('right', 'short');?></div>

<?php if($thread->readonly){ ?>

<div class='alert alert-info'><?php echo $lang->thread->readonlyMessage; ?></div>
<?php }elseif($control->session->user->account != 'guest'){ ?>

<div class='panel panel-form'>
  <div class='panel-heading'><strong><i class='icon-edit'></i> <?php echo $lang->thread->replies; ?></strong></div>
  <div class='panel-body'>
    <form method='post' enctype='multipart/form-data' id='replyForm' action='<?php echo $control->createLink('reply', 'post', "thread=$thread->id"); ?>'>
      <div class='form-group' id='reply'>
        <?php echo html::textarea('content', '', "rows='6' class='form-control'"); ?>

      </div>
      <div class='row'>
        <div class='col-md-8 col-sm-12'>
          <?php echo $control->fetch('file', 'buildForm'); ?>

          <?php if(zget($control->config->site, 'captcha', 'auto') == 'open'){ ?>

            <div class='form-group clearfix' id='captchaBox'><?php echo $control->loadModel('guarder')->create4reply(); ?></div>
          <?php }else{ ?>

            <div class='form-group clearfix' id='captchaBox' style='display:none;'></div>
          <?php } ?>

        </div>
      </div>
      
      <div class='form-group'><?php echo html::submitButton(); ?></div>
      <?php echo html::hidden('reply', 0); ?>

    </form>
  </div>
</div>
<?php } ?>

