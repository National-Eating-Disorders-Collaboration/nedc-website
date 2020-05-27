<?php

class Message extends DataObject {

	private static $db = array(
		'Area'	=> 'Varchar(155)',
		'Name'	=> 'Varchar(155)',
		'Email'	=> 'Varchar(155)',
		'Description'	=> 'Text'
	);

	private static $summary_fields = array(
		'Area',
		'Name',
		'Email'
	);
	// You can't edit peoples messgaes!!!
    public function canEdit($member = null)
    {
        return FALSE;
    }
}
