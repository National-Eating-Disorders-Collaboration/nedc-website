<?php

class NewsPage extends Page
{
	private static $has_many = array(
		'News'	=> 'News',
		'Carousel'	=> 'Carousel'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$config = GridFieldConfig_RelationEditor::create();
		$config->addComponent(new GridFieldSortableRows('SortOrder'));

		$fields->addFieldToTab('Root.NewsItems', GridField::create(
			'News',
			'News',
			$this->News(),
			GridFieldConfig_RelationEditor::create()
		));

		$fields->addFieldToTab('Root.Carousel', GridField::create(
			'Carousel',
			'Carousel',
			$this->Carousel(),
			$config
		));

		return $fields;
	}

	public function getLatestNews($num = 1)
	{
		$news = DataObject::get('News')->sort('Created ASC')->limit($num);
		return isset($news) ? $news : false;
	}
}

class NewsPage_Controller extends Page_Controller
{
	private static $allowed_actions = array(
		'index',
		'show'
	);

	public function index(SS_HTTPRequest $request)
	{
		$news = DataObject::get('News')->sort('Created DESC');

		if ($topic = $request->getVar('topics')) {
			$news = $news->filter('Topics.ID:ExactMatchMulti', $topic);
		}

		$paginated_list = PaginatedList::create(
			$news,
			$request
		)->setPageLength(6);

		return array(
			'Results' => $paginated_list,
		);
	}

	public function show(SS_HTTPRequest $request)
	{
		$news = DataObject::get('News')->byID($request->param('ID'));

		if (! $news) {
			throw new Exception("Error Processing Request", 1);
		}

		return array(
			'News' 	=> $news,
			'Title'	=> $news->Title
		);
	}

	public function SortForm()
	{
		$topics = DataObject::get('Topic')->map('ID', 'Title')->toArray();

		$form = Form::create(
			$this,
			__FUNCTION__,

			FieldList::create(
				DropdownField::create('topics')
					->setEmptyString('Topics')
					->setSource($topics)
			),
			FieldList::create(
				FormAction::create('results', _t('Results', 'Results'))
			)
		);

		$form->setFormMethod('GET')
			 ->setFormAction($this->Link())
			 ->disableSecurityToken()
			 ->loadDataFrom($this->request->getVars());
		return $form;
	}
}
