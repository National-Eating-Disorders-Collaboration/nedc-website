<?php

class ELearningPage extends Page
{

	private static $has_many = array(
		'ELearning'	=> 'ELearning',
		'Carousel'	=> 'Carousel'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$config = GridFieldConfig_RelationEditor::create();
		$config->addComponent(new GridFieldSortableRows('SortOrder'));

		$fields->addFieldToTab('Root.ELearning', GridField::create(
			'ELearning',
			'ELearning',
			$this->ELearning(),
			$config
		));

		$fields->addFieldToTab('Root.Carousel', GridField::create(
			'Carousel',
			'Carousel',
			$this->Carousel(),
			$config
		));

		return $fields;
	}

	public function getLatestVideo($num = 1)
	{
		$video = DataObject::get('ELearning')->filter('Featured', 1)->sort('LastEdited ASC')->limit($num);
		return ($video) ? $video : false;
	}
}

class ELearningPage_Controller extends Page_Controller
{
	private static $allowed_actions = array(
		'index',
		'show'
	);

	public function index(SS_HTTPRequest $request)
	{
		$webminar = DataObject::get('ELearning');//->sort('Created DESC');

		if ($topic = $request->getVar('topics')) {
			$webminar = $webminar->filter('Topic.ID:ExactMatchMulti', $topic);
		}

		if ($type = $request->getVar('type')) {
			$webminar = $webminar->where(
                "\"CategoriesID\" = '".$type."'"
        	);
		}

		$paginated_list = PaginatedList::create(
			$webminar,
			$request
		)->setPageLength(9);

		return array(
			'Results' => $paginated_list,
		);
	}

	public function show(SS_HTTPRequest $request)
	{
		$webminar = DataObject::get('ELearning')->byID($request->param('ID'));

		if (! $webminar) {
			throw new Exception("Error Processing Request", 1);
		}

		return array(
			'ELearn' => $webminar,
			'Title'	=> $webminar->Title
		);
	}
	/**
	 * Sorting data
	 * @date    2017-09-11
	 * @version 1.0.0
	 */
	public function SortForm()
	{

		$topics = DataObject::get('Topic')->map('ID', 'Title');
		$types =	DataObject::get('ELearningCategories')->map('ID', 'Title');

		$form = Form::create(
			$this,
			__FUNCTION__,

			FieldList::create(
				DropdownField::create('topics')
					->setEmptyString('Topics')
					->setSource($topics),
				DropdownField::create('type')
					->setEmptyString('Type')
					->setSource($types)
			),
			FieldList::create(
				FormAction::create('results', _t('Resutls', 'Results'))
			)
		);

		$form->setFormMethod('GET')
			 ->setFormAction($this->Link())
			 ->disableSecurityToken()
			 ->loadDataFrom($this->request->getVars());
		return $form;
	}
}
