<?php

class ImportMemberTask extends BuildTask {

    protected $title       = "Import Members";

    protected $description = "Import Members";

    private $_topics = null;
    private $_interests = null;
    private $_membershipOpportunities = null;
    private $_professions = null;
    private $_professionGroups = null;
    private $_ageGroups = null;
    private $_howDidYouHearAboutUs = null;
    private $_notFound = array();

    private static $field_mapping = array(
        'Email_Address' => 'Email',
        'Username' => 'Username',
        'First_Name' => 'FirstName',
        'Last_Name' => 'Surname',
        'Postal_Address' => 'PostalAddress',
        'City/Suburb/Location' => 'City',
        'Website' => 'OrganizationWebsite',
        'Organisation' => 'Organization',
        'Jobtitle' => 'JobTitle',
        'State' => 'State',
        'Country' => 'Country'
    );

    public function run($request) {

        $file = Director::baseFolder() . "/mysite/code/tasks/members.csv";
        if(!file_exists($file)) {
            echo "members.csv doesn't exist";
            return false;
        }

        $parser = new CSVParser($file);

        foreach ($parser as $row) {
            foreach ($row as $key => $value) {
                $row[$key] = trim($value);
            }

            if(empty($row['Username']) || empty($row['Email_Address']) || DataObject::get_one('Member', "Username = '" . Convert::raw2sql($row['Username']) . "'")) {
                continue;
            }

            $member       = new Member();
            // General field mapping
            foreach($this->config()->field_mapping as $field => $memberField) {
                $member->$memberField = $row[$field];
            }
            $member->ProfessionID = $this->getProfessionId($row['Profession']);
            $member->ProfessionGroupID = $this->getProfessionGroupId($row['Area']);
            $member->AgeGroupID = $this->getAgeGroupId($row['Age Group']);
            $member->HowDidYouHearAboutUsID = $this->getHowDidYouHearAboutUsId($row['How did you hear about us?']);
            $member->InterestID = $this->getInterestId($row['What interests you in becoming a member of NEDC?']);

            switch(strtolower($row['Gender'])) {
                case 'm':
                    $member->Gender = 'Male';
                    break;
                case 'f':
                    $member->Gender = 'Female';
                    break;
                default:
                    $member->Gender = 'Other';
            }

            $member->EmailBounced = $row['Email_Bounced'] == 'Yes';
            $member->Phone = preg_replace("/[^0-9]/", '', $row['Phone']);

            //var_dump($member);
            //exit;

            // What_topics_are_you_interested_in
            $topics = array_map('trim', explode('|', $row['What_topics_are_you_interested_in']));
            foreach($topics as $topic) {
                if($topicId = $this->getTopicId($topic)) {
                    $member->Topics()->add($topicId);
                }
            }

            // What_membership_opportunities_are_you_interested_in
            $membershipOpportunities = array_map('trim', explode('|', $row['What_membership_opportunities_are_you_interested_in']));
            foreach($membershipOpportunities as $membershipOpportunity) {
                if($membershipOpportunityId = $this->getMembershipOpportunityId($membershipOpportunity)) {
                    $member->MembershipOpportunities()->add($membershipOpportunityId);
                }
            }

            $member->write();
            DB::query("UPDATE Member Set Created = '" . $row['Registration_Date'] . "' WHERE ID = " . $member->ID);
        }

        echo "Done";

        foreach($this->_notFound as $item => $array) {
            $this->_notFound[$item] = array_unique($array);
        }
        //var_dump($this->_notFound);
    }

    protected function getMembershipOpportunityId($text) {
        $text = strtolower($text);

        // Fix some values
        switch($text) {
            case 'information and education':
                $text = 'information & education';
                break;
            case 'community and collaboration':
                $text = 'community & collaboration';
                break;
            case 'input in to the evidence base':
                $text = 'input to the evidence base';
                break;
        }

        if(is_null($this->_membershipOpportunities)) {
            $items = MembershipOpportunities::get();
            foreach($items as $item) {
                $this->_membershipOpportunities[strtolower($item->Title)] = $item->ID;
            }
        }
        if($text && !isset($this->_membershipOpportunities[$text])) {
            $this->_notFound['MembershipOpportunities'][] = $text;
        }
        return isset($this->_membershipOpportunities[$text]) ? $this->_membershipOpportunities[$text] : 0;
    }

    protected function getInterestId($text) {
        $text = strtolower($text);

        // Fix some values
        switch($text) {
            case 'yes - as a consumer':
                $text = 'i have personal interest';
                break;
            case 'yes - as a carer':
                $text = 'i\'m a carer of someone with lived experience';
                break;
            case 'input to the evidence base':
            case 'i don\'t have a lived experience':
                $text = 'other (please specify below)';
                break;
            case 'no':
                $text = '';
                break;
        }

        if(is_null($this->_interests)) {
            $items = InterestBecomingMember::get();
            foreach($items as $item) {
                $this->_interests[strtolower($item->Title)] = $item->ID;
            }
        }
        if($text && !isset($this->_interests[$text])) {
            $this->_notFound['InterestBecomingMember'][] = $text;
        }
        return isset($this->_interests[$text]) ? $this->_interests[$text] : 0;
    }

