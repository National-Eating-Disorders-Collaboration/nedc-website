<?php
/**
 *
 */

class SupportHelpPage extends Page
{
	private static $db = array(
		'BrowseTitle' => 'Varchar',
		'BrowseText'=> 'HTMLText',
		'ButterflyText' => 'HTMLText'
	);
	private static $has_one = array(
		'BrowseLink'	=> 'Link' ,
	);
	private static $has_many = array(
		
		'Blocks'	=> 'SupportHelpBlock'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.ExtraFields', TextField::create('BrowseTitle', 'BrowseTitle'));
		$fields->addFieldToTab('Root.ExtraFields', LinkField::create('BrowseLinkID', 'BrowseLink'));
		$fields->addFieldToTab('Root.ExtraFields', HtmlEditorField::create('BrowseText', 'Browse Text'));
		$fields->addFieldToTab('Root.ExtraFields', HtmlEditorField::create('ButterflyText', 'Butterfly Extra Info'));
		
		$fields->addFieldToTab('Root.Blocks', GridField::create(
			'Blocks',
			'Blocks',
			$this->Blocks(),
			GridFieldConfig_RecordEditor::create()
		));

		return $fields;
	}
}
