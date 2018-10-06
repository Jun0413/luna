# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.1.36-MariaDB)
# Database: luna
# Generation Time: 2018-10-04 12:12:49 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table booking
# ------------------------------------------------------------

DROP TABLE IF EXISTS `booking`;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table cinema
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cinema`;

CREATE TABLE `cinema` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `address` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `phone` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `cinema` WRITE;
/*!40000 ALTER TABLE `cinema` DISABLE KEYS */;

INSERT INTO `cinema` (`id`, `name`, `address`, `phone`)
VALUES
	(1,'Luna Clementi','3150 Commonwealth Avenue West','68129580'),
	(2,'Luna Bedok','315 New Upper Changi Road','68467347'),
	(3,'Luna Orchard','2 Orchard Turn','68238801'),
	(4,'Luna Bayfront','10 Bayfront Avenue','68018956');

/*!40000 ALTER TABLE `cinema` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hall
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hall`;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `hall` WRITE;
/*!40000 ALTER TABLE `hall` DISABLE KEYS */;

INSERT INTO `hall` (`id`, `name`, `is_imax`, `is_dolby`, `type`, `cinema_id`)
VALUES
	(1,'Hall 1',0,1,'A',1),
	(2,'Hall 2',0,0,'B',1),
	(3,'Hall 3',0,0,'B',1),
	(4,'Hall 1',0,0,'B',2),
	(5,'Hall 2',0,0,'B',2),
	(6,'Hall 3',0,0,'B',2),
	(7,'Hall 1',1,0,'A',3),
	(8,'Hall 2',0,0,'B',3),
	(9,'Hall 3',0,0,'B',3),
	(10,'Hall 1',1,1,'A',4),
	(11,'Hall 2',0,0,'B',4),
	(12,'Hall 3',0,0,'B',4);

/*!40000 ALTER TABLE `hall` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table movie
# ------------------------------------------------------------

DROP TABLE IF EXISTS `movie`;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `movie` WRITE;
/*!40000 ALTER TABLE `movie` DISABLE KEYS */;

