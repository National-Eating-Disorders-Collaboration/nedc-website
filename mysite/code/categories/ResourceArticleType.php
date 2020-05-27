<?php

class ResourceArticleType extends DataObject {
	private static $db = array(
    'Name' => 'Varchar',
    'URLSegment' => 'Varchar(255)',
    'ShortDescription' => 'Text'
    );

    private static $has_one = array(
        'Thumbnail' => 'Image'
    );

 	public function getCMSFields() {
 		$fields = parent::getCMSFields();

 		$fields->removeByName('URLSegment');
 		// $fields->getByName('Thumbnail')->getValidator()->setAllowedExtensions(array('svg'));

 		return $fields;
 	}

 	public function onBeforeWrite() {
 		parent::onBeforeWrite();

 		if($this->Name) {
 			$this->URLSegment = singleton('SiteTree')->generateURLSegment($this->Name);
 		}
 	}

    public function Link() {
        return Controller::join_links(singleton('ResearchAndResourcesHolder_Controller')->Link(), $this->URLSegment);
	}
	
	public function getTitle() {
		return $this->Name;
	}
}
