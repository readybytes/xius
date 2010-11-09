TRUNCATE TABLE `#__xipt_profilefields`;;

INSERT INTO `#__xipt_profilefields` (`id`, `fid`, `pid`, `category`) VALUES
(1, 22, 1, 0),
(2, 22, 3, 0),
(3, 22, 4, 0),
(4, 23, 1, 0),
(5, 23, 4, 0),
(6, 24, 1, 0),
(7, 24, 4, 0),
(8, 25, 1, 0),
(9, 25, 4, 0),
(10, 26, 1, 0),
(11, 26, 4, 0),
(12, 27, 1, 0),
(13, 27, 4, 0),
(14, 18, 1, 0),
(15, 18, 3, 0),
(16, 18, 4, 0),
(17, 2, 2, 0),
(18, 2, 3, 0),
(19, 2, 4, 0),
(20, 21, 1, 0),
(21, 21, 2, 0),
(22, 21, 4, 0);;

TRUNCATE TABLE `#__community_fields` ;;
INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `options`, `fieldcode`, `regshow`, `registration`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basic information for user', 1, 1, 1, '', '', 1, 1),
(2, 'select', 7, 1, 10, 100, 'Gender', 'Select gender', 1, 1, 1, 'Male\nFemale', 'FIELD_GENDER', 1, 1),
(3, 'date', 8, 1, 10, 100, 'Birthday', 'Enter your date of birth so other users can know when to wish you happy birthday ', 1, 1, 1, '', 'FIELD_BIRTHDAY', 1, 1),
(4, 'text', 9, 1, 5, 250, 'Hometown', 'Hometown', 1, 1, 1, '', 'FIELD_HOMETOWN', 1, 1),
(5, 'textarea', 10, 1, 1, 800, 'About me', 'Tell us more about yourself', 1, 1, 1, '', 'FIELD_ABOUTME', 1, 1),
(6, 'group', 11, 1, 10, 100, 'Contact Information', 'Specify your contact details', 1, 1, 1, '', '', 1, 1),
(7, 'text', 12, 1, 10, 100, 'Mobile phone', 'Mobile carrier number that other users can contact you.', 1, 0, 1, '', 'FIELD_MOBILE', 1, 1),
(8, 'text', 13, 1, 10, 100, 'Land phone', 'Contact number that other users can contact you.', 1, 0, 1, '', 'FIELD_LANDPHONE', 1, 1),
(9, 'textarea', 14, 1, 10, 100, 'Address', 'Address', 1, 1, 1, '', 'FIELD_ADDRESS', 1, 1),
(10, 'text', 15, 1, 10, 100, 'State', 'State', 1, 1, 1, '', 'FIELD_STATE', 1, 1),
(11, 'text', 16, 1, 10, 100, 'City / Town', 'City / Town', 1, 1, 1, '', 'FIELD_CITY', 1, 1),
(12, 'select', 17, 1, 10, 100, 'Country', 'Country', 1, 1, 1, 'Afghanistan\nAlbania\nAlgeria\nAmerican Samoa\nAndorra\nAngola\nAnguilla\nAntarctica\nAntigua and Barbuda\nArgentina\nArmenia\nAruba\nIndia', 'FIELD_COUNTRY', 1, 1),
(13, 'text', 18, 1, 10, 100, 'Website', 'Website', 1, 1, 1, '', 'FIELD_WEBSITE', 1, 1),
(14, 'group', 19, 1, 10, 100, 'Education', 'Educations', 1, 1, 1, '', '', 1, 1),
(15, 'text', 20, 1, 10, 200, 'College / University', 'College / University', 1, 1, 1, '', 'FIELD_COLLEGE', 1, 1),
(16, 'text', 21, 1, 5, 100, 'Graduation Year', 'Graduation year', 1, 1, 1, '', 'FIELD_GRADUATION', 1, 1),
(17, 'checkbox', 7, 1, 10, 100, 'Checkbox1', 'Checkbox1', 1, 1, 1, 'Checkbox1\nCheckbox11\nCheckbox2\nCheckbox21\nCheckbox', 'Checkbox1', 1, 1),
(18, 'checkbox', 6, 1, 10, 100, 'Chekbox', '', 1, 1, 1, 'A\nB\nC\nD\nE', 'CHK_BOX', 1, 1),
(19, 'templates', 5, 1, 10, 100, 'Template', 'Template Of User', 1, 1, 1, '', 'XIPT_TEMPLATE', 1, 1),
(20, 'profiletypes', 4, 1, 10, 100, 'Profiletype', 'Profiletype Of User', 1, 1, 1, '', 'XIPT_PROFILETYPE', 1, 1),
(21, 'list', 3, 1, 10, 100, 'Multi', '', 1, 1, 1, 'A\nB\nC\nD\nE', 'mULTI', 1, 1),
(22, 'radio', 2, 1, 10, 100, 'RADIO', 'A', 1, 1, 1, 'A\nB\nC\nD', 'RaSIO', 1, 1);;


TRUNCATE TABLE `#__xipt_settings` ;;

INSERT INTO `#__xipt_settings` (`name`, `params`) VALUES
('settings', 'show_ptype_during_reg=1\nallow_user_to_change_ptype_after_reg=1\ndefaultProfiletypeID=1\nguestProfiletypeID=1\njspt_show_radio=1\njspt_fb_show_radio=0\nallow_templatechange=1\nshow_watermark=0\njspt_block_dis_app=0\naec_integrate=0\naec_message=b\njspt_restrict_reg_check=0\njspt_prevent_username=\njspt_allowed_email=\njspt_prevent_email=\n\n');;
