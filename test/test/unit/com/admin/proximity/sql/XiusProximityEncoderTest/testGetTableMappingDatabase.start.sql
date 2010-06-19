TRUNCATE TABLE `#__xius_info`;;
INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(2, 'City', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', '', 'Jsfields', 2, 1),
(3, 'Country', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '12', '', 'Jsfields', 3, 1),
(4, 'Gender', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '2', '', 'Jsfields', 4, 1),
(5, 'Name', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', 'name', '', 'Joomla', 5, 1),
(6, 'Geocoding', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=0\ntooltip=\n\n', '0', 'xius_proximity_encoding=Database\nxius_proximity_latitude=\nxius_proximity_country=3\nxius_proximity_zipcode=\nxius_proximity_state=\nxius_proximity_city=2\nxius_gmap_key=\nxius_proximity_table=#__xius_proximity\nxius_proximity_zipcode_column=zipcode\nxius_proximity_country_column=country\nxius_proximity_state_column=state\nxius_proximity_city_column=city\nxius_proximity_lat_column=latitude\nxius_proximity_long_column=longitude\n\n', 'Proximity', 3, 1);;

