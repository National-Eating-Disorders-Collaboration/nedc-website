<?php
/**
 * Support and Services Page
 * @author Jem Lopez <jem@blissmedia.com.au>
 * @date 2017-08-17
 *
 */

class SupportAndServicesPage extends Page
{

	private static $allowed_children = array('SupportHelpPage', 'StandardPage');
	private static $db = array(

	);

	private static $has_many = array(
		'Organization'  => 'SupportOrganization',
		'SideBlocks'	=> 'SideBlocks'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->addFieldToTab('Root.SupportOrganization', GridField::create(
			'Organization',
			'Support Organization',
			$this->Organization(),
			GridFieldConfig_RecordEditor::create()
		));

		$config = GridFieldConfig_RecordEditor::create();
        $config->addComponent(new GridFieldSortableRows('SortOrder'));
		$fields->addFieldToTab('Root.SideBox', GridField::create(
			'SideBlocks',
			'SideBlocks',
			$this->SideBlocks(),
			$config
		));

		return $fields;
	}

	/**
	 * Get service/opening hours
	 * @date    2017-07-31
	 * @version 1.0.0
	 * @param   [type]     $obj [description]
	 * @return  [type]          [description]
	 */
	public function getServiceHours($obj) {
		$days = array(
			'Monday' 	=> 'Monday',
			'Tuesday' 	=> 'Tuesday',
			'Wednesday' => 'Wednesday',
			'Thursday' 	=> 'Thursday',
			'Friday' 	=> 'Friday',
			'Saturday' 	=> 'Saturday',
			'Sunday' 	=> 'Sunday'
		);

		$service_hours = array();

		foreach ($days as $key => $value) {
			if(isset($obj)) {
				$to = $key.'To';
				$from = $key.'From';
				// Check if it exist
				if(!empty($obj->$to) && !empty($obj->$from)) {

					$fto = date('g:ia', strtotime($obj->$to));
					$ffrom = date('g:ia', strtotime($obj->$from));
				} else {
					$fto = $obj->$to;
					$ffrom = $obj->$from;
				}
				// mark depends if data is empty
				$mark = empty($fto) && empty($ffrom) ? 'Closed' : ' - ';
				// return string "9:00am - 5:00pm"
				$service_hours[$key] =  $ffrom . $mark . $fto;
			}
		}
		return $service_hours;
	}

	/**
	 * Get today's opening hours
	 * @date    2017-07-31
	 * @version 1.0.0
	 * @param   [array]     $a   [get the days]
	 * @param   [obj]     $obj 	 [get the oraganization obj]
	 * @return  [array]          [return the single array]
	 */
	public function getToday($a, $obj)
	{
		// Match today's day to service hours
		$today =  date('l');
		foreach ($a as $key => $value) {
			if($key == $today) {
				if($value != 'Closed') {
					$obj->Data()->Hour = 'Open Today ' . $value;
				}
			}
		}
		return $today;
	}
}

