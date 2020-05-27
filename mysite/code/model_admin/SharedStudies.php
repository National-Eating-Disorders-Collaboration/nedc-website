<?php
/**
 * Creates an admin model for shared studies
 *
 * This shares the db for 'ResearchAndResources' and fitered to 'SubmittedStudies => Pending'
 *
 */

class SharedStudies extends LeftAndMain implements PermissionProvider
{
	/**
	 * Creates a tab on the cms to manage all the articles and category
	 *
	 * @var array
	 */

    private static $menu_icon = 'mysite/images/Resources.svg';

    private static $url_segment = 'shared-studies'; // your URL name admin/articles

    private static $menu_title = "Shared Studies ";//.$this->getCount(); //Name on the CMS

    public function init() {
        parent::init();
        Config::inst()->update('SharedStudies', 'menu_title', self::$menu_title . $this->getCount());
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

        $studies_accepted = ResearchResource::get()->filter(array('SubmittedStudies' => 'Accepted', 'isAustralianCaseStudies' => '1'))->sort('Created DESC');
        $studies_pending = ResearchResource::get()->filter(array('SubmittedStudies' => 'Pending', 'isAustralianCaseStudies' => '1'))->sort('Created DESC');
        $studies_declined = ResearchResource::get()->filter(array('SubmittedStudies' => 'Declined', 'isAustralianCaseStudies' => '1'))->sort('Created DESC');

        $accepted = new GridField(
            'studies_accepted',
            'Shared Studies',
            $studies_accepted,
            GridFieldConfig_RecordEditor::create()
        );

        $pending = new GridField(
            'studies_pending',
            'Shared Studies',
            $studies_pending,
            GridFieldConfig_RecordEditor::create()
        );

        $declined = new GridField(
            'studies_declined',
            'Shared Studies',
            $studies_declined,
            GridFieldConfig_RecordEditor::create()
        );

        $accepted->getConfig()->removeComponentsByType('GridFieldAddNewButton');
        $pending->getConfig()->removeComponentsByType('GridFieldAddNewButton');
        $declined->getConfig()->removeComponentsByType('GridFieldAddNewButton');
        $acceptedCount = '(' . count($studies_accepted) . ')';
        $pendingCount = '(' . count($studies_pending) . ')';
        $declinedCount = '(' . count($studies_declined) . ')';

        $fields = new FieldList(
            $root = new TabSet(
                'Root',
                new Tab('accepted', _t('Studies.accepted', 'Accepted') . ' ' . $acceptedCount,
                    $accepted
                ),
                new Tab('pending', _t('Studies.pending', 'Pending') . ' ' . $pendingCount,
                    $pending
                ),
                new Tab('declined', _t('Studies.declined', 'Declined') . ' ' . $declinedCount,
                    $declined
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
        $studies = ResearchResource::get()->filter('SubmittedStudies', 'Pending');
        $count = '(' . count($studies) . ')';
        return $count;
    }

}
