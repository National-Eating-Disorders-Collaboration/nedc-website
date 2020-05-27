<?php

class Member_Controller extends Page_Controller  {
	private static $allowed_actions = array('bookmark', 'dashboard', 'MemberUpdateForm', 'MemberUpdateFormSubmit');

	private static $url_handlers = array(
		'bookmark/$Operation!/$Type!/$ID!' => 'bookmark'
    );

	public function bookmark() {
		if( !$this->getRequest()->isAjax() || !Member::currentUser() ) {
		 	$this->httpError(404);
		}

		$operation = $this->getRequest()->param('Operation');
		$type = $this->getRequest()->param('Type');
		$ID = $this->getRequest()->param('ID');

		switch($type) {
			case 'resource':
				$resource = DataObject::get("ResearchResource")->byID($ID);

				$extraFields = array('isNEDC' => $resource->isNEDC, 'Created' => date('Y-m-d H:i:s'));

				if(!$resource) {
					$this->httpError(500);
				}
				if($operation == 'add') {

					Member::currentUser()->BookmarkedResources()->add($resource->ID, $extraFields);
				} else {
					Member::currentUser()->BookmarkedResources()->remove($resource);
				}
				break;
			case 'event':
				$event = DataObject::get("Event")->byID($ID);
				$extraFields = array('isNEDC' => $event->isOwn, 'Created' => date('Y-m-d H:i:s'));
				if(!$event) {
					$this->httpError(500);
				}

				if($operation == 'add') {
					Member::currentUser()->BookmarkedEvents()->add($event->ID, $extraFields);
				} else {
					Member::currentUser()->BookmarkedEvents()->remove($event);
				}
				break;
			case 'service':
				$service = DataObject::get_by_id("SupportOrganization", (int)$ID);
				$extraFields = array('Created' => date('Y-m-d H:i:s'));
				if(!$service) {
					$this->httpError(500);
				}
				if($operation == 'add') {
					Member::currentUser()->BookmarkedServices()->add($service, $extraFields);
				} else {
					Member::currentUser()->BookmarkedServices()->remove($service);
				}
				break;
			case 'lesson':
				$lesson = DataObject::get_by_id("ELearning", (int)$ID);
				$extraFields = array('Created' => date('Y-m-d H:i:s'));
				if(!$lesson) {
					$this->httpError(500);
				}
				if($operation == 'add') {
					Member::currentUser()->BookmarkedLessons()->add($lesson, $extraFields);
				} else {
					Member::currentUser()->BookmarkedLessons()->remove($lesson);
				}
				break;
		}
	}

	public function dashboard() {

		if(!Member::currentUser()) {
			$this->redirect('/Security/login');
			return;
		} else if (Member::currentUser()->inGroup('Administrators')) {
			// $this->redirect('/admin/pages');
			// return;
		}
		$bookedEvents = Member::currentUser()->BookedEvents();
		$bookedEvents = PaginatedList::create($bookedEvents)->setPageLength(12)->setPaginationGetVar('booked-events-start');
		// $bookedEvents = DataList::create('Event');


		// $bookedEvents = Member::currentUser()->Attendees();
		// $bookedEvents = PaginatedList::create($bookedEvents)->setPageLength(12)->setPaginationGetVar('booked-events-start');

		$bookmarkedEvents = Member::currentUser()->BookmarkedEvents()->sort(array('isNEDC' => 'DESC', 'Created' => 'DESC'));
		$bookmarkedEvents = PaginatedList::create($bookmarkedEvents, $this->getRequest())->setPageLength(12)->setPaginationGetVar('bookmarked-events-start');

		$bookmarkedResources = Member::currentUser()->BookmarkedResources()->sort(array('isNEDC' => 'DESC', 'Created' => 'DESC'));

		$bookmarkedResources = PaginatedList::create($bookmarkedResources, $this->getRequest())->setPageLength(12)->setPaginationGetVar('bookmarked-resources-start');

		$bookmarkedLessons = Member::currentUser()->BookmarkedLessons()->sort('Created DESC');
		$bookmarkedLessons = PaginatedList::create($bookmarkedLessons, $this->getRequest())->setPageLength(12)->setPaginationGetVar('bookmarked-lessons-start');

		$bookmarkedServices = Member::currentUser()->BookmarkedServices()->sort('Created DESC');
		$bookmarkedServices = PaginatedList::create($bookmarkedServices, $this->getRequest())->setPageLength(12)->setPaginationGetVar('bookmarked-services-start');

		$latest_ebulletin = DataObject::get('ResearchResource')->filter('ArticleTypes.Name:PartialMatch', 'e-Bulletin')->sort('Created DESC')->limit(1);

		return $this->renderWith(array('Dashboard', 'Page'), array(
           'BookedEvents' => $bookedEvents,
           'BookmarkedEvents' => $bookmarkedEvents,
           'BookmarkedResources' => $bookmarkedResources,
           'BookmarkedLessons' => $bookmarkedLessons,
           'BookmarkedServices' => $bookmarkedServices,
           'AdminEmail'		=> SiteConfig::current_site_config()->AdminEmail,
           'EBulletin'	=> $latest_ebulletin
        ));
	}

