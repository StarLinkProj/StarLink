-- Remove the useless default module (unpublished, non positioned and assigned to no pages) automatically created during the module installation
DELETE FROM `#__modules` WHERE `module` = 'mod_foxcontact' AND `published` = 0;
