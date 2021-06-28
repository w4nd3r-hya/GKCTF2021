DELETE  from `eps_config` where owner='system' and module = 'common' and section = 'template' and `key` = 'parser';
REPLACE into `eps_config` set owner='system', module = 'common', section = 'template', `key` = 'parser', value = 'raintpl', lang = 'zh-cn';
REPLACE into `eps_config` set owner='system', module = 'common', section = 'template', `key` = 'parser', value = 'raintpl', lang = 'zh-tw';
REPLACE into `eps_config` set owner='system', module = 'common', section = 'template', `key` = 'parser', value = 'raintpl', lang = 'en';
