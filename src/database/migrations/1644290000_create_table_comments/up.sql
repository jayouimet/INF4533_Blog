CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT NOW(),
  `updated_at` datetime NOT NULL DEFAULT NOW() ON UPDATE NOW(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`),
  FOREIGN KEY (`post_id`) REFERENCES posts(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `body`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'premier comments', '2022-02-25 23:14:34', '2022-02-25 23:14:34'),
(2, 2, 1, 'deuxieme jk12uijk123hbyujk12hb3yj1yh comments', '2022-02-25 23:14:46', '2022-02-25 23:14:46'),
(3, 1, 1, 'premier comments jay', '2022-02-25 23:16:28', '2022-02-25 23:16:28'),
(4, 1, 1, 'bo bonhomme mr toast', '2022-02-25 23:16:37', '2022-02-25 23:16:37'),
(5, 1, 2, ':)))))))))))))))))))', '2022-02-25 23:17:22', '2022-02-25 23:17:22'),
(6, 2, 2, 'bo smile jay-sama', '2022-02-25 23:17:46', '2022-02-25 23:17:46'),
(7, 2, 2, ';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;)', '2022-02-25 23:17:51', '2022-02-25 23:17:51');
