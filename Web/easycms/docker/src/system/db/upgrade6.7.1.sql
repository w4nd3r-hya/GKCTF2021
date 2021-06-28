ALTER TABLE `eps_article`
ADD `stickTime` datetime NOT NULL AFTER `sticky`,
ADD `stickBold` enum('0', '1') NOT NULL DEFAULT '0' AFTER `stickTime`;

ALTER TABLE `eps_thread`
ADD `stickTime` datetime NOT NULL AFTER `stick`,
ADD `stickBold` enum('0', '1') NOT NULL DEFAULT '0' AFTER `stickTime`;

ALTER TABLE `eps_statlog` 
ADD  KEY `month_lang` (`month`,`lang`),
ADD  KEY `day_lang` (`day`,`lang`),
ADD  KEY `hour_lang` (`hour`,`lang`),
ADD  KEY `osName` (`osName`),
ADD  KEY `browserName` (`browserName`),
ADD  KEY `year` (`year`);
