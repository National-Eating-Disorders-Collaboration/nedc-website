<?php
/**
 * Creates an admin model for shared events
 *
 * This shares the db for 'Events' and fitered to 'Published => 0'
 *
 */

class SharedEvents extends LeftAndMain implements PermissionProvider
{
	/**
	 * Creates a tab on the cms to manage all the articles and category
	 *
	 * @var array
	 */

    private static $menu_icon = 'mysite/images/Events.svg';

    private static $url_segment = 'shared-events'; // your URL name admin/articles

    private static $menu_title = "Shared Events ";//.$this->getCount(); //Name on the CMS

    public function init() {
        parent::init();
        Config::inst()->update('SharedEvents', 'menu_title', self::$menu_title . $this->getCount());
    }

    /**
     * @return Form
     */
    public function getEditForm($id = null, $fields = null)
    {
        if (!$id) {
            $id = $this->currentPageID();
        }
        $form = parent::getEditForm($id);

        $record = $this->getRecord($id);
        if ($record && !$record->canView()) {
            return Security::permissionFailure($this);
        }

        $events = Event::get()->filter('Status', 'Pending')->sort('Created DESC');

        $newGrid = new GridField(
            'events',
            'Shared Events',
            $events,
            GridFieldConfig_RecordEditor::create()
        );

        $newGrid->getConfig()->removeComponentsByType('GridFieldAddNewButton');
        $newCount = '(' . count($events) . ')';

        $fields = new FieldList(
            $root = new TabSet(
                'Root',
                new Tab('events', _t('Event.events', 'Pending') . ' ' . $newCount,
                    $newGrid
                )
            )
        );

        $root->setTemplate('CMSTabSet');
        $actions = new FieldList();
        $form = new Form(
            $this,
            'EditForm',
            $fields,
            $actions
        );

        $form->addExtraClass('cms-edit-form');
        $form->setTemplate($this->getTemplatesWithSuffix('_EditForm'));
        if ($form->Fields()->hasTabset()) {
            $form->Fields()->findOrMakeTab('Root')->setTemplate('CMSTabSet');
            $form->addExtraClass('center ss-tabset cms-tabset ' . $this->BaseCSSClasses());
        }
        $this->extend('updateEditForm', $form);
        return $form;
    }

    /**
     * Get Unpublished (Shared) events
     * @return  [string]
     */
    public function getCount()
    {
        $events = Event::get()->filter('Status', 'Pending');
        $count = '(' . count($events) . ')';
        return $count;
    }

}
