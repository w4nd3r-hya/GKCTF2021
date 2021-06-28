<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of visual module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     visual
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php
class visualModel extends model
{
    /**
     * Print layout item
     *
     * @access public
     * @param  object $item
     * @param  string $region
     * @param  string $page
     * @param  object $regionBlocks
     * @return string
     */
    public function printLayoutItem($item, $region, $page)
    {
        if(!isset($item['title']))
        {
            if($item['type'] === 'placeholder')
            {
                $item['title'] = $this->lang->visual->design->placeholders[$item['name']];
            }
            else if($item['type'] !== 'col')
            {
                $item['title'] = zget($region, $item['name'], '');
            }
            else
            {
                $item['title'] = '';
            }
        }

        $attrs    = '';
        $class    = '';
        $isRegion = false;
        $inGrid   = false;
        switch($item['type'])
        {
            case 'placeholder':
                $class .= 'layout-placeholder';
                break;
            case 'row':
                $class .= 'layout-row row';
                break;
            case 'col':
                $class .= 'layout-col col';
                $attrs .= " style='width: {$item['colWidth']}'";
                break;
            default:
                $class .= 'layout-region';
                $isRegion = true;
                break;
        }

        echo "<div class='layout-item type-{$item['type']} {$class}' data-title='{$item['title']}' data-name='{$item['name']}' {$attrs}>";

        $footer = '';
        if($item['type'] === 'grid')
        {
            echo '<div class="row">';
            $footer = '</div>';
            $inGrid = true;
        }
        else if($item['type'] === 'col')
        {
            echo '<div class="col-container">';
            $footer = '</div>';
        }
        else if($item['type'] === 'row')
        {
            echo '<div class="actions">' . html::a('javascript:;', '<i class="icon icon-columns"></i> ' . $this->lang->visual->design->setColumns, "class='btn-setPageColumns' data-page='$page'") . '</div>';
        }
        
        if(!empty($item['children']))
        {
            foreach ($item['children'] as $child)
            {
                $this->printLayoutItem($child, $region, $page);
            }
        }
        
        echo $footer;
        echo '</div>';
    }
}
