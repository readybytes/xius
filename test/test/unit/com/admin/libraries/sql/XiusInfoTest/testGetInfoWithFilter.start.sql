TRUNCATE TABLE `#__xius_info`;
ALTER TABLE `#__xius_info` AUTO_INCREMENT=1;

INSERT INTO `#__xius_info` (`id`,`labelName`,`params`,`key`,`pluginParams`,`pluginType`,`ordering`,`published`) VALUES
(1, 'Gender', '', '2', '','Jsfields',1,1),
(2, 'City', '', '11', '','Jsfields',2,0),
(3, 'Country', '', '12','', 'Jsfields',3,1);
