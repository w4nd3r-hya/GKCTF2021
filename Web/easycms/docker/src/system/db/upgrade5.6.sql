UPDATE `eps_article`    SET `type` = 'submission' WHERE `type` = 'submittion';
UPDATE `eps_config`     SET `value` = replace(value, 'submittion', 'submission') WHERE `key` = 'modules';
UPDATE `eps_config`     SET `value` = replace(value, 'submittion', 'submission') WHERE `key` = 'home';
UPDATE `eps_file`       SET `objectType` = 'submission' WHERE `objectType` = 'submittion';
UPDATE `eps_score`      SET `method` = 'approvesubmission' WHERE `method` = 'approvesubmittion';
UPDATE `eps_score`      SET `method` = 'approvesubmission' WHERE `method` = 'approveSubmittion';
UPDATE `eps_statlog`    SET `url` = replace(url, 'submittion', 'submission');
UPDATE `eps_statreport` SET `item` = replace(item, 'submittion', 'submission');
UPDATE `eps_widget`     SET `type` = 'submission' WHERE `type` = 'submittion';
