<?php
/**
 *
 * Professional Development Page that holds all the events
 * @date 2017-08-17
 * @author  Jem Lopez <jem@blissmedia.com.au>
 * @version  1.0.3
 *
 *
 */
class ProfessionalDevelopmentPage extends Page
{
	private static $allowed_children = array('ELearningPage', 'StandardPage', 'ShareEventPage');

	private static $has_many = array(
		'Events'		=> 'Event',
		'Carousel'		=> 'Carousel',
		'SideBlocks'	=> 'SideBlocks',
		'SeeAlsoSection'	=> 'SeeAlsoSection'
	);

	private static $has_one = array(
		'BecomeMember'	=> 'BecomeMember'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$config = GridFieldConfig_RelationEditor::create();
		$config->addComponent(new GridFieldSortableRows('SortOrder'));
		
		$fields->addFieldToTab('Root.Events', $g = GridField::create(
			'Events',
			'Events',
			$this->Events(),
			GridFieldConfig_RecordEditor::create()
		));

		$fields->addFieldToTab('Root.Carousel', $g = GridField::create(
			'Carousel',
			'Carousel',
			$this->Carousel(),
			$config
		));

		$fields->addFieldToTab('Root.SideBox', $g = GridField::create(
			'SideBlocks',
			'SideBlocks',
			$this->SideBlocks(),
			$config
		));

		$fields->addFieldToTab('Root.SeeAlso', $g = GridField::create(
			'SeeAlso',
			'SeeAlso',
			$this->SeeAlsoSection(),
			$config
		));

		$g->getConfig()->getComponentByType('GridFieldAddNewButton')->setButtonName('Add');
		$text = TextField::create('BecomeMember-_1_-Title', 'Title');
		$desc = TextAreaField::create('BecomeMember-_1_-Description', 'Description');
		$link = LinkField::create('BecomeMember-_1_-LinkID', 'Link');
		$button = LinkField::create('BecomeMember-_1_-ButtonID', 'Button');


		$fields->addFieldsToTab('Root.BecomeMember', array($text, $desc, $link, $button));

		return $fields;
	}
	/**
	 *  Get the sorted Events latest and published
	 *  @return obj
	 */
	public function getSortedEvents() {
		$date = date('Y-m-d', strtotime('-1 days'));
		$events = Event::get()->filter(array('EventTimeDate.Date:GreaterThan' => $date, 'Status' => 'Published'));
		$next_date = new ArrayList();
		
		// Get the lastest date from an array of dates - limit of 1
		$nd_events = DB::query('SELECT e.ID, (SELECT "Date" FROM "EventTimeDate" WHERE "Date" > CURDATE() AND "EventID" = e.ID ORDER BY "Date" LIMIT 1) 
		nd  FROM "Event" e WHERE e.Status = \'Published\' ORDER BY nd ');
		
		foreach ($nd_events as $item) {
			$next_date[] = $item;
		}


		$results = new ArrayList();
		$state = array();
		// Map ID 
		// @TODO: CLEAN THIS UPP!!
		foreach($events as $event) {
			
			foreach($next_date as $date) {
				if($event->ID == $date->ID) {
					$next = $date->nd;
				}
			}

			foreach($event->State()->First() as  $states) {
				// @TODO make this an array as this is many_many relation
				$state = $states->ID;
			}

			$event->NextDate = $next;
			$event->State = $state;
			$results[] = $event;
		}

		$final = $results->sort(array('NextDate' =>  'ASC'));

		return $final;
	}

}

class ProfessionalDevelopmentPage_Controller extends Page_Controller
{

	static $url_segment = 'professional-development';

	private static $allowed_actions = array(
		'index',
		'event',
		'results',
		'LoginForm',
		'EventRegistrationForm',
		'submitRegistration'
	);

	private static $url_handlers = array(
		'$Action//$ID/$OtherID/$SubAction' => 'handleAction',
	);