class SupportAndServicesPage_Controller extends Page_Controller
{
	private static $allowed_actions = array(
		'organization'
	);
	/**
	 * Parse data based from the ServicesForm()
	 * @date    2017-08-01
	 * @version 1.0.0
	 * @param   SS_HTTPRequest $request [getVars()]
	 * @return  [array]                  [object]
	 */
	public function index(SS_HTTPRequest $request) {

		$orgs =  DataObject::get('SupportOrganization');

		// Query/Input Text
        if($query = $request->getVar('query')) {
            $orgs = $orgs->filterAny(array(
            	'Title:PartialMatch' => $query,
            	'Content:PartialMatch' => $query,
            	'Address:PartialMatch'	=>$query,
            	'Website:PartialMatch'	=> $query
            ));
        }

        // Dropdown from SupportAndServicesCategories Dataobject
        if($services = $request->getVar('services')) {
        	$orgs = $orgs->filter('Categories.ID:ExactMatchMulti', $services
        	);
        }

        // Dropdown from AustraliaState Dataobject
        if($state = $request->getVar('state')) {
        	$orgs = $orgs->where(
                "\"AUStateID\" = '".$state."'"
        	);
        }

        // Dropdown from Population Dataobject
        if($population = $request->getVar('population')) {
        	$orgs = $orgs->filter('Population.ID:ExactMatchMulti', $population
        	);
        }

        // Sort Dataobject// Insert more if applicable
        if($sort = $request->getVar('sort')) {
            switch ($sort) {
                case "Alphabetical";
                    $orgs = $orgs->sort('Title ASC');
                break;
                case "Relevance";
                    $orgs = DataObject::get('SupportOrganization')->filter('SearchFields:fulltext', $query);
                    $orgs = $orgs->alterDataQuery(function($q, $list) use ($query) {
                        $q->selectField('MATCH("SupportOrganization"."Title", "SupportOrganization"."Content")
                                                 AGAINST (\'' . $query . '\')', 'Relevance');
                        return $q;
                    });
                break;
            }
        }

        // Paginate list items/ 6 per page
        $paginated_org = PaginatedList::create(
            $orgs,
            $request
        )->setPageLength(6);

		return array(
			'Results' => $paginated_org,
		);
	}

	/**
	 * Render individual support organization
	 * @date    2017-08-01
	 * @version 1.0.0
	 * @param   SS_HTTPRequest $request [gets the ID ]
	 * @return  [array]                  [parse data]
	 */
	public function organization(SS_HTTPRequest $request)
	{
		$org = DataObject::get('SupportOrganization')
			->byID($request->param('ID'));

		$dt = DataObject::get('DayTimeAvailability', " ID = $org->ServiceHoursID")
			->First();

		$state = DataObject::get('AustraliaState', "ID = $org->AUStateID");

		$hours = $this->getServiceHours($dt);

		if (isset($hours)) {
			$this->getToday($hours, $org);
		}

		// If all closed, don't bother showing
		if (count(array_unique($hours)) === 1 && end($hours) == 'Closed') {
			$hours = '';
		}

		foreach ($state as $key => $value) {
			$org->Data()->State = $value->Title;
		}

		if(! $org) {
			return $this->httpError(404,'That news could not be found');
		}

		return array (
			'Organization' => $org,
			'Population' => $org->Populations(),
			'Title'     => $org->Title,
			'Time' => $hours,
		);
	}

	/**
	 * Form for searching organizations and services
	 * @date    2017-08-01
	 * @version 1.0.0
	 */
	public function ServicesForm()
	{
		$services = DataObject::get('SupportAndServicesCategories')
			->map('ID', 'Title');
		$populations = DataObject::get('Population')
			->map('ID', 'Title');
		$state = DataObject::get('AustraliaState')
			->map('ID', 'Title')
			->toArray();

		$sort = array('Alphabetical' => 'Alphabetical', 'Relevance' => 'Relevance');

		$form = Form::create(
			$this,
			__FUNCTION__,

			FieldList::create(
				DropdownField::create('services')
					->setEmptyString('All Services')
					->setSource($services)
					->addExtraClass('services'),
				TextField::create('query')
					->setAttribute('placeholder', 'Search keywords or Topic')
					->addExtraClass('input_text'),
				// DropdownField::create('population')
				// 	->setEmptyString('Population')
				// 	->setSource($populations)
				// 	->addExtraClass('population_dd'),
				DropdownField::create('state')
					->setEmptyString('Australia')
					->setSource($state)
					->addExtraClass('hidden'),
				DropdownField::create('sort')
					->setEmptyString('Sort')
					->setSource($sort)
					->addExtraClass('hidden')
			),
			FieldList::create(
				FormAction::create('search', 'Search')
					->addExtraClass('btn darkBlue')
			)
		);
		$form->setFormMethod('GET')
			 ->setFormAction($this->Link())
			 ->disableSecurityToken()
			 ->loadDataFrom($this->request->getVars());
		return $form;
	}
}