	public function MemberUpdateForm() {
		$opportunities = DataObject::get('MembershipOpportunities')->map('ID', 'Title');
		$HowDidYouHearAboutUs = DataObject::get('HowDidYouHearAboutUs')->map('ID', 'Title');
    	$topics = DataObject::get('TopicsInterestedIn')->map('ID', 'Title');
    	$gender = Member::currentUser()->dbObject('Gender')->enumValues();
		$member = Member::currentUser();
		$form = new Form(
            $this,
            __FUNCTION__,
            $fiedlist  = FieldList::create(
            	DropdownField::create('Gender')
                    ->setSource($gender)
                    ->setValue($member->Gender),
                EmailField::create('EmailAlternate')
                	->setAttribute('placeholder','Your Alternative Email')
                	->setValue($member->EmailAlternate),
                PhoneField::create('Phone')
                	->setAttribute('placeholder','Contact Number')
                	->setValue($member->Phone),
                TextField::create('Postcode')
                	->setAttribute('placeholder', 'Post code')
                	->setValue($member->Postcode),
               	TextField::create('State')
                	->setAttribute('placeholder','State')
                	->setValue($member->State),
                TextField::create('City')
                	->setAttribute('placeholder','City/Suburb')
                	->setValue($member->City),
				TextField::create('Country')
					->setValue($member->Country),
                TextField::create('Oraganization')
                	->setAttribute('placeholder','Organization')
                	->setValue($member->Organization),
                TextField::create('OrganizationWebsite')
                	->setAttribute('placeholder','Organization Website')
                	->setValue($member->OrganizationWebsite),
                TextField::create('JobTitle')
                	->setAttribute('placeholder','Job Title')
                	->setValue($member->JobTitle),
                DropdownField::create('TopicsID', 'What topics are you interested in?')
                    ->setSource($topics)
                    ->setValue($member->TopicsID),
                DropdownField::create('MembershipID', 'What membership opportunities are you interested in? ')
                    ->setSource($opportunities)
					->setValue($member->MembershipID),
				DropdownField::create('HowDidYouHearAboutUsID', 'How did you hear about us?')
                    ->setSource($HowDidYouHearAboutUs)
                    ->setValue($member->HowDidYouHearAboutUsID)
            ),
            $actions = FieldList::create(
                new FormAction('MemberUpdateFormSubmit', 'Update')
            ),

            RequiredFields::create(
            	'FirstName','Surname','Username', 'Password', 'Email', 'Postcode', 'ProfessionGroupID', 'ProfessionID'
            )
        );
        $form->setFormAction('member/MemberUpdateForm');
        // $form->setFormMethod('POST');
        return $form;
	}

	public function MemberUpdateFormSubmit($data, $form) {

		$Member = Member::currentUser();
		$form->saveInto($Member);
		$Member->write(true);
		$form->sessionMessage('Awesome! Your details has been updated!', 'good');
  		return $this->redirectBack();
	}


}
