<?php

class ResearchAndResourcesHolder_Controller extends Page_Controller {
    private static $allowed_actions = array(
        'details', 'search', 'listing', 'index'
    );

    private static $url_handlers = array(
        ''           => 'index',
        'show/$Slug' => 'details',
        'search'     => 'search',
        '$LIST'      => 'listing',
    );

    public function getBoxID() {
        return $this->BecomeMemberID;
    }

    public function index() {

        $nedcArticleTypesSelect = new SQLSelect(array('"ResourceArticleType"."ID"'), 'ResourceArticleType');
        $nedcArticleTypesSelect->setDistinct(true);
        $nedcArticleTypesSelect->addInnerJoin('ResearchResource_ArticleTypes', '"ResearchResource_ArticleTypes"."ResourceArticleTypeID" = "ResourceArticleType"."ID"');
        $nedcArticleTypesSelect->addInnerJoin('ResearchResource', '"ResearchResource"."ID" = "ResearchResource_ArticleTypes"."ResearchResourceID"');
        $nedcArticleTypesSelect->addWhere('"ResearchResource"."isNEDC" = 1');
        $nedcArticleTypes = new ArrayList();

        // foreach($nedcArticleTypesSelect->execute() as $row) {
        //     $nedcArticleTypes->push($row);
        // }

        $research_resources_page = DataObject::get('SiteTree', array('URLSegment = ?' => 'research-and-resources'))->first();
        if($research_resources_page) {
            $this->customise($research_resources_page->data()->toMap());
        }
        $this_model = ResearchAndResourcesHolder::get()->First();
        $customise_data = array(
            'NEDCResources' => DataObject::get('ResourceArticleType')->filter(array('ID' => $nedcArticleTypesSelect->execute()->column('ID'))),
            'Audience' => Audience::get(),
            'Topics' => Topic::get(),
            'Disorders' => Disorder::get(),
            'SubmitStudies' => DataObject::get('BecomeMember')->filter("ID", $this_model->BecomeMemberID)->First(),
            'LatestResearch' => ResearchResource::get()->filter('isNEDC', 0)->sort(array('Year' => 'DESC', 'Created' => 'DESC'))->limit(3),
            'CurrentAustralianStudies' => ResearchResource::get()->filter(array('ArticleTypes.Name' => array('Pilot Study', 'Case Study', 'Study', 'Explatory study'), 'isAustralianCaseStudies' => '1', 'SubmittedStudies' => 'Accepted'))->sort(array('ProjectStartDate' => 'DESC'))->limit(3),
        );

        return $this->renderWith(array('ResearchResource_index', 'Page'), $customise_data);
    }

    public function details() {
    	$slug = $this->getRequest()->param('Slug');

    	if(!$slug) {
    		$this->httpError(404);
    	}

    	$resource = DataObject::get_one('ResearchResource', array('"URLSegment" = ?' => $slug));

        if(!$resource) {
            $this->httpError(404);
            return;
        }

        $this->dataRecord = $resource;

    	return array(
            'Resource' => $resource,
            'SeeAlso' => $this->renderWith('Resource_SeeAlso', array('RelatedResources' => $this->getRelatedResources())),
            'MetaTags' => $resource->MetaTags()
         );
    }

    public function getRelatedResources() {
        $output = $relatedResources = array();

        if($this->data()) {
            if($this->data()->Disorders()->First()) {
                $relatedResources += DataObject::get('ResearchResource', array('"ResearchResource"."ID" != ?' => $this->data()->ID))->filter(array(
                    'Disorders.ID' => $this->data()->Disorders()->First()->ID
                ))->sort("RAND()")->toArray();
            }

            if($this->data()->Audiences()->First()) {
                $relatedResources += DataObject::get('ResearchResource', array('"ResearchResource"."ID" != ?' => $this->data()->ID))->filter(array(
                    'Audiences.ID' => $this->data()->Audiences()->First()->ID
                ))->sort("RAND()")->toArray();
            }

            if($this->data()->ArticleTypes()->First()) {
                $relatedResources += DataObject::get('ResearchResource', array('"ResearchResource"."ID" != ?' => $this->data()->ID))->filter(array(
                    'ArticleTypes.ID' => $this->data()->ArticleTypes()->First()->ID
                ))->sort("RAND()")->toArray();
            }

            if(count($relatedResources) > 4) {
                for($x = 1; $x <= 4; $x++) {
                    $tmp = array_splice($relatedResources, rand(0, count($relatedResources) - 1), 1);
                    $output[] = array_pop($tmp);
                }
            } else {
                $output = $relatedResources;
            }
        }

        return new ArrayList($output);
    }

