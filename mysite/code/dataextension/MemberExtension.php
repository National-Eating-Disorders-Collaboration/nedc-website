<?php
/**
 *
 */

class MemberExtension extends DataExtension
{
	private static $db = array(
		'Username'			    => 'Varchar(155)',
		'Gender'			    => 'Enum("Male, Female, Other")',
		'EmailAlternate'	    => 'Varchar(155)',
		'EmailBounced'		    => 'Boolean',
		'Postcode'			    => 'Varchar(10)',
		'PostalAddress'	        => 'Varchar(255)',
		'City'				    => 'Varchar(155)',
		'State'	    		    => 'Varchar(155)',
		'Country'			    => 'Varchar',
		'Phone'				    => 'Varchar(155)',
		'Organization'		    => 'Varchar(155)',
		'JobTitle'			    => 'Varchar(155)',
		'OrganizationWebsite'	=> 'Varchar(155)',
		'OtherInterest'			=> 'Varchar(155)',
		'OtherProfession'		=> 'Varchar(155)',
		'OtherProfessionGroup'  => 'Varchar(155)'
	);

	private static $default_country = 'AU';

	private static $has_one = array(
		'ProfessionGroup' 	    => 'ProfessionGroup',
		'Profession'		    => 'Profession',
        'HowDidYouHearAboutUs'  => 'HowDidYouHearAboutUs',
        'AgeGroup'              => 'AgeGroup',
        'Interest'              => 'InterestBecomingMember'
    );

    private static $summary_fields = array(
		'Created.Nice' => 'Joined',
		'Created' => 'Created',
		'FirstName'   => 'FirstName',
		'Surname'	=> 'Surname',
        'Email'     => 'Email',
        'Username'  => 'Username',
        'Postcode'  => 'Postcode',
        'Gender'    => 'Gender',
        'Postcode' => 'Postcode',
        'PostalAddress' => 'PostalAddress',
        'State' => 'State',
        'City' => 'City',
        'Country' => 'Country',
        'Phone' => 'Phone',
        'Organization' => 'Organization',
        'JobTitle' => 'JobTitle',
        'OrganizationWebsite' => 'OrganizationWebsite',
        'ProfessionGroup.Title'       => 'ProfessionGroup',
        'Profession.Title'            => 'Profession',
        'AgeGroup.Title'      => 'AgeGroup',
        'HowDidYouHearAboutUs.Title' => 'HowDidYouHearAboutUs',
        'Interest.Title'    => 'Interest'
    );
	private static $many_many = array(
    	'BookmarkedResources' 	    => 'ResearchResource',
    	'BookmarkedEvents' 		    => 'Event',
    	'BookmarkedServices' 	    => 'SupportOrganization',
    	'BookmarkedLessons'     	=> 'ELearning',
    	'BookedEvents'			    => 'Event',
        'Topics'                    => 'TopicsInterestedIn',
        'MembershipOpportunities'   => 'MembershipOpportunities',
	);

	private static $many_many_extraFields = array(
		"BookmarkedResources" => array(
			'isNEDC'	=> "Boolean",
			'Created'	=> "SS_DateTime"
		),
		"BookmarkedEvents" => array(
			'isNEDC'	=> "Boolean",
			'Created'	=> "SS_DateTime"
		),
		"BookmarkedServices" => array(
			'Created'	=> 'SS_DateTime'
		),
		"BookmarkedLessons" => array(
			'Created'	=> 'SS_DateTime'
		)
	);


	public function getCMSFields() {
		$f = parent::getCMSFields();
		$f->removeByName('Topics');
		$f->removeByName('BookmarkedResources');
		$f->removeByName('BookmarkedEvents');
		$fields->addFieldToTab('Root.Main', CountryDropdownField::create('Country', 'Country'));

		return $f;
	}

     public function updateSummaryFields(&$fields) {
        $fields = Config::inst()->get($this->class, 'summary_fields');

    }

    public function getExportFields() {
        return array(
            'Name' => 'FirstName',
        );
	}

}
