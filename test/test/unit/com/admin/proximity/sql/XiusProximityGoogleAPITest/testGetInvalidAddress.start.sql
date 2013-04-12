CREATE TABLE IF NOT EXISTS `#__xius_proximity_geocode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(250) NOT NULL,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;;

TRUNCATE TABLE `#__xius_proximity_geocode`;;
INSERT INTO `#__xius_proximity_geocode` (`id`, `address`, `latitude`, `longitude`, `valid`) VALUES
(1, 'Bhilwara,Rajasthan,India', NULL, NULL, 1),
(2, 'Ajmer,Rajasthan,India', NULL, NULL, 0),
(3, 'Surat,Gujrat,India', NULL, NULL, 1),
(4, 'Ludhiana,Punjab,India', NULL, NULL, 1),
(5, 'Chandigarh,Punjab,India', NULL, NULL, 0),
(6, 'Indore,Madhya Pradesh,India', NULL, NULL, 0),
(7, 'Noida,Uttar Pradesh,India', NULL, NULL, 1),
(8, 'Shimla,Himachal Pradesh,India', NULL, NULL, 0),
(9, 'Pune,Maharashtra,India', NULL, NULL, 0),
(10, 'Kolkata,West Bangal,India', NULL, NULL, 1),
(11, 'Alwar,Rajasthan,India', NULL, NULL, 0),
(12, 'Bikaner,Rajasthan,India', NULL, NULL, 0),
(13, 'Nagpur,Maharashtra,India', NULL, NULL, 1),
(14, 'chennai,Tamilnadu,India', NULL, NULL, 0),
(15, 'Ahmedabad,Gujrat,India', NULL, NULL, 0),
(16, 'Coimbatore,Karnataka,India', NULL, NULL, 0),
(17, 'Jalandhar,Punjab,India', NULL, NULL, 0),
(18, 'Jodhapur,Rajasthan,India', NULL, NULL, 0),
(19, 'Nagpur,Madhya Pradesh,India', NULL, NULL, 0),
(20, 'Jaipur,Rajasthan,India', NULL, NULL, 0),
(21, 'Bhopal,Madhya Pradesh,India', NULL, NULL, 0),
(22, 'Mumbai,Maharashtra,India', NULL, NULL, 0),
(23, 'Vadodara,Gujrat,India', NULL, NULL, 0),
(24, 'Hyderabad,Andhra Pradesh,India', NULL, NULL, 0),
(25, 'Udaipur,Rajasthan,India', NULL, NULL, 0),
(26, 'Banglore,Karnataka,India', NULL, NULL, 0);;

