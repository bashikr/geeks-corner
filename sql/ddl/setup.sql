DROP DATABASE geeksCorner;
CREATE DATABASE IF NOT EXISTS geeksCorner;

CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'pass';

GRANT ALL PRIVILEGES ON geeksCorner.* TO 'user'@'%';

USE geeksCorner;
