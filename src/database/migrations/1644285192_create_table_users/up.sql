CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `firstname` text,
  `lastname` text,
  `email` varchar(255) NOT NULL,
  `confirmation_code` text,
  `is_active` boolean NOT NULL DEFAULT 0,
  `date_of_birth` date NOT NULL,
  `password` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT NOW(),
  `updated_at` datetime NOT NULL DEFAULT NOW() ON UPDATE NOW(),
  `profile_picture` text,
  `status_message` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY unique_email(email(255))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `email`, `confirmation_code`, `is_active`, `date_of_birth`, `password`, `created_at`, `updated_at`, `profile_picture`, `status_message`) VALUES
(1, 'jayouimet', 'jay', 'sama', 'jay@sama.jp', NULL, 0, '2022-02-02', '$2y$10$KcAIBFt82tq87VMUVfvel.ujvkx/4R//xxC8Zb75W31n9MpFJBVTm', '2022-02-25 23:05:53', '2022-02-25 23:05:53', NULL, NULL),
(2, 'darkxys', 'francis', 'hotbread', 'frank@toast.com', NULL, 0, '2022-02-07', '$2y$10$24KwL9Z7acEzns1HS/hXDOewXL4.Ic3WcWO4hjK8pDyxJkgWt6rS.', '2022-02-25 23:12:08', '2022-02-25 23:12:08', NULL, NULL);
COMMIT;