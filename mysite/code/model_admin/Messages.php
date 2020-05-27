<?php

class Messages extends ModelAdmin
{
	/**
	 * Creates a tab on the cms to manage all the articles and category
	 *
	 * @var array
	 */
    private static $managed_models = array
    (
        'Message',
    );

    private static $menu_icon = 'mysite/images/Email.svg';

    private static $url_segment = 'messages'; // your URL name admin/articles

    private static $menu_title = 'Messages'; //Name on the CMS
}
