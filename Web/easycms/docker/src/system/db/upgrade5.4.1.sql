ALTER TABLE `eps_order` add `humanID` char(13) NOT NULL after id;
ALTER TABLE `eps_order` ADD `balance`  decimal(10,2) unsigned  NOT NULL DEFAULT 0.00 AFTER `amount`;
ALTER TABLE `eps_order` ADD `last` datetime NOT NULL AFTER `status`;
