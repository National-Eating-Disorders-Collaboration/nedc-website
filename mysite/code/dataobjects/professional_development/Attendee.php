<?php

class Attendee extends DataObject
{

	private static $db = array(
		'FirstName' => 'Varchar(155)',
		'Surname'	=> 'Varchar(155)',
		'Email'		=> 'Varchar(155)',
		'PostCode'	=> 'Varchar(10)',
		'State'		=> 'Varchar(55)',
		'Organisation'	=> 'Varchar(155)',
		'FoodRequirements'	=> 'Text',
	);

	private static $has_one = array(
		'Event'		=> 'Event',
		'Member' 	=> 'Member'
	);

	private static $summary_fields = array(
		'getFullName'	=> 'Name',
		'PostCode'		=> 'PostCode',
		'State'			=> 'State',
		'Email'			=> 'Email',
		'Organisation'	=> 'Organisation',
		'getDate'		=> 'Dates'
	);

	private static $many_many = array(
		'Date'	=> 'EventTimeDate'
	);

	// You can't edit people!!!
    public function canEdit($member = null)
    {
        return FALSE;
    }

    public function getFullName() {
    	return $this->FirstName . ' ' . $this->Surname;
    }

   	protected function getDate()
	{
		$dates = $this->Date();
		$dates_r = array();

		foreach ($dates as $rec) {
			$day = date('F jS', strtotime($rec->Date));
			$start = date('g:ia', strtotime($rec->StartTime));
			$end = date('g:ia', strtotime($rec->EndTime));
			$dates_r[$rec->ID] =  $day . " " . $start . ' to ' . $end;
		}

		$results = implode(",\n", $dates_r);
		return $results;
	}

}
