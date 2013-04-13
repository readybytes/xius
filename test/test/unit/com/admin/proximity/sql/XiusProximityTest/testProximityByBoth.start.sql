CREATE TABLE IF NOT EXISTS `#__xius_proximity_geocode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(250) NOT NULL,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;;

--
-- Dumping data for table `j405_xius_proximity_geocode`
--
TRUNCATE TABLE `#__xius_proximity_geocode`;;
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
-- Table structure for table `#__xius_cache`
--

CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `joomlaemail_0` varchar(250) NOT NULL,
  `jsfields3_0` varchar(250) NOT NULL,
  `jsuserlatitude_0` varchar(250) NOT NULL,
  `rangesearch14_0` int(5) NOT NULL DEFAULT '0',
  `jsuserlongitude_0` varchar(250) NOT NULL,
  `jsfields11_0` varchar(250) NOT NULL,
  `jsfields12_0` varchar(250) NOT NULL,
  `jsfields10_0` varchar(250) NOT NULL,
  `proximity_google_latitude_0` float(10,6) DEFAULT NULL,
  `proximity_google_longitude_0` float(10,6) DEFAULT NULL,
  `proximity_google_address_0` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;

--
-- Dumping data for table `#__xius_cache`
--

INSERT INTO `#__xius_cache` (`userid`, `joomlaemail_0`, `jsfields3_0`, `jsuserlatitude_0`, `rangesearch14_0`, `jsuserlongitude_0`, `jsfields11_0`, `jsfields12_0`, `jsfields10_0`, `proximity_google_latitude_0`, `proximity_google_longitude_0`, `proximity_google_address_0`) VALUES
(62, 'shyam@joomlaxi.com', '', '25.3463001251221', 0, '74.6363983154297', 'Bhilwara', 'India', 'Rajasthan', 25.346251, 74.636383, 'Bhilwara,Rajasthan,India'),
(63, 'username64@email.com', '', '26.4538993835449', 0, '74.6389007568359', 'Ajmer', 'India', 'Rajasthan', NULL, NULL, 'Ajmer,Rajasthan,India'),
(64, 'username65@email.com', '2000-12-25 23:59:59', '21.1949996948242', 10, '72.8195037841797', 'Surat', 'India', 'Gujrat', 21.195009, 72.819527, 'Surat,Gujrat,India'),
(65, 'username66@email.com', '1992-2-9 23:59:59', '30.9022006988525', 18, '75.8546981811523', 'Ludhiana', 'India', 'Punjab', 30.902222, 75.854721, 'Ludhiana,Punjab,India'),
(66, 'username67@email.com', '1994-9-22 23:59:59', '20.2376003265381', 16, '84.2699966430664', 'Chandigarh', 'India', 'Punjab', NULL, NULL, 'Chandigarh,Punjab,India'),
(67, 'username68@email.com', '1993-6-20 23:59:59', '22.726900100708', 17, '75.8638000488281', 'Indore', 'India', 'Madhya Pradesh', 22.725313, 75.865555, 'Indore,Madhya Pradesh,India'),
(68, 'username69@email.com', '1994-5-21 23:59:59', '28.6165008544922', 16, '77.2415008544922', 'Noida', 'India', 'Uttar Pradesh', 28.583332, 77.333336, 'Noida,Uttar Pradesh,India'),
(69, 'username70@email.com', '1992-9-21 23:59:59', '29.0587997436523', 18, '76.0856018066406', 'Shimla', 'India', 'Himachal Pradesh', 31.100000, 77.169998, 'Shimla,Himachal Pradesh,India'),
(70, 'username71@email.com', '1999-1-21 23:59:59', '18.5200004577637', 11, '73.8565979003906', 'Pune', 'India', 'Maharashtra', 18.520470, 73.856621, 'Pune,Maharashtra,India'),
(71, 'username72@email.com', '1994-1-27 23:59:59', '24.5949001312256', 16, '84.7142028808594', 'Kolkata', 'India', 'West Bangal', 22.572645, 88.363892, 'Kolkata,West Bangal,India'),
(72, 'username73@email.com', '1996-10-3 23:59:59', '27.5618000030518', 14, '76.6087036132812', 'Alwar', 'India', 'Rajasthan', 27.561800, 76.608742, 'Alwar,Rajasthan,India'),
(73, 'username74@email.com', '1998-12-21 23:59:59', '18.5200004577637', 12, '73.8565979003906', 'Pune', 'India', 'Maharashtra', 18.520470, 73.856621, 'Pune,Maharashtra,India'),
(74, 'username75@email.com', '1995-9-18 23:59:59', '28.6182994842529', 15, '77.2422027587891', 'Noida', 'India', 'Uttar Pradesh', 28.583332, 77.333336, 'Noida,Uttar Pradesh,India'),
(75, 'username76@email.com', '1996-7-10 23:59:59', '25.1979999542236', 14, '85.5218963623047', 'Ajmer', 'India', 'Rajasthan', NULL, NULL, 'Ajmer,Rajasthan,India'),
(76, 'username77@email.com', '1999-12-20 23:59:59', '28.6165008544922', 11, '77.2415008544922', 'Noida', 'India', 'Uttar Pradesh', 28.583332, 77.333336, 'Noida,Uttar Pradesh,India'),
(77, 'username78@email.com', '1994-6-3 23:59:59', '30.8820991516113', 16, '75.8339996337891', 'Ludhiana', 'India', 'Punjab', 30.902222, 75.854721, 'Ludhiana,Punjab,India'),
(78, 'username79@email.com', '1997-10-23 23:59:59', '15.3172998428345', 13, '75.7138977050781', 'Bikaner', 'India', 'Rajasthan', 28.016666, 73.333336, 'Bikaner,Rajasthan,India'),
(79, 'username80@email.com', '1990-5-7 23:59:59', '26.2005996704102', 20, '92.9375991821289', 'Nagpur', 'India', 'Maharashtra', 21.153889, 79.083054, 'Nagpur,Maharashtra,India'),
(80, 'username81@email.com', '1998-12-20 23:59:59', '13.0604000091553', 12, '80.2496032714844', 'chennai', 'India', 'Tamilnadu', 13.060416, 80.249634, 'chennai,Tamilnadu,India'),
(81, 'username82@email.com', '1996-11-20 23:59:59', '23.0396003723145', 14, '72.5660018920898', 'Ahmedabad', 'India', 'Gujrat', 23.039574, 72.566017, 'Ahmedabad,Gujrat,India'),
(82, 'username83@email.com', '1995-10-13 23:59:59', '10.7985000610352', 15, '77.1025009155273', 'Coimbatore', 'India', 'Karnataka', 10.798509, 77.102493, 'Coimbatore,Karnataka,India'),
(83, 'username84@email.com', '1997-1-12 23:59:59', '21.1539001464844', 13, '79.0830993652344', 'Nagpur', 'India', 'Maharashtra', 21.153889, 79.083054, 'Nagpur,Maharashtra,India'),
(84, 'username85@email.com', '1994-6-2 23:59:59', '25.3463001251221', 16, '74.6363983154297', 'Bhilwara', 'India', 'Rajasthan', 25.346251, 74.636383, 'Bhilwara,Rajasthan,India'),
(85, 'username86@email.com', '2000-10-8 23:59:59', '30.9022006988525', 10, '75.8546981811523', 'Ludhiana', 'India', 'Punjab', 30.902222, 75.854721, 'Ludhiana,Punjab,India'),
(86, 'username87@email.com', '2000-1-7 23:59:59', '31.3199996948242', 10, '75.5800018310547', 'Jalandhar', 'India', 'Punjab', 31.320000, 75.580002, 'Jalandhar,Punjab,India'),
(87, 'username88@email.com', '1996-4-14 23:59:59', '26.2805995941162', 14, '73.0158004760742', 'Jodhapur', 'India', 'Rajasthan', 26.280556, 73.015831, 'Jodhapur,Rajasthan,India'),
(88, 'username89@email.com', '1998-8-24 23:59:59', '30.9022006988525', 12, '75.8546981811523', 'Ludhiana', 'India', 'Punjab', 30.902222, 75.854721, 'Ludhiana,Punjab,India'),
(89, 'username90@email.com', '1994-1-17 23:59:59', '27.5618000030518', 16, '76.6087036132812', 'Alwar', 'India', 'Rajasthan', 27.561800, 76.608742, 'Alwar,Rajasthan,India'),
(90, 'username91@email.com', '1993-6-9 23:59:59', '25.3463001251221', 17, '74.6363983154297', 'Bhilwara', 'India', 'Rajasthan', 25.346251, 74.636383, 'Bhilwara,Rajasthan,India'),
(91, 'username92@email.com', '1998-8-19 23:59:59', '22.7252998352051', 12, '75.8656005859375', 'Indore', 'India', 'Madhya Pradesh', 22.725313, 75.865555, 'Indore,Madhya Pradesh,India'),
(92, 'username93@email.com', '1990-2-3 23:59:59', '28.5832996368408', 20, '77.3332977294922', 'Noida', 'India', 'Uttar Pradesh', 28.583332, 77.333336, 'Noida,Uttar Pradesh,India'),
(93, 'username94@email.com', '2000-6-20 23:59:59', '22.7252998352051', 10, '75.8656005859375', 'Indore', 'India', 'Madhya Pradesh', 22.725313, 75.865555, 'Indore,Madhya Pradesh,India'),
(94, 'username95@email.com', '1994-6-13 23:59:59', '22.5725994110107', 16, '88.363899230957', 'Kolkata', 'India', 'West Bangal', 22.572645, 88.363892, 'Kolkata,West Bangal,India'),
(95, 'username96@email.com', '1998-6-17 23:59:59', '21.2287006378174', 12, '79.2901992797852', 'Nagpur', 'India', 'Madhya Pradesh', 21.228649, 79.290215, 'Nagpur,Madhya Pradesh,India'),
(96, 'username97@email.com', '1998-9-3 23:59:59', '26.9260997772217', 12, '75.8088989257812', 'Jaipur', 'India', 'Rajasthan', 26.926111, 75.808891, 'Jaipur,Rajasthan,India'),
(97, 'username98@email.com', '1999-10-25 23:59:59', '23.2474994659424', 11, '77.4158020019531', 'Bhopal', 'India', 'Madhya Pradesh', 23.247499, 77.415833, 'Bhopal,Madhya Pradesh,India'),
(98, 'username99@email.com', '1992-11-18 23:59:59', '19.0177001953125', 18, '72.856201171875', 'Mumbai', 'India', 'Maharashtra', 19.017656, 72.856178, 'Mumbai,Maharashtra,India'),
(99, 'username100@email.com', '1996-4-22 23:59:59', '30.9022006988525', 14, '75.8546981811523', 'Ludhiana', 'India', 'Punjab', 30.902222, 75.854721, 'Ludhiana,Punjab,India'),
(100, 'username101@email.com', '1998-5-14 23:59:59', '30.9022006988525', 12, '75.8546981811523', 'Ludhiana', 'India', 'Punjab', 30.902222, 75.854721, 'Ludhiana,Punjab,India'),
(101, 'username102@email.com', '1995-2-18 23:59:59', '26.4538993835449', 15, '74.6389007568359', 'Ajmer', 'India', 'Rajasthan', NULL, NULL, 'Ajmer,Rajasthan,India'),
(102, 'username103@email.com', '1992-9-23 23:59:59', '10.7985000610352', 18, '77.1025009155273', 'Coimbatore', 'India', 'Karnataka', 10.798509, 77.102493, 'Coimbatore,Karnataka,India'),
(103, 'username104@email.com', '1999-2-27 23:59:59', '18.5205001831055', 11, '73.8565979003906', 'Pune', 'India', 'Maharashtra', 18.520470, 73.856621, 'Pune,Maharashtra,India'),
(104, 'username105@email.com', '1990-6-2 23:59:59', '22.3064994812012', 20, '73.1875991821289', 'Vadodara', 'India', 'Gujrat', 22.306549, 73.187576, 'Vadodara,Gujrat,India'),
(105, 'username106@email.com', '1998-4-21 23:59:59', '28.0167007446289', 12, '73.3332977294922', 'Bikaner', 'India', 'Rajasthan', 28.016666, 73.333336, 'Bikaner,Rajasthan,India'),
(106, 'username107@email.com', '1998-9-11 23:59:59', '17.3850002288818', 12, '78.486701965332', 'Hyderabad', 'India', 'Andhra Pradesh', 17.385044, 78.486671, 'Hyderabad,Andhra Pradesh,India'),
(107, 'username108@email.com', '1997-11-16 23:59:59', '13.0604000091553', 13, '80.2496032714844', 'chennai', 'India', 'Tamilnadu', 13.060416, 80.249634, 'chennai,Tamilnadu,India'),
(108, 'username109@email.com', '1993-2-12 23:59:59', '25.3463001251221', 17, '74.6363983154297', 'Bhilwara', 'India', 'Rajasthan', 25.346251, 74.636383, 'Bhilwara,Rajasthan,India'),
(109, 'username110@email.com', '1998-4-16 23:59:59', '24.5713005065918', 12, '73.6914978027344', 'Udaipur', 'India', 'Rajasthan', 24.571270, 73.691544, 'Udaipur,Rajasthan,India'),
(110, 'username111@email.com', '1995-4-5 23:59:59', '13.0604000091553', 15, '80.2496032714844', 'chennai', 'India', 'Tamilnadu', 13.060416, 80.249634, 'chennai,Tamilnadu,India'),
(111, 'username112@email.com', '1990-3-13 23:59:59', '26.9260997772217', 20, '75.8088989257812', 'Jaipur', 'India', 'Rajasthan', 26.926111, 75.808891, 'Jaipur,Rajasthan,India'),
(112, 'username113@email.com', '1995-1-20 23:59:59', '23.0396003723145', 15, '72.5660018920898', 'Ahmedabad', 'India', 'Gujrat', 23.039574, 72.566017, 'Ahmedabad,Gujrat,India'),
(113, 'username114@email.com', '1996-4-18 23:59:59', '31.3199996948242', 14, '75.5800018310547', 'Jalandhar', 'India', 'Punjab', 31.320000, 75.580002, 'Jalandhar,Punjab,India'),
(114, 'username115@email.com', '1997-6-16 23:59:59', '17.3850002288818', 13, '78.486701965332', 'Hyderabad', 'India', 'Andhra Pradesh', 17.385044, 78.486671, 'Hyderabad,Andhra Pradesh,India'),
(115, 'username116@email.com', '1994-9-1 23:59:59', '25.3463001251221', 16, '74.6363983154297', 'Bhilwara', 'India', 'Rajasthan', 25.346251, 74.636383, 'Bhilwara,Rajasthan,India'),
(116, 'username117@email.com', '1990-1-13 23:59:59', '31.1000003814697', 20, '77.1699981689453', 'Shimla', 'India', 'Himachal Pradesh', 31.100000, 77.169998, 'Shimla,Himachal Pradesh,India'),
(117, 'username118@email.com', '1999-8-12 23:59:59', '12.9715995788574', 11, '77.5943984985352', 'Banglore', 'India', 'Karnataka', 12.971606, 77.594376, 'Banglore,Karnataka,India'),
(118, 'username119@email.com', '1999-10-22 23:59:59', '26.9260997772217', 11, '75.8088989257812', 'Jaipur', 'India', 'Rajasthan', 26.926111, 75.808891, 'Jaipur,Rajasthan,India'),
(119, 'username120@email.com', '1999-7-4 23:59:59', '21.1949996948242', 11, '72.8195037841797', 'Surat', 'India', 'Gujrat', 21.195009, 72.819527, 'Surat,Gujrat,India'),
(120, 'username121@email.com', '1990-6-13 23:59:59', '30.9022006988525', 20, '75.8546981811523', 'Ludhiana', 'India', 'Punjab', 30.902222, 75.854721, 'Ludhiana,Punjab,India');;


