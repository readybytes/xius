/* XIUS INFO */

TRUNCATE TABLE `#__xius_info`;;

/* XIUS INFO */

TRUNCATE TABLE `#__xius_info`;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(2, 'City', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', '', 'Jsfields', 2, 1),
(4, 'Gender', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '2', '', 'Jsfields', 4, 0),
(7, 'State', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '10', '', 'Jsfields', 5, 1),
(8, 'GOOGLE API', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'google', 'xius_proximity_country=3\nxius_proximity_zipcode=\nxius_proximity_state=7\nxius_proximity_city=2\nxius_gmap_key=\n\n', 'Proximity', 6, 1),
(9, 'ID', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\n\n', 'id', '', 'Joomla', 7, 0),
(10, 'IDByRange', 'isSearchable=1\nisVisible=1\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\n\n', '9', 'rangesearchType=integer\n\n', 'Rangesearch', 8, 0),
(11, 'IDByForce', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\n\n', '10', 'infoid=10\nvalue=a:2:{i:0;s:1:"1";i:1;s:3:"200";}\noperator==\n\n', 'Forcesearch', 9, 1),
(12, 'Keyword', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\n\n', 'keywordsearch', '', 'Keyword', 10, 0),
(13, 'Keyword', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\n\n', '12', 'infoid=12\nvalue=s:6:"female";\noperator==\n\n', 'Forcesearch', 11, 1);;


DROP TABLE IF EXISTS `#__xius_cache`;;


CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `jsfields11_0` varchar(250) NOT NULL,
  `jsfields2_0` varchar(250) NOT NULL,
  `jsfields10_0` varchar(250) NOT NULL,
  `joomlaid_0` int(21) NOT NULL,
  `rangesearch9_0` int(31) NOT NULL DEFAULT '0',
  `proximity_google_latitude_0` float(10,6) DEFAULT NULL,
  `proximity_google_longitude_0` float(10,6) DEFAULT NULL,
  `proximity_google_address_0` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;



INSERT INTO `#__xius_cache` (`userid`, `jsfields11_0`, `jsfields2_0`, `jsfields10_0`, `joomlaid_0`, `rangesearch9_0`, `proximity_google_latitude_0`, `proximity_google_longitude_0`, `proximity_google_address_0`) VALUES
(62, '', '', '', 62, 62, NULL, NULL, ''),
(63, '', '', '', 63, 63, NULL, NULL, ''),
(64, 'Surat', 'Female', 'Rajasthan', 64, 64, NULL, NULL, 'Surat,Rajasthan,Rajasthan'),
(65, 'Ludhiana', 'Female', 'Gujrat', 65, 65, NULL, NULL, 'Ludhiana,Gujrat,Gujrat'),
(66, 'Chandigarh', 'Male', 'Orissa', 66, 66, NULL, NULL, 'Chandigarh,Orissa,Orissa'),
(67, 'Indore', 'Male', 'Gujrat', 67, 67, NULL, NULL, 'Indore,Gujrat,Gujrat'),
(68, 'Noida', 'Female', 'Orissa', 68, 68, NULL, NULL, 'Noida,Orissa,Orissa'),
(69, 'Shimla', 'Female', 'Haryana', 69, 69, NULL, NULL, 'Shimla,Haryana,Haryana'),
(70, 'Pune', 'Female', 'Karnataka', 70, 70, NULL, NULL, 'Pune,Karnataka,Karnataka'),
(71, 'Kolkata', 'Female', 'Bihar', 71, 71, NULL, NULL, 'Kolkata,Bihar,Bihar'),
(72, 'Alwar', 'Female', 'Rajasthan', 72, 72, NULL, NULL, 'Alwar,Rajasthan,Rajasthan'),
(73, 'Pune', 'Male', 'Rajasthan', 73, 73, NULL, NULL, 'Pune,Rajasthan,Rajasthan'),
(74, 'Noida', 'Female', 'Karnataka', 74, 74, NULL, NULL, 'Noida,Karnataka,Karnataka'),
(75, 'Ajmer', 'Male', 'Bihar', 75, 75, NULL, NULL, 'Ajmer,Bihar,Bihar'),
(76, 'Noida', 'Male', 'Orissa', 76, 76, NULL, NULL, 'Noida,Orissa,Orissa'),
(77, 'Ludhiana', 'Male', 'Delhi', 77, 77, NULL, NULL, 'Ludhiana,Delhi,Delhi'),
(78, 'Bikaner', 'Female', 'Karnataka', 78, 78, NULL, NULL, 'Bikaner,Karnataka,Karnataka'),
(79, 'Nagpur', 'Female', 'Assam', 79, 79, NULL, NULL, 'Nagpur,Assam,Assam'),
(80, 'chennai', 'Female', 'Goa', 80, 80, NULL, NULL, 'chennai,Goa,Goa'),
(81, 'Ahmedabad', 'Male', 'Karnataka', 81, 81, NULL, NULL, 'Ahmedabad,Karnataka,Karnataka'),
(82, 'Coimbatore', 'Male', 'Orissa', 82, 82, NULL, NULL, 'Coimbatore,Orissa,Orissa'),
(83, 'Nagpur', 'Female', 'Haryana', 83, 83, NULL, NULL, 'Nagpur,Haryana,Haryana'),
(84, 'Bhilwara', 'Female', 'Assam', 84, 84, NULL, NULL, 'Bhilwara,Assam,Assam'),
(85, 'Ludhiana', 'Male', 'Assam', 85, 85, NULL, NULL, 'Ludhiana,Assam,Assam'),
(86, 'Jalandhar', 'Female', 'Uttar Pradesh', 86, 86, NULL, NULL, 'Jalandhar,Uttar Pradesh,Uttar Pradesh'),
(87, 'Jodhapur', 'Female', 'Goa', 87, 87, NULL, NULL, 'Jodhapur,Goa,Goa'),
(88, 'Ludhiana', 'Female', 'Goa', 88, 88, NULL, NULL, 'Ludhiana,Goa,Goa'),
(89, 'Alwar', 'Male', 'Andhra Pradesh', 89, 89, NULL, NULL, 'Alwar,Andhra Pradesh,Andhra Pradesh'),
(90, 'Bhilwara', 'Female', 'Rajasthan', 90, 90, NULL, NULL, 'Bhilwara,Rajasthan,Rajasthan'),
(91, 'Indore', 'Female', 'Delhi', 91, 91, NULL, NULL, 'Indore,Delhi,Delhi'),
(92, 'Noida', 'Male', 'Orissa', 92, 92, NULL, NULL, 'Noida,Orissa,Orissa'),
(93, 'Indore', 'Female', 'Gujrat', 93, 93, NULL, NULL, 'Indore,Gujrat,Gujrat'),
(94, 'Kolkata', 'Male', 'Haryana', 94, 94, NULL, NULL, 'Kolkata,Haryana,Haryana'),
(95, 'Nagpur', 'Female', 'Uttar Pradesh', 95, 95, NULL, NULL, 'Nagpur,Uttar Pradesh,Uttar Pradesh'),
(96, 'Jaipur', 'Male', 'Karnataka', 96, 96, NULL, NULL, 'Jaipur,Karnataka,Karnataka'),
(97, 'Bhopal', 'Female', 'Goa', 97, 97, NULL, NULL, 'Bhopal,Goa,Goa'),
(98, 'Mumbai', 'Female', 'Maharashtra', 98, 98, NULL, NULL, 'Mumbai,Maharashtra,Maharashtra'),
(99, 'Ludhiana', 'Male', 'Karnataka', 99, 99, NULL, NULL, 'Ludhiana,Karnataka,Karnataka'),
(100, 'Ludhiana', 'Male', 'Andhra Pradesh', 100, 100, NULL, NULL, 'Ludhiana,Andhra Pradesh,Andhra Pradesh'),
(101, 'Ajmer', 'Male', 'Gujrat', 101, 101, NULL, NULL, 'Ajmer,Gujrat,Gujrat'),
(102, 'Coimbatore', 'Female', 'Haryana', 102, 102, NULL, NULL, 'Coimbatore,Haryana,Haryana'),
(103, 'Pune', 'Male', 'Orissa', 103, 103, NULL, NULL, 'Pune,Orissa,Orissa'),
(104, 'Vadodara', 'Male', 'Orissa', 104, 104, NULL, NULL, 'Vadodara,Orissa,Orissa'),
(105, 'Bikaner', 'Female', 'Rajasthan', 105, 105, NULL, NULL, 'Bikaner,Rajasthan,Rajasthan'),
(106, 'Hyderabad', 'Male', 'Maharashtra', 106, 106, NULL, NULL, 'Hyderabad,Maharashtra,Maharashtra'),
(107, 'chennai', 'Male', 'Gujrat', 107, 107, NULL, NULL, 'chennai,Gujrat,Gujrat'),
(108, 'Chandigarh', 'Male', 'Uttar Pradesh', 108, 108, NULL, NULL, 'Chandigarh,Uttar Pradesh,Uttar Pradesh'),
(109, 'Udaipur', 'Male', 'Rajasthan', 109, 109, NULL, NULL, 'Udaipur,Rajasthan,Rajasthan'),
(110, 'chennai', 'Male', 'Karnataka', 110, 110, NULL, NULL, 'chennai,Karnataka,Karnataka'),
(111, 'Jaipur', 'Male', 'Karnataka', 111, 111, NULL, NULL, 'Jaipur,Karnataka,Karnataka'),
(112, 'Ahmedabad', 'Male', 'Rajasthan', 112, 112, NULL, NULL, 'Ahmedabad,Rajasthan,Rajasthan'),
(113, 'Jalandhar', 'Male', 'Orissa', 113, 113, NULL, NULL, 'Jalandhar,Orissa,Orissa'),
(114, 'Hyderabad', 'Female', 'Assam', 114, 114, NULL, NULL, 'Hyderabad,Assam,Assam'),
(115, 'Bhilwara', 'Female', 'Haryana', 115, 115, NULL, NULL, 'Bhilwara,Haryana,Haryana'),
(116, 'Shimla', 'Female', 'Maharashtra', 116, 116, NULL, NULL, 'Shimla,Maharashtra,Maharashtra'),
(117, 'Banglore', 'Female', 'Karnataka', 117, 117, NULL, NULL, 'Banglore,Karnataka,Karnataka'),
(118, 'Jaipur', 'Female', 'Karnataka', 118, 118, NULL, NULL, 'Jaipur,Karnataka,Karnataka'),
(119, 'Surat', 'Male', 'Karnataka', 119, 119, NULL, NULL, 'Surat,Karnataka,Karnataka'),
(120, 'Ludhiana', 'Male', 'Rajasthan', 120, 120, NULL, NULL, 'Ludhiana,Rajasthan,Rajasthan');;

