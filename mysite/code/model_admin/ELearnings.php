<?php

class ELearnings extends ModelAdmin
{
	/**
	 * Creates a tab on the cms to manage all the articles and category
	 *
	 * @var array
	 */
    private static $managed_models = array
    (
        'ELearning',
    );

    private static $menu_icon = 'mysite/images/e-learning.svg';

    private static $url_segment = 'e-learn'; // your URL name admin/articles

    private static $menu_title = 'E-Learn '; //Name on the CMS


    public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm($id, $fields);
        $sort = $form->Fields()->fieldByName('ELearning');
        if ($sort){
         $sort->getConfig()->addComponent(new GridFieldSortableRows('SortOrder'));
        }
        return $form;
    }
}
