-- It's up to Joomla to remove the following entries, but as in 1.6 series it sometimes failed, it's safer to force the cleanup

-- Installed modules
DELETE FROM `#__extensions` WHERE `element` = 'mod_foxcontact';

-- Site modules
DELETE FROM `#__modules` WHERE `module` = 'mod_foxcontact';