    protected function getTopicId($text) {
        $text = str_replace(' and ', ' & ', strtolower($text));

        if(is_null($this->_topics)) {
            $topics = TopicsInterestedIn::get();
            foreach($topics as $topic) {
                $this->_topics[strtolower($topic->Title)] = $topic->ID;
            }
        }
        if($text && !isset($this->_topics[$text])) {
            $this->_notFound['TopicsInterestedIn'][] = $text;
        }
        return isset($this->_topics[$text]) ? $this->_topics[$text] : 0;
    }

    protected function getAgeGroupId($text) {
        $text = strtolower($text);
        if(is_null($this->_ageGroups)) {
            $items = AgeGroup::get();
            foreach($items as $item) {
                $this->_ageGroups[strtolower($item->Title)] = $item->ID;
            }
        }
        if($text && !isset($this->_ageGroups[$text])) {
            $this->_notFound['AgeGroup'][] = $text;
        }
        return isset($this->_ageGroups[$text]) ? $this->_ageGroups[$text] : 0;
    }

    protected function getProfessionId($text) {
        $text = strtolower($text);

        // Fix some values
        switch($text) {
            case 'social work':
                $text = 'social worker';
                break;
            case 'education':
            case 'teacher':
                $text = 'teacher / educational professional';
                break;
            case 'counsellor/therapist':
                $text = 'counsellor / therapist';
                break;
            case 'obstetrics and gynaecology registrar':
                $text = '';
                break;
            case 'director and dietitian in private practice':
                $text = 'dietitian';
                break;
            case 'registered nurse community mental health':
                $text = 'nurse';
                break;
            case 'journalist':
                $text = 'journalist / media professional';
                break;
            case 'psychiatric epidemiology':
                $text = 'psychiatrist';
                break;
            case 'psychology':
                $text = 'psychologist';
                break;
            case 'medical practitioner':
                $text = 'general practitioner';
                break;
            case 'community work':
                $text = 'community worker';
                break;
            case 'nursing assistant':
            case 'lawyer':
            case 'communications':
            case 'psychotherapist':
            case 'surgical trainee':
            case 'professional':
            case 'studying psychology':
            case 'bachelor of psychology student':
            case 'carer support in eating disorders':
            case 'consumer consultant':
            case 'other (please specifiy below)':
            case 'other':
            case 'public health':
                $text = 'other (please specify below)';
                break;
        }

        if(is_null($this->_professions)) {
            $items = Profession::get();
            foreach($items as $item) {
                $this->_professions[strtolower($item->Title)] = $item->ID;
            }
        }
        if($text && !isset($this->_professions[$text])) {
            $this->_notFound['Profession'][] = $text;
        }
        return isset($this->_professions[$text]) ? $this->_professions[$text] : 0;
    }

    protected function getHowDidYouHearAboutUsId($text) {
        $text = strtolower($text);

        // Fix some values
        switch($text) {
            case 'other (please specify below)':
                $text = 'other';
                break;
            case 'nedc flyer/brochure':
                $text = 'nedc flyer / brochure';
                break;
        }

        if(is_null($this->_howDidYouHearAboutUs)) {
            $items = HowDidYouHearAboutUs::get();
            foreach($items as $item) {
                $this->_howDidYouHearAboutUs[strtolower($item->Title)] = $item->ID;
            }
        }
        if($text && !isset($this->_howDidYouHearAboutUs[$text])) {
            $this->_notFound['HowDidYouHearAboutUs'][] = $text;
        }
        return isset($this->_howDidYouHearAboutUs[$text]) ? $this->_howDidYouHearAboutUs[$text] : 0;
    }

    protected function getProfessionGroupId($text) {
        $text = strtolower($text);

        // Fix some values
        switch($text) {
            case 'allied health':
            case 'mental health':
            case 'palliative care':
            case 'general health and wellbeing':
            case 'sexual health':
                $text = 'health professional';
                break;
            case 'community worker':
            case 'community and welfare':
                $text = 'community / not for profit';
                break;
            case 'medicine':
            case 'child, youth and family':
            case 'media and communications':
            case 'specialist eating disorders services':
            case 'sport and fitness':
            case 'mother':
            case 'lab technician (science)':
            case 'infant child adolescent mental health':
            case 'government policy':
            case 'specialist eating disorders service':
            case 'specialist eating disorder services':
            case 'food services':
            case 'peer worker':
            case 'aged care':
                $text = 'other (please specify below)';
                break;
            case 'education':
                $text = 'school';
                break;
            case 'bachelor of science with a major in psychology':
                $text = 'tafe / university';
                break;
        }

        if(is_null($this->_professionGroups)) {
            $items = ProfessionGroup::get();
            foreach($items as $item) {
                $this->_professionGroups[strtolower($item->Title)] = $item->ID;
            }
        }
        if($text && !isset($this->_professionGroups[$text])) {
            $this->_notFound['ProfessionGroup'][] = $text;
        }
        return isset($this->_professionGroups[$text]) ? $this->_professionGroups[$text] : 0;
    }

}
