<?php
/**
 *
 */
class Speaker extends DataObject
{
	private static $db = array(
		'Name' => 'VARCHAR(55)',
		'Position'	=> 'VARCHAR(55)',
		'Company'	=> 'VARCHAR(55)',
	);

	private static $has_one = array(
		'Image'		=> 'Image',
		'Events'	=> 'Event'
	);

	private static $summary_fields = array(
		'Name',
		'Position',
		'Company'
	);

	public function getCMSFields()
	{
		$f = parent::getCMSFields();
		$f->addFieldToTab('Root.Main', $image = UploadField::create('Image'));
		$image->setRightTitle('Recommend: 100 x 100');
		$image->allowedExtensions = array('png','jpg','jpeg','gif');
		return $f;
	}
}
