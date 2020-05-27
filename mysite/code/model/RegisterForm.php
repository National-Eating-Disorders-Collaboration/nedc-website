<?php
/**
 *
 */

class RegisterForm extends Page
{

    private static $has_many = array(
        'Profession'            => 'Profession',
        'ProfessionGroup'       => 'ProfessionGroup',
        'Membership'            => 'MembershipOpportunities',
        'Topics'                => 'TopicsInterestedIn',
        'HowDidYouHearAboutUs'  => 'HowDidYouHearAboutUs',
        'AgeGroup'              => 'AgeGroup',
        'Interest'              => 'InterestBecomingMember'
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Proffesion', GridField::create(
            'Profession',
            'Profession',
            $this->Profession(),
            GridFieldConfig_RelationEditor::create()
        ));

        $fields->addFieldToTab('Root.Proffesion', GridField::create(
            'ProfessionGroup',
            'ProfessionGroup',
            $this->ProfessionGroup(),
            GridFieldConfig_RelationEditor::create()
        ));

        $fields->addFieldToTab('Root.MembershipOpportunities', GridField::create(
            'Membership',
            'Membership Interested in',
            $this->Membership(),
            GridFieldConfig_RelationEditor::create()
        ));

        $fields->addFieldToTab('Root.TopicsInterested', GridField::create(
            'Topics',
            'Topics interested in',
            $this->Topics(),
            GridFieldConfig_RelationEditor::create()
        ));

        $fields->addFieldToTab('Root.HowDidYouHearAboutUs', GridField::create(
            'HowDidYouHearAboutUs',
            'HowDidYouHearAboutUs',
            $this->HowDidYouHearAboutUs(),
            GridFieldConfig_RelationEditor::create()
        ));

        $fields->addFieldToTab('Root.AgeGroup', GridField::create(
            'AgeGroup',
            'AgeGroup',
            $this->AgeGroup(),
            GridFieldConfig_RelationEditor::create()
        ));

        $fields->addFieldToTab('Root.InterestBecomingNEDC', GridField::create(
            'Interest',
            'Interest',
            $this->Interest(),
            GridFieldConfig_RelationEditor::create()
        ));
        return $fields;
    }
}

class RegisterForm_Controller extends Page_Controller
{

    private static $allowed_actions = array(
        'RegisterForm'
    );

    public function init()
    {
        parent::init();
        Requirements::css($this->ThemeDir()."/css/datepicker.css");
        Requirements::CustomScript(
            "jQuery(document).ready(function() {

                $('select.other-profession').on('change', function(){
                    if($('select.other-profession option:last').is(':selected')) {
                        $(this).closest('div').find('.other').removeClass('hide');
                    } else {
                        $(this).closest('div').find('.other').addClass('hide');
                    }
                });

                $('select.other-interest').on('change', function(){
                    if($('select.other-interest option:last').is(':selected')) {
                        $(this).closest('div').find('.other').removeClass('hide');
                    } else {
                        $(this).closest('div').find('.other').addClass('hide');
                    }
                });

                $('.countrydropdown option:selected').attr('selected', false);
            });
            "
        );
    }

    public function RegisterForm(){

    	$professions = DataObject::get('Profession')->map('ID', 'Title')->toArray();
    	$profession_groups = DataObject::get('ProfessionGroup')->map('ID', 'Title')->toArray();
        $gender = Member::get()->dbObject('Gender')->enumValues();

        $age = DataObject::get('AgeGroup')->map('ID', 'Title');
        $interest = DataObject::get('InterestBecomingMember')->map('ID', 'Title')->toArray();

        $fields = FieldList::create(
            TextField::create('FirstName')
            	->setAttribute('placeholder','First Name'),
            TextField::create('Surname')
            	->setAttribute('placeholder','Last Name'),
            TextField::create('Username')
            	->setAttribute('placeholder','Username'),
            PasswordField::create('Password')
            	->setAttribute('placeholder','Password'),
            EmailField::create('Email')
            	->setAttribute('placeholder','Your Email'),
            DropdownField::create('Gender')
                ->setSource($gender),

            TextField::create('Postcode')
                ->setAttribute('placeholder','Enter & Choose postcode'),

            HiddenField::create('City'),
            HiddenField::create('State'),
            HiddenField::create('Country'),

             DropdownField::create('AgeGroupID')
                ->setSource($age),
            DropdownField::create('ProfessionGroupID')
                ->setSource($profession_groups),
            DropdownField::create('ProfessionID')
                ->setSource($professions)
                ->addExtraClass('other-profession'),
            DropdownField::create('InterestID')
                ->setSource($interest)
                ->addExtraClass('other-interest'),
            // Other fields
            TextField::create('OtherInterest')
                ->setAttribute('placeholder','Other (please specify)'),
            TextField::create('OtherProfession')
                ->setAttribute('placeholder','Other (please specify)'),

            CheckboxField::create('TNC', 'I agree to Terms & Conditions')
        );

        $actions = FieldList::create(
            FormAction::create('register', 'Sign up')
        );
        $required = RequiredFields::create(
        	'FirstName','Surname','Username', 'Password', 'Email', 'Postcode', 'TNC'
        );

         $form = new Form($this, 'RegisterForm', $fields, $actions, $required );
         $form->enableSpamProtection();
        return $form;
    }

    public function register($data, $form)
    {
    	$member = Member::get()->filter('Email', $data['Email'])->first();

    	if ($member) {
    		$message = "Sorry, that email already exist.";
	    	$form->addErrorMessage('Email', $message,'bad');
            return $this->redirectBack();
    	}
    	else
    	{
			// Save new user to member table
			$Member = Member::create();
			$form->saveInto($Member);
			$save = $Member->write();

            // Save message database
            if ($save) {
                $Message = new Message();
                $Message->Name = $data['FirstName'] . ' ' . $data['Surname'];
                $Message->Area = 'Register Form';
                $Message->Email = $data['Email'];
                $Message->write();
            }

			// Add this member to user group
			$user_group = DataObject::get_one('Group', "ID = 3");
			if ($user_group) {
				$Member->Groups()->add($user_group);
			}

            //Email to User
            $ConfirmationTo = $data['Email'];
            $ConfirmationFrom = "no-reply@nedc.com.au";
            $ConfirmationSubject = "You are registered, " . $data['FirstName'] . ' ' . $data['Surname'];
            $ConfirmationEmail = new Email($ConfirmationFrom, $ConfirmationTo, $ConfirmationSubject);
            $ConfirmationEmail->setTemplate('RegistrationConfirmation');
            $ConfirmationEmail->populateTemplate($data);
            $ConfirmationSend_attempt = $ConfirmationEmail->send();

            // Email notification
            $message = <<<EOD
            Hi Admin,<br><br>
            This is to inform you that {$data['FirstName']} {$data['Surname']} has registered to www.nedc.com.au.<br><br>
            Thanks,<br>
            NEDC Website
EOD;
            // Email to ADMIN (Whoever is recieving the email)
            $email_admin = SiteConfig::current_site_config();
            $From = "no-reply@nedc.com.au";
            $To   = $email_admin->AdminEmail;
            $Subject = "Website registration from " .  $data['FirstName'];
            $email = new Email($From, $To, $Subject, $message);
            $send_attempt = $email->send();             //send mail

            return array(
	            'Content'		=> '<div style="padding: 100px 0;"><h3>Thanks for registering! Redirecting to login... </h3></div>',
	            'RegisterForm'	=> false
        	);
		}
    }
}
