USE geeksCorner;

SET NAMES utf8;

--
-- Table `Users`
--
DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `firstname` VARCHAR(100) NOT NULL,
    `lastname` VARCHAR(100) NOT NULL,
    `image` VARCHAR(100) NOT NULL, 
    `email` VARCHAR(100) UNIQUE NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `gender` VARCHAR(100) DEFAULT "Prefer not to say.",
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `counter` INTEGER,
    `updated` DATETIME,
    `deleted` DATETIME,
    `active` DATETIME

) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;


--
-- Table `Questions`
--
DROP TABLE IF EXISTS `Questions`;
CREATE TABLE `Questions` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `userId` INTEGER NOT NULL,
    `tags` VARCHAR(256) NOT NULL,
    `question` TEXT NOT NULL,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;


--
-- Table Tags
--
DROP TABLE IF EXISTS `Tags`;
CREATE TABLE `Tags` (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `tag` VARCHAR(50) UNIQUE NOT NULL,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `counter` INTEGER
) ENGINE INNODB CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci;
