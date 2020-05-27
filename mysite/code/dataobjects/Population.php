<?php 

class Population extends DataObject 
{

    private static $db = array (
        'Title' => 'VARCHAR(55)',
    );

    // Add the page name you want to relate to
    private static $belongs_many_many = array (
        'PopulationsFor' => 'SupportOrganization'
    );
    
    public function getCMSFields_forPopUp()
    {
    	$fields = new FieldSet();
    	$fields->push( new TextField('Title'));
    	return $fields;
    }
}