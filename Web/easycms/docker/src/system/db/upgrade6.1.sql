ALTER TABLE `eps_book` ADD `link` varchar(255) NOT NULL AFTER `order`,
ADD `articleID` smallint(5) unsigned not null default 0 AFTER `id`,
ADD `status` varchar(20) NOT NULL DEFAULT 'normal' AFTER `editedDate`;

ALTER TABLE `eps_wx_public` ADD `remindUsers` text NOT NULL AFTER `addedDate`;
