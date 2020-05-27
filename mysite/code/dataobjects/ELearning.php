<?php

class ELearning extends DataObject
{
	private static $db = array(
		'Featured'		=> 'Boolean',
		'Title'			=> 'Varchar(155)',
		'Description'	=> 'HTMLText',
		'Video'			=> 'Varchar(255)',
		'URLSegment'	=> 'Varchar(255)',
		'SortOrder'		=> 'Int',
	);

	private static $has_one = array(
		'Page'			=> 'ELearningPage',
		'Categories' 	=> 'ELearningCategories',
		'Thumbnail'		=> 'Image'
	);

	private static $many_many = array(
		'Topics'	=> 'Topic'
	);

	private static $summary_fields = array(
		'Title',
		'Video',
		'Featured.Nice'
	);
	
	public static $default_sort = 'SortOrder';

    static $belongs_many_many = array(
        'BookmarkedMembers' => 'Member'
    );

	public function Link() {
		$elearn = $this->Page()->URLSegment;
		$parent = $this->Page()->Parent()->URLSegment;
        return Controller::join_links($parent . '/' .$elearn, 'show', $this->ID .'/'. $this->URLSegment);
    }

    public function getValidator() {
        return RequiredFields::create('Title');
    }

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('Topics');
		$fields->removeByName('URLSegment');
		$fields->addFieldToTab('Root.Main', $video = new TextField('Video'));
		// TODO: Refactor and use oembed class
		$video->setRightTitle('Get the last URL Code from yotube. Example: https://www.youtube.com/watch?v=ScKx4bSN_po (Copy the "ScKx4bSN_po")');
		// $fields->addFieldToTab('Root.Main', EmbeddedObjectField::create('Video', 'Video from oEmbed URL', $this->Video()));

		$fields->addFieldToTab('Root.Main', $image = UploadField::create('Thumbnail'));
		$image->getValidator()->setAllowedExtensions(array('png','jpg','jpeg','gif'));
		$image->setDescription('Recommended size: 370 x 235');
		$tag = TagField::create(
			'Topics',
			'Topics',
			Topic::get(),
			$this->Topics()
		)
		->setShouldLazyLoad(true)
		->setCanCreate(true)
		->setRightTitle('Find or create topic.');

		$fields->addFieldToTab('Root.Main', $tag);
		return $fields;
	}

    public function isBookmarked() {
        return in_array(Member::currentUserID(), array_keys($this->BookMarkedMembers()->map()->toArray()));
    }

    public function onBeforeWrite() {
        parent::onBeforeWrite();

        if(!$this->URLSegment && $this->Title) {
            $this->URLSegment = singleton('SiteTree')->generateURLSegment($this->Title);
        }
    }
}
