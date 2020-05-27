<?php

class AustraliaState extends DataObject
{
	private static $db = array(
		'Title'	=> 'VARCHAR(155)',
		'State'	=> 'VARCHAR(5)'
	);

	private static $has_many = array(
		'Services'	=> 'SupportOrganization',
	);

	private static $belongs_many_many = array(
		'Events'	=> 'Event',
	);

}