TRUNCATE TABLE `#__xius_info`;;
INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(15, 'Age', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '14', '', 'Rangesearch', 7, 1),
(14, 'Birthday', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '3', '', 'Jsfields', 6, 1),
(13, 'Keyword', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'keywordsearch', '', 'Keyword', 5, 1),
(12, 'E-mail', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'email', '', 'Joomla', 4, 1),
(9, 'latitude', 'isSearchable=0\nisVisible=0\nisSortable=0\nisExportable=0\ntooltip=\n\n', 'latitude', '', 'Jsuser', 6, 1),
(10, 'longitude', 'isSearchable=0\nisVisible=0\nisSortable=0\nisExportable=0\ntooltip=\n\n', 'longitude', '', 'Jsuser', 7, 1),
(11, 'By Information', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'information', 'xius_proximity_latitude=9\nxius_proximity_longitude=10\n\n', 'Proximity', 8, 1),
(16, 'City / Town', 'isSearchable=0\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '11', '', 'Jsfields', 8, 1),
(17, 'Country', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '12', '', 'Jsfields', 9, 1),
(19, 'State', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '10', '', 'Jsfields', 10, 1),
(20, 'By Google API', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'google', 'xius_proximity_country=17\nxius_proximity_zipcode=\nxius_proximity_state=19\nxius_proximity_city=16\nxius_gmap_key=\n\n', 'Proximity', 11, 1);;

