ALTER TABLE `eps_action` ADD key(`objectType`);

ALTER TABLE `eps_article` ADD key(`type`);
ALTER TABLE `eps_article` ADD key(`order`);
ALTER TABLE `eps_article` ADD key(`status`);
ALTER TABLE `eps_article` ADD key(`ADDedDate`);

ALTER TABLE `eps_slide` ADD key(`group`);

ALTER TABLE `eps_block` ADD key(`type`);
ALTER TABLE `eps_block` ADD key(`template`);

ALTER TABLE `eps_book` ADD key(`status`);
ALTER TABLE `eps_book` ADD key(`ADDedDate`);

ALTER TABLE `eps_category` ADD key(`grade`);

ALTER TABLE `eps_package` ADD key(`type`);

ALTER TABLE `eps_file` ADD key(`pathname`);

ALTER TABLE `eps_message` ADD key(`type`);
ALTER TABLE `eps_message` ADD key(`to`);
ALTER TABLE `eps_message` ADD key(`account`);
ALTER TABLE `eps_message` ADD key(`readed`);

ALTER TABLE `eps_product` ADD key(`status`);

ALTER TABLE `eps_relation` ADD key(`id`);
ALTER TABLE `eps_relation` ADD key(`category`);

ALTER TABLE `eps_reply` ADD key(`reply`);
ALTER TABLE `eps_reply` ADD key(`hidden`);
ALTER TABLE `eps_reply` ADD key(`editedDate`);

ALTER TABLE `eps_thread` ADD key(`hidden`);
ALTER TABLE `eps_thread` ADD key(`status`);
ALTER TABLE `eps_thread` ADD key(`ADDedDate`);

ALTER TABLE `eps_user` ADD key(`score`);
ALTER TABLE `eps_user` ADD key(`rank`);

ALTER TABLE `eps_log` ADD key(`ip`);
ALTER TABLE `eps_log` ADD key(`type`);
ALTER TABLE `eps_log` ADD key(`account`);
ALTER TABLE `eps_log` ADD key(`date`);

ALTER TABLE `eps_wx_message` ADD key(`type`);
ALTER TABLE `eps_wx_message` ADD key(`public`);
ALTER TABLE `eps_wx_message` ADD key(`from`);
ALTER TABLE `eps_wx_message` ADD key(`to`);
ALTER TABLE `eps_wx_message` ADD key(`replied`);

ALTER TABLE `eps_score` ADD key(`time`);
ALTER TABLE `eps_score` ADD key(`type`);

ALTER TABLE `eps_order` ADD key(`deliveryStatus`);
ALTER TABLE `eps_order` ADD key(`payStatus`);
ALTER TABLE `eps_order` ADD key(`type`);

ALTER TABLE `eps_cart` ADD key(`product`);

ALTER TABLE `eps_widget` ADD key(`hidden`);