    public function search() {
        $searchParams = $this->_getSearchParams();

        $resources = DataObject::get('ResearchResource');
        $articles = DataList::create('EatingDisordersArticle');

        if($searchParams['keywords']) {

            $searchKeywords = array($searchParams['keywords']);

            if(!preg_match('/^".+"$/i', $searchParams['keywords'])) {
                $words = explode(' ', $searchParams['keywords']);
                foreach($words as $word) {
                    if($variants = self::getKeywordVariants($word)) {
                        $searchKeywords = array_merge($searchKeywords, $variants);
                    }
                }
            }

            $resources = DataObject::get('ResearchResource')->filter(array('SearchFields:fulltext' => join(' ', $searchKeywords)));
            $resources = $resources->alterDataQuery(function($dataQuery, $list) use ($searchKeywords) {                
                $dataQuery->selectField('MATCH("ResearchResource"."Title", "ResearchResource"."Tags") AGAINST (\'' . join(' ', $searchKeywords) . '\')', 'Relevance');                                
                return $dataQuery;
            });

            $articles = DataObject::get('EatingDisordersArticle')->filterAny(array('Title:PartialMatch' => $searchParams['keywords'], 'Content:PartialMatch' => $searchParams['keywords']))->limit(15);
        }

        if($searchParams['disorder']) {
            $resources = $resources->addFilter(array('Disorders.ID' => $searchParams['disorder']));
        }

        if($searchParams['topic']) {
            $resources = $resources->addFilter(array('Topics.ID' => $searchParams['topic']));
        }

        if($searchParams['article-type']) {
            $resources = $resources->addFilter(array('ArticleTypes.ID' => $searchParams['article-type']));
        }

        if($searchParams['full-text-only']) {
            $resources = $resources->addFilter(array('FullText' => 1));
        }

        $sort = array();
        
        if ($searchParams['sort']) {
            if ($searchParams['sort'] == 'Recent') {        
                $sort['Created'] = 'DESC';
            }

            if ($searchParams['sort'] == 'Title') {
                $sort['Title'] = 'ASC';
            }
        }

        if(!empty($searchParams['keywords'])) {
            $sort['Relevance'] = 'DESC';
        }

        $resources = $resources->sort($sort);

        if($searchParams['timeframe']) {
            $year = '';
            switch ($searchParams['timeframe']) {
                case 'lastyear':
                    $year = date('Y', strtotime('-1 year'));
                    break;
                case 'last2years':
                    $year = date('Y', strtotime('-2 years'));
                    break;
                case 'last5years':
                    $year = date('Y', strtotime('-5 years'));
                    break;
                case 'last10years':
                    $year = date('Y', strtotime('-10 years'));
                    break;

            }
            if($year) {
                $resources = $resources->filterAny(array('Year:GreaterThanOrEqual' => $year, 'ProjectStartDate:GreaterThanOrEqual' => $year.'-01-01'));
            }
        }

        $resources = PaginatedList::create($resources, $this->getRequest())->setPageLength(12);

    	return array('Resources' => $resources, 'Keywords' => $searchParams['keywords'], 'Articles' => $articles);
    }

    public function Link($action = null) {
        $output = 'research-and-resources';
        foreach(Config::inst()->get('Director', 'rules') as $rule => $controller) {
            if($controller == __CLASS__ ) {
                $rule_segments = explode('/', $rule);
                $output = array_shift($rule_segments);
                break;
            }
        }

        if($action == 'true') {
            $output = Controller::join_links($output, $this->getAction());
        } elseif($action) {
            $output = Controller::join_links($output, $action);
        }

        return $output;
    }

    public function SearchForm() {
        $values = $this->_getSearchParams();
        $sort = array('' => 'Sort By', 'Recent' => 'Recent', 'Title' => 'Title');

        $fieldlist = FieldList::create(
           $keyword = TextField::create('keywords', '', $values['keywords'])->setAttribute('placeholder', 'Search by keyword or topics'),
           $disorder = DropdownField::create('disorder', '', DataObject::get('Disorder')->map()->unshift('', 'All Disorders'), $values['disorder']),
           $topic = DropdownField::create('topic', '', DataObject::get('Topic')->map()->unshift('', 'All Topics'), $values['topic']),
           $articleType = DropdownField::create('article-type', '', DataObject::get('ResourceArticleType')->map()->unshift('', 'Article Type'), $values['article-type']),
           $timeframe = DropdownField::create('timeframe', '', array('' => 'Timeframe', 'lastyear' => 'Last Year', 'last2years' => 'Last 2 Years', 'last5years' => 'Last 5 Years', 'last10years' => 'Last 10 Years'), $values['timeframe']),
           $fulltext = CheckboxField::create('full-text-only', '', $values['full-text-only']),
           $sort = DropdownField::create('sort', '', $sort, $values['sort'])
        );


        $form = new Form($this, 'ResourceSearchForm', $fieldlist, FieldList::create());
        $form->setFormAction(Controller::join_links($this->Link(), 'search'));
        $form->setFormMethod('GET');

        return $this->renderWith(array('ResourceSearchForm'), array('Form' => $form));
    }

