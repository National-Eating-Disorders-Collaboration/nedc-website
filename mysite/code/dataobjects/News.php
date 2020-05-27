<?php

class News extends DataObject
{
	private static $db = array(
		'Title'	=> 'Varchar(155)',
		'Content'=> 'HTMLText',
		'URLSegment' => 'Varchar(255)',
	);

	private static $many_many = array(
		'Topics'	=> 'Topic'
	);

	private static $has_one = array(
		'Thumbnail'	=> 'Image',
		'NewsPhoto' => 'Image',
		'News'		=> 'NewsPage'
	);

	private static $summary_fields = array(
		'Title'			=> 'Title',
		'Created.Long'	=> 'Created'
	);

	public function Link() {
		$parent = $this->News()->URLSegment;
        return Controller::join_links($parent . '/', 'show', $this->ID .'/'. $this->URLSegment);
    }

	public function getValidator() {
        return RequiredFields::create('Title');
    }

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('Topics');
		$fields->removeByName('URLSegment');
		$fields->addFieldToTab('Root.Main', $image = UploadField::create('Thumbnail'));
		$image->getValidator()->setAllowedExtensions(array('png','jpg','jpeg','gif'));
		$image->setDescription('Recommended size: 370 x 235');

		$fields->addFieldToTab('Root.Main', $news = UploadField::create('NewsPhoto'));
		$news->getValidator()->setAllowedExtensions(array('png','jpg','jpeg','gif'));

		$tag = TagField::create(
			'Topics',
			'Topics',
			Topic::get(),
			$this->Topics()
		)
		->setShouldLazyLoad(true)
		->setCanCreate(true)
		->setRightTitle('Choose or Create topic.');

		$fields->addFieldToTab('Root.Main', $tag, 'Content');

		$fields->addFieldToTab('Root.Main', DropdownField::create('NewsID', 'News', NewsPage::get()->map('ID', 'Title')));
		return $fields;
	}

	public function Categories()
	{
		$cats = $this->Topics();
		foreach ($cats as $cat) {
			return $cat->Title;
		}
	}

	 public function onBeforeWrite() {
        parent::onBeforeWrite();

        if(!$this->URLSegment && $this->Title) {
            $this->URLSegment = singleton('SiteTree')->generateURLSegment($this->Title);
        }
    }
}
