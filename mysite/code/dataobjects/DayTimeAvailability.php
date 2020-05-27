<?php

class DayTimeAvailability extends DataObject
{
	private static $db = array(
		// Weekday hours
		'Title'		=> 'VARCHAR(55)',
		'MondayFrom'=>	'Time',
		'MondayTo'	=> 'Time',
		'TuesdayFrom'=>	'Time',
		'TuesdayTo'	=> 'Time',
		'WednesdayFrom'=>	'Time',
		'WednesdayTo'	=> 'Time',
		'ThursdayFrom' => 'Time',
		'ThursdayTo' => 'Time',
		'FridayFrom' => 'Time',
		'FridayTo' => 'Time',
		'SaturdayFrom' => 'Time',
		'SaturdayTo' => 'Time',
		'SundayFrom' => 'Time',
		'SundayTo' => 'Time',
	);

	private static $summary_fields = array(
		'Title'
	);
	private static $belongs_to = array(
		'Organization' => 'SupportOrganization.DayTimeAvailability',
	);
}
