ALTER TABLE `eps_file` CHANGE `size` `size` int(10) UNSIGNED NOT NULL;
ALTER TABLE `eps_blacklist` ADD `addedDate` datetime NOT NULL AFTER `expiredDate`;
ALTER TABLE `eps_blacklist` ADD index `addedDate` (`addedDate`);
ALTER TABLE `eps_block` ADD effectID mediumint(8) UNSIGNED NOT NULL default 0;
