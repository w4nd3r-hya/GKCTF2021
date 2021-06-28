UPDATE `eps_config` set `lang` = 'tmp' where owner = 'system' and module = 'common' and section = 'site' and `key` = 'requesttype' and lang = 'all';
UPDATE `eps_config` set `lang` = 'all' where owner = 'system' and module = 'common' and section = 'site' and `key` = 'requesttype' limit 1;
DELETE from `eps_config` where owner = 'system' and module = 'common' and section = 'site' and `key` = 'requesttype' and lang != 'all';