INSERT INTO `movie` (`id`, `name`, `genre`, `region`, `rating`, `overview`, `director`, `length`, `cast`, `is_showing`)
VALUES
	(1,'First Man','Drama','USA','PG-13','On the heels of their six-time Academy Award®-winning smash, La La Land, Oscar®-winning director Damien Chazelle and star Ryan Gosling reteam for Universal Pictures? First Man, the riveting story of NASA?s mission to land a man on the moon, focusing on Neil Armstrong and the years 1961-1969. A visceral, first-person account, based on the book by James R. Hansen, the movie will explore the sacrifices and the cost?on Armstrong and on the nation?of one of the most dangerous missions in history. \n','Damien Chazelle',150,'Ryan Gosling, Claire Foy, Jason Clarke, Kyle Chandler',0),
	(2,'A Simple Favor','Comedy','USA','R','A SIMPLE FAVOR, directed by Paul Feig, centers around Stephanie (Anna Kendrick), a mommy vlogger who seeks to uncover the truth behind her best friend Emily\'s (Blake Lively) sudden disappearance from their small town. Stephanie is joined by Emily\'s husband Sean (Henry Golding) in this stylish thriller filled with twists and betrayals, secrets and revelations, love and loyalty, murder and revenge. ','Paul Feig',104,'Anna Kendrick, Blake Lively, Henry Golding ',1),
	(3,'Venom','Action','USA','PG-13','Journalist Eddie Brock is trying to take down Carlton Drake, the notorious and brilliant founder of the Life Foundation. While investigating one of Drake\'s experiments, Eddie\'s body merges with the alien Venom -- leaving him with superhuman strength and power. Twisted, dark and fueled by rage, Venom tries to control the new and dangerous abilities that Eddie finds so intoxicating.\n','Ruben Fleischer',112,'Tom Hardy, Michelle Williams, Marcella Bragio',1),
	(4,'Mission: Impossible - Fallout','Action','USA','PG-13','Ethan Hunt and the IMF team join forces with CIA assassin August Walker to prevent a disaster of epic proportions. Arms dealer John Lark and a group of terrorists known as the Apostles plan to use three plutonium cores for a simultaneous nuclear attack on the Vatican, Jerusalem and Mecca, Saudi Arabia. When the weapons go missing, Ethan and his crew find themselves in a desperate race against time to prevent them from falling into the wrong hands.','Christopher McQuarrie',147,'Tom Cruise, Henry Cavill, Ving Rhames',1),
	(5,'The Hows of Us','Romance','Philippines','PG-13','Story of couple Primo (Daniel Padilla) and George (Kathryn Bernardo) who are in a long-term relationship and are already building and planning their future together. Their love will be put to the test as their relationship faces hurdles - from misunderstandings to different career paths, among others. How will they save their \"us\"?','Cathy Garcia-Molina',117,'Kathryn Bernardo, Daniel Padilla, Darren Espanto |',1),
	(6,'Johnny English Strikes Again','Comedy','UK','PG','The new adventure begins when a cyber attack reveals the identities of all active undercover agents in Britain, leaving Johnny English as the secret service\'s last hope. Called out of retirement, English dives headfirst into action with the mission to find the mastermind hacker. As a man with few skills and analogue methods, Johnny English must overcome the challenges of modern technology to make this mission a success.','David Kerr',89,'Olga Kurylenko, Emma Thompson, Rowan Atkinson',1),
	(7,'Crazy Rich Asians','Comedy','Singapore','PG-13','Rachel Chu is happy to accompany her longtime boyfriend, Nick, to his best friend\'s wedding in Singapore. She\'s also surprised to learn that Nick\'s family is extremely wealthy and he\'s considered one of the country\'s most eligible bachelors. Thrust into the spotlight, Rachel must now contend with jealous socialites, quirky relatives and something far, far worse -- Nick\'s disapproving mother.','Jon M. Chu',121,'Constance Wu, Henry Golding, Michelle Yeoh',1),
	(8,'Smallfoot','Animation','USA','PG','An animated adventure for all ages, with original music and an all-star cast, ?Smallfoot? turns the Bigfoot legend upside down when a bright young Yeti finds something he thought didn?t exist?a human. News of this ?smallfoot? brings him fame and a chance with the girl of his dreams. It also throws the simple Yeti community into an uproar over what else might be out there in the big world beyond their snowy village, in a rollicking story about friendship, courage and the joy of discovery. ','\nKarey Kirkpatrick',97,'\nChanning Tatum, James Corden, Zendaya, Common',1),
	(9,'Fantastic Beasts: The Crimes Of Grindelwald','Adventure','UK','PG-13','In an effort to thwart Grindelwald\'s plans of raising pure-blood wizards up to rule over all non-magical beings, Albus Dumbledore enlists his former student Newt Scamander, who agrees to help, unaware of the dangers that lie ahead. Lines are drawn as love and loyalty are tested, even among the truest friends and family, in an increasingly divided wizarding world.','David Yates',116,'Eddie Redmayne, Katherine Waterston, Dan Fogler\n',0),
	(10,'Rampant','Action','South Korea','NC-17','Zombies are taking over the world! Neither dead nor alive, zombies are rampant in Joseon. With his home country on the verge of collapse, Prince Ganglim (HYUN Bin) returns to Joseon, only to be greeted with peasants who seem to be infected with a mysterious virus. He is forced to kill his own people alongside Baron Park (JO Woo-jin) and his men, and he unwillingly joins their crusade to eliminate all the zombies before they reach the royal palace. Meanwhile, Minister of War Kim Ja-joon (JANG Dong-gun) has his eyes set on the throne and uses his authority and influence to gather enough support to dethrone the king and uses the virus to create chaos in the palace? ','Sung-hoon Kim',129,'Hyun Bin, Jang Dong-Gun',0),
	(11,'Killing for the Prosecution','Mystery','Japan','NC-17','Mogami Takeshi works at the Tokyo prosecutor\'s office focusing on violent criminal cases. Okino Keiichiro admires him and is happy to be assigned to work with Mogami. When a money lender is killed for his dealings with the deceased one Matsukura Shigeo is considered a suspect. He has a past involving a schoolgirl and the prosecutors strive to make the case.','Masato Harada',123,'Takuya Kimura, Kazunari Ninomiya, Yuriko Yoshitaka |',1),
	(12,'Hello Mr Billionaire','Comedy','China','PG-13','The pathetic minor league Soccer goalkeeper Wang Duoyu (Shen Teng), just lost his job when he was told that he was the successor of his grandfather?s brother ? a billionaire. But to get the inheritance, he must succeeds in spending a Billion dollars in 30 days. Moreover, he?s not allowed to tell anyone about the task and he must not own any valuables by the end of it. Extraordinarily excited, Wang Duoyu agrees to the challenge without doubt. However, it is not easy as he thought it will be. ','Damo Peng',119,'Shen Teng, Song Yunhua',1),
	(13,'Miss Granny','Drama','Philippines','PG-13','Miss Granny tells the story of a woman in her 70s who realizes she is becoming a burden on her family when she magically finds herself back in the body of her 20-year-old self after having her picture taken at a mysterious photo studio.','Joyce Bernal',114,'Sarah Geronimo, Xian Lim, James Reid',1),
	(14,'The Predator','Action','USA','R','From the outer reaches of space to the small-town streets of suburbia, the hunt comes home in Shane Black\'s explosive reinvention of the Predator series. Now, the universe\'s most lethal hunters are stronger, smarter and deadlier than ever before, having genetically upgraded themselves with DNA from other species. When a young boy accidentally triggers their return to Earth, only a ragtag crew of ex-soldiers and a disgruntled science teacher can prevent the end of the human race. ','\nBoyd Holbrook, Trevante Rhode',107,'Boyd Holbrook, Trevante Rhodes, Jacob Tremblay, Keegan-Michael Key, Olivia Munn',0),
	(15,'16 levers de soleil ','Documentary','France','PG-13','On November 17, 2016, Thomas Pesquet flew for his first space mission. 450 kilometers away from the Flying for Space. It is this dream that Thomas Pesquet realized by taking off from the base of Baikonur. 450 kilometers from the Earth, during these six months when the world seems to be moving into the unknown, a dialogue is woven between the astronaut and the visionary work of Saint Exupéry that he took to the space station.','Pierre-Emmanuel Le Goff',117,'Oleg Novitsky, Thomas Pesquet, Peggy Whitson',0),
	(16,'Europe Raiders','Drama','Hong Kong','PG','Mr. Lin and Ms. Wang, two bounty hunters, have to find Hand of God. Sophie wanted Rocky released from prison. The rivalry between two bounty hunters intensifies as they both attempt to track down a destructive device known as the \"Hand of God.\"','Jingle Ma',101,'Tony Chiu-Wai Leung, Kris Wu, Ji-hyun Jun |',1),
	(17,'The Negotiation','Thriller','South Korea','PG-13','Ha Chae-Yoon (Son Ye-Jin) is a crisis negotiator for Seoul Metropolitan Police Agency. She faces off against Min Tae-Koo (Hyun-Bin) who has kidnapped his boss. ','Lee Jong-Suk',113,'Hyun Bin, Son Ye Jin',1),
	(18,'Cry Me A Sad River','Romance','China','G','The story spans across a decade, focusing on the love story between childhood friends Qi Ming and Yi Yao, and their eventual growth and separation. Childhood friends Qi Ming and Yi Yao realize their feelings for each other and, over the course of a decade, explore growth and separation.','Luo luo',105,'Zhao Yingbo, Ren Min, Xin Yunlai, Zhang Ruonan',1),
	(19,'Manou the Swift','Animation','German','G','The little swift Manou grows up believing he\'s a seagull. Learning to fly he finds out he never will be. Shocked, he runs away from home. He meets birds of his own species and finds out who he really is. When both seagulls and swifts face a dangerous threa','Christian Haas',88,'Kate Winslet, Willem Dafoe',0),
	(20,'Sui Dhaaga','Comedy','India','PG','A heart-warming story of pride and self-reliance, rooted in the heart of India. An unemployed small-town man defies all odds and naysayers and starts his own garment business.','Sharat Katariya',126,'Anushka Sharma, Varun Dhawan, Raghuvir Yadav',1),
	(21,'Killed by Rock and Roll','Crime','Taiwan','NC-17','What are the controlling relationships between humans and animals? Is human playing God as modern technology develops? Being a biologist at the lab at Academia Sinica in Taiwan, Tiffany Chang struggles to balance her personal life and bioethical conflicts. This documentary explores the rights of controlling the lives of humans and animals from researchers\' perspectives. It reveals a researcher\'s true identity inside and outside of work. In addition to that, the film reflects humans\' misunderstanding of issues due to their predisposed biases.','Tommy Yu',90,'Zaizai Lin, Sam Ta-cheng Yang, Yi-Chieh Lee |',1),
	(22,'Godzilla: Planet of the Monsters','Animation','Japan','G','Years into the future and the human race has been defeated several times by the new ruling force of the planet: \"kaijus\". And the ruler of that force is Godzilla, The King of the Monsters. Humanity is in such defeat, plans to leave the planet have been made, and several people have been chosen to look at a new planet to see if it is inhabitable. Realizing it\'s not, though, the human race resorts to plan B: to defeat Godzilla and take back their planet.','Hiroyuki Seshita',89,'Mamoru Miyano, Takahiro Sakurai, Kana Hanazawa',1),
	(23,'Thomas & Friends: Big World! Big Adventures!','Animation','UK','G','Thomas is inspired to embark on an ambitious trip around the world. Travelling full steam ahead across five continents, Thomas discovers magnificent new sights and cultures, making friends with an inspiring and fun Kenyan engine called Nia. With so much for Thomas to learn about the world, will Nia be successful in teaching him a lesson about the true meaning of friendship?','David Stoten',81,'Peter Andre, Teresa Gallagher, John Hasler',1),
	(24,'Beoning','Drama','Korea','R','Jong-su, a part-time worker, bumps into Hae-mi while delivering, who used to live in the same neighborhood. Hae-mi asks him to look after her cat while she\'s on a trip to Africa. When Hae-mi comes back, she introduces Ben, a mysterious guy she met in Africa, to Jong-su. One day, Ben visits Jong-su\'s with Hae-mi and confesses his own secret hobby.','Chang-dong Lee',148,'Ah-In Yoo, Steven Yeun, Jong-seo Jeon',0);

