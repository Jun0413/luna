use DB_NAME;

CREATE TABLE `cinema` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `address` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `phone` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
);

CREATE TABLE `hall` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `is_imax` tinyint(1) NOT NULL,
  `is_dolby` tinyint(1) NOT NULL,
  `type` enum('A','B') NOT NULL,
  `cinema_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cinema_id` (`cinema_id`),
  CONSTRAINT `hall_ibfk_1` FOREIGN KEY (`cinema_id`) REFERENCES `cinema` (`id`)
);

CREATE TABLE `movie` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `genre` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `region` varchar(256) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `rating` enum('G','PG','PG-13','R','NC-17') NOT NULL,
  `overview` text CHARACTER SET utf8 NOT NULL,
  `director` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `length` int(11) NOT NULL,
  `cast` varchar(256) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `is_showing` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
);











CREATE TABLE `showtime` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hall_id` int(11) unsigned NOT NULL,
  `movie_id` int(11) unsigned NOT NULL,
  `day` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `hall_id` (`hall_id`),
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `hall_id` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id`),
  CONSTRAINT `movie_id` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`)
);

CREATE TABLE `transaction` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `email` varchar(256) NOT NULL,
  `combo_a` int(11) DEFAULT '0',
  `combo_b` int(11) DEFAULT '0',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
);

CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `email` varchar(256) NOT NULL,
  `password` varchar(256) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
);

CREATE TABLE `booking` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `showtime_id` int(11) unsigned NOT NULL,
  `transaction_id` int(11) unsigned NOT NULL,
  `seat` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `showtime_id` (`showtime_id`),
  KEY `transaction_id` (`transaction_id`),
  CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`showtime_id`) REFERENCES `showtime` (`id`),
  CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`id`)
);
