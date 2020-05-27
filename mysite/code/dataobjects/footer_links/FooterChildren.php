<?php

class FooterChildren extends DataObject {
	private static $db = array(
		'SortOrder'	=> 'Int',
	);

	private static $has_one = array(
		'Link'	=> 'Link',
		'Parent'	=> 'FooterParent',

	);
	public static $default_sort = 'SortOrder';
	private static $summary_fields =array(
		'Link.Title'	=> 'Title'
	);

	public function getCMSFields()
	{
		$f = parent::getCMSFields();
		$f->removeByName('SortOrder');
		$f->addFieldToTab('Root.Main', LinkField::create('LinkID', 'Title with Link'));

		return $f;
	}


}
