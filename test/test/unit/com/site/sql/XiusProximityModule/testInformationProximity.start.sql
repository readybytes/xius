
TRUNCATE TABLE `#__xius_info`;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(13, 'Keyword', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'keywordsearch', '', 'Keyword', 5, 1),
(12, 'E-mail', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'email', '', 'Joomla', 4, 1),
(9, 'latitude', 'isSearchable=0\nisVisible=0\nisSortable=0\nisExportable=0\ntooltip=\n\n', 'latitude', '', 'Jsuser', 6, 1),
(10, 'longitude', 'isSearchable=0\nisVisible=0\nisSortable=0\nisExportable=0\ntooltip=\n\n', 'longitude', '', 'Jsuser', 7, 1),
(11, 'By Information', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'information', 'xius_proximity_latitude=9\nxius_proximity_longitude=10\n\n', 'Proximity', 8, 1);;

DROP TABLE IF EXISTS `#__xius_proximity_geocode`;;

CREATE TABLE IF NOT EXISTS `#__xius_proximity_geocode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(250) NOT NULL,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;;



INSERT INTO `#__xius_proximity_geocode` (`id`, `address`, `latitude`, `longitude`, `valid`) VALUES
(1, 'Bhilwara,Rajasthan,India', 25.346251, 74.636383, 1),
(2, 'Ajmer,Rajasthan,India', NULL, NULL, 0),
(3, 'Surat,Gujrat,India', 21.195009, 72.819527, 1),
(4, 'Ludhiana,Punjab,India', 30.902222, 75.854721, 1),
(5, 'Chandigarh,Punjab,India', NULL, NULL, 0),
(6, 'Indore,Madhya Pradesh,India', 22.725313, 75.865555, 1),
(7, 'Noida,Uttar Pradesh,India', 28.583332, 77.333336, 1),
(8, 'Shimla,Himachal Pradesh,India', 31.100000, 77.169998, 1),
(9, 'Pune,Maharashtra,India', 18.520470, 73.856621, 1),
(10, 'Kolkata,West Bangal,India', 22.572645, 88.363892, 1),
(11, 'Alwar,Rajasthan,India', 27.561800, 76.608742, 1),
(12, 'Bikaner,Rajasthan,India', 28.016666, 73.333336, 1),
(13, 'Nagpur,Maharashtra,India', 21.153889, 79.083054, 1),
(14, 'chennai,Tamilnadu,India', 13.060416, 80.249634, 1),
(15, 'Ahmedabad,Gujrat,India', 23.039574, 72.566017, 1),
(16, 'Coimbatore,Karnataka,India', 10.798509, 77.102493, 1),
(17, 'Jalandhar,Punjab,India', 31.320000, 75.580002, 1),
(18, 'Jodhapur,Rajasthan,India', 26.280556, 73.015831, 1),
(19, 'Nagpur,Madhya Pradesh,India', 21.228649, 79.290215, 1),
(20, 'Jaipur,Rajasthan,India', 26.926111, 75.808891, 1),
(21, 'Bhopal,Madhya Pradesh,India', 23.247499, 77.415833, 1),
(22, 'Mumbai,Maharashtra,India', 19.017656, 72.856178, 1),
(23, 'Vadodara,Gujrat,India', 22.306549, 73.187576, 1),
(24, 'Hyderabad,Andhra Pradesh,India', 17.385044, 78.486671, 1),
(25, 'Udaipur,Rajasthan,India', 24.571270, 73.691544, 1),
(26, 'Banglore,Karnataka,India', 12.971606, 77.594376, 1);;


DROP TABLE IF EXISTS `#__xius_cache`;;
--

CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `joomlaemail_0` varchar(250) NOT NULL,
  `jsuserlatitude_0` varchar(250) NOT NULL,
  `jsuserlongitude_0` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;



