<?php

/*
 * Create your own "0_dbInfo.php" file with your settings.
 * leave this one commented out otherwise munsClicker will try to include it.
 * 
 * dbInfo.php is in the gitignore, so as long as you don't do any weird stuff
 *   it should never get pushed.
 * 

define('DB_HOST', 'your database host');
define('DB_USER', 'your database user');
define('DB_PASS', 'your database password');
define('DB_NAME', 'your database name');


 *
 * the rest of this is the import SQL for the database, do not paste that into
 *    your dbInfo.php!
 * 
 * you can use your own data if you want, i just put 2 examples in here.
 * 


CREATE TABLE IF NOT EXISTS `clicker_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `value` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `increase` float NOT NULL,
  `type` int(11) NOT NULL COMMENT '1="auto",2="upgrade"',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `clicker_items` (`id`, `name`, `desc`, `value`, `cost`, `increase`, `type`) VALUES
(1, 'Simple clicker', 'Adds 1 click per second', 1, 10, 1.1, 1),
(2, 'Advanced clicker', 'Adds 2 clicks per second!', 2, 100, 1.1, 1);



*/