DROP DATABASE IF EXISTS tp_php;
CREATE DATABASE tp_php;
use tp_php;

CREATE TABLE `user` (
                        `id_user` int(11) NOT NULL AUTO_INCREMENT,
                        `login` varchar(200) NOT NULL,
                        `password` varchar(200) NOT NULL,
                        PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

CREATE TABLE `kifekoi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date` timestamp NOT NULL,
  CONSTRAINT fk_ff FOREIGN KEY (id_user) REFERENCES user (id_user),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

LOCK TABLES `user` WRITE;
INSERT INTO `user` VALUES
(1,'tala','$2y$10$LyeqvANpvnq3Tb02dqweWeAOtlo6Q8MJTgKAS6FOnGbMdnWr78oqW'),
(2,'talo','$2y$10$GEkWIzNz.UQsLompj8Dq0Oc.C5zsvMIN87G6ZRZD6eqbZuuFcZB.m'),
(4,'tala3','$2y$10$3LYpTeWfVN6pMvzFI7apx.H0lcLmWtqnUCB0gB0jCQ.T7DrG/lHr2');
UNLOCK TABLES;