INSERT INTO `#__xius_cache` (`userid`, `joomlaemail_0`, `jsuserlatitude_0`, `jsuserlongitude_0`) VALUES
(62, 'shyam@joomlaxi.com', '25.3463001251221', '74.6363983154297'),
(63, 'username64@email.com', '26.4538993835449', '74.6389007568359'),
(64, 'username65@email.com', '21.1949996948242', '72.8195037841797'),
(65, 'username66@email.com', '30.9022006988525', '75.8546981811523'),
(66, 'username67@email.com', '20.2376003265381', '84.2699966430664'),
(67, 'username68@email.com', '22.726900100708', '75.8638000488281'),
(68, 'username69@email.com', '28.6165008544922', '77.2415008544922'),
(69, 'username70@email.com', '29.0587997436523', '76.0856018066406'),
(70, 'username71@email.com', '18.5200004577637', '73.8565979003906'),
(71, 'username72@email.com', '24.5949001312256', '84.7142028808594'),
(72, 'username73@email.com', '27.5618000030518', '76.6087036132812'),
(73, 'username74@email.com', '18.5200004577637', '73.8565979003906'),
(74, 'username75@email.com', '28.6182994842529', '77.2422027587891'),
(75, 'username76@email.com', '25.1979999542236', '85.5218963623047'),
(76, 'username77@email.com', '28.6165008544922', '77.2415008544922'),
(77, 'username78@email.com', '30.8820991516113', '75.8339996337891'),
(78, 'username79@email.com', '15.3172998428345', '75.7138977050781'),
(79, 'username80@email.com', '26.2005996704102', '92.9375991821289'),
(80, 'username81@email.com', '13.0604000091553', '80.2496032714844'),
(81, 'username82@email.com', '23.0396003723145', '72.5660018920898'),
(82, 'username83@email.com', '10.7985000610352', '77.1025009155273'),
(83, 'username84@email.com', '21.1539001464844', '79.0830993652344'),
(84, 'username85@email.com', '25.3463001251221', '74.6363983154297'),
(85, 'username86@email.com', '30.9022006988525', '75.8546981811523'),
(86, 'username87@email.com', '31.3199996948242', '75.5800018310547'),
(87, 'username88@email.com', '26.2805995941162', '73.0158004760742'),
(88, 'username89@email.com', '30.9022006988525', '75.8546981811523'),
(89, 'username90@email.com', '27.5618000030518', '76.6087036132812'),
(90, 'username91@email.com', '25.3463001251221', '74.6363983154297'),
(91, 'username92@email.com', '22.7252998352051', '75.8656005859375'),
(92, 'username93@email.com', '28.5832996368408', '77.3332977294922'),
(93, 'username94@email.com', '22.7252998352051', '75.8656005859375'),
(94, 'username95@email.com', '22.5725994110107', '88.363899230957'),
(95, 'username96@email.com', '21.2287006378174', '79.2901992797852'),
(96, 'username97@email.com', '26.9260997772217', '75.8088989257812'),
(97, 'username98@email.com', '23.2474994659424', '77.4158020019531'),
(98, 'username99@email.com', '19.0177001953125', '72.856201171875'),
(99, 'username100@email.com', '30.9022006988525', '75.8546981811523'),
(100, 'username101@email.com', '30.9022006988525', '75.8546981811523'),
(101, 'username102@email.com', '26.4538993835449', '74.6389007568359'),
(102, 'username103@email.com', '10.7985000610352', '77.1025009155273'),
(103, 'username104@email.com', '18.5205001831055', '73.8565979003906'),
(104, 'username105@email.com', '22.3064994812012', '73.1875991821289'),
(105, 'username106@email.com', '28.0167007446289', '73.3332977294922'),
(106, 'username107@email.com', '17.3850002288818', '78.486701965332'),
(107, 'username108@email.com', '13.0604000091553', '80.2496032714844'),
(108, 'username109@email.com', '25.3463001251221', '74.6363983154297'),
(109, 'username110@email.com', '24.5713005065918', '73.6914978027344'),
(110, 'username111@email.com', '13.0604000091553', '80.2496032714844'),
(111, 'username112@email.com', '26.9260997772217', '75.8088989257812'),
(112, 'username113@email.com', '23.0396003723145', '72.5660018920898'),
(113, 'username114@email.com', '31.3199996948242', '75.5800018310547'),
(114, 'username115@email.com', '17.3850002288818', '78.486701965332'),
(115, 'username116@email.com', '25.3463001251221', '74.6363983154297'),
(116, 'username117@email.com', '31.1000003814697', '77.1699981689453'),
(117, 'username118@email.com', '12.9715995788574', '77.5943984985352'),
(118, 'username119@email.com', '26.9260997772217', '75.8088989257812'),
(119, 'username120@email.com', '21.1949996948242', '72.8195037841797'),
(120, 'username121@email.com', '30.9022006988525', '75.8546981811523');;
