<?php

class NEDCExtraSettingsSiteConfig extends DataExtension {

  private static $db = array(
    'UrgentSupportCTA' => 'HTMLText',
    'SiteFooterText' => 'HTMLText',
    'Help'        => 'HTMLText',
    'FacebookURL' => 'Varchar(255)',
    'TwitterURL' => 'Varchar(255)',
    'InstagramURL' => 'Varchar(255)',
    'LinkedInURL' => 'Varchar(255)',
    'AdminEmail'  => 'Varchar(255)',

    // Survey
    'DisableSurvey' => 'Boolean',
    'SurveyHeader'  => 'Varchar',
    'SurveyText'    => 'Text',
  );

  private static $has_one = array(
    'SurveyLink' => 'Link'
  );
  private static $has_many = array(
    'Footers' => 'FooterParent'
  );

  public function updateCMSFields(FieldList $fields) {

    $fields->insertAfter(new HTMLEditorField('UrgentSupportCTA', 'Urgent Support CTA Block'), 'Theme');
    $fields->insertBefore(new EmailField('AdminEmail', 'Admin Email'), 'UrgentSupportCTA');
    $fields->insertAfter(new HTMLEditorField('Help', 'Dashboard Help'), 'UrgentSupportCTA');
    $fields->insertAfter(new HTMLEditorField('SiteFooterText', 'Footer Text'), 'Help');
    $fields->insertAfter(new TextField('FacebookURL', 'Facebook URL'), 'SiteFooterText');
    $fields->insertAfter(new TextField('TwitterURL', 'Twitter URL'), 'FacebookURL');
    $fields->insertAfter(new TextField('InstagramURL', 'Instagram URL'), 'TwitterURL');
    $fields->insertAfter(new TextField('LinkedInURL', 'LinkedIn URL'), 'InstagramURL');

    $fields->addFieldToTab('Root.Survey', CheckboxField::create('DisableSurvey', 'Disable Survey?'));
    $fields->addFieldToTab('Root.Survey', TextField::create('SurveyHeader', 'Header'));
    $fields->addFieldToTab('Root.Survey', TextareaField::create('SurveyText', 'Content'));
    $fields->addFieldToTab('Root.Survey', LinkField::create('SurveyLinkID', 'Link'));

    $config = GridFieldConfig_RecordEditor::create();
    $config->addComponent(new GridFieldSortableRows('SortOrder'));
    $fields->addFieldToTab('Root.Footer', GridField::create(
      'Links',
      'Links',
      $this->owner->Footers(),
      $config
    ));
  }


  // public static function get_template_global_variables() {
  //   return array('UrgentSupportCTA' => 'UrgentSupportCTA');
  // }
}
