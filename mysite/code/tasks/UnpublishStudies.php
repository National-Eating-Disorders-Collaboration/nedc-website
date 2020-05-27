<?php

class UnpublishStudies extends CronTask {

    protected $title = 'Unpublish Studies';

    protected $description = 'Unpublish studies when the project date ended.';

    protected $enabled = true;

    function process() {
        $date = date('Y-m-d', strtotime('-2 days'));
        
		$studies = DataObject::get('ResearchResource')->filterAny(array(
            'ProjectEndDate:LessThan' => $date,
        ));        
      
		foreach ($studies as $rec) {
			$rec->SubmittedStudies = 'Pending';
			$unpublished = $rec->write();
        }
        if( $unpublished) {
            echo "Unpublished!";
        }
    }
}
