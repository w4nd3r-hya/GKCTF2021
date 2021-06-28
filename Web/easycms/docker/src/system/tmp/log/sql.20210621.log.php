<?php
 die();
?>
20210621 20:36:19: /error/chan/chanzhieps/www/install.php

20210621 20:36:21: /error/chan/chanzhieps/www/install.php?m=install&f=step0

20210621 20:36:22: /error/chan/chanzhieps/www/install.php?m=install&f=step1

20210621 20:36:23: /error/chan/chanzhieps/www/install.php?m=install&f=step2

20210621 20:47:55: /chan7/www/install.php

20210621 20:47:57: /chan7/www/install.php?m=install&f=step0

20210621 20:47:59: /chan7/www/install.php?m=install&f=step1

20210621 20:48:00: /chan7/www/install.php?m=install&f=step2

20210621 20:48:26: /chan7/www/install.php?m=install&f=step3

20210621 20:48:26: /chan7/www/install.php?m=install&f=step4

20210621 20:48:31: /chan7/www/install.php?m=install&f=step4
  INSERT INTO eps_user SET `account` = 'admin',`realname` = 'admin',`password` = '77fada96dff3ec453737264e3dc5fe9e',`admin` = 'super',`join` = '2021-06-21 20:48:31',`lang` = 'zh-cn'
  REPLACE eps_config SET `owner` = 'system',`module` = 'common',`section` = 'global',`key` = 'version',`value` = '7.7',`lang` = 'all'

20210621 20:48:31: /chan7/www/install.php?m=install&f=step5
  REPLACE eps_config SET `owner` = 'system',`module` = 'common',`section` = 'site',`key` = 'lang',`value` = 'zh-cn',`lang` = 'all'

20210621 20:48:32: /chan7/www/admin.php?m=widget&f=printWidget&widget=1
  SELECT * FROM eps_config WHERE owner IN ('system','admin')  AND  eps_config.lang in('zh-cn', 'all')  ORDER BY `id` 
  SELECT *, id as category FROM eps_category WHERE type IN ('article','video','product','blog','forum','usercase') AND  eps_category.lang in('zh-cn', 'all') 
  SELECT * FROM eps_widget WHERE id  = '1' AND  eps_widget.lang in('zh-cn', 'all') 
  UPDATE eps_order SET  `deliveryStatus` = 'confirmed', `last` = '2021-06-21 20:48:32' WHERE deliveryStatus  = 'send' AND  deliveriedDate  <= '2021-06-14 20:48:32' AND  status  != 'finished' AND  eps_order.lang in('zh-cn', 'all') 
  UPDATE eps_order SET  `status` = 'expired', `last` = '2021-06-21 20:48:32' WHERE payStatus  = 'not_paid' AND  status  != 'deleted' AND  status  != 'expired' AND  createdDate  <= '2021-05-22 20:48:32' AND  eps_order.lang in('zh-cn', 'all') 
  SELECT * FROM eps_order WHERE 1  AND  status  != 'deleted'  AND  eps_order.lang in('zh-cn', 'all')  ORDER BY `id` desc 
  SELECT COUNT(*) AS recTotal FROM eps_order WHERE 1  AND  status  != 'deleted'  AND  eps_order.lang in('zh-cn', 'all')  
  SELECT * FROM eps_order WHERE 1  AND  status  != 'deleted'  AND  eps_order.lang in('zh-cn', 'all')  ORDER BY `id` desc 
  SELECT * FROM eps_order_product WHERE orderID IN ('2','1') AND  eps_order_product.lang in('zh-cn', 'all') 
  SELECT * FROM eps_file WHERE objectType  = 'product' AND  objectID IN ('2') AND  extension IN ('jpeg','jpg','gif','png','bmp') ORDER BY `order`,`editor` desc 
  SELECT * FROM eps_file WHERE objectType  = 'product' AND  objectID IN ('2') AND  extension IN ('jpeg','jpg','gif','png','bmp') ORDER BY `order`,`editor` desc 
  REPLACE eps_config SET `owner` = 'system',`module` = 'common',`section` = 'site',`key` = 'updatedTime',`value` = '1624279712',`lang` = 'all'

20210621 20:48:32: /chan7/www/admin.php?m=widget&f=printWidget&widget=2
  SELECT * FROM eps_config WHERE owner IN ('system','admin')  AND  eps_config.lang in('zh-cn', 'all')  ORDER BY `id` 
  SELECT *, id as category FROM eps_category WHERE type IN ('article','video','product','blog','forum','usercase') AND  eps_category.lang in('zh-cn', 'all') 
  SELECT * FROM eps_widget WHERE id  = '2' AND  eps_widget.lang in('zh-cn', 'all') 
  SELECT * FROM eps_thread WHERE 1   AND  eps_thread.lang in('zh-cn', 'all')  ORDER BY `id` desc  LIMIT 10 
  SELECT account, realnames, realname FROM eps_user WHERE account IN ('demo','','')
  SELECT * FROM eps_file WHERE objectType  = 'thread' AND  objectID IN ('1') AND  extension IN ('jpeg','jpg','gif','png','bmp') ORDER BY `order`,`editor` desc 
  SELECT account, realname, realnames FROM eps_user ORDER BY `id` asc 

20210621 20:48:32: /chan7/www/admin.php?m=widget&f=printWidget&widget=3
  SELECT * FROM eps_config WHERE owner IN ('system','admin')  AND  eps_config.lang in('zh-cn', 'all')  ORDER BY `id` 
  SELECT *, id as category FROM eps_category WHERE type IN ('article','video','product','blog','forum','usercase') AND  eps_category.lang in('zh-cn', 'all') 
  SELECT * FROM eps_widget WHERE id  = '3' AND  eps_widget.lang in('zh-cn', 'all') 
  SELECT account FROM eps_user WHERE admin  != 'no'
  SELECT * FROM eps_message WHERE status  = '0' AND  type IN ('comment','message','reply') AND  account  NOT IN ('admin','demo')  AND  eps_message.lang in('zh-cn', 'all')  ORDER BY `date` desc  LIMIT 10 
  SELECT id, title FROM eps_article WHERE id IN ('') AND  eps_article.lang in('zh-cn', 'all') 
  SELECT id, name FROM eps_product WHERE id IN ('') AND  eps_product.lang in('zh-cn', 'all') 
  SELECT id, title FROM eps_book WHERE id IN ('') AND  eps_book.lang in('zh-cn', 'all') 
  SELECT id, `from` FROM eps_message WHERE id IN ('') AND  eps_message.lang in('zh-cn', 'all') 
  SELECT id, `from` FROM eps_message WHERE id IN ('') AND  eps_message.lang in('zh-cn', 'all') 

20210621 20:48:32: /chan7/www/admin.php?m=widget&f=printWidget&widget=5
  SELECT * FROM eps_config WHERE owner IN ('system','admin')  AND  eps_config.lang in('zh-cn', 'all')  ORDER BY `id` 
  SELECT *, id as category FROM eps_category WHERE type IN ('article','video','product','blog','forum','usercase') AND  eps_category.lang in('zh-cn', 'all') 
  SELECT * FROM eps_widget WHERE id  = '5' AND  eps_widget.lang in('zh-cn', 'all') 
  SELECT * FROM eps_category WHERE type  = 'article'  AND  eps_category.lang in('zh-cn', 'all')  ORDER BY `grade` desc,`order` 

