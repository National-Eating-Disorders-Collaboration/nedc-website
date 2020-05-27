<?php
/**
 *
 */

class SupportHelpBlock extends DataObject
{
	private static $db = array(
		'Type'		=> 'Enum("Help, Butterfly")',
		'Title'		=> 'VARCHAR(155)',
		'Contact'	=> 'VARCHAR(155)',
		'Email'		=> 'VARCHAR(155)',
		'Description'=> 'TEXT'
	);

	private static $has_one = array(
		'Image'	=> 'Image',
		'Link'	=> 'Link',
		'Page'	=> 'SupportHelpPage'
	);

	private static $summary_fields = array(
		'getSummary'	=> 'Title',
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$title = TextField::create('Title');
		$email = TextField::create('Email');
		$link1 = Linkfield::create('LinkID', 'Add Link');

		$image = UploadField::create('Image', 'Image');
		$desc = TextAreaField::create('Description');

		$link1->hideIf('Type')->isEqualTo('Help');
		$title->hideIf('Type')->isEqualTo('Help');
		$email->hideIf('Type')->isEqualTo('Help');
		$desc->hideIf('Type')->isEqualTo('Help');
		$fields->addFieldsToTab('Root.Main',array($link1, $title, $email, $desc, $image));
		return $fields;
	}

	protected function getSummary(){
		return !empty($this->Title) ? $this->Title : $this->Contact;
	}
}
