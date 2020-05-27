<?php
/**
 * Homepage functions
 * @author  Jem Lopez <jem@blissmedia.com.au>
 * @date (2017-08-29)
 */

class HomePage  extends Page
{
	private static $has_many = array(
		'Carousel'		=> 'HomePageSlider',
		'Blocks'		=> 'Block',
	);

	private static $has_one = array(
		'BecomeMember'	=> 'BecomeMember'
	);

	public function getLatestEvents()
	{
		$events = new ProfessionalDevelopmentPage();
		return $events->getSortedEvents()->limit(6);
	}

	public function getEventForm()
	{
		// TODO: Use config() to get static const in the controller
		$url = 'professional-development/';
		$controller	= new ProfessionalDevelopmentPage_Controller();
		$form = $controller->EventForm()->setFormAction(Controller::join_links($url, 'SearchForm'));
		return isset($form) ? $form : false;
	}

	public function getNews()
	{
		$date = date('Y-m-d', strtotime('-60 days'));
		$news = DataObject::get('News')->sort('Created DESC')->where(array('"Created" >= ? ' => $date));
		return isset($news) ? $news : false;
	}

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$config = GridFieldConfig_RecordEditor::create();
		$config->addComponent(new GridFieldSortableRows('SortOrder'));

		$fields->addFieldToTab('Root.Carousel', GridField::create(
			'Carousel',
			'Carousel',
			$this->Carousel(),
			$config
		));

		$fields->addFieldToTab('Root.Blocks', GridField::create(
			'Blocks',
			'Blocks',
			$this->Blocks(),
			$config
		));

		$text = TextField::create('BecomeMember-_1_-Title', 'Title');
		$desc = TextAreaField::create('BecomeMember-_1_-Description', 'Description');
		$link = LinkField::create('BecomeMember-_1_-LinkID', 'Link');
		$button = LinkField::create('BecomeMember-_1_-ButtonID', 'Button');
		// $img = UploadField::create('BecomeMember-_1_-ImageID', 'Background');

		// $images = DataObject::get('File')->sort('Created ASC')->last();

		// $image = $this->BecomeMember();
		// $image->ImageID = $images->ID;
		// $image->write();

		$fields->addFieldsToTab('Root.BecomeMember', array($text, $desc, $link, $button));
		return $fields;
	}
}

class HomePage_Controller extends Page_Controller
{
}
