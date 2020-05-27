<?php

class SupportOrganizationsAndServices extends ModelAdmin
{
	/**
	 * Creates a tab on the cms to manage all the articles and category
	 *
	 * @var array
	 */
    private static $managed_models = array
    (
        'SupportOrganization',
    );

    private static $menu_icon = 'mysite/images/Services.svg';

    private static $url_segment = 'Services'; // your URL name admin/articles

    private static $menu_title = 'Support & Services '; //Name on the CMS

    public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm($id, $fields);

        // $gridFieldName is generated from the ModelClass, eg if the Class 'Product'
        // is managed by this ModelAdmin, the GridField for it will also be named 'Product'

        $gridFieldName = $this->sanitiseClassName($this->modelClass);
        $gridField = $form->Fields()->fieldByName($gridFieldName);

        // modify the list view.
        $gridField->getConfig()->addComponent(new GridFieldFilterHeader());
        return $form;
    }
}
