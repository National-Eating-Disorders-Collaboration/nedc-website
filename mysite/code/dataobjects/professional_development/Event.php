<?php
/**
 * Event data
 * Handles
 *  - Bookmarking
 *  - Attendess
 *  - Generated URL/Slugs
 *  - Email Notification for accepted events
 *
 * @date 2017-08-17
 * @author  Jem Lopez <jem@blissmedia.com.au>
 * @version  1.0.5
 *
 */

class Event extends DataObject
{
	private static $db = array(
		'Featured'		=> 'Boolean',
		'Organization'	=> 'Varchar(155)',
		'Status'		=> 'Enum("Published, Pending, Unpublished", "Published")',
		'Title'			=> 'Varchar(155)',
		'isOwn'			=> 'Boolean',
		'Address'		=> 'Varchar(155)',
		'ContactPerson'	=> 'Varchar(155)',
		'Contact'		=> 'Varchar(155)',
		'Email'			=> 'Varchar(155)',
		'Price'			=> 'Varchar',
		'URLSegment' 	=> 'Varchar(255)',
		'OtherType'		=> 'Varchar(50)',
		'ExternalForm'	=> 'Text',
		'About'			=> 'HTMLText',
		'Requirements' 	=> 'HTMLText',
		'EventAudience'	=> 'HTMLText'
		
	);

	private static $defaults = array(
		'SubmittedByID' => '1'
	);

	private static $has_many = array(
		'EventTimeDate'	=> 'EventTimeDate',
		'Speakers'		=> 'Speaker',
		'Logos'			=> 'Logo',
		'Attendees'		=> 'Attendee'
	);

	private static $has_one = array(
		'PDPage' 		=> 'ProfessionalDevelopmentPage',
		'SubmittedBy'	=> 'Member',
		'Image'			=> 'Image',
		'AdditonalFile' => 'File',
		'ContactLink'	=> 'Link',
	);

	private static $many_many = array(
		'State'		=> 'AustraliaState',
		'EventType'	=> 'EventType',
	);

	private static $summary_fields = array(
		'Title' 			=> 'Title',
		'Created.Long' 		=> 'Submitted',
		'getMember'			=> 'Author',
		'Contact'			=> 'Contact',
		'Email'				=> 'Email Address',
		'Status'			=> 'Status',
		'Featured.Nice'		=> 'Featured'

	);

    static $belongs_many_many = array(
        'BookmarkedMembers' => 'Member.BookmarkedEvents',
    );

    // static $field_labels = array(
    // 	'BookmarkedMembers' => 'Attendees'
    // );

    public function getValidator() {
        return RequiredFields::create('Title');
    }

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('EventTimeDate');
		$fields->removeByName('Speakers');
		$fields->removeByName('State');
		$fields->removeByName('EventType');
		$fields->removeByName('URLSegment');
		$fields->removeByName('BookmarkedMembers');

		$state = TagField::create(
			'State',
			'Where in Australia',
			AustraliaState::get(),
			$this->State()
		)
		->setShouldLazyLoad(true)
		->setRightTitle('Leave blank if national event.');

		$fields->addFieldToTab('Root.Main', $state);
		$fields->addFieldToTab('Root.Main', LinkField::create('ContactLinkID', 'Contact Link'), 'Contact');
		$config = GridFieldConfig_RecordEditor::create();

		$fields->addFieldToTab('Root.Logos', GridField::create(
			'Logos',
			'Logos',
			$this->Logos(),
			$config
		));

		$fields->addFieldToTab('Root.Attendees', GridField::create(
			'Attendees',
			'Attendees',
			$this->Attendees(),
			GridFieldConfig_RecordEditor::create()
		));


		$config->addComponent(new GridFieldSortableRows('SortOrder'));
		$fields->addFieldToTab('Root.Main', DropdownField::create(
			'PDPageID',
			'PDPage',
			ProfessionalDevelopmentPage::get()
			->map('ID', 'Title'))
		);

		$event_type = TagField::create(
			'EventType',
			'EventType',
			EventType::get(),
			$this->EventType()
		)
		->setShouldLazyLoad(true)
		->setCanCreate(true);

		$fields->addFieldToTab('Root.Main', $event_type);

