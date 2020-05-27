<?php

class UnpublishEvents extends CronTask {

    protected $title = 'Unpublish Events';

    protected $description = 'Unpublish events when it is past events.';

    protected $enabled = true;

    function process() {
        $date = date('Y-m-d', strtotime('-2 days'));
		$events = DataObject::get('Event')->filterAny("EventTimeDate.Date:LessThan", $date);

		foreach ($events as $rec) {
			$rec->Status = 'Unpublished';
			$rec->write();
		}

		echo "Unpublished!";
    }
}