    private function _getSearchParams() {
        $params = $this->getRequest()->getVars();

        $defaults = array(
            'keywords' => '',
            'disorder' => '',
            'topic' => '',
            'article-type' => '',
            'timeframe' => '',
            'full-text-only' => 0,
            'sort'  => ''
        );

        return array_merge($defaults, $params);
    }

    public function listing() {
        $category = null;
        $var = $this->getRequest()->param('LIST');
        
        // ChildPage
        if( is_string($var)) {
            $standard = DataObject::get('SiteTree')->filter('ClassName', 'StandardPage');
            foreach ($standard as $page) {
                if ($var == $page->URLSegment) {
                    return $this->renderWith(array('StandardPage', 'Page'), $page);
                }
            }
        }

        switch($var) {
            case 'current-australian-studies':
                $resources = DataObject::get('ResearchResource')->filter(array('SubmittedStudies' => 'Accepted', 'isAustralianCaseStudies' => '1'))->sort('ProjectStartDate DESC');
                $title = 'Current Australian Studies';
                break;
            case 'latest-research':
                $resources = DataObject::get('ResearchResource')->filter('isNEDC', 0);//>sort(array('isNEDC' => 'DESC', 'Year' => 'DESC'));
                $title = 'Latest Research';
                break;
            default:
                //determine listing category
                $listing_categories = array(
                    'Audience' => 'Audiences.ID',
                    'Disorder' => 'Disorders.ID',
                    'ResourceArticleType' => 'ArticleTypes.ID',
                    'Topic' => 'Topics.ID'
                );
                foreach($listing_categories as $category_class => $resource_filter_condition) {
                    $category = DataObject::get_one($category_class, array('"URLSegment" = ?' => $this->getRequest()->param('LIST')));

                    if($category) {
                        break;
                    }
                }

                if(!$category) {
                    $this->httpError(404);
                    return;
                }

                $resources = ResearchResource::get()->filter(array($resource_filter_condition => $category->ID))->sort('Created DESC');
                $title = (property_exists($category, 'Title')) ? $category->Title : $category->Name;
                break;
        }
        $search = $this->_getSearchParams();

        if ($sort = $search['sort']) {
            if ($sort == 'Recent') {
                $resources = $resources->sort('Created DESC');
            }

            if ($sort == 'Title') {
                $resources = $resources->sort('Title ASC');
            }
        }
        $resources = PaginatedList::create($resources, $this->getRequest())->setPageLength(12);

        return array('Resources' => $resources, 'Title' => $title, 'Category' => $category);
    }

    public static function getKeywordVariants($keyword) {
        $output = array();
        $result = DataObject::get('KeywordVariant')->filterAny(array('Keyword1' => $keyword, 'Keyword2' => $keyword, 'Keyword3' => $keyword, 'Keyword4' => $keyword, 'Keyword5' => $keyword, ))->first();

        if($result) {
            $output = array_filter($result->data()->toMap(), function($k){
                return substr($k, 0, 7) == 'Keyword';
            }, ARRAY_FILTER_USE_KEY);
        }

        return array_values($output);
    }

    // sort for listing with category
    public function SortForm()
    {
        $sort = array( 'Recent' => 'Recent', 'Title' => 'Title');

        $form = Form::create(
            $this,
            __FUNCTION__,

            FieldList::create(
                DropdownField::create('sort')
                    ->setEmptyString('Sort By')
                    ->setSource($sort)
            ),
            FieldList::create(
                FormAction::create('listing', _t('Results', 'Results'))
            )
        );

        $form->setFormMethod('GET')
             ->addExtraClass('hide')
             ->setFormAction(Controller::join_links($this->Link() . '/' . $this->getRequest()->param('LIST')))
             ->disableSecurityToken()
             ->loadDataFrom($this->request->getVars());
        return $form;
    }
}
