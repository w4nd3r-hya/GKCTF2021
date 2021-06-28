<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of rss module of ChanzhiEPS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     rss
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class rssModel extends model
{
    /**
     * Process articles for rss.
     * 
     * @param  array    $articles 
     * @access public
     * @return array
     */
    public function processArticles($articles)
    {
        $webRoot = commonModel::getSysURL() . $this->config->webRoot;
        foreach($articles as $article)
        {
            $idList[] = $article->id;

            $article->content = str_replace("src=\"{$this->config->webRoot}data/", "src=\"{$webRoot}data/", $article->content);
            $article->content = str_replace("src='{$this->config->webRoot}data/", "src='{$webRoot}data/", $article->content);

            $article->content = str_replace("href=\"{$this->config->webRoot}data/", "href=\"{$webRoot}data/", $article->content);
            $article->content = str_replace("href='{$this->config->webRoot}data/", "href='{$webRoot}data/", $article->content);

            $article->content = str_replace("src=\"{$this->config->webRoot}file.php", "src=\"{$webRoot}file.php", $article->content);
            $article->content = str_replace("src='{$this->config->webRoot}file.php", "src='{$webRoot}file.php", $article->content);

            $article->content = str_replace("href=\"{$this->config->webRoot}file.php", "href=\"{$webRoot}file.php", $article->content);
            $article->content = str_replace("href='{$this->config->webRoot}file.php", "href='{$webRoot}file.php", $article->content);
        }

        $categories = $this->dao->select('id,category')->from(TABLE_RELATION)->where('id')->in($idList)->andWhere('type')->in('article,page,blog')->fetchPairs('id', 'category');
        $categoryIdList = array_values($categories);
        $categoryMenus  = $this->dao->select('id,name')->from(TABLE_CATEGORY)->where('id')->in($categoryIdList)->fetchPairs('id', 'name');

        foreach($articles as $article)
        {
            $article->category = zget($categories, $article->id);
            $article->url      = rtrim($webRoot, '/') . $this->loadModel('article')->createPreviewLink($article->id);
            $article->categoryName = zget($categoryMenus, $article->category);
        }
        return $articles;
    }

    /**
     * Process products for rss.
     * 
     * @param  array    $products 
     * @access public
     * @return array
     */
    public function processProducts($products)
    {
        $webRoot = commonModel::getSysURL() . $this->config->webRoot;
        foreach($products as $product)
        {
            $product->content = str_replace("src=\"{$this->config->webRoot}data/", "src=\"{$webRoot}data/", $product->content);
            $product->content = str_replace("src='{$this->config->webRoot}data/", "src='{$webRoot}data/", $product->content);

            $product->content = str_replace("href=\"{$this->config->webRoot}data/", "href=\"{$webRoot}data/", $product->content);
            $product->content = str_replace("href='{$this->config->webRoot}data/", "href='{$webRoot}data/", $product->content);

            $product->content = str_replace("src=\"{$this->config->webRoot}file.php", "src=\"{$webRoot}file.php", $product->content);
            $product->content = str_replace("src='{$this->config->webRoot}file.php", "src='{$webRoot}file.php", $product->content);

            $product->content = str_replace("href=\"{$this->config->webRoot}file.php", "href=\"{$webRoot}file.php", $product->content);
            $product->content = str_replace("href='{$this->config->webRoot}file.php", "href='{$webRoot}file.php", $product->content);

            $product->url = rtrim($webRoot, '/') . $this->loadModel('product')->createPreviewLink($product->id);
            $product->category = current($product->categories);

        }
        return $products;
    }
}
