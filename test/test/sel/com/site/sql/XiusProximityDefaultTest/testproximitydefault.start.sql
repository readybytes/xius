

TRUNCATE TABLE `#__xius_info`;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(15, 'Age', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '14', '', 'Rangesearch', 7, 1),
(14, 'Birthday', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '3', '', 'Jsfields', 6, 1),
(13, 'Keyword', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'keywordsearch', '', 'Keyword', 5, 1),
(12, 'E-mail', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'email', '', 'Joomla', 4, 1),
(9, 'latitude', 'isSearchable=0\nisVisible=0\nisSortable=0\nisExportable=0\ntooltip=\n\n', 'latitude', '', 'Jsuser', 6, 1),
(10, 'longitude', 'isSearchable=0\nisVisible=0\nisSortable=0\nisExportable=0\ntooltip=\n\n', 'longitude', '', 'Jsuser', 7, 1),
(11, 'By Information', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\n\n', 'information', 'xius_proximity_latitude=9\nxius_proximity_longitude=10\nxius_default_location=none\n\n', 'Proximity', 8, 1),
(16, 'City / Town', 'isSearchable=0\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '11', '', 'Jsfields', 8, 1),
(17, 'Country', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '12', '', 'Jsfields', 9, 1),
(19, 'State', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=0\ntooltip=\n\n', '10', '', 'Jsfields', 10, 1);;


DROP TABLE IF EXISTS `#__xius_cache`;;

CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `joomlaemail_0` varchar(250) NOT NULL,
  `jsfields3_0` datetime NOT NULL,
  `jsuserlatitude_0` varchar(250) NOT NULL,
  `rangesearch14_0` int(31) NOT NULL DEFAULT '0',
  `jsuserlongitude_0` varchar(250) NOT NULL,
  `jsfields11_0` varchar(250) NOT NULL,
  `jsfields12_0` varchar(250) NOT NULL,
  `jsfields10_0` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;


INSERT INTO `#__xius_cache` (`userid`, `joomlaemail_0`, `jsfields3_0`, `jsuserlatitude_0`, `rangesearch14_0`, `jsuserlongitude_0`, `jsfields11_0`, `jsfields12_0`, `jsfields10_0`) VALUES
(62, 'shyam@joomlaxi.com', '0000-00-00 00:00:00', '25.3463001251221', 0, '74.6363983154297', 'Bhilwara', 'India', 'Rajasthan'),
(63, 'username64@email.com', '0000-00-00 00:00:00', '26.4538993835449', 0, '74.6389007568359', 'Ajmer', 'India', 'Rajasthan'),
(64, 'username65@email.com', '2000-12-25 23:59:59', '21.1949996948242', 9, '72.8195037841797', 'Surat', 'India', 'Gujrat'),
(65, 'username66@email.com', '1992-02-09 23:59:59', '30.9022006988525', 18, '75.8546981811523', 'Ludhiana', 'India', 'Punjab'),
(66, 'username67@email.com', '1994-09-22 23:59:59', '20.2376003265381', 15, '84.2699966430664', 'Chandigarh', 'India', 'Punjab'),
(67, 'username68@email.com', '1993-06-20 23:59:59', '22.726900100708', 17, '75.8638000488281', 'Indore', 'India', 'Madhya Pradesh'),
(68, 'username69@email.com', '1994-05-21 23:59:59', '28.6165008544922', 16, '77.2415008544922', 'Noida', 'India', 'Uttar Pradesh'),
(69, 'username70@email.com', '1992-09-21 23:59:59', '29.0587997436523', 17, '76.0856018066406', 'Shimla', 'India', 'Himachal Pradesh'),
(70, 'username71@email.com', '1999-01-21 23:59:59', '18.5200004577637', 11, '73.8565979003906', 'Pune', 'India', 'Maharashtra'),
(71, 'username72@email.com', '1994-01-27 23:59:59', '24.5949001312256', 16, '84.7142028808594', 'Kolkata', 'India', 'West Bangal'),
(72, 'username73@email.com', '1996-10-03 23:59:59', '27.5618000030518', 13, '76.6087036132812', 'Alwar', 'India', 'Rajasthan'),
(73, 'username74@email.com', '1998-12-21 23:59:59', '18.5200004577637', 11, '73.8565979003906', 'Pune', 'India', 'Maharashtra'),
(74, 'username75@email.com', '1995-09-18 23:59:59', '28.6182994842529', 14, '77.2422027587891', 'Noida', 'India', 'Uttar Pradesh'),
(75, 'username76@email.com', '1996-07-10 23:59:59', '25.1979999542236', 14, '85.5218963623047', 'Ajmer', 'India', 'Rajasthan'),
(76, 'username77@email.com', '1999-12-20 23:59:59', '28.6165008544922', 10, '77.2415008544922', 'Noida', 'India', 'Uttar Pradesh'),
(77, 'username78@email.com', '1994-06-03 23:59:59', '30.8820991516113', 16, '75.8339996337891', 'Ludhiana', 'India', 'Punjab'),
(78, 'username79@email.com', '1997-10-23 23:59:59', '15.3172998428345', 12, '75.7138977050781', 'Bikaner', 'India', 'Rajasthan'),
(79, 'username80@email.com', '1990-05-07 23:59:59', '26.2005996704102', 20, '92.9375991821289', 'Nagpur', 'India', 'Maharashtra'),
(80, 'username81@email.com', '1998-12-20 23:59:59', '13.0604000091553', 11, '80.2496032714844', 'chennai', 'India', 'Tamilnadu'),
(81, 'username82@email.com', '1996-11-20 23:59:59', '23.0396003723145', 13, '72.5660018920898', 'Ahmedabad', 'India', 'Gujrat'),
(82, 'username83@email.com', '1995-10-13 23:59:59', '10.7985000610352', 14, '77.1025009155273', 'Coimbatore', 'India', 'Karnataka'),
(83, 'username84@email.com', '1997-01-12 23:59:59', '21.1539001464844', 13, '79.0830993652344', 'Nagpur', 'India', 'Maharashtra'),
(84, 'username85@email.com', '1994-06-02 23:59:59', '25.3463001251221', 16, '74.6363983154297', 'Bhilwara', 'India', 'Rajasthan'),
(85, 'username86@email.com', '2000-10-08 23:59:59', '30.9022006988525', 9, '75.8546981811523', 'Ludhiana', 'India', 'Punjab'),
(86, 'username87@email.com', '2000-01-07 23:59:59', '31.3199996948242', 10, '75.5800018310547', 'Jalandhar', 'India', 'Punjab'),
(87, 'username88@email.com', '1996-04-14 23:59:59', '26.2805995941162', 14, '73.0158004760742', 'Jodhapur', 'India', 'Rajasthan'),
(88, 'username89@email.com', '1998-08-24 23:59:59', '30.9022006988525', 12, '75.8546981811523', 'Ludhiana', 'India', 'Punjab'),
(89, 'username90@email.com', '1994-01-17 23:59:59', '27.5618000030518', 16, '76.6087036132812', 'Alwar', 'India', 'Rajasthan'),
(90, 'username91@email.com', '1993-06-09 23:59:59', '25.3463001251221', 17, '74.6363983154297', 'Bhilwara', 'India', 'Rajasthan'),
(91, 'username92@email.com', '1998-08-19 23:59:59', '22.7252998352051', 12, '75.8656005859375', 'Indore', 'India', 'Madhya Pradesh'),
(92, 'username93@email.com', '1990-02-03 23:59:59', '28.5832996368408', 20, '77.3332977294922', 'Noida', 'India', 'Uttar Pradesh'),
(93, 'username94@email.com', '2000-06-20 23:59:59', '22.7252998352051', 10, '75.8656005859375', 'Indore', 'India', 'Madhya Pradesh'),
(94, 'username95@email.com', '1994-06-13 23:59:59', '22.5725994110107', 16, '88.363899230957', 'Kolkata', 'India', 'West Bangal'),
(95, 'username96@email.com', '1998-06-17 23:59:59', '21.2287006378174', 12, '79.2901992797852', 'Nagpur', 'India', 'Madhya Pradesh'),
(96, 'username97@email.com', '1998-09-03 23:59:59', '26.9260997772217', 12, '75.8088989257812', 'Jaipur', 'India', 'Rajasthan'),
(97, 'username98@email.com', '1999-10-25 23:59:59', '23.2474994659424', 10, '77.4158020019531', 'Bhopal', 'India', 'Madhya Pradesh'),
(98, 'username99@email.com', '1992-11-18 23:59:59', '19.0177001953125', 17, '72.856201171875', 'Mumbai', 'India', 'Maharashtra'),
(99, 'username100@email.com', '1996-04-22 23:59:59', '30.9022006988525', 14, '75.8546981811523', 'Ludhiana', 'India', 'Punjab'),
(100, 'username101@email.com', '1998-05-14 23:59:59', '30.9022006988525', 12, '75.8546981811523', 'Ludhiana', 'India', 'Punjab'),
(101, 'username102@email.com', '1995-02-18 23:59:59', '26.4538993835449', 15, '74.6389007568359', 'Ajmer', 'India', 'Rajasthan'),
(102, 'username103@email.com', '1992-09-23 23:59:59', '10.7985000610352', 17, '77.1025009155273', 'Coimbatore', 'India', 'Karnataka'),
(103, 'username104@email.com', '1999-02-27 23:59:59', '18.5205001831055', 11, '73.8565979003906', 'Pune', 'India', 'Maharashtra'),
(104, 'username105@email.com', '1990-06-02 23:59:59', '22.3064994812012', 20, '73.1875991821289', 'Vadodara', 'India', 'Gujrat'),
(105, 'username106@email.com', '1998-04-21 23:59:59', '28.0167007446289', 12, '73.3332977294922', 'Bikaner', 'India', 'Rajasthan'),
(106, 'username107@email.com', '1998-09-11 23:59:59', '17.3850002288818', 11, '78.486701965332', 'Hyderabad', 'India', 'Andhra Pradesh'),
(107, 'username108@email.com', '1997-11-16 23:59:59', '13.0604000091553', 12, '80.2496032714844', 'chennai', 'India', 'Tamilnadu'),
(108, 'username109@email.com', '1993-02-12 23:59:59', '25.3463001251221', 17, '74.6363983154297', 'Bhilwara', 'India', 'Rajasthan'),
(109, 'username110@email.com', '1998-04-16 23:59:59', '24.5713005065918', 12, '73.6914978027344', 'Udaipur', 'India', 'Rajasthan'),
(110, 'username111@email.com', '1995-04-05 23:59:59', '13.0604000091553', 15, '80.2496032714844', 'chennai', 'India', 'Tamilnadu'),
(111, 'username112@email.com', '1990-03-13 23:59:59', '26.9260997772217', 20, '75.8088989257812', 'Jaipur', 'India', 'Rajasthan'),
(112, 'username113@email.com', '1995-01-20 23:59:59', '23.0396003723145', 15, '72.5660018920898', 'Ahmedabad', 'India', 'Gujrat'),
(113, 'username114@email.com', '1996-04-18 23:59:59', '31.3199996948242', 14, '75.5800018310547', 'Jalandhar', 'India', 'Punjab'),
(114, 'username115@email.com', '1997-06-16 23:59:59', '17.3850002288818', 13, '78.486701965332', 'Hyderabad', 'India', 'Andhra Pradesh'),
(115, 'username116@email.com', '1994-09-01 23:59:59', '25.3463001251221', 16, '74.6363983154297', 'Bhilwara', 'India', 'Rajasthan'),
(116, 'username117@email.com', '1990-01-13 23:59:59', '31.1000003814697', 20, '77.1699981689453', 'Shimla', 'India', 'Himachal Pradesh'),
(117, 'username118@email.com', '1999-08-12 23:59:59', '12.9715995788574', 11, '77.5943984985352', 'Banglore', 'India', 'Karnataka'),
(118, 'username119@email.com', '1999-10-22 23:59:59', '26.9260997772217', 10, '75.8088989257812', 'Jaipur', 'India', 'Rajasthan'),
(119, 'username120@email.com', '1999-07-04 23:59:59', '21.1949996948242', 11, '72.8195037841797', 'Surat', 'India', 'Gujrat'),
(120, 'username121@email.com', '1990-06-13 23:59:59', '30.9022006988525', 20, '75.8546981811523', 'Ludhiana', 'India', 'Punjab');;