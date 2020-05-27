<?php

class FooterParent extends DataObject {

	private static $db = array(
		'Row'	=> 'Enum("First, Second, Third")',
		'SortOrder'	=> 'Int',
	);

	private static $has_one = array(
		'TitleLink'	=> 'Link',
		'SiteConfig'	=> 'SiteConfig',
		'Page'	=> 'Page'
	);

	public static $default_sort = 'SortOrder';

	private static $has_many = array(
		'ChildrenLink'	=> 'FooterChildren'
	);

	private static $summary_fields =array(
		'Row'	=> 'Row #',
		'TitleLink.Title'	=> 'Title',
		'TitleLink.LinkURL'	=> 'URL',
	);

	private static $casting = array(
		'Title'	=> 'Varchar'
	);

	public function getCMSFields()
	{
		$f = parent::getCMSFields();
		$f->removeByName('PageID');
		$f->removeByName('SortOrder');
		$f->addFieldToTab('Root.Main', LinkField::create('TitleLinkID', 'Title with Link'));
		// $f->addFieldToTab('Root.Main', LiteralField::create('Note', '<b> NOTE: You can only change sort footer parent/children for each row #. '));

    	$config = GridFieldConfig_RecordEditor::create();
    	$config->addComponent(new GridFieldSortableRows('SortOrder'));
		$f->addFieldToTab('Root.Main', GridField::create(
			'ChildrenLinks',
			'ChildrenLinks',
			$this->ChildrenLink(),
			$config
		));
		return $f;
	}

	public function getTitle() {
		return $this->TitleLink()->Title;
	}
}
