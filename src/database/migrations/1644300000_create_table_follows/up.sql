CREATE TABLE IF NOT EXISTS `follows` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `user_followed_id` int NOT NULL,
    `created_at` datetime NOT NULL DEFAULT NOW(),
    `updated_at` datetime NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES  users(`id`),
    FOREIGN KEY (`user_followed_id`) REFERENCES  users(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;