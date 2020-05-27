<?php
/**
 * 
 */

class EventTimeDate extends DataObject
{
	private static $db = array(
		'Date'		=> 'Date',
		'StartTime'	=> 'Time',
		'EndTime'	=> 'Time',
	);

	private static $has_one = array(
		'Event' => 'Event',
	);

	private static $summary_fields = array(
		'Date.Long'			=> 'Date',
		'StartTime.Nice'	=> 'StartTime',
		'EndTime.Nice'		=> 'EndTime'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('Event');

		$fields->addFieldToTab(
			'Root.Main', 
			TimeField::create('StartTime')
				->setRightTitle('Example: 09:00 (9am)')
		);
		
		$fields->addFieldToTab(
			'Root.Main', 
			TimeField::create('EndTime')
				->setRightTitle('Example: 19:00 (5pm)')
		);
		
		$fields->addFieldToTab(
			'Root.Main',
			DateField::create('Date','Date of Event')
            	->setConfig('showcalendar', true)
        );

		return $fields;
	}
}