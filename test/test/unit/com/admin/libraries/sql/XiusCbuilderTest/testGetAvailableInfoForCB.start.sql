TRUNCATE TABLE `#__comprofiler_fields`;;
ALTER TABLE `#__comprofiler_fields` AUTO_INCREMENT=1;;

/* add data into community_fields table */
INSERT INTO `#__comprofiler_fields` (`fieldid`, `name`, `tablecolumns`, `table`, `title`, `description`, `type`, `maxlength`, `size`, `required`, `tabid`, `ordering`, `cols`, `rows`, `value`, `default`, `published`, `registration`, `profile`, `displaytitle`, `readonly`, `searchable`, `calculated`, `sys`, `pluginid`, `params`) 
VALUES
(41, 'name', 'name', '#__users', '_UE_NAME', '_UE_REGWARN_NAME', 'predefined', NULL, NULL, 1, 11, -51, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0, 1, 1, 1, 1, NULL),
(26, 'onlinestatus', '', '#__comprofiler', '_UE_ONLINESTATUS', '', 'status', NULL, NULL, 0, 21, -21, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 0, 1, 1, 1, NULL),
(27, 'lastvisitDate', 'lastvisitDate', '#__users', '_UE_LASTONLINE', '', 'datetime', NULL, NULL, 0, 21, -19, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 0, 1, 1, 1, 'field_display_by=2'),
(28, 'registerDate', 'registerDate', '#__users', '_UE_MEMBERSINCE', '', 'datetime', NULL, NULL, 0, 21, -20, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 0, 1, 1, 1, 'field_display_by=2'),
(29, 'avatar', 'avatar,avatarapproved', '#__comprofiler', '_UE_IMAGE', '', 'image', NULL, NULL, 0, 20, 1, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 0, 0, 1, 1, 1, NULL),
(42, 'username', 'username', '#__users', '_UE_UNAME', '_UE_VALID_UNAME', 'predefined', NULL, NULL, 1, 11, -46, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0, 1, 1, 1, 1, NULL),
(45, 'formatname', '', '#__comprofiler', '_UE_FORMATNAME', '', 'formatname', NULL, NULL, 0, 11, -52, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, 0, 1, 1, 1, NULL),
(46, 'firstname', 'firstname', '#__comprofiler', '_UE_YOUR_FNAME', '_UE_REGWARN_FNAME', 'predefined', NULL, NULL, 1, 11, -50, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0, 0, 1, 1, 1, NULL),
(47, 'middlename', 'middlename', '#__comprofiler', '_UE_YOUR_MNAME', '_UE_REGWARN_MNAME', 'predefined', NULL, NULL, 0, 11, -49, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0, 0, 1, 1, 1, NULL),
(48, 'lastname', 'lastname', '#__comprofiler', '_UE_YOUR_LNAME', '_UE_REGWARN_LNAME', 'predefined', NULL, NULL, 1, 11, -48, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0, 0, 1, 1, 1, NULL),
(49, 'lastupdatedate', 'lastupdatedate', '#__comprofiler', '_UE_LASTUPDATEDON', '', 'datetime', NULL, NULL, 0, 21, -18, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 0, 1, 1, 1, 'field_display_by=2'),
(50, 'email', 'email', '#__users', '_UE_EMAIL', '_UE_REGWARN_MAIL', 'primaryemailaddress', NULL, NULL, 1, 11, -47, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0, 0, 1, 1, 1, NULL),
(25, 'hits', 'hits', '#__comprofiler', '_UE_HITS', '_UE_HITS_DESC', 'counter', NULL, NULL, 0, 21, -22, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 0, 1, 1, 1, NULL),
(51, 'password', 'password', '#__users', '_UE_PASS', '_UE_VALID_PASS', 'password', 50, NULL, 1, 11, -45, NULL, NULL, NULL, NULL, 1, 1, 0, 1, 0, 0, 1, 1, 1, NULL),
(52, 'params', 'params', '#__users', '_UE_USERPARAMS', '', 'userparams', NULL, NULL, 0, 11, -30, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, 0, 1, 1, 1, NULL),
(24, 'connections', '', '#__comprofiler', '_UE_CONNECTION', '', 'connections', NULL, NULL, 0, 21, -17, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 0, 1, 1, 1, NULL),
(23, 'forumrank', '', '#__comprofiler', '_UE_FORUM_FORUMRANKING', '', 'forumstats', NULL, NULL, 0, 21, -16, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 0, 1, 1, 4, NULL),
(22, 'forumposts', '', '#__comprofiler', '_UE_FORUM_TOTALPOSTS', '', 'forumstats', NULL, NULL, 0, 21, -15, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 0, 1, 1, 4, NULL),
(21, 'forumkarma', '', '#__comprofiler', '_UE_FORUM_KARMA', '', 'forumstats', NULL, NULL, 0, 21, -14, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, 0, 1, 1, 4, NULL),
(54, 'cb_trial', 'cb_trial', '#__comprofiler', 'Trial', '<p>trial</p>', 'text', 0, 0, 0, 11, -29, 0, 0, NULL, '', 1, 1, 1, 1, 0, 0, 0, 0, 1, 'fieldMinLength=0\nfieldValidateExpression=\npregexp=/^.*$/\npregexperror=Not a valid input\nfieldValidateForbiddenList_register=http:,https:,mailto:,//.[url],<a,</a>,&#\nfieldValidateForbiddenList_profile='),
(55, 'cb_trialdate', 'cb_trialdate', '#__comprofiler', 'Trial Date', '<p>Trial Date</p>', 'date', 0, 0, 0, 11, -28, 0, 0, NULL, '', 1, 1, 1, 1, 0, 0, 0, 0, 1, 'year_min=-110\nyear_max=+25\nfield_display_by=0\nfield_display_years_text=1\nfield_display_ago_text=1\nfield_search_by=0\nduration_title=\nshow_date_time=0');;


TRUNCATE TABLE `#__comprofiler`;;
ALTER TABLE `#__comprofiler` AUTO_INCREMENT=1;;
