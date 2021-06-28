<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The html block form view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<?php if($this->app->clientDevice == 'desktop'):?>
<?php include '../../common/view/kindeditor.html.php';?>

<?php if(!isset($block)) $block = new stdclass();?>
<?php if(!isset($block->content)) $block->content = new stdclass();?>
<?php js::set('noInsertTip', $lang->block->noInsertTip);?>
<tr class='top'>
  <th id='tableHeadingtop' rowspan='2'><?php echo $lang->block->header->top->common;?></th>
  <td class='w-p45'>
    <div class='input-group'>
      <span class='input-group-addon'><?php echo $lang->block->header->top->left;?></span>
      <?php echo html::select('params[top][left]', $lang->block->header->top->leftOptions, isset($block->content->top->left) ? $block->content->top->left : '', "class='form-control'");?>
    </div>
  </td>
</tr>
<tr class='top topLeft hide'>
  <td><?php echo html::textarea("params[topLeftContent]", isset($block->content->topLeftContent) ? $block->content->topLeftContent : '', "class='form-control'");?></td>
</tr>
<tr class='top'>
  <td>
    <div class='input-group'>
      <span class='input-group-addon'><?php echo $lang->block->header->top->right;?></span>
      <?php echo html::select('params[top][right]', $lang->block->header->top->rightOptions, isset($block->content->top->right) ? $block->content->top->right : 'login', "class='form-control'");?>
    </div>
  </td>
  <td></td>
</tr>
<tr class='top topRight hide'>
  <td>
    <?php echo html::textarea("params[topRightContent]", isset($block->content->topRightContent) ? $block->content->topRightContent : '', "class='form-control textarea-withchosen' rows='5'");?>
    <div class='textarea-chosen'>
        <?php echo html::a('javascript:;', $lang->block->header->top->rightOptions['login'], "id='login' class='btn btn-xs btn-addChoice btn-default btn-select'");?>
        <?php echo html::a('javascript:;', $lang->block->header->top->rightOptions['search'], "id='search' class='btn btn-xs btn-addChoice btn-default btn-select'");?>
    </div>
    <p></p>
  </td>
</tr>
<tr class='middle'>
  <th><?php echo $lang->block->header->middle->common;?></th>
  <td colsapn='2'>
    <div class='input-group'>
      <span class='input-group-addon'><?php echo $lang->block->header->middle->left;?></span>
      <?php echo html::select('params[middle][left]', $lang->block->header->middle->leftOptions, isset($block->content->middle->left) ? $block->content->middle->left : 'logo', "class='form-control'");?>
      <span class='input-group-addon'><?php echo $lang->block->header->middle->center;?></span>
      <?php echo html::select('params[middle][center]', $lang->block->header->middle->centerOptions, isset($block->content->middle->center) ? $block->content->middle->center : 'slogan', "class='form-control'");?>
      <span class='input-group-addon'><?php echo $lang->block->header->middle->right;?></span>
      <?php echo html::select('params[middle][right]', $lang->block->header->middle->rightOptions, isset($block->content->middle->right) ? $block->content->middle->right : 'search', "class='form-control'");?>
    </div>
  </td>
</tr>
<tr class='bottom'>
  <th><?php echo $lang->block->header->bottom->common;?></th>
  <td><?php echo html::select('params[bottom]', $lang->block->header->bottomOptions, isset($block->content->bottom) ? $block->content->bottom : 'nav', "class='form-control'");?></td>
  <td></td>
</tr>
<tr>
  <th></th>
  <td colspan='2'>
    <div class='checkbox'><label><input style='margin-top: 3px' type='checkbox' id='compatible'  name='params[compatible]' value='1'<?php if(zget($block->content, 'compatible', 0)) echo " checked='checked'" ?>> <?php echo $lang->block->headerLayout->compatibleEnable ?></label></div>
  </td>
</tr>
<script>
$(".btn-addChoice").click(function(){
    choiceItem      = this.id;
    topRightContent = $("[name*=params][name*=topRightContent]").val();
    topRightContent += '$' + choiceItem.toUpperCase() + ' ';

    if(!checkChoiceInserted($("[name*=params][name*=topRightContent]").val(), choiceItem)) 
    {
        $("[name*=params][name*=topRightContent]").val(topRightContent); 
    }
});

var checkChoiceInserted = function(searchedStr, searchItem){
    if(searchItem == 'login')
    {
        if(searchedStr.indexOf('$LOGIN') >= 0) return true;
    }
    if(searchItem == 'search')
    {
        if(searchedStr.indexOf('$SEARCH') >= 0) return true;
    }
    
    return false;
};

$(function()
{
    $('#compatible').change(function()
    {
        $('tr.top, tr.middle, tr.bottom').toggle(!$(this).is(':checked'));
        $("[name*=params][name*=top][name*=left]").change();
    }).change();

    $("[name*=params][name*=top][name*=left]").change(function()
    {
        if($(this).val() == 'custom')
        {
            $('tr.topLeft').show();
            if($("[name*=params][name*=top][name*=right]").val() == 'custom')
            {
                $("#tableHeadingtop").attr('rowspan', '4');
            }
            else
            {
                $("#tableHeadingtop").attr('rowspan', '3');
            }
        }
        else
        {
            $('tr.topLeft').hide();
            if($("[name*=params][name*=top][name*=right]").val() == 'custom')
            {
                $("#tableHeadingtop").attr('rowspan', '3');
            }
            else
            {
                $("#tableHeadingtop").attr('rowspan', '2');
            }
        }
    })

    $("[name*=params][name*=top][name*=right]").change(function()
    {
        if($(this).val() == 'custom')
        {
            $('tr.topRight').show();
            if($("[name*=params][name*=top][name*=left]").val() == 'custom')
            {
                $("#tableHeadingtop").attr('rowspan', '4');
            }
            else
            {
                $("#tableHeadingtop").attr('rowspan', '3');
            }
        }
        else
        {
            $('tr.topRight').hide();
            if($("[name*=params][name*=top][name*=left]").val() == 'custom')
            {
                $("#tableHeadingtop").attr('rowspan', '3');
            }
            else
            {
                $("#tableHeadingtop").attr('rowspan', '2');
            }
        }
    })
    $("[name*=params][name*=top][name*=left]").change();
    $("[name*=params][name*=top][name*=right]").change();
})
</script>
<?php endif;?>
