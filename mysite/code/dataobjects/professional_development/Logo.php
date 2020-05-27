<?php
/**
 * Use for events
 */
class Logo extends DataObject
{
	private static $db = array(
		'SortOrder'	=> 'Int'
	);

	private static $has_one = array(
		'Image'		=> 'Image',
		'Event'		=> 'Event'
	);

	public static $default_sort = 'SortOrder';

	private static $summary_fields = array(
		'setThumbnail'	=> 'Thumbnail'
	);
	public function getCMSFields()
	{
		$f = parent::getCMSFields();
		$f->removeByName('EventID');
		$f->removeByName('SortOrder');
		$f->addFieldToTab('Root.Main', $image = UploadField::create('Image'));
		$image->getValidator()->setAllowedExtensions(array('png','jpg','jpeg','gif'));
		$image->setDescription('Recommended size: 125 x 50');
		return $f;
	}
	protected function setThumbnail()
	{
		return $this->Image()->setHeight(40);
	}
}
