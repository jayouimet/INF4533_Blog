CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_post` int NOT NULL,
  `post_id` int NOT NULL,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT NOW(),
  `updated_at` datetime NOT NULL DEFAULT NOW() ON UPDATE NOW(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`, `post_id`) REFERENCES users(`id`),
) ENGINE=MyISAM DEFAULT CHARSET=latin1;