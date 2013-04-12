TRUNCATE TABLE `#__modules`;;
INSERT INTO `#__modules` SELECT * FROM `bak_#__modules`;;

TRUNCATE TABLE `#__modules_menu`;;
INSERT INTO `#__modules_menu` SELECT * FROM `bak_#__modules_menu`;;
