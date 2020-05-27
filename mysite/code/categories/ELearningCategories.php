<?php
/**
 *
 */

class ELearningCategories extends DataObject
{
	private static $db = array(
		'Title'	=> 'VARCHAR(55)',
	);

	private static $field_labels = array(
	  'Title' => 'E-Learning Type'
	);
}
