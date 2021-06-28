<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The browse view file of nav module of XiRangEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     nav
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php js::set('type', $type);?>
<?php js::set('cannotRemoveAll', $lang->nav->cannotRemoveAll); ?>
<div id='mainMenu'>
  <div class='container'>
    <ul class='nav nav-underline' id='navMenu'>
      <?php
      if(empty($_SESSION['device']) or $this->session->device == 'desktop')
      {
          $class = $type == 'desktop_top' ? "class='active'" : '';
          if($this->config->site->type != 'blog') echo "<li $class>" . html::a(helper::createLink('nav', 'admin', "type=desktop_top"), $lang->nav->desktop, $class) . '</li>';
          $class = $type == 'desktop_blog' ? "class='active'" : '';
          echo "<li $class>" . html::a(helper::createLink('nav', 'admin', "type=desktop_blog"), $lang->nav->desktop_blog, $class) . '</li>';
      }
      elseif($this->session->device == 'mobile')
      {
          if($this->config->site->type != 'blog')
          {
              $class = $type == 'mobile_top' ? "class='active'" : '';
              echo "<li $class>" . html::a(helper::createLink('nav', 'admin', "type=mobile_top"), $lang->nav->mobile_top, $class) . '</li>';
          }
          $class = $type == 'mobile_blog' ? "class='active'" : '';
          echo "<li $class>" . html::a(helper::createLink('nav', 'admin', "type=mobile_blog"), $lang->nav->mobile_blog, $class) . '</li>';
      }
      ?>
    </ul>
    <ul class='nav nav-pills' id='deviceMenu'>
      <li<?php if($this->session->device != 'mobile') echo " class='active'";?>><?php echo html::a($this->createLink('ui', 'setDevice', "device=desktop"), '<i class="icon icon-desktop"></i> ' . $lang->ui->clientDesktop);?></li>
      <li<?php if($this->session->device == 'mobile') echo " class='active'";?>><?php echo html::a($this->createLink('ui', 'setDevice', "device=mobile"), '<i class="icon icon-tablet"></i> ' . $lang->ui->clientMobile);?></li>
    </ul>
  </div>
</div>
<div class='panel'>
  <div class='panel-heading'><?php echo $lang->nav->common;?></div>
  <div class='panel-body'>
    <form class='form-inline ve-form' id='navForm' method='post'>
      <ul class='navList ulGrade1' id='navList'>
        <?php
        foreach($navs as $nav)
        {
            echo "<li class='liGrade1'>";

            $hover = (isset($nav->children) && sizeof($nav->children));
            echo $this->nav->createEntry(1, $nav, $type, $hover);
            echo "<ul class='ulGrade2 hide'>";
            if(isset($nav->children))
            {
                foreach($nav->children as $nav2)
                {
                    echo "<li class='liGrade2'>";
                    echo $this->nav->createEntry(2, $nav2, $type);
                    echo "<ul class='ulGrade3'>";
                    if(isset($nav2->children))
                    {
                        foreach($nav2->children as $nav3)
                        {
                            echo  "<li class='liGrade3'>". $this->nav->createEntry(3, $nav3, $type) .'</li>';
                        }
                    }
                    echo '</ul>';
                    echo '</li>';
                }
            }
            echo '</ul>';
            echo '</li>';
        }
        ?>
      </ul>
      <div id='submitBox'><?php echo html::a('javascript:;', $lang->save, "class='btn btn-primary submit hidden' onclick='return submitForm()'")?></div>
    </form>
  </div>
</div>
<?php /* hidden navSource start .*/ ?>
<div id='grade1NavSource' class='hide'>
  <li class='liGrade1'>
    <?php echo $this->nav->createEntry(1, null, $type);?>
    <ul class='ulGrade2'></ul>
  </li>
</div>
<div id='grade2NavSource' class='hide'>
  <ul class='ulGrade2'>
    <li class='liGrade2'>
      <?php echo $this->nav->createEntry(2, null, $type);?>
      <ul class='ulGrade3'></ul>
    </li>
  </ul>
</div>
<div id='grade3NavSource' class='hide'>
  <ul class='ulGrade3'>
    <li class='liGrade3'><?php echo $this->nav->createEntry(3, null, $type);?></li>
  </ul>
</div>
<?php /* hidden navSource end.*/ ?>

<?php include '../../common/view/footer.admin.html.php';?>
