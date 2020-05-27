<?php

class KeywordVariant extends DataObject {
	private static $db = array(
       'Keyword1' => 'Varchar',
       'Keyword2' => 'Varchar',
       'Keyword3' => 'Varchar',
       'Keyword4' => 'Varchar',
       'Keyword5' => 'Varchar',
   	);

    private static $create_table_options = array(
        'MySQLDatabase' => 'ENGINE=MyISAM'
    );

    private static $summary_fields = array(
       'Keyword1' => 'Main Keyword',
       'Keyword2' => 'Variant #1',
       'Keyword3' => 'Variant #2',
       'Keyword4' => 'Variant #3',
       'Keyword5' => 'Variant #4',
	);

    private static $indexes = array(
      'SearchFields' => array(
          'type' => 'index',
          'name' => 'SearchFields',
          'value' => '"Keyword1", "Keyword2", "Keyword3", "Keyword4", "Keyword5"'
      )
    );
}
