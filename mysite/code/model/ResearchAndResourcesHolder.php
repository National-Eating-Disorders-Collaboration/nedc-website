<?php

class ResearchAndResourcesHolder extends Page {
    private static $can_create = false;
    private static $create_default_pages = false;
    private static $allowed_children = array('StandardPage');
    private static $db = array(
        'SearchInstruction' => 'HTMLText',
        'Button1'       => 'Varchar',
        'Button2'       => 'Varchar',
        'Button3'       => 'Varchar',
        'Button4'       => 'Varchar',
    );
    
    private static $has_one = array(
        'BecomeMember'  => 'BecomeMember'
    );

    public function getCMSFields() {
        $f = parent::getCMSFields();
        $button1 = TextField::create('Button1', 'Button1');
        $button2 = TextField::create('Button2', 'Button2');
        $button3 = TextField::create('Button3', 'Button3');
        $button4 = TextField::create('Button4', 'Button4');
        
        $text = TextField::create('BecomeMember-_1_-Title', 'Title');
        $desc = TextAreaField::create('BecomeMember-_1_-Description', 'Description');
        $link = LinkField::create('BecomeMember-_1_-LinkID', 'Link');
        $button = LinkField::create('BecomeMember-_1_-ButtonID', 'Button');
        // Image doesn't work on this module// sucks 
        $f->addFieldsToTab('Root.SubmitStudiesBox', array($text, $desc, $link, $button));
        $f->addFieldsToTab('Root.Main', array($button1, $button2, $button3, $button4), 'Content');

        $f->addFieldToTab('Root.Main', HTMLEditorField::create('SearchInstruction'));
        return $f;
    }
}
