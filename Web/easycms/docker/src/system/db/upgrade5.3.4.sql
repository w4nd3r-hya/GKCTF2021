ALTER TABLE `eps_order` change status status enum('normal','canceled','finished','deleted','expired') NOT NULL DEFAULT 'normal';
