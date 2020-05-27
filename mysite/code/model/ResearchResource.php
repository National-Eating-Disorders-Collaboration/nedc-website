<?php

class ResearchResource extends DataObject {
	private static $db = array(
        // 'Type' => "Enum('Resource,Research,Australian Study', 'Resource')",
        // 'FullText' => 'Boolean',
        'isAustralianCaseStudies' => 'Boolean',
        'SubmittedStudies' => 'Enum("Accepted, Pending, Declined","Accepted")',
        'Title'  => 'Varchar(255)',
        'Format' => 'Varchar',
        'Description' => 'HTMLText',
        'Author' => 'Varchar(255)',
        'Journal' => 'Varchar',
        'Volume' => 'Varchar',
        'isNEDC' => 'Boolean',
        'PDFAvailable' => 'Boolean',
        'Publisher' => 'Varchar',
        'Year' => 'Int',
        'Country' => 'Varchar',
        'Free' => 'Boolean',
        'AvailableFrom' => 'Varchar',
        'Address' => 'Text',
        'Phone' => 'Varchar',
        'Fax' => 'Varchar',
        'Website' => 'Text',
        'ExternalLink' => 'Text',
        'Publication' => 'Varchar',
        'Institution' => 'Varchar',
        'EthicsApprovalNumber' => 'Varchar',
        'FundingSource' => 'Text',
        'ProjectStartDate' => 'Date',
        'ProjectEndDate' => 'Date',
        'Participants' => 'Text',
        'WhatsInvolved' => 'Text',
        'Location' => 'Varchar',
        'ContactDetails' => 'HTMLText',
        'URLSegment' => 'Varchar(255)',
        'Tags' => 'Text'
    );
		// this was hardcoded as "1". 1 does not exist, which broke saving studies.
			// this is now set to a member that exists (30.01.2020)
     static $defaults = array('SubmittedByID' => '1025');
    // static $defaults = array('SubmittedByID' => '1');
    static $has_one = array(
        'DownloadableFile' => 'File',
        'EthicsApprovalFile' => 'File',
        'SubmittedBy' => 'Member',
    );

    static $many_many = array(
    	'Topics' => 'Topic',
    	'Audiences' => 'Audience',
        'ArticleTypes' => 'ResourceArticleType',
        'Disorders' => 'Disorder',
    );

    static $belongs_many_many = array(
        'BookmarkedMembers' => 'Member'
    );

    private static $summary_fields = array(
      'Title' => 'Title',
      'Author' => 'Author',
      'isNEDC.Nice' => 'NEDC',
      'getCategory'    => 'Article Type',
      'Journal' => 'Journal',
      'Volume' => 'Volume',
      'ExternalLink' => 'URL',
      'Created.Nice' => 'Created',
      'LastEdited.Nice' => 'Updated'
    );

    private static $create_table_options = array(
        'MySQLDatabase' => 'ENGINE=MyISAM'
    );

    private static $indexes = array(
        'SearchFields' => array(
            'type' => 'fulltext',
            'value' => '"Title", "Tags"',
        )
    );

    private static $searchable_fields = array(
        'Title' => 'Title',
        'isNEDC' => 'isNEDC',
        'Author'    => 'Author',
        'Publisher' => 'Publisher',
        'Institution'=> 'Institution',
        'Title' => 'Title',
        'Author' => 'Author',
        'Journal' => 'Journal',
        'Volume' => 'Volume',
        'Created'=> 'Created',
        'ExternalLink' => 'URL',
        'ArticleTypes.ID' => array(
            'name'=> 'Name',
            'filter' => 'ExactMatchFilter'
        )
    );

