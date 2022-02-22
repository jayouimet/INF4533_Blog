CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `post_id` int,
  `comment_id` int,
  `created_at` datetime NOT NULL DEFAULT NOW(),
  `updated_at` datetime NOT NULL DEFAULT NOW() ON UPDATE NOW(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES  users(`id`),
  FOREIGN KEY (`post_id`) REFERENCES  posts(`id`),
  FOREIGN KEY (`comment_id`) REFERENCES  comments(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;