<?php

class SideBlocks extends DataObject
{
	private static $db = array(
		'Title'	=> 'Varchar(155)',
		'Description' => 'HTMLText',
		'SortOrder'	=> 'Int',
	);

	private static $has_one = array(
		'Link'			=> 'Link',
		'StandardPage' 	=> 'StandardPage',
		'Support'		=> 'SupportAndServicesPage',
		'SubPage'		=> 'SubStandardPage',
		'ProfPage'		=> 'ProfessionalDevelopmentPage',
		'EDArticle'		=> 'EatingDisordersArticle'
	);
	public static $default_sort = 'SortOrder';

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('StandardPageID');
		$fields->removeByName('SupportID');
		$fields->removeByName('ProfPageID');
		$fields->removeByName('SubPageID');
		$fields->removeByName('SortOrder');
		$fields->addFieldToTab('Root.Main', LinkField::create('LinkID', 'Link'));
		return $fields;
	}
}