    public function getCMSFields()  {
        $fieldlist = parent::getCMSFields();

        $fieldlist->removeByName('Topics');
        $fieldlist->removeByName('Audiences');
        $fieldlist->removeByName('Disorders');
        $fieldlist->removeByName('ArticleTypes');
        $fieldlist->removeByName('BookmarkedMembers');
        $fieldlist->removeByName('Tags');
        $fieldlist->removeByName('DownloadableFile');
        $fieldlist->removeByName('EthicsApprovalFile');
        $options = $this->dbObject('SubmittedStudies')->enumValues();
        $member = DataObject::get('Member')->map('ID', 'getName');

        // $Type = DropdownField::create('Type', 'Type', singleton('ResearchResource')->dbObject('Type')->enumValues());
        // $isFullText             = CheckboxField::create('FullText', 'is Full Text ?');
        $isAUCaseStudies        = CheckboxField::create('isAustralianCaseStudies', 'is Australian Case Studies?');
        $SubmittedStudies       = DropdownField::create('SubmittedStudies', 'Status')->setSource($options);
        $Title                  = TextField::create('Title', 'Title');
        $urlSegment             = SiteTreeURLSegmentField::create("URLSegment", "URL Segment")
                                    ->setURLPrefix(Controller::join_links(singleton('ResearchAndResourcesHolder_Controller')->Link(), 'show' ,  '/'))
                                    ->setDefaultURL(Controller::join_links(singleton('ResearchAndResourcesHolder_Controller')->Link(), 'show', 'new-research-and-resource-page'));
        $Format                 = TextField::create('Format', 'Format');
        $Description            = HtmlEditorField::create('Description', 'Abstract');
        $Author                 = TextField::create('Author', 'Author');
        $Publisher              = TextField::create('Publisher', 'Publisher');
        $Year                   = TextField::create('Year', 'Year of publication');
        $Country                = TextField::create('Country', 'Country');
        $isFree                 = CheckboxField::create('Free', 'is Free ?');
        $AvailableFrom          = TextField::create('AvailableFrom', 'Available From');
        $Address                = TextareaField::create('Address', 'Address');
        $Phone                  = TextField::create('Phone', 'Phone');
        $Fax                    = TextField::create('Fax', 'Fax');
        $Website                = TextareaField::create('Website', 'Website');
        $ExternalLink           = TextareaField::create('ExternalLink', 'External Link');
        $Publication            = TextField::create('Publication', 'Publication');
        $Institution            = TextField::create('Institution', 'Institution');
        $EthicsApprovalNumber   = TextField::create('EthicsApprovalNumber', 'Ethics Approval Number');
        $FundingSource          = TextareaField::create('FundingSource', 'Funding Source');
        $ProjectStartDate       = DateField::create('ProjectStartDate', 'Project Start Date')->setConfig('showcalendar', true);
        $ProjectEndDate       = DateField::create('ProjectEndDate', 'Project End Date')->setConfig('showcalendar', true);
        $Participants           = TextareaField::create('Participants', 'Participants');
        $WhatsInvolved          = TextareaField::create('WhatsInvolved', 'Whats Involved');
        $Location               = TextField::create('Location', 'Location');
        $ContactDetails         = HtmlEditorField::create('ContactDetails', 'Contact Details');

        $disorders              = TagField::create('Disorders', 'Disorders', DataObject::get('Disorder'), $this->Disorders());
        $topics                 = TagField::create('Topics', 'Topics', DataObject::get('Topic'), $this->Topics());
        $audiences              = TagField::create('Audiences', 'Audiences', DataObject::get('Audience'), $this->Audiences());
        $ArticleTypes           = TagField::create('ArticleTypes', 'Article Types', DataObject::get('ResourceArticleType'), $this->ArticleTypes());
        $SubmittedBy            = DropdownField::create('SubmittedByID', 'SubmittedBy', $member)->setDisabled(true)->setDescription('Can\'t change person.');

        $tag_key = explode(',', $this->Tags);
        $ResourceTags = StringTagField::create('Tags', 'Tags',  $tag_key, is_null($this->Tags) ? '' : $this->Tags);
        $ResourceTags->setShouldLazyLoad(true);


        $DownloadableFile = UploadField::create('DownloadableFile', 'Resource File');
        $EthicsFile = UploadField::create('EthicsApprovalFile', 'Ethics Approval File')->setDescription('To open file: Click Edit>URL');

        $SubmittedBy->displayIf('isAustralianCaseStudies')->isChecked()->end();
        $SubmittedStudies->displayIf('isAustralianCaseStudies')->isChecked()->end();
        $EthicsApprovalFiles  = DisplayLogicWrapper::create($EthicsFile)->displayIf('isAustralianCaseStudies')->isChecked()->end();

        $fieldlist->addFieldsToTab('Root.Main', array($ArticleTypes, $isAUCaseStudies, $SubmittedBy, $SubmittedStudies, $EthicsApprovalFiles), 'Title');
        $fieldlist->addFieldsToTab('Root.Main', array($Title, $Author, $isFree, $topics, $audiences, $Description, $ExternalLink, $disorders, $ResourceTags, $urlSegment));

        $fieldlist->addFieldsToTab('Root.Attributes', array( $Publisher, $Year, $Country, $AvailableFrom, $Address, $Phone, $Fax, $Website, $Publication, $Institution, $EthicsApprovalNumber, $FundingSource, $ProjectStartDate, $ProjectEndDate, $Participants, $WhatsInvolved, $Location, $ContactDetails, $Format));

        $fieldlist->addFieldsToTab('Root.Attachments', $DownloadableFile);

        return $fieldlist;
    }

    public function getValidator() {
        return RequiredFields::create('ArticleTypes', 'Title');
    }


    public function getCategory() {
        $categories = $this->ArticleTypes();
        foreach($categories as $cat) {
            return $cat->Title;
        }
    }


    public function Link() {
        return Controller::join_links('research-and-resources', 'show', $this->URLSegment);
    }

    public function AbsoluteLink() {
        return Controller::join_links(Director::absoluteBaseURL(), 'research-and-resources', 'show', $this->ID);
    }

    public function MetaTags() {
        $tags = '';

        $tags .= '<meta property="og:title" content="'.$this->Title.'" />';
        $tags .= '<meta property="og:description" content="'.substr(htmlentities(strip_tags($this->Description)), 0, 200).'..." />';
        $tags .= '<meta property="og:url" content="'.$this->AbsoluteLink().'" />';

        $this->extend('MetaTags', $tags);

        return $tags;
    }

    public function isBookmarked() {
        return in_array(Member::currentUserID(), array_keys($this->BookMarkedMembers()->map()->toArray()));
    }

    public function onBeforeWrite() {
        parent::onBeforeWrite();

        if(!$this->URLSegment && $this->Title) {
            $this->URLSegment = singleton('SiteTree')->generateURLSegment($this->Title);
        }

        if($this->ID && $this->SubmittedBy()->ID != '1025') {
            if($this->original['SubmittedStudies'] == 'Pending' && $this->SubmittedStudies == 'Accepted' && $this->SubmittedBy()->ID) {
                $From = 'no-reply@nedc.com.au';
                $To   = $this->SubmittedBy()->Email;
                $Subject = 'NEDC: Your submitted study has been accepted!';

                $message = <<<X
Hi {$this->SubmittedBy()->getName()},

This is to inform you that your submitted study "{$this->Title}" has been accepted.

Your studies is listed here. -> {$this->Link()}

Thanks,

NEDC Admin
X;

                $email = new Email($From, $To, $Subject, $message);
                $send_attempt = $email->setTemplate('EmailToUserStudyPublished')
                                    ->populateTemplate(array(
                                         'Name' => $this->SubmittedBy()->getName(),
                                         'Title' => htmlentities($this->Title),
                                         'Link' => $this->Link(),
                                     ))
                                    ->send();
            }
        }
    }
}
