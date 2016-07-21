if (typeof Fox == 'undefined')
{
	Fox = {};

	Fox.Strings =
	{
		add: function (object)
		{
			jQuery.extend(this, object);
			return this;
		}
	};

	Fox.Options =
	{
		// Fox.Options.add('key', {...});
		add: function (key, data)
		{
			var o = {};
			o[key] = data;
            jQuery.extend(this, o);
			return this;
		},

		// Return by copy: Fox.Options.get('key');
		// Return by reference: Fox.Options['key'];
		get: function (key)
		{
			return jQuery.extend({}, this[key]);
		}
	};
}


(function ()
{
	Fox.Strings.add(
		{
			JCANCEL: "<?php echo JText::_('JCANCEL') ?>",
			COM_FOXCONTACT_BROWSE_FILES: "<?php echo JText::_('COM_FOXCONTACT_BROWSE_FILES') ?>",
			COM_FOXCONTACT_FAILED: "<?php echo JText::_('COM_FOXCONTACT_FAILED') ?>",
			COM_FOXCONTACT_SUCCESS: "<?php echo JText::_('COM_FOXCONTACT_SUCCESS') ?>",
			COM_FOXCONTACT_NO_RESULTS_MATCH: "<?php echo JText::_('COM_FOXCONTACT_NO_RESULTS_MATCH') ?>",
			COM_FOXCONTACT_MULTIPLE_JQUERY: "<?php echo JText::_('COM_FOXCONTACT_MULTIPLE_JQUERY') ?>",
			COM_FOXCONTACT_READ_MORE: "<?php echo JText::_('COM_FOXCONTACT_READ_MORE') ?>",
			COM_FOXCONTACT_REMOVE_ALT: "<?php echo JText::_('COM_FOXCONTACT_REMOVE_ALT') ?>",
			COM_FOXCONTACT_REMOVE_TITLE: "<?php echo JText::_('COM_FOXCONTACT_REMOVE_TITLE') ?>",
			JURI_ROOT: "<?php echo JUri::root(true) ?>"
		}
	);

	Date.monthNames = ["<?php echo JText::_('JANUARY') ?>", "<?php echo JText::_('FEBRUARY') ?>", "<?php echo JText::_('MARCH') ?>", "<?php echo JText::_('APRIL') ?>", "<?php echo JText::_('MAY') ?>", "<?php echo JText::_('JUNE') ?>", "<?php echo JText::_('JULY') ?>", "<?php echo JText::_('AUGUST') ?>", "<?php echo JText::_('SEPTEMBER') ?>", "<?php echo JText::_('OCTOBER') ?>", "<?php echo JText::_('NOVEMBER') ?>", "<?php echo JText::_('DECEMBER') ?>"];
	Date.dayNames = ["<?php echo JText::_('SUNDAY') ?>", "<?php echo JText::_('MONDAY') ?>", "<?php echo JText::_('TUESDAY') ?>", "<?php echo JText::_('WEDNESDAY') ?>", "<?php echo JText::_('THURSDAY') ?>", "<?php echo JText::_('FRIDAY') ?>", "<?php echo JText::_('SATURDAY') ?>"];
	Date.monthNumbers = {
		"<?php echo JText::_('JANUARY') ?>": 0,
		"<?php echo JText::_('FEBRUARY') ?>": 1,
		"<?php echo JText::_('MARCH') ?>": 2,
		"<?php echo JText::_('APRIL') ?>": 3,
		"<?php echo JText::_('MAY') ?>": 4,
		"<?php echo JText::_('JUNE') ?>": 5,
		"<?php echo JText::_('JULY') ?>": 6,
		"<?php echo JText::_('AUGUST') ?>": 7,
		"<?php echo JText::_('SEPTEMBER') ?>": 8,
		"<?php echo JText::_('OCTOBER') ?>": 9,
		"<?php echo JText::_('NOVEMBER') ?>": 10,
		"<?php echo JText::_('DECEMBER') ?>": 11
	};

	// Calendar default options
	Fox.Options.add('calendar', {
		dayOfWeekStart: JSON.parse("<?php echo JFactory::getLanguage()->getFirstDay() ?>"),
		lang: 'dynamic',
		step: 60,
		i18n: {
			dynamic: {
				months: Date.monthNames,
				dayOfWeek: ["<?php echo JText::_('SUN') ?>", "<?php echo JText::_('MON') ?>", "<?php echo JText::_('TUE') ?>", "<?php echo JText::_('WED') ?>", "<?php echo JText::_('THU') ?>", "<?php echo JText::_('FRI') ?>", "<?php echo JText::_('SAT') ?>"]
			}
		}
	});

})();


jQuery(document).ready(function ($)
{
	$('.fox-item-captcha-img-reload').each(function ()
	{
		$(this).click(function ()
		{
			var image = document.getElementById($(this).attr("data-captcha-img"));

			// Generates a unique id with an 8 digits fixed length
			var uniqueid = Math.floor(Math.random() * Math.pow(10, 8)).toString();
			while (uniqueid.length < 8)
			{
				uniqueid = '0' + uniqueid;
			}

			// Update the image src
			image.src = image.src.replace(/uniqueid=[0-9]{8}/, "uniqueid=" + uniqueid);
		}).show();
	});
});


/* Enable the following function if you want to enable autofocus to the first input of the first form in the page */
/*
 jQuery(document).ready(function ($)
 {
 $('.fox-form').find('input[type=text]').filter(':visible:first').focus();
 });
 */