/*!40000 ALTER TABLE `movie` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table showtime
# ------------------------------------------------------------

DROP TABLE IF EXISTS `showtime`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `showtime` WRITE;
/*!40000 ALTER TABLE `showtime` DISABLE KEYS */;

INSERT INTO `showtime` (`id`, `hall_id`, `movie_id`, `day`, `start_time`, `price`)
VALUES
	(1,1,4,1,'09:00:00',0),
	(2,1,4,1,'15:00:00',0),
	(3,1,8,1,'21:00:00',0),
	(4,2,21,1,'09:00:00',0),
	(5,2,13,1,'12:00:00',0),
	(6,2,13,1,'15:00:00',0),
	(7,2,16,1,'21:00:00',0),
	(8,3,3,1,'12:00:00',0),
	(9,3,20,1,'18:00:00',0),
	(10,1,20,2,'09:00:00',0),
	(11,1,4,2,'12:00:00',0),
	(12,1,4,2,'18:00:00',0),
	(13,2,11,2,'15:00:00',0),
	(14,2,11,2,'18:00:00',0),
	(15,3,21,2,'12:00:00',0),
	(16,3,4,2,'15:00:00',0),
	(17,3,16,2,'21:00:00',0),
	(18,1,4,3,'12:00:00',0),
	(19,1,12,3,'15:00:00',0),
	(20,2,21,3,'12:00:00',0),
	(21,2,11,3,'15:00:00',0),
	(22,2,21,3,'21:00:00',0),
	(23,1,20,4,'09:00:00',0),
	(24,1,3,4,'12:00:00',0),
	(25,1,8,4,'18:00:00',0),
	(26,1,8,4,'21:00:00',0),
	(27,2,18,4,'09:00:00',0),
	(28,2,4,4,'15:00:00',0),
	(29,2,16,4,'21:00:00',0),
	(30,3,20,4,'12:00:00',0),
	(31,3,18,4,'15:00:00',0),
	(32,3,16,4,'18:00:00',0),
	(33,1,8,5,'09:00:00',0),
	(34,1,3,5,'12:00:00',0),
	(35,1,8,5,'18:00:00',0),
	(36,2,12,5,'09:00:00',0),
	(37,2,13,5,'18:00:00',0),
	(38,2,16,5,'21:00:00',0),
	(39,3,18,5,'12:00:00',0),
	(40,3,3,5,'15:00:00',0),
	(41,3,8,5,'21:00:00',0),
	(42,1,3,6,'09:00:00',0),
	(43,1,3,6,'12:00:00',0),
	(44,1,4,6,'15:00:00',0),
	(45,1,20,6,'18:00:00',0),
	(46,2,12,6,'12:00:00',0),
	(47,2,17,6,'18:00:00',0),
	(48,3,12,6,'09:00:00',0),
	(49,3,17,6,'15:00:00',0),
	(50,3,3,6,'21:00:00',0),
	(51,1,3,7,'09:00:00',0),
	(52,1,3,7,'12:00:00',0),
	(53,1,8,7,'21:00:00',0),
	(54,2,17,7,'12:00:00',0),
	(55,2,21,7,'21:00:00',0),
	(56,3,12,7,'15:00:00',0),
	(58,3,8,7,'18:00:00',0),
	(59,4,3,1,'09:00:00',0),
	(60,4,22,1,'12:00:00',0),
	(61,4,4,1,'21:00:00',0),
	(62,5,21,1,'09:00:00',0),
	(63,5,21,1,'12:00:00',0),
	(64,6,3,1,'15:00:00',0),
	(65,6,2,1,'18:00:00',0),
	(66,4,4,2,'09:00:00',0),
	(67,4,3,2,'15:00:00',0),
	(68,4,3,2,'18:00:00',0),
	(69,4,4,2,'21:00:00',0),
	(70,5,17,2,'09:00:00',0),
	(71,5,6,2,'12:00:00',0),
	(72,5,16,2,'21:00:00',0),
	(73,6,3,2,'12:00:00',0),
	(74,6,22,2,'15:00:00',0),
	(75,6,16,2,'18:00:00',0),
	(76,4,3,3,'09:00:00',0),
	(77,4,22,3,'12:00:00',0),
	(78,4,21,3,'21:00:00',0),
	(79,5,5,3,'09:00:00',0),
	(80,5,5,3,'12:00:00',0),
	(81,6,22,3,'15:00:00',0),
	(82,6,6,3,'18:00:00',0),
	(83,4,3,4,'15:00:00',0),
	(84,4,6,4,'18:00:00',0),
	(85,4,21,4,'21:00:00',0),
	(86,5,4,4,'12:00:00',0),
	(87,5,6,4,'15:00:00',0),
	(88,5,5,4,'18:00:00',0),
	(89,6,4,4,'09:00:00',0),
	(90,6,4,4,'12:00:00',0),
	(91,4,4,5,'09:00:00',0),
	(92,4,4,5,'12:00:00',0),
	(93,4,2,5,'21:00:00',0),
	(94,5,16,5,'09:00:00',0),
	(95,5,17,5,'21:00:00',0),
	(96,6,4,5,'15:00:00',0),
	(97,6,2,5,'18:00:00',0),
	(98,4,3,6,'09:00:00',0),
	(99,4,4,6,'15:00:00',0),
	(100,4,4,6,'18:00:00',0),
	(101,4,2,6,'21:00:00',0),
	(102,5,16,6,'09:00:00',0),
	(103,5,17,6,'21:00:00',0),
	(104,6,6,6,'12:00:00',0),
	(105,6,17,6,'15:00:00',0),
	(106,4,2,7,'09:00:00',0),
	(107,4,22,7,'12:00:00',0),
	(108,4,3,7,'15:00:00',0),
	(109,5,5,7,'12:00:00',0),
	(110,6,3,7,'18:00:00',0),
	(111,6,4,7,'21:00:00',0),
	(112,7,7,1,'09:00:00',0),
	(113,7,6,1,'12:00:00',0),
	(114,7,7,1,'15:00:00',0),
	(115,7,12,1,'21:00:00',0),
	(116,8,3,1,'09:00:00',0),
	(117,8,2,1,'18:00:00',0),
	(118,8,2,1,'21:00:00',0),
	(119,9,23,1,'15:00:00',0),
	(120,9,7,1,'18:00:00',0),
	(121,7,6,2,'09:00:00',0),
	(122,7,6,2,'18:00:00',0),
	(123,7,6,2,'21:00:00',0),
	(124,8,12,2,'09:00:00',0),
	(125,8,12,2,'12:00:00',0),
	(126,8,8,2,'21:00:00',0),
	(127,9,7,2,'12:00:00',0),
	(128,9,7,2,'15:00:00',0),
	(129,7,3,3,'09:00:00',0),
	(130,7,7,3,'18:00:00',0),
	(131,7,2,3,'21:00:00',0),
	(132,8,3,3,'12:00:00',0),
	(133,8,8,3,'18:00:00',0),
	(134,8,8,3,'21:00:00',0),
	(135,9,7,3,'12:00:00',0),
	(136,9,7,3,'15:00:00',0),
	(137,7,2,4,'09:00:00',0),
	(138,7,2,4,'21:00:00',0),
	(139,8,6,4,'15:00:00',0),
	(140,9,6,4,'12:00:00',0),
	(141,9,6,4,'18:00:00',0),
	(142,7,7,5,'09:00:00',0),
	(143,7,6,5,'15:00:00',0),
	(144,7,3,5,'18:00:00',0),
	(145,7,12,5,'21:00:00',0),
	(146,8,23,5,'09:00:00',0),
	(147,8,23,5,'12:00:00',0),
	(148,8,3,5,'21:00:00',0),
	(149,9,6,5,'12:00:00',0),
	(150,9,12,5,'18:00:00',0),
	(151,7,7,6,'09:00:00',0),
	(152,7,23,6,'15:00:00',0),
	(153,7,6,6,'21:00:00',0),
	(154,8,23,6,'18:00:00',0),
	(155,8,8,6,'21:00:00',0),
	(156,9,2,6,'12:00:00',0),
	(157,9,6,6,'18:00:00',0),
	(158,7,7,7,'09:00:00',0),
	(159,7,3,7,'15:00:00',0),
	(160,7,6,7,'21:00:00',0),
	(161,8,8,7,'09:00:00',0),
	(162,8,8,7,'12:00:00',0),
	(163,9,7,7,'12:00:00',0),
	(164,9,23,7,'18:00:00',0),
	(165,10,4,1,'09:00:00',0),
	(166,10,8,1,'18:00:00',0),
	(167,10,23,1,'21:00:00',0),
	(168,11,11,1,'09:00:00',0),
	(169,11,22,1,'18:00:00',0),
	(170,11,22,1,'21:00:00',0),
	(171,12,4,1,'12:00:00',0),
	(172,12,3,1,'15:00:00',0),
	(173,10,13,2,'09:00:00',0),
	(174,10,13,2,'12:00:00',0),
	(175,10,3,2,'21:00:00',0),
	(176,11,8,2,'09:00:00',0),
	(177,11,11,2,'15:00:00',0),
	(178,11,12,2,'18:00:00',0),
	(179,12,12,2,'12:00:00',0),
	(180,12,13,2,'15:00:00',0),
	(181,12,23,2,'18:00:00',0),
	(182,10,3,3,'09:00:00',0),
	(183,10,4,3,'12:00:00',0),
	(184,10,13,3,'15:00:00',0),
	(185,11,5,3,'09:00:00',0),
	(186,11,3,3,'12:00:00',0),
	(187,11,11,3,'15:00:00',0),
	(188,12,13,3,'18:00:00',0),
	(189,12,13,3,'21:00:00',0),
	(190,10,4,4,'09:00:00',0),
	(191,10,3,4,'12:00:00',0),
	(192,10,7,4,'15:00:00',0),
	(193,10,23,4,'21:00:00',0),
	(194,11,8,4,'09:00:00',0),
	(195,11,22,4,'21:00:00',0),
	(196,12,12,4,'15:00:00',0),
	(197,12,23,4,'18:00:00',0),
	(198,10,23,5,'15:00:00',0),
	(199,10,7,5,'18:00:00',0),
	(200,10,23,5,'21:00:00',0),
	(201,11,18,5,'12:00:00',0),
	(202,11,18,5,'15:00:00',0),
	(203,11,7,5,'21:00:00',0),
	(204,12,13,5,'09:00:00',0),
	(205,12,23,5,'12:00:00',0),
	(206,10,23,6,'09:00:00',0),
	(207,10,4,6,'12:00:00',0),
	(208,10,4,6,'15:00:00',0),
	(209,11,23,6,'12:00:00',0),
	(210,11,5,6,'15:00:00',0),
	(211,11,5,6,'18:00:00',0),
	(212,11,2,6,'21:00:00',0),
	(213,12,2,6,'09:00:00',0),
	(214,12,4,6,'18:00:00',0),
	(215,12,7,6,'00:00:21',0),
	(216,10,4,7,'12:00:00',0),
	(217,10,7,7,'15:00:00',0),
	(218,10,13,7,'18:00:00',0),
	(219,10,13,7,'00:00:21',0),
	(220,11,8,7,'09:00:00',0),
	(221,11,18,7,'18:00:00',0),
	(222,12,4,7,'09:00:00',0),
	(223,12,8,7,'12:00:00',0),
	(224,12,2,7,'21:00:00',0),
	(225,3,4,3,'09:00:00',0);

/*!40000 ALTER TABLE `showtime` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table transaction
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transaction`;

CREATE TABLE `transaction` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `email` varchar(256) NOT NULL,
  `combo_a` int(11) DEFAULT '0',
  `combo_b` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `email` varchar(256) NOT NULL,
  `password` varchar(256) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `name`, `email`, `password`)
VALUES
	(1,'admin','admin@luna.com','$2y$10$970EC274CA867815174EB.FVKnL5YeZw66EQaT148o5sMdaviahle');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
