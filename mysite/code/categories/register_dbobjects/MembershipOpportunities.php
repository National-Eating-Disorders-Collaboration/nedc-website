<?php

class MembershipOpportunities extends DataObject {

	private static $db = array(
		'Title'	=> 'VARCHAR',
	);

	private static $has_one = array(
		'RegisterForm'		=> 'RegisterForm'
	);
}
