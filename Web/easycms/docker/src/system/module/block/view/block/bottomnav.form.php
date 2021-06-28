<?php if(!defined("RUN_MODE")) die();?>
<tr>
  <th><?php echo $lang->block->navPosition;?></th>
  <td class='form-inline' colspan='2'>
    <ul class='navList ulGrade1' id='navList'>
      <?php
      $navs = isset($block->content->nav) ? $block->content->nav : $this->loadModel('nav')->getDefault('desktop_bottom');
      foreach($navs as $nav)
      {
          echo "<li class='liGrade1'>";
          echo $this->loadModel('nav')->createEntry(1, $nav, 'desktop_bottom');
          echo "<ul class='ulGrade2'>";
          if(isset($nav->children))
          {
              foreach($nav->children as $nav2)
              {
                  echo "<li class='liGrade2'>";
                  echo $this->nav->createEntry(2, $nav2, 'desktop_bottom');
                  echo '</li>';
              }
          }
          echo '</ul>';
          echo '</li>';
      }
      ?>
    </ul>
  </td>
</tr>
