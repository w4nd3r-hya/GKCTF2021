<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The side view file of book module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai<daitingting@xirangit.com>
 * @package     book
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<div class='col-md-2'>
  <div class="leftmenu affix hiddden-xs hidden-sm">
    <div class='panel book-list'>
      <div class='panel-body'>
        <ul class='tree tree-lines' data-idx='0'>
          <?php foreach($bookList as $bookID => $bookTitle):?> 
          <li data-idx='1' data-id="<?php echo $bookID;?>"><?php echo html::a($this->createLink('book', 'admin', "bookID=$bookID"), $bookTitle);?></li>
          <?php endforeach;?>
        </ul>
        <div class='text-right'>
          <?php commonModel::printLink('book', 'create', '', $lang->book->create);?>
          <?php commonModel::printLink('book', 'setting', '', $lang->book->setting);?>
        </div>
      </div>
    </div>
  </div>
</div>
