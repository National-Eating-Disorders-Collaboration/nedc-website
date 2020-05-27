<?php

class Events extends ModelAdmin
{
	/**
	 * Creates a tab on the cms to manage all the articles and category
	 *
	 * @var array
	 */
    private static $managed_models = array
    (
        'Event',

    );

    private static $menu_icon = 'mysite/images/Events.svg';

    private static $url_segment = 'events'; // your URL name admin/articles

    private static $menu_title = 'Events '; //Name on the CMS

    public function getList() {
        $list = parent::getList();

        // Always limit by model class, in case you're managing multiple
        if($this->modelClass == 'Event') {
            $list = $list->filter('Status', array('Published', 'Unpublished'))->sort('Created DESC');
        }

        return $list;
    }
}
