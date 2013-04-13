DROP TABLE IF EXISTS `#__xius_cache`;;
CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `jsfields11_0` varchar(250) NOT NULL,
  `jsfields12_0` varchar(250) NOT NULL,
  `jsfields2_0` varchar(250) NOT NULL,
  `joomlaname_0` varchar(250) NOT NULL,
  `jsfields10_0` varchar(250) NOT NULL,
  `proximity_google_latitude_0` float(10,6) NOT NULL DEFAULT '0.000000',
  `proximity_google_longitude_0` float(10,6) NOT NULL DEFAULT '0.000000',
  `proximity_google_address_0` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;

--
-- Dumping data for table `j143_xius_cache`
--

INSERT INTO `#__xius_cache` (`userid`, `jsfields11_0`, `jsfields12_0`, `jsfields2_0`, `joomlaname_0`, `jsfields10_0`, `proximity_google_latitude_0`, `proximity_google_longitude_0`, `proximity_google_address_0`) VALUES
(62, 'Bhilwara', 'India', '', 'Administrator', 'Rajasthan', 0.000000, 0.000000, 'Bhilwara,Rajasthan,India'),
(63, 'Ajmer', 'India', '', 'name64', 'Rajasthan', 0.000000, 0.000000, 'Ajmer,Rajasthan,India'),
(64, 'Surat', 'India', 'Female', 'name65', 'Gujrat', 0.000000, 0.000000, 'Surat,Gujrat,India'),
(65, 'Ludhiana', 'India', 'Female', 'name66', 'Punjab', 0.000000, 0.000000, 'Ludhiana,Punjab,India'),
(66, 'Chandigarh', 'India', 'Male', 'name67', 'Punjab', 0.000000, 0.000000, 'Chandigarh,Punjab,India'),
(67, 'Indore', 'India', 'Male', 'name68', 'Madhya Pradesh', 0.000000, 0.000000, 'Indore,Madhya Pradesh,India'),
(68, 'Noida', 'India', 'Female', 'name69', 'Uttar Pradesh', 0.000000, 0.000000, 'Noida,Uttar Pradesh,India'),
(69, 'Shimla', 'India', 'Female', 'name70', 'Himachal Pradesh', 0.000000, 0.000000, 'Shimla,Himachal Pradesh,India'),
(70, 'Pune', 'India', 'Female', 'name71', 'Maharashtra', 0.000000, 0.000000, 'Pune,Maharashtra,India'),
(71, 'Kolkata', 'India', 'Female', 'name72', 'West Bangal', 0.000000, 0.000000, 'Kolkata,West Bangal,India'),
(72, 'Alwar', 'India', 'Female', 'name73', 'Rajasthan', 0.000000, 0.000000, 'Alwar,Rajasthan,India'),
(73, 'Pune', 'India', 'Male', 'name74', 'Maharashtra', 0.000000, 0.000000, 'Pune,Maharashtra,India'),
(74, 'Noida', 'India', 'Female', 'name75', 'Uttar Pradesh', 0.000000, 0.000000, 'Noida,Uttar Pradesh,India'),
(75, 'Ajmer', 'India', 'Male', 'name76', 'Rajasthan', 0.000000, 0.000000, 'Ajmer,Rajasthan,India'),
(76, 'Noida', 'India', 'Male', 'name77', 'Uttar Pradesh', 0.000000, 0.000000, 'Noida,Uttar Pradesh,India'),
(77, 'Ludhiana', 'India', 'Male', 'name78', 'Punjab', 0.000000, 0.000000, 'Ludhiana,Punjab,India'),
(78, 'Bikaner', 'India', 'Female', 'name79', 'Rajasthan', 0.000000, 0.000000, 'Bikaner,Rajasthan,India'),
(79, 'Nagpur', 'India', 'Female', 'name80', 'Maharashtra', 0.000000, 0.000000, 'Nagpur,Maharashtra,India'),
(80, 'chennai', 'India', 'Female', 'name81', 'Tamilnadu', 0.000000, 0.000000, 'chennai,Tamilnadu,India'),
(81, 'Ahmedabad', 'India', 'Male', 'name82', 'Gujrat', 0.000000, 0.000000, 'Ahmedabad,Gujrat,India'),
(82, 'Coimbatore', 'India', 'Male', 'name83', 'Karnataka', 0.000000, 0.000000, 'Coimbatore,Karnataka,India'),
(83, 'Nagpur', 'India', 'Female', 'name84', 'Maharashtra', 0.000000, 0.000000, 'Nagpur,Maharashtra,India'),
(84, 'Bhilwara', 'India', 'Female', 'name85', 'Rajasthan', 0.000000, 0.000000, 'Bhilwara,Rajasthan,India'),
(85, 'Ludhiana', 'India', 'Male', 'name86', 'Punjab', 0.000000, 0.000000, 'Ludhiana,Punjab,India'),
(86, 'Jalandhar', 'India', 'Female', 'name87', 'Punjab', 0.000000, 0.000000, 'Jalandhar,Punjab,India'),
(87, 'Jodhapur', 'India', 'Female', 'name88', 'Rajasthan', 0.000000, 0.000000, 'Jodhapur,Rajasthan,India'),
(88, 'Ludhiana', 'India', 'Female', 'name89', 'Punjab', 0.000000, 0.000000, 'Ludhiana,Punjab,India'),
(89, 'Alwar', 'India', 'Male', 'name90', 'Rajasthan', 0.000000, 0.000000, 'Alwar,Rajasthan,India'),
(90, 'Bhilwara', 'India', 'Female', 'name91', 'Rajasthan', 0.000000, 0.000000, 'Bhilwara,Rajasthan,India'),
(91, 'Indore', 'India', 'Female', 'name92', 'Madhya Pradesh', 0.000000, 0.000000, 'Indore,Madhya Pradesh,India'),
(92, 'Noida', 'India', 'Male', 'name93', 'Uttar Pradesh', 0.000000, 0.000000, 'Noida,Uttar Pradesh,India'),
(93, 'Indore', 'India', 'Female', 'name94', 'Madhya Pradesh', 0.000000, 0.000000, 'Indore,Madhya Pradesh,India'),
(94, 'Kolkata', 'India', 'Male', 'name95', 'West Bangal', 0.000000, 0.000000, 'Kolkata,West Bangal,India'),
(95, 'Nagpur', 'India', 'Female', 'name96', 'Madhya Pradesh', 0.000000, 0.000000, 'Nagpur,Madhya Pradesh,India'),
(96, 'Jaipur', 'India', 'Male', 'name97', 'Rajasthan', 0.000000, 0.000000, 'Jaipur,Rajasthan,India'),
(97, 'Bhopal', 'India', 'Female', 'name98', 'Madhya Pradesh', 0.000000, 0.000000, 'Bhopal,Madhya Pradesh,India'),
(98, 'Mumbai', 'India', 'Female', 'name99', 'Maharashtra', 0.000000, 0.000000, 'Mumbai,Maharashtra,India'),
(99, 'Ludhiana', 'India', 'Male', 'name100', 'Punjab', 0.000000, 0.000000, 'Ludhiana,Punjab,India'),
(100, 'Ludhiana', 'India', 'Male', 'name101', 'Punjab', 0.000000, 0.000000, 'Ludhiana,Punjab,India'),
(101, 'Ajmer', 'India', 'Male', 'name102', 'Rajasthan', 0.000000, 0.000000, 'Ajmer,Rajasthan,India'),
(102, 'Coimbatore', 'India', 'Female', 'name103', 'Karnataka', 0.000000, 0.000000, 'Coimbatore,Karnataka,India'),
(103, 'Pune', 'India', 'Male', 'name104', 'Maharashtra', 0.000000, 0.000000, 'Pune,Maharashtra,India'),
(104, 'Vadodara', 'India', 'Male', 'name105', 'Gujrat', 0.000000, 0.000000, 'Vadodara,Gujrat,India'),
(105, 'Bikaner', 'India', 'Female', 'name106', 'Rajasthan', 0.000000, 0.000000, 'Bikaner,Rajasthan,India'),
(106, 'Hyderabad', 'India', 'Male', 'name107', 'Andhra Pradesh', 0.000000, 0.000000, 'Hyderabad,Andhra Pradesh,India'),
(107, 'chennai', 'India', 'Male', 'name108', 'Tamilnadu', 0.000000, 0.000000, 'chennai,Tamilnadu,India'),
(108, 'Bhilwara', 'India', 'Male', 'name109', 'Rajasthan', 0.000000, 0.000000, 'Bhilwara,Rajasthan,India'),
(109, 'Udaipur', 'India', 'Male', 'name110', 'Rajasthan', 0.000000, 0.000000, 'Udaipur,Rajasthan,India'),
(110, 'chennai', 'India', 'Male', 'name111', 'Tamilnadu', 0.000000, 0.000000, 'chennai,Tamilnadu,India'),
(111, 'Jaipur', 'India', 'Male', 'name112', 'Rajasthan', 0.000000, 0.000000, 'Jaipur,Rajasthan,India'),
(112, 'Ahmedabad', 'India', 'Male', 'name113', 'Gujrat', 0.000000, 0.000000, 'Ahmedabad,Gujrat,India'),
(113, 'Jalandhar', 'India', 'Male', 'name114', 'Punjab', 0.000000, 0.000000, 'Jalandhar,Punjab,India'),
(114, 'Hyderabad', 'India', 'Female', 'name115', 'Andhra Pradesh', 0.000000, 0.000000, 'Hyderabad,Andhra Pradesh,India'),
(115, 'Bhilwara', 'India', 'Female', 'name116', 'Rajasthan', 0.000000, 0.000000, 'Bhilwara,Rajasthan,India'),
(116, 'Shimla', 'India', 'Female', 'name117', 'Himachal Pradesh', 0.000000, 0.000000, 'Shimla,Himachal Pradesh,India'),
(117, 'Banglore', 'India', 'Female', 'name118', 'Karnataka', 0.000000, 0.000000, 'Banglore,Karnataka,India'),
(118, 'Jaipur', 'India', 'Female', 'name119', 'Rajasthan', 0.000000, 0.000000, 'Jaipur,Rajasthan,India'),
(119, 'Surat', 'India', 'Male', 'name120', 'Gujrat', 0.000000, 0.000000, 'Surat,Gujrat,India'),
(120, 'Ludhiana', 'India', 'Male', 'name121', 'Punjab', 0.000000, 0.000000, 'Ludhiana,Punjab,India');;


