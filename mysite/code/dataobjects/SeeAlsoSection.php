<?php

class SeeAlsoSection extends DataObject {

    private static $db = array(
        'SortOrder' => 'Int',
        'Teaser'   => 'Varchar(255)'
    );

    private static $has_one = array(
        'Link' => 'Link',
        'Standard' => 'StandardPage',
        'Sub'   => 'SubStandardPage',
        'PD'    => 'ProfessionalDevelopmentPage'
    );

    private static $summary_fields = array(
        'Link.Title'    => 'Title',
        'Teaser.LimitWordCount(10)'        => 'Teaser'
    );

    public static $default_sort = 'SortOrder';

    public function getCMSFields() {
        $f = parent::getCMSFields();
        $f->removeByName('SortOrder');
        $f->removeByName('SubID');
        $f->removeByName('StandardID');
        $f->removeByName('PDID');
        $f->addFieldToTab('Root.Main', LinkField::create('LinkID', 'Page or Link'));
        $f->addFieldToTab('Root.Main', $t = TextareaField::create('Teaser', 'Teaser' ));
        $t->setDescription('If left blank, this will auto-generate the content from selected page. Max words - 20');
        return $f;
    }

    public function getContent() {
        $link =  DataObject::get_one('Link', "ID = $this->LinkID");
        $content = DataObject::get_one('SiteTree', "ID =  $link->SiteTreeID");
        return strip_tags($content->Content);
    }

    public function onBeforeWrite() {
        if (empty($this->Teaser) ) { //|| $this->owner->isChanged('Teaser', 2
            $this->Teaser = $this->getContent();
        }
        parent::onBeforeWrite();
    }
}