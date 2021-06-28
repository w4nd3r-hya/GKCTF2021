<?php
/**
 * ZenTaoPHP的分页类。
 * The pager class file of ZenTaoPHP framework.
 *
 * The author disclaims copyright to this source code.  In place of
 * a legal notice, here is a blessing:
 *
 *  May you do good and not evil.
 *  May you find forgiveness for yourself and forgive others.
 *  May you share freely, never taking more than you give.
 */

helper::import(dirname(dirname(__FILE__)) . '/base/pager/pager.class.php');
/**
 * pager类.
 * Pager class.
 *
 * @package framework
 */
class pager extends basePager
{
    /**
     * 创建每页显示记录数的select标签。
     * Create the select object of record perpage.
     *
     * @access public
     * @return string
     */
    public function createRecPerPageJS()
    {
        /*
         * 替换recTotal, recPerPage, pageID为特殊的字符串，然后用js代码替换掉。
         * Replace the recTotal, recPerPage, pageID to special string, and then replace them with values by JS.
         **/
        $params = $this->params;
        foreach($params as $key => $value)
        {
            if(strtolower($key) == 'rectotal')   $params[$key] = '_recTotal_';
            if(strtolower($key) == 'recperpage') $params[$key] = '_recPerPage_';
            if(strtolower($key) == 'pageid')     $params[$key] = '_pageID_';
        }
        $vars = '';
        foreach($params as $key => $value) $vars .= "$key=$value&";
        $vars = rtrim($vars, '&');

        $js  = <<<EOT
        <script language='Javascript'>
        vars = '$vars';
        pageCookie = '$this->pageCookie';
        function submitPage(mode, perPage)
        {
            pageTotal  = parseInt(document.getElementById('_pageTotal').value);
            pageID     = document.getElementById('_pageID').value;
            recPerPage = document.getElementById('_recPerPage').getAttribute('data-value');
            recTotal   = document.getElementById('_recTotal').value;
            if(mode == 'changePageID')
            {
                if(pageID > pageTotal) pageID = pageTotal;
                if(pageID < 1) pageID = 1;
            }
            else if(mode == 'changeRecPerPage')
            {
                recPerPage = perPage;
                pageID = 1;
            }
            $.cookie(pageCookie, recPerPage, {expires:config.cookieLife, path:config.cookiePath});

            vars = vars.replace('_recTotal_', recTotal)
            vars = vars.replace('_recPerPage_', recPerPage)
            vars = vars.replace('_pageID_', pageID);
            location.href=createLink('$this->moduleName', '$this->methodName', vars);
        }
        </script>
EOT;
        return $js;
    }

    /**
     * 创建下拉刷新插件代码。
     * Create 'pull-up-load-more' component js code.
     *
     * @param string $listEle       list element selector 列表元素选择器
     * @param string $hintText      hint text 下拉提示文本
     * @param string $pageUrlFormat page url template 页码链接模版，例如 /message-comment-article-$ID.html
     * @param bool   $showPageTag   if set to true, then show a pager tag element and fixed on page bottom 如果设置为 true，则在页面底部固定显示当前页面信息标签
     * @access public
     * @return string
     */
    public function createPullUpJS($listEle, $hintText = '', $pageUrlFormat = '', $showPageTag = true)
    {
        if(!$pageUrlFormat) $pageUrlFormat = $this->createUrl('$ID');
        $hintDiv     = $this->pageID < $this->pageTotal ? "<div class='pager-pull-up-hint'><i class='icon-spinner-indicator icon icon-spin'></i><span>$hintText</span></div>" : '';
        $pageTagHtml = '';
        if($showPageTag)
        {
            $pageTagHtml = <<<EOT
            <div class="pager-pull-up-fixed">
                <div class='pager-pull-up-label'>
                    <span class='pager-pull-up-pageID'>$this->pageID</span>&#47;<span class='pager-pull-up-pageTotal'>$this->pageTotal</span>
                </div>
            </div>
EOT;
        }
        $js = <<<EOT
        <div class='pager-pull-up' data-url='$pageUrlFormat' data-pageID='$this->pageID' data-pageTotal='$this->pageTotal' data-list='$listEle'>
            $hintDiv
            $pageTagHtml
        </div>
EOT;
        return $js;
    }
}
