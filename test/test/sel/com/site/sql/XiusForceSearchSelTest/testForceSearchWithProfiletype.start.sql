/* XIUS INFO */

TRUNCATE TABLE `#__xius_info`;;

/* XIUS INFO */

TRUNCATE TABLE `#__xius_info`;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(9, 'Profiletype', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '19', '', 'Jsfields', 1, 1),
(10, 'E-mail', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\n\n', 'email', '', 'Joomla', 2, 1),
(11, 'Marital Status', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\n\n', '20', '', 'Jsfields', 3, 1),
(12, 'Gender', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\n\n', '2', '', 'Jsfields', 4, 1),
(13, 'ProfiletypeFS', 'isSearchable=1\nisVisible=0\nisSortable=1\nisAccessible=a:1:{i:0;s:3:"All";}\nisExportable=0\ntooltip=\n\n', '9', 'infoid=9\nvalue=s:1:"2";\noperator==\n\n', 'Forcesearch', 5, 1);;

TRUNCATE TABLE `#__community_fields`;;
INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `options`, `fieldcode`, `registration`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basic information for user', 1, 1, 1, '', '', 1),
(2, 'select', 5, 1, 10, 100, 'Gender', 'Select gender', 1, 1, 1, 'Male\nFemale', 'FIELD_GENDER', 1),
(3, 'date', 6, 1, 10, 100, 'Birthday', 'Enter your date of birth so other users can know when to wish you happy birthday ', 1, 1, 1, '', 'FIELD_BIRTHDAY', 1),
(4, 'text', 7, 1, 5, 250, 'Hometown', 'Hometown', 1, 1, 1, '', 'FIELD_HOMETOWN', 1),
(5, 'textarea', 8, 1, 1, 800, 'About me', 'Tell us more about yourself', 1, 1, 1, '', 'FIELD_ABOUTME', 1),
(6, 'group', 9, 1, 10, 100, 'Contact Information', 'Specify your contact details', 1, 1, 1, '', '', 1),
(7, 'text', 10, 1, 10, 100, 'Mobile phone', 'Mobile carrier number that other users can contact you.', 1, 0, 1, '', 'FIELD_MOBILE', 1),
(8, 'text', 11, 1, 10, 100, 'Land phone', 'Contact number that other users can contact you.', 1, 0, 1, '', 'FIELD_LANDPHONE', 1),
(9, 'textarea', 12, 1, 10, 100, 'Address', 'Address', 1, 1, 1, '', 'FIELD_ADDRESS', 1),
(10, 'text', 13, 1, 10, 100, 'State', 'State', 1, 1, 1, '', 'FIELD_STATE', 1),
(11, 'text', 14, 1, 10, 100, 'City / Town', 'City / Town', 1, 1, 1, '', 'FIELD_CITY', 1),
(12, 'select', 15, 1, 10, 100, 'Country', 'Country', 1, 1, 1, 'Afghanistan\nAlbania\nAlgeria\nAmerican Samoa\nAndorra\nAngola\nAnguilla\nAntarctica\nAntigua and Barbuda\nArgentina\nArmenia\nAruba', 'FIELD_COUNTRY', 1),
(13, 'text', 16, 1, 10, 100, 'Website', 'Website', 1, 1, 1, '', 'FIELD_WEBSITE', 1),
(14, 'group', 17, 1, 10, 100, 'Education', 'Educations', 1, 1, 1, '', '', 1),
(15, 'text', 18, 1, 10, 200, 'College / University', 'College / University', 1, 1, 1, '', 'FIELD_COLLEGE', 1),
(16, 'text', 19, 1, 5, 100, 'Graduation Year', 'Graduation year', 1, 1, 1, '', 'FIELD_GRADUATION', 1),
(17, 'checkbox', 5, 1, 10, 100, 'Checkbox1', 'Checkbox1', 1, 1, 1, 'Checkbox1\nCheckbox11\nCheckbox2\nCheckbox21\nCheckbox', 'Checkbox1', 1),
(18, 'templates', 4, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, '', 'XIPT_TEMPLATE', 1),
(19, 'profiletypes', 3, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, '', 'XIPT_PROFILETYPE', 1),
(20, 'select', 2, 1, 10, 100, 'Marital Status', '', 1, 1, 1, 'Single\nMarriage', 'NEW', 1);;


DROP TABLE IF EXISTS `#__xius_cache`;;

CREATE TABLE IF NOT EXISTS `#__xius_cache` (
  `userid` int(21) NOT NULL,
  `jsfields19_0` varchar(250) NOT NULL,
  `joomlaemail_0` varchar(250) NOT NULL,
  `jsfields20_0` varchar(250) NOT NULL,
  `jsfields2_0` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;;



INSERT INTO `#__xius_cache` (`userid`, `jsfields19_0`, `joomlaemail_0`, `jsfields20_0`, `jsfields2_0`) VALUES
(62, '1', 'shyam@joomlaxi.com', '', ''),
(63, '3', 'username64@email.com', '', ''),
(64, '1', 'username65@email.com', '', 'Female'),
(65, '1', 'username66@email.com', '', 'Female'),
(66, '1', 'username67@email.com', '', 'Male'),
(67, '1', 'username68@email.com', '', 'Male'),
(68, '1', 'username69@email.com', '', 'Female'),
(69, '1', 'username70@email.com', '', 'Female'),
(70, '1', 'username71@email.com', '', 'Female'),
(71, '1', 'username72@email.com', '', 'Female'),
(72, '1', 'username73@email.com', '', 'Female'),
(73, '1', 'username74@email.com', '', 'Male'),
(74, '1', 'username75@email.com', '', 'Female'),
(75, '1', 'username76@email.com', '', 'Male'),
(76, '1', 'username77@email.com', '', 'Male'),
(77, '1', 'username78@email.com', '', 'Male'),
(78, '2', 'username79@email.com', '', 'Female'),
(79, '1', 'username80@email.com', '', 'Female'),
(80, '1', 'username81@email.com', '', 'Female'),
(81, '1', 'username82@email.com', '', 'Male'),
(82, '1', 'username83@email.com', '', 'Male'),
(83, '1', 'username84@email.com', '', 'Female'),
(84, '2', 'username85@email.com', '', 'Female'),
(85, '2', 'username86@email.com', '', 'Male'),
(86, '2', 'username87@email.com', '', 'Female'),
(87, '1', 'username88@email.com', '', 'Female'),
(88, '1', 'username89@email.com', '', 'Female'),
(89, '1', 'username90@email.com', '', 'Male'),
(90, '1', 'username91@email.com', '', 'Female'),
(91, '1', 'username92@email.com', '', 'Female'),
(92, '1', 'username93@email.com', '', 'Male'),
(93, '1', 'username94@email.com', '', 'Female'),
(94, '2', 'username95@email.com', '', 'Male'),
(95, '1', 'username96@email.com', '', 'Female'),
(96, '1', 'username97@email.com', '', 'Male'),
(97, '1', 'username98@email.com', '', 'Female'),
(98, '1', 'username99@email.com', '', 'Female'),
(99, '1', 'username100@email.com', '', 'Male'),
(100, '1', 'username101@email.com', '', 'Male'),
(101, '1', 'username102@email.com', '', 'Male'),
(102, '1', 'username103@email.com', '', 'Female'),
(103, '1', 'username104@email.com', '', 'Male'),
(104, '1', 'username105@email.com', '', 'Male'),
(105, '1', 'username106@email.com', '', 'Female'),
(106, '1', 'username107@email.com', '', 'Male'),
(107, '1', 'username108@email.com', '', 'Male'),
(108, '1', 'username109@email.com', '', 'Male'),
(109, '1', 'username110@email.com', '', 'Male'),
(110, '1', 'username111@email.com', '', 'Male'),
(111, '1', 'username112@email.com', '', 'Male'),
(112, '1', 'username113@email.com', '', 'Male'),
(113, '1', 'username114@email.com', '', 'Male'),
(114, '1', 'username115@email.com', '', 'Female'),
(115, '1', 'username116@email.com', '', 'Female'),
(116, '1', 'username117@email.com', '', 'Female'),
(117, '1', 'username118@email.com', '', 'Female'),
(118, '1', 'username119@email.com', '', 'Female'),
(119, '1', 'username120@email.com', '', 'Male'),
(120, '1', 'username121@email.com', '', 'Male');;

TRUNCATE TABLE `#__xipt_profiletypes`;;

INSERT INTO `#__xipt_profiletypes` (`id`, `name`, `ordering`, `published`, `tip`, `privacy`, `template`, `jusertype`, `avatar`, `approve`, `allowt`, `group`, `watermark`, `params`, `watermarkparams`, `visible`, `config`) VALUES
(1, 'Free Member', 0, 1, 'If you are just want to explore the site, choose this type. Its free.', 'privacyprofile=20\n\n', 'default', 'Registered', 'components/com_community/assets/default.jpg', 0, 0, '4', '', '', '', 1, 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator, admin, support, owner, employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(2, 'Paid Subscriber', 1, 1, 'If you wish to subscribe for the paid components and services, choose this account type.', 'privacyprofile=30\n\n', 'default', 'Registered', 'images/profiletype/avatar_2.gif', 0, 1, '1', '', '', '', 1, 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator, admin, support, owner, employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(3, 'Serious Joomla User', 2, 1, 'Serious Joomla User, are the users who really want to motivate the joomla developers to enhance the joomla experience. When you subscribe to this plan, you support us by paying few $$.', 'privacyprofile=30\n\n', 'default', 'Registered', 'images/profiletype/avatar_3.png', 0, 0, '0', '', '', '', 1, 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator, admin, support, owner, employee\njspt_allowed_email=\njspt_prevent_email=\n\n'),
(4, 'Moderator', 3, 0, 'The members are moderating the website.', 'privacyprofile=30\n\n', 'default', 'Registered', '/images/avatar/a1f960fb81d15c26035a6808.jpg', 1, 0, '0', '', '', '', 1, 'jspt_restrict_reg_check=1\njspt_prevent_username=moderator, admin, support, owner, employee\njspt_allowed_email=\njspt_prevent_email=\n\n');;