TRUNCATE TABLE `#__users`;;
INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`) VALUES
(62, 'Administrator', 'admin', 'shyam@readybytes.in', '6a8c2b2fbc4ee1b4f3f042009d8a22f3:K5wzjZ3SlgIYTVPMaKt0wE0w6JUEJ2Bm', 'Super Administrator', 0, 1, 25, '2009-10-27 14:21:57', '2010-09-18 09:52:11', '', '\n'),
(63, 'user10', 'username10', 'username@gmail.com', 'c48522e405aecc2af0502bb86b3a81fe:lk6GGMRvyFaAC8XEBu2wdExeiGEH2xeR', 'Registered', 0, 0, 18, '2010-09-18 09:53:34', '2010-09-20 04:29:39', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(64, 'user20', 'username20', 'username20@gmail.com', 'a682af8305db6e35899969ec1bcbc996:nid4508jks8yyjbe2T72INW81oJsz2cu', 'Administrator', 0, 0, 24, '2010-09-18 09:57:25', '2010-09-20 05:25:16', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(65, 'user30', 'username30', 'username30@gmail.com', '18443743cce2d58de0febf5049ee4edc:yF3HncKm5jXPEYOZgo807tmuk1oXB8Ge', 'Manager', 0, 0, 23, '2010-09-18 09:58:19', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(66, 'user40', 'username40', 'username40@gmail.com', '16124598883815e42ee1b250158071f5:lXjcAuyWmtiMKDlkaGV2EE4qfpyGCjGv', 'Publisher', 0, 0, 21, '2010-09-18 09:59:18', '2010-09-20 05:25:45', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(67, 'user50', 'username50', 'username50@gmail.com', '37f8787ef4eee71e347cbf1b4cf58a9b:GvJ4p6zDbdUfdaZRIq5pT18RWk0ul9u1', 'Registered', 0, 0, 18, '2010-09-18 10:00:37', '2010-09-20 05:03:26', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(68, 'user60', 'username60', 'username60@gmail.com', '63dda07f978e06b3c2d6a29c119f15a1:xmANVPp88K8wy8HlREAGRXYvvyg21JnX', 'Administrator', 0, 0, 24, '2010-09-18 10:01:18', '2010-09-20 04:44:53', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(70, 'user80', 'username80', 'username80@gmail.com', '2f1da49660643038b13e140816bd93a4:BILU5GNNRB2HhEQUZsuvadJhSMm60EXC', 'Registered', 0, 0, 18, '2010-09-18 10:38:34', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(69, 'user70', 'username70', 'username70@gmail.com', '93581e8a48b8b5b1b9b8e9c3ad89eca9:LzdhENAa1Axo5nmoRl7bLOeatoSqUxXR', 'Registered', 0, 0, 18, '2010-09-18 10:29:15', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n');;


TRUNCATE TABLE `#__core_acl_aro`;;
INSERT INTO `#__core_acl_aro` (`id`, `section_value`, `value`, `order_value`, `name`, `hidden`) VALUES
(10, 'users', '62', 0, 'Administrator', 0),
(11, 'users', '63', 0, 'user10', 0),
(12, 'users', '64', 0, 'user20', 0),
(13, 'users', '65', 0, 'user30', 0),
(14, 'users', '66', 0, 'user40', 0),
(15, 'users', '67', 0, 'user50', 0),
(16, 'users', '68', 0, 'user60', 0),
(17, 'users', '69', 0, 'user70', 0),
(18, 'users', '70', 0, 'user80', 0);;
