<?php
/**
 *
 */

class Topic extends DataObject
{
	private static $db = array(
		'Title'	=> 'VARCHAR(55)',
		'URLSegment' => 'Varchar(255)',
		'ShortDescription' => 'Text',		
	);

	private static $has_one = array(
        'Thumbnail' => 'Image'
    );

	//Add the page name you want to relate to
	private static $belongs_many_many = array (
		'Topic' => 'ELearning',
		'Topic'	=> 'News'
	);

 	public function getCMSFields() {
 		$fields = parent::getCMSFields();

 		$fields->removeByName('URLSegment');

 		return $fields;
 	}

 	public function onBeforeWrite() {
 		parent::onBeforeWrite();

 		if($this->Title) {
 			$this->URLSegment = singleton('SiteTree')->generateURLSegment($this->Title);
 		}
 	}	

 	public function Link() {
 		return Controller::join_links(singleton('ResearchAndResourcesHolder_Controller')->Link(), $this->URLSegment);
 	} 	
}