DROP TABLE IF EXISTS `#__xius_proximity_geocode`;;
CREATE TABLE IF NOT EXISTS `#__xius_proximity_geocode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(250) NOT NULL,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;;


CREATE TABLE IF NOT EXISTS `au_#__xius_proximity_geocode` SELECT * FROM `#__xius_proximity_geocode`;;
TRUNCATE TABLE `au_#__xius_proximity_geocode`;;
INSERT INTO `au_#__xius_proximity_geocode` (`id`, `address`, `latitude`, `longitude`, `valid`) VALUES
(1, 'Bhilwara,Rajasthan,India', NULL, NULL, 0),
(2, 'Ajmer,Rajasthan,India', NULL, NULL, 0),
(3, 'Surat,Gujrat,India', NULL, NULL, 0),
(4, 'Ludhiana,Punjab,India', NULL, NULL, 0),
(5, 'Chandigarh,Punjab,India', NULL, NULL, 0),
(6, 'Indore,Madhya Pradesh,India', NULL, NULL, 0),
(7, 'Noida,Uttar Pradesh,India', NULL, NULL, 0),
(8, 'Shimla,Himachal Pradesh,India', NULL, NULL, 0),
(9, 'Pune,Maharashtra,India', NULL, NULL, 0),
(10, 'Kolkata,West Bangal,India', NULL, NULL, 0),
(11, 'Alwar,Rajasthan,India', NULL, NULL, 0),
(12, 'Bikaner,Rajasthan,India', NULL, NULL, 0),
(13, 'Nagpur,Maharashtra,India', NULL, NULL, 0),
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


TRUNCATE TABLE `#__xius_info`;;
INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(2, 'City', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', '', 'Jsfields', 2, 1),
(3, 'Country', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '12', '', 'Jsfields', 3, 1),
(4, 'Gender', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '2', '', 'Jsfields', 4, 1),
(5, 'Name', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'name', '', 'Joomla', 5, 1),
(7, 'State', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '10', '', 'Jsfields', 5, 1),
(8, 'GOOGLE API', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'google', 'xius_proximity_country=3\nxius_proximity_zipcode=\nxius_proximity_state=7\nxius_proximity_city=2\nxius_gmap_key=\n\n', 'Proximity', 6, 1);;

