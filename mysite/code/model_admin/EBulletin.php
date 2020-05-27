<?php

class EBulletin extends ModelAdmin {


	/**
	 * Creates a tab on the cms to manage all the articles and category
	 *
	 * @var array
	 */
    private static $managed_models = array
    (
        'ResearchResource',

    );

    private static $menu_icon = 'mysite/images/News.svg';

    private static $url_segment = 'e-bulletin'; // your URL name admin/articles

    private static $menu_title = 'E-Bulletin '; //Name on the CMS

    public function getList() {
        $list = parent::getList();

        // Always limit by model class, in case you're managing multiple
        if($this->modelClass == 'ResearchResource') {
            $list = $list
            	->innerJoin('ResearchResource_ArticleTypes', "ResearchResource.ID = ResearchResource_ArticleTypes.ResearchResourceID")
            	->innerJoin('ResourceArticleType', "ResearchResource_ArticleTypes.ResourceArticleTypeID = ResourceArticleType.ID")
            	->filter(array('ResourceArticleType.Name:PartialMatch' => 'e-Bulletin'))
            	->sort('Created DESC');
        }

        return $list;
    }
}
