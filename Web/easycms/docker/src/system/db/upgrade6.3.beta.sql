ALTER TABLE `eps_product` ADD `negotiate` enum('0','1') NOT NULL DEFAULT '0' AFTER `price`;
ALTER TABLE `eps_statreferer` DROP INDEX `url`, ADD UNIQUE `url` (`url`(255));
