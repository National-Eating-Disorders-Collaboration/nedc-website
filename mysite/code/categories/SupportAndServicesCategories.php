<?php

class SupportAndServicesCategories extends DataObject {

	private static $db = array (
		'Title' => 'VARCHAR(55)',
	);

	private static $field_labels = array(
	  'Title' => 'Service Type'
	);

	//Add the page name you want to relate to
	private static $belongs_many_many = array (
		'ServiceCategory' => 'SupportOrganization'
	);
}
