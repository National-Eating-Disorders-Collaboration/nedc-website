<?php

class ResourcesAdmin extends ModelAdmin {
    private static $allowed_actions = array(
        'ImportForm',
        'SearchForm',
        'importCustom',
        'importCustomSubmit',
        'ResourcesCustomImportForm'
    );

    private static $managed_models = array
    (
        'ResearchResource'
    );

    public $showImportForm = false;
    private static $menu_icon = 'mysite/images/Resources.svg';
    private static $url_segment = 'resources'; // your URL name admin/articles

    private static $menu_title = 'Research & Resources '; //Name on the CMS

    public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm($id, $fields);

        // $gridFieldName is generated from the ModelClass, eg if the Class 'Product'
        // is managed by this ModelAdmin, the GridField for it will also be named 'Product'

        $gridFieldName = $this->sanitiseClassName($this->modelClass);
        
        $gridField = $form->Fields()->fieldByName($gridFieldName);

        // modify the list view.
        $gridField->getConfig()->addComponent(new GridFieldFilterHeader());

        $gridField->getConfig()->addComponent(new ResourcesCustomImportCTA('buttons-before-left'));

        return $form;
    }
    
    public function getList() {
        $list = parent::getList();

        // Always limit by model class, in case you're managing multiple
        if($this->modelClass == 'ResearchResource') {
            $list = $list->filter('SubmittedStudies', 'Accepted');
        }

        return $list;
    }



    public function importCustom() {
        return array('EditForm' => $this->ResourcesCustomImportForm(), 'Title' => 'Import Research & Resources');
    }

    public function ResourcesCustomImportForm() {
        $literalContent = <<<X
        <h2>Import Research & Resources</h2>
        <h5>The following column names are used to import data.</h5>
        <ul>
            <li>Year</li>
            <li>Title</li>
            <li>Authors</li>
            <li>Journal</li>
            <li>Volume(issue): pages</li>
            <li>Abstract</li>
            <li>URL</li>
            <li>NEDC   Publication?</li>
            <li>Article Type 1</li>
            <li>Article Type 2</li>
            <li>Article Type 3</li>
            <li>Free</li>
            <li>PDF available?</li>
            <li>Tag 1 - Tag 10</li>
        </ul>
X;
        $literal = new LiteralField('headerNote', $literalContent);
        $file = new FileField('resourcescsvfile', 'Resources CSV file');
        $action = new FormAction('ResourcesCustomImportFormSubmit', 'Import Reseach & Resources');
        $action->addExtraClass('ss-ui-action-constructive');
        $form = new Form($this, 'ResourcesCustomImportForm', new FieldList($literal,$file), new FieldList($action), new RequiredFields('resourcescsvfile'));

        return $form;
    }

    public function ResourcesCustomImportFormSubmit($data, $form) {
        if(isset($_FILES['resourcescsvfile']['tmp_name']) && !$_FILES['resourcescsvfile']['error']) {
            $loader = new ResearchResourceCsvBulkUploader('ResearchResource');
            $results = $loader->load($_FILES['resourcescsvfile']['tmp_name']);
            $messages = array();
            if($results->CreatedCount()) $messages[] = sprintf('Imported %d items', $results->CreatedCount());
            if($results->UpdatedCount()) $messages[] = sprintf('Updated %d items', $results->UpdatedCount());
            if($results->DeletedCount()) $messages[] = sprintf('Deleted %d items', $results->DeletedCount());
            if(!$messages) $messages[] = 'No changes';
            $form->sessionMessage(implode(', ', $messages), 'good');
        }

        return $this->redirectBack();
    }
}
