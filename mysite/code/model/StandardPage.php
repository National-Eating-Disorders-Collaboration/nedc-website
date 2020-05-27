<?php
/**
 *
 */
class StandardPage extends Page
{
	private static $allowed_children = array('SubStandardPage');
	
	private static $db = array(
		'DarkColor'		=> 'Boolean',
	);
	private static $has_one = array(
		'Banner'	 => 'Image',
	);

	private static $has_many = array(
		'SideBlocks'	=> 'SideBlocks',
		'SeeAlsoSection' => 'SeeAlsoSection'
	);

	public function getCMSFields()
	{
		$f = parent::getCMSFields();
		$f->addFieldToTab('Root.Main', CheckboxField::create('DarkColor'), 'URLSegment');
		$f->addFieldToTab('Root.Banner', $image = UploadField::create('Banner'));
		$image->getValidator()->setAllowedExtensions(array('png','jpg','jpeg','gif'));
		$image->setDescription('Recommended size: 1800 x 350');

		$config = GridFieldConfig_RecordEditor::create();
        $config->addComponent(new GridFieldSortableRows('SortOrder'));
		$f->addFieldToTab('Root.SideBox', GridField::create(
			'SideBlocks',
			'SideBlocks',
			$this->SideBlocks(),
			$config
		));

		$f->addFieldToTab('Root.SeeAlso', GridField::create(
			'SeeAlsoSection',
			'SeeAlsoSection',
			$this->SeeAlsoSection(),
			$config
		));
		return $f;
	}
}
