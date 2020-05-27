<?php

class Page_Controller extends ContentController
{
    /**
     * An array of actions that can be accessed via a request. Each array element should be an action name, and the
     * permissions or conditions required to allow the user to access it.
     *
     * <code>
     * array (
     *     'action', // anyone can access this action
     *     'action' => true, // same as above
     *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
     *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
     * );
     * </code>
     *
     * @var array
     */
    private static $allowed_actions = array(
        'result', 'GloablSearch'
    );

    public function init()
    {
        parent::init();
        // You can include any CSS or JS required by your project here.
        // See: http://doc.silverstripe.org/framework/en/reference/requirements
        // CSS
        Requirements::css($this->ThemeDir()."/css/font-awesome.min.css");
        Requirements::css("//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css");
        Requirements::css($this->ThemeDir()."/css/index.css");

        // JS
        Requirements::javascript($this->ThemeDir()."/js/jquery-3.2.1.min.js");
        Requirements::javascript($this->ThemeDir()."/js/jquery-ui.min.js");
        Requirements::javascript($this->ThemeDir()."/js/jquery.leanModal.min.js");
        Requirements::javascript("//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js");
        Requirements::javascript($this->ThemeDir()."/js/jquery.sticky.js");
        Requirements::javascript($this->ThemeDir()."/js/js-cookie.js");
        Requirements::javascript($this->ThemeDir()."/js/google.js");
        Requirements::javascript($this->ThemeDir()."/js/index.js");
    }

    /**
     * Get related dataobject for each page and parse into 'SeeAlso' blocks
     * @date    2017-08-11
     * @version 1.0.0
     * @param   string     $obj [dataobject's name base from the database]
     * @return  [viewable data]
     */
    public function getRelatedBlocks($obj = '')
    {
        // TODO: Add categories
    
        $dataobject = DataObject::get($obj)->sort('Created DESC')->sort('RAND()')->limit(8);
        if($obj == 'Event') {
            $dataobject = DataObject::get($obj)->filter('Status', 'Published')->sort('Created DESC')->sort('RAND()')->limit(8);
        }
        $result = isset($dataobject) ? $dataobject : false;
        return $this->customise(['Blocks' => $result]);
    }

    public function MiddleOf($number) {
        return ceil((int) $number / 2);
    }

    public function resultCounter($totalItems, $page_number = 1, $per_page = 12) {
        $range_start = (($page_number - 1) * $per_page) + 1;
        $range_end = ($per_page * $page_number > $totalItems) ? $totalItems : $per_page * $page_number;
        return (($totalItems) ? sprintf('Showing %d - %d of %d total results', $range_start, $range_end, $totalItems) : '');
    }

    /**
     * Overwritten SearchForm
     * @date    2017-09-06
     * @version 1.0.0
     */
    public function GlobalSearch() {
        $searchText =  _t('GlobalSearch', '');

        if($this->owner->getRequest() && $this->owner->getRequest()->getVar('Search')) {
            $searchText = $this->owner->getRequest()->getVar('Search');
        }

        $fields = new FieldList(
            $search = new TextField('Search', false, $searchText)
        );
        $search->addExtraClass('search-query');

        $search->setAttribute('placeholder', "What are you searching for?");
        $search->setAttribute('autocomplete', 'off');

        $actions = new FieldList(
            $action = new FormAction('result', _t('GlobalSearch', ''))
        );
        $action->addExtraClass('search-submit');

        $form = SearchForm::create($this, 'GlobalSearch', $fields, $actions);
        $form->addExtraClass('search-form');

        $form->setFormAction(Controller::join_links(BASE_URL, "home", "SearchForm"));

        $form->classesToSearch(FulltextSearchable::get_searchable_classes());
        return $form;
    }

    /**
     * Process and render search results.
     *
     * @param array $data The raw request data submitted by user
     * @param SearchForm $form The form instance that was submitted
     * @param SS_HTTPRequest $request Request generated for this action
     */
     public function result($data, $form){
        $data = $_REQUEST;

        $query = htmlspecialchars($data['Search'], ENT_QUOTES,'UTF-8');

        $event = DataObject::get('Event')
                ->filterAny(array(
                'Title:PartialMatch' => $query,
            ))->toArray();

        $news = DataObject::get('News')
                ->filterAny(array(
                'Title:PartialMatch' => $query,
                'Content:PartialMatch' => $query,
            ))->toArray();

        $site = DataObject::get('SiteTree')
                ->filterAny(array(
                'Title:PartialMatch' => $query,
                'Content:PartialMatch' => $query,
            ))
            ->exclude('Title', array('404', 'Home', 'Server Error', 'Search results', 'Dashboard' ))
            ->toArray();

        $resources = DataObject::get('ResearchResource')
                ->filterAny(array(
                'Title:PartialMatch' => $query,
                'Tags:PartialMatch' => $query,
                'Volume:PartialMatch' => $query,
                'Journal:PartialMatch' => $query,
                'Participants:PartialMatch' => $query,
                'WhatsInvolved:PartialMatch' => $query,
                'Description:PartialMatch' => $query,
                'Author:PartialMatch' => $query,
            ))->toArray();

        $elearning = DataObject::get('ELearning')
              ->filterAny(array(
                'Title:PartialMatch' => $query,
                'Description:PartialMatch' => $query,
            ))->toArray();

        $services = DataObject::get('SupportOrganization')
             ->filterAny(array(
             'Title:PartialMatch' => $query,
         ))->toArray();

        $searchresults = new ArrayList();
        $searchresults->merge($site);
        $searchresults->merge($resources);
        $searchresults->merge($event);
        $searchresults->merge($news);
        $searchresults->merge($elearning);
        $searchresults->merge($services);

        $data['Result'] = $searchresults;

        $paginated_search = PaginatedList::create(
            $searchresults,
            $data
        )->setPageLength(6);

        $results = array(
            'Results'   => $paginated_search,
            'Query'     => $query,
            'Title'     => 'Search Results'
        );

        return $this->customise($results)->renderWith(array('Page_results','Page'));
    }
    
    public function getFooter() {
       return DataObject::get('FooterParent');
    }

}
