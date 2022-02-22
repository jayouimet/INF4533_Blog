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
  `profile_picture` varchar(255),
  `status_message` varchar(255),
  PRIMARY KEY (`id`),
  UNIQUE KEY unique_email(email(255))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;