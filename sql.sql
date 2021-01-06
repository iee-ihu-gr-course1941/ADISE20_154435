SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;

CREATE DATABASE backgammonDB;

CREATE TABLE `board` (
  `side` enum('B','W') NOT NULL,
  `y` tinyint(1) NOT NULL,
  `quantity` tinyint(4) NOT NULL DEFAULT 0,
  `piece_color` enum('W','B') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `game_status` (
  `status` enum('not active','started','ended') NOT NULL DEFAULT 'not active',
  `p_turn` enum('W','B') DEFAULT NULL,
  `result` enum('B','W') DEFAULT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `players` (
  `username` varchar(20) DEFAULT NULL,
  `piece_color` enum('B','W') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

COMMIT; 