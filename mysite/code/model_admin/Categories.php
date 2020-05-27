<?php

class Categories extends ModelAdmin
{
	/**
	 * Creates a tab on the cms to manage all the categories
	 *
	 * @var array
	 */
    private static $managed_models = array
    (
        'Population'                    => array('title' => 'Populations'),
        'SupportAndServicesCategories'  => array('title' => 'Support and Services'),
        'Topic'                         => array('title' => 'Topics'),
        'ArticleType'                   => array('title' => 'Article Types'),
        'ELearningCategories'           => array('title' => 'E-Learning Types'),
        'ResourceArticleType'           => array('title' => 'Resource Article Types'),
        'Disorder'                      => array('title' => 'Disorders'),
        'Audience'                      => array('title' => 'Audiences'),
        'KeywordVariant'                => array('title' => 'Keyword Variants'),
    );

    private static $menu_icon = 'mysite/images/Categories.svg';

    private static $url_segment = 'categories'; // your URL name admin/articles

    private static $menu_title = 'Categories '; //Name on the CMS
}
