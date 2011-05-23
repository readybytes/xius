TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@joomlaxi.com', 'aa95a2cb1a9bd63f349a7fb72502489c:IXZhjkhVI11TgPm5YIVeHNcJTH8HbIKs', 'Super Administrator', 0, 1, 25, '2010-01-16 11:12:08', '2010-08-05 11:38:21', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(63, 'name64', 'username64', 'username64@email.com', '57048e7e51be27d034ad468671229b86:Fzk4eZv9djbjLoqnjRX49t5GERYcY5Fx', 'Registered', 0, 0, 18, '2010-05-20 10:31:50', '0000-00-00 00:00:00', '', 'language=\ntimezone=0\n\n'),
(64, 'name65', 'username65', 'username65@email.com', 'c6760cbc8fbb0d3b330cda62f14d4df8:6xApyV7UoTXhZFvW6d9jLT9N4A8WlaQL', 'Registered', 0, 0, 18, '2010-05-20 10:32:10', '0000-00-00 00:00:00', '', 'language=\ntimezone=0\n\n'),
(65, 'name66', 'username66', 'username66@email.com', 'a8fe0feb870e88548181583c41024e4e:saL5B5BG20caRLo60ynhCKbAZw8WIWtn', 'Registered', 0, 0, 18, '2010-05-20 10:32:10', '0000-00-00 00:00:00', '', 'language=\ntimezone=0\n\n'),
(66, 'name67', 'username67', 'username67@email.com', '10aaf84f6822970768033aed4c6c5ad7:Y33vW30BKxxKJgguIKxhOMazhh2j9GlT', 'Registered', 0, 0, 18, '2010-05-20 10:32:10', '0000-00-00 00:00:00', '', 'language=\ntimezone=0\n\n'),
(67, 'name68', 'username68', 'username68@email.com', '63b3c955bf392b75648c6ef504d377e6:ngmtwZt85QNej2f0qnMxEYCLzkcTTN3n', 'Registered', 0, 0, 18, '2010-05-20 10:32:10', '0000-00-00 00:00:00', '', 'language=\ntimezone=0\n\n'),
(68, 'name69', 'username69', 'username69@email.com', 'f1272d04850d66ac8f02081443af7e64:iCQx3wHAXABo5fs1IlR5gYMUYINmCwQk', 'Registered', 0, 0, 18, '2010-05-20 10:32:10', '0000-00-00 00:00:00', '', 'language=\ntimezone=0\n\n');;

TRUNCATE TABLE `#__core_acl_aro`;;
INSERT INTO `#__core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0),
(11, 'users', '63', 0, 'name64', 0),
(12, 'users', '64', 0, 'name65', 0),
(13, 'users', '65', 0, 'name66', 0),
(14, 'users', '66', 0, 'name67', 0),
(15, 'users', '67', 0, 'name68', 0),
(16, 'users', '68', 0, 'name69', 0);;
