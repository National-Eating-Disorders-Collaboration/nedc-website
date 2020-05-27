<?php
/**
 *
 */
class BecomeMember extends DataObject {

	private static $db = array(
		'Title'			=> 'VARCHAR(155)',
		'Description'	=> 'VARCHAR(155)',
	);

	private static $has_one = array(
		'Link'		=> 'Link',
		'Button'	=>'Link',
		'Image'		=> 'Image',
	);

	private static $belongs_to = array(
		'Home'	=> 'HomePage.BecomeMember',
		'PDPage' => 'ProfessionalDevelopmentPage.BecomeMember',
		'ResearchPage' => 'ResearchAndResourcesHolder.BecomeMember'
	);

	public function getCMSFields() {
		$f = parent::getCMSFields();

		$f->addFieldToTab('Root.Main', LinkField::create('LinkID', 'Link to page'));
		$f->addFieldToTab('Root.Main', LinkField::create('ButtonID', 'Button to link'));

		return $f;
	}
}