	public function init()
	{
		parent::init();
		Requirements::CustomScript("
            jQuery(document).ready(function()
            {
                jQuery(function(){
                	function getUrl(state, isOwn) {
                		return '". $this->Link() . "SearchForm?State='+ state +'&isOwn='+ isOwn +'&Type=&action_results=Browse+All';
                	}
					var states = $('#au_states_events');
					states.on('change', function() {
						var id = $(this).val();
						var currenturl = location.href;
						var state = id;
						window.location.replace(getUrl(state, '". $this->getParameter('isOwn') ."'),'_self');
					});
					states.val(".$this->getParameter('State').");
					$('.sort_by').on('click', function(){
						var data = $(this).data('url');
						switch (data) {
							case 'nedc':
								var isOwn = 'nedc';
								break;
							case 'other':
								var isOwn = 'other';
								break;
							case 'all':
								var isOwn = '';
								break;
							default:
								$(this).addClass('active');
								break;
						}
						window.location.replace(getUrl('".$this->getParameter('State')."', isOwn), '_self');
					});
					var url = '". $this->getParameter('isOwn') ."';
					if (url == '') {
						var url = 'all';
					}
					$('.sort_by').each(function(){
						var data = $(this).data('url');
						if (url == data)  {
							$(this).addClass('active');
						}
					});

					$('#Form_EventRegistrationForm_action_submitRegistration').on('click', function(e) {
						$('label > span').empty();
						if($('.checkboxset input:checked').length == 0) {
							e.preventDefault();
							$('<span> <br>Please select date and time </span>').insertBefore('.checkboxset').css('color', 'red');
						}
					});
                });
            })
       ");
	}
	/**
	 * Onload events
	 * @date    2017-08-02
	 * @version 1.0.0
	 * @param   SS_HTTPRequest $request [description]
	 * @return  [type]                  [description]
	 */
	public function index(SS_HTTPRequest $request)
	{
		return array('Results' => $this->getSortedEvents()->limit(4));
	}

	/**
	 * List Individual Events
	 * @date    2017-08-01
	 * @version 1.0.0
	 * @param   SS_HTTPRequest $request [getVars]
	 * @return  [obj]
	 */
	public function event(SS_HTTPRequest $request)
	{
		$event  = DataObject::get('Event')->byID($request->param('ID'));

		if (! $event ) {
			throw new Exception("Can't find event", 404);
		}
		if ( $request->param('SubAction') && $request->param('SubAction') == 'calendar') {
			$this->downloadICS($event);
		}

		return array(
			'Event' => $event,
			'Title' => $event->Title,
		);
	}
	/**
	 * Search for events
	 * @date    2017-08-03
	 * @version 1.0.0
	 */
	public function EventForm()
	{
		$state = DataObject::get('AustraliaState')
				->map('ID', 'Title')
				->toArray();

		$sort = array(
			'other'	=> 'Other',
			'nedc' => 'NEDC',
			''	=> 'All'
		);

		$types = DataObject::get('EventType')
				->map('ID', 'Title')
				->toArray();

		$form = Form::create(
			$this,
			__FUNCTION__,
			$fields = FieldList::create(
				DropdownField::create('State')
					->setEmptyString('Australia')
					->setSource($state),
				OptionsetField::create('isOwn')
					->setSource($sort),
				DropdownField::create('Type')
					->setEmptyString('All')
					->setSource($types)
			),
			$actions = FieldList::create(
				FormAction::create('results', 'Browse All')
					->addExtraClass('state')
			)
		);
		$form = SearchForm::create($this, 'SearchForm', $fields, $actions);

		$form->setFormAction(Controller::join_links(BASE_URL, $this->URLSegment, "SearchForm"))
			->setFormMethod('GET')
			->disableSecurityToken()
			->loadDataFrom($this->request->getVars());
		return $form;
	}
	/**
	 * Results page from EventForm() variables
	 * @date    2017-08-03
	 * @version 1.0.0
	 * @param   [array]     $data
	 * @param   [$form]     $form
	 * @param   [vars]     $request
	 * @return  [paginated array]
	 */
	public function results($data, $form, SS_HTTPRequest $request)
	{
	
		$events =  $this->getSortedEvents();
	
		if ($nedc = $request->getVar('isOwn')) {
			// For some reason, false in boolean is skipped when filtering objs
			$nedc == 'other' ? $nedc = 0 : $nedc = 1 ;
			$events = $events->filter('isOwn', $nedc);
		}

		if ($state = $request->getVar('State')) {
			$events = $events->filter('State', $state);
		}

		// Set $data as array
		$data['Result'] = $events;

		// Paginate list items/ 6 per page
        $paginated_event = PaginatedList::create(
            $events,
            $data
        )->setPageLength(6);

        // Parse results
		$results = array(
			'Results' => $paginated_event,
		);

		return $this->customise($results)->renderWith(array('ProfessionalDevelopmentPage_Results', 'Page'));
	}
	/**
	 * Get current param for sorting
	 * @date    2017-08-04
	 * @version 1.0.0
	 * @param   string     $param [get param from url]
	 * @return  [string]
	 */
	public function getParameter($param = '')
	{
		if ($this->request) {
			$vars = $this->request->requestVars();
			if (isset($vars[$param])) {
				return $vars[$param];
			}
		}
		return false;
	}

    /**
     * Event registration form
     * @date    2017-09-21
     * @version 1.0.0
     */
    public function EventRegistrationForm() {

		$ID = $this->getRequest()->param('ID');
		$event = DataObject::get('Event')->byID($ID);
		$date = $event->EventTimeDate()->toArray();
		$member = Member::currentUser();

		$list_date = array();
		foreach ($date as $rec) {
			$day = date('F jS', strtotime($rec->Date));
			$start = date('g:ia', strtotime($rec->StartTime));
			$end = date('g:ia', strtotime($rec->EndTime));

			$list_date[$rec->ID] =  $day . " " . $start . ' to ' . $end;
		}

		$state = DataObject::get('AustraliaState')->map('ID', 'Title');

		$fields = new FieldList(
			TextField::create('FirstName', 'FirstName')
		 		->setAttribute('placeholder', 'First Name')
		 		->setValue(isset($member) ? $member->FirstName : ''),
		 	HiddenField::create('EventID', $ID)
		 		->setValue($ID),
		 	TextField::create('Surname', 'Surname')
		 		->setAttribute('placeholder', 'Surname')
		 		->setValue(isset($member) ? $member->Surname : ''),
		 	EmailField::create('Email', 'Email Address *')
		 		->setAttribute('placeholder', 'Enter your email address' )
		 		->setValue(isset($member) ? $member->Email : ''),
		 	TextField::create('PostCode', 'Post code')
		 		->setAttribute('placeholder', 'Post code or City'),
			TextField::create('State', 'State *')
				->setAttribute('placeholder', 'State')
				->setAttribute('disabled', 'disabled'),
		 	TextField::create('Organisation', 'Organisation')
		 		->setAttribute('placeholder', 'Enter Organisation'),
			TextareaField::create('FoodRequirements', 'Food Requirements')
				->setAttribute('placeholder', 'Please Specify'),
			CheckboxSetField::create('ChooseSession', 'Choose Session')
				->setSource($list_date)
		);

		$actions = new FieldList(
			FormAction::create('submitRegistration', 'SEND')->setUseButtonTag(TRUE)->addExtraClass('btn--submit btn_submit submit_action')
		);
		$required = RequiredFields::create(
            'FirstName', 'Surname', 'Email', 'PostCode', 'Organisation', 'ChooseSession'
        );

		$form =  Form::create($this, 'EventRegistrationForm', $fields, $actions, $required);
		$form->setFormAction($this->Link('submitRegistration'));

        return $form;
    }

    public function submitRegistration($data) {

    	if (! isset($data)) {
    		throw new Exception("Can't find event", 404);
    	}
    	$member = Member::currentUserID();
    	$Attendee = new Attendee();
    	$Attendee->FirstName = $data['FirstName'];
    	$Attendee->Surname = $data['Surname'];
    	$Attendee->Email = $data['Email'];
    	$Attendee->Age = $data['Age'];
    	$Attendee->Organisation = $data['Organisation'];
    	$Attendee->FoodRequirements = $data['FoodRequirements'];
    	$Attendee->EventID = $data['EventID'];
    	$Attendee->State = $data['State'];
    	$Attendee->PostCode = $data['PostCode'];
    	$Attendee->MemberID = ! empty($member) ? $member : '0';
    	$send = $Attendee->write();

    	if ($Attendee->ID) {
    		$Attendee->Date()->addMany($data['ChooseSession']);
    	}

    	if($send) {
    		if (! empty($member)) {
    			$booked = DataObject::get('Event')->byID($data['EventID']);
    			Member::currentUser()->BookedEvents()->add($booked);
    		}
    	}

    	$e = DataObject::get('Event')->byID($data['EventID']);
    	$to = $data['Email'];
    	$from = 'no-reply@nedc.com.au';
    	$subject = 'Thanks for registering to one of our events.';
    	$message = <<<X
Hi {$data['FirstName']},
<br>
You have recently registered to this event, <a href="{$e->Link()} ">{$e->Title}</a>.
<br>
Thanks,
<br>
NEDC Admin
X;
    	$email = new Email($from, $to, $subject, $message);
    	$send = $email->send();

    	if ($send) {
			if ($member) {
				return $this->redirectBack();
			}
		    $success = array(
		    	'Content' => 'Thanks! You are registered.',
		    	'Back'	=> $this->AbsoluteLink() . $e->Link(),
		    );
		    return $this->customise($success)->renderWith(array('ProfessionalDevelopmentPage_success', 'Page'));
		}

		return $this->redirectBack();
    }

   	public function LoginForm() {
   		if($this->getRequest()->isGET()){
			$event_link = DataObject::get('Event')->byID($this->getRequest()->param('ID'));
			$login = MemberAuthenticator::get_login_form($this);
			$login->setFormAction($login->FormAction() . '?BackURL=' . urlencode(Director::absoluteBaseURL() . $event_link->Link()));
			return $login;
		} else {
			return parent::LoginForm();
		}
	}

		/**
	 * DELETED AS PER CLIENT REQUEST -- Download event as .ICS
	 * Able to handle multiple events in one ICS
	 * @todo 	if the user only one date for an event, replace the link 'add to calendar' and add to each date info e.g ' 23 Sept 2017 10am'
	 * @date 	2017-09-19 (DELETED)
	 * @date    2017-09-08
	 * @version 1.0.0
	 * @param   [$obj]     $event [individual event obj]
	 * @return  string
	 */
    // public function downloadICS($event) {
    // 	// Set ICS config header
    // 	header('Content-Type: text/calendar; charset=utf-8');
	// 	header('Content-Disposition: attachment; filename=invite.ics');
	// 	// Get has-many rel time and date
	// 	$date =  $event->EventTimeDate();
	// 	// init arrays
	// 	$start = array();
	// 	$end = array();
	// 	$ics = array();
	// 	//init output
	// 	$output = '';
	// 	// Loop over the date
	// 	for($x = 0; $x < count($date); $x++) {
	// 		// init and concat date, starttime, endtime
	// 		$start[] = $date[$x]->Date . ' ' . $date[$x]->StartTime;
	// 		$end[] = $date[$x]->Date . ' ' . $date[$x]->EndTime;
	// 		// get link
	// 		$link = $this->AbsoluteLink() . 'event/' . $event->ID;

	// 		if (isset($date)) {
	// 			$ics[$x] = array(
	// 			  'location' => $event->Address,
	// 			  'description' => 'Visit link below to read more.',
	// 			  'dtstart' => $start[$x],
	// 			  'dtend' => $end[$x],
	// 			  'summary' => $event->Title,
	// 			  'url' => $link,
	// 			  'uid'=> uniqid()
	// 			);
	// 		}
	// 		// get ICS class and pass each obj as ics properties
	// 		$ics_obj = new ICS($ics[$x]);
	// 		// append each properties
	// 		$output .= "\n". $ics_obj->to_string();
	// 	}
	// 	// removed ICS heading properties on the ICS class and append it here
	// 	$head = array(
	// 		'BEGIN:VCALENDAR',
	// 		'VERSION:2.0',
	// 		'PRODID:-//hacksw/handcal//NONSGML v1.0//EN',
	// 		'CALSCALE:GREGORIAN',
	// 	);

	// 	$footer = "\n" . "END:VCALENDAR";
	// 	// echo as string
	// 	echo implode("\r\n", $head) . $output . $footer ;
	// 	exit;
    // }

}
