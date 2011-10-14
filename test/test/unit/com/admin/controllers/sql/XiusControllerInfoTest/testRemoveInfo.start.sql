TRUNCATE TABLE `#__xius_info`;;
ALTER TABLE `#__xius_info` AUTO_INCREMENT=1;;

DROP TABLE IF EXISTS `au_#__xius_info`;;

CREATE TABLE `au_#__xius_info` SELECT * FROM `#__xius_info`;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(39, 'email', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'email', '', 'Joomla', 7, 1),
(40, 'E-mail', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'Email', 'xius_email=39\n\n', 'Xiusemail', 8, 1),
(41, 'By Google API', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'google', 'xius_proximity_country=38\nxius_proximity_zipcode=\nxius_proximity_state=37\nxius_proximity_city=36\nxius_gmap_key=\nxius_default_location=none\nxiusProximityDefaultLat=28.635308\nxiusProximityDefaultLong=77.22496\nxiusDefaultDistance=10\nxiusDefaultDistanceUnit=miles\nxiusProximityGmapZoom=2\n\n', 'Proximity', 9, 1),
(42, 'name', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'name', '', 'Joomla', 10, 1),
(43, 'name', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '42', 'infoid=42\nvalue=s:4:"john";\noperator==\n\n', 'Forcesearch', 11, 1),
(44, 'Birthdate', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '3', '', 'Jsfields', 12, 1),
(45, 'Birthdate', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '44', 'rangesearchType=date\n\n', 'Rangesearch', 13, 1),
(37, 'State', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '9', '', 'Jsfields', 5, 1),
(38, 'Country', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '11', '', 'Jsfields', 6, 1),
(36, 'City / Town', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '10', '', 'Jsfields', 4, 1),
(35, 'By Information', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'information', 'xius_proximity_latitude=33\nxius_proximity_longitude=34\nxius_default_location=none\nxiusProximityDefaultLat=28.635308\nxiusProximityDefaultLong=77.22496\nxiusDefaultDistance=10\nxiusDefaultDistanceUnit=miles\nxiusProximityGmapZoom=2\n\n', 'Proximity', 3, 1),
(33, 'latitude', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'latitude', '', 'Jsuser', 1, 1),
(34, 'longitude', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'longitude', '', 'Jsuser', 2, 1);;


INSERT INTO `au_#__xius_info` (`id`,`labelName` , `params`, `key`,`pluginParams`,`pluginType`,`ordering`,`published`) VALUES
(42, 'name', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', 'name', '', 'Joomla', 10, 1),
(44, 'Birthdate', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\njs_privacy=public\n\n', '3', '', 'Jsfields', 12, 1);;


TRUNCATE TABLE `#__community_fields`;;
-- ALTER TABLE `#__community_fields` AUTO_INCREMENT=1;;

/* add data into community_fields table */
INSERT INTO `#__community_fields`(`id`,`type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`) 
VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basic information for user', 1, 1, 1, 1, '', ''),
(2, 'select', 2, 1, 10, 100, 'Gender', 'Select gender', 1, 1, 1, 1, 'Male\nFemale', 'FIELD_GENDER'),
(3, 'date', 3, 1, 10, 100, 'Birthday', 'Enter your date of birth so other users can know when to wish you happy birthday ', 1, 1, 1, 1, '', 'FIELD_BIRTHDAY'),
(4, 'text', 4, 1, 5, 250, 'Hometown', 'Hometown', 1, 1, 1, 1, '', 'FIELD_HOMETOWN'),
(5, 'textarea', 5, 1, 1, 800, 'About me', 'Tell us more about yourself', 1, 1, 1, 1, '', 'FIELD_ABOUTME'),
(6, 'group', 6, 1, 10, 100, 'Contact Information', 'Specify your contact details', 1, 1, 1, 1, '', ''),
(7, 'text', 7, 1, 10, 100, 'Mobile phone', 'Mobile carrier number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_MOBILE'),
(8, 'text', 8, 1, 10, 100, 'Land phone', 'Contact number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_LANDPHONE'),
(9, 'textarea', 9, 1, 10, 100, 'Address', 'Address', 1, 1, 1, 1, '', 'FIELD_ADDRESS'),
(10, 'text', 10, 1, 10, 100, 'State', 'State', 1, 1, 1, 1, '', 'FIELD_STATE'),
(11, 'text', 11, 1, 10, 100, 'City / Town', 'City / Town', 1, 1, 1, 1, '', 'FIELD_CITY'),
(12, 'select', 12, 1, 10, 100, 'Country', 'Country', 1, 1, 1, 1, 'Afghanistan\nAlbania\nAlgeria\nAmerican Samoa\nAndorra\nAngola\nAnguilla\nAntarctica\nAntigua and Barbuda\nArgentina\nArmenia\nAruba', 'FIELD_COUNTRY'),
(13, 'text', 13, 1, 10, 100, 'Website', 'Website', 1, 1, 1, 1, '', 'FIELD_WEBSITE'),
(14, 'group', 14, 1, 10, 100, 'Education', 'Educations', 1, 1, 1, 1, '', ''),
(15, 'text', 15, 1, 10, 200, 'College / University', 'College / University', 1, 1, 1, 1, '', 'FIELD_COLLEGE'),
(16, 'text', 16, 1, 5, 100, 'Graduation Year', 'Graduation year', 1, 1, 1, 1, '', 'FIELD_GRADUATION'),
(17, 'checkbox', 2, 1, 10, 100, 'Checkbox1', 'Checkbox1', 1, 1, 1, 1, 'Checkbox1\nCheckbox11\nCheckbox2\nCheckbox21\nCheckbox', 'Checkbox1');;
