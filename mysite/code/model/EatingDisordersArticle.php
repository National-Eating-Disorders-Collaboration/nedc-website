<?php

class EatingDisordersArticle extends Page {
	private static $has_one = array(
        'Category'      => 'EatingDisordersArticleCategory',
        'Article Group' => 'EatingDisordersArticleSubCategory',
        'Photo' => 'Image'
    );

    private static $can_be_root = false;

	private static $has_many = array(
		'Factsheets' => 'Factsheet',
        'SideBox'   => 'SideBlocks'
    );

    private static $many_many = array(
      'Links' => 'Link'
  	);

    private static $db = array(
       'SpecialSummary' => 'HTMLText',
       'RelatedLinksTitle'  => 'VARCHAR(155)'
    );

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', TextField::create('RelatedLinksTitle'), 'Content');
        $fields->insertBefore('Content', ToggleCompositeField::create('Special Summary', 'Special Summary', array(HtmlEditorField::create('SpecialSummary', 'Special Summary', 'SpecialSummary')))->setHeadingLevel(4));

		$fields->addFieldToTab('Root.Factsheets', GridField::create(
            'Factsheets',
            'Factsheets for this article',
            $this->Factsheets(),
            GridFieldConfig_RecordEditor::create()
        ));
        
        $config = GridFieldConfig_RecordEditor::create();
        $config->addComponent(new GridFieldSortableRows('SortOrder'));
        $fields->addFieldToTab('Root.SideBox', GridField::create(
            'SideBox',
            'SideBox',
            $this->SideBox(),
            $config
        ));

        $fields->addFieldToTab('Root.Related', GridField::create(
            'Links',
            'Related research for this article',
            $this->Links(),
            GridFieldConfig_RelationEditor::create()
        ));

        $fields->addFieldToTab('Root.Category Image', $image = UploadField::create('Photo', 'Category Image'));
        $image->getValidator()->setAllowedExtensions(array('png','jpg','jpeg','gif'));
        $image->setDescription('Note: This is the image that will be displayed on pages that lists this article.(e.g. the category page that lists this article). Recommended size: 425 x 400');
        return $fields;
    }
}

class EatingDisordersArticle_Controller extends Page_Controller {
	private static $allowed_actions = array('HasSiblingArticles', 'SiblingArticles');

    public function HasSiblingArticles() {
        return count($this->SiblingArticles()) > 0;
    }

    public function SiblingArticles() {
        $articles = $this->data()->Parent()->Children();
        $current = $this->data();

        foreach($articles as $article) {
            if($article->isCurrent() || !is_a($article, 'EatingDisordersArticle')) $articles->remove($article);
        }

        return $articles;
    }
}
