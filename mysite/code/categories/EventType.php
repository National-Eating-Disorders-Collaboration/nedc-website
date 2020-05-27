<?php
/**
 *
 */

class EventType extends DataObject
{
	private static $db = array(
		'Title'	=> 'VARCHAR(55)',
	);

	private static $field_labels = array(
	  'Title' => 'Event Type'
	);

	private static $belongs_many_many = array(
		'Events'	=> 'Event'
	);
}
