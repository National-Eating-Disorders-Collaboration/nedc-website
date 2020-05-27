<?php

class SupportOrganization extends DataObject
{
	private static $db = array(
		'Title'		=> 'VARCHAR(155)',
		'Author'	=> 'VARCHAR(55),',
		'Website'	=> 'URL',
		'EmailAddress' =>'VARCHAR(55)',
		'Contact'	=> 'VARCHAR(25)',
		'Phone1'	=> 'VARCHAR(25)',
		'Phone2'	=> 'VARCHAR(25)',
		'Fax'		=> 'VARCHAR(15)',
		'Address'	=> 'VARCHAR(155)',
		'Content'	=> 'HTMLText',
		'URLSegment' => 'Varchar(255)',

	);

	private static $many_many = array(
		'Populations' 	=> 'Population',
		'Categories'	=>	'SupportAndServicesCategories'
	);

	private static $has_one = array(
		'Page' 			=> 'SupportAndServicesPage',
		'ServiceHours'	=> 'DayTimeAvailability',
		'AUState'		=> 'AustraliaState'
	);

    static $belongs_many_many = array(
        'BookmarkedMembers' => 'Member'
    );

    private static $summary_fields = array(
    	'Title'		=> 'Title',
    	'Website'	=> 'Website',
    	'Contact'	=> 'Contact',
    	'Address'	=> 'Address',
    );

    private static $indexes = array(
        'SearchFields' => array(
            'type' => 'fulltext',
            'name' => 'SearchFields',
            'value' => '"Title", "Content"',
        )
    );

    private static $create_table_options = array(
        'MySQLDatabase' => 'ENGINE=MyISAM',
    );

    public function getValidator() {
        return RequiredFields::create('Title');
    }

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('Populations');
		$fields->removeByName('Categories');
		$fields->removeByName('URLSegment');
		$fields->removeByName('BookmarkedMembers');
		// $fields->removeByName('ServiceHoursID');



		if ($this->ID) {
			$config = GridFieldConfig_RecordEditor::create();
			$config->addComponent(new GridFieldHasOneRelationHandler($this, 'ServiceHours'));
			// $config->removeComponentsByType('GridFieldDetailForm');
			$data = DataObject::get('DayTimeAvailability');
			$field = new GridField('ServiceHours', null, $data, $config);
			// @TODO: remove 'save changes buttton'

			$fields->addFieldToTab('Root.ServiceHours', $field);
		}

		$tag = TagField::create(
			'Populations',
			'Population',
			Population::get(),
			$this->Populations()
		)
		->setShouldLazyLoad(true)
		->setCanCreate(true);

		$categories = TagField::create(
			'Categories',
			'Service Categories',
			SupportAndServicesCategories::get(),
			$this->Categories()
		)
		->setShouldLazyLoad(true)
		->setCanCreate(true);

		$fields->addFieldToTab('Root.Main', $tag, 'Content');
		$fields->addFieldToTab('Root.Main', $categories, 'Content');
		$fields->addFieldToTab('Root.Main', DropdownField::create('PageID', 'Page', SupportAndServicesPage::get()->map('ID', 'Title'))->setDisabled(false));
		$fields->addFieldToTab('Root.Main', DropdownField::create('AUStateID', 'Australia State', AustraliaState::get()->map('ID', 'Title')), 'Content');
		return $fields;
	}

	public function Link() {
		$parent = $this->Page()->URLSegment;
        return Controller::join_links($parent . '/', 'organization', $this->ID .'/'. $this->URLSegment);
    }
	/**
	 * Get Opening Hours for each services and call it from the template
	 * @date    2017-08-08
	 * @version 1.0.0
	 */
	public function Hours()
	{
		$hours =  $this->ServiceHours();

		if (isset($hours)) {
			$result = $this->Page()->getServiceHours($hours);
		}

		$today = date('l');
		foreach ($result as $key => $value) {
			if ($key == $today) {
				return $value;
			}
		}
	}

    public function isBookmarked() {
        return in_array(Member::currentUserID(), array_keys($this->BookMarkedMembers()->map()->toArray()));
    }

    public function onBeforeWrite() {
        parent::onBeforeWrite();
		
		if ($this->owner->isChanged('Title', 2) && !$this->owner->isChanged('URLSegment', 2)) {
            $this->URLSegment = singleton('SiteTree')->generateURLSegment($this->Title);
        }
    }
}
