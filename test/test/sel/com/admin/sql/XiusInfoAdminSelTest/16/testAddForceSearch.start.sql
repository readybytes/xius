TRUNCATE TABLE `#__community_fields`;;
INSERT INTO `#__community_fields` (`id`, `type`, `ordering`, `published`, `min`, `max`, `name`, `tips`, `visible`, `required`, `searchable`, `registration`, `options`, `fieldcode`, `params`) VALUES
(1, 'group', 1, 1, 10, 100, 'Basic Information', 'Basic information for user', 1, 0, 1, 1, '', '', ''),
(2, 'select', 3, 1, 10, 100, 'Gender', 'Select gender', 1, 0, 1, 1, 'Male\nFemale', 'FIELD_GENDER', ''),
(3, 'birthdate', 4, 1, 10, 100, 'Birthdate', 'Enter your date of birth so other users can know when to wish you happy birthday ', 1, 0, 1, 1, '', 'FIELD_BIRTHDATE', ''),
(4, 'textarea', 5, 1, 1, 800, 'About me', 'Tell us more about yourself', 1, 0, 1, 1, '', 'FIELD_ABOUTME', ''),
(5, 'group', 6, 1, 10, 100, 'Contact Information', 'Specify your contact details', 1, 0, 1, 1, '', '', ''),
(6, 'text', 7, 1, 10, 100, 'Mobile phone', 'Mobile carrier number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_MOBILE', ''),
(7, 'text', 8, 1, 10, 100, 'Land phone', 'Contact number that other users can contact you.', 1, 0, 1, 1, '', 'FIELD_LANDPHONE', ''),
(8, 'textarea', 9, 1, 10, 100, 'Address', 'Your Address', 1, 0, 1, 1, '', 'FIELD_ADDRESS', ''),
(9, 'text', 10, 1, 10, 100, 'State', 'Your state', 1, 0, 1, 1, '', 'FIELD_STATE', ''),
(10, 'text', 11, 1, 10, 100, 'City / Town', 'Your city or town name', 1, 0, 1, 1, '', 'FIELD_CITY', ''),
(11, 'country', 12, 1, 10, 100, 'Country', 'Your country', 1, 0, 1, 1, 'Afghanistan\nAlbania\nAlgeria\nAmerican Samoa\nAndorra\nAngola\nAnguilla\nAntarctica\nAntigua and Barbuda\nArgentina\nArmenia\nAruba\nAustralia\nAustria\nAzerbaijan\nBahamas\nBahrain\nBangladesh\nBarbados\nBelarus\nBelgium\nBelize\nBenin\nBermuda\nBhutan\nBolivia\nBosnia and Herzegovina\nBotswana\nBouvet Island\nBrazil\nBritish Indian Ocean Territory\nBrunei Darussalam\nBulgaria\nBurkina Faso\nBurundi\nCambodia\nCameroon\nCanada\nCape Verde\nCayman Islands\nCentral African Republic\nChad\nChile\nChina\nChristmas Island\nCocos (Keeling) Islands\nColombia\nComoros\nCongo\nCook Islands\nCosta Rica\nCote D''Ivoire (Ivory Coast)\nCroatia (Hrvatska)\nCuba\nCyprus\nCzechoslovakia (former)\nCzech Republic\nDenmark\nDjibouti\nDominica\nDominican Republic\nEast Timor\nEcuador\nEgypt\nEl Salvador\nEquatorial Guinea\nEritrea\nEstonia\nEthiopia\nFalkland Islands (Malvinas)\nFaroe Islands\nFiji\nFinland\nFrance\nFrance, Metropolitan\nFrench Guiana\nFrench Polynesia\nFrench Southern Territories\nGabon\nGambia\nGeorgia\nGermany\nGhana\nGibraltar\nGreat Britain (UK)\nGreece\nGreenland\nGrenada\nGuadeloupe\nGuam\nGuatemala\nGuinea\nGuinea-Bissau\nGuyana\nHaiti\nHeard and McDonald Islands\nHonduras\nHong Kong\nHungary\nIceland\nIndia\nIndonesia\nIran\nIraq\nIreland\nIsrael\nItaly\nJamaica\nJapan\nJordan\nKazakhstan\nKenya\nKiribati\nKorea, North\nSouth Korea\nKuwait\nKyrgyzstan\nLaos\nLatvia\nLebanon\nLesotho\nLiberia\nLibya\nLiechtenstein\nLithuania\nLuxembourg\nMacau\nMacedonia\nMadagascar\nMalawi\nMalaysia\nMaldives\nMali\nMalta\nMarshall Islands\nMartinique\nMauritania\nMauritius\nMayotte\nMexico\nMicronesia\nMoldova\nMonaco\nMongolia\nMontserrat\nMorocco\nMozambique\nMyanmar\nNamibia\nNauru\nNepal\nNetherlands\nNetherlands Antilles\nNeutral Zone\nNew Caledonia\nNew Zealand\nNicaragua\nNiger\nNigeria\nNiue\nNorfolk Island\nNorthern Mariana Islands\nNorway\nOman\nPakistan\nPalau\nPanama\nPapua New Guinea\nParaguay\nPeru\nPhilippines\nPitcairn\nPoland\nPortugal\nPuerto Rico\nQatar\nReunion\nRomania\nRussian Federation\nRwanda\nSaint Kitts and Nevis\nSaint Lucia\nSaint Vincent and the Grenadines\nSamoa\nSan Marino\nSao Tome and Principe\nSaudi Arabia\nSenegal\nSeychelles\nS. Georgia and S. Sandwich Isls.\nSierra Leone\nSingapore\nSlovak Republic\nSlovenia\nSolomon Islands\nSomalia\nSouth Africa\nSpain\nSri Lanka\nSt. Helena\nSt. Pierre and Miquelon\nSudan\nSuriname\nSvalbard and Jan Mayen Islands\nSwaziland\nSweden\nSwitzerland\nSyria\nTaiwan\nTajikistan\nTanzania\nThailand\nTogo\nTokelau\nTonga\nTrinidad and Tobago\nTunisia\nTurkey\nTurkmenistan\nTurks and Caicos Islands\nTuvalu\nUganda\nUkraine\nUnited Arab Emirates\nUnited Kingdom\nUnited States\nUruguay\nUS Minor Outlying Islands\nUSSR (former)\nUzbekistan\nVanuatu\nVatican City State (Holy Sea)\nVenezuela\nViet Nam\nVirgin Islands (British)\nVirgin Islands (U.S.)\nWallis and Futuna Islands\nWestern Sahara\nYemen\nYugoslavia\nZaire\nZambia\nZimbabwe', 'FIELD_COUNTRY', ''),
(12, 'url', 13, 1, 10, 100, 'Website', 'Your website', 1, 0, 1, 1, '', 'FIELD_WEBSITE', ''),
(13, 'group', 14, 1, 10, 100, 'Education', 'Educations', 1, 0, 1, 1, '', '', ''),
(14, 'text', 15, 1, 10, 200, 'College / University', 'Your college or university name', 1, 0, 1, 1, '', 'FIELD_COLLEGE', ''),
(15, 'text', 16, 1, 5, 100, 'Graduation Year', 'Graduation year', 1, 0, 1, 1, '', 'FIELD_GRADUATION', ''),
(16, 'checkbox', 2, 1, 10, 100, 'checkbox1', '', 1, 1, 1, 1, 'checkbox1\ncheckbox2\ncheckbox11\ncheckbox12\ncheckbox', 'field16', '{"disabled":"0","readonly":"0","style":""}');;

