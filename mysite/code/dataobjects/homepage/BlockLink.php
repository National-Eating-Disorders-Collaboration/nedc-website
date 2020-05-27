<?php

class BlockLink extends DataObject {

    private static $db = array(
        'SortOrder' => 'Int'
    );

    private static $has_one = array(
        'Link'     => 'Link',
        'Blocks'    => 'Block'
    );
    public static $default_sort = 'SortOrder';

    private static $summary_fields = array(
        'Link.Title' => 'Title'
    );

    public function getCMSFields() {

        $f = parent::getCMSFields();
        $f->removeByName('SortOrder');
        $f->addFieldToTab('Root.Main', LinkField::create('LinkID', 'Link'));
        return $f;
    }
}