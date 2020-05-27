<?php
/**
 * Homepage
 */
class Block extends DataObject
{
	private static $db = array(
		'Featured'		=> 'Boolean',
		'Position'		=> 'Enum("First, Second, Third")',
		'Title'			=> 'Varchar(155)',
		'Description'	=> 'Varchar(255)',
		'SortOrder'		=> 'Int',
	);

	private static $has_one = array(
		'Background'=> 'Image',
		'Home'		=> 'HomePage',
		'Browse'	=> 'Link'
	);

	private static $has_many = array(
		'BlockLinks'	=> 'BlockLink'
	);
	public static $default_sort = 'SortOrder';

	public function getCMSValidator() {
		return new RequiredFields('Position');
	}

	private static $summary_fields = array(
		'Title'			=> 'Title',
		'Description'	=> 'Description',
		'Position'		=> 'Position',
		'Featured.Nice'	=> 'Featured'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('SortOrder');
		$fields->removeByName('BlockLinks');
		$fields->addFieldToTab('Root.Main', LinkField::create('BrowseID', 'Browse Link'));
		$config = GridFieldConfig_RecordEditor::create();
		$config->addComponent(new GridFieldSortableRows('SortOrder'));

		$fields->addFieldToTab('Root.Main', GridField::create(
			'BlockLinks',
			'BlockLinks',
			$this->BlockLinks(),
			$config
		));
		return $fields;
	}
}
