<?php
/**
 *
 */
class ProfessionGroup extends DataObject
{
	private static $db = array(
		'Title'	=> 'VARCHAR(155)'
	);

	private static $has_one = array(
		'RegisterForm' => 'RegisterForm'
	);
}
