ALTER TABLE `eps_message` CHANGE account account char(30) NOT NULL;
ALTER TABLE `eps_file`       ADD index `extension` (`extension`);
ALTER TABLE `eps_book`       ADD index `type` (`type`);
ALTER TABLE `eps_address`    ADD index `lang` (`lang`);
ALTER TABLE `eps_cart`       ADD index `lang` (`lang`);
ALTER TABLE `eps_order`      ADD index `lang` (`lang`);
ALTER TABLE `eps_oauth`      ADD index `lang` (`lang`);
ALTER TABLE `eps_usergroup`  ADD index `lang` (`lang`);
ALTER TABLE `eps_group`      ADD index `lang` (`lang`);
ALTER TABLE `eps_relation`   ADD index `lang` (`lang`);
ALTER TABLE `eps_statregion` ADD index `lang` (`lang`);
ALTER TABLE `eps_score`      ADD index `lang` (`lang`);
ALTER TABLE `eps_log`        ADD index `lang` (`lang`);
ALTER TABLE `eps_blacklist`  ADD index `lang` (`lang`);
ALTER TABLE `eps_layout` ADD object char(30) NOT NULL AFTER `region`;
ALTER TABLE `eps_layout` DROP INDEX `layout`, ADD UNIQUE `layout` (`template`, `plan`, `page`, `region`, `object`, `lang`);
ALTER TABLE `eps_order` CHANGE express express char(30) NOT NULL AFTER waybill;
ALTER TABLE `eps_message` ADD `mobile` char(11) NOT NULL AFTER `phone`;
ALTER TABLE `eps_article` ADD `onlyBody` enum('0', '1') NOT NULL DEFAULT '0' AFTER `js`;
-- DROP TABLE IF EXISTS `eps_widget`;
CREATE TABLE `eps_widget` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `account` char(30) NOT NULL,
  `type`    char(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `params` text NOT NULL,
  `order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `grid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `lang` char(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`),
  UNIQUE KEY `accountAppOrder` (`account`, `order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
