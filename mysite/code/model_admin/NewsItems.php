<?php

class NewsItems extends ModelAdmin
{
	/**
	 * Creates a tab on the cms to manage all the articles and category
	 *
	 * @var array
	 */
    private static $managed_models = array
    (
        'News',
    );

    private static $menu_icon = 'mysite/images/News.svg';

    private static $url_segment = 'news'; // your URL name admin/articles

    private static $menu_title = 'News '; //Name on the CMS
}