		if($this->ID) {
			$fields->addFieldToTab('Root.Main', GridField::create(
				'TimeAndDates',
				'Add Time and Dates for this Event',
				$this->EventTimeDate(),
				GridFieldConfig_RecordEditor::create()
			));

			$fields->addFieldToTab('Root.Main', GridField::create(
				'Speakers',
				'Add Speakers for this event',
				$this->Speakers(),
				GridFieldConfig_RecordEditor::create()
			));

			$fields->addFieldToTab('Root.Attendees', GridField::create(
				'Attendees',
				'Attendees',
				$this->Attendees(),
				GridFieldConfig_RecordEditor::create()
			));
		}

		return $fields;
	}
	/**
	 * Build link for individual events
	 * @date    2017-08-01
	 * @version 1.0.0
	 */
	public function Link() {
		$parent = $this->PDPage()->URLSegment;
        return Controller::join_links($parent . '/', 'event', $this->ID .'/'. $this->URLSegment);
    }

	/**
	 * Get Date from each date and parse to summary fields
	 * @date    2017-08-01
	 * @version 1.0.0
	 * @return  [string]     [array of dates into string]
	 */
	protected function getDate()
	{
		$dates = $this->EventTimeDate();
		$dates_r = array();

		foreach ($dates as $date) {
			$dates_r[$date->EventID] = $date->Date; 
		}

		$results = explode(',', $dates_r);
		return $results;
	}

	protected function getDates()
	{
		$dates = $this->EventTimeDate();
		$results = new arrayList();
		
		foreach ($dates as $date) {
			if($date->Date) {
				$reformat = date('M j y', strtotime($date->Date));
				$d = explode(' ', $reformat);
				$results[] =  array('Month' => $d[0],'Day' => $d[1], 'Year' => $d[2]);
			}
		}
		return $results;
	}

	/**
	 * Get Count
	 * @return  int
	 */
	protected function getCount() {
		return count($this->getDates());
	}
	/**
	 * Get Count
	 * @return  array
	 */
	protected function getCategory() {
		$categories = $this->EventType();
		foreach($categories as $cat) {
			return $cat->Title;
		}
	}
	/**
	 * Get Title for Summary fields
	 * @return  string
	 */
	protected function getMember()
	{
		$id = $this->SubmittedByID;
		if ($id) {
			$member = DataObject::get('Member')->filter('ID', $id)->First();
			$fullname =  $member->FirstName . ' ' .$member->Surname;
			return $fullname;
		}

		return false;
	}

    public function isBookmarked() {
        return in_array(Member::currentUserID(), array_keys($this->BookMarkedMembers()->map()->toArray()));
    }

    public function isAttending() {
    	if (Member::currentUserID() == 0 ) {
    		return false;
    	}
        return in_array(Member::currentUserID(), array_keys($this->Attendees()->map('MemberID')->toArray()));
    }

    // public function isFullyBooked() {
    // 	if (count($this->Attendees()) == $this->MaxNumber && $this->MaxNumber != 0) {
    // 		return true;
    // 	}
    // 	return false;
    // }

    public function onBeforeWrite() {
        parent::onBeforeWrite();

        if ($this->owner->isChanged('Title', 2) && !$this->owner->isChanged('URLSegment', 2)) {
            $this->URLSegment = singleton('SiteTree')->generateURLSegment($this->Title);
        }

        if($this->ID) {
        	if($this->owner->isChanged('Status', 2) && $this->Status == 'Published') {

        		$member = ($this->SubmittedBy()->ID != '0') ? $this->SubmittedBy()->getName() : $this->ContactPerson;
        		$email = ($this->SubmittedBy()->ID != '0') ? $this->SubmittedBy()->Email : $this->Email;

				$From = 'no-reply@nedc.com.au';
				$To   = $email;
				$Subject = 'NEDC: Your submitted event has been published!';

				$message = <<<X
Hi {$member},

This is to inform you that your submitted event "{$this->Title}" has been published.

Your event is listed here. -> {$this->Link()}

Thanks,

NEDC Admin
X;

				$email = new Email($From, $To, $Subject, $message);
				$send_attempt = $email->setTemplate('EmailToUserEventPublished')
									->populateTemplate(array(
				                         'Name' => $member,
				                         'Title' => htmlentities($this->Title),
				                         'Link' => $this->Link(),
			                         ))
									->send();
        	}
        }
    }
}
