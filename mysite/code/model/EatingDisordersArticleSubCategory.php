<?php

class EatingDisordersArticleSubCategory extends Page {
	private static $allowed_children = array ('EatingDisordersArticle');
	private static $can_be_root = false;
	private static $has_many = array('Articles' => 'EatingDisordersArticle');	
  private static $can_be_breadcrumb = false;

	private static $db = array(
       'Title' => 'Varchar'
    );

	public function getCMSFields() {
    	$fields = parent::getCMSFields();

    	$fields->addFieldToTab('Root.Main', TextField::create('Title', 'Article Group Title'));

    	$fields->removeByName('URLSegment');
    	$fields->removeByName('Content');
      $fields->removeByName('MenuTitle');
    	$fields->removeByName('Metadata');

    	return $fields;
  	}    
}