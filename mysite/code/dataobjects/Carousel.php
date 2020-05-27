<?php
/**
 *
 */
class Carousel extends DataObject
{
	private static $db = array(
		'Title'		=> 'Varchar(155)',
		'Description' => 'Text',
		'SortOrder'	=> 'Int',
	);

	private static $has_one = array(
		'Slider' 	=> 'Image',
		'PDPage'	=> 'ProfessionalDevelopmentPage',
		'ELearning'	=> 'ELearningPage',
		'News'		=> 'NewsPage',
		'Link'		=> 'Link',
	);

	private static $summary_fields = array(
		'setThumbnail'	=> 'Thumbnail'
	);

	public static $default_sort = 'SortOrder';

	public function getCMSFields()
	{
		$f = parent::getCMSFields();
		$f->removeByName('NewsID');
		$f->removeByName('ELearningID');
		$f->removeByName('PDPageID');
		$f->removeByName('HomeID');
		$f->removeByName('SortOrder');
		$f->addFieldToTab('Root.Main', $image = UploadField::create('Slider'));
		$f->addFieldToTab('Root.Main', LinkField::create('LinkID', 'Link to page or file'));
		$image->getValidator()->setAllowedExtensions(array('png','jpg','jpeg','gif'));
		$image->setDescription('Recommended size: 1150 x 380');
		return $f;
	}
	protected function setThumbnail()
	{
		return $this->Slider()->setHeight(40);
	}
}
