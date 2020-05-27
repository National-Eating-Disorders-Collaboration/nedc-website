<?php
/**
 * @author Jem Lopez <jem@blissmedia.com.au>
 * @version  1.0.0
 * Front-end form for sharing australian case studies
 */
class ShareStudiesPage extends Page
{

}

class ShareStudiesPage_Controller extends Page_Controller
{
	private static $allowed_actions = array('ShareStudiesForm', 'submit'
	);

	public function init()
    {
        parent::init();
        Requirements::css($this->ThemeDir()."/css/datepicker.css");
    }

	public function ShareStudiesForm()
	{
		$categories = DataObject::get('ResourceArticleType')->filterAny('Name:PartialMatch', 'Study')->map('ID','Title')->toArray();

		$fields = new FieldList(
			TextField::create('Title', 'Case Study Title')
		 		->setAttribute('placeholder', 'Case Study Title'),
			TextField::create('Author', 'Research Team')
		 		->setAttribute('placeholder', 'e.g. Dr John Smith (PsySc), Edward Hill (PHD) '),
		 	TextField::create('Institution', 'Institution')
		 		->setAttribute('placeholder', 'The University of Queensland '),
		 	TextField::create('EthicsApprovalNumber', 'Ethics Approval number')
		 		->setAttribute('placeholder', 'Ethics approval number'),
		 	TextField::create('FundingSource', 'Funding Source')
		 		->setAttribute('placeholder', 'Funding Source'),
		 	DateField::create('ProjectStartDate', 'ProjectStartDate')
		 		->setAttribute('placeholder', 'Project Date commence')
				 ->addExtraClass('calendar'),
			DateField::create('ProjectEndDate', 'ProjectEndDate')
		 		->setAttribute('placeholder', 'Project Date ends')
		 		->addExtraClass('calendar'),
		 	DropdownField::create('Category', 'Category')
		 		->setEmptyString('Select Type')
				->setSource($categories),
			TextareaField::create('Participants', 'Participants')
				->setAttribute('placeholder', 'Who are your participants?'),
			TextareaField::create('Description', 'Description of Project')
				->setAttribute('placeholder', 'Brief Description'),
			TextareaField::create('WhatsInvolved', 'What is involved')
				->setAttribute('placeholder', 'What is involved?'),
			TextField::create('Location', 'Location')
		 		->setAttribute('placeholder', 'Location/Link'),
		 	TextField::create('ContactDetails', 'Contact Details')
		 		->setAttribute('placeholder', 'Person/Number/Email'),

		 	$file =  UploadField::create('File','Upload Ethics Approval')
		);

		$file->setCanAttachExisting(false);
		$file->setCanPreviewFolder(false);
		$file->relationAutoSetting = false;
		$file->setAllowedExtensions(array('doc', 'pdf', 'docx', 'pdf', 'xls', 'csv'));
		$file->setFolderName('files/tmp-share-studies');
		$file->setAllowedMaxFileNumber(1);

		$actions = new FieldList(
			FormAction::create('submit', 'SEND')->setUseButtonTag(TRUE)->addExtraClass('btn--submit btn_submit submit_action')
		);
		$required = RequiredFields::create(
            'Title','Category', 'Description'
        );

		$form =  Form::create($this, 'ShareStudiesForm', $fields, $actions, $required);

		return $form;
	}

	public function submit($data, $form)
	{
		$fullname = Member::currentUser()->getName();
    	$category = DataObject::get('ResourceArticleType')->map('ID', 'Title');
    	$admin_email= SiteConfig::current_site_config();

    	if (! is_array($data) || !isset($data) ) {
    		return array(
	            'Content'	=> 'Sorry, we can\'t share your case studies right now',
	    	);
    	}

    	if (is_array($data) && isset($data)) {
    		$Studies = new ResearchResource();
    		$Studies->Title = $data['Title'];
    		$Studies->Author = $data['Author'];
    		$Studies->Institution = $data['Institution'];
    		$Studies->EthicsApprovalNumber = $data['EthicsApprovalNumber'];
    		$Studies->FundingSource = $data['FundingSource'];
    		$Studies->ProjectStartDate = $data['ProjectStartDate'];
    		$Studies->ProjectEndDate = $data['ProjectEndDate'];
    		$Studies->Participants = $data['Participants'];
    		$Studies->Description = $data['Description'];
    		$Studies->WhatsInvolved = $data['WhatsInvolved'];
    		$Studies->Location = $data['Location'];
    		$Studies->ContactDetails = $data['ContactDetails'];
    		$Studies->SubmittedStudies = 'Pending';
    		$Studies->isAustralianCaseStudies = '1';
    		$Studies->EthicsApprovalFileID = !empty($data['File']['Files']) ? $data['File']['Files'][0] : null;
    		$Studies->SubmittedByID = Member::currentUserID();
    		$Studies->write();

			if ($Studies->ID) {
				$Studies->ArticleTypes()->add($data['Category']);
			}
    	}

    	if(!empty($Studies) && isset($Studies->ID)) {

			// Email to ADMIN
			$From = 'no-reply@nedc.com.au';
			$To   = $admin_email->AdminEmail;
			$Subject = $fullname . " has shared a case study";
			$message = $data['Title'];

			$email = new Email($From, $To, $Subject, $message);
			$email->setTemplate('ContactAdminShareStudies');
			$email->replyTo(Member::currentUser()->Email);
			$email->populateTemplate($data);
			$email->populateTemplate(array(
				'Member'	=> $fullname,
				'Files'		=> !empty($data['File']) ? count($data['File']['Files']) : ''
			));
			$email->send();

			//Email to User
			$ConfirmationTo =  Member::currentUser()->Email;
			$ConfirmationFrom =	'no-reply@nedc.com.au';
			$ConfirmationSubject = "Thanks for sharing your studies, " . $fullname;
			$ConfirmationEmail = new Email($ConfirmationFrom, $ConfirmationTo, $ConfirmationSubject);
			$ConfirmationEmail->setTemplate('EmailToUserStudies');
			$ConfirmationEmail->populateTemplate($data);
			$ConfirmationEmail->populateTemplate(array(
					'Member'	=> $fullname
			));
			$ConfirmationEmail->send();

	        $results = array(
            'Content'		=> '<h3>Thanks for sharing your studies. Case Studies are sent to the admin and are pending for approval. Do not refresh your page. Redirecting...</h3>',
            'ShareStudiesForm'	=> false,
	        );

	        return $this->customise($results)->renderWith(array('ShareStudiesPage_success', 'Page'));

    	} else {
    		$this->redirectBack();
    	}
	}
}