TRUNCATE TABLE `#__xius_info`;;

DROP TABLE IF EXISTS `au_#__xius_info`;;
CREATE TABLE `au_#__xius_info` SELECT * FROM `#__xius_info`;;

INSERT INTO `#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'Gender', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '2', '', 'Jsfields', 1, 1),
(2, 'City', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', '', 'Jsfields', 2, 1),
(3, 'Country', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '12', '', 'Jsfields', 3, 1),
(4, 'Register Date', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'registerDate', '', 'Joomla', 4, 1),
(5, 'Username', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=1\n\n', 'username', '', 'Joomla', 5, 1),
(6, 'Name', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'name', '', 'Joomla', 6, 1),
(7, 'Checkbox1', 'isSearchable="1"\nisVisible="0"\nisSortable="1"\nisAccessible="a:1:{i:0;s:3:"All";}"\nisExportable="0"\ntooltip=""\njs_privacy="public"', '16', '', 'Jsfields', 7, 1),
(8, 'Birthday', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '3', '', 'Jsfields', 8, 1),
(9, 'ID', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'id', '', 'Joomla', 9, 1),
(10, 'E-mail', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'email', '', 'Joomla', 10, 1),
(11, 'usertype', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'usertype', '', 'Joomla', 11, 1),
(12, 'Block', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'block', '', 'Joomla', 12, 1),
(13, 'lastvisitDate', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'lastvisitDate', '', 'Joomla', 13, 1),
(14, 'Block should be 0', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '12', 'infoid=12\nvalue=s:1:"0";\noperator==\n\n', 'Forcesearch', 14, 1),
(15, 'All Female', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '1', 'infoid=1\nvalue=s:6:"Female";\noperator==\n\n', 'Forcesearch', 15, 1),
(16, 'Super Admin should not be visible', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', 'infoid=11\nvalue=s:19:"Super Administrator";\noperator==\n\n', 'Forcesearch', 16, 0);;

INSERT INTO `au_#__xius_info` (`id`, `labelName`, `params`, `key`, `pluginParams`, `pluginType`, `ordering`, `published`) VALUES
(1, 'Gender', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '2', '', 'Jsfields', 1, 1),
(2, 'City', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', '', 'Jsfields', 2, 1),
(3, 'Country', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '12', '', 'Jsfields', 3, 1),
(4, 'Register Date', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'registerDate', '', 'Joomla', 4, 1),
(5, 'Username', 'isSearchable=1\nisVisible=0\nisSortable=1\nisExportable=1\n\n', 'username', '', 'Joomla', 5, 1),
(6, 'Name', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'name', '', 'Joomla', 6, 1),
(7, 'Checkbox1', 'isSearchable="1"\nisVisible="0"\nisSortable="1"\nisAccessible="a:1:{i:0;s:3:"All";}"\nisExportable="0"\ntooltip=""\njs_privacy="public"', '16', '', 'Jsfields', 7, 1),
(8, 'Birthday', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '3', '', 'Jsfields', 8, 1),
(9, 'ID', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'id', '', 'Joomla', 9, 1),
(10, 'E-mail', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'email', '', 'Joomla', 10, 1),
(11, 'usertype', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'usertype', '', 'Joomla', 11, 1),
(12, 'Block', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'block', '', 'Joomla', 12, 1),
(13, 'lastvisitDate', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', 'lastvisitDate', '', 'Joomla', 13, 1),
(14, 'Block should be 0', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '12', 'infoid=12\nvalue=s:1:"0";\noperator==\n\n', 'Forcesearch', 14, 1),
(15, 'All Female', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '1', 'infoid=1\nvalue=s:6:"Female";\noperator==\n\n', 'Forcesearch', 15, 1),
(16, 'Super Admin should not be visible', 'isSearchable=1\nisVisible=1\nisSortable=1\nisExportable=1\n\n', '11', 'infoid=11\nvalue=s:19:"Super Administrator";\noperator==\n\n', 'Forcesearch', 16, 0),
(17, 'Register Date Should be 10 Jun 2009', 'isSearchable="0"\nisVisible="0"\nisSortable="1"\nisAccessible="a:1:{i:0;s:3:"All";}"\nisExportable="0"\ntooltip=""\nxipt_privacy="a:1:{i:0;s:1:"0";}"\njs_privacy="public"', '4', 'infoid="4"\nvalue="s:10:"10-06-2009";"\noperator="="', 'Forcesearch', 17, 1),
(18, 'Checkbox1 value should be checkbox11 and checkbox', 'isSearchable="0"\nisVisible="0"\nisSortable="0"\nisAccessible="a:1:{i:0;s:3:"All";}"\nisExportable="0"\ntooltip=""\nxipt_privacy="a:1:{i:0;s:1:"0";}"\njs_privacy="public"', '7', 'infoid="7"\nvalue="a:2:{i:0;s:10:"checkbox11";i:1;s:8:"checkbox";}"\noperator="="', 'Forcesearch', 18, 0);;
