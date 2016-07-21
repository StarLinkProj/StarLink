-- Extension specific tables
DROP TABLE IF EXISTS `#__foxcontact_settings`;
DROP TABLE IF EXISTS `#__foxcontact_captcha`;

-- It's up to Joomla to remove the following entries, but as in 1.6 series it sometimes failed, it's safer to force the cleanup

-- Assets
DELETE FROM `#__assets` WHERE `name` = 'com_foxcontact';

-- Installed extension
DELETE FROM `#__extensions` WHERE `element` = 'com_foxcontact';

-- Administrator menu item and Site menu items
DELETE FROM `#__menu` WHERE `link` LIKE '%com_foxcontact%';

-- Joomla auto updater
DELETE FROM `#__update_sites` WHERE `name` LIKE '%foxcontact%';
