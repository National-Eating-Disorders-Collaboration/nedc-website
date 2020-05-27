<?php
/**
 *
 */
class HomePageSlider extends DataObject
{
	private static $db = array(
		'Title'		=> 'Varchar(155)',
		'Color'		=> 'Enum("Light, Dark", "Light")',
		'OtherText' => 'Varchar(55)',
		'SortOrder'	=> 'Int'
	);

	private static $has_one = array(
		'Slider' 	=> 'Image',
		'Home'		=> 'HomePage',
		'Link'		=> 'Link',
	);

	public static $default_sort = 'SortOrder';

	private static $summary_fields = array(
		'Title'			=> 'Title',
		'setThumbnail'	=> 'Thumbnail'
	);

	public function getCMSFields()
	{
		$f = parent::getCMSFields();
		$f->removeByName('SortOrder');
		$f->addFieldToTab('Root.Main', LinkField::create('LinkID', 'Link to page or file'));
		return $f;
	}

	protected function setThumbnail()
	{
		return $this->Slider()->setHeight(40);
	}
}
