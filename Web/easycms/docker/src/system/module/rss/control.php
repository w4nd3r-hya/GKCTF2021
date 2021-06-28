<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of article module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class rss extends control
{
    /**
     * Output the rss.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->loadModel('tree');
        $this->loadModel('article');

        $articles = $this->dao->select('*')->from(TABLE_ARTICLE)
            ->where('addedDate')->le(helper::now())
            ->andWhere('status')->eq('normal')
            ->orderBy('addedDate_desc')
            ->limit(50)
            ->fetchAll();

        $articles = $this->rss->processArticles($articles);
        $latestArticle = current((array)$articles);

        $products = $this->loadModel('product')->getLatest(0, 20, $image = false);
        $products = $this->rss->processProducts($products);
        $latestProduct = current((array)$products);

        $this->view->products = $products;

        $this->view->title    = $this->config->site->name;
        $this->view->desc     = $this->config->site->desc;
        $this->view->siteLink = commonModel::getSysURL();

        $this->view->articles = $articles;

        $this->view->lastDate = date('Y-m-d H:i:s');
        if($latestArticle) $this->view->lastDate = $latestArticle->addedDate;
        if($latestProduct and $latestProduct->addedDate > $latestArticle->addedDate)
        {
            $this->view->lastDate = $latestProduct->addedDate;
        }
        echo '<?xml version="1.0" encoding="UTF-8" ?>';
        if($this->app->clientDevice == 'mobile') echo '<?xml-stylesheet type="text/css" href="' . $this->config->webRoot . 'theme/mobile/common/css/rss.css" ?>';
        $this->display();
    }
}
