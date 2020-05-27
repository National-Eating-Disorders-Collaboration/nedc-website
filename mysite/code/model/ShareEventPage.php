<?php
/**
 *
 * @author Jem Lopez <jem@blissmedia.com.au>
 * @version  1.0.0
 * Front-end form for sharing events
 *
 */

class ShareEventPage extends Page
{

}

class ShareEventPage_Controller extends Page_Controller
{
	private static $allowed_actions = array('ShareEventForm');

	public function init()
    {
        parent::init();
        Requirements::css($this->ThemeDir()."/css/datepicker.css");
        Requirements::CustomScript(
        	"jQuery(document).ready(function() {
				$('.other-type').hide();
				// we know that 'other' will be pushed at the end of the aray
				$('#Form_ShareEventForm_Category li:last').on('click', function(){
					if($(this).find('input').is(':checked')) {
						$('.other-type').show();
					} else {
						$('.other-type').hide();
					}
				});

				var select = $('#Form_ShareEventForm_FreeOrPaid');
				select.on('change', function() {
					if($(this).val() == 'Paid') {
						$('#Form_ShareEventForm_Price').prop('disabled', false);
					} else {
						$('#Form_ShareEventForm_Price').prop('disabled', true);
					}
				});
			});
            "
        );
    }

	public function ShareEventForm()
	{
		$categories = DataObject::get('EventType')->map('ID', 'Title')->toArray();
		$state = DataObject::get('AustraliaState')->map('ID', 'Title');

		if (!empty($categories)) {
			array_push($categories, 'Other');
		}

		$fields = new FieldList(
			TextField::create('Organization', 'Organization')
		 		->setAttribute('placeholder', 'Organization'),
			TextField::create('Title', 'Event Title')
		 		->setAttribute('placeholder', 'Event Title'),
			TextareaField::create('About', 'Description')
				->setAttribute('placeholder', 'What is your event about?'),
			TextareaField::create('EventAudience', 'Event Audience')
				->setAttribute('placeholder', 'Who are your event audience?'),
			TextareaField::create('Requirements', 'Requirement')
				->setAttribute('placeholder', 'What are the requirements of your event?'),
			CheckboxSetField::create('Category', 'Event Type')
				->setSource($categories),
			TextField::create('Other', 'Other (Please Specify)')
				->setAttribute('placeholder', 'Specify other Category'),
		 	NumericField::create('Price', 'Ticket Price')
		 		->setAttribute('placeholder', 'Tricket Price e.g 90')
		 		->setAttribute('disabled', 'disabled'),
		 	TextField::create('ExternalForm', 'Ticket Form')
		 		->setAttribute('placeholder', 'www.your-event-registration-form.com'),
		 	TextField::create('Address', 'Address')
		 		->setAttribute('placeholder', '123 Main St, Docklands'),
		 	DropdownField::create('State', 'State')
		 		->setEmptyString('Select State')
				->setSource($state),
		 	DateField::create('Date[]', 'Date of Event')
		 		->setAttribute('placeholder', 'Date of your event')
		 		->addExtraClass('calendar'),
		 	TimeField::create('StartTime[]', 'Start Time')
		 		->setAttribute('placeholder', '08:00 or 8am'),
		 	TimeField::create('EndTime[]', 'End Time')
		 		->setAttribute('placeholder', '15:00 or 3pm '),
		 	TextField::create('Name', 'Speaker Name')
		 		->setAttribute('placeholder', 'John Smith'),
		 	TextField::create('Position', 'Position')
		 		->setAttribute('placeholder', 'CEO'),
		 	TextField::create('Company', 'Company Name')
		 		->setAttribute('placeholder', 'Delloitte'),
		 	EmailField::create('Email', 'Email Address')
		 		->setAttribute('placeholder', 'Contact\'s email address' ),
		 	TextField::create('Contact', 'Contact Number')
		 		->setAttribute('placeholder', 'Contact\'s phone number'),
		 	TextField::create('ContactPerson', 'Contact Person')
		 		->setAttribute('placeholder', 'Contact\'s name'),
		 	DropdownField::create('FreeOrPaid', 'Free or Paid')
		 		->setSource(array('Free' => 'Free', 'Paid' => 'Paid')),
		 	$image =  UploadField::create('Images','Upload Images (Sponsor\'s logo) (Optional)'),
		 	$file =  UploadField::create('File','Additional Files (Optional)')

		);

		$image->setCanAttachExisting(false);
		$image->setCanPreviewFolder(false);
		$image->relationAutoSetting = false;
		$image->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif','tiff'));
		$image->setFolderName('images/tmp-upload-logo-images');
		$image->setAllowedMaxFileNumber(3);

		$file->setCanAttachExisting(false);
		$file->setCanPreviewFolder(false);
		$file->relationAutoSetting = false;
		$file->setAllowedExtensions(array('pdf', 'doc','docx', 'pptx', 'xlsx'));
		$file->setFolderName('images/tmp-upload-files');
		$file->setAllowedMaxFileNumber(1);

		$actions = new FieldList(
			FormAction::create('submit', 'SEND')->setUseButtonTag(TRUE)->addExtraClass('btn--submit btn_submit submit_action')
		);
		$required = RequiredFields::create(
            'Title','Description', 'Date', 'StartTime', 'EndTime', 'State', 'ContactPerson', 'Email', 'Address', 'Category', 'ExternalForm'
        );

		$form =  Form::create($this, 'ShareEventForm', $fields, $actions, $required);

		return $form;
	}

	public function submit($data, $form)
    {

    	// Sharer should register first
    	$pd_id = DataObject::get('ProfessionalDevelopmentPage')->First();
    	$category = DataObject::get('EventType')->map('ID', 'Title');
    	$states = DataObject::get('AustraliaState')->map('ID', 'Title');
    	$email = SiteConfig::current_site_config();
    	$fullname = (Member::currentUserID() != '0') ? Member::currentUser()->getName() : $data['ContactPerson'];

    	if (! isset($pd_id->ID) && ! is_array($data)) {
    		return array(
	            'Content'	=> 'Sorry, we can\'t share your event right now',
	    	);
    	}

    	// Get Category Title
		if (!empty($category) && !empty($data['Category'])) {
			$result = array();
			foreach ($category as $k => $v) {
				foreach ($data['Category'] as $key => $value) {
					if ($k == $value) {
						$result[] = $v;
					}
				}
			}
			if(isset($result)) {
				$categories = implode(', ', $result);
			} else {
				$categories = ' ';
			}
		}
		// Get State Title
		if ($states) {
			foreach ($states as $key => $value) {
				if ($key == $data['State']) {
					$state = $value;
				} else {
					$state = ' ';
				}
			}
		}

		// Set date in another array form to save in database
		if (is_array($data)) {
			$data['Dates'] = array(
			'Date'		=> $data['Date'],
			'StartTime' => $data['StartTime'],
			'EndTime' 	=> $data['EndTime']
			);
		}

		// To populate the date onto template, has to be a Datalist
		$dates = new ArrayList();
		for ($i=0; $i < count($data['Dates']['Date']) ; $i++) {
			$dates[$i] = array(
				'Date'		=> $data['Date'][$i],
				'StartTime' =>  $data['StartTime'][$i],
				'EndTime' 	=>  $data['EndTime'][$i]
			);
			$data['DateForEmail'] = $dates;
		}

		// Save data to database
    	if (isset($pd_id->ID) && isset($data)) {

			// Save new user to Event table
			$Event = Event::create();
			$Event->Organization = $data['Organization'];
			$Event->Title = $data['Title'];
			$Event->isOwn = 0;
			$Event->Address = $data['Address'];
			$Event->EventAudience = $data['EventAudience'];
			$Event->About = $data['About'];
			$Event->Requirements = $data['Requirements'];
			$Event->Price = !empty($data['Price']) ? $data['Price'] : 0;
			$Event->Status = 'Pending';
			$Event->ExternalForm = $data['ExternalForm'];
			$Event->Contact = $data['Contact'];
			$Event->ContactPerson = $data['ContactPerson'];
			$Event->Email = $data['Email'];
			$Event->OtherType = $data['Other'];
			$Event->PDPageID = $pd_id->ID;
			$Event->AdditonalFileID = !empty($data['File']['Files']) ? $data['File']['Files'][0] : null; // adds only one
			$Event->SubmittedByID = !empty(Member::currentUserID()) ? Member::currentUserID() : '0';
			//$form->saveInto($Member);
			$Event->write();

			if ($Event->ID) {

				for ($i=0; $i < count($data['Dates']['Date']); $i++) {
					$TimeDate = EventTimeDate::create();
					$TimeDate->EventID = $Event->ID;
					$TimeDate->Date = $data['Date'][$i];
					$TimeDate->StartTime = $data['StartTime'][$i];
					$TimeDate->EndTime = $data['EndTime'][$i];
					$TimeDate->write();
				}

				$Speaker = Speaker::create();
				$Speaker->Name = $data['Name'];
				$Speaker->Position = $data['Position'];
				$Speaker->Company = $data['Company'];
				$Speaker->EventsID = $Event->ID;
				$Speaker->write();

				if ($imgs = isset($data['Images']['Files'])) {
					for ($i=0; $i < count($data['Images']['Files']) ; $i++) {
						$Logo = Logo::create();
						$Logo->EventID = $Event->ID;
						$Logo->ImageID = $data['Images']['Files'][$i];
						$Logo->write();
					}
				}
			}
			// Add many-many rel to the database
			if ($Event->ID) {
				$Event->EventType()->addMany($data['Category']);
				$Event->State()->add($data['State']);
			}

			if (!empty($Event) && isset($Event->ID)) {
				// Email to ADMIN

				$From = 'no-reply@nedc.com.au';
				$To   = $email->AdminEmail;
				$Subject = $fullname . " has shared an event";
				$message = $data['Title'];
				$email = new Email($From, $To, $Subject, $message);

				$email->setTemplate('ContactAdminShareEvent');
				$email->populateTemplate($data);
				$email->populateTemplate(array(
					'Category'	=> $categories,
					'State'		=> $state,
					'Member'	=> $fullname,
					'Dates'		=> $dates,
					'Images'	=> !empty($imgs) ? count($imgs) : ''
				));
				$send_attempt = $email->send();

				$member_email = (Member::currentUserID() != '0') ? Member::currentUser()->Email : $data['Email'];

				//Email to User
				$ConfirmationTo =  $member_email;
				$ConfirmationFrom =	'no-reply@nedc.com.au';
				$ConfirmationSubject = "Thanks for sharing your event, " . $fullname;
				$ConfirmationEmail = new Email($ConfirmationFrom, $ConfirmationTo, $ConfirmationSubject);
				$ConfirmationEmail->setTemplate('EmailToUserEvent');
				$ConfirmationEmail->populateTemplate($data);
				$ConfirmationEmail->populateTemplate(array(
						'Member'	=> $fullname
				));
				$ConfirmationSend_attempt = $ConfirmationEmail->send();

		        $results = array(
		            'Content'		=> '<h3>Thanks for sharing your event. Events are sent to the admin and are pending for approval. Do not refresh your page. Redirecting...</h3>',
		            'ShareEventForm'	=> false,
		        );
		        return $this->customise($results)->renderWith(array('ShareEventPage_success', 'Page'));
		    } else {

		    	$this->redirectBack();
		    }
	    }
    }
}
