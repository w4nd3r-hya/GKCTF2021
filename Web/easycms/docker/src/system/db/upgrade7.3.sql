CREATE TABLE `eps_bearlog` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  `objectType` varchar(30) NOT NULL,
  `objectID` mediumint(9) NOT NULL,
  `url` varchar(255) NOT NULL,
  `account` varchar(30) NOT NULL,
  `status` char(30) NOT NULL,
  `response` text NOT NULL,
  `time` datetime NOT NULL,
  `auto` enum('yes','no') NOT NULL,
  `lang` char(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  KEY `lang` (`lang`),
  KEY `objectType` (`objectType`),
  KEY `objectID` (`objectID`),
  KEY `time` (`time`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
ALTER TABLE `eps_article`
CHANGE `views` `views` int(11) unsigned NOT NULL DEFAULT '0' AFTER `submission`,
COMMENT='';
ALTER TABLE `eps_book`
CHANGE `views` `views` int(11) unsigned NOT NULL DEFAULT '0' AFTER `status`,
COMMENT='';
ALTER TABLE `eps_product`
CHANGE `views` `views` int(11) unsigned NOT NULL DEFAULT '0' AFTER `status`,
COMMENT='';
ALTER TABLE `eps_thread`
CHANGE `views` `views` int(11) unsigned NOT NULL DEFAULT '0' AFTER `readonly`,
COMMENT='';
