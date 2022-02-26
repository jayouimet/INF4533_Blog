CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` text NOT NULL,
  `body` text,
  `created_at` datetime NOT NULL DEFAULT NOW(),
  `updated_at` datetime NOT NULL DEFAULT NOW() ON UPDATE NOW(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES  users(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `posts` (`id`, `user_id`, `title`, `body`, `created_at`, `updated_at`) VALUES
(1, 2, 'test post#1', 'woa post #1', '2022-02-25 23:14:21', '2022-02-25 23:14:21'),
(2, 1, 'jay&#39;s post', 'eh ben un post pour moi aussi', '2022-02-25 23:17:16', '2022-02-25 23:17:16');
