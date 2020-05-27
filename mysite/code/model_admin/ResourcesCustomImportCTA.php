<?php

class ResourcesCustomImportCTA implements GridField_HTMLProvider, GridField_ActionProvider {
	public function __construct($targetFragment = "after") {
		$this->targetFragment = $targetFragment;		
	}

	public function getHTMLFragments($gridField) {
		$button = new GridField_FormAction(
			$gridField,
			'importCustom',
			'Import research & resources',
			'importCustom',
			null
		);
		$button->setAttribute('data-icon', 'drive-upload');
		$button->addExtraClass('no-ajax action_import_custom');
		$button->setForm($gridField->getForm());
		return array(
			$this->targetFragment => '<p class="grid-csv-button">' . $button->Field() . '</p>',
		);
	}

	public function getActions($gridField) {
		return array('importCustom');
	}

	public function handleAction(GridField $gridField, $actionName, $arguments, $data) {		
		if($actionName == 'importcustom') {
			$this->importCustom($gridField);
		}
	}	

    public function importCustom($gridField, $request = null) {        
        $gridField->getForm()->getController()->redirect('/admin/resources/ResearchResource/importCustom');
    }
}