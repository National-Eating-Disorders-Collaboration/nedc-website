<?php

class EatingDisordersArticleCategory extends Page {
	private static $allowed_children = array (
		'EatingDisordersArticle',
		'EatingDisordersArticleSubCategory'
	);

	private static $can_be_root = false;

	private static $has_many = array(
		'Articles'		=> 'EatingDisordersArticle',
		'SubCategories' => 'EatingDisordersArticleSubCategory',
		'Factsheets'	=> 'Factsheet'
	);

	private static $db = array(
       'no_of_articles_on_parent_list_mode' => 'Int'
    );

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->addFieldToTab('Root.Factsheets', GridField::create(
            'Factsheets',
            'Factsheets for this Category',
            $this->Factsheets(),
            GridFieldConfig_RecordEditor::create()
        ));

        $fields->addFieldToTab('Root.Settings', TextField::create('no_of_articles_on_parent_list_mode', 'Number of Articles on parent holder list mode', 'no_of_articles_on_parent_list_mode'));

		return $fields;
	}
}
