<?php

class ResearchResourceCsvBulkUploader extends CsvBulkLoader {
   public $columnMap = array(
      // 'File Name' => '', 
      // 'Upload #' => '', 
      // 'Upload Date' => '', 
      'Year' 				=> 'Year',
      'Title' 				=> 'Title',
      'Authors' 			=> 'Author', 
      'Journal' 			=> 'Journal',
      'Volume(issue): pages'=> 'Volume', 
      'Abstract'			=> 'Description', 
      'URL' 				=> 'ExternalLink', 
      'NEDC   Publication?' => 'isNEDC', 
      'Article Type 1' 		=> '->getArticleTypeByName', 
      'Article Type 2' 		=> '->getArticleTypeByName', 
      'Article Type 3' 		=> '->getArticleTypeByName',
      'OA  (open access articles -free to share whole pdf)' 				=> 'Free', 
      'PDF available?' 		=> 'PDFAvailable', 
      'Tag 1' => '->addToTags',
      'Tag 2' => '->addToTags',
      'Tag 3' => '->addToTags',
      'Tag 4' => '->addToTags',
      'Tag 5' => '->addToTags',
      'Tag 6' => '->addToTags',
      'Tag 7' => '->addToTags',
      'Tag 8' => '->addToTags',
      'Tag 9' => '->addToTags',
      'Tag 10' => '->addToTags',      
   );	

   public $duplicateChecks = array(
      'Title' => 'Title'
   );      

   public static function getArticleTypeByName(&$obj, $val, $record) {
      if($val) {
	      $articleType = DataObject::get('ResourceArticleType')->filter('Name', $val)->first();

	      if(!$articleType) {
	      	$articleType = new ResourceArticleType();
	      	$articleType->Name = $val;
	      	$articleType->write();
	      }

	      $obj->ArticleTypes()->add($articleType);
      }
   }    

   public static function addToTags(&$obj, $val, $record) {
      if($val) {
         $obj->Tags = $obj->Tags . "," . $val;

         // Check if tag is applicable to Audience, Disorders or Topics
         $search = array($val);
         $search += ResearchAndResourcesHolder_Controller::getKeywordVariants($val);
         
         if($disorder = DataObject::get('Disorder')->filter('Name', $search)->first()) {
            $obj->Disorders()->add($disorder);
         }

         if($topic = DataObject::get('Topic')->filter('Title', $search)->first()) {
            $obj->Topics()->add($topic);  
         }

         if($audience = DataObject::get('Audience')->filter('Name', $search)->first()) {
            $obj->Audiences()->add($audience);  
         }         
      }
   }
}