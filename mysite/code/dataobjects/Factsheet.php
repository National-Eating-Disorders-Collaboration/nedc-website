<?php

class Factsheet extends DataObject {
	private static $db = array(
        'Title' => 'Varchar'
    );

	private static $has_one = array(
         'FactsheetPDF' => 'File',
         'Article'      => 'EatingDisordersArticle',
         'Category'     => 'EatingDisordersArticleCategory'
    );

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', UploadField::create('FactsheetPDF','Factsheet, optional (PDF only)'));
        return $fields;
    }
}
