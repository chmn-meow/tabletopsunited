
CREATE DATABASE IF NOT EXISTS `ttu` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ttu`;

CREATE TABLE `categories` (
  `catid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catname` char(60) NOT NULL,
  PRIMARY KEY (`catid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `content` (
  `contentid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author` char(80) DEFAULT NULL,
  `title` char(100) DEFAULT NULL,
  `catid` int(10) unsigned DEFAULT NULL,
  `price` float(4,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`contentid`),
  KEY `FK_content` (`catid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `orders` (
  `orderid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `amount` float(6,2) DEFAULT NULL,
  `date` date NOT NULL,
  `order_status` char(10) DEFAULT NULL,
  `ship_name` char(60) NOT NULL,
  `ship_address` char(80) NOT NULL,
  `ship_city` char(30) NOT NULL,
  `ship_state` char(20) DEFAULT NULL,
  `ship_zip` char(10) DEFAULT NULL,
  `ship_country` char(20) NOT NULL,
  PRIMARY KEY (`orderid`),
  KEY `FK_orders` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `order_items` (
  `orderid` int(10) unsigned NOT NULL,
  `contentid` int(10) unsigned NOT NULL,
  `item_price` float(4,2) NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`orderid`,`contentid`),
  KEY `FK_order_items` (`contentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `users_auth` (
  `userid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(16) NOT NULL,
  `passwrd` char(40) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE `user_info` (
  `userid` int(10) unsigned NOT NULL,
  `fname` char(30) NOT NULL,
  `lname` char(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` char(80) NOT NULL,
  `city` char(30) NOT NULL,
  `state` char(2) DEFAULT NULL,
  `zip` char(10) DEFAULT NULL,
  `country` char(20) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `content`
  ADD CONSTRAINT `FK_content` FOREIGN KEY (`catid`) REFERENCES `categories` (`catid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `orders`
  ADD CONSTRAINT `FK_orders` FOREIGN KEY (`userid`) REFERENCES `users_auth` (`userid`) ON UPDATE CASCADE;

ALTER TABLE `order_items`
  ADD CONSTRAINT `FK_order_items_orderid` FOREIGN KEY (`orderid`) REFERENCES `orders` (`orderid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_order_items` FOREIGN KEY (`contentid`) REFERENCES `content` (`contentid`) ON UPDATE CASCADE;

ALTER TABLE `user_info`
  ADD CONSTRAINT `FK_user_info` FOREIGN KEY (`userid`) REFERENCES `users_auth` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;