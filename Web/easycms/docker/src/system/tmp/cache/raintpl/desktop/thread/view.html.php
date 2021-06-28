<?php if(!class_exists('raintpl')){exit;}?><?php if(!defined("RUN_MODE")){ ?>

<?php echo die(); ?>

<?php } ?>


<?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($control->loadModel('ui')->getEffectViewFile('default', 'common', 'header'));?>

<?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw(TPL_ROOT . 'common/kindeditor.html.php');?>


<?php echo js::set('viewReplies', $lang->thread->viewReplies); ?>

<?php echo js::set('stayCurrent', $lang->thread->stayCurrent); ?>

<?php echo js::set('quoteTitle', $lang->thread->quoteTitle); ?>

<?php echo js::set('discussion', $thread->discussion); ?>

<?php echo js::set('isCurrentPage', ceil(($pager->recTotal + 1) / $pager->recPerPage) == $pager->pageID); ?>


<?php echo "<div class='row blocks' data-grid='4' data-region='thread_view-top'>"; ?>

<?php echo $control->block->printRegion($layouts, 'thread_view', 'top', true);?>

<?php echo "</div>"; ?>


<?php echo $common->printPositionBar($board, $thread);?>


<?php if($pager->pageID == 1){ ?>

<?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($control->loadModel('ui')->getEffectViewFile('default', 'thread', 'thread'));?>

<?php } ?>

<?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($control->loadModel('ui')->getEffectViewFile('default', 'thread', 'reply'));?>


<?php echo "<div class='blocks' data-region='thread_view-bottom'>"; ?>

<?php echo $control->block->printRegion($layouts, 'thread_view', 'bottom');?>

<?php echo "</div>"; ?>


<?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw(TPL_ROOT . 'common/video.html.php');?>

<?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer'));?>

