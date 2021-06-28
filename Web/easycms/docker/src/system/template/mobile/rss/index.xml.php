<rss version="2.0">
<channel>
  <title>{$title}</title>
  <link>{$siteLink}</link>
  <description>{$desc}</description>
  <copyright>{!echo $config->company->name . $config->site->copyright . '-' . date('Y')}</copyright>
  <lastBuildDate>{$lastDate}</lastBuildDate>
  
  {foreach($articles as $article)}
    <item>
      <title>{$article->title}</title>
      <description><![CDATA[  {$article->content}]]></description>
      <link>{!str_replace('&', '&amp;', $article->url)}</link>
      <category>{$article->categoryName}</category>
      <pubDate>{!echo $article->addedDate . ' +0800'}</pubDate>
    </item>
  {/foreach}

  {foreach($products as $product)}
    <item>
      <title>{$product->name}</title>
      <description><![CDATA[  {$product->content}]]></description>
      <link>{!str_replace('&', '&amp;', $product->url)}</link>
      <category>{$product->category->name}</category>
      <pubDate>{!echo $product->addedDate . ' +0800'}</pubDate>
    </item>
  {/foreach}

</channel>
</rss>
