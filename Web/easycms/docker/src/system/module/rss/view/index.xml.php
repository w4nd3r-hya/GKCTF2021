<?php if(!defined("RUN_MODE")) die();?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0">
<channel>
  <title><?php echo $title;?></title>
  <link><?php echo $siteLink;?></link>
  <description><?php echo $desc;?></description>
  <copyright><?php echo $config->company->name . $config->site->copyright . '-' . date('Y');?></copyright>
  <lastBuildDate><?php echo $lastDate;?></lastBuildDate>
  
  <?php foreach($articles as $article): ?>
  <item>
    <title><?php echo $article->title?></title>
    <description><![CDATA[  <?php echo $article->content;?>]]></description>
    <link><?php echo str_replace('&', '&amp;', $article->url);?></link>
    <category><?php echo $article->categoryName; ?></category>
    <pubDate><?php echo $article->addedDate . ' +0800';?></pubDate>
  </item>
  <?php endforeach;?>
</channel>
</rss>